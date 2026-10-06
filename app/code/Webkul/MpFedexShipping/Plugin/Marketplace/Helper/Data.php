<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_MpFedexShipping
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\MpFedexShipping\Plugin\Marketplace\Helper;

class Data
{
    /**
     * function to run to change the return data of afterIsSeller.
     *
     * @param array $result
     *
     * @return bool
     */
    public function afterGetControllerMappedPermissions(
        \Webkul\Marketplace\Helper\Data $subject,
        $result
    ) {
        $result['mpfedex/shipping/view'] = 'mpfedex/shipping/index';
        return $result;
    }
}
