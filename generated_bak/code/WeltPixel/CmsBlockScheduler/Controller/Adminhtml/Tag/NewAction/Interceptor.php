<?php
namespace WeltPixel\CmsBlockScheduler\Controller\Adminhtml\Tag\NewAction;

/**
 * Interceptor class for @see \WeltPixel\CmsBlockScheduler\Controller\Adminhtml\Tag\NewAction
 */
class Interceptor extends \WeltPixel\CmsBlockScheduler\Controller\Adminhtml\Tag\NewAction implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \WeltPixel\CmsBlockScheduler\Model\TagFactory $tagFactory, \WeltPixel\CmsBlockScheduler\Model\ResourceModel\Tag\CollectionFactory $tagCollectionFactory, \Magento\Framework\Registry $coreRegistry, \Magento\Framework\App\Response\Http\FileFactory $fileFactory, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory, \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Backend\Helper\Js $jsHelper)
    {
        $this->___init();
        parent::__construct($context, $tagFactory, $tagCollectionFactory, $coreRegistry, $fileFactory, $resultPageFactory, $resultLayoutFactory, $resultForwardFactory, $storeManager, $jsHelper);
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
