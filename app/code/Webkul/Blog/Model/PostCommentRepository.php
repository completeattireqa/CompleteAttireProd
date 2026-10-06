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

use Webkul\Blog\Model\ResourceModel\PostComment\Collection;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 * @SuppressWarnings(PHPMD.TooManyFields)
 */
class PostCommentRepository implements \Webkul\Blog\Api\PostCommentRepositoryInterface
{
    /**
     * resource model
     *
     * @var \Webkul\Blog\Model\ResourceModel\PostComment
     */
    protected $_resourceModel;

    /**
     * @param PostCommentFactory                                             $postCommentFactory
     * @param \Webkul\Blog\Model\ResourceModel\PostComment\CollectionFactory $$collectionFactory
     * @param \Webkul\Blog\Model\ResourceModel\PostComment                   $resourceModel
     */
    public function __construct(
        PostCommentFactory $postCommentFactory,
        \Webkul\Blog\Model\ResourceModel\PostComment\CollectionFactory $collectionFactory,
        \Webkul\Blog\Model\ResourceModel\PostComment $resourceModel
    ) {
    
        $this->_resourceModel = $resourceModel;
        $this->_postCommentFactory = $postCommentFactory;
        $this->_collectionFactory = $collectionFactory;
    }

    /**
     * get Comments by Post id
     *
     * @param  integer $postId
     * @return object
     */
    public function getCommentsByPostId($postId)
    {
        $postCommentCollection = $this->_postCommentFactory->create()->getCollection()
            ->addFieldToFilter('post_id', ['eq'=>$postId])
            ->addFieldToFilter('status', ['eq'=>'1']);
        return $postCommentCollection;
    }
}
