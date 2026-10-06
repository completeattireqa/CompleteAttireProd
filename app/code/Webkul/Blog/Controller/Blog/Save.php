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

namespace Webkul\Blog\Controller\Blog;

use Magento\Customer\Model\Session;
use Magento\Framework\View\Result\PageFactory;
use Webkul\Blog\Api\BlogRepositoryInterface;
use Webkul\Blog\Helper\Data;
use Magento\Framework\App\Action\Context;

/**
 * Save Class
 */
class Save extends \Magento\Customer\Controller\AbstractAccount
{
    /**
     * @var \Magento\Customer\Model\Customer
     */
    protected $_customerModel;

    /**
     * @var Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scoprConfig;
    
    /**
     * @var Session
     */
    protected $_session;

    /**
     * @var Data
     */
    protected $_helperData;

    /**
     * @var \Webkul\Blog\Model\BlogFactory
     */
    protected $_blogFactory;

    /**
     * @var BlogRepositoryInterface
     */
    protected $_blogRepository;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_date;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Magento\Framework\App\Cache\TypeListInterface
     */
    protected $_cacheTypeList;

    /**
     * @var \Magento\Framework\App\Cache\Frontend\Pool
     */
    protected $_cacheFrontendPool;
    
    /**
     * @param Context                                            $context
     * @param Session                                            $customerSession
     * @param \Webkul\Blog\Model\BlogFactory                     $blogFactory
     * @param BlogRepositoryInterface                            $blogRepository
     * @param \Magento\Customer\Model\Customer                   $customerModel
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Framework\Stdlib\DateTime\DateTime        $Date
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        \Webkul\Blog\Model\BlogFactory $blogFactory,
        BlogRepositoryInterface $blogRepository,
        Data $helperData,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Customer\Model\Customer $customerModel,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date
    ) {
        $this->_date = $date;
        $this->_session = $customerSession;
        $this->_helperData = $helperData;
        $this->_blogFactory= $blogFactory;
        $this->_scopeConfig = $scopeConfig;
        $this->_customerModel=$customerModel;
        $this->_cacheTypeList = $cacheTypeList;
        $this->_cacheFrontendPool = $cacheFrontendPool;
        $this->_blogRepository = $blogRepository;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($this->getRequest()->isPost()) {
            if ($this->validateData()) {
                $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
                $adminName = $this->_scopeConfig->getValue('trans_email/ident_general/name', $storeScope);
                $adminEmail = $this->_scopeConfig->getValue('trans_email/ident_general/email', $storeScope);
                $status = $this->_scopeConfig->getValue('Content/character/blogapproval', $storeScope);
                $date = $this->_date->date()->format('m/d/y H:i:s');
                $customerId = $this->_session->getCustomer()->getId();
                $cName = $this->_customerModel->load($customerId)->getName();
                $cEmail =  $this->_customerModel->load($customerId)->getEmail();
                $data = $this->getRequest()->getparams();
                $tags= explode(",", $data['tag']);
                if (count($tags) < 2) {
                    $data['tag'] = $data['tag'].",";
                }
                $blogId =$this->getRequest()->getParam('blogid');
                if ($blogId) {
                    $collection= $this->_blogRepository->getBlogById($blogId);
                    foreach ($collection as $blogCollection) {
                        $blogCollection->setData($data);
                        $blogCollection->setId($blogId);
                        $blogCollection->setCustomerName($cName);
                        $blogCollection->setCustomerEmail($cEmail);
                        $blogCollection->setUserId($customerId);
                        $blogCollection->setCreatedAt($date);
                        $blogCollection->save();
                        $this->cleanMagentoCache();
                    }
                    $this->messageManager->addSuccess(__('Post edited successfully.'));
                    return $resultRedirect->setPath("wkblog/blog/viewallpost");
                } else {
                    $blogCollection = $this->_blogFactory->create();
                    $blogCollection->setData($data);
                    $blogCollection->setCustomerName($cName);
                    $blogCollection->setCustomerEmail($cEmail);
                    $blogCollection->setUserId($customerId);
                    $blogCollection->setBlogStatus($status);
                    $blogCollection->setCreatedAt($date);
                    $blogCollection->save();
                    if ($status) {                        
                        $this->messageManager->addSuccess(__('Post saved successfully.'));
                    } else {                       
                        try {
                            $customerEmail = $cEmail;
                            $customerName = $cName;
                            $senderInfo = [];
                            $receiverInfo = [];

                            $senderInfo = [
                                'name' => $customerName,
                                'email' => $customerEmail,
                             ];
                            $receiverInfo = [
                                'name' => $adminName,
                                'email' => $adminEmail,
                             ];
                            $emailTempVariables = [];
                            $emailTempVariables['name'] = $adminName;
                            $emailTempVariables['senderName'] = $customerName;
                            $this->_helperData->blogApprovalRequest(
                                $emailTempVariables,
                                $senderInfo,
                                $receiverInfo
                            );
                        } catch (\Exception $e) {
                            $this->messageManager->addError($e->getMessage());
                        }
                        $this->messageManager->addSuccess(__("Post saved successfully.Wait for admin's approval"));
                    }
                    $this->cleanMagentoCache();
                    return $resultRedirect->setPath("wkblog/Blog/viewallpost");
                }
            } else {
                return $resultRedirect->setPath("wkblog/Blog/viewallpost");
            }
        } else {
            return $resultRedirect->setPath("customer/account");
        }
    }

    public function validateData()
    {
        $flag = 1;
        $data = $this->getRequest()->getParams();
        $tag = $data['tag'];
        $subject = $data['subject'];
        $content = $data['content'];
        $metadescription = $data['metadescription'];
        $metakeywords = $data['metakeywords'];
        if ($subject == "") {
            $this->messageManager->addError(__('Subject can not be empty'));
            $flag = 0;
        }
        if ($content == "") {
            $this->messageManager->addError(__('Content can not be empty'));
            $flag = 0;
        }
        if ($tag == "") {
            $this->messageManager->addError(__('Tag can not be empty'));
            $flag = 0;
        }
        if ($metadescription == "") {
            $this->messageManager->addError(__('Meta Description can not be empty'));
            $flag = 0;
        }
        if ($metakeywords == "") {
            $this->messageManager->addError(__('Meta keywords can not be empty'));
            $flag = 0;
        }
        return $flag;
    }

    /**
     * function to clean cache on blog save
     */
    public function cleanMagentoCache()
    {
        $types = ['full_page'];
        foreach ($types as $type) {
            $this->_cacheTypeList->cleanType($type);
        }        
        foreach ($this->_cacheFrontendPool as $cacheFrontend) {
            $cacheFrontend->getBackend()->clean();
        }
    }
}
