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

use Webkul\Blog\Model\ResourceModel\Blog\Collection;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.TooManyFields)
 */
class BlogRepository implements \Webkul\Blog\Api\BlogRepositoryInterface
{
    /**
     * \Webkul\Blog\Model\Category
     */
    protected $_categoryModel;

    /**
     * resource model
     *
     * @var \Webkul\Blog\Model\ResourceModel\Blog
     */
    protected $_resourceModel;

    /**
     * @param BlogFactory                                             $blogFactory
     * @param \Webkul\Blog\Model\ResourceModel\Blog\CollectionFactory $collectionFactory
     * @param \Webkul\Blog\Model\ResourceModel\Blog                   $resourceModel
     */
    public function __construct(
        BlogFactory $blogFactory,
        \Webkul\Blog\Model\ResourceModel\Blog\CollectionFactory $collectionFactory,
        \Webkul\Blog\Model\Category $categoryModel,
        \Webkul\Blog\Model\ResourceModel\Blog $resourceModel
    ) {
    
        $this->_resourceModel = $resourceModel;
        $this->_blogFactory = $blogFactory;
        $this->_categoryModel = $categoryModel;
        $this->_collectionFactory = $collectionFactory;
    }

    /**
     * get Blog Collection by User user id
     *
     * @param  integer $UserId
     * @return object
     */
    public function getBlogCollectionByUserId($userId)
    {
        $blogCollection = $this->_blogFactory->create()->getCollection();
        $blogCollection=$blogCollection->addFieldToFilter('user_id', ['eq'=>$userId])->setOrder('id', 'DESC');
        return $blogCollection;
    }

    /**
     * get Blog by id
     *
     * @param  integer $BlogId
     * @return object
     */
    public function getBlogById($blogId)
    {
        $blogCollection = $this->_blogFactory->create()->getCollection()->addFieldToFilter('id', ['eq'=>$blogId]);
        return $blogCollection;
    }

    /**
     * get Blog by category id
     *
     * @param  integer $categoryId
     * @return object
     */
    public function getBlogByCategoryId($categoryId)
    {
        $blogCollection = $this->_blogFactory->create()->getCollection();
        $blogCollection=$blogCollection->addFieldToFilter('category_id', ['eq'=>$categoryId]);
        return $blogCollection;
    }
    
    /**
     * get Blog Collection
     *
     * @return object
     */
    public function getBlogCollection()
    {
        $blogCollection = $this->_blogFactory->create()->getCollection();
        return $blogCollection;
    }

    /**
     * get Blog by Tagname
     *
     * @param  string $tagName
     * @return object
     */
    public function getBlogByTagName($tagName)
    {
        $collection = $this->_blogFactory->create()->getCollection();
        $blogCollection =$collection->addFieldToFilter(
            'tag',
            [
                ['like'=>'%,'.$tagName.',%'],
                ['like'=>'%,'.$tagName],
                ['like'=>$tagName.',%']
            ]
        );
        return $blogCollection;
    }

    public function doesCategoryExist($postId)
    {
        $collection = $this->_blogFactory->create()->getCollection()
                                        ->addFieldToFilter('id', ['eq',$postId]);
        $data = $collection->getFirstItem();
        $categoryCollection = $this->_categoryModel
                                    ->getCollection()
                                    ->addFieldToFilter('id', ['eq', $data->getCategoryId()]);
        return $categoryCollection->getSize();
    }

    /**
     * get Blog for Title
     *
     * @return object
     */
    public function getBlogForTitle()
    {
        $blogCollection = $this->_blogFactory->create()->getCollection();
        $blogCollection=$blogCollection->setOrder('id', 'DESC');
        return $blogCollection;
    }

    /**
     * get BloggerId by Blog Id
     *
     * @return blogger id
     */
    public function getBloggerIdByBlogId($blogId)
    {
        $blogCollection = $this->_blogFactory->create()->getCollection();
        $blogCollection = $blogCollection->addFieldToFilter('id', ['eq'=>$blogId]);
        $data = $blogCollection->getFirstItem();
        return $data['user_id'];
    }
}
