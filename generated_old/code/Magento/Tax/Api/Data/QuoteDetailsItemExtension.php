<?php
namespace Magento\Tax\Api\Data;

/**
 * Extension class for @see \Magento\Tax\Api\Data\QuoteDetailsItemInterface
 */
class QuoteDetailsItemExtension extends \Magento\Framework\Api\AbstractSimpleObject implements QuoteDetailsItemExtensionInterface
{
    /**
     * @return float|null
     */
    public function getTaxCollectable()
    {
        return $this->_get('tax_collectable');
    }

    /**
     * @param float $taxCollectable
     * @return $this
     */
    public function setTaxCollectable($taxCollectable)
    {
        $this->setData('tax_collectable', $taxCollectable);
        return $this;
    }

    /**
     * @return float|null
     */
    public function getCombinedTaxRate()
    {
        return $this->_get('combined_tax_rate');
    }

    /**
     * @param float $combinedTaxRate
     * @return $this
     */
    public function setCombinedTaxRate($combinedTaxRate)
    {
        $this->setData('combined_tax_rate', $combinedTaxRate);
        return $this;
    }

    /**
     * @return array|null
     */
    public function getJurisdictionTaxRates()
    {
        return $this->_get('jurisdiction_tax_rates');
    }

    /**
     * @param array $jurisdictionTaxRates
     * @return $this
     */
    public function setJurisdictionTaxRates(array $jurisdictionTaxRates)
    {
        $this->setData('jurisdiction_tax_rates', $jurisdictionTaxRates);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getProductType()
    {
        return $this->_get('product_type');
    }

    /**
     * @param string $productType
     * @return $this
     */
    public function setProductType($productType)
    {
        $this->setData('product_type', $productType);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPriceType()
    {
        return $this->_get('price_type');
    }

    /**
     * @param string $priceType
     * @return $this
     */
    public function setPriceType($priceType)
    {
        $this->setData('price_type', $priceType);
        return $this;
    }
}
