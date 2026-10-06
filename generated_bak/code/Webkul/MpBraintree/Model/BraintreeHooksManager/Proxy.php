<?php
namespace Webkul\MpBraintree\Model\BraintreeHooksManager;

/**
 * Proxy class for @see \Webkul\MpBraintree\Model\BraintreeHooksManager
 */
class Proxy extends \Webkul\MpBraintree\Model\BraintreeHooksManager implements \Magento\Framework\ObjectManager\NoninterceptableInterface
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
     * @var \Webkul\MpBraintree\Model\BraintreeHooksManager
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
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager, $instanceName = '\\Webkul\\MpBraintree\\Model\\BraintreeHooksManager', $shared = true)
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
     * @return \Webkul\MpBraintree\Model\BraintreeHooksManager
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
    public function parseHooksData($post)
    {
        return $this->_getSubject()->parseHooksData($post);
    }

    /**
     * {@inheritdoc}
     */
    public function subMerchantApprovedHandler()
    {
        return $this->_getSubject()->subMerchantApprovedHandler();
    }

    /**
     * {@inheritdoc}
     */
    public function subMerchantDeclinedHandler()
    {
        return $this->_getSubject()->subMerchantDeclinedHandler();
    }

    /**
     * {@inheritdoc}
     */
    public function disbursementExceptionHandler()
    {
        return $this->_getSubject()->disbursementExceptionHandler();
    }

    /**
     * {@inheritdoc}
     */
    public function disbursementHandler()
    {
        return $this->_getSubject()->disbursementHandler();
    }

    /**
     * {@inheritdoc}
     */
    public function transactionDisbursementHandler()
    {
        return $this->_getSubject()->transactionDisbursementHandler();
    }

    /**
     * {@inheritdoc}
     */
    public function disputeOpenHandler()
    {
        return $this->_getSubject()->disputeOpenHandler();
    }

    /**
     * {@inheritdoc}
     */
    public function disputeWonHandler()
    {
        return $this->_getSubject()->disputeWonHandler();
    }

    /**
     * {@inheritdoc}
     */
    public function disputeLostHandler()
    {
        return $this->_getSubject()->disputeLostHandler();
    }

    /**
     * {@inheritdoc}
     */
    public function updateSubmerchantStatus($customer, $status)
    {
        return $this->_getSubject()->updateSubmerchantStatus($customer, $status);
    }

    /**
     * {@inheritdoc}
     */
    public function disableSeller($sellerId)
    {
        return $this->_getSubject()->disableSeller($sellerId);
    }

    /**
     * {@inheritdoc}
     */
    public function disableSellerProducts($sellerId)
    {
        return $this->_getSubject()->disableSellerProducts($sellerId);
    }

    /**
     * {@inheritdoc}
     */
    public function getSellerProductData($sellerId)
    {
        return $this->_getSubject()->getSellerProductData($sellerId);
    }

    /**
     * {@inheritdoc}
     */
    public function checkIfAssociate($productId)
    {
        return $this->_getSubject()->checkIfAssociate($productId);
    }
}
