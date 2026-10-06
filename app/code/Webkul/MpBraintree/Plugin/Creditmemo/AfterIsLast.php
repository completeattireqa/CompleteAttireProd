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

namespace Webkul\MpBraintree\Plugin\Creditmemo;

class AfterIsLast
{
   
    public function afterIsLast(\Magento\Sales\Model\Order\Creditmemo $subject, $result)
    {
        if ($subject->getOrder()->getPayment()->getMethod() == 'mpbraintree') {
            return false;
        }
        return $result;
    }
}
