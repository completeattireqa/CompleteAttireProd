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

/**
 * Class TransactionSale
 */
class TransactionSale extends AbstractTransaction
{
    /**
     * @inheritdoc
     */
    protected function process(array $data)
    {
        $paymentData = $data['seller'];
        // print_r($paymentData);die;
        $result = [];
        foreach ($paymentData as $payment) {
            $result[] = $this->adapter->sale($payment);
        }
        $obj = new \Magento\Framework\DataObject();
        $obj->setItem($result);
        return  $obj;
    }
}
