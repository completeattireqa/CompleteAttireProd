<?php

namespace Webkul\ChatGPT\Ui\Component\MassAction\ImportContent;

use Magento\Framework\Phrase;
use Magento\Framework\UrlInterface;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Api\StoreRepositoryInterface;

class Stores implements \JsonSerializable
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
     * @var array $additionalData
     */
    protected $additionalData = [];
    /**
     * Constructor
     *
     * @param UrlInterface $urlBuilder
     * @param StoreRepositoryInterface $storeRepository
     * @param \Webkul\ChatGPT\Helper\ConfigHelper $moduleConfig
     * @param array $data
     */
    public function __construct(
        UrlInterface $urlBuilder,
        StoreRepositoryInterface $storeRepository,
        \Webkul\ChatGPT\Helper\ConfigHelper $moduleConfig,
        array $data = []
    ) {
        $this->data = $data;
        $this->urlBuilder = $urlBuilder;
        $this->moduleConfig = $moduleConfig;
        $this->storeRepository = $storeRepository;
    }
    /**
     * Json Serialize
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        if ($this->options === null) {
            $options = [];
            $count = 0;
            foreach ($this->getAllStoreList() as $store) {
                if (!$store->getStoreId() == 0 && $this->isModuleEnabledForStore($store->getStoreId())['active']) {
                    $options[$count] = ['value' => $store->getStoreId(), 'label' => $store->getName()];
                    $count++;
                }
            }
            $this->prepareData();
            foreach ($options as $optionCode) {
                $this->options[$optionCode['value']] = [
                    'type' => 'import_content_' . $optionCode['value'],
                    'label' => __($optionCode['label']),
                    '__disableTmpl' => true
                ];

                if ($this->urlPath && $this->paramName && $this->promptTarget) {
                    $this->options[$optionCode['value']]['url'] = $this->urlBuilder->getUrl(
                        $this->urlPath,
                        [$this->paramName => $optionCode['value'], $this->promptTarget => 'product']
                    );
                }

                $this->options[$optionCode['value']] = array_merge_recursive(
                    $this->options[$optionCode['value']],
                    $this->additionalData
                );
            }
            if ($this->options) {
                $this->options = array_values($this->options);
            }
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
    /**
     * Get Store list
     *
     * @return StoreInterface[]
     */
    public function getAllStoreList(): array
    {
        $storeList = $this->storeRepository->getList();
        return $storeList;
    }
    /**
     * Is Module Enabled/Disabled for Particular Store
     *
     * @param int $storeId
     */
    public function isModuleEnabledForStore($storeId)
    {
        return $this->moduleConfig->getStoreConfigBySection('chatgpt', $storeId);
    }
}
