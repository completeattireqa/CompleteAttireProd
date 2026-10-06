<?php
namespace Taxjar\SalesTax\Controller\Adminhtml\Config\Disconnect;

/**
 * Interceptor class for @see \Taxjar\SalesTax\Controller\Adminhtml\Config\Disconnect
 */
class Interceptor extends \Taxjar\SalesTax\Controller\Adminhtml\Config\Disconnect implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Config\Model\ResourceModel\Config $resourceConfig, \Magento\Framework\App\Config\ReinitableConfigInterface $reinitableConfig, \Taxjar\SalesTax\Model\Tax\NexusFactory $nexusFactory, \Magento\Store\Model\StoreManagerInterface $storeManager)
    {
        $this->___init();
        parent::__construct($context, $resourceConfig, $reinitableConfig, $nexusFactory, $storeManager);
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
