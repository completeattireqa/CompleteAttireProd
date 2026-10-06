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
 * BlogCustomerStatus Class
 */
class BlogCustomerStatus implements OptionSourceInterface
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
                            'label' => __('Is Not Permitted'),
                            'value' => 0
                        ],
                        [
                            'label' => __('Is Permitted'),
                            'value' => 1
                        ]
                    ];
        return $options;
    }
}
