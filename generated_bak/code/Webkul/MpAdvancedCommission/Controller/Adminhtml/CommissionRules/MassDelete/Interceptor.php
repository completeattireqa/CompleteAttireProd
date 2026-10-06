<?php
namespace Webkul\MpAdvancedCommission\Controller\Adminhtml\CommissionRules\MassDelete;

/**
 * Interceptor class for @see \Webkul\MpAdvancedCommission\Controller\Adminhtml\CommissionRules\MassDelete
 */
class Interceptor extends \Webkul\MpAdvancedCommission\Controller\Adminhtml\CommissionRules\MassDelete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Ui\Component\MassAction\Filter $filter, \Webkul\MpAdvancedCommission\Model\ResourceModel\CommissionRules\CollectionFactory $collectionFactory)
    {
        $this->___init();
        parent::__construct($context, $filter, $collectionFactory);
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
