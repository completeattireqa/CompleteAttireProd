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

/**
 * MassBlogDelete Class
 */
class MassBlogDelete extends \Magento\Backend\App\Action
{

    /**
     * @param Webkul\Blog\Model\Blog
     */
    protected $_blogModel;

    /**
     * @var \Magento\Ui\Component\MassAction\Filter
     */
    protected $_massModel;

    /**
     * @var \Webkul\Blog\Helper\Data
     */
    protected $_helperData;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @param \Webkul\Blog\Model\Blog                 $blogModel
     * @param \Magento\Ui\Component\MassAction\Filter $massModel
     * @param Action\Context                          $context
     */
    public function __construct(
        \Webkul\Blog\Model\Blog $blogModel,
        \Magento\Ui\Component\MassAction\Filter $massModel,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Webkul\Blog\Helper\Data $helper,
        Action\Context $context
    ) {
        $this->_blogModel = $blogModel;
        $this->_helperData = $helper;
        $this->_scopeConfig = $scopeConfig;
        $this->_massModel = $massModel;
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
        $id = $this->getRequest()->getParam('user_id');
        $customerModel = $this->_blogModel;
        $model = $this->_massModel;
        $collection = $model->getCollection($customerModel->getCollection());
        foreach ($collection as $data) {
            $bloggerId = $data->getUserId();
            $customerName = $data->getCustomerName();
            $customerEmail = $data->getCustomerEmail();
            $title = $data->getSubject();
            $senderInfo = [];
            $receiverInfo = [];
            $receiverInfo = [
                'name' => $customerName,
                'email' => $customerEmail,
             ];
            $senderInfo = [
                'name' => $adminName,
                'email' => $adminEmail,
             ];
            $details = "deleted";
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
            $data->delete();
        }
        $this->_helperData->cleanMagentoCache();
        $this->messageManager->addSuccess(__('Blogs Deleted Successfully'));
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('wkblog/blog/manageblog/user_id/'.$id);
    }
}
