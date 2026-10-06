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

use Webkul\Blog\Model\ResourceModel\Category\Collection;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.TooManyFields)
 */
class CategoryRepository implements \Webkul\Blog\Api\CategoryRepositoryInterface
{
    /**
     * resource model
     *
     * @var \Webkul\Blog\Model\ResourceModel\Category
     */
    protected $_resourceModel;
    protected $_categoryRepository;

    /**
     * @param CategoryFactory                                             $blogCustomerFactory
     * @param \Webkul\Blog\Model\ResourceModel\Category\CollectionFactory $collectionFactory
     * @param \Webkul\Blog\Model\ResourceModel\Badge                      $resourceModel
     */
    public function __construct(
        CategoryFactory $blogCustomerFactory,
        \Webkul\Blog\Model\ResourceModel\Category\CollectionFactory $collectionFactory,
        \Webkul\Blog\Model\ResourceModel\Category $resourceModel
    ) {
        $this->_categoryRepository = $categoryRepository;
        $this->_resourceModel = $resourceModel;
        $this->_categoryFactory = $categoryFactory;
        $this->_collectionFactory = $collectionFactory;
    }

    /**
     * get customer status by customer id
     *
     * @param  integer $Id
     * @return object
     */
    public function getCategoryCollection()
    {
        $categoryCollection = $this->_categoryRepository->getCategoryCollection();
        return $categoryCollection;
    }
}
