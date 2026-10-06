<?php
/**
 * Webkul Software
 *
 * @category    Webkul
 * @package     Webkul_EmailUnsubscribe
 * @author      Webkul
 * @copyright   Copyright (c)  Webkul Software Private Limited (https://webkul.com)
 * @license     https://store.webkul.com/license.html
 */

namespace Webkul\EmailUnsubscribe\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class QueryStatus for the reply form on the admin side.
 */
class Status implements OptionSourceInterface
{
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options[] = [
            'label' => __('Disabled'),
            'value' => 0,
        ];
        $options[] = [
            'label' => __('Enabled'),
            'value' => 1,
        ];
        return $options;
    }
}
