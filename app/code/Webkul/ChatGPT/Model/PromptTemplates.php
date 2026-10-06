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

namespace Webkul\ChatGPT\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * ChatGPT PromptTemplates Model.
 *
 * @method \Webkul\ChatGPT\Model\ResourceModel\PromptTemplates _getResource()
 * @method \Webkul\ChatGPT\Model\ResourceModel\PromptTemplates getResource()
 */
class PromptTemplates extends AbstractModel
{
    /**
     * No route page id.
     */
    const NOROUTE_ENTITY_ID = 'no-route';

    /**
     * ChatGPT PromptTemplates cache tag.
     */
    const CACHE_TAG = 'wk_chatgpt_prompt_templates';

    /**
     * @var string
     */
    protected $_cacheTag = 'wk_chatgpt_prompt_templates';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'wk_chatgpt_prompt_templates';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init(
            \Webkul\ChatGPT\Model\ResourceModel\PromptTemplates::class
        );
    }

    /**
     * Load object data.
     *
     * @param int|null $id
     * @param string   $field
     *
     * @return $this
     */
    public function load($id, $field = null)
    {
        if ($id === null) {
            return $this->noRouteItems();
        }

        return parent::load($id, $field);
    }
    /**
     * Load No-Route Items.
     *
     * @return \Webkul\ChatGPT\Model\Slot
     */
    public function noRouteItems()
    {
        return $this->load(self::NOROUTE_ENTITY_ID, $this->getIdFieldName());
    }
}
