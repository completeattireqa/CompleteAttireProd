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

namespace Webkul\Blog\Controller\Blog;

use Magento\Customer\Model\Session;
use Magento\Framework\View\Result\PageFactory;
use Webkul\Blog\Api\BlogCustomerRepositoryInterface;
use Webkul\Blog\Api\BlogRepositoryInterface;
use Magento\Framework\App\Action\Context;

/**
 * Index Class
 */
class Index extends \Magento\Customer\Controller\AbstractAccount
{
    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var BlogCustomerRepositoryInterface
     */
    protected $_blogCustomerRepository;

    /**
     * @var BlogRepositoryInterface
     */
    protected $_blogRepository;

    /**
     * @var Session
     */
    protected $_customerSession;
    
    /**
     * @param Context                         $context
     * @param Session                         $customerSession
     * @param BlogCustomerRepositoryInterface $blogCustomerRepository
     * @param PageFactory                     $resultPageFactory
     * @param array                           $data
     */
    public function __construct(
        Session $customerSession,
        Context $context,
        BlogRepositoryInterface $blogRepository,
        BlogCustomerRepositoryInterface $blogCustomerRepository,
        PageFactory $resultPageFactory
    ) {
        $this->_customerSession = $customerSession;
        $this->_blogRepository = $blogRepository;
        $this->_blogCustomerRepository = $blogCustomerRepository;
        $this->_resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $customerId = $this->_customerSession->getCustomer()->getId();
        $postId = $this->getRequest()->getParam('blogid');
        $bloggerId = $this->_blogRepository->getBloggerIdByBlogId($postId);
        $status = $this->_blogCustomerRepository->getCustomerStatusById($customerId);
        if ($customerId == $bloggerId || !($postId)) {
            if ($status) {
                $resultPage = $this->_resultPageFactory->create();
                if ($postId) {
                    $resultPage->getConfig()->getTitle()->set(__('Edit Post'));
                } else {
                    $resultPage->getConfig()->getTitle()->set(__('Add New Post'));
                }
                return $resultPage;
            } else {
                return $resultRedirect->setPath("customer/account");
            }
        } else {
            $this->messageManager->addError(__('Desired action cannot be performed!'));
            return $resultRedirect->setPath("customer/account");
        }
    }
}
