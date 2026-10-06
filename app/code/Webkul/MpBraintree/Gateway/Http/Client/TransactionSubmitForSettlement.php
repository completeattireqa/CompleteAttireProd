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
namespace Webkul\MpBraintree\Gateway\Http\Client;

use Webkul\MpBraintree\Gateway\Request\CaptureDataBuilder;
use Webkul\MpBraintree\Gateway\Request\PaymentDataBuilder;

/**
 * Class TransactionSubmitForSettlement
 */
class TransactionSubmitForSettlement extends AbstractTransaction
{
    /**
     * @inheritdoc
     */
    protected function process(array $data)
    {
        return  $this->adapter->submitForSettlement(
            $data[CaptureDataBuilder::TRANSACTION_ID],
            $data['amount']
        );
    }
}
