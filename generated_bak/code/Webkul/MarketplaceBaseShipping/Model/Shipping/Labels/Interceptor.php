<?php
namespace Webkul\MarketplaceBaseShipping\Model\Shipping\Labels;

/**
 * Interceptor class for @see \Webkul\MarketplaceBaseShipping\Model\Shipping\Labels
 */
class Interceptor extends \Webkul\MarketplaceBaseShipping\Model\Shipping\Labels implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Webkul\MarketplaceBaseShipping\Model\ShippingSettingRepository $dataRepository, \Magento\Shipping\Model\Config $shippingConfig, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Shipping\Model\CarrierFactory $carrierFactory, \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory, \Magento\Shipping\Model\Shipment\RequestFactory $shipmentRequestFactory, \Magento\Directory\Model\RegionFactory $regionFactory, \Magento\Framework\Math\Division $mathDivision, \Magento\Customer\Model\Session $customerSession, \Magento\Shipping\Model\Shipping\LabelsFactory $labelFactory, \Magento\CatalogInventory\Api\StockRegistryInterface $stockRegistry, \Magento\Backend\Model\Auth\Session $authSession, \Magento\Shipping\Model\Shipment\Request $request, \Webkul\MarketplaceBaseShipping\Helper\Data $helper)
    {
        $this->___init();
        parent::__construct($scopeConfig, $dataRepository, $shippingConfig, $storeManager, $carrierFactory, $rateResultFactory, $shipmentRequestFactory, $regionFactory, $mathDivision, $customerSession, $labelFactory, $stockRegistry, $authSession, $request, $helper);
    }

    /**
     * {@inheritdoc}
     */
    public function collectRates(\Magento\Quote\Model\Quote\Address\RateRequest $request)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'collectRates');
        if (!$pluginInfo) {
            return parent::collectRates($request);
        } else {
            return $this->___callPlugins('collectRates', func_get_args(), $pluginInfo);
        }
    }
}
