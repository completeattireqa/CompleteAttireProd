<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_MpBraintree
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\MpBraintree\Controller\BraintreeAccount;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\App\RequestInterface;

class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * @var Magento\Framework\Registry
     */
    protected $_coreRegistry ;

    /**
     * @var Webkul\Marketplace\Helper\Data
     */
    protected $_marketplaceHelper ;

    /**
     * @param Context                         $context
     * @param PageFactory                     $resultPageFactory
     * @param \Magento\Customer\Model\Session $customerSession   customer session
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Session $customerSession,
        \Webkul\Marketplace\Helper\Data $marketplaceHelper,
        \Magento\Framework\Registry $coreRegistry
    ) {
    
        $this->_customerSession = $customerSession;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_marketplaceHelper = $marketplaceHelper;
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * Retrieve customer session object.
     *
     * @return \Magento\Customer\Model\Session
     */
    protected function _getSession()
    {
        return $this->_customerSession;
    }

    /**
     * Check customer authentication.
     *
     * @param RequestInterface $request
     *
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function dispatch(RequestInterface $request)
    {
        $loginUrl = $this->_objectManager->get('Magento\Customer\Model\Url')->getLoginUrl();

        if (!$this->_customerSession->authenticate($loginUrl)) {
            $this->_actionFlag->set('', self::FLAG_NO_DISPATCH, true);
        }
        return parent::dispatch($request);
    }

    /**
     * braintree form
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $pageLabel = 'Braintree Vendor Account Details';
        $resultPage = $this->_resultPageFactory->create();
        if ($this->_marketplaceHelper->getIsSeparatePanel()) {
            $resultPage->addHandle('mpbraintree_layout2_braintreeaccount_index');
        }
        if ($resultPage->getLayout()->getBlock('mpbraintree.customer.edit')->isTestMode()) {
            $this->messageManager->addNotice(__("Braintree currently configured for test mode"));
        }
        $resultPage->getConfig()->getTitle()->set(__($pageLabel));
        $layout = $resultPage->getLayout();

        return $resultPage;
    }
}
