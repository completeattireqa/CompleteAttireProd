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
namespace Webkul\Blog\Controller\Adminhtml\Blog;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Backend\App\Action;
use Magento\TestFramework\ErrorLog\Logger;
use Webkul\Blog\Helper\Data;

/**
 * MassBlogDelete Class
 */
class BlogMassaction extends \Magento\Backend\App\Action
{

    /**
     * @param Webkul\Blog\Model\Blog
     */
    protected $_blogModel;

    /**
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    protected $_massModel;

    /** @var \Webkul\Helper\Data
     */
    protected $_helperData;

    /**
     * @param \Webkul\Blog\Model\Blog                 $blogModel
     * @param \Magento\Ui\Component\MassAction\Filter $massModel
     * @param Action\Context                          $context
     */
    public function __construct(
        \Webkul\Blog\Model\Blog $blogModel,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        Data $helperData,
        \Magento\Ui\Component\MassAction\Filter $massModel,
        Action\Context $context
    ) {
        $this->_blogModel = $blogModel;
        $this->_helperData = $helperData;
        $this->_massModel = $massModel;
        $this->_scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $adminName = $this->_scopeConfig->getValue('trans_email/ident_general/name', $storeScope);
        $adminEmail = $this->_scopeConfig->getValue('trans_email/ident_general/email', $storeScope);
        $status = $this->getRequest()->getParam('id');
        $postId = $this->getRequest()->getParam('post_id');
        $bloggerId = $this->getRequest()->getParam('user_id');
        $data = $this->getRequest()->getParams();
        $blogCollection = $this->_blogModel->getCollection();
        if ($postId) {
            $blogCollection = $blogCollection->addFieldToFilter("user_id", ['eq'=> $postId]);
        }
        $model = $this->_massModel;
        $collection = $model->getCollection($blogCollection);
        if ($collection->getSize()) {
            try {
                foreach ($collection as $data) {
                    $customerName = $data->getCustomerName();
                    $customerEmail = $data->getCustomerEmail();
                    $title = $data->getSubject();
                    $senderInfo = [];
                    $receiverInfo = [];
                    $details = "";
                    $receiverInfo = [
                        'name' => $customerName,
                        'email' => $customerEmail,
                     ];
                    $senderInfo = [
                        'name' => $adminName,
                        'email' => $adminEmail,
                     ];
                    if ($status == 1) {
                        $details ="approved";
                    } elseif ($status == 0) {
                        $details = "disapproved";
                    }
                    $emailTempVariables = [];
                    $emailTempVariables['name'] = $customerName;
                    $emailTempVariables['status'] = $details;
                    $emailTempVariables['senderName'] = $adminName;
                    $emailTempVariables['subject'] = $title;
                    $this->_helperData->blogNotification(
                        $emailTempVariables,
                        $senderInfo,
                        $receiverInfo
                    );
                }
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        if ($status == 2) {
            foreach ($collection as $blogs) {
                $blogs->delete();
            }
            $this->messageManager->addSuccess(__('Blogs Deleted Successfully'));
        } else {
            foreach ($collection as $blog) {
                $postId = $blog->getUserId();
                $blog->setBlogStatus($status);
                $blog->save();
            }
            $this->messageManager->addSuccess(__('Blogs status has been changed successfully'));
        }
        $this->_helperData->cleanMagentoCache();
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('wkblog/blog/manageblog/user_id/'.$bloggerId);
    }
}
