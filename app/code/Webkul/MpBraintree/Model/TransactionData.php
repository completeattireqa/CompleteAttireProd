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

use Webkul\MpBraintree\Logger\BraintreeLogger as Logger;

class TransactionData
{
    const TRANSACTION_ID = "id";

    const TRANSACTION_STATUS = "status";

    const CURRENCY = "currencyIsoCode";

    const MERCHANT_ID = "merchantAccountId";

    const SUB_MERCHANT_ID = "subMerchantAccountId";

    const MARTER_MERCHANT_ID = "masterMerchantAccountId";

    const ESCROW_STATUS = "escrowStatus";

    const CUSTOMER = "customer";

    const BILLING = "billing";

    const SHIPPING = "shipping";

    const CREDIT_CARD = "creditCard";

    const TRANSACTION_ARRAY = [
        self::TRANSACTION_ID,
        self::TRANSACTION_STATUS,
        self::CURRENCY,
        self::MERCHANT_ID,
        self::MARTER_MERCHANT_ID,
        self::SUB_MERCHANT_ID,
        self::ESCROW_STATUS,
        self::CUSTOMER,
        self::BILLING,
        self::SHIPPING,
        self::CREDIT_CARD
    ];

    /**
     * @var \Magento\Sales\Model\Order\Payment\TransactionFactory
     */
    protected $transactionFactory;

    /**
     * @var Webkul\MpBraintree\Model\Adapter\MpBraintreeAdapter
     */
    protected $adapter;

    public function __construct(
        \Magento\Sales\Model\Order\Payment\TransactionFactory $transactionFactory,
        \Webkul\MpBraintree\Model\Adapter\MpBraintreeAdapter $adapter,
        Logger $logger
    ) {
        $this->transactionFactory = $transactionFactory;
        $this->adapter = $adapter;
        $this->_logger = $logger;
    }

    /**
     * set transaction data
     *
     * @param int $transactionId
     * @return void
     */
    public function setTransactionData($transactionId = 0)
    {
        if ($transactionId) {
            $this->_logger->critical("update transaction AI for id: ".$transactionId);
            $transaction = $this->transactionFactory->create()->load($transactionId);
            $braintreeData = $this->setBraintreeData($transaction);
        }
    }

    /**
     * get braintree transaction data
     *
     * @param  string $txnId
     * @return array
     */
    public function setBraintreeData($transaction)
    {
        $txnId = $transaction->getTxnId();
        $braintreeTransaction = $this->adapter->findTransaction($txnId);
        $this->_logger->critical("update real transaction AI for id: ".$txnId);
        if ($braintreeTransaction->id) {
            $transactionData = [];
            foreach (self::TRANSACTION_ARRAY as $item) {
                if (is_array($braintreeTransaction->$item)) {
                    $tData = \Zend\Json\Json::encode($braintreeTransaction->$item, true);
                    $transactionData[$item] = $tData;
                } else {
                    $transactionData[$item] = $braintreeTransaction->$item;
                }
            }
            $oldTransactionDetails = $transaction->getAdditionalInformation(\Magento\Sales\Model\Order\Payment\Transaction::RAW_DETAILS);
            $updateTransData = array_merge($oldTransactionDetails, $transactionData);
            $this->_logger->critical("update real transaction AI for id: ".$txnId, $updateTransData);
            $transaction->setAdditionalInformation(\Magento\Sales\Model\Order\Payment\Transaction::RAW_DETAILS, $updateTransData);
            $transaction->save();
        }
    }
}
