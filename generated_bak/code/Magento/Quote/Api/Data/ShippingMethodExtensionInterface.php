<?php
namespace Magento\Quote\Api\Data;

/**
 * ExtensionInterface class for @see \Magento\Quote\Api\Data\ShippingMethodInterface
 */
interface ShippingMethodExtensionInterface extends \Magento\Framework\Api\ExtensionAttributesInterface
{
    /**
     * @return string|null
     */
    public function getDeliveryTime();

    /**
     * @param string $deliveryTime
     * @return $this
     */
    public function setDeliveryTime($deliveryTime);

    /**
     * @return string|null
     */
    public function getDeliveryMessage();

    /**
     * @param string $deliveryMessage
     * @return $this
     */
    public function setDeliveryMessage($deliveryMessage);
}
