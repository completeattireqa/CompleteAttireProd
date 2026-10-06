<?php
namespace Webkul\MpBraintree\Controller\BraintreeAccount\Save;

/**
 * Interceptor class for @see \Webkul\MpBraintree\Controller\BraintreeAccount\Save
 */
class Interceptor extends \Webkul\MpBraintree\Controller\BraintreeAccount\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Webkul\MpBraintree\Gateway\Config\Config $config, \Webkul\MpBraintree\Model\Adapter\MpBraintreeAdapter $adapter, \Magento\Directory\Model\RegionFactory $region, \Magento\Directory\Model\CountryFactory $country, \Webkul\MpBraintree\Helper\Data $braintreeHelper, \Magento\Customer\Model\CustomerFactory $customer, \Magento\Store\Model\StoreManagerInterface $storeManager, \Webkul\Marketplace\Helper\Data $marketplaceHelper, \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator, \Magento\Customer\Model\Session $customerSession)
    {
        $this->___init();
        parent::__construct($context, $config, $adapter, $region, $country, $braintreeHelper, $customer, $storeManager, $marketplaceHelper, $formKeyValidator, $customerSession);
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
