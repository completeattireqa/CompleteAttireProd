<?php
namespace WeltPixel\SocialLogin\Controller\Ajax\Login;

/**
 * Interceptor class for @see \WeltPixel\SocialLogin\Controller\Ajax\Login
 */
class Interceptor extends \WeltPixel\SocialLogin\Controller\Ajax\Login implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session $customerSession, \Magento\Framework\Json\Helper\Data $helper, \Magento\Customer\Api\AccountManagementInterface $customerAccountManagement, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory, \Magento\Framework\Controller\Result\RawFactory $resultRawFactory, \Magento\Newsletter\Model\SubscriberFactory $subscriberFactory)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $helper, $customerAccountManagement, $resultJsonFactory, $resultRawFactory, $subscriberFactory);
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
