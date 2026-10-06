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

use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;

/**
 * Title Class
 */
class Title extends \Magento\Framework\App\Action\Action
{
    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @param Context     $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Webkul\Blog\Model\Blog $blogModel
    ) {
        $this->_resultPageFactory = $resultPageFactory;
        $this->_blogModel = $blogModel;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('blogid');
        $subject = $this->_blogModel->load($id)->getSubject();
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set($subject);
        return $resultPage;
    }
}
