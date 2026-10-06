<?php
namespace Magento\Quote\Api\Data;

/**
 * Extension class for @see \Magento\Quote\Api\Data\ShippingMethodInterface
 */
class ShippingMethodExtension extends \Magento\Framework\Api\AbstractSimpleObject implements ShippingMethodExtensionInterface
{
    /**
     * @return string|null
     */
    public function getDeliveryTime()
    {
        return $this->_get('delivery_time');
    }

    /**
     * @param string $deliveryTime
     * @return $this
     */
    public function setDeliveryTime($deliveryTime)
    {
        $this->setData('delivery_time', $deliveryTime);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeliveryMessage()
    {
        return $this->_get('delivery_message');
    }

    /**
     * @param string $deliveryMessage
     * @return $this
     */
    public function setDeliveryMessage($deliveryMessage)
    {
        $this->setData('delivery_message', $deliveryMessage);
        return $this;
    }
}
