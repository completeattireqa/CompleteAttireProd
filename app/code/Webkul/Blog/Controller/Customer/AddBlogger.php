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
namespace Webkul\Blog\Controller\Customer;

use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;
use Webkul\Blog\Helper\Data;

/**
 * AddBlogger Class
 */
class AddBlogger extends \Magento\Customer\Controller\AbstractAccount
{
    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;
    
    /**
     * @var \Magento\Model\Customer\Session
     */
    protected $_customerSession;

    /**
     * @var \Webkul\Blog\Model\BlogCustomerFactory
     */
    protected $_customerFactory;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_date;

      /**
       * @var Webkul\Blog\Helper\Data
       */
    protected $_helperData;

    /**
     * @param \Magento\Customer\Model\Session                    $customerSession
     * @param \Magento\Framework\Stdlib\DateTime\DateTime        $date
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Webkul\Blog\Model\BlogCustomerFactory             $customerFactory
     * @param Context                                            $context
     * @param Data                                               $helperData
     * @param PageFactory                                        $resultPageFactory
     */
    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Webkul\Blog\Model\BlogCustomerFactory $customerFactory,
        Context $context,
        Data $helperData,
        PageFactory $resultPageFactory
    ) {
        $this->_date = $date;
        $this->_helperData = $helperData;
        $this->_scopeConfig = $scopeConfig;
        $this->_customerSession= $customerSession;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_customerFactory = $customerFactory;
        parent::__construct($context);
    }
    
    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */

    public function execute()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $adminName = $this->_scopeConfig->getValue('trans_email/ident_general/name', $storeScope);
        $adminEmail = $this->_scopeConfig->getValue('trans_email/ident_general/email', $storeScope);
        $bloggerApproval = $this->_scopeConfig->getValue('Content/character/bloggerapproval', $storeScope);
        $id = $this->_customerSession->getCustomer()->getId();
        $customerName = $this->_customerSession->getCustomer()->getName();
        $customerEmail = $this->_customerSession->getCustomer()->getEmail();
        $date = $this->_date->date()->format('m/d/y H:i:s');
        $resultRedirect = $this->resultRedirectFactory->create();
        $customerCollection = $this->_customerFactory->create()
                                ->getCollection()
                                ->addFieldToFilter("user_id", ['eq'=>$id]);
        if ($customerCollection->getSize()) {
            foreach ($customerCollection as $customer) {
                if ($customer->getCustomerStatus()) {
                    $this->messageManager->addError(__("You are already subscribed for blogs."));
                    return $resultRedirect->setPath("customer/account");
                } else {
                    $customer->setUserId($id);
                    $customer->setCustomerStatus($bloggerApproval);
                    $customer->save();
                }
            }
        } else {
            $customer = $this->_customerFactory->create();
            $customer->setUserId($id);
            $customer->setCreatedAt($date);
            $customer->setCustomerStatus($bloggerApproval);
            $customer->save();
        }

        if ($bloggerApproval) {
                    $this->messageManager->addSuccess(__("Thank You for subscribing blogs."));
        } else {
            try {
                $senderInfo = [];
                $receiverInfo = [];
                $receiverInfo = [
                    'name' => $adminName,
                    'email' => $adminEmail,
                 ];
                $senderInfo = [
                    'name' => $customerName,
                    'email' => $customerEmail,
                 ];
                $emailTempVariables = [];
                $emailTempVariables['senderName'] = $customerName;
                
                $this->_helperData->statusApprovalWaitingNotification(
                    $emailTempVariables,
                    $senderInfo,
                    $receiverInfo
                );
                 $resultRedirect = $this->resultRedirectFactory->create();
                 $this->messageManager->addSuccess(__("Thank You for subscribing blogs.Wait For Admin's Approval."));
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }

        return $resultRedirect->setPath("customer/account");
    }
}
