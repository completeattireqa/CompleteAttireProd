<?php
namespace Magento\Customer\Api\Data;

/**
 * ExtensionInterface class for @see \Magento\Customer\Api\Data\GroupInterface
 */
interface GroupExtensionInterface extends \Magento\Framework\Api\ExtensionAttributesInterface
{
    /**
     * @return string|null
     */
    public function getShippingMethods();

    /**
     * @param string $shippingMethods
     * @return $this
     */
    public function setShippingMethods($shippingMethods);

    /**
     * @return string|null
     */
    public function getPaymentMethods();

    /**
     * @param string $paymentMethods
     * @return $this
     */
    public function setPaymentMethods($paymentMethods);
}
