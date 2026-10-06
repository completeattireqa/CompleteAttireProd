<?php

namespace Webkul\ChatGPT\Model\Config\Source;

use Magento\Eav\Model\Config;
use Magento\Catalog\Api\Data\ProductAttributeInterface;

class AttributesList implements \Magento\Framework\Option\ArrayInterface
{
      /**
       * @var Config
       */
    protected $eavConfig;

      /**
       * Constructor
       *
       * @param Config $eavConfig
       */
    public function __construct(
        Config $eavConfig
    ) {
        $this->eavConfig = $eavConfig;
    }
    /**
     * To Option Array
     */
    public function toOptionArray()
    {
        $options =[];
        foreach ($this->getAttributeSetCollection() as $attr) {
            $attrCode='';
            if (strpos($attr->getAttributeCode(), '_') !== false) {
                $attrcodeArr = explode('_', $attr->getAttributeCode());
                foreach ($attrcodeArr as $code) {
                    $attrCode.= ucfirst($code);
                }
            } else {
                $attrCode = ucfirst($attr->getAttributeCode());
            }
            $options[]=['value'=>$attrCode,'label'=>$attr->getFrontendLabel()];
        }
        return $options;
    }
    /**
     * Get Attributes Collection
     */
    public function getAttributeSetCollection()
    {
        $entityType = $this->eavConfig->getEntityType(ProductAttributeInterface::ENTITY_TYPE_CODE);

        return $entityType->getAttributeCollection()
        ->addFieldToFilter('frontend_input', ['in'=>['text','textarea']])
        ->addFieldToFilter('attribute_code', ['nin'=>['custom_layout_update','category_ids','tier_price']]);
    }
}
