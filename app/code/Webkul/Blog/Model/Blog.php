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

use Webkul\Blog\Api\Data\BlogInterface;
use Magento\Framework\DataObject\IdentityInterface;

/**
 * Blog Model
 */
class Blog extends \Magento\Framework\Model\AbstractModel implements BlogInterface, IdentityInterface
{
    /**
     * No route page id.
     */
    const NOROUTE_ENTITY_ID = 'no-route';
   
    /**#@+
     * Blog Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * Blog cache tag.
     */
    const CACHE_TAG = 'Blog_Blog';
    
    /**
     * @var string
     */
    protected $_cacheTag = 'Blog_Blog';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'Blog_Blog';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('Webkul\Blog\Model\ResourceModel\Blog');
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
            return $this->noRouteGallery();
        }
        return parent::load($id, $field);
    }

    /**
     * Load No-Route bLOG
     *
     * @return \Webkul\Blog\Model\Blog
     */
    public function noRouteImages()
    {
        return $this->load(self::NOROUTE_ENTITY_ID, $this->getIdFieldName());
    }

    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Approved'), self::STATUS_DISABLED => __('Disapproved')];
    }

    /**
     * Get identities.
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get ID.
     *
     * @return int
     */
    public function getId()
    {
        return parent::getData(self::ENTITY_ID);
    }

    /**
     * Set ID.
     *
     * @param int $id
     */
    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }
}
