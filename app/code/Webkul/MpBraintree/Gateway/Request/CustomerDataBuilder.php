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

use Magento\Payment\Gateway\Request\BuilderInterface;
use Webkul\MpBraintree\Gateway\Helper\SubjectReader;

/**
 * Class CustomerDataBuilder
 */
class CustomerDataBuilder implements BuilderInterface
{
    /**
     * Customer block name
     */
    const CUSTOMER = 'customer';

    /**
     * The customer’s company. 255 character maximum.
     */
    const COMPANY = 'company';

    /**
     * The customer’s email address, comprised of ASCII characters.
     */
    const EMAIL = 'email';

    /**
     * The first name value must be less than or equal to 255 characters.
     */
    const FIRST_NAME = 'firstName';

    /**
     * The last name value must be less than or equal to 255 characters.
     */
    const LAST_NAME = 'lastName';

    /**
     * Phone number. Phone must be 10-14 characters and can
     * only contain numbers, dashes, parentheses and periods.
     */
    const PHONE = 'phone';

    /**
     * @var SubjectReader
     */
    private $mpBraintreeSubjectReader;

    /**
     * Constructor
     *
     * @param SubjectReader $mpBraintreeSubjectReader
     */
    public function __construct(SubjectReader $mpBraintreeSubjectReader)
    {
        $this->mpBraintreeSubjectReader = $mpBraintreeSubjectReader;
    }

    /**
     * @inheritdoc
     */
    public function build(array $buildSubject)
    {
        $paymentDO = $this->mpBraintreeSubjectReader->readPayment($buildSubject);

        $order = $paymentDO->getOrder();
        $billingAddress = $order->getBillingAddress();

        return [
            self::CUSTOMER => [
                self::FIRST_NAME => $billingAddress->getFirstname(),
                self::LAST_NAME => $billingAddress->getLastname(),
                self::COMPANY => $billingAddress->getCompany(),
                self::PHONE => $billingAddress->getTelephone(),
                self::EMAIL => $billingAddress->getEmail(),
            ]
        ];
    }
}
