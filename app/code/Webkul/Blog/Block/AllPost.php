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
namespace Webkul\Blog\Block;

use Webkul\Blog\Api\BlogRepositoryInterface;

/**
 * Webkul Blog AllPost Block
 */
class AllPost extends \Magento\Framework\View\Element\Template
{
    /**
     * customer session
     *
     * @var customerSession
     */
    protected $_customerSession;
  
    /**
     * blog repository
     *
     * @var blogRepositoryInteface
     */
   
    protected $_blogRepository;
  
    /**
     * category factory
     *
     * @var categoryfactory
     */
    protected $_categoryFactory;

    protected $_blogs;

    /**
     * @param \Magento\Framework\View\Element\Template\Context     $context
     * @param BlogRepositoryInterface                              $blogRepository
     * @param \Webkul\Blog\Model\ResourceModel\Category\Collection $categoryFactory
     * @param array                                                $data
     * @param \Magento\Customer\Model\Session                      $customerSession
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        BlogRepositoryInterface $blogRepository,
        \Webkul\Blog\Model\ResourceModel\Category\Collection $categoryFactory,
        \Magento\Customer\Model\Session $customerSession,
        array $data = []
    ) {
        $this->_categoryFactory = $categoryFactory;
        $this->_customerSession = $customerSession;
        $this->_blogRepository = $blogRepository;
        parent::__construct($context, $data);
        $this->setCollection($this->getBlogCollection());
    }

    /**
     * get customer Id
     *
     * @return object
     */
    public function getCustomerId()
    {
        $customerId = $this->_customerSession->getCustomerId();
        return $customerId;
    }

    /**
     * get Blog Collection
     *
     * @return object
     */
    public function getBlogCollection()
    {
        if (!$this->_blogs) {
            $customerId = $this->_customerSession->getCustomerId();
            $collection = $this->_blogRepository->getBlogCollectionByUserId($customerId);
            $collection = $collection->addFieldToFilter('user_id', ['eq'=>$customerId]);
            $categoryCollection = $this->_categoryFactory->getTable('wk_category');
            $collection->getSelect()->joinleft(
                $categoryCollection.' as pd',
                'main_table.category_id = pd.id',
                ['category','status']
            );
            $this->_blogs = $collection->addFieldToFilter('blog_status', ['eq'=>1])
                                ->setOrder('created_at', 'DESC');
        }

        return $this->_blogs;
    }

     /**
      * @return $this
      */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if ($this->getBlogCollection()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'Blog.Collection.list.pager'
            )->setCollection(
                $this->getBlogCollection()
            );
            $this->setChild('wk-pager', $pager);
            $this->getBlogCollection()->load();
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('wk-pager');
    }
}
