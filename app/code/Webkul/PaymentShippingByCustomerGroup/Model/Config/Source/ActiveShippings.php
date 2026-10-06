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
namespace Webkul\PaymentShippingByCustomerGroup\Model\Config\Source;

use \Magento\Framework\App\Config\ScopeConfigInterface;

class ActiveShippings implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @param ScopeConfigInterface $appConfigScopeConfigInterface
     * @param \Magento\Shipping\Model\Config $config
     */
    public function __construct(
        ScopeConfigInterface $appConfigScopeConfigInterface,
        \Magento\Shipping\Model\Config $config
    ) {
        $this->config = $config;
        $this->_appConfigScopeConfigInterface = $appConfigScopeConfigInterface;
    }

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        $options = [];
        foreach ($this->config->getActiveCarriers() as $active) {
            $shippingTitle = $this->_appConfigScopeConfigInterface->getValue('carriers/'.$active->getId().'/title');
            $options[$active->getId()] = [
                'label' => __($shippingTitle),
                'value' => $active->getId()
            ];
        }

        return $options;
    }
}
