<?php
namespace WeltPixel\SocialLogin\Controller\Account\Email;

/**
 * Interceptor class for @see \WeltPixel\SocialLogin\Controller\Account\Email
 */
class Interceptor extends \WeltPixel\SocialLogin\Controller\Account\Email implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \WeltPixel\SocialLogin\Helper\Data $slHelper, \Magento\Store\Model\StoreManager $storeManager, \Magento\Framework\Controller\Result\RawFactory $resultRawFactory, \Magento\Newsletter\Model\SubscriberFactory $subscriberFactory, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory, \Magento\Customer\Model\CustomerFactory $customerFactory, \WeltPixel\SocialLogin\Model\Sociallogin $model, \Magento\Customer\Model\Session $customerSession, \Magento\Framework\View\Layout\Interceptor $layout)
    {
        $this->___init();
        parent::__construct($context, $slHelper, $storeManager, $resultRawFactory, $subscriberFactory, $resultJsonFactory, $customerFactory, $model, $customerSession, $layout);
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
