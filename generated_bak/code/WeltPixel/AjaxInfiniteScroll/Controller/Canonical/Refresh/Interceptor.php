<?php
namespace WeltPixel\AjaxInfiniteScroll\Controller\Canonical\Refresh;

/**
 * Interceptor class for @see \WeltPixel\AjaxInfiniteScroll\Controller\Canonical\Refresh
 */
class Interceptor extends \WeltPixel\AjaxInfiniteScroll\Controller\Canonical\Refresh implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Json\Helper\Data $jsonHelper, \WeltPixel\AjaxInfiniteScroll\Helper\Data $iasHelper, \Psr\Log\LoggerInterface $logger)
    {
        $this->___init();
        parent::__construct($context, $jsonHelper, $iasHelper, $logger);
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
