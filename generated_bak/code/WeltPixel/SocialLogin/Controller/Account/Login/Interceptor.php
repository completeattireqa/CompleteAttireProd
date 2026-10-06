<?php
namespace WeltPixel\SocialLogin\Controller\Account\Login;

/**
 * Interceptor class for @see \WeltPixel\SocialLogin\Controller\Account\Login
 */
class Interceptor extends \WeltPixel\SocialLogin\Controller\Account\Login implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session $customerSession, \WeltPixel\SocialLogin\Helper\Data $dataHelper, \Magento\Store\Model\StoreManager $storeManager, \Magento\Framework\Controller\Result\RawFactory $resultRawFactory, \Magento\Framework\View\Layout\Interceptor $layout, \Magento\Newsletter\Model\SubscriberFactory $subscriberFactory, \Magento\Customer\Model\CustomerFactory $customer, \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository, \Magento\Framework\Data\Form\FormKey $formKey)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $dataHelper, $storeManager, $resultRawFactory, $layout, $subscriberFactory, $customer, $customerRepository, $formKey);
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
