<?php
namespace Webkul\MpAdvancedCommission\Controller\Adminhtml\CommissionRules\Save;

/**
 * Interceptor class for @see \Webkul\MpAdvancedCommission\Controller\Adminhtml\CommissionRules\Save
 */
class Interceptor extends \Webkul\MpAdvancedCommission\Controller\Adminhtml\CommissionRules\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Webkul\MpAdvancedCommission\Model\CommissionRulesFactory $commissionRulesFactory, \Magento\Framework\Stdlib\DateTime\DateTime $date, \Webkul\MpAdvancedCommission\Api\CommissionRulesRepositoryInterface $commissionRulesRepository)
    {
        $this->___init();
        parent::__construct($context, $commissionRulesFactory, $date, $commissionRulesRepository);
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
