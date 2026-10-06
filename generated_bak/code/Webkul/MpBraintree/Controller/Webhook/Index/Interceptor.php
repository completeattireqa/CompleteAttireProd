<?php
namespace Webkul\MpBraintree\Controller\Webhook\Index;

/**
 * Interceptor class for @see \Webkul\MpBraintree\Controller\Webhook\Index
 */
class Interceptor extends \Webkul\MpBraintree\Controller\Webhook\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Webkul\MpBraintree\Helper\Data $braintreeHelper, \Webkul\MpBraintree\Model\Adapter\MpBraintreeAdapter $adapter, \Webkul\MpBraintree\Gateway\Config\Config $config, \Webkul\MpBraintree\Api\BraintreeHooksManagerInterface $webhookManager)
    {
        $this->___init();
        parent::__construct($context, $braintreeHelper, $adapter, $config, $webhookManager);
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
