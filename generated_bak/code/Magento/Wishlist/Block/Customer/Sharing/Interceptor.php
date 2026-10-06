<?php
namespace Magento\Wishlist\Block\Customer\Sharing;

/**
 * Interceptor class for @see \Magento\Wishlist\Block\Customer\Sharing
 */
class Interceptor extends \Magento\Wishlist\Block\Customer\Sharing implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Wishlist\Model\Config $wishlistConfig, \Magento\Framework\Session\Generic $wishlistSession, array $data = array())
    {
        $this->___init();
        parent::__construct($context, $wishlistConfig, $wishlistSession, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockHtml($name)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getBlockHtml');
        if (!$pluginInfo) {
            return parent::getBlockHtml($name);
        } else {
            return $this->___callPlugins('getBlockHtml', func_get_args(), $pluginInfo);
        }
    }
}
