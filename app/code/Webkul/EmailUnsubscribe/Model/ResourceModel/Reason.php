<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_EmailUnsubscribe
 * @author    Webkul
 * @copyright Copyright (c)   Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\EmailUnsubscribe\Model\ResourceModel;

class Reason extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('unsubscription_reasons', 'entity_id');
    }
}
