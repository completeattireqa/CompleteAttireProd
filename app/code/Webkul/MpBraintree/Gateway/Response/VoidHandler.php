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
namespace Webkul\MpBraintree\Gateway\Response;

use Magento\Sales\Model\Order\Payment;

class VoidHandler extends TransactionIdHandler
{
    /**
     * @param Payment $orderPayment
     * @param \Braintree\Transaction $transaction
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function setTransactionId(Payment $orderPayment, \Braintree\Transaction $transaction)
    {
        return;
    }

    /**
     * Whether transaction should be closed
     *
     * @return bool
     */
    protected function shouldCloseTransaction()
    {
        return true;
    }

    /**
     * Whether parent transaction should be closed
     *
     * @param Payment $orderPayment
     * @return bool
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function shouldCloseParentTransaction(Payment $orderPayment)
    {
        return true;
    }
}
