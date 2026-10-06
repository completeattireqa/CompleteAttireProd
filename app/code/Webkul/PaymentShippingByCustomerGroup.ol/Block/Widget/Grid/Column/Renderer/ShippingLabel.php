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

namespace Webkul\PaymentShippingByCustomerGroup\Block\Widget\Grid\Column\Renderer;

use Webkul\PaymentShippingByCustomerGroup\Model\Config\Source\ActiveShippings;

class ShippingLabel extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{
    /**
     * @param \Magento\Backend\Block\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Context $context,
        ActiveShippings $activeShippings,
        array $data = []
    ) {
        $this->activeShippings = $activeShippings;
        parent::__construct($context, $data);
    }

    /**
     * Renders grid column
     *
     * @param   \Magento\Framework\DataObject $row
     * @return  string
     */
    public function render(\Magento\Framework\DataObject $row)
    {
        $rows = $row->getData();
        if (isset($rows['shipping_methods'])) {
            $options = $this->activeShippings->toOptionArray();
            $shippings = explode(",", $rows['shipping_methods']);
            unset($rows);
            foreach ($options as $option) {
                $optionArray[] = $option['value'];
            }
            foreach ($shippings as $key => $shipping) {
                if (!in_array($shipping, $optionArray)) {
                    unset($shippings[$key]);
                } else {
                    $rows[] = $options[$shipping]['label'];
                }
            }
            $rows =  implode(",", $rows);
            $row->setShippingMethods($rows);
        }
        return $this->_getValue($row);
    }
}
