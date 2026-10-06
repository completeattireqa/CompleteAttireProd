<?php

namespace Webkul\ChatGPT\Model\Config\Source;

use Magento\Eav\Model\Config;
use Magento\Catalog\Api\Data\ProductAttributeInterface;
use Magento\Framework\Option\ArrayInterface;
use Magento\User\Model\ResourceModel\User\CollectionFactory;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory as CategoryCollectionFactory;

class SEOAttributesList implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var State
     */
    private $state;
    /**
     * @var Country
     */
    private $country;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
      /**
       * @var Config
       */
      protected $eavConfig;
     /**
      * Constructor
      *
      * @param ScopeConfigInterface $scopeConfig
      * @param \Magento\Framework\App\State $state
      * @param \Magento\Directory\Model\Country $country
      * @param CategoryCollectionFactory $collectionFactory
      * @param Config $eavConfig
      */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\State $state,
        \Magento\Directory\Model\Country $country,
        CategoryCollectionFactory $collectionFactory,
        Config $eavConfig
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->state = $state;
        $this->country = $country;
        $this->collectionFactory = $collectionFactory;
        $this->eavConfig = $eavConfig;
    }
    /**
     * To Option Array
     */
    public function toOptionArray()
    {
        $optionArray = [];
        $arr = $this->toArray();
        $currentGroup = '';
        $groupedOptions = [];
        foreach ($arr as $key => $value) {
            if (is_int($key)) {
                // This is a new group label
                if (!empty($groupedOptions)) {
                    $optionArray[] = [
                        'label' => $currentGroup,
                        'value' => $groupedOptions
                    ];
                    $groupedOptions = [];
                }
                $currentGroup = $value;
            } else {
                // This is an option within the group
                $groupedOptions[] = [
                    'label' => $value,
                    'value' => $key
                ];
            }
        }
        // Add the last group
        if (!empty($groupedOptions)) {
            $optionArray[] = [
                'label' => $currentGroup,
                'value' => $groupedOptions
            ];
        }
        return $optionArray;
    }
     /**
      * Get options in "key-value" format
      *
      * @return array
      */
    public function toArray()
    {
        return $this->getChildren();
    }

    /**
     * Get children
     */
    private function getChildren()
    {
        $options = [];
        $parents = ['Product', 'Category', 'CMSPage'];
        $seoAttributes = $this->getSEOAttributes();
        foreach ($parents as $parent) {
            $options[] = $parent;
            foreach ($seoAttributes as $seoAttribute) {
                $options[$parent.'_'.$seoAttribute['value']] = str_repeat("-  ", 3) .$seoAttribute['label'];
            }
        }
        return $options;
    }
    /**
     * Get Attributes Collection
     */
    public function getAttributeSetCollection()
    {
        $entityType = $this->eavConfig->getEntityType(ProductAttributeInterface::ENTITY_TYPE_CODE);
        $returnArr = $entityType->getAttributeCollection()
        ->addFieldToFilter('frontend_input', ['in'=>['text','textarea']])
        ->addFieldToFilter('attribute_code', ['nin'=>['custom_layout_update','category_ids','tier_price']]);
        return $returnArr;
    }
    /**
     * To Get SEO Attributes
     */
    public function getSEOAttributes()
    {
        $options =[];
        foreach ($this->getAttributeSetCollection() as $attr) {            
            $attrCode='';
            if (strpos($attr->getAttributeCode(), 'meta_') !== false) {
                $attrcodeArr = explode('_', $attr->getAttributeCode());
                foreach ($attrcodeArr as $code) {
                    $attrCode.= ucfirst($code);
                }
            } else {
                continue;
            }
            $options[]=['value'=>$attrCode,'label'=>'  '.$attr->getFrontendLabel()];
        }
        return $options;
    }
}
