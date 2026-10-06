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
namespace Webkul\Blog\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Blog data helper
 */
class Data extends AbstractHelper
{
    const XML_PATH_STATUS_PERMITTED_NOTIFICATION_MAIL = 'Content/email_settings/status_permitted_notification';
    const XML_PATH_STATUS_NOTPERMITTED_NOTIFICATION_MAIL = 'Content/email_settings/status_notpermitted_notification';
    const XML_PATH_STATUS_WAITING_NOTIFICATION_MAIL = 'Content/email_settings/status_waiting_notification';
    const XML_PATH_STATUS_ONBLOG_NOTIFICATION_MAIL = 'Content/email_settings/comment_onblog_notification';
    const XML_PATH_COMMENT_APPROVAL_NOTIFICATION_MAIL = 'Content/email_settings/comment_approval_notification';
    const XML_PATH_BLOG_NOTIFICATION_MAIL = 'Content/email_settings/blog_notification';
    const XML_PATH_BLOG_APPROVAL_REQUEST_MAIL = 'Content/email_settings/blog_approval_request';
    const XML_PATH_COMMENT_STATUS_WAITING__NOTIFICATION_MAIL=
    'Content/email_settings/comment_status_waiting_notification';
    
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * @var \Webkul\Blog\Model\BlogCustomerfactory
     */
    protected $_blogCustomerFactory;

    /**
     * @var \Magento\Framework\Translate\Inline\StateInterface
     */
    protected $_inlineTranslation;

    /**
     *
     * @var \Webkul\Blog\Model\BlogFactory
     */
    protected $_blogFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $_transportBuilder;

    /**
     * @param \Magento\Customer\Model\Session                       $customerSession
     * @param \Webkul\Blog\Model\BlogCustomerFactory                $blogCustomerFactory
     * @param  \Webkul\Blog\Model\BlogFactory                       $blogFactory
     * @param \Magento\Framework\App\Config\ScopeConfigInterface    $scopeConfig
     * @param \Magento\Framework\Translate\Inline\StateInterface    $inlineTranslation
     * @param \Magento\Framework\Mail\Template\TransportBuilder     $transpostBuilder
     * @param  \Magento\Store\Model\StoreManagerInterface           $storeManager
     */
    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Webkul\Blog\Model\BlogCustomerFactory $blogCustomerFactory,
        \Webkul\Blog\Model\BlogFactory $blogFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation
    ) {
        $this->_transportBuilder = $transportBuilder;
        $this->_storeManager = $storeManager;
        $this->_blogFactory = $blogFactory;
        $this->_inlineTranslation = $inlineTranslation;
        $this->_blogCustomerFactory = $blogCustomerFactory;
        $this->_scopeConfig = $scopeConfig;
        $this->_cacheTypeList = $cacheTypeList;
        $this->_cacheFrontendPool = $cacheFrontendPool;
        $this->_customerSession = $customerSession;
    }
    /**
     * get character limit
     * @return int
     */
    public function getCharacterLimit()
    {
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        return $this->_scopeConfig->getValue('Content/character/limit', $storeScope);
    }

     /**
      * get Customer Login Info
      * @return int
      */
    public function getCustomerLoginInfo()
    {
        $login = $this->_customerSession->isLoggedIn();
        return $login;
    }

    /**
     * get customer info
     * @return int
     */
    public function isCustomerBlogger()
    {
        $id = $this->_customerSession->getCustomer()->getId();
        $collection = $this->_blogCustomerFactory->create()->getCollection();
        $collection = $collection->addFieldToFilter('user_id', ['eq'=>$id]);
        $size = $collection->getSize();
        if ($size) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * get subject by postid
     * @return int
     */
    public function getSubjectByPostId($postId)
    {
        $collection = $this->_blogFactory->create()->getCollection();
        $collection = $collection->addFieldToFilter('id', ['eq'=>$postId]);
        foreach ($collection as $title) {
            $subject = $title->getSubject();
        }
        return $subject;
    }

    /**
     * get id of Logged in customer
     * @return int
     */
    public function getLoggedInCustomerId()
    {
        $id = $this->_customerSession->getCustomer()->getId();
        return $id;
    }

    /**
     * get data of Logged in customer
     * @return object
     */
    public function getLoggedInCustomerData()
    {
        $data = $this->_customerSession->getCustomer();
        return $data;
    }

    /**
     * Return store configuration value.
     *
     * @param string $path
     * @param int    $storeId
     *
     * @return mixed
     */
    public function getConfigValue($path, $storeId)
    {
        return $this->_scopeConfig->getValue(
            $path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * Return template id.
     *
     * @return mixed
     */
    public function getTemplateId($xmlPath)
    {
        return $this->getConfigValue($xmlPath, $this->getStore()->getStoreId());
    }

    /**
     * Return store.
     *
     * @return Store
     */
    public function getStore()
    {
        return $this->_storeManager->getStore();
    }

    /**
     * [status permitted notificaation description]
     * @param  Mixed $emailTemplateVariables
     * @param  Mixed $senderInfo
     * @param  Mixed $receiverInfo
     */
    public function statusPermittedNotification($emailTemplateVariables, $senderInfo, $receiverInfo)
    {
        $this->_template = $this->getTemplateId(self::XML_PATH_STATUS_PERMITTED_NOTIFICATION_MAIL);
        $this->_inlineTranslation->suspend();
        $this->generateTemplate($emailTemplateVariables, $senderInfo, $receiverInfo);
        $transport = $this->_transportBuilder->getTransport();
        $transport->sendMessage();
        $this->_inlineTranslation->resume();
    }
    
    /**
     * [status not permitted notificaation description]
     * @param  Mixed $emailTemplateVariables
     * @param  Mixed $senderInfo
     * @param  Mixed $receiverInfo
     */
    public function statusNotPermittedNotification($emailTemplateVariables, $senderInfo, $receiverInfo)
    {
        $this->_template = $this->getTemplateId(self::XML_PATH_STATUS_NOTPERMITTED_NOTIFICATION_MAIL);
        $this->_inlineTranslation->suspend();
        $this->generateTemplate($emailTemplateVariables, $senderInfo, $receiverInfo);
        $transport = $this->_transportBuilder->getTransport();
        $transport->sendMessage();
        $this->_inlineTranslation->resume();
    }

    /**
     * [generateTemplate description].
     *
     * @param Mixed $emailTemplateVariables
     * @param Mixed $senderInfo
     * @param Mixed $receiverInfo
     */
    public function generateTemplate($emailTemplateVariables, $senderInfo, $receiverInfo)
    {
        $template = $this->_transportBuilder
                ->setTemplateIdentifier($this->_template)
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => $this->_storeManager->getStore()->getId(),
                    ]
                )
                ->setTemplateVars($emailTemplateVariables)
                ->setFrom($senderInfo)
                ->addTo($receiverInfo['email'], $receiverInfo['name']);

        return $this;
    }

    /**
     * [status approval waiting mail to admin]
     * @param  Mixed $emailTemplateVariables
     * @param  Mixed $senderInfo
     * @param  Mixed $receiverInfo
     */
    public function statusApprovalWaitingNotification($emailTemplateVariables, $senderInfo, $receiverInfo)
    {
        $this->_template = $this->getTemplateId(self::XML_PATH_STATUS_WAITING_NOTIFICATION_MAIL);
        $this->_inlineTranslation->suspend();
        $this->generateTemplate($emailTemplateVariables, $senderInfo, $receiverInfo);
        $transport = $this->_transportBuilder->getTransport();
        $transport->sendMessage();
        $this->_inlineTranslation->resume();
    }

    /**
     * [New comment notification mail to blogger]
     * @param  Mixed $emailTemplateVariables
     * @param  Mixed $senderInfo
     * @param  Mixed $receiverInfo
     */
    public function commentOnBlogNotification($emailTemplateVariables, $senderInfo, $receiverInfo)
    {
        $this->_template = $this->getTemplateId(self::XML_PATH_STATUS_ONBLOG_NOTIFICATION_MAIL);
        $this->_inlineTranslation->suspend();
        $this->generateTemplate($emailTemplateVariables, $senderInfo, $receiverInfo);
        $transport = $this->_transportBuilder->getTransport();
        $transport->sendMessage();
        $this->_inlineTranslation->resume();
    }

    /**
     * [comment approval mail to blogger]
     * @param  Mixed $emailTemplateVariables
     * @param  Mixed $senderInfo
     * @param  Mixed $receiverInfo
     */
    public function commentApprovalNotification($emailTemplateVariables, $senderInfo, $receiverInfo)
    {
        $this->_template = $this->getTemplateId(self::XML_PATH_COMMENT_APPROVAL_NOTIFICATION_MAIL);
        $this->_inlineTranslation->suspend();
        $this->generateTemplate($emailTemplateVariables, $senderInfo, $receiverInfo);
        $transport = $this->_transportBuilder->getTransport();
        $transport->sendMessage();
        $this->_inlineTranslation->resume();
    }

    /**
     * [blog approval/unapproval mail to blogger]
     * @param  Mixed $emailTemplateVariables
     * @param  Mixed $senderInfo
     * @param  Mixed $receiverInfo
     */
    public function blogNotification($emailTemplateVariables, $senderInfo, $receiverInfo)
    {

        $this->_template = $this->getTemplateId(self::XML_PATH_BLOG_NOTIFICATION_MAIL);
        $this->_inlineTranslation->suspend();
        $this->generateTemplate($emailTemplateVariables, $senderInfo, $receiverInfo);
        $transport = $this->_transportBuilder->getTransport();
        $transport->sendMessage();
        $this->_inlineTranslation->resume();
    }

    /**
     * [blog approval request mail to admin]
     * @param  Mixed $emailTemplateVariables
     * @param  Mixed $senderInfo
     * @param  Mixed $receiverInfo
     */
    public function blogApprovalRequest($emailTemplateVariables, $senderInfo, $receiverInfo)
    {
        $this->_template = $this->getTemplateId(self::XML_PATH_BLOG_APPROVAL_REQUEST_MAIL);
        $this->_inlineTranslation->suspend();
        $this->generateTemplate($emailTemplateVariables, $senderInfo, $receiverInfo);
        $transport = $this->_transportBuilder->getTransport();
        $transport->sendMessage();
        $this->_inlineTranslation->resume();
    }

    /**
     * [comment status waiting notification to admin]
     * @param  Mixed $emailTemplateVariables
     * @param  Mixed $senderInfo
     * @param  Mixed $receiverInfo
     */
    public function commentStatusWaitingNotification($emailTemplateVariables, $senderInfo, $receiverInfo)
    {
        $this->_template = $this->getTemplateId(self::XML_PATH_COMMENT_STATUS_WAITING__NOTIFICATION_MAIL);
        $this->_inlineTranslation->suspend();
        $this->generateTemplate($emailTemplateVariables, $senderInfo, $receiverInfo);
        $transport = $this->_transportBuilder->getTransport();
        $transport->sendMessage();
        $this->_inlineTranslation->resume();
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
