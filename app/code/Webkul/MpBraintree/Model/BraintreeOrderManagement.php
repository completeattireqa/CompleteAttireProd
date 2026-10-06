<?php
/**
 * Webkul Software.
 *
 * @category Webkul
 *
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\MpBraintree\Model;

use Magento\Customer\Model\Session;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Order\Payment\Transaction;
use Magento\Sales\Model\Order\Email\Sender\InvoiceSender;
use Webkul\MpBraintree\Logger\BraintreeLogger as Logger;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Braintree\Model\Adapter\BraintreeSearchAdapter;
use Webkul\Marketplace\Helper\Orders as MarketplaceOrders;

class BraintreeOrderManagement implements \Webkul\MpBraintree\Api\BraintreeOrderManagementInterface
{
    /**
     * @var Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * $_scopeConfig.
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * $_helper.
     *
     * @var \Webkul\MpBraintree\Helper\Data
     */
    protected $_helper;

    /**
     * $_orderRepository.
     *
     * @var OrderRepositoryInterface
     */
    protected $_orderRepository;

    /**
     * $_transactionBuilder.
     *
     * @var Transaction
     */
    protected $_transactionBuilder;

    /**
     * $_transactionFactory.
     *
     * @var Transaction
     */
    protected $_transactionFactory;

    /**
     * @var InvoiceSender
     */
    protected $_invoiceSender;

    /**
     * $_checkoutSession.
     *
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * $_logger.
     *
     * @var Webkul\MpBraintree\Logger\BraintreeLogger
     */
    protected $_logger;

    /**
     * @var PriceCurrencyInterface
     */
    protected $_priceCurrency;

    /**
     * ObjectManager
     */
    protected $_objectManager;

    /**
     * braintree configuration
     *
     * @var Webkul\Braintree\Gateway\Config\Config
     */
    protected $config;
    
    /**
     * braintree payment adapter
     *
     * @var Webkul\Braintree\Model\Adapter\MpBraintreeAdapter
     */
    protected $adapter;

    /**
     * @var BraintreeSearchAdapter
     */
    private $braintreeSearchAdapter;

    /**
     * marketplace order helper
     *
     * @var MarketplaceOrders
     */
    protected $marketplaceOrders;

    /**
     * order management interface
     *
     * @var \Magento\Sales\Api\OrderManagementInterface
     */
    protected $orderManagement;

    /**
     * @var \Webkul\MpBraintree\Model\TransactionData
     */
    protected $transactionData;

    /**
     * @var \Magento\Sales\Model\OrderFactory
     */
    protected $_orderFactory;

    public function __construct(
        Session $customerSession,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Webkul\MpBraintree\Helper\Data $helper,
        OrderRepositoryInterface $orderRepository,
        \Magento\Checkout\Model\Session $checkoutSession,
        Transaction\BuilderInterface $transactionBuilder,
        \Magento\Sales\Model\Order\Payment\TransactionFactory $transactionFactory,
        InvoiceSender $invoiceSender,
        PriceCurrencyInterface $priceCurrency,
        Logger $logger,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Webkul\MpBraintree\Gateway\Config\Config $config,
        \Webkul\MpBraintree\Model\Adapter\MpBraintreeAdapter $adapter,
        BraintreeSearchAdapter $braintreeSearchAdapter,
        MarketplaceOrders $marketplaceOrders,
        \Magento\Sales\Api\OrderManagementInterface $orderManagement,
        \Webkul\MpBraintree\Model\TransactionData $transactionData,
        \Magento\Sales\Model\OrderFactory $orderFactory
    ) {
        $this->_helper = $helper;
        $this->_customerSession = $customerSession;
        $this->_scopeConfig = $scopeConfig;
        $this->_orderRepository = $orderRepository;
        $this->_checkoutSession = $checkoutSession;
        $this->_transactionBuilder = $transactionBuilder;
        $this->_transactionFactory = $transactionFactory;
        $this->_invoiceSender = $invoiceSender;
        $this->_logger = $logger;
        $this->_priceCurrency = $priceCurrency;
        $this->_objectManager = $objectManager;
        $this->config = $config;
        $this->adapter = $adapter;
        $this->braintreeSearchAdapter = $braintreeSearchAdapter;
        $this->marketplaceOrders = $marketplaceOrders;
        $this->orderManagement = $orderManagement;
        $this->transactionData = $transactionData;
        $this->_orderFactory = $orderFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function doCompleteOrderInvoice($order, $sellerData)
    {
        $order = $this->validateOrder($order);
        if ($order && $this->canInvoice($order)) {
            try {
                /**
                 * $transactionId create transaction for the current charge.
                 *
                 * @var int
                 */
                $transactionId = $this->doTransaction($order, $sellerData);
                
                $invoice = $this->_objectManager->create(
                    'Magento\Sales\Model\Service\InvoiceService'
                )->prepareInvoice($order);
                $invoice->setTransactionId($transactionId);
                $invoice->setRequestedCaptureCase(\Magento\Sales\Model\Order\Invoice::CAPTURE_ONLINE);
                $invoice->register();
                $invoice->save();
                $transactionSave = $this->_objectManager->create(
                    'Magento\Framework\DB\Transaction'
                )->addObject(
                    $invoice
                )->addObject(
                    $invoice->getOrder()
                );
                $transactionSave->save();
                $this->_invoiceSender->send($invoice);
                //send notification code
                $order->addStatusHistoryComment(
                    __('Notified customer about invoice #%1.', $invoice->getId())
                )
                ->setIsCustomerNotified(true)
                ->setState(\Magento\Sales\Model\Order::STATE_PROCESSING)
                ->setStatus(\Magento\Sales\Model\Order::STATE_PROCESSING)
                ->save();
                //update transaction information
                $this->transactionData->setTransactionData($transactionId);
                return $transactionId;
            } catch (\Exception $e) {
                $this->_logger->critical($e);
        
                throw new \Magento\Framework\Exception\LocalizedException(__("somthing went wromg while creating the order invoice--". $e->getMessage()));
            }
        } else {
            $this->_logger->critical("something went wrong not able to create invoice for complete order");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function doSellerOrderInvoice($order, $sellerData, $transactionId)
    {
        $order = $this->validateOrder($order);
        if (($order && $this->canInvoice($order)) || $order->getTotalDue() > 0) {
            try {
                $orderId = $order->getId();
                $sellerId = $sellerData['seller'];
                
                /**
                 * $itemsarray get item data for invoice.
                 *
                 * @var array
                 */
                $itemsarray['data'] = [];

                if (isset($sellerData['products']) && $sellerData['products']) {
                    $itemsarray = $this->_getItemQtys($order, explode(',', $sellerData['products']));
                }

                    $invoice = $this->_objectManager->create(
                        'Magento\Sales\Model\Service\InvoiceService'
                    )->prepareInvoice(
                        $order,
                        $itemsarray['data']
                    );
                if (count($itemsarray['data']) > 0) {
                    $invoice->setTransactionId($transactionId);
                    $invoice->setRequestedCaptureCase(\Magento\Sales\Model\Order\Invoice::CAPTURE_ONLINE);
                    
                    $invoice->setShippingAmount($sellerData['shippingprice']);
                    $invoice->setBaseShippingAmount($sellerData['shippingprice']);

                    // $invoice->setTaxAmount($sellerData['taxamount']);
                    // $invoice->setBaseTaxAmount($sellerData['taxamount']);
                    
                    $invoice->setSubtotal($this->_priceCurrency->round($sellerData['price'] - $sellerData['taxamount']));
                    $invoice->setBaseSubtotal($this->_priceCurrency->round($sellerData['price'] - $sellerData['taxamount']));
                    $invoice->setGrandTotal(
                        $this->_priceCurrency->round(
                            $sellerData['price']
                        )
                    );
                    $invoice->setBaseGrandTotal(
                        $this->_priceCurrency->round(
                            $sellerData['price']
                        )
                    );
                } else {
                    $invoice->setTransactionId($transactionId);
                    $invoice->setRequestedCaptureCase(\Magento\Sales\Model\Order\Invoice::CAPTURE_ONLINE);
                    
                    $invoice->setSubtotal($sellerData['price']);
                    // $invoice->setTaxAmount(0);
                    // $invoice->setBaseTaxAmount(0);
                    $invoice->setShippingAmount(0);
                    $invoice->setBaseShippingAmount(0);
                    $invoice->setGrandTotal($sellerData['price']);
                    $invoice->setBaseGrandTotal($sellerData['price']);
                }
                
                    $invoice->register();
                    $invoice->save();
                    $invoice->getOrder()->setIsInProcess(true);
                    $transactionSave = $this->_objectManager->create(
                        'Magento\Framework\DB\Transaction'
                    )
                    ->addObject($invoice)
                    ->addObject($invoice->getOrder());
                    $transactionSave->save();
                    $this->_invoiceSender->send($invoice);
                    //send notification code
                    $order->addStatusHistoryComment(
                        __(
                            'Notified customer about invoice #%1.',
                            $invoice->getId()
                        )
                    )
                    ->setIsCustomerNotified(true)
                    ->setState(\Magento\Sales\Model\Order::STATE_PROCESSING)
                    ->setStatus(\Magento\Sales\Model\Order::STATE_PROCESSING)
                    ->save();
                    $invoiceId = $invoice->getId();
                    // $mpTracking = $this->_objectManager->create('Webkul\Marketplace\Model\OrdersFactory')
                    //     ->create()
                    //     ->getCollection()
                    //     ->addFieldToFilter('order_id', $orderId)
                    //     ->addFieldToFilter('seller_id', $sellerId);
                    // $this->_logger->critical("invoice created from invoice", [$invoiceId, $mpTracking->getSize()]);
                    // if ($mpTracking->getSize() > 0) {
                    //     foreach ($mpTracking as $row) {
                    //         $row->setInvoiceId($invoiceId);
                    //         $row->save();
                    //     }
                    // }

                    return $invoice->getId();
            } catch (\Exception $e) {
                $this->_logger->critical($e);
                
                throw new \Magento\Framework\Exception\LocalizedException(__("something went wrong while creating the order invoice -- ".$e->getMessage()));
            }
        } else {
            $this->_logger->critical("something went wrong not able to create seller wise invoice");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function doTransaction($order, $sellerData)
    {
        try {
            $order = $this->validateOrder($order);
            if ($order === null) {
                return null;
            }
            $transactioId = $this->getTransactionId($order->getPayment(), $sellerData);
            $this->_logger->debug('debug transaction with id: '.$transactioId, $sellerData);
            $payment = $order->getPayment();
            //$lastTransactionId = $payment->getLastTransId();
            $this->_logger->debug('debug last transaction with id: '.$transactioId, $sellerData);
            $payment->setLastTransId($transactioId);
            $payment->setTransactionId($transactioId);
            $formatedPrice = $order->getBaseCurrency()->formatTxt(
                $order->getGrandTotal()
            );

            $message = __('The authorized amount is %1.', $formatedPrice);

            $trans = $this->_transactionBuilder;
            $isClosed = 0;
            $transaction = $trans->setPayment($payment)
                ->setOrder($order)
                ->setTransactionId($transactioId)
                ->setAdditionalInformation(
                    [\Magento\Sales\Model\Order\Payment\Transaction::RAW_DETAILS => (array) $sellerData]
                )
                ->setFailSafe(true)
                ->build(\Magento\Sales\Model\Order\Payment\Transaction::TYPE_CAPTURE);
             $this->_logger->critical('debug last transaction with id: '.$transactioId, $sellerData);
            $payment->addTransactionCommentsToOrder(
                $transaction,
                $message
            );
            $transaction->setIsClosed($isClosed);
            //$payment->setParentTransactionId();
            $payment->save();
            $order->save();
            if ($transaction) {
                return  $transaction->save()->getTransactionId();
            } else {
                return $transactioId;
            }
        } catch (\Exception $e) {
            $this->_logger->critical($e);

            throw new \Magento\Framework\Exception\LocalizedException(__("something went wrong while creating the transaction-- ".$e->getMessage()));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function doVoid($transactioId)
    {
        try {
            $this->adapter->void($transactioId);
            return true;
        } catch (\Exception $e) {
            return false;
            // throw new \Magento\Framework\Exception\LocalizedException(__("not able to void the transaction"));
        }
    }

    /**
     * cancel seller wise items
     *
     * @return bool
     */
    public function cancelOrder($order)
    {
        $this->orderManagement->cancel($order);
    }

    /**
     * cancel seller wise items
     *
     * @return bool
     */
    public function cancelSellerWiseItems($order, $sellerData)
    {
        try {
            $transactioId = $this->getTransactionId($order->getPayment(), $sellerData);
            $this->adapter->void($transactioId);
            $this->cancelOrderItems($order, $sellerData);
            return true;
        } catch (\Exception $e) {
            //todo log issue
        }
    }

    /**
     * cancel order items
     *
     * @return void
     */
    public function cancelOrderItems($order, $sellerData)
    {
        if (isset($sellerData['products']) && $sellerData['products']) {
            $products = explode(",", $sellerData['product']);
            foreach ($order->getAllVisibleItems() as $_item) {
                if (in_array($_item->getProductId(), $products)) {
                    try {
                        $_item->cancel();
                    } catch (\Exception $e) {
                        //todo log exception
                    }
                }
            }
        }
    }

    /**
     * check if invoice creation allowed
     *
     * @param Magento\Sales\Model\Order $order
     * @return bool
     */
    public function canInvoice($order)
    {
        return $order->canInvoice();
    }

    /**
     * check if order can be set void
     *
     * @param Magento\Sales\Model\Order $order
     * @return bool
     */
    public function canVoid($order = null)
    {
        return $order->canVoid();
    }

    /**
     * check if escrow enabled
     *
     * @param Magento\Sales\Model\Order $order
     * @return bool
     */
    public function canEscrow($order = null)
    {
        return $this->config->getHoldInEscrow();
    }

    /**
     * check escrow status
     *
     * @param string $transactionId
     * @return bool
     */
    public function escrowStatus($transactionId)
    {
        try {
            $transaction = $this->adapter->findTransaction($transactioId);
            return $transaction->escrowStatus;
        } catch (\Exception $e) {
            return false;
            $this->_logger->critical("transaction with id ".$transactionId." not found");
        }
    }

    /**
     * check transaction status
     *
     * @param string $transactionId
     * @return bool
     */
    public function transactionStatus($transactionId)
    {
        try {
            $transaction = $this->adapter->findTransaction($transactioId);
            return $transaction->status;
        } catch (\Exception $e) {
            return false;
            $this->_logger->critical("transaction with id ".$transactionId." not found");
        }
    }

    /**
     * can escrow transaction
     *
     * @param string $transactionId
     * @return boolean
     */
    public function canEscrowTransaction($transactionId)
    {
        $obj = $this->adapter->findTransaction($transactionId);
        $collection = $this->adapter->search([
                $this->braintreeSearchAdapter->id()->is($transactionId),
                $this->braintreeSearchAdapter->status()->in([\Braintree\Transaction::AUTHORIZED, \Braintree\Transaction::SUBMITTED_FOR_SETTLEMENT]),

        ]);
        $this->_logger->critical("transaction count for escrow status", [$collection->maximumCount(), $obj->status, $obj->escrowStatus]);
        return $collection->maximumCount() > 0;
    }

    /**
     * hold transaction in escrow
     *
     * @param string $transactionId
     * @param Magento\Sales\Model\Order $order
     * @return mixed
     */
    public function holdInEscrow($transactionId)
    {
        $result = $this->adapter->holdInEscrow($transactionId);
        if ($result->success) {
            return true;
        }
        return false;
    }

    /**
     * validate order
     *
     * @param Magento\Sales\Model\Order $order
     * @return Magento\Sales\Model\Order | NULL
     */
    public function validateOrder($order)
    {
        if ($order && $order->getId()) {
            return $order;
        }

        return null;
    }

    /**
     * get transaction id for seller from payment additional info
     *
     * @param Magento\Sales\Model\Order\Payment $payment
     * @param array $charge
     * @return void
     */
    public function getTransactionId($payment, $charge)
    {
        $additionalInfo = $payment->getAdditionalInformation();
        $transData = [];
        foreach ($additionalInfo as $key => $info) {
            // echo $info;
            $data = explode("_seller_", $key);
            if (count($data) == 2) {
                if (is_numeric($data[1])) {
                    $transData[$data[1]][$data[0]] = $info;
                }
            }
        }

        foreach ($transData as $t) {
            if ($t['sellerId'] == $charge['seller']) {
                return $t['id'];
            }
        }
    }

    /**
     * get seller id from transaction id
     *
     * @param string $transactionId
     * @return int
     */
    public function getSellerFromTransactionId($transactionId, $order)
    {
        if (is_numeric($order)) {
            $order = $this->_orderFactory->create()->load($order);
        }
        $additionalInfo = $order->getPayment()->getAdditionalInformation();
        $transData = [];
        foreach ($additionalInfo as $key => $info) {
            // echo $info;
            $data = explode("_seller_", $key);
            if (count($data) == 2) {
                if (is_numeric($data[1])) {
                    $transData[$data[1]][$data[0]] = $info;
                }
            }
        }
        
        foreach ($transData as $t) {
            if ($t['id'] == $transactionId) {
                return $t['sellerId'];
            }
        }
        return 0;
    }

    /**
     * get real transaction id generated by payment gateway
     * @param int $transactionId
     *
     * @return string
     */
    public function getRealTransactionId($transactionId)
    {
        return $this->_transactionFactory->create()->load($transactionId)->getTxnId();
    }

    /**
     * get all transactions by order id
     * @param int $orderId
     *
     * @return string
     */
    public function getAllTransactionsOfOrder($orderId)
    {
        $transactions = [];
        $tranCollection = $this->_transactionFactory->create()->getCollection()->addFieldToFilter("order_id", ['eq' => $orderId]);

        if ($tranCollection->getSize() > 0) {
            foreach ($tranCollection as $tc) {
                $transactions[] = $tc->getTxnId();
            }
        }
        return $transactions;
    }

    /**
     * get all marketplace hold transactions
     *
     * @return Magento\Sales\Model\ResouceModel\Order\Payment\Collection
     */
    public function getTransactionList()
    {
        return $this->_transactionFactory->create()->getCollection()
        ->addFieldToFilter("is_closed", ['eq' => 0]);
    }

    /**
     * get transaction object
     *
     * @param string $txnId
     *
     * @return Magento\Sales\Model\Order\Payment\Transaction | bool
     */
    public function getTransactionByTxnId($txnId)
    {
        $collection = $this->_transactionFactory->create()->getCollection()
        ->addFieldToFilter("txn_id", ['eq' => $txnId]);
        if ($collection->getSize() > 0) {
            return $collection->getLastItem();
        } else {
            return false;
        }
    }

        /**
         * get cart data from payment additional info
         *
         * @param Magento\Sales\Model\Order\Payment $payment
         * @return array
         */
    public function getCartData($payment)
    {
        $additionalInfo = $payment->getAdditionalInformation();
        $cartData = [];
        foreach ($additionalInfo as $key => $info) {
            $data = explode("_cart_", $key);
            if (count($data) == 2) {
                if (is_numeric($data[1])) {
                    $cartData[$data[1]][$data[0]] = $info;
                }
            }
        }

        return $cartData;
    }

    /**
     * getIfSellerInCart function to check if seller present in the cart.
     *
     * @param array $paymentDetails
     *
     * @return bool true | false
     */
    public function getIfSellerInCart($paymentDetails = [])
    {
        if (count($paymentDetails) > 0) {
            foreach ($paymentDetails as $cart) {
                if (isset($cart['seller']) && $cart['seller']) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Get Order item array data to create invoice.
     *
     * @param $order
     * @param $items
     *
     * @return array
     */
    protected function _getItemQtys($order, $items)
    {
        $data = [];
        $subtotal = 0;
        $baseSubtotal = 0;
        foreach ($order->getAllItems() as $item) {
            if (in_array($item->getProductId(), $items)) {
                $data[$item->getItemId()] = intval(
                    $item->getQtyOrdered() - $item->getQtyInvoiced()
                );

                $_item = $item;

                // for bundle product
                $bundleitems = array_merge(
                    [$_item],
                    $_item->getChildrenItems()
                );

                if ($_item->getParentItem()) {
                    continue;
                }

                if ($_item->getProductType() == 'bundle') {
                    foreach ($bundleitems as $_bundleitem) {
                        if ($_bundleitem->getParentItem()) {
                            $data[$_bundleitem->getItemId()] = intval(
                                $_bundleitem->getQtyOrdered() - $item->getQtyInvoiced()
                            );
                        }
                    }
                }
                $subtotal += $_item->getRowTotal();
                $baseSubtotal += $_item->getBaseRowTotal();
            } else {
                if (!$item->getParentItemId()) {
                    $data[$item->getItemId()] = 0;
                }
            }
        }

        return [
            'data' => $data,
            'subtotal' => $subtotal,
            'baseSubtotal' => $baseSubtotal,
        ];
    }

    /**
     * pay amount to seller
     *
     * @param Magento\Sales\Model\Order $order
     * @param int $sellerId
     * @param string $transactionId
     * @return void
     */
    public function payToSeller($order, $sellerId, $transactionId)
    {
        if (is_numeric($order)) {
            $order = $this->_orderFactory->create()->load($order);
        }
        $this->marketplaceOrders->paysellerpayment($order, $sellerId, $transactionId);
    }
}
