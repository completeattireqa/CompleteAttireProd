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
namespace Webkul\Blog\Controller\Category;

use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;

/**
 * Category Class
 */
class Category extends \Magento\Framework\App\Action\Action
{
    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @param Context     $context
     * @param PageFactory $resultPageFactory
     * @param array       $data
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Webkul\Blog\Model\Category $categoryModel
    ) {
        $this->_resultPageFactory = $resultPageFactory;
        $this->_categoryModel = $categoryModel;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        $categoryId = $this->getRequest()->getParam('categoryid');
        $category = $this->_categoryModel->load($categoryId)->getCategory();
        $resultPage->getConfig()->getTitle()->set($category);
        return $resultPage;
    }
}
