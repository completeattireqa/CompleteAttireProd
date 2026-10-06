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
namespace Webkul\MpBraintree\Gateway\Request;

use Webkul\MpBraintree\Gateway\Helper\SubjectReader;
use Magento\Payment\Gateway\Request\BuilderInterface;
use Magento\Payment\Helper\Formatter;
use Magento\Sales\Api\Data\TransactionInterface;
use Magento\Sales\Model\Order\Payment;
use Webkul\MpBraintree\Model\BraintreeOrderManagement;

class RefundDataBuilder implements BuilderInterface
{
    use Formatter;

    /**
     * @var SubjectReader
     */
    private $subjectReader;

    /**
     * @var BraintreeOrderManagement
     */
    protected $_braintreeOrderManager;

    /**
     * Constructor
     *
     * @param SubjectReader $subjectReader
     */
    public function __construct(SubjectReader $subjectReader, BraintreeOrderManagement $braintreeOrderManager)
    {
        $this->subjectReader = $subjectReader;
        $this->_braintreeOrderManager = $braintreeOrderManager;
    }

    /**
     * Builds ENV request
     *
     * @param array $buildSubject
     * @return array
     */
    public function build(array $buildSubject)
    {
        $paymentDO = $this->subjectReader->readPayment($buildSubject);

        /** @var Payment $payment */
        $payment = $paymentDO->getPayment();
        $amount = null;
        try {
            $amount = $this->formatPrice($this->subjectReader->readAmount($buildSubject));
        } catch (\InvalidArgumentException $e) {
            // pass
        }

        /*
         * we should remember that Payment sets Capture txn id of current Invoice into ParentTransactionId Field
         * We should also support previous implementations of Magento Braintree -
         * and cut off '-capture' postfix from transaction ID to support backward compatibility
         */
        $txnId = str_replace(
            '-' . TransactionInterface::TYPE_CAPTURE,
            '',
            $payment->getRefundTransactionId()
        );
        
        return [
            'transaction_id' => $txnId,
            PaymentDataBuilder::AMOUNT => $amount
        ];
    }
}
