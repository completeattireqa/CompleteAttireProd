<?php
namespace WeltPixel\AdvancedWishlist\CustomerData\Wishlist;

/**
 * Interceptor class for @see \WeltPixel\AdvancedWishlist\CustomerData\Wishlist
 */
class Interceptor extends \WeltPixel\AdvancedWishlist\CustomerData\Wishlist implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Wishlist\Helper\Data $wishlistHelper, \Magento\Wishlist\Block\Customer\Sidebar $block, \Magento\Catalog\Helper\ImageFactory $imageHelperFactory, \Magento\Framework\App\ViewInterface $view)
    {
        $this->___init();
        parent::__construct($wishlistHelper, $block, $imageHelperFactory, $view);
    }

    /**
     * {@inheritdoc}
     */
    public function getMultiWishlistCounter()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getMultiWishlistCounter');
        if (!$pluginInfo) {
            return parent::getMultiWishlistCounter();
        } else {
            return $this->___callPlugins('getMultiWishlistCounter', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getMultiWishlistItems()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getMultiWishlistItems');
        if (!$pluginInfo) {
            return parent::getMultiWishlistItems();
        } else {
            return $this->___callPlugins('getMultiWishlistItems', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSectionData()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSectionData');
        if (!$pluginInfo) {
            return parent::getSectionData();
        } else {
            return $this->___callPlugins('getSectionData', func_get_args(), $pluginInfo);
        }
    }
}
