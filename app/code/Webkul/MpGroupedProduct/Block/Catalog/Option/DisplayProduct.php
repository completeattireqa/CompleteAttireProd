<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_MpGroupedProduct
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\MpGroupedProduct\Block\Catalog\Option;

/**
 * DisplayProduct Class MpGroupedProduct
 */
class DisplayProduct extends \Magento\GroupedProduct\Block\Adminhtml\Product\Composite\Fieldset\Grouped
{
    /**
     * @var \Magento\Framework\Pricing\Helper\Data
     */
    protected $pricingHelper;
    protected $_product;

    /**
     * @param \Magento\Catalog\Block\Product\Context $context
     * @param \Magento\Framework\Stdlib\ArrayUtils   $arrayUtils
     * @param \Magento\Framework\Pricing\Helper\Data $pricingHelper
     * @param array                                  $data
     */
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Catalog\Model\Product $product,
        \Magento\Framework\Stdlib\ArrayUtils $arrayUtils,
        \Magento\Framework\Pricing\Helper\Data $pricingHelper,
        array $data = []
    ) {
        $this->pricingHelper = $pricingHelper;
        $this->_product = $product;
        parent::__construct(
            $context,
            $arrayUtils,
            $pricingHelper,
            $data
        );
    }
    
    /**
     * Retrieve array of associated products
     *
     * @return array
     */
    public function getAssociatedProducts()
    {
        $productId = $this->getRequest()->getParam('id');
        $productIds = [];
        $i = 0;
        if ($productId) {
            $product = $this->_product->load($productId);
            $result = $product->getTypeInstance()->getAssociatedProducts($product);
            foreach ($result as $item) {
                $productIds[$i] = $item->getId();
                $i++;
            }
        }
        return $productIds;
    }

    /**
     * @return product type
     */
    public function getProductType()
    {
        $productId = $this->getRequest()->getParam('id');
        if ($productId) {
            $product = $this->_product->load($productId);
            $productType = $product->getTypeId();
        } else {
            $productType = $this->getRequest()->getParam('type');
        }
        return $productType;
    }
}
