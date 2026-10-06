<?php
namespace Webkul\Marketplace\Block\Account\Navigation\ShippingMenu;

/**
 * Interceptor class for @see \Webkul\Marketplace\Block\Account\Navigation\ShippingMenu
 */
class Interceptor extends \Webkul\Marketplace\Block\Account\Navigation\ShippingMenu implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, \Magento\Framework\ObjectManagerInterface $objectManager, \Magento\Framework\Stdlib\DateTime\DateTime $date, \Magento\Customer\Model\Session $customerSession, \Magento\Shipping\Model\Config $shipconfig)
    {
        $this->___init();
        parent::__construct($context, $objectManager, $date, $customerSession, $shipconfig);
    }

    /**
     * {@inheritdoc}
     */
    public function isShippineAvlForSeller()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isShippineAvlForSeller');
        if (!$pluginInfo) {
            return parent::isShippineAvlForSeller();
        } else {
            return $this->___callPlugins('isShippineAvlForSeller', func_get_args(), $pluginInfo);
        }
    }
}
