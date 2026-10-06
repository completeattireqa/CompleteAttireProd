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
use \Magento\Framework\View\Result\PageFactory;
use Webkul\ChatGPT\Helper\Data;

class Individual extends Action
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
     * @var \Webkul\ChatGPT\Helper\ChatGPT4 $gpt4Helper
     */
    protected $gpt4Helper;
    /**
     * @var $chatGPTModel
     */
    protected $chatGPTModel;

    /**
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param \Magento\Catalog\Model\ProductFactory $productFactory
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper
     * @param Data $helper
     * @param \Webkul\ChatGPT\Helper\ChatGPT4 $gpt4Helper
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        Data $helper,
        \Webkul\ChatGPT\Helper\ChatGPT4 $gpt4Helper
    ) {
        $this->helper = $helper;
        $this->jsonHelper = $jsonHelper;
        $this->date = $date;
        $this->productFactory = $productFactory;
        $this->resultPageFactory = $pageFactory;
        $this->gpt4Helper = $gpt4Helper;
        $this->chatGPTModel = $this->helper->getChatGPTConfigByGroupAndField('general_settings', 'gpt_model');
        parent::__construct($context);
    }

    /**
     * Execute
     */
    public function execute()
    {
        $importContentFor = $this->getRequest()->getParam('name');
        $promptTarget = $this->getRequest()->getParam('promptTarget');
        $type = $this->getRequest()->getParam('type');
        $client = $this->helper->getClient();
        $prompt = '';
        $currentLocale = $this->getRequest()->getParam('storeLocale');
        $storeId = $this->getRequest()->getParam('storeId');
        $allowedTags = '<div><a><p><span><em><strong><ul><li><ol><h5><h4><h3><h2><h1><table><tbody><tr>
        <td<th><tfoot><img><hr><figure><button><i><u><br><b><iframe><style><pre>';
        $isPromptTemplatingEnabled = $this->helper->getIsPromptTemplatingEnabled();
        switch ($promptTarget) {
            case 'product':
                $prompt = $this->getPrompt(
                    $isPromptTemplatingEnabled,
                    $this->helper->getChatGPTProductPrompt(),
                    $importContentFor
                );
                $defaultPrompt = $type == 'long' ?
                    "product specifications and description for ".$importContentFor." in html in ".$currentLocale :
                    "about ".$importContentFor." in html in ".$currentLocale;
                    $prompt = $prompt != '' ? $prompt.' in HTML' : $defaultPrompt;
                    break;
                    case 'category':
                        switch ($type) {
                            case 'desc':
                                case 'short':
                                    $prompt = $this->getPrompt(
                                        $isPromptTemplatingEnabled,
                                        $this->helper->getChatGPTCategoryPrompt(),
                                        $importContentFor
                                    );
                                    $prompt = $prompt != '' ?
                                    $prompt . " in HTML" :
                            "category description for " . $importContentFor . " in html in " . $currentLocale;
                        break;
                    case 'seo':
                        $response = $this->importCategorySeo($importContentFor, $currentLocale);
                        $this->setJsonResponse($response);
                        return;
                        default:
                        $this->setJsonResponse(['error' => true, 'msg' => __('Something went wrong in chatGPT.')]);
                        return;
                    }
                    break;
                    case 'page':
                        case 'cms_page':
                            $config = $this->helper->getModuleConfig($storeId);
                            if (isset($config['active']) && !$config['active']) {
                                $this->setJsonResponse(
                                    ['error' =>
                                    ['message' => __('Unable to Import AI Content for (%1) as the module is disabled for the store
                                    view [%2] associated with this page.', $importContentFor, $storeId)
                                    ]
                                    ]
                                );
                                return;
                            }
                            $prompt = $this->getPrompt(
                                $isPromptTemplatingEnabled,
                                $this->helper->getChatGPTCMSPagePrompt(),
                                $importContentFor
                            );
                            $prompt = $prompt != '' ?
                            $prompt . " in HTML" :
                            "Page Content for " . $importContentFor . " in html in " . $currentLocale;
                            break;
                            default:
                            $this->setJsonResponse(['error' => __('Something went wrong in chatGPT.')]);
                            return;
                        }
                        
                        try {
                            if ($this->chatGPTModel === Data::CHAT_GPT3_MODEL) {
                                $params = [
                                    "model" => Data::CHAT_GPT3_MODEL,
                                    "prompt" => $prompt,
                                    "temperature" => 1,
                                    "max_tokens" => 3725
                                ];
                                $client->post(Data::CHAT_GPT3_END_POINT, $this->helper->getJsonEncode($params));                               
                                $desc = $this->helper->getJsonDecode($client->getBody(), true)['choices'][0]['text'] ?? '';
                            } elseif ($this->chatGPTModel === \Webkul\ChatGPT\Helper\ChatGPT4::CHAT_GPT4_MODEL) {
                                list($client, $desc) = $this->gpt4Helper->getResponse('individual', $client, $prompt);
                                $error = $this->checkError($client, $desc);
                                if (count($error)) {
                                    return $this->setJsonResponse($error);
                                }
                            }
                            
                            $desc = strip_tags($desc, $allowedTags);
            $desc = $this->removeAttribute($desc, '/\sdir="[^"]*"/i');

            if (!$desc || $desc == '') {
                $response = $this->helper->getJsonDecode($client->getBody());
            } else {
                $response = ['status' => 'success', 'result' => $desc];
            }
        } catch (\Exception $th) {
            $response = ['error' => $th->getMessage()];
        }

        $this->setJsonResponse($response);
    }
    /**
     * Get Prompt
     *
     * @param boolean $isPromptTemplatingEnabled
     * @param string $promptValue
     * @param string $importContentFor
     */
    private function getPrompt($isPromptTemplatingEnabled, $promptValue, $importContentFor)
    {
        $prompt = '';

        if ($isPromptTemplatingEnabled && $promptValue !== null && $promptValue !== '') {
            $prompt = \str_replace('{{importContentFor}}', $importContentFor, $promptValue ?? '');
        }

        return $prompt;
    }
    /**
     * Remove Attribute
     *
     * @param string $desc
     * @param mixed $pattern
     */
    private function removeAttribute($desc, $pattern)
    {
        return preg_replace($pattern, '', $desc);
    }
    /**
     * Set JSON Response
     *
     * @param mixed $response
     */
    private function setJsonResponse($response)
    {
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody($this->jsonHelper->jsonEncode($response));
    }

    /**
     * Import Content For Category SEO Attributes
     *
     * @param string $importContentFor
     * @param string $currentLocale
     */
    public function importCategorySeo($importContentFor, $currentLocale)
    {
        try {
            $response = [];
            $storeId = $this->getRequest()->getParam('storeId');
            $seoAttributes = $this->helper->getSelectedSEOAttributes('Category_', 1, $storeId);
            $client = $this->helper->getClient();
            foreach ($seoAttributes as $key => $value) {
                $prompt = $value." for ".$importContentFor." category in ".$currentLocale."
                for e-commerce store";
                if ($this->chatGPTModel === Data::CHAT_GPT3_MODEL) {
                    $seo = [
                            "model"=> Data::CHAT_GPT3_MODEL,
                        "prompt"=> $prompt,
                        "temperature"=> 1,
                        "max_tokens"=> 4000
                        ];
                    $client->post(Data::CHAT_GPT3_END_POINT, $this->helper->getJsonEncode($seo));
                    $seoContent = $this->helper->getJsonDecode($client->getBody(), true)['choices'][0]['text']??'';
                } elseif ($this->chatGPTModel === \Webkul\ChatGPT\Helper\ChatGPT4::CHAT_GPT4_MODEL) {
                    list($client, $seoContent) = $this->gpt4Helper->getResponse('individual', $client, $prompt);
                    $error = $this->checkError($client, $seoContent);
                    if (count($error)) {
                        return $seoContent;
                    }
                }
                if (!$seoContent || $seoContent=='') {
                    $response = $this->helper->getJsonDecode($client->getBody(), true);
                } else {
                    $response['result'][$value] = $seoContent;
                }
            }
            if (!count($response)) {
                $response['result'] = [];
            }
        } catch (\Exception $err) {
            $response = ['error' => $err->getMessage()];
        }
        return $response;
    }
    /**
     * Check GPT-4 errors
     *
     * @param mixed $client
     * @param array $res
     */
    private function checkError($client, $res)
    {
        if (isset($res['error'])) {
            return $res;
        }
        return [];
    }
}
