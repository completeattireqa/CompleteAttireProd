<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_ChatGPT
 * @author    Webkul Software Private Limited
 * @copyright Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\ChatGPT\Model\ResourceModel\PromptTemplates;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Webkul ChatGPT ResourceModel PromptTemplates collection
 */
class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            \Webkul\ChatGPT\Model\PromptTemplates::class,
            \Webkul\ChatGPT\Model\ResourceModel\PromptTemplates::class
        );
        $this->_map['fields']['entity_id'] = 'main_table.entity_id';
    }
}
