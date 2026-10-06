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

use Webkul\Blog\Api\BlogCustomerRepositoryInterface;
 
/**
 * Webkul Blog IsBlogger Block
 */
class IsBlogger extends \Magento\Framework\View\Element\Template
{
    /**
     * category factory
     *
     * @var \Webkul\Blog\Model\CategoryFactory
     */
    protected $_categoryFactory;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * blog Customer repository
     *
     * @var blogCustomerRepositoryInterface
     */
    protected $_blogCustomerRepository;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Webkul\Blog\Model\CategoryFactory               $categoryFactory
     * @param \Magento\Customer\Model\Session                  $customerSession
     * @param BlogRepositoryInterface                          $blogRepository
     * @param array                                            $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        BlogCustomerRepositoryInterface $blogCustomerRepository,
        \Webkul\Blog\Model\CategoryFactory $categoryFactory,
        array $data = []
    ) {
        $this->_customerSession = $customerSession;
        $this->_blogCustomerRepository = $blogCustomerRepository;
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
        $categoryModel = $this->_categoryFactory->create()->getCollection();
        return $categoryModel;
    }

    /**
     * get data of post to be edit
     *
     * @return int
     */
    public function getEditPostData()
    {
        $id= $this->_customerSession->getCustomer()->getId();
        $collection = $this->_blogCustomerRepository->getCustomerDataById($id);
        if (empty($collection)) {
            return 0;
        } else {
            return 1;
        }
    }
}
