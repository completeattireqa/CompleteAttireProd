<?php
namespace Magento\Tax\Api\Data;

/**
 * ExtensionInterface class for @see \Magento\Tax\Api\Data\QuoteDetailsItemInterface
 */
interface QuoteDetailsItemExtensionInterface extends \Magento\Framework\Api\ExtensionAttributesInterface
{
    /**
     * @return float|null
     */
    public function getTaxCollectable();

    /**
     * @param float $taxCollectable
     * @return $this
     */
    public function setTaxCollectable($taxCollectable);

    /**
     * @return float|null
     */
    public function getCombinedTaxRate();

    /**
     * @param float $combinedTaxRate
     * @return $this
     */
    public function setCombinedTaxRate($combinedTaxRate);

    /**
     * @return array|null
     */
    public function getJurisdictionTaxRates();

    /**
     * @param array $jurisdictionTaxRates
     * @return $this
     */
    public function setJurisdictionTaxRates(array $jurisdictionTaxRates);

    /**
     * @return string|null
     */
    public function getProductType();

    /**
     * @param string $productType
     * @return $this
     */
    public function setProductType($productType);

    /**
     * @return string|null
     */
    public function getPriceType();

    /**
     * @param string $priceType
     * @return $this
     */
    public function setPriceType($priceType);
}
