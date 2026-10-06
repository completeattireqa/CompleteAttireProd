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
 * Webkul Blog Category Block
 */
class Category extends \Magento\Framework\View\Element\Template
{
    /**
     * category factory
     *
     * @var categoryFactory
     */
    protected $_categoryFactory;

    /**
     * blog repository
     *
     * @var blogRepositoryInterface
     */
    protected $_blogRepository;

    protected $_category;

    /**
     * @param \Webkul\Blog\Model\ResourceModel\Category\Collection $categoryFactory
     * @param \Magento\Framework\View\Element\Template\Context     $context
     * @param blogRepositoryInterface                              $blogRepository
     * @param array                                                $data
     */
    public function __construct(
        \Webkul\Blog\Model\ResourceModel\Category\Collection $categoryFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        BlogRepositoryInterface $blogRepository,
        array $data = []
    ) {
            $this->_categoryFactory = $categoryFactory;
            $this->_blogRepository = $blogRepository;
            parent::__construct($context, $data);
            $this->setCollection($this->getCategoryBlog());
    }

    /**
     * get blog by category
     *
     * @return object
     */
    public function getCategoryBlog()
    {
        if (!$this->_category) {
            $categoryid = $this->getRequest()->getParam('categoryid');
            $collection = $this->_blogRepository->getBlogByCategoryId($categoryid);
            $categoryCollection = $this->_categoryFactory->getTable('wk_category');
            $collection->getSelect()->join(
                $categoryCollection.' as pd',
                'main_table.category_id = pd.id',
                ['category']
            );
            $this->_category = $collection->addFieldToFilter('blog_status', ['eq'=>1])->setOrder('created_at', 'DESC');
        }
        return $this->_category;
    }

    /**
     * @return $this
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if ($this->getCategoryBlog()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'Blog.Collection.list.pager'
            )->setCollection(
                $this->getCategoryBlog()
            );
            $this->setChild('pager', $pager);
            $this->getCategoryBlog()->load();
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
