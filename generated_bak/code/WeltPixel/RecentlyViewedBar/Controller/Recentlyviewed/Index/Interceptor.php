<?php
namespace WeltPixel\RecentlyViewedBar\Controller\Recentlyviewed\Index;

/**
 * Interceptor class for @see \WeltPixel\RecentlyViewedBar\Controller\Recentlyviewed\Index
 */
class Interceptor extends \WeltPixel\RecentlyViewedBar\Controller\Recentlyviewed\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Json\Helper\Data $jsonHelper, \Psr\Log\LoggerInterface $logger, \Magento\Reports\Block\Product\Widget\Viewed\Proxy $viewProductsBlock, \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {
        $this->___init();
        parent::__construct($context, $jsonHelper, $logger, $viewProductsBlock, $resultPageFactory);
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
