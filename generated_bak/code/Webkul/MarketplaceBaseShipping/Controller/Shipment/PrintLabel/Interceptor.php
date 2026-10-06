<?php
namespace Webkul\MarketplaceBaseShipping\Controller\Shipment\PrintLabel;

/**
 * Interceptor class for @see \Webkul\MarketplaceBaseShipping\Controller\Shipment\PrintLabel
 */
class Interceptor extends \Webkul\MarketplaceBaseShipping\Controller\Shipment\PrintLabel implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session $customerSession, \Magento\Framework\Filesystem\DirectoryList $directoryList, \Magento\Shipping\Model\Shipping\LabelGenerator $labelGenerator, \Magento\Framework\App\Response\Http\FileFactory $fileFactory)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $directoryList, $labelGenerator, $fileFactory);
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
