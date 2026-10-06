<?php
namespace WeltPixel\AjaxInfiniteScroll\Controller\NextPage\ReloadPagination;

/**
 * Interceptor class for @see \WeltPixel\AjaxInfiniteScroll\Controller\NextPage\ReloadPagination
 */
class Interceptor extends \WeltPixel\AjaxInfiniteScroll\Controller\NextPage\ReloadPagination implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\Json\Helper\Data $jsonHelper, \Psr\Log\LoggerInterface $logger, \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository, \Magento\Store\Model\StoreManagerInterface $storeManager)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $jsonHelper, $logger, $categoryRepository, $storeManager);
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
