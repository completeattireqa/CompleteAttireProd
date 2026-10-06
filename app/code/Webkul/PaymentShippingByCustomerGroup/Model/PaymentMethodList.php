<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_PaymentShippingByCustomerGroup
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\PaymentShippingByCustomerGroup\Model;

use Magento\Payment\Api\Data\PaymentMethodInterface;

class PaymentMethodList extends \Magento\Payment\Model\PaymentMethodList
{
    /**
     * @param \Magento\Payment\Api\Data\PaymentMethodInterfaceFactory $methodFactory
     * @param \Magento\Payment\Helper\Data $helper
     * @param \Webkul\PaymentShippingByCustomerGroup\Helper\Data $wkhelper
     */
    public function __construct(
        \Magento\Payment\Api\Data\PaymentMethodInterfaceFactory $methodFactory,
        \Magento\Payment\Helper\Data $helper,
        \Webkul\PaymentShippingByCustomerGroup\Helper\Data $wkhelper
    ) {
        parent::__construct($methodFactory, $helper);
        $this->wkhelper = $wkhelper;
    }

    /**
     * Returns active payments list
     *
     * @param int $storeId
     * @return array
     */
    public function getActiveList($storeId)
    {
        $methodList = array_filter(
            $this->getList($storeId),
            function (PaymentMethodInterface $method) {
                return $method->getIsActive();
            }
        );

        if ($this->wkhelper->isModuleEnable()) {
            $methodList = $this->wkhelper->getApplicablePayments($methodList);
        }

        return array_values($methodList);
    }
}
