<?php
namespace WeltPixel\UserProfile\Controller\View\Uploadimage;

/**
 * Interceptor class for @see \WeltPixel\UserProfile\Controller\View\Uploadimage
 */
class Interceptor extends \WeltPixel\UserProfile\Controller\View\Uploadimage implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory, \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory, \Magento\Framework\Filesystem $fileSystem, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\Image\AdapterFactory $imageFactory)
    {
        $this->___init();
        parent::__construct($context, $resultJsonFactory, $fileUploaderFactory, $fileSystem, $storeManager, $imageFactory);
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
