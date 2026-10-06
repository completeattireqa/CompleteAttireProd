<?php
namespace Taxjar\SalesTax\Controller\Adminhtml\Nexus\Sync;

/**
 * Interceptor class for @see \Taxjar\SalesTax\Controller\Adminhtml\Nexus\Sync
 */
class Interceptor extends \Taxjar\SalesTax\Controller\Adminhtml\Nexus\Sync implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry, \Taxjar\SalesTax\Api\Tax\NexusRepositoryInterface $nexusService, \Taxjar\SalesTax\Api\Data\Tax\NexusInterfaceFactory $nexusDataObjectFactory, \Taxjar\SalesTax\Model\Tax\NexusSyncFactory $nexusSyncFactory, \Magento\Directory\Model\RegionFactory $regionFactory, \Magento\Directory\Model\CountryFactory $countryFactory)
    {
        $this->___init();
        parent::__construct($context, $coreRegistry, $nexusService, $nexusDataObjectFactory, $nexusSyncFactory, $regionFactory, $countryFactory);
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
