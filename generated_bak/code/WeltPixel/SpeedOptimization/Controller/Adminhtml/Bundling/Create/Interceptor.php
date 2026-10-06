<?php
namespace WeltPixel\SpeedOptimization\Controller\Adminhtml\Bundling\Create;

/**
 * Interceptor class for @see \WeltPixel\SpeedOptimization\Controller\Adminhtml\Bundling\Create
 */
class Interceptor extends \WeltPixel\SpeedOptimization\Controller\Adminhtml\Bundling\Create implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \WeltPixel\SpeedOptimization\Helper\Bundling $bundlingHelper, \Magento\Framework\App\Config\Storage\WriterInterface $configWriter, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory)
    {
        $this->___init();
        parent::__construct($context, $bundlingHelper, $configWriter, $scopeConfig, $resultJsonFactory);
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
