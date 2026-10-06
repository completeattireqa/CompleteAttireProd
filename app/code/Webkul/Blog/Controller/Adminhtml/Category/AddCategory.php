<?php
/**
 * Webkul Software
 *
 * @category    Webkul
 * @package     Webkul_Blog
 * @author      Webkul
 * @copyright   Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license     https://store.webkul.com/license.html
 */
namespace Webkul\Blog\Controller\Adminhtml\Category;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;
use Webkul\Blog\Model\Category;
use Magento\Framework\Registry;

class AddCategory extends Action
{
    
    protected $_session;

    /**
     * @var Registry
     */
    protected $_registry;

    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var Attributes
     */
    protected $_category;

    /**
     * @param Context     $context
     * @param Registry    $registry
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        Registry $registry,
        Category $category,
        PageFactory $resultPageFactory
    ) {
        $this->_registry = $registry;
        $this->_category = $category;
        $this->_session = $context->getSession();
        parent::__construct($context);
        $this->_resultPageFactory = $resultPageFactory;
    }
    
    /**
     * @return page
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $categoryModel = $this->_category;
        if ($this->getRequest()->getParam('id')) {
            $categoryModel->load($this->getRequest()->getParam('id'));
        }
        $data = $this->_session->getFormData(true);
        if (!empty($data)) {
            $categoryModel->setData($data);
        }
        $this->_registry->register('category', $categoryModel);
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->prepend(
            $categoryModel->getId() ? $categoryModel->getCategory() : __('Add New Category')
        );
        $content = $resultPage->getLayout()->createBlock('Webkul\Blog\Block\Adminhtml\Category\AddCategory');
        $resultPage->addContent($content);
        return $resultPage;
    }
}
