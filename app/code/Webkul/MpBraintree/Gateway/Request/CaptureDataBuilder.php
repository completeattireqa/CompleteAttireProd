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

use Magento\Framework\Exception\LocalizedException;
use Webkul\MpBraintree\Gateway\Helper\SubjectReader;
use Magento\Payment\Gateway\Request\BuilderInterface;
use Magento\Payment\Helper\Formatter;

/**
 * Class CaptureDataBuilder
 */
class CaptureDataBuilder implements BuilderInterface
{
    use Formatter;

    const TRANSACTION_ID = 'transaction_id';

    /**
     * @var SubjectReader
     */
    private $subjectReader;

    /**
     * Constructor
     *
     * @param SubjectReader $subjectReader
     */
    public function __construct(SubjectReader $subjectReader)
    {
        $this->subjectReader = $subjectReader;
    }

    /**
     * @inheritdoc
     */
    public function build(array $buildSubject)
    {
        $paymentDO = $this->subjectReader->readPayment($buildSubject);

        $payment = $paymentDO->getPayment();

        $transactionId = $payment->getLastTransId();
        if (!$transactionId) {
            throw new LocalizedException(__('No authorization transaction to proceed capture.'));
        }

        return [
            self::TRANSACTION_ID => $transactionId,
            PaymentDataBuilder::AMOUNT => $this->formatPrice($this->subjectReader->readAmount($buildSubject))
        ];
    }
}
