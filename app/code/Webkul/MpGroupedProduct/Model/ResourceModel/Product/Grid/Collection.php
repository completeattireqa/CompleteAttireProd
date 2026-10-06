<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_MpGroupedProduct
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\MpGroupedProduct\Model\ResourceModel\Product\Grid;

use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Search\AggregationInterface;
use Magento\Framework\Module\ModuleListInterface;
use Webkul\Marketplace\Model\ResourceModel\Product\Grid\Collection as ProductCollection;

/**
 * Class Collection
 * Collection for displaying grid of Bundle Product selection
 */
class Collection extends ProductCollection implements SearchResultInterface
{
    /**
     * @var AggregationInterface
     */
    protected $_aggregations;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;


    /**
     * @param \Magento\Framework\Data\Collection\EntityFactoryInterface    $entityFactory
     * @param \Psr\Log\LoggerInterface                                     $logger
     * @param \Magento\Customer\Model\Session                              $customerSession
     * @param \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy
     * @param \Magento\Framework\Event\ManagerInterface                    $eventManager
     * @param \Magento\Store\Model\StoreManagerInterface                   $storeManager
     * @param mixed|null                                                   $mainTable
     * @param \Magento\Framework\Model\ResourceModel\Db\AbstractDb         $eventPrefix
     * @param mixed                                                        $eventObject
     * @param mixed                                                        $resourceModel
     * @param string                                                       $model
     * @param null                                                         $connection
     * @param \Magento\Framework\Model\ResourceModel\Db\AbstractDb|null    $resource
     *
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Eav\Model\ResourceModel\Entity\Attribute $attribute,
        $mainTable,
        $eventPrefix,
        $eventObject,
        $resourceModel,
        $model = 'Magento\Framework\View\Element\UiComponent\DataProvider\Document',
        \Magento\Framework\DB\Adapter\AdapterInterface $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $storeManager,
            $mainTable,
            $eventPrefix,
            $eventObject,
            $resourceModel,
            $model,
            $connection,
            $resource
        );
        $this->_customerSession = $customerSession;
        $this->_eventPrefix = $eventPrefix;
        $this->_eventObject = $eventObject;
        $this->_init($model, $resourceModel);
        $this->setMainTable($mainTable);
    }

    /**
     * Join store relation table if there is store filter
     *
     * @return void
     */
    protected function _renderFiltersBefore()
    {
        parent::_renderFiltersBefore();
        $customerId = $this->_customerSession->getCustomer()->getId();
        $catalogProductEntity = $this->getTable('catalog_product_entity');
        $this->getSelect()->join(
            $catalogProductEntity.' as cpe',
            'main_table.mageproduct_id = cpe.entity_id',
            ['type_id'=>'type_id', 'sku' => 'sku']
        );
        
        $this->addFieldToFilter('seller_id', ['eq'=> $customerId])
            ->addFieldToFilter(
                'type_id',
                [
                  ['eq'=> 'simple'],
                  ['eq'=> 'virtual'],
                  ['eq' => 'downloadable']

                ]
            );
    }
}
