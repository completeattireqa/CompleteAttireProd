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

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Backend\App\Action;
use Magento\TestFramework\ErrorLog\Logger;

/**
 * MassDelete Class
 */
class MassDisable extends \Magento\Backend\App\Action
{
    
    /**
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    protected $_massModel;

    /**
     * @var \Webkul\Blog\Model\Category
     */
    protected $_categoryModel;

    /**
     * @param Action\Context                             $context
     * @param \Magento\Ui\Component\MassAction\Filter    $massModel
     * @param \Webkul\Blog\Model\Category                $categoryModel
     */
   
    public function __construct(
        Action\Context $context,
        \Magento\Ui\Component\MassAction\Filter $massModel,
        \Webkul\Blog\Model\Category $categoryModel
    ) {
        $this->_categoryModel = $categoryModel;
        $this->_massModel = $massModel;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */

    public function execute()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $modelCategory = $this->_categoryModel;
        $model = $this->_massModel;
        $collection = $model->getCollection($modelCategory->getCollection());
        foreach ($collection as $data) {
            $data->setStatus(0);
            $data->save();
        }
        $this->messageManager->addSuccess(__('Categories disabled successfully.'));
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('wkblog/category/managecategories');
    }
}
