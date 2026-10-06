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
namespace Webkul\MpBraintree\Gateway\Response;

use Braintree\Transaction;
use Webkul\MpBraintree\Observer\DataAssignObserver;
use Magento\Payment\Gateway\Helper\ContextHelper;
use Webkul\MpBraintree\Gateway\Helper\SubjectReader;
use Magento\Payment\Gateway\Response\HandlerInterface;
use Magento\Sales\Api\Data\OrderPaymentInterface;

/**
 * Payment Details Handler
 */
class PaymentDetailsHandler implements HandlerInterface
{
    const AVS_POSTAL_RESPONSE_CODE = 'avsPostalCodeResponseCode';

    const AVS_STREET_ADDRESS_RESPONSE_CODE = 'avsStreetAddressResponseCode';

    const CVV_RESPONSE_CODE = 'cvvResponseCode';

    const PROCESSOR_AUTHORIZATION_CODE = 'processorAuthorizationCode';

    const PROCESSOR_RESPONSE_CODE = 'processorResponseCode';

    const PROCESSOR_RESPONSE_TEXT = 'processorResponseText';

    const TRANSACTION_ID = 'id';

    const SUB_MERCHANT_ID = 'subMerchantAccountId';

    const SELLER_ID = 'sellerId';

    /**
     * List of additional details
     * @var array
     */
    protected $additionalInformationMapping = [
        self::AVS_POSTAL_RESPONSE_CODE,
        self::AVS_STREET_ADDRESS_RESPONSE_CODE,
        self::CVV_RESPONSE_CODE,
        self::PROCESSOR_AUTHORIZATION_CODE,
        self::PROCESSOR_RESPONSE_CODE,
        self::PROCESSOR_RESPONSE_TEXT,
        self::TRANSACTION_ID,
        self::SUB_MERCHANT_ID,
        self::SELLER_ID

    ];

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
    public function handle(array $handlingSubject, array $response)
    {
        $paymentDO = $this->subjectReader->readPayment($handlingSubject);
        /** @var \Braintree\Transaction $transaction */
        $transactions = $this->subjectReader->readTransaction($response);
        /** @var OrderPaymentInterface $payment */
        $payment = $paymentDO->getPayment();

        //remove previously set payment nonce
        $payment->unsAdditionalInformation(DataAssignObserver::PAYMENT_METHOD_NONCE);

        foreach ($transactions as $key => $transaction) {
            foreach ($this->additionalInformationMapping as $item) {
                if (!isset($transaction->$item)) {
                    continue;
                }
                $payment->setAdditionalInformation($item.'_seller_'.$key, $transaction->$item);
            }
        }
    }
}
