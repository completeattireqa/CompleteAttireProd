<?php
namespace Magento\Customer\Api\Data;

/**
 * Extension class for @see \Magento\Customer\Api\Data\GroupInterface
 */
class GroupExtension extends \Magento\Framework\Api\AbstractSimpleObject implements GroupExtensionInterface
{
    /**
     * @return string|null
     */
    public function getShippingMethods()
    {
        return $this->_get('shipping_methods');
    }

    /**
     * @param string $shippingMethods
     * @return $this
     */
    public function setShippingMethods($shippingMethods)
    {
        $this->setData('shipping_methods', $shippingMethods);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPaymentMethods()
    {
        return $this->_get('payment_methods');
    }

    /**
     * @param string $paymentMethods
     * @return $this
     */
    public function setPaymentMethods($paymentMethods)
    {
        $this->setData('payment_methods', $paymentMethods);
        return $this;
    }
}
