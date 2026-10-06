<?php

namespace Webkul\ChatGPT\Ui\Component\MassAction\ImportContent\Cms;

use Magento\Framework\Phrase;
use Magento\Framework\UrlInterface;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Api\StoreRepositoryInterface;
use Webkul\ChatGPT\Helper\Data as HelperData;

class Content implements \JsonSerializable
{
    /**
     * @var array $options
     */
    protected $options;

    /**
     * @var array $data
     */
    protected $data;

    /**
     * @var UrlInterface $urlBuilder
     */
    protected $urlBuilder;

    /**
     * @var UrlInterface $urlPath
     */
    protected $urlPath;

    /**
     * @var UrlInterface $paramName
     */
    protected $paramName;

    /**
     * @var $promptTarget
     */
    protected $promptTarget;

    /**
     * @var StoreRepositoryInterface
     */
    protected $storeRepository;
    /**
     * @var \Webkul\ChatGPT\Helper\ConfigHelper
     */
    protected $moduleConfig;
    /**
     * @var \Webkul\ChatGPT\Helper\Data
     */
    protected $helper;
    /**
     * @var array $additionalData
     */
    protected $additionalData = [];
    /**
     * Constructor
     *
     * @param UrlInterface $urlBuilder
     * @param StoreRepositoryInterface $storeRepository
     * @param \Webkul\ChatGPT\Helper\ConfigHelper $moduleConfig
     * @param \Webkul\ChatGPT\Helper\Data $helper
     * @param array $data
     */
    public function __construct(
        UrlInterface $urlBuilder,
        StoreRepositoryInterface $storeRepository,
        \Webkul\ChatGPT\Helper\ConfigHelper $moduleConfig,
        HelperData $helper,
        array $data = []
    ) {
        $this->data = $data;
        $this->urlBuilder = $urlBuilder;
        $this->moduleConfig = $moduleConfig;
        $this->helper = $helper;
        $this->storeRepository = $storeRepository;
    }
    /**
     * Json Serialize
     *
     * @return mixed
     */
    public function jsonSerialize(): mixed
    {
        $storeId = $this->moduleConfig->getStoreId();
        $isSEOEnabled = $this->helper->isSEOEnabled($storeId);
        if ($this->options === null) {
            $options[0]['value']='page_content';
            $options[0]['label']=__('Page Content');
            if ($isSEOEnabled) {
                $options[1]['value']='seo_content';
                $options[1]['label']=__('SEO Content');
            }
            $this->prepareData();
            foreach ($options as $optionCode) {
                $this->options[$optionCode['value']] = [
                    'type' => 'import_content_' . $optionCode['value'],
                    'label' => $optionCode['label'],
                    '__disableTmpl' => true
                ];
 
                if ($this->urlPath && $this->paramName && $this->promptTarget) {
                    $this->options[$optionCode['value']]['url'] = $this->urlBuilder->getUrl(
                        $this->urlPath,
                        [$this->paramName => $optionCode['value'], $this->promptTarget => 'page']
                    );
                }
 
                $this->options[$optionCode['value']] = array_merge_recursive(
                    $this->options[$optionCode['value']],
                    $this->additionalData
                );
            }
            $this->options = array_values($this->options);
        }
        return $this->options;
    }
    /**
     * Prepare Data
     *
     * @return void
     */
    protected function prepareData()
    {
        foreach ($this->data as $key => $value) {
            switch ($key) {
                case 'urlPath':
                    $this->urlPath = $value;
                    break;
                case 'paramName':
                    $this->paramName = $value;
                    break;
                case 'promptTarget':
                    $this->promptTarget = $value;
                    break;
                case 'confirm':
                    foreach ($value as $messageName => $message) {
                        $this->additionalData[$key][$messageName] = (string)new Phrase($message);
                    }
                    break;
                default:
                    $this->additionalData[$key] = $value;
                    break;
            }
        }
    }
}
