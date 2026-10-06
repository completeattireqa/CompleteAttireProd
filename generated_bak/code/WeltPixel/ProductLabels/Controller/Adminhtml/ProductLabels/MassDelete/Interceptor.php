<?php
namespace WeltPixel\ProductLabels\Controller\Adminhtml\ProductLabels\MassDelete;

/**
 * Interceptor class for @see \WeltPixel\ProductLabels\Controller\Adminhtml\ProductLabels\MassDelete
 */
class Interceptor extends \WeltPixel\ProductLabels\Controller\Adminhtml\ProductLabels\MassDelete implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Ui\Component\MassAction\Filter $filter, \WeltPixel\ProductLabels\Model\ResourceModel\ProductLabels\CollectionFactory $collectionFactory)
    {
        $this->___init();
        parent::__construct($context, $filter, $collectionFactory);
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
