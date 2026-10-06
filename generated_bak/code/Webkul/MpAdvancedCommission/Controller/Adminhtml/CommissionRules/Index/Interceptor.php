<?php
namespace Webkul\MpAdvancedCommission\Controller\Adminhtml\CommissionRules\Index;

/**
 * Interceptor class for @see \Webkul\MpAdvancedCommission\Controller\Adminhtml\CommissionRules\Index
 */
class Interceptor extends \Webkul\MpAdvancedCommission\Controller\Adminhtml\CommissionRules\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory);
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
