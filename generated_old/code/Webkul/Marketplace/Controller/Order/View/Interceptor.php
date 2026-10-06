<?php
namespace Webkul\Marketplace\Controller\Order\View;

/**
 * Interceptor class for @see \Webkul\Marketplace\Controller\Order\View
 */
class Interceptor extends \Webkul\Marketplace\Controller\Order\View implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Sales\Model\Order\Email\Sender\InvoiceSender $invoiceSender, \Magento\Sales\Model\Order\Email\Sender\ShipmentSender $shipmentSender, \Magento\Sales\Model\Order\ShipmentFactory $shipmentFactory, \Magento\Sales\Model\Order\Shipment $shipment, \Magento\Sales\Model\Order\Email\Sender\CreditmemoSender $creditmemoSender, \Magento\Sales\Api\CreditmemoRepositoryInterface $creditmemoRepository, \Magento\Sales\Model\Order\CreditmemoFactory $creditmemoFactory, \Magento\Sales\Api\InvoiceRepositoryInterface $invoiceRepository, \Magento\CatalogInventory\Api\StockConfigurationInterface $stockConfiguration, \Magento\Sales\Api\OrderRepositoryInterface $orderRepository, \Magento\Sales\Api\OrderManagementInterface $orderManagement, \Magento\Framework\Registry $coreRegistry, \Magento\Customer\Model\Session $customerSession, \Webkul\Marketplace\Helper\Orders $orderHelper, \Webkul\Marketplace\Helper\Notification $notificationHelper)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $invoiceSender, $shipmentSender, $shipmentFactory, $shipment, $creditmemoSender, $creditmemoRepository, $creditmemoFactory, $invoiceRepository, $stockConfiguration, $orderRepository, $orderManagement, $coreRegistry, $customerSession, $orderHelper, $notificationHelper);
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
