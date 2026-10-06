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
namespace Webkul\Blog\Controller\Adminhtml\Blog;

use Magento\Backend\App\Action;
use Magento\Framework\Registry;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * ManageBlog Class
 */
class ManageBlog extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    /**
     * registry
     *
     * @var Registry
     */
    protected $_registry;

    /**
     * @param Context     $context
     * @param Registry    $registry
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        Registry $registry,
        PageFactory $resultPageFactory
    ) {
        $this->_registry = $registry;
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $bloggerId = $this->getRequest()->getParam('id');
        $this->_registry->register('bloggerId', $bloggerId);
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Blogs'));
        return $resultPage;
    }
}
