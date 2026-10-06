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
 * Webkul Blog Tag Block
 */
class Tag extends \Magento\Framework\View\Element\Template
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
     * @var BlogRepositoryInterface
     */
    protected $_blogRepository;

    /**
     * @var  random variable
     */
    protected $_tags;
        
    /**
     * @param \Magento\Framework\View\Element\Template\Context     $context
     * @param BlogRepositoryInterface                              $blogRepository
     * @param \Webkul\Blog\Model\ResourceModel\Category\Collection $categoryFactory
     * @param array                                                $data
     */

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Webkul\Blog\Model\ResourceModel\Category\Collection $categoryFactory,
        BlogRepositoryInterface $blogRepository,
        array $data = []
    ) {
        $this->_blogRepository = $blogRepository;
        $this->_categoryFactory = $categoryFactory;
        parent::__construct($context, $data);
        $this->setCollection($this->getBlogByTag());
    }
    
    /**
     * get tag name
     *
     * @return string
     */
    public function getTagName()
    {
        $tagName = $this->getRequest()->getParam('tag');
        return $tagName;
    }

    /**
     * get blog by tag
     *
     * @return object
     */
    public function getBlogByTag()
    {
        if (!$this->_tags) {
            $tagName = $this->getRequest()->getParam('tag');
            $collection = $this->_blogRepository->getBlogByTagName($tagName);
            $categoryCollection = $this->_categoryFactory->getTable('wk_category');
            $collection->getSelect()->joinleft(
                $categoryCollection.' as pd',
                'main_table.category_id = pd.id',
                ['category','status']
            );
            $this->_tags = $collection->addFieldToFilter('blog_status', ['eq'=>1])->setOrder('created_at', 'DESC');
        }
        return $this->_tags;
    }

    /**
     * @return $this
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if ($this->getBlogByTag()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'Blog.Collection.list.pager'
            )->setCollection(
                $this->getBlogByTag()
            );
            $this->setChild('pager', $pager);
            $this->getBlogByTag()->load();
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
