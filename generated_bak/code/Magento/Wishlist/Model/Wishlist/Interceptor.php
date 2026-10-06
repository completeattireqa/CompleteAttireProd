<?php
namespace Magento\Wishlist\Model\Wishlist;

/**
 * Interceptor class for @see \Magento\Wishlist\Model\Wishlist
 */
class Interceptor extends \Magento\Wishlist\Model\Wishlist implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Model\Context $context, \Magento\Framework\Registry $registry, \Magento\Catalog\Helper\Product $catalogProduct, \Magento\Wishlist\Helper\Data $wishlistData, \Magento\Wishlist\Model\ResourceModel\Wishlist $resource, \Magento\Wishlist\Model\ResourceModel\Wishlist\Collection $resourceCollection, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\Stdlib\DateTime\DateTime $date, \Magento\Wishlist\Model\ItemFactory $wishlistItemFactory, \Magento\Wishlist\Model\ResourceModel\Item\CollectionFactory $wishlistCollectionFactory, \Magento\Catalog\Model\ProductFactory $productFactory, \Magento\Framework\Math\Random $mathRandom, \Magento\Framework\Stdlib\DateTime $dateTime, \Magento\Catalog\Api\ProductRepositoryInterface $productRepository, $useCurrentWebsite = true, array $data = array(), \Magento\Framework\Serialize\Serializer\Json $serializer = null)
    {
        $this->___init();
        parent::__construct($context, $registry, $catalogProduct, $wishlistData, $resource, $resourceCollection, $storeManager, $date, $wishlistItemFactory, $wishlistCollectionFactory, $productFactory, $mathRandom, $dateTime, $productRepository, $useCurrentWebsite, $data, $serializer);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getName');
        if (!$pluginInfo) {
            return parent::getName();
        } else {
            return $this->___callPlugins('getName', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function afterSave()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'afterSave');
        if (!$pluginInfo) {
            return parent::afterSave();
        } else {
            return $this->___callPlugins('afterSave', func_get_args(), $pluginInfo);
        }
    }
}
