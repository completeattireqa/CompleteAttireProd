<?php
namespace Webkul\MarketplaceBaseShipping\Controller\Order\Shipment\GetShippingItemsGrid;

/**
 * Interceptor class for @see \Webkul\MarketplaceBaseShipping\Controller\Order\Shipment\GetShippingItemsGrid
 */
class Interceptor extends \Webkul\MarketplaceBaseShipping\Controller\Order\Shipment\GetShippingItemsGrid implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Shipping\Controller\Adminhtml\Order\ShipmentLoader $shipmentLoader)
    {
        $this->___init();
        parent::__construct($context, $shipmentLoader);
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
