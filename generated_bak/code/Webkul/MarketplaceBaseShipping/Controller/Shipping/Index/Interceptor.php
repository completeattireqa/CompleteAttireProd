<?php
namespace Webkul\MarketplaceBaseShipping\Controller\Shipping\Index;

/**
 * Interceptor class for @see \Webkul\MarketplaceBaseShipping\Controller\Shipping\Index
 */
class Interceptor extends \Webkul\MarketplaceBaseShipping\Controller\Shipping\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Customer\Model\Session $customerSession, \Webkul\MarketplaceBaseShipping\Model\ShippingSettingRepository $shippingSettingRepository, \Webkul\Marketplace\Helper\Data $marketplaceHelper, \Magento\Framework\Registry $registry, \Magento\Store\Model\StoreManagerInterface $storeManager)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $customerSession, $shippingSettingRepository, $marketplaceHelper, $registry, $storeManager);
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        if (!$pluginInfo) {
            return parent::dispatch($request);
        } else {
            return $this->___callPlugins('dispatch', func_get_args(), $pluginInfo);
        }
    }
}
