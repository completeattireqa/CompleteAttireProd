<?php
namespace WeSupply\Toolbox\Controller\Estimations\Estimatedelivery;

/**
 * Interceptor class for @see \WeSupply\Toolbox\Controller\Estimations\Estimatedelivery
 */
class Interceptor extends \WeSupply\Toolbox\Controller\Estimations\Estimatedelivery implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Serialize\SerializerInterface $serializer, \WeSupply\Toolbox\Helper\Data $helper, \WeSupply\Toolbox\Api\WeSupplyApiInterface $weSupplyApi, \Magento\Framework\Controller\Result\JsonFactory $jsonFactory, \Magento\Catalog\Model\Session $catalogSession, \Magento\Framework\HTTP\PhpEnvironment\RemoteAddress $remoteAddress, \Psr\Log\LoggerInterface $logger)
    {
        $this->___init();
        parent::__construct($context, $serializer, $helper, $weSupplyApi, $jsonFactory, $catalogSession, $remoteAddress, $logger);
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
