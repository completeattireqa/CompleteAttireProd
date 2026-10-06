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
namespace Webkul\MpBraintree\Gateway\Http\Client;

use Magento\Braintree\Gateway\Request\PaymentDataBuilder;

class TransactionRefund extends AbstractTransaction
{
    /**
     * Process http request
     * @param array $data
     * @return \Braintree\Result\Error|\Braintree\Result\Successful
     */
    protected function process(array $data)
    {
        $transactionCanRefund = $this->adapter->findTransaction($data['transaction_id']);
        $transaction = $this->adapter->findTransaction($data['transaction_id']);
        if ($transactionCanRefund && $transactionCanRefund->status == \Braintree\Transaction::SETTLED) {
            if ($transaction->amount <= $data['amount']) {
                return $this->adapter->refund(
                    $data['transaction_id']
                );
            } else {
                return $this->adapter->refund(
                    $data['transaction_id'],
                    $data['amount']
                );
            }
        } else {
            if ($transaction->amount == $data['amount']) {
                return $this->adapter->void(
                    $data['transaction_id']
                );
            } else {
                throw new \Exception(__("cannot refund transaction currently, please try again later."));
            }
        }
    }
}
