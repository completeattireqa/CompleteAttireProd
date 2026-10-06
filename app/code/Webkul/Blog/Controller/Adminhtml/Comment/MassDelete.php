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
namespace Webkul\Blog\Controller\Adminhtml\Comment;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Backend\App\Action;
use Magento\TestFramework\ErrorLog\Logger;
use Webkul\Blog\Helper\Data;

/**
 * MassDelete Class
 */
class MassDelete extends \Magento\Backend\App\Action
{
    
    /**
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    protected $_massModel;

    /**
     * @var \Webkul\Blog\Model\PostComment
     */
    protected $_commentModel;
    protected $_scopeConfig;

    /**
     * @param Action\Context                             $context
     * @param \Magento\Ui\Component\MassAction\Filter    $massModel
     * @param \Webkul\Blog\Model\Category                $categoryModel
     */
   
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        Action\Context $context,
        \Magento\Ui\Component\MassAction\Filter $massModel,
        \Webkul\Blog\Model\PostComment $commentModel,
        Data $helperData
    ) {
        $this->_commentModel = $commentModel;
        $this->_scopeConfig = $scopeConfig;
        $this->_helperData=$helperData;
        $this->_massModel = $massModel;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */

    public function execute()
    {
        $modelComment = $this->_commentModel;
        $model = $this->_massModel;
        $collection = $model->getCollection($modelComment->getCollection());
        $postId = '';
        foreach ($collection as $data) {
            $postId = $data->getPostId();
            $data->delete();
        }
        $this->_helperData->cleanMagentoCache();
        $this->messageManager->addSuccess(__('Comment deleted successfully.'));
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('wkblog/comment/postcomment/post_id/'.$postId);
    }
}
