<?php
/**
 * Webkul Software
 *
 * @category  Webkul
 * @package   Webkul_Blog
 * @author    Webkul
 * @copyright Copyright (c) 2010-2018 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\Blog\Block;

use Webkul\Blog\Api\BlogRepositoryInterface;
use Webkul\Blog\Api\PostCommentRepositoryInterface;

/**
 * Webkul Blog AddPost Block
 */
class Title extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;
    
    /**
     * blog repository
     *
     * @var blogRepositoryInterface
     */
    protected $_blogRepository;
    
    /**
     * category factory
     *
     * @var \Webkul\Blog\Model\ResourceModel\Category\Collection
     */
    protected $_categoryFactory;
    
    /**
     * comment repository
     *
     * @var commentRepositoryInterface
     */
    protected $_commentRepository;

    /**
     *
     * @var
     */
    protected $_comments;

    /**
     * @param \Magento\Framework\View\Element\Template\Context     $context
     * @param BlogRepositoryInterface                              $blogRepository
     * @param PostCommentRepositoryInterface                       $commentRepository
     * @param \Webkul\Blog\Model\ResourceModel\Category\Collection $categoryFactory
     * @param \Magento\Customer\Model\Session                      $customerSession
     * @param array                                                $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        BlogRepositoryInterface $blogRepository,
        PostCommentRepositoryInterface $commentRepository,
        \Webkul\Blog\Model\ResourceModel\Category\Collection $categoryFactory,
        \Magento\Customer\Model\Session $customerSession,
        array $data = []
    ) {
        $this->_categoryFactory = $categoryFactory;
        $this->_customerSession = $customerSession;
        $this->_blogRepository = $blogRepository;
        $this->_commentRepository = $commentRepository;
        parent::__construct($context, $data);
        $this->setCollection($this->getTitle());
    }
    
    /**
     * get login Customer data
     *
     * @return object
     */
    public function getCustomerData()
    {
        $customer = $this->_customerSession->getCustomer();
        return $customer;
    }

    /**
     * get blog by title
     *
     * @return object
     */
    public function getTitle()
    {
        $blogId =  $this->getRequest()->getParam('blogid');
        $customerId = $this->_customerSession->getCustomerId();
        $collection = $this->_blogRepository->getBlogForTitle();
        $categoryExist = $this->_blogRepository->doesCategoryExist($blogId);
        if ($categoryExist) {
                $categoryCollection = $this->_categoryFactory->getTable('wk_category');
                $collection->getSelect()->join(
                    $categoryCollection.' as pd',
                    'main_table.category_id = pd.id and main_table.id ='.$blogId,
                    ['category','status']
                );
        } else {
            $collection = $collection->addFieldToFilter('id', ['eq'=>$blogId]);
        }
        return $collection;
    }
    
    /**
     * get comments of blog
     *
     * @return object
     */
    public function getComments()
    {
        if (!$this->_comments) {
            $blogId =  $this->getRequest()->getParam('blogid');
            $collection = $this->_commentRepository
                ->getCommentsByPostId($blogId)
                ->setOrder('id', 'DESC');
            $this->_comments = $collection;
        }
        return $this->_comments;
    }

    /**
     * get no of comments of blog
     *
     * @return object
     */
    public function getCommentSize()
    {
        $blogId =  $this->getRequest()->getParam('blogid');
        $collection = $this->_commentRepository
            ->getCommentsByPostId($blogId)
            ->setOrder('id', 'DESC');
        return $collection->getSize();
    }

    /**
     * @return $this
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if ($this->getComments()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'Blog.Collection.list.pager'
            )
                ->setCollection(
                    $this->getComments()
                );
            $this->setChild('pager', $pager);
            $this->getComments()->load();
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
}
