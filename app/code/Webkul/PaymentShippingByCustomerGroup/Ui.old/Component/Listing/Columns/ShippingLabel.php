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
namespace Webkul\PaymentShippingByCustomerGroup\Ui\Component\Listing\Columns;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Webkul\PaymentShippingByCustomerGroup\Model\Config\Source\ActiveShippings;

class ShippingLabel extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        ActiveShippings $activeShippings,
        array $components = [],
        array $data = []
    ) {
        $this->activeShippings = $activeShippings;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $options = $this->activeShippings->toOptionArray();
            foreach ($options as $option) {
                $optionArray[] = $option['value'];
            }
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item[$fieldName])) {
                    $shippings = explode(",", $item[$fieldName]);
                    foreach ($shippings as $key => $shipping) {
                        if (!in_array($shipping, $optionArray)) {
                            unset($shippings[$key]);
                        } else {
                            $shippings[$key] = $options[$shipping]['label']->getText();
                        }
                    }
                    $item[$fieldName] =  implode(",", $shippings);
                }
            }
        }
        return $dataSource;
    }
}
