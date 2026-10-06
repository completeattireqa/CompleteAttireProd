<?php
namespace Taxjar\SalesTax\Controller\Adminhtml\Taxclass\Product\NewAction;

/**
 * Interceptor class for @see \Taxjar\SalesTax\Controller\Adminhtml\Taxclass\Product\NewAction
 */
class Interceptor extends \Taxjar\SalesTax\Controller\Adminhtml\Taxclass\Product\NewAction implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry, \Magento\Tax\Api\TaxClassRepositoryInterface $taxClassService, \Magento\Tax\Api\Data\TaxClassInterfaceFactory $taxClassDataObjectFactory)
    {
        $this->___init();
        parent::__construct($context, $coreRegistry, $taxClassService, $taxClassDataObjectFactory);
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
