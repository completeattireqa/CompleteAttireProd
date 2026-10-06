<?php
namespace Webkul\MpBraintree\Model\BraintreeOrderManagement;

/**
 * Proxy class for @see \Webkul\MpBraintree\Model\BraintreeOrderManagement
 */
class Proxy extends \Webkul\MpBraintree\Model\BraintreeOrderManagement implements \Magento\Framework\ObjectManager\NoninterceptableInterface
{
    /**
     * Object Manager instance
     *
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager = null;

    /**
     * Proxied instance name
     *
     * @var string
     */
    protected $_instanceName = null;

    /**
     * Proxied instance
     *
     * @var \Webkul\MpBraintree\Model\BraintreeOrderManagement
     */
    protected $_subject = null;

    /**
     * Instance shareability flag
     *
     * @var bool
     */
    protected $_isShared = null;

    /**
     * Proxy constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param string $instanceName
     * @param bool $shared
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Webkul\\MpBraintree\\Model\\BraintreeOrderManagement', $shared = true)
    {
        $this->_objectManager = $objectManager;
        $this->_instanceName = $instanceName;
        $this->_isShared = $shared;
    }

    /**
     * @return array
     */
    public function __sleep()
    {
        return ['_subject', '_isShared', '_instanceName'];
    }

    /**
     * Retrieve ObjectManager from global scope
     */
    public function __wakeup()
    {
        $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    }

    /**
     * Clone proxied instance
     */
    public function __clone()
    {
        $this->_subject = clone $this->_getSubject();
    }

    /**
     * Get proxied instance
     *
     * @return \Webkul\MpBraintree\Model\BraintreeOrderManagement
     */
    protected function _getSubject()
    {
        if (!$this->_subject) {
            $this->_subject = true === $this->_isShared
                ? $this->_objectManager->get($this->_instanceName)
                : $this->_objectManager->create($this->_instanceName);
        }
        return $this->_subject;
    }

    /**
     * {@inheritdoc}
     */
    public function doCompleteOrderInvoice($order, $sellerData)
    {
        return $this->_getSubject()->doCompleteOrderInvoice($order, $sellerData);
    }

    /**
     * {@inheritdoc}
     */
    public function doSellerOrderInvoice($order, $sellerData, $transactionId)
    {
        return $this->_getSubject()->doSellerOrderInvoice($order, $sellerData, $transactionId);
    }

    /**
     * {@inheritdoc}
     */
    public function doTransaction($order, $sellerData)
    {
        return $this->_getSubject()->doTransaction($order, $sellerData);
    }

    /**
     * {@inheritdoc}
     */
    public function doVoid($transactioId)
    {
        return $this->_getSubject()->doVoid($transactioId);
    }

    /**
     * {@inheritdoc}
     */
    public function cancelOrder($order)
    {
        return $this->_getSubject()->cancelOrder($order);
    }

    /**
     * {@inheritdoc}
     */
    public function cancelSellerWiseItems($order, $sellerData)
    {
        return $this->_getSubject()->cancelSellerWiseItems($order, $sellerData);
    }

    /**
     * {@inheritdoc}
     */
    public function cancelOrderItems($order, $sellerData)
    {
        return $this->_getSubject()->cancelOrderItems($order, $sellerData);
    }

    /**
     * {@inheritdoc}
     */
    public function canInvoice($order)
    {
        return $this->_getSubject()->canInvoice($order);
    }

    /**
     * {@inheritdoc}
     */
    public function canVoid($order = null)
    {
        return $this->_getSubject()->canVoid($order);
    }

    /**
     * {@inheritdoc}
     */
    public function canEscrow($order = null)
    {
        return $this->_getSubject()->canEscrow($order);
    }

    /**
     * {@inheritdoc}
     */
    public function escrowStatus($transactionId)
    {
        return $this->_getSubject()->escrowStatus($transactionId);
    }

    /**
     * {@inheritdoc}
     */
    public function transactionStatus($transactionId)
    {
        return $this->_getSubject()->transactionStatus($transactionId);
    }

    /**
     * {@inheritdoc}
     */
    public function canEscrowTransaction($transactionId)
    {
        return $this->_getSubject()->canEscrowTransaction($transactionId);
    }

    /**
     * {@inheritdoc}
     */
    public function holdInEscrow($transactionId)
    {
        return $this->_getSubject()->holdInEscrow($transactionId);
    }

    /**
     * {@inheritdoc}
     */
    public function validateOrder($order)
    {
        return $this->_getSubject()->validateOrder($order);
    }

    /**
     * {@inheritdoc}
     */
    public function getTransactionId($payment, $charge)
    {
        return $this->_getSubject()->getTransactionId($payment, $charge);
    }

    /**
     * {@inheritdoc}
     */
    public function getSellerFromTransactionId($transactionId, $order)
    {
        return $this->_getSubject()->getSellerFromTransactionId($transactionId, $order);
    }

    /**
     * {@inheritdoc}
     */
    public function getRealTransactionId($transactionId)
    {
        return $this->_getSubject()->getRealTransactionId($transactionId);
    }

    /**
     * {@inheritdoc}
     */
    public function getAllTransactionsOfOrder($orderId)
    {
        return $this->_getSubject()->getAllTransactionsOfOrder($orderId);
    }

    /**
     * {@inheritdoc}
     */
    public function getTransactionList()
    {
        return $this->_getSubject()->getTransactionList();
    }

    /**
     * {@inheritdoc}
     */
    public function getTransactionByTxnId($txnId)
    {
        return $this->_getSubject()->getTransactionByTxnId($txnId);
    }

    /**
     * {@inheritdoc}
     */
    public function getCartData($payment)
    {
        return $this->_getSubject()->getCartData($payment);
    }

    /**
     * {@inheritdoc}
     */
    public function getIfSellerInCart($paymentDetails = array())
    {
        return $this->_getSubject()->getIfSellerInCart($paymentDetails);
    }

    /**
     * {@inheritdoc}
     */
    public function payToSeller($order, $sellerId, $transactionId)
    {
        return $this->_getSubject()->payToSeller($order, $sellerId, $transactionId);
    }
}
