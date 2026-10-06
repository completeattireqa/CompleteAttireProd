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
namespace Webkul\EmailUnsubscribe\Model;

use Webkul\EmailUnsubscribe\Api\Data\ReasonInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Reason extends AbstractModel implements ReasonInterface, IdentityInterface
{
    /**
     * No route page id
     */
    const NOROUTE_ENTITY_ID = 'no-route';

    /**
     * Unsubscribed Sellers Table Name
     */
    const TABLE_NAME = 'unsubscription_reasons';

    /**
     * reason enable Status
     */
    const STATUS_ENABLED = 1;

    /**
     * reason disable Status
     */
    const STATUS_DISABLED = 0;

    /**
     * Unsubscribed Sellers cache tag
     */
    const CACHE_TAG = 'unsubscription_reasons';

    /**
     * @var string
     */
    protected $_cacheTag = 'unsubscription_reasons';

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'unsubscription_reasons';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Webkul\EmailUnsubscribe\Model\ResourceModel\Reason::class);
    }

    /**
     * Load object data
     *
     * @param int|null $id
     * @param string $field
     * @return $this
     */
    public function load($id, $field = null)
    {
        if ($id === null) {
            return $this->noRouteFaq();
        }
        return parent::load($id, $field);
    }

    /**
     * Load No-Route Images
     *
     * @return \Webkul\EmailUnsubscribe\Model\Reason
     */
    public function noRouteFaq()
    {
        return $this->load(self::NOROUTE_ENTITY_ID, $this->getIdFieldName());
    }
  
    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get ID
     *
     * @return int
     */
    public function getId()
    {
        return parent::getData(self::ENTITY_ID);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return \Webkul\EmailUnsubscribe\Api\Data\ReasonInterface
     */
    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }
}
