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
    public function execute()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'execute');
        if (!$pluginInfo) {
            return parent::execute();
        } else {
            return $this->___callPlugins('execute', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addressFilter($address)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'addressFilter');
        if (!$pluginInfo) {
            return parent::addressFilter($address);
        } else {
            return $this->___callPlugins('addressFilter', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getStreetAddress($streetAddress)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getStreetAddress');
        if (!$pluginInfo) {
            return parent::getStreetAddress($streetAddress);
        } else {
            return $this->___callPlugins('getStreetAddress', func_get_args(), $pluginInfo);
        }
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

    /**
     * {@inheritdoc}
     */
    public function getActionFlag()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getActionFlag');
        if (!$pluginInfo) {
            return parent::getActionFlag();
        } else {
            return $this->___callPlugins('getActionFlag', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getRequest()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getRequest');
        if (!$pluginInfo) {
            return parent::getRequest();
        } else {
            return $this->___callPlugins('getRequest', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getResponse()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getResponse');
        if (!$pluginInfo) {
            return parent::getResponse();
        } else {
            return $this->___callPlugins('getResponse', func_get_args(), $pluginInfo);
        }
    }
}
