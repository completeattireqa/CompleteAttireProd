<?php
namespace WeSupply\Toolbox\Controller\Order\Cancel;

/**
 * Interceptor class for @see \WeSupply\Toolbox\Controller\Order\Cancel
 */
class Interceptor extends \WeSupply\Toolbox\Controller\Order\Cancel implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \WeSupply\Toolbox\Helper\Data $helper, \Magento\Sales\Api\OrderRepositoryInterface $orderRepositoryInterface)
    {
        $this->___init();
        parent::__construct($context, $helper, $orderRepositoryInterface);
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
