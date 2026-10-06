<?php
namespace WeSupply\Toolbox\Controller\Api\Notify;

/**
 * Interceptor class for @see \WeSupply\Toolbox\Controller\Api\Notify
 */
class Interceptor extends \WeSupply\Toolbox\Controller\Api\Notify implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \WeSupply\Toolbox\Helper\Data $helper, \WeSupply\Toolbox\Api\ReturnsInterface $returnsInterface, \WeSupply\Toolbox\Api\WeSupplyApiInterface $weSupplyApi, \Psr\Log\LoggerInterface $logger)
    {
        $this->___init();
        parent::__construct($context, $helper, $returnsInterface, $weSupplyApi, $logger);
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
