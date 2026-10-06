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

use Webkul\Blog\Model\ResourceModel\BlogCustomer\Collection;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.TooManyFields)
 */
class BlogCustomerRepository implements \Webkul\Blog\Api\BlogCustomerRepositoryInterface
{
    /**
     * resource model
     *
     * @var \Webkul\Blog\Model\ResourceModel\BlogCustomer
     */
    protected $_resourceModel;

    /**
     * @param BlogCustomerFactory                                             $blogCustomerFactory
     * @param \Webkul\Blog\Model\ResourceModel\BlogCustomer\CollectionFactory $collectionFactory
     * @param \Webkul\Blog\Model\ResourceModel\BlogCustomer                   $resourceModel
     */
    public function __construct(
        BlogCustomerFactory $blogCustomerFactory,
        \Webkul\Blog\Model\ResourceModel\BlogCustomer\CollectionFactory $collectionFactory,
        \Webkul\Blog\Model\ResourceModel\BlogCustomer $resourceModel
    ) {
    
        $this->_resourceModel = $resourceModel;
        $this->_blogCustomerFactory = $blogCustomerFactory;
        $this->_collectionFactory = $collectionFactory;
    }

    /**
     * get customer data by customer id
     *
     * @param  integer $Id
     * @return object
     */
    public function getCustomerDataById($customerId)
    {
        $customerCollection = $this->_blogCustomerFactory->create()->getCollection();
        $blogCustomerCollection = $customerCollection->addFieldToFilter('user_id', ['eq'=>$customerId]);
        return $blogCustomerCollection;
    }

    /**
     * get customer data
     *
     * @return object
     */
    public function getCustomerData()
    {
        $blogCustomerCollection = $this->_blogCustomerFactory->create()->getCollection();
        $tableName = $blogCustomerCollection->getTable('customer_grid_flat');
        $blogCustomerCollection->getSelect()->join(
            $tableName.' as pd',
            'main_table.user_id = pd.entity_id',
            ['name','email']
        );
        return $blogCustomerCollection;
    }

    /**
     * get Customer Status By id
     *
     * @return Int
     */
    public function getCustomerStatusById($customerId)
    {
        $status = "";
        $customerCollection = $this->_blogCustomerFactory->create()->getCollection();
        $blogCustomerCollection = $customerCollection->addFieldToFilter('user_id', ['eq'=>$customerId]);
        foreach ($blogCustomerCollection as $collection) {
            $status = $collection->getCustomerStatus();
        }
        return $status;
    }
}
