<?php
namespace Webkul\MpBraintree\Controller\BraintreeAccount\Index;

/**
 * Interceptor class for @see \Webkul\MpBraintree\Controller\BraintreeAccount\Index
 */
class Interceptor extends \Webkul\MpBraintree\Controller\BraintreeAccount\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Customer\Model\Session $customerSession, \Webkul\Marketplace\Helper\Data $marketplaceHelper, \Magento\Framework\Registry $coreRegistry)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $customerSession, $marketplaceHelper, $coreRegistry);
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch(\Magento\Framework\App\RequestInterface $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'dispatch');
        if (!$pluginInfo) {
            return parent::dispatch($request);
        } else {
            return $this->___callPlugins('dispatch', func_get_args(), $pluginInfo);
        }
    }
}
