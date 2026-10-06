<?php
namespace WeltPixel\SocialLogin\Controller\Account\Unlink;

/**
 * Interceptor class for @see \WeltPixel\SocialLogin\Controller\Account\Unlink
 */
class Interceptor extends \WeltPixel\SocialLogin\Controller\Account\Unlink implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session $customerSession, \WeltPixel\SocialLogin\Helper\Data $slHelper, \Magento\Store\Model\StoreManager $storeManager, \Magento\Framework\Controller\Result\RawFactory $resultRawFactory, \Magento\Framework\View\Layout\Interceptor $layout, \Magento\Newsletter\Model\SubscriberFactory $subscriberFactory, \WeltPixel\SocialLogin\Model\SocialloginFactory $socialloginFactory)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $slHelper, $storeManager, $resultRawFactory, $layout, $subscriberFactory, $socialloginFactory);
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
