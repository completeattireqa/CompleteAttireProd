<?php

namespace Webkul\Blog\Model;

use Webkul\Blog\Api\Data\CategoryInterface;
use Magento\Framework\DataObject\IdentityInterface;

class Category extends \Magento\Framework\Model\AbstractModel implements CategoryInterface, IdentityInterface
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
    const CACHE_TAG = 'Blog_Category';
    
    /**
     * @var string
     */
    protected $_cacheTag = 'Blog_Category';

    /**
     * Prefix of model events names.
     *
     * @var string
     */
    protected $_eventPrefix = 'Blog_Category';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('Webkul\Blog\Model\ResourceModel\Category');
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
     * @return \Webkul\Blog\Model\Category
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
