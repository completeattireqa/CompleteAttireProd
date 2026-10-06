<?php
namespace Webkul\MpFedexShipping\Controller\Shipping\View;

/**
 * Interceptor class for @see \Webkul\MpFedexShipping\Controller\Shipping\View
 */
class Interceptor extends \Webkul\MpFedexShipping\Controller\Shipping\View implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Webkul\Marketplace\Helper\Data $marketplaceHelper, \Webkul\MpFedexShipping\Helper\Data $fedexHelper, \Magento\Customer\Model\Session $customerSession, \Magento\Customer\Model\Url $url)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $marketplaceHelper, $fedexHelper, $customerSession, $url);
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
