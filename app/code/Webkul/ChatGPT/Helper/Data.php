<?php

namespace Webkul\ChatGPT\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Locale\Resolver;

class Data extends AbstractHelper
{
    const XML_PATH_ENABLED = 'chatgpt/general/enabled';
    const XML_SEO_PATH_ENABLED = 'chatgpt/general_settings/seo_enabled';
    const XML_SEO_ATTRIBUTES = 'chatgpt/general_settings/seo_attributes';
    const CHAT_GPT3_MODEL = 'text-davinci-003';
    const CHAT_GPT3_END_POINT = 'https://api.openai.com/v1/completions';

    /**
     * @var \Magento\Framework\HTTP\Client\Curl
     */
    protected $curl;
    /**
     * @var \Webkul\ChatGPT\Helper\ConfigHelper
     */
    protected $moduleConfig;
    /**
     * @var \Magento\Framework\Encryption\EncryptorInterface
     */
    protected $enc;
    /**
     * @var \Webkul\ChatGPT\Logger\Logger
     */
    protected $_logger;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;
    /**
     * @var \Magento\Framework\App\Response\RedirectInterface $redirect
     */
    protected $redirect;
    /**
     * @var \Webkul\ChatGPT\Model\PromptTemplatesFactory $promptTemplates
     */
    protected $promptTemplates;
     /**
      * @var \Magento\Framework\Serialize\Serializer\Json
      */
      protected $_json;

    /**
     * Constructor
     *
     * @param \Magento\Framework\HTTP\Client\Curl $curl
     * @param \Webkul\ChatGPT\Helper\ConfigHelper $moduleConfig
     * @param \Magento\Framework\Encryption\EncryptorInterface $enc
     * @param \Webkul\ChatGPT\Logger\Logger $chatGPtlogger
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\App\Response\RedirectInterface $redirect
     * @param \Webkul\ChatGPT\Model\PromptTemplatesFactory $promptTemplates
     * @param \Magento\Framework\Serialize\Serializer\Json $json
     */
    public function __construct(
        \Magento\Framework\HTTP\Client\Curl $curl,
        \Webkul\ChatGPT\Helper\ConfigHelper $moduleConfig,
        \Magento\Framework\Encryption\EncryptorInterface $enc,
        \Webkul\ChatGPT\Logger\Logger $chatGPtlogger,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\Response\RedirectInterface $redirect,
        \Webkul\ChatGPT\Model\PromptTemplatesFactory $promptTemplates,
        \Magento\Framework\Serialize\Serializer\Json $json
    ) {
        $this->curl = $curl;
        $this->moduleConfig = $moduleConfig;
        $this->enc = $enc;
        $this->_logger = $chatGPtlogger;
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
        $this->redirect = $redirect;
        $this->promptTemplates = $promptTemplates;
        $this->_json = $json;
    }

    /**
     * Get Is Module Enabled
     *
     * @param object $store
     * @return boolean
     */
    public function isEnabled($store = null)
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }
    /**
     * Get Is SEO Import Content Enabled
     *
     * @param object $store
     * @return boolean
     */
    public function isSEOEnabled($store = null)
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_SEO_PATH_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }
    /**
     * Get Is SEO Import Content Enabled
     *
     * @param object $store
     * @return boolean
     */
    public function getSEOAttributes($store = null)
    {
        return explode(',', $this->scopeConfig->getValue(
            self::XML_SEO_ATTRIBUTES,
            ScopeInterface::SCOPE_STORE,
            $store??''
        ));
    }
    /**
     * Get Is SEO Import Content Enabled
     *
     * @param object $store
     * @return boolean
     */
    public function getIsChatGPTEnable($store = null)
    {
        return $this->scopeConfig->getValue(
            'chatgpt/general_settings/active',
            ScopeInterface::SCOPE_STORE,
            $store??''
        );
    }
    /**
     * Get Client
     */
    public function getClient()
    {
        $config =   $this->moduleConfig->getStoreConfigBySection('chatgpt');
        $auth = $this->enc->decrypt($config['secret']);
        $headers = [
            "Content-Type" => "application/json", "Accept" => "application/json", "Authorization" => 'Bearer ' . $auth];
        $this->curl->setHeaders($headers);
        return $this->curl;
    }
    /**
     * Get Module Config
     *
     * @param int $storeId
     */
    public function getModuleConfig($storeId = null)
    {
        $config =  $this->moduleConfig->getStoreConfigBySection('chatgpt', $storeId);
        return $config;
    }
    /**
     * Update Content
     *
     * @param mixed $currentProduct
     */
    public function updateContent($currentProduct)
    {
        $config = $this->getModuleConfig();
        $client = $this->getClient();
        switch ($config['attributes']) {
            case 'name':
                $product = $currentProduct->getName();

                break;

            case 'sku':
                $product = $currentProduct->getSku();

                break;
            
            default:
                $product = $currentProduct->getName();
                break;
        }
        $params = [
            "model"=> self::CHAT_GPT3_MODEL,
        "prompt"=> "product specifications and description for ".$product." in html in ".$this->getCurrentStoreLocale(),
        "temperature"=> 1,
        "max_tokens"=> 4000
        ];
        $client->post(self::CHAT_GPT3_END_POINT, $this->getJsonEncode($params));
        $desc = $this->getJsonDecode($client->getBody(), true)['choices'][0]['text'];
        try {
            $currentProduct->setShortDescription($desc);
            $currentProduct->setContentUpdatedAt($this->date->date()->format('Y-m-d H:i:s'));
            if ($config['images']) {

                $this->getGoogleImages($currentProduct);
            }
            $currentProduct->save();
            $response = ['status'=>'success'];
            return $response;
        } catch (\Exception $th) {
            return ['error'=>$th->getMessage()];
        }
    }
    /**
     * Get Google Images
     *
     * @param mixed $product
     */
    public function getGoogleImages($product)
    {
        $name = $product->getName();
        $query = [
            "q" => "Apple Iphone 14 pro",
            "tbm" => "isch",
            "ijn" => "0",
           ];
           $search = new \GoogleSearchResults('1653334df684ea8c0e50a6022eaa76d153d270f31dbf0d65893629e02a59e0ca');
           $result = $search->get_json($query);
           $images_results = $result->images_results;
    }
    /**
     * Get ChatGPT logger
     *
     * @return object
     */
    public function getChatGPTLogger()
    {
        return $this->_logger;
    }
    /**
     * Get Current Store Locale for Multi-Lingual Content
     *
     * @param int $storeId
     * @return string
     */
    public function getCurrentStoreLocale($storeId = null)
    {
        if (!$storeId) {
            $storeId = $this->storeManager->getStore()->getId();
        }
        $currentLocaleCode = $this->scopeConfig->getValue('general/locale/code', ScopeInterface::SCOPE_STORE, $storeId);
        return $currentLocaleCode;
    }
    /**
     * Get RefererURL
     */
    public function getRefererUrl()
    {
        return $this->redirect->getRefererUrl();
    }
    /**
     * Get Client
     */
    public function getPromptTemplatesClient()
    {
        $headers = [
            "Content-Type" => "application/json", "Accept" => "application/json"];
        $this->curl->setHeaders($headers);
        return $this->curl;
    }
    /**
     * Get Is ChatGPT Prompt Template Enabled
     *
     * @param object $storeId
     * @return boolean
     */
    public function getIsPromptTemplatingEnabled($storeId = null)
    {
        return $this->scopeConfig->isSetFlag(
            'chatgpt/general_settings/enable_prompt_templates',
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
    /**
     * Get ChatGPT Product Prompt
     *
     * @param int $store
     */
    public function getChatGPTProductPrompt($store = null)
    {
        $prompt = '';
        $templateId = $this->scopeConfig->getValue(
            'chatgpt/general_settings/product_prompt_template',
            ScopeInterface::SCOPE_STORE,
            $store
        );
        $template = $this->promptTemplates->create()->getCollection()
                    ->addFieldToFilter('entity_id', $templateId)
                    ->getFirstItem();
        if ($template->getId()) {
            $prompt = $template->getPrompt();
        }
        return $prompt;
    }
    /**
     * Get ChatGPT Category Prompt
     *
     * @param int $store
     */
    public function getChatGPTCategoryPrompt($store = null)
    {
        $prompt = '';
        $templateId = $this->scopeConfig->getValue(
            'chatgpt/general_settings/category_prompt_template',
            ScopeInterface::SCOPE_STORE,
            $store
        );
        $template = $this->promptTemplates->create()->getCollection()
                    ->addFieldToFilter('entity_id', $templateId)
                    ->getFirstItem();
        if ($template->getId()) {
            $prompt = $template->getPrompt();
        }
        return $prompt;
    }
    /**
     * Get ChatGPT Category Prompt
     *
     * @param int $store
     */
    public function getChatGPTCMSPagePrompt($store = null)
    {
        $prompt = '';
        $templateId = $this->scopeConfig->getValue(
            'chatgpt/general_settings/cmspage_prompt_template',
            ScopeInterface::SCOPE_STORE,
            $store
        );
        $template = $this->promptTemplates->create()->getCollection()
                    ->addFieldToFilter('entity_id', $templateId)
                    ->getFirstItem();
        if ($template->getId()) {
            $prompt = $template->getPrompt();
        }
        return $prompt;
    }
    /**
     * Category, SubCategory Data Array
     */
    public function getSubCategories()
    {
        return [
            'copwri' => [
                'name' => 'Copywriting',
                'subcategories' => [
                    'copblo' => 'Blog Writing',
                    'copboo' => 'Book Writing',
                    'copcon' => 'Content Writing',
                    'copcou' => 'Course Writing',
                    'copema' => 'Email Writing',
                    'coplan' => 'Landing Pages'
                ]
            ],
            'market' => [
                'name' => 'Marketing',
                'subcategories' => [
                    'mktfrm' => 'Frameworks',
                    'mktmis' => 'Miscellaneous'
                ]
            ],
            'seenop' => [
                'name' => 'SEO',
                'subcategories' => [
                    'seokwr' => 'Keyword Research',
                    'seoecom' => 'Ecommerce SEO',
                    'seoloc' => 'Local SEO',
                    'seoonp' => 'On-Page Optimization'
                ]
            ],
            'socmed' => [
                'name' => 'Social Media',
                'subcategories' => [
                    'socfac' => 'Facebook',
                    'socins' => 'Instagram',
                    'soclin' => 'LinkedIn',
                    'socpin' => 'Pinterest',
                    'soctik' => 'TikTok',
                    'soctwi' => 'Twitter',
                    'socyou' => 'YouTube'
                ]
            ],
            'produc' => [
                'name' => 'Productivity',
                'subcategories' => [
                    'proexc' => 'Excel',
                    'protra' => 'Translation',
                    'proext' => 'Extraction',
                    'prosum' => 'Summarization'
                ]
            ],
            'occupa' => [
                'name' => 'Professionals',
                'subcategories' => [
                    'occacc' => 'Accountants',
                    'occent' => 'Entrepreneurs',
                    'occfin' => 'Finance',
                    'occhur' => 'Human Resources',
                    'occlaw' => 'Lawyers',
                    'occtea' => 'Teachers'
                ]
            ]
        ];
    }
    /**
     * Get Selected SEO Attributes
     *
     * @param string $target
     * @param int $parent
     * @param mixed $storeId
     */
    public function getSelectedSEOAttributes($target, $parent, $storeId = null)
    {
        $seoAttributes = [];
        $allSeoAttributes = $this->scopeConfig->getValue(
            'chatgpt/general_settings/seo_attributes',
            ScopeInterface::SCOPE_STORE,
            $storeId != "" || $storeId != null ? $storeId : 0
        );
        $allSeoAttributes = \explode(',', $allSeoAttributes??'');
        foreach ($allSeoAttributes as $key => $value) {
            if ($value == $parent) {
                $seoAttributes = ['MetaTitle', 'MetaKeyWords', 'MetaDescription'];
                break;
            } else {
                if (\str_contains($value, $target)) {
                    $seoAttributes[] = \explode('_', $value)[1];
                }
            }
        }
        if (\is_array($seoAttributes)) {
            return $seoAttributes;
        } else {
            return [];
        }
    }
    /**
     * Get Module Config
     *
     * @param string $group
     * @param string $field
     * @param int $storeId
     */
    public function getChatGPTConfigByGroupAndField($group, $field, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            'chatgpt/'.$group.'/'.$field,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
    /**
     * Get Json Encode
     *
     * @param array $data
     * @return bool|false|string
     */
    public function getJsonEncode($data)
    {
        return $this->_json->serialize($data);
    }

   /**
    * Get Json Decode
    *
    * @param array $data
    * @return array|bool|float|int|mixed|string|null
    */
    public function getJsonDecode($data)
    {
        return $this->_json->unserialize($data);
    }
}
