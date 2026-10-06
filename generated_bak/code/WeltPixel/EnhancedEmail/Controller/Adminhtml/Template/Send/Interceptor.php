<?php
namespace WeltPixel\EnhancedEmail\Controller\Adminhtml\Template\Send;

/**
 * Interceptor class for @see \WeltPixel\EnhancedEmail\Controller\Adminhtml\Template\Send
 */
class Interceptor extends \WeltPixel\EnhancedEmail\Controller\Adminhtml\Template\Send implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Registry $coreRegistry, \Magento\Backend\App\Action\Context $context, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder, \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation, \WeltPixel\EnhancedEmail\Helper\Data $wpHelper, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory)
    {
        $this->___init();
        parent::__construct($coreRegistry, $context, $storeManager, $scopeConfig, $transportBuilder, $inlineTranslation, $wpHelper, $resultPageFactory, $resultJsonFactory);
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
