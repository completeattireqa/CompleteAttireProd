<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_MpFedexShipping
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\MpFedexShipping\Controller\Shipping ;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

use Magento\Framework\App\RequestInterface;

class View extends Action
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Customer\Model\Url
     */
    protected $url;
    
    /**
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param \Webkul\Marketplace\Helper\Data $marketplaceHelper
     * @param \Webkul\MpFedexShipping\Helper\Data $fedexHelper
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Customer\Model\Url $url
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        \Webkul\Marketplace\Helper\Data $marketplaceHelper,
        \Webkul\MpFedexShipping\Helper\Data $fedexHelper,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Customer\Model\Url $url
    ) {
        $this->_customerSession = $customerSession;
        $this->resultPageFactory = $resultPageFactory;
        $this->marketplaceHelper = $marketplaceHelper;
        $this->url = $url;
        $this->fedexHelper = $fedexHelper;
        parent::__construct($context);
    }

    /**
     * Check customer authentication
     *
     * @param RequestInterface $request
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function dispatch(RequestInterface $request)
    {
        $loginUrl = $this->url->getLoginUrl();

        if (!$this->_customerSession->authenticate($loginUrl)) {
            $this->_actionFlag->set('', self::FLAG_NO_DISPATCH, true);
        }
        return parent::dispatch($request);
    }

    /**
     * Default customer account page
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $isPartner = $this->marketplaceHelper->isSeller();

        if ($isPartner == 1 && $this->fedexHelper->getConfigData('allow_seller')) {

            /** @var \Magento\Framework\View\Result\Page $resultPage */
            $resultPage = $this->resultPageFactory->create();
            if ($this->marketplaceHelper->getIsSeparatePanel()) {
                $resultPage->addHandle('mpfedex_shipping_layout2_view');
            }
            $resultPage->getConfig()->getTitle()->set(__('Manage Fedex Configuration'));
            return $resultPage;
        } else {
            return $this->resultRedirectFactory->create()->setPath(
                'marketplace/account/dashboard',
                ['_secure' => $this->getRequest()->isSecure()]
            );
        }
    }
}
