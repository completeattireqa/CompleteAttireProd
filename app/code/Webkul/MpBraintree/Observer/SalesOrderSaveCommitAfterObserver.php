<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_MpBraintree
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\MpBraintree\Observer;

use Magento\Framework\Event\ObserverInterface;

/**
 * Webkul Marketplace SalesOrderSaveCommitAfterObserver Observer Model.
 */
class SalesOrderSaveCommitAfterObserver implements ObserverInterface
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
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_date;

    /**
     * @var \Webkul\Marketplace\Model\OrdersFactory
     */
    protected $mpOrderFactory;

    /**
     * @var \Webkul\MpBraintree\Model\TransactionData
     */
    protected $transactionData;

    /**
     * @param \Magento\Framework\Event\Manager            $eventManager
     * @param \Magento\Framework\ObjectManagerInterface   $objectManager
     * @param \Magento\Customer\Model\Session             $customerSession
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     */
    public function __construct(
        \Magento\Framework\Event\Manager $eventManager,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Webkul\Marketplace\Model\OrdersFactory $mpOrderFactory,
        \Webkul\MpBraintree\Model\TransactionDataFactory $transactionData
    ) {
        $this->_eventManager = $eventManager;
        $this->_objectManager = $objectManager;
        $this->_customerSession = $customerSession;
        $this->_date = $date;
        $this->mpOrderFactory = $mpOrderFactory;
        $this->transactionData = $transactionData;
    }

    /**
     * Sales order save commmit after on order complete state event handler.
     *
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var $orderInstance Order */
        $order = $observer->getOrder();
        $payment = $order->getPayment();
        $lastOrderId = $observer->getOrder()->getId();

        if ($order->getPayment()->getMethod() == 'mpbraintree' && !$order->canInvoice()) {
            $sellerInvoiceData = $payment->getAdditionalInformation('item__invoice__data');
            if ($sellerInvoiceData) {
                $sellerInvoiceData = json_decode($sellerInvoiceData, true);
                foreach ($sellerInvoiceData as $key => $invoiceData) {
                    $mpTracking = $this->mpOrderFactory->create()
                        ->getCollection()
                        ->addFieldToFilter('order_id', $invoiceData['order_id'])
                        ->addFieldToFilter('seller_id', $key);

                    if ($mpTracking->getSize() > 0) {
                        foreach ($mpTracking as $row) {
                            $row->setInvoiceId($invoiceData['invoice_id']);
                            $row->save();
                        }
                    }
                }
            }

            $sellerTransactionData = $payment->getAdditionalInformation('item__transaction__data');
            if ($sellerTransactionData) {
                $sellerTransactionData = json_decode($sellerTransactionData, true);
                foreach ($sellerTransactionData as $std) {
                    /**
                     * update transaction details with braintree transaction
                     */
                    $this->transactionData->create()->setTransactionData($std);
                }
            }
        }
    }
}
