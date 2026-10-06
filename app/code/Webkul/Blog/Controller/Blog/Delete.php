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
use Magento\Framework\App\Action\Context;
use Webkul\Blog\Api\BlogRepositoryInterface;

/**
 * Delete Class
 */
class Delete extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Webkul\Blog\Model\BlogFactory
     */
    protected $_blogFactory;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * @var BlogRepositoryInterface
     */
    protected $_blogRepositoryInterface;

    /**
     * @param Context                        $context
     * @param \Webkul\Blog\Model\BlogFactory $blogFactory
     */
    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        BlogRepositoryInterface $blogRepositoryInterface,
        Context $context,
        \Webkul\Blog\Model\BlogFactory $blogFactory
    ) {
        $this->_blogFactory= $blogFactory;
        $this->_blogRepositoryInterface = $blogRepositoryInterface;
        $this->_customerSession = $customerSession;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $blogId =  $this->getRequest()->getParam('id');
        $bloggerId = $this->_blogRepositoryInterface->getBloggerIdByBlogId($blogId);
        $thisCustomerId = $this->_customerSession->getCustomer()->getId();
        if ($thisCustomerId == $bloggerId) {
            $collection = $this->_blogFactory->create()->getCollection()->addFieldToFilter('id', ['eq'=>$blogId]);
            foreach ($collection as $data) {
                $data->delete();
            }
            $this->messageManager->addSuccess(__('Post deleted successfully.'));
            return $resultRedirect->setPath("wkblog/Blog/viewallpost");
        } else {
            $this->messageManager->addError(__('Desired action cannot be performed!'));
            return $resultRedirect->setPath("wkblog/Blog/viewallpost");
        }
    }
}
