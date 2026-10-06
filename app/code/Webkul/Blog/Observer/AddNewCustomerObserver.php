<?php
/**
 * Webkul Software
 *
 * @category  Webkul
 * @package   Webkul_ Blog
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\Blog\Observer;

use Magento\Framework\Event\ObserverInterface;
use Webkul\Blog\Helper\Data;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Category;

/**
 * Webkul Blog Add New Customer Observer Model.
 */
class AddNewCustomerObserver implements ObserverInterface
{
    /**
     * @var eventManager
     */
    protected $_eventManager;

    /**
     * @var CustomerFactory
     */
    protected $_customerFactory;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_date;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var Webkul\Blog\Helper\Data
     */
    protected $_helperData;

    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $_getRequest;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $_messageManager;

    /**
     * @param \Magento\Framework\App\RequestInterface            $getRequest
     * @param \Magento\Framework\Stdlib\DateTime\DateTime        $date
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param Data                                               $helperData
     * @param \Webkul\Blog\Model\BlogCustomerFactory             $customerFactory
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $getRequest,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        Data $helperData,
        \Webkul\Blog\Model\BlogCustomerFactory $customerFactory
    ) {
        $this->_helperData = $helperData;
        $this->_messageManager = $messageManager;
        $this->_scopeConfig = $scopeConfig;
        $this->_getRequest = $getRequest;
        $this->_date = $date;
        $this->_customerFactory = $customerFactory;
    }

    /**
     * Blog customer registration event handler.
     *
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        $adminName = $this->_scopeConfig->getValue('trans_email/ident_general/name', $storeScope);
        $adminEmail = $this->_scopeConfig->getValue('trans_email/ident_general/email', $storeScope);
        $bloggerApproval = $this->_scopeConfig->getValue('Content/character/bloggerapproval', $storeScope);
        $date = $this->_date->gmtDate();
        $dataa = $observer->getCustomer();
        $customerName = $dataa->getFirstname();
        $customerEmail = $dataa->getEmail();
        $id = $dataa->getId();
        $interest = $this->_getRequest->getParam('interest');
        if ($interest == 'yes') {
            $senderInfo = [];
            $receiverInfo = [];
            $customerModel = $this->_customerFactory->create();
            $customerModel->setCreatedAt($date);
            $customerModel->setCustomerStatus($bloggerApproval);
            $customerModel->setUserId($id);
            $customerModel->save();
            if ($bloggerApproval) {
                 $this->_messageManager->addSuccess(__("Thank You for subscribing blogs."));
            } else {
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
                $this->_messageManager->addSuccess(__("Thank You for subscribing blogs.Wait For Admin's Approval."));
            }
        }
    }
}
