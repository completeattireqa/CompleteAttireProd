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

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Webkul\MpBraintree\Logger\BraintreeLogger as Logger;

class CheckoutAllSubmitAfterObserver implements ObserverInterface
{
    /**
     * $_logger.
     *
     * @var Webkul\MpBraintree\Logger\BraintreeLogger
     */
    protected $_logger;
   
   /**
    * braintree order manager
    *
    * @var Webkul\MpBraintree\Model\BraintreeOrderManagement
    */
    protected $_braintreOrderManager;

    /**
     * @var \Webkul\MpBraintree\Model\TransactionData
     */
    protected $transactionData;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $_request;

    /**
     * all the transactions ids
     */
    protected $transactionsArray = [];

    public function __construct(
        Logger $logger,
        \Webkul\MpBraintree\Api\BraintreeOrderManagementInterface $braintreOrderManager,
        \Webkul\MpBraintree\Model\TransactionDataFactory $transactionData,
        \Magento\Framework\App\RequestInterface $request
    ) {
        $this->_logger = $logger;
        $this->_braintreOrderManager = $braintreOrderManager;
        $this->transactionData = $transactionData;
        $this->_request = $request;
    }

    /**
     *
     * @param Observer $observer
     * @return $this
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        if (!$order->getId()) {
            return $this;
        }

        if ($order->getPayment()->getMethod() == 'mpbraintree') {
            //this code will be only executed if
            $totalPaid = 0;
            if ($order->getTotalPaid()) {
                $totalPaid = $order->getTotalPaid();
            }
            if ($order->canInvoice() && $totalPaid == 0) {
                $cartData = $this->_braintreOrderManager->getCartData($order->getPayment());
                /**
                 * $ifSellerInCart check if there is atlest one seller product is order.
                 *
                 * @var bool
                 */
                $ifSellerInCart = $this->_braintreOrderManager->getIfSellerInCart($cartData);
                try {
                    $transactionIds = [];
                    $sellerInvoiceData = [];
                    if ($ifSellerInCart) {
                        foreach ($cartData as $cart) {
                             /**
                             * $transactionId create transaction.
                             *
                             * @var string
                             */
                            $transactionId = $this->_braintreOrderManager->doTransaction($order, $cart);
                            $transactionIds[] = $transactionId;
                            $realTransactionId = $this->_braintreOrderManager->getRealTransactionId($transactionId);
                            $invoiceId = $this->_braintreOrderManager->doSellerOrderInvoice($order, $cart, $realTransactionId);
                            if ($invoiceId) {
                                $sellerInvoiceData[$cart['seller']]['order_id'] = $order->getId();
                                $sellerInvoiceData[$cart['seller']]['invoice_id'] = $invoiceId;
                            }
                            /**
                             * escrow transaction
                             */
                            if ($this->_braintreOrderManager->canEscrow()) {
                                $this->_logger->critical("check order escrow status passed");
                                
                                if ($this->_braintreOrderManager->canEscrowTransaction($realTransactionId)) {
                                    $this->_logger->critical("check transaction escrow status passed");
                                    $this->_braintreOrderManager->holdInEscrow($realTransactionId);
                                } else {
                                    $this->_logger->critical("check transaction escrow status failed");
                                }
                            } else {
                                if (isset($cart['seller']) && $cart['seller']) {
                                    $this->_braintreOrderManager->payToSeller($order, $cart['seller'], $transactionId);
                                }
                                $this->_logger->critical("check order escrow status failed");
                            }
                        }
                    } else {
                        $transactionId = $this->_braintreOrderManager->doCompleteOrderInvoice($order, $cartData[0]);
                        $transactionIds[] = $transactionId;
                    }
                    
                    if (count($transactionIds) > 0) {
                        $payment = $order->getPayment();
                        $payment->setAdditionalInformation('item__transaction__data', json_encode($transactionIds));
                        $payment->save();
                    }

                    if (count($sellerInvoiceData) > 0) {
                        $payment = $order->getPayment();
                        $payment->setAdditionalInformation('item__invoice__data', json_encode($sellerInvoiceData));
                        $payment->save();
                    }
                } catch (\Exception $e) {
                    $this->_logger->critical($e);
                    $this->_transactionsArray = $this->_braintreOrderManager->getAllTransactionsOfOrder($order->getId());
                    $this->voidAllTransactions();
                    throw new \Magento\Framework\Exception\LocalizedException(__($e->getMessage()));
                }
            }
        }
        return $this;
    }

    /**
     * void all the transactions
     *
     * @return void
     */
    private function voidAllTransactions()
    {
        if (count($this->_transactionsArray) > 0) {
            foreach ($this->_transactionsArray as $txnId) {
                $this->_braintreOrderManager->doVoid($txnId);
            }
        }
    }
}
