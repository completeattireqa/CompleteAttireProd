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
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;

/**
 * ViewAllPost Class
 */
class ViewAllPost extends \Magento\Framework\App\Action\Action
{
    /**
     * @var Session
     */
    protected $_customerSession;
    
    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;
    
    /**
     * @param Context     $context
     * @param Session     $customerSession
     * @param PageFactory $resultPageFatory
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        PageFactory $resultPageFactory
    ) {

        $this->_customerSession = $customerSession;
        $this->_resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Check customer authentication.
     *
     * @param RequestInterface $request
     *
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function dispatch(RequestInterface $request)
    {
        $loginUrl = $this->_objectManager->get(
            'Magento\Customer\Model\Url'
        )->getLoginUrl();

        if (!$this->_customerSession->authenticate($loginUrl)) {
            $this->_actionFlag->set('', self::FLAG_NO_DISPATCH, true);
        }

        return parent::dispatch($request);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $id = $this->_customerSession->getCustomer()->getId();
        $name = $this->_customerSession->getCustomer()->getName();
        if ($id) {
            $resultPage = $this->_resultPageFactory->create();
            $resultPage->getConfig()->getTitle()->set($name);
            return $resultPage;
        } else {
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath("customer/account");
        }
    }
}
