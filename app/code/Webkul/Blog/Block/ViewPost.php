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
use Magento\Framework\App\RequestInterface;

/**
 * Webkul Blog ViewPost Block
 */
class ViewPost extends \Magento\Framework\View\Element\Template
{
    /**
     *  blog repository
     *
     * @var blogrepositoryInterface
     */
    protected $_blogRepository;

    /**
     *  category factory
     *
     * @var \Webkul\Blog\Model\ResourceModel\Category\Collection
     */
    protected $_categoryFactory;

    protected $_posts;

    /**
     * @param \Magento\Framework\View\Element\Template\Context     $context
     * @param BlogRepositoryInterface                              $blogRepository
     * @param \Webkul\Blog\Model\ResourceModel\Category\Collection $categoryFactory
     * @param \magento\Customer\Model\Session                      $customerSession
     * @param array                                                $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        BlogRepositoryInterface $blogRepository,
        \Magento\Customer\Model\Session $customerSession,
        \Webkul\Blog\Model\ResourceModel\Category\Collection $categoryFactory,
        array $data = []
    ) {
        $this->_categoryFactory = $categoryFactory;
        $this->_customerSession = $customerSession;
        $this->_blogRepository = $blogRepository;
        parent::__construct($context, $data);
        $this->setCollection($this->getBlogCollection());
    }

    /**
     * get customer id of login customer
     *
     * @return int
     */
    public function getCustomerId()
    {
        $customerId = $this->_customerSession->getCustomerId();
        return $customerId;
    }

    /**
     * get blog collection
     *
     * @return object
     */
    public function getBlogCollection()
    {
        if (!$this->_posts) {
            $customerId = $this->_customerSession->getCustomerId();
            $collection = $this->_blogRepository->getBlogCollection();
            $categoryCollection = $this->_categoryFactory->getTable('wk_category');
            $collection->getSelect()->joinleft(
                $categoryCollection.' as pd',
                'main_table.category_id = pd.id',
                ['category','status']
            );
            $this->_posts = $collection ->addFieldToFilter('blog_status', ['eq'=>1])->setOrder('created_at', 'DESC');
        }
        return $this->_posts;
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
                'Blog.Collection.pager'
            )
                ->setCollection(
                    $this->getBlogCollection()
                );
            $this->setChild('pager', $pager);
            $this->getBlogCollection()->load();
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
