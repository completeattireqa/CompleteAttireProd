<?php
namespace Webkul\MpGroupedProduct\Controller\Product\Render;

/**
 * Interceptor class for @see \Webkul\MpGroupedProduct\Controller\Product\Render
 */
class Interceptor extends \Webkul\MpGroupedProduct\Controller\Product\Render implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Element\UiComponentFactory $factory, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory = null, \Magento\Framework\Escaper $escaper = null, \Psr\Log\LoggerInterface $logger = null)
    {
        $this->___init();
        parent::__construct($context, $factory, $resultJsonFactory, $escaper, $logger);
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
