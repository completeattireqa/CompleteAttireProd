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

namespace Webkul\Blog\Controller\Comment;

use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;
use Webkul\Blog\Api\BlogRepositoryInterface;
use Webkul\Blog\Helper\Data;

/**
 * PostComment Class
 */
class PostComment extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Webkul\Blog\Model\PostCommentFactory
     */
    protected $_postCommentFactory;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_date;

    /**
     * @var BlogRepositoryInterface
     */
    protected $_blogRepository;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */

    protected $_storeManager;
    /**
     * @var Data
     */
    protected $_helperData;

    /**
     * @param Context                                              $context
     * @param \Webkul\Blog\Model\PostCommentFactory                $postCommentFactory
     * @param Data                                                 $helperData
     * @param \Magento\Framework\App\Config\ScopeConfigInterface   $scopeConfig
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date
     */
    public function __construct(
        Context $context,
        \Webkul\Blog\Model\PostCommentFactory $postCommentFactory,
        Data $helperData,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        BlogRepositoryInterface $blogRepository,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $date
    ) {
        $this->_date=$date;
        $this->_helperData = $helperData;
        $this->_scopeConfig = $scopeConfig;
        $this->_storeManager =$storeManager;
        $this->_blogRepository = $blogRepository;
        $this->_cacheTypeList = $cacheTypeList;
        $this->_customerSession = $customerSession;
        $this->_cacheFrontendPool = $cacheFrontendPool;
        $this->_postCommentFactory= $postCommentFactory;
        parent::__construct($context);
    }
    
    /**
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {

        if ($this->getRequest()->isPost()) {
            $this->cleanMagentoCache();
            $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            $adminName = $this->_scopeConfig->getValue('trans_email/ident_general/name', $storeScope);
            $adminEmail = $this->_scopeConfig->getValue('trans_email/ident_general/email', $storeScope);
            $customerName = $this->getRequest()->getParam('customer_name');
            $customerEmail = $this->getRequest()->getParam('customer_email');
            if ($customerEmail == '') {
                $customerEmail = $this->_customerSession->getCustomer()->getEmail();
            }
            $title = $this->getRequest()->getParam('title');
            $senderInfo = [];
            $receiverInfo = [];
            if ($this->_scopeConfig->getValue('Content/character/options', $storeScope)) {
                $status = '1';
                $this->messageManager->addSuccess(__('Comment saved successfully.'));
            } else {
                try {
                    $status = '0';
                    $receiverInfo = [
                    'name' => $adminName,
                    'email' => $adminEmail,
                    ];
                    $senderInfo = [
                    'name' => $customerName,
                    'email' => $customerEmail,
                    ];

                    $emailTempVariablesComment = [];
                    $emailTempVariablesComment['senderName'] = $customerName;
                    $emailTempVariablesComment['title'] = $title;
                    $this->_helperData->commentStatusWaitingNotification(
                        $emailTempVariablesComment,
                        $senderInfo,
                        $receiverInfo
                    );
                    $this->messageManager->addSuccess(__("Comment saved successfully. Wait for admin's approval."));
                } catch (\Exception $e) {
                    $this->messageManager->addError($e->getMessage());
                }
            }
            $date = $this->_date->date()->format('m/d/y H:i:s');
            $data = $this->getRequest()->getparams();
            $postCommentCollection = $this->_postCommentFactory->create();
            $postId = $this->getRequest()->getParam('post_id');
            $postCommentCollection->setData($data);
            $postCommentCollection->setStatus($status);
            $postCommentCollection->setCreatedAt($date);
            $postCommentCollection->setCustomerEmail($customerEmail);
            $postCommentCollection->save();
            $blogCollection = $this->_blogRepository->getBlogById($postId);
            foreach ($blogCollection as $blogColl) {
                $bloggerName = $blogColl->getCustomerName();
                $bloggerEmail = $blogColl->getCustomerEmail();
            }
            try {
                $receiverInfoBlog = [
                'name' => $bloggerName,
                'email' => $bloggerEmail,
                ];
                $senderInfoBlog = [
                'name' => $adminName,
                'email' => $adminEmail,
                ];

                 $emailTempVariablesBlog = [];
                 $emailTempVariablesBlog['senderName'] = $customerName;
                 $emailTempVariablesBlog['senderName'] = $customerName;
                 $url = $this->_storeManager->getStore()->getBaseUrl()."wkblog/blog/title/blogid/".$postId;
                 $emailTempVariablesBlog['title'] = $title;
                 $emailTempVariablesBlog['url'] = $url;
                $this->_helperData->commentOnBlogNotification(
                    $emailTempVariablesBlog,
                    $senderInfoBlog,
                    $receiverInfoBlog
                );
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath("wkblog/blog/title/blogid/".$postId);
        } else {
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath("customer/account");
        }
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
