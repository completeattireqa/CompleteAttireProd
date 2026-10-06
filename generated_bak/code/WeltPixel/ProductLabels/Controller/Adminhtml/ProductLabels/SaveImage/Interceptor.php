<?php
namespace WeltPixel\ProductLabels\Controller\Adminhtml\ProductLabels\SaveImage;

/**
 * Interceptor class for @see \WeltPixel\ProductLabels\Controller\Adminhtml\ProductLabels\SaveImage
 */
class Interceptor extends \WeltPixel\ProductLabels\Controller\Adminhtml\ProductLabels\SaveImage implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry, \WeltPixel\ProductLabels\Model\Config\FileUploader\FileProcessor $fileProcessor)
    {
        $this->___init();
        parent::__construct($context, $coreRegistry, $fileProcessor);
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
