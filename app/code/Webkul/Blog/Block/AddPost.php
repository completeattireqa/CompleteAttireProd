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
 * Webkul Blog AddPost Block
 */
class AddPost extends \Magento\Framework\View\Element\Template
{
    /**
     * category factory
     *
     * @var \Webkul\Blog\Model\CategoryFactory
     */
    protected $_categoryFactory;

    /**
     * blog repository
     *
     * @var blogRepositoryInterface
     */
    protected $_blogRepository;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Webkul\Blog\Model\CategoryFactory               $categoryFactory
     * @param BlogRepositoryInterface                          $blogRepository
     * @param array                                            $data
     */

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        BlogRepositoryInterface $blogRepository,
        \Webkul\Blog\Model\CategoryFactory $categoryFactory,
        array $data = []
    ) {
        $this->_blogRepository = $blogRepository;
        $this->_categoryFactory = $categoryFactory;
        parent::__construct($context, $data);
    }
    
    /**
     * get categories Collection
     *
     * @return object
     */
    public function getCategories()
    {
        $categoryModel = $this->_categoryFactory->create()
                            ->getCollection()
                            ->addFieldToFilter('status', ['eq' => 1]);
        return $categoryModel;
    }

    /**
     * get data of post to be edit
     *
     * @return array
     */
    public function getEditPostData()
    {
        $blogId = $this->getRequest()->getParam('blogid');
        if ($blogId) {
            $collection = $this->_blogRepository->getBlogById($blogId);
            foreach ($collection as $data) {
                $editData = $data->getData();
            }
            return $editData;
        }
    }
}
