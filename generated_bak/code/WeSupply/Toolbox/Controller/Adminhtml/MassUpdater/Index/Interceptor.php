<?php
namespace WeSupply\Toolbox\Controller\Adminhtml\MassUpdater\Index;

/**
 * Interceptor class for @see \WeSupply\Toolbox\Controller\Adminhtml\MassUpdater\Index
 */
class Interceptor extends \WeSupply\Toolbox\Controller\Adminhtml\MassUpdater\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory, \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $resultJsonFactory, $orderCollectionFactory);
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
