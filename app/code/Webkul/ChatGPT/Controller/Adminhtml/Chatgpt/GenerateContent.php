<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_ChatGPT
 * @author    Webkul Software Private Limited
 * @copyright Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\ChatGPT\Controller\Adminhtml\Chatgpt;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Webkul\ChatGPT\Helper\Data;
use Webkul\ChatGPT\Helper\ChatGPT4;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\InputException;

class GenerateContent extends Action
{
    /**
     * @var $resultPageFactory
     */
    protected $resultPageFactory;
 /**
  * @var Data
  */
    protected $helper;
    /**
     * @var \Magento\Framework\Json\Helper\Data
     */
    protected $jsonHelper;
     /**
      * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
      */
    protected $date;
     /**
      * @var \Magento\Catalog\Model\ProductFactory
      */
    protected $productFactory;
    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Cms\Model\ResourceModel\PageFactory
     */
    protected $cmsPageFactory;

    /**
     * @var $chatGPTModel
     */
    protected $chatGPTModel;

    /**
     * @var ChatGPT4 $gpt4Helper
     */
    protected $gpt4Helper;

    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param Data $helper
     * @param \Magento\Cms\Model\PageFactory $cmsPageFactory
     * @param ChatGPT4 $gpt4Helper
     */

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Webkul\ChatGPT\Helper\Data $helper,
        \Magento\Cms\Model\PageFactory $cmsPageFactory,
        ChatGPT4 $gpt4Helper
    ) {
        $this->helper = $helper;
        $this->jsonHelper = $jsonHelper;
        $this->date = $date;
        $this->productFactory = $productFactory;
        $this->resultPageFactory = $pageFactory;
        $this->_storeManager = $storeManager;
        $this->cmsPageFactory = $cmsPageFactory;
        $this->chatGPTModel = $this->helper->getChatGPTConfigByGroupAndField('general_settings', 'gpt_model');
        $this->gpt4Helper = $gpt4Helper;
        parent::__construct($context);
    }

    /**
     * Execute
     */
    public function execute()
    {
        try {
            $config = $this->helper->getModuleConfig();
            $prodId = $this->getRequest()->getParam('productId');
            $storeId = $this->getRequest()->getParam('storeId');
            $promptTarget = $this->getRequest()->getParam('promptTarget');
            $isPromptTemplatingEnabled = $this->helper->getIsPromptTemplatingEnabled($storeId);
            switch ($promptTarget) {
                case 'product':
                    list($response, $client) = $this->runProductProfiler(
                        $config,
                        $prodId,
                        $storeId,
                        $promptTarget,
                        $isPromptTemplatingEnabled
                    );
                    break;
                case 'page':
                    list($response, $client) =  $this->runPageProfiler(
                        $config,
                        $prodId,
                        $storeId,
                        $promptTarget,
                        $isPromptTemplatingEnabled
                    );
                    break;
            }

            $this->getResponse()->setHeader('Content-type', 'application/json');
            $this->getResponse()->setBody($this->jsonHelper
                ->jsonEncode($response));
        } catch (\Exception $err) {
            $this->handleException($err, $client);
        }
    }

    /**
     * Import Content for Products
     *
     * @param array $config
     * @param int $prodId
     * @param int $storeId
     * @param string $promptTarget
     * @param boolean $isPromptTemplatingEnabled
     */
    public function runProductProfiler($config, $prodId, $storeId, $promptTarget, $isPromptTemplatingEnabled)
    {
        try {
            $originalStoreId = $this->_storeManager->getStore()->getId();
            $this->_storeManager->setCurrentStore($storeId);
            $currentProduct = $this->productFactory->create()->load($prodId);
            $currentLocale = $this->helper->getCurrentStoreLocale($storeId);
            $allowedTags = '<div><a><p><span><em><strong><ul><li><ol><h5><h4><h3><h2><h1><table>
        <tbody><tr><td<th><tfoot><img><hr><figure><button><i><u><br><b><iframe><style><pre>';
            $isSEOEnabled = $this->helper->isSEOEnabled($storeId);
            if (!isset($config['attributes'])) {
                $config['attributes'] = 'Name';
            }
            $attr = 'get'.$config['attributes'];
            $prompt = '';
            $client = $this->helper->getClient();
            $product = $currentProduct->$attr();
            if ($isPromptTemplatingEnabled) {
                $prompt = $this->helper->getChatGPTProductPrompt($storeId) ?? null;
                if ($prompt != null && $prompt != '') {
                    $prompt = \str_replace('{{importContentFor}}', $product, $prompt??'');
                }
            }
            if ($this->chatGPTModel === Data::CHAT_GPT3_MODEL) {
                $long = [
                "model"=> Data::CHAT_GPT3_MODEL,
                "prompt"=> $prompt != '' ?
                    $prompt." in HTML" :
                    "product specifications and description for ".$product." in html in ".$currentLocale,
                "temperature"=> 1,
                "max_tokens"=> 3725
                ];
                $this->helper->getChatGPTLogger()->info('run profiler first prompt : ',[$long]);
                $client->post(Data::CHAT_GPT3_END_POINT, $this->helper->getJsonEncode($long));
                $desc = $this->helper->getJsonDecode($client->getBody(), true)['choices'][0]['text'];
            } elseif ($this->chatGPTModel === ChatGPT4::CHAT_GPT4_MODEL) {
                list($client, $desc) = $this->gpt4Helper->getResponse(
                    'mass',
                    $client,
                    $prompt != '' ?
                    $prompt." in HTML" :
                    "product specifications and description for ".$product." in html in ".$currentLocale
                );
            }
            if ($this->chatGPTModel === Data::CHAT_GPT3_MODEL) {
                $short = [
                "model"=> Data::CHAT_GPT3_MODEL,
                "prompt"=> $prompt != '' ? $prompt." in HTML" : "about ".$product." in html in ".$currentLocale,
                "temperature"=> 1,
                "max_tokens"=> 3725
                ];
                $this->helper->getChatGPTLogger()->info(' run profiler second prompt',[$short]);
                $client->post(Data::CHAT_GPT3_END_POINT, $this->helper->getJsonEncode($short));
                $short_desc = $this->helper->getJsonDecode($client->getBody(), true)['choices'][0]['text'];
            } elseif ($this->chatGPTModel === ChatGPT4::CHAT_GPT4_MODEL) {
                list($client, $short_desc) = $this->gpt4Helper->getResponse(
                    'mass',
                    $client,
                    $prompt != '' ? $prompt." in HTML" : "about ".$product." in html in ".$currentLocale
                );
            }
            $short_desc = strip_tags($short_desc, $allowedTags);
            $desc = strip_tags($desc, $allowedTags);
            $pattern = '/\sdir="[^"]*"/i';
            $desc = preg_replace($pattern, '', $desc);
            $short_desc = preg_replace($pattern, '', $short_desc);
            $pattern = '/\slang="[^"]*"/i';
            $desc = preg_replace($pattern, '', $desc);
            $short_desc = preg_replace($pattern, '', $short_desc);
            if ($isSEOEnabled) {
                $seoAttributes = $this->helper->getSelectedSEOAttributes('Product_', 0, $storeId);
                foreach ($seoAttributes as $key => $value) {
                    $seoPrompt = $value." for ".$product." in ".$currentLocale." for e-commerce store";
                    $seoContent = $this->getSEOContent($client, $seoPrompt);
                    $seoAttr = 'set'.$value;
                    $currentProduct->$seoAttr($seoContent);
                }
            }
            $currentProduct->setShortDescription($desc);
            $currentProduct->setDescription($short_desc);
            $currentProduct->setContentUpdatedAt($this->date->date()->format('Y-m-d H:i:s'));
            $currentProduct->save();
            $this->_storeManager->setCurrentStore($originalStoreId);
            $response = ['status'=>'success'];
            return [$response, $client];
        } catch (\Exception $th) {
            return $this->handleException($th, $client);
        }
    }

    /**
     * Import Content for CMS Pages
     *
     * @param array $config
     * @param int $prodId
     * @param int $storeId
     * @param string $promptTarget
     * @param boolean $isPromptTemplatingEnabled
     */
    public function runPageProfiler($config, $prodId, $storeId, $promptTarget, $isPromptTemplatingEnabled)
    {
        try {
            $currentPage = $this->cmsPageFactory->create()->load($prodId);
            $currentLocale = $this->helper->getCurrentStoreLocale();
            $params = $this->getRequest()->getParams();
            $client = $this->helper->getClient();
            $page = $currentPage->getTitle();
            $allowedTags = '<div><a><p><span><em><strong><ul><li><ol><h5><h4><h3><h2><h1><table>
            <tbody><tr><td<th><tfoot><img><hr><figure><button><i><u><br><b><iframe><style><pre>';
            if (!$storeId) {
                $isPromptTemplatingEnabled = $this->helper->getIsPromptTemplatingEnabled();
                $storeId = $currentPage->getStoreId()[0];
            }
            $config = $this->helper->getModuleConfig($storeId);
            if (isset($config['active']) && !$config['active']) {
                return [
                    [
                        'error' => true,
                        'msg' => __('Unable to Import AI Content for (%1) as the module is disabled for the store view 
                                [%2] associated with this page.', $page, $storeId),
                        'skip' => true,
                    ],
                    $client
                ];
            }

            $cmsPageDescPrompt = '';
            if ($isPromptTemplatingEnabled) {
                $cmsPageDescPrompt = $this->helper->getChatGPTCMSPagePrompt() ?? null;
                if ($cmsPageDescPrompt != null && $cmsPageDescPrompt != '') {
                    $cmsPageDescPrompt = \str_replace('{{importContentFor}}', $page, $cmsPageDescPrompt??'');
                }
            }
            if (isset($params['contentType']) && $params['contentType']) {
                switch ($params['contentType']) {
                    case 'seo_content':
                        $seoAttributes = $this->helper->getSelectedSEOAttributes('CMSPage_', 2, $storeId);
                        foreach ($seoAttributes as $key => $value) {
                            $seoPrompt = $value." for ".$page." page in ".$currentLocale." for e-commerce store";
                            $seoContent = $this->getSEOContent($client, $seoPrompt);
                            $value = ($value === 'MetaKeyword') ? 'MetaKeywords' : $value;
                            $seoAttr = 'set'.$value;
                            $currentPage->$seoAttr($seoContent);
                        }
                        $this->saveCurrentPage($currentPage);
                        break;
                    case 'page_content':
                        $pageContent = $this->getPageContent($client, $cmsPageDescPrompt, $page, $currentLocale);
                        $pageContent = strip_tags($pageContent, $allowedTags);
                        $currentPage->setContent($pageContent);
                        $this->saveCurrentPage($currentPage);
                        break;
                    default:
                        $response = ['error'=>1, 'msg'=> __('Something went wrong in chatGPT')];
                        break;
                }
            }
            $response = ['status'=>'success'];
            return [$response, $client];
        } catch (\Exception $th) {
            return $this->handleException($th, $client);
        }
    }
    /**
     * Get SEO Content
     *
     * @param mixed $client
     * @param string $seoPrompt
     */
    private function getSEOContent($client, $seoPrompt)
    {
        if ($this->chatGPTModel === Data::CHAT_GPT3_MODEL) {
            $seo = [
                "model" => Data::CHAT_GPT3_MODEL,
                "prompt" => $seoPrompt,
                "temperature" => 1,
                "max_tokens" => 3725
            ];
            $this->helper->getChatGPTLogger()->info('get SEO Content prompt : ',[$seo]);
            $client->post(
                Data::CHAT_GPT3_END_POINT,
                $this->helper->getJsonEncode($seo)
            );
            return $this->helper->getJsonDecode($client->getBody(), true)['choices'][0]['text'];
        } elseif ($this->chatGPTModel === ChatGPT4::CHAT_GPT4_MODEL) {
            return $this->gpt4Helper->getResponse('mass', $client, $seoPrompt)[1];
        }
    }

    /**
     * Get Page Content
     *
     * @param mixed $client
     * @param string $cmsPageDescPrompt
     * @param mixed $page
     * @param string $currentLocale
     */
    private function getPageContent($client, $cmsPageDescPrompt, $page, $currentLocale)
    {
        if ($this->chatGPTModel === Data::CHAT_GPT3_MODEL) {
            $content = [
                "model" => Data::CHAT_GPT3_MODEL,
                "prompt" => $cmsPageDescPrompt != '' ?
                    $cmsPageDescPrompt . " in HTML" :
                    "Page Description for " . $page . " in " . $currentLocale . " for e-commerce store",
                "temperature" => 1,
                "max_tokens" => 3725
            ];
            $this->helper->getChatGPTLogger()->info('get page content prompt : ',[$content]);
            $client->post(
                Data::CHAT_GPT3_END_POINT,
                $this->helper->getJsonEncode($content)
            );
            return $this->helper->getJsonDecode($client->getBody(), true)['choices'][0]['text'];
        } elseif ($this->chatGPTModel === ChatGPT4::CHAT_GPT4_MODEL) {
            return $this->gpt4Helper->getResponse('mass', $client, $cmsPageDescPrompt != '' ?
                $cmsPageDescPrompt . " in HTML" :
                "Page Description for " . $page . " in " . $currentLocale . " for e-commerce store")[1];
        }
    }

    /**
     * Save Current Page
     *
     * @param mixed $currentPage
     */
    private function saveCurrentPage($currentPage)
    {
        $currentPage->setUpdateTime($this->date->date()->format('Y-m-d H:i:s'));
        $currentPage->save();
    }

    /**
     * Handle Exception
     *
     * @param mixed $exception
     * @param mixed $client
     */
    private function handleException($exception, $client)
    {
        $this->helper->getChatGPTLogger()->warning($exception->getMessage());
        $message = __("An error occurred while importing AI Content. 
            Please check your API keys and configurations, then try again.");
        $clientBody = $this->helper->getJsonDecode($client->getBody(), true);
        if (!isset($clientBody['choices']) && isset($clientBody['error'])) {
            $message = __($clientBody['error']['message']);
        }
        $response = ['error' => 1, 'msg' => $message];
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody($this->jsonHelper->jsonEncode($response));
        return [$response, $client];
    }
}
