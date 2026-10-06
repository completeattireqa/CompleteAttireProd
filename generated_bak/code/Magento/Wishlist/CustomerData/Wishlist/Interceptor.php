<?php
namespace Magento\Wishlist\CustomerData\Wishlist;

/**
 * Interceptor class for @see \Magento\Wishlist\CustomerData\Wishlist
 */
class Interceptor extends \Magento\Wishlist\CustomerData\Wishlist implements \Magento\Framework\Interception\InterceptorInterface
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
