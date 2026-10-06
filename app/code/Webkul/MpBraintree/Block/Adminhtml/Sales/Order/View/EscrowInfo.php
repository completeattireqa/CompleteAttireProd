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
namespace Webkul\MpBraintree\Block\Adminhtml\Sales\Order\View;

/**
 * escrow info block
 *
 * @author      Webkul
 */
class EscrowInfo extends \Magento\Backend\Block\Template implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * Sales data
     *
     * @var \Webkul\MpBraintree\Model\BraintreeOrderManagement
     */
    protected $_braintreeOrderManager = null;

    /**
     * @var \Webkul\MpBraintree\Model\Adapter\MpBraintreeAdapter
     */
    protected $adapter;

    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\Payment\Transaction\CollectionFactory
     */
    protected $transactions;

    /**
     * @var string
     */
    protected $_template = "Webkul_MpBraintree::sales/order/view/escrow_info.phtml";

    /**
     * constructor
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Webkul\MpBraintree\Api\BraintreeOrderManagementInterface $braintreeOrderManager,
        \Webkul\MpBraintree\Model\Adapter\MpBraintreeAdapter $adapter,
        \Magento\Sales\Model\ResourceModel\Order\Payment\Transaction\CollectionFactory $transactions,
        array $data = []
    ) {
        $this->_braintreeOrderManager = $braintreeOrderManager;
        $this->adapter = $adapter;
        $this->_coreRegistry = $registry;
        $this->transactions = $transactions;
        parent::__construct($context, $data);
    }

    /**
     * Preparing global layout
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }


    /**
     * Retrieve order model
     *
     * @return \Magento\Sales\Model\Order
     */
    public function getOrder()
    {
        return $this->_coreRegistry->registry('sales_order');
    }

    /**
     * release URL getter
     *
     * @return string
     */
    public function getReleaseUrl($transactionId)
    {
        return $this->getUrl(
            'mpbraintree/escrow/release',
            ['transaction_id' => $transactionId, 'order_id' => $this->getOrder()->getId()]
        );
    }

    /**
     * get all the transactions in the order
     *
     * @return array
     */
    public function getOrderTransactions()
    {
        try {
            $transactions = $this->transactions->create()->addFieldToFilter("order_id", ['eq' => $this->getOrder()->getId()]);
            return $transactions;
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    /**
     * check transaction escrow status
     *
     * @param string $transactionId
     * @return bool
     */
    public function checkEscrowStatus($transactionId)
    {
        try {
            $transaction = $this->adapter->findTransaction($transactionId);
            return $transaction->escrowStatus;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTabLabel()
    {
        return __('Escrow Info');
    }

    /**
     * {@inheritdoc}
     */
    public function getTabTitle()
    {
        return __('Order Invoices');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return $this->ifAnyTransactionIsInEscrow();
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    public function ifAnyTransactionIsInEscrow()
    {
        $transactions = $this->getOrderTransactions();

        if ($transactions->getSize() > 0) {
            foreach ($transactions as $transaction) {
                $transactionEscrowStatus = $this->checkEscrowStatus($transaction->getTxnId());
                if ($transactionEscrowStatus) {
                    return true;
                }
            }
        }
        return false;
    }
}
