<?php
namespace Webkul\MarketplaceBaseShipping\Controller\Order\Shipment\Save;

/**
 * Interceptor class for @see \Webkul\MarketplaceBaseShipping\Controller\Order\Shipment\Save
 */
class Interceptor extends \Webkul\MarketplaceBaseShipping\Controller\Order\Shipment\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Webkul\Marketplace\Model\OrdersFactory $marketplaceOrderData, \Magento\Customer\Model\Session $customerSession, \Magento\Shipping\Controller\Adminhtml\Order\ShipmentLoader $shipmentLoader, \Webkul\MarketplaceBaseShipping\Model\Shipping\LabelGenerator $labelGenerator, \Magento\Sales\Model\Order\Email\Sender\ShipmentSender $shipmentSender)
    {
        $this->___init();
        parent::__construct($context, $marketplaceOrderData, $customerSession, $shipmentLoader, $labelGenerator, $shipmentSender);
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
