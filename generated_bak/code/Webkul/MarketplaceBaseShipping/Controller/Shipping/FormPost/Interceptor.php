<?php
namespace Webkul\MarketplaceBaseShipping\Controller\Shipping\FormPost;

/**
 * Interceptor class for @see \Webkul\MarketplaceBaseShipping\Controller\Shipping\FormPost
 */
class Interceptor extends \Webkul\MarketplaceBaseShipping\Controller\Shipping\FormPost implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session $customerSession, \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator, \Webkul\MarketplaceBaseShipping\Api\ShippingSettingRepositoryInterface $shippingSettingRepository, \Webkul\MarketplaceBaseShipping\Api\Data\ShippingSettingInterfaceFactory $shippingSettingDataFactory, \Magento\Customer\Api\Data\RegionInterfaceFactory $regionDataFactory, \Magento\Framework\Reflection\DataObjectProcessor $dataProcessor, \Magento\Framework\Api\DataObjectHelper $dataObjectHelper, \Magento\Framework\Controller\Result\ForwardFactory $resultForwardFactory, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Directory\Model\RegionFactory $regionFactory, \Magento\Directory\Helper\Data $helperData)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $formKeyValidator, $shippingSettingRepository, $shippingSettingDataFactory, $regionDataFactory, $dataProcessor, $dataObjectHelper, $resultForwardFactory, $resultPageFactory, $regionFactory, $helperData);
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
