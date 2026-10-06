<?php
/**
 * Webkul Software
 *
 * @category    Webkul
 * @package     Webkul_EmailUnsubscribe
 * @author      Webkul
 * @copyright   Copyright (c)   Webkul Software Private Limited (https://webkul.com)
 * @license     https://store.webkul.com/license.html
 */

namespace Webkul\EmailUnsubscribe\Model\ResourceModel\Reason;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
   
    protected $_idFieldName = 'entity_id';
    
    protected function _construct()
    {
        $this->_init(
            \Webkul\EmailUnsubscribe\Model\Reason::class,
            \Webkul\EmailUnsubscribe\Model\ResourceModel\Reason::class
        );
        $this->_map['fields']['id'] = 'main_table.entity_id';
    }
    
    /**
     * Create all ids retrieving select with limitation
     *
     * @param int $limit
     * @param int $offset
     * @return \Magento\Eav\Model\Entity\Collection\AbstractCollection
     */
    protected function _getAllIdsSelect($limit = null, $offset = null)
    {
        $idsSelect = clone $this->getSelect();
        $idsSelect->reset(\Magento\Framework\DB\Select::ORDER);
        $idsSelect->reset(\Magento\Framework\DB\Select::LIMIT_COUNT);
        $idsSelect->reset(\Magento\Framework\DB\Select::LIMIT_OFFSET);
        $idsSelect->reset(\Magento\Framework\DB\Select::COLUMNS);
        $idsSelect->columns($this->getResource()->getIdFieldName(), 'main_table');
        $idsSelect->limit($limit, $offset);
        return $idsSelect;
    }
}
