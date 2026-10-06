<?php
/**
 * Webkul Software
 *
 * @category  Webkul
 * @package   Webkul_Blog
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\Blog\Model;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * CategoryStatus Class
 */
class CategoryStatus implements OptionSourceInterface
{
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [
                        [
                            'label' => __('Disable'),
                            'value' => 0
                        ],
                        [
                            'label' => __('Enable'),
                            'value' => 1
                        ]
                    ];
        return $options;
    }
}
