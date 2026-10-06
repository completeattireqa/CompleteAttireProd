<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_EmailUnsubscribe
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\EmailUnsubscribe\Model;

use Webkul\EmailUnsubscribe\Model\ResourceModel\Reason\CollectionFactory;
use Magento\Eav\Model\Config;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Session\SessionManagerInterface;

class ReasonDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var SessionManagerInterface
     */
    protected $session;

    /**
     * Constructor.
     *
     * @param string                   $name
     * @param string                   $primaryFieldName
     * @param string                   $requestFieldName
     * @param CollectionFactory        $CollectionFactory
     * @param array                    $meta
     * @param array                    $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }

    /**
     * Get session object.
     *
     * @return SessionManagerInterface
     */
    protected function getSession()
    {
        if ($this->session === null) {
            $this->session = ObjectManager::getInstance()->get(
                \Magento\Framework\Session\SessionManagerInterface::class
            );
        }

        return $this->session;
    }

    /**
     * Get data
     * ads_pricing
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $item) {
            $result['reason_form'] = $item->getData();
            $this->loadedData[$item->getId()] = $result;
        }

        $data = $this->getSession()->getDataFormData();
        if (!empty($data)) {
            $id = isset($data['reason_form']['entity_id'])
            ? $data['reason_form']['entity_id'] : null;
            $this->loadedData[$id] = $data;
            $this->getSession()->unsDataFormData();
        }
        return $this->loadedData;
    }
}
