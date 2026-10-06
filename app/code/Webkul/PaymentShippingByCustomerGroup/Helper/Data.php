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
namespace Webkul\PaymentShippingByCustomerGroup\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @param \Magento\Customer\Model\Session $session
     * @param \Magento\Backend\Model\Auth\Session $authSession
     * @param \Magento\Customer\Model\GroupFactory $customerGroup
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Customer\Model\Session $session,
        \Magento\Backend\Model\Auth\Session $authSession,
        \Magento\Customer\Model\GroupFactory $customerGroup,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->session = $session;
        $this->authSession = $authSession;
        $this->customerGroup = $customerGroup;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Filter shippings on basis of customer group
     *
     * @param array $carrier
     * @return array
     */
    public function getApplicableShippings($carrier)
    {
        if ($this->authSession->getUser()) {
            return $carrier;
        }
        $str="webkul_paymentshippingbycustomergroup/webkul_paymentshippingbycustomergroup_shippings";
        $filteredCarriers = [];
        $groupId = $this->session->getCustomerGroupId();
        $group = $this->customerGroup->create()->load($groupId);
        if (!empty($group->getShippingMethods())) {
            $shippingMethods = $group->getShippingMethods();
        } else {
            $asshipping = $this->scopeConfig->getValue($str.'/allowspecific');
            if ($asshipping) {
                $methodshipping = $this->scopeConfig->getValue($str.'/specificcountry');
                $shippingMethods = $methodshipping;
            } else {
                return $carrier;
            }
        }
        $applicableShippings = explode(",", $shippingMethods);
        foreach ($applicableShippings as $applicableShipping) {
            $filteredCarriers[$applicableShipping] = $carrier[$applicableShipping];
        }

        return $filteredCarriers;
    }

    /**
     * Filter shippings on basis of customer group
     *
     * @param array $methodList
     * @return array
     */
    public function getApplicablePayments($methodList)
    {
        if ($this->authSession->getUser()) {
            return $methodList;
        }
        $filteredPayments = [];
        $i = 0;
        $str = "webkul_paymentshippingbycustomergroup/webkul_paymentshippingbycustomergroup_payments";
        $groupId = $this->session->getCustomerGroupId();
        $group = $this->customerGroup->create()->load($groupId);
        if (!empty($group->getPaymentMethods())) {
            $paymentMethods = $group->getPaymentMethods();
        } else {
            $aspayment = $this->scopeConfig->getValue($str.'/allowspecific');
            if ($aspayment) {
                $methodpayment = $this->scopeConfig->getValue($str.'/specificcountry');
                $paymentMethods = $methodpayment;
            } else {
                return $methodList;
            }
        }
        $applicablePayments = explode(",", $paymentMethods);
        foreach ($applicablePayments as $applicablePayment) {
            foreach ($methodList as $method) {
                if ($method->getCode() == $applicablePayment) {
                    $filteredPayments[$i++] = $method;
                }
            }
        }

        return $filteredPayments;
    }

    /**
     * Checks if module enable
     *
     * @return int
     */
    public function isModuleEnable()
    {
        $str="webkul_paymentshippingbycustomergroup/webkul_paymentshippingbycustomergroup_settings";
        return $this->scopeConfig->getValue($str.'/enable_disable_paymentshippingbycustomergroup');
    }
}
