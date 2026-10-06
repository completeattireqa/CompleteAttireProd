<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_Mpsellercredits
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\MpBraintree\Gateway\Validator;

use Braintree\Result\Error;
use Braintree\Result\Successful;
use Braintree\Transaction;
use Magento\Payment\Gateway\Validator\ResultInterfaceFactory;

/**
 * Class ResponseValidator
 */
class ResponseValidator extends GeneralResponseValidator
{
    /**
     * @return array
     */
    protected function getResponseValidators()
    {
        return array_merge(
            parent::getResponseValidators(),
            [
                function ($response) {
                    return [
                        $response instanceof Successful
                        && isset($response->transaction)
                        && in_array(
                            $response->transaction->status,
                            [Transaction::AUTHORIZED, Transaction::SUBMITTED_FOR_SETTLEMENT, Transaction::SETTLING]
                        ),
                        [__('Wrong transaction status')]
                    ];
                }
            ]
        );
    }
}
