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

use \Webkul\Blog\Api\BlogRepositoryInterface;

/**
 * Webkul Blog User Block
 */
class User extends \Magento\Framework\View\Element\Template
{
    /**
     * category factory
     *
     * @var \Webkul\Blog\Model\ResourceModel\Category\Collection
     */
    protected $_categoryFactory;
    
    /**
     * blog repository
     *
     * @var blogRepositoryInterface
     */
    protected $_blogRepository;

    protected $_blogs;

    /**
     * @param \Magento\Framework\View\Element\Template\Context     $context
     * @param BlogRepositoryInterface                              $blogRepository
     * @param \Webkul\Blog\Model\ResourceModel\Category\Collection $categoryFactory
     * @param array                                                $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        BlogRepositoryInterface $blogRepository,
        \Webkul\Blog\Model\ResourceModel\Category\Collection $categoryFactory,
        array $data = []
    ) {
        $this->_categoryFactory = $categoryFactory;
        $this->_blogRepository = $blogRepository;
        parent::__construct($context, $data);
        $this->setCollection($this->getBlogByName());
    }

    /**
     * get blog for user name
     *
     * @return object
     */
    public function getBlogByName()
    {
        if (!$this->_blogs) {
            $userId = $this->getRequest()->getParam('userid');
            $collection = $this->_blogRepository->getBlogCollectionByUserId($userId);
            $categoryCollection = $this->_categoryFactory->getTable('wk_category');
            $collection->getSelect()->joinleft(
                $categoryCollection.' as pd',
                'main_table.category_id = pd.id',
                ['category','status']
            );
            $this->_blogs = $collection->addFieldToFilter('blog_status', ['eq'=>1])->setOrder('created_at', 'DESC');
        }
        return $this->_blogs;
    }

    /**
     * @return $this
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if ($this->getBlogByName()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'Blog.Collection.list.pager'
            )->setCollection(
                $this->getBlogByName()
            );
            $this->setChild('pager', $pager);
            $this->getBlogByName()->load();
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
