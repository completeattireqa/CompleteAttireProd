<?php
namespace Webkul\MpBraintree\Controller\Adminhtml\Escrow\Release;

/**
 * Interceptor class for @see \Webkul\MpBraintree\Controller\Adminhtml\Escrow\Release
 */
class Interceptor extends \Webkul\MpBraintree\Controller\Adminhtml\Escrow\Release implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Webkul\MpBraintree\Model\Adapter\MpBraintreeAdapter $adapter, \Webkul\MpBraintree\Api\BraintreeOrderManagementInterface $braintreOrderManager)
    {
        $this->___init();
        parent::__construct($context, $adapter, $braintreOrderManager);
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
