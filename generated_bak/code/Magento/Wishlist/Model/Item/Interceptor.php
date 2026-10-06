<?php
namespace Magento\Wishlist\Model\Item;

/**
 * Interceptor class for @see \Magento\Wishlist\Model\Item
 */
class Interceptor extends \Magento\Wishlist\Model\Item implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\Stdlib\DateTime\DateTime $date, \Magento\Catalog\Model\ResourceModel\Url $catalogUrl, \Magento\Wishlist\Model\Item\OptionFactory $wishlistOptFactory, \Magento\Wishlist\Model\ResourceModel\Item\Option\CollectionFactory $wishlOptionCollectionFactory, \Magento\Catalog\Model\ProductTypes\ConfigInterface $productTypeConfig, \Magento\Catalog\Api\ProductRepositoryInterface $productRepository, \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null, \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null, array $data = array(), \Magento\Framework\Serialize\Serializer\Json $serializer = null)
    {
        $this->___init();
        parent::__construct($context, $registry, $storeManager, $date, $catalogUrl, $wishlistOptFactory, $wishlOptionCollectionFactory, $productTypeConfig, $productRepository, $resource, $resourceCollection, $data, $serializer);
    }

    /**
     * {@inheritdoc}
     */
    public function addToCart(\Magento\Checkout\Model\Cart $cart, $delete = false)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addToCart');
        if (!$pluginInfo) {
            return parent::addToCart($cart, $delete);
        } else {
            return $this->___callPlugins('addToCart', func_get_args(), $pluginInfo);
        }
    }
}
