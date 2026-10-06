<?php
namespace WeSupply\Toolbox\Controller\Estimations\DeliveryProduct;

/**
 * Interceptor class for @see \WeSupply\Toolbox\Controller\Estimations\DeliveryProduct
 */
class Interceptor extends \WeSupply\Toolbox\Controller\Estimations\DeliveryProduct implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Controller\Result\JsonFactory $jsonFactory, \Magento\Framework\Serialize\Serializer\Json $json, \Magento\Customer\Model\Session $customerSession, \WeSupply\Toolbox\Block\Estimations\Delivery $estimatesDelivery, \WeSupply\Toolbox\Helper\Data $helper, \WeSupply\Toolbox\Helper\Estimates $estimatesHelper, \WeSupply\Toolbox\Logger\Logger $logger)
    {
        $this->___init();
        parent::__construct($context, $jsonFactory, $json, $customerSession, $estimatesDelivery, $helper, $estimatesHelper, $logger);
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
