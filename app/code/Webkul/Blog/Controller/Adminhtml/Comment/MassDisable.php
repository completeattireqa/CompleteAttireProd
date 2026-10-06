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
 * MassDisable Class
 */
class MassDisable extends \Magento\Backend\App\Action
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
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $senderName = $this->_scopeConfig->getValue('trans_email/ident_general/name', $storeScope);
        $senderEmail = $this->_scopeConfig->getValue('trans_email/ident_general/email', $storeScope);
        
        $modelComment = $this->_commentModel;
        $model = $this->_massModel;
        $collection = $model->getCollection($modelComment->getCollection());
        $postId = '';
        foreach ($collection as $data) {
            try {
                $data->setStatus(0);
                $data->save();
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        $this->_helperData->cleanMagentoCache();
        $this->messageManager->addSuccess(__('Comment status changed successfully.'));
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('wkblog/comment/postcomment/post_id/'.$postId);
    }
}
