<?php
namespace WeltPixel\ThankYouPage\Controller\Newsletter\Subscribe;

/**
 * Interceptor class for @see \WeltPixel\ThankYouPage\Controller\Newsletter\Subscribe
 */
class Interceptor extends \WeltPixel\ThankYouPage\Controller\Newsletter\Subscribe implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Newsletter\Model\SubscriberFactory $subscriberFactory, \Magento\Customer\Model\Session $customerSession, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Customer\Model\Url $customerUrl, \Magento\Customer\Api\AccountManagementInterface $customerAccountManagement, \Magento\Checkout\Model\Session $checkoutSession, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory)
    {
        $this->___init();
        parent::__construct($context, $subscriberFactory, $customerSession, $storeManager, $customerUrl, $customerAccountManagement, $checkoutSession, $resultJsonFactory);
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
