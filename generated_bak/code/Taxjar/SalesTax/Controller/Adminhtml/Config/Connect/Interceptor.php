<?php
namespace Taxjar\SalesTax\Controller\Adminhtml\Config\Connect;

/**
 * Interceptor class for @see \Taxjar\SalesTax\Controller\Adminhtml\Config\Connect
 */
class Interceptor extends \Taxjar\SalesTax\Controller\Adminhtml\Config\Connect implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Config\Model\ResourceModel\Config $resourceConfig, \Magento\Framework\App\Config\ReinitableConfigInterface $reinitableConfig)
    {
        $this->___init();
        parent::__construct($context, $scopeConfig, $resourceConfig, $reinitableConfig);
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
