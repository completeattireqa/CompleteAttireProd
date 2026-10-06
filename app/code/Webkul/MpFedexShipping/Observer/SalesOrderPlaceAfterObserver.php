<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_MpFedexShipping
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\MpFedexShipping\Observer;

use Magento\Framework\Event\Manager;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Session\SessionManager;

/**
 * Webkul Marketplace MpFedexShipping SalesOrderPlaceAfterObserver Observer Model
 *
 * @author      Webkul Software
 *
 */
class SalesOrderPlaceAfterObserver implements ObserverInterface
{
    /**
     * @var eventManager
     */
    protected $_eventManager;
    /**
     * @var ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @var Session
     */
    protected $_customerSession;
    /**
     * @var Session
     */
    protected $_session;
    /**
     *
     * @var \Magento\Framework\Logger\Monolog
     */
    protected $_logger;

    /**
     * @var ordersFactory
     */
    protected $ordersFactory;

    /**
     *
     * @param \Magento\Framework\Event\Manager $eventManager
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\Logger\Monolog $logger
     * @param \Webkul\Marketplace\Model\Orders $orders
     * @param SessionManager $session
     */
    public function __construct(
        \Magento\Framework\Event\Manager $eventManager,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Logger\Monolog $logger,
        \Webkul\Marketplace\Model\OrdersFactory $ordersFactory,
        \Webkul\MpFedexShipping\Block\ManageFedexShipping $shippingConfig,
        SessionManager $session
    ) {
        $this->_eventManager = $eventManager;
        $this->_objectManager = $objectManager;
        $this->_customerSession = $customerSession;
        $this->_logger = $logger;
        $this->_session = $session;
        $this->shippingConfig = $shippingConfig;
        $this->ordersFactory = $ordersFactory;
    }

    /**
     * after place order event handler
     * Distribute Shipping Price for sellers
     * @param \Magento\Framework\Event\Observer $observer
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $order = $observer->getOrder();
        $shippingmethod=$order->getShippingMethod();
        $lastOrderId = $observer->getOrder()->getId();
        if (strpos($shippingmethod, 'mpfedex')!==false) {
            $allorderitems=$order->getAllItems();
            $shipmethod=explode('_', $shippingmethod, 2);
            $shippingAll=$this->_session->getShippingInfo();
            foreach ((array)$shippingAll['mpfedex'] as $shipdata) {
                $collection= $this->ordersFactory->create()
                            ->getCollection()
                            ->addFieldToFilter('order_id', ['eq'=>$lastOrderId])
                            ->addFieldToFilter('seller_id', ['eq'=>$shipdata['seller_id']])
                            ->getFirstItem();
                if ($collection->getId()) {
                    
                    $collection->setCarrierName($shipdata['submethod'][$shipmethod[1]]['method']);
                    
                    if (!empty($this->shippingConfig->_getCustomerData()->getFedexAccountId())) {
                        
                        $collection->setShippingCharges($shipdata['submethod'][$shipmethod[1]]['cost']);
                    }

                    $this->saveCollection($collection);
                }
            }
            $this->_session->unsShippingInfo($collection);
        }
    }

    /**
     * saveCollection
     *
     * @param  object $collection
     * @return void
     */
    public function saveCollection($collection)
    {
        $collection->save();
    }
}
