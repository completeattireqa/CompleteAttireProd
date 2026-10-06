<?php
namespace Webkul\MpAdvancedCommission\Controller\Adminhtml\CommissionRules\Edit;

/**
 * Interceptor class for @see \Webkul\MpAdvancedCommission\Controller\Adminhtml\CommissionRules\Edit
 */
class Interceptor extends \Webkul\MpAdvancedCommission\Controller\Adminhtml\CommissionRules\Edit implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Webkul\MpAdvancedCommission\Model\CommissionRulesFactory $commissionRule)
    {
        $this->___init();
        parent::__construct($context, $registry, $resultPageFactory, $commissionRule);
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
