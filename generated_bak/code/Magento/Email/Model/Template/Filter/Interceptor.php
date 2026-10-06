<?php
namespace Magento\Email\Model\Template\Filter;

/**
 * Interceptor class for @see \Magento\Email\Model\Template\Filter
 */
class Interceptor extends \Magento\Email\Model\Template\Filter implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Stdlib\StringUtils $string, \Psr\Log\LoggerInterface $logger, \Magento\Framework\Escaper $escaper, \Magento\Framework\View\Asset\Repository $assetRepo, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Variable\Model\VariableFactory $coreVariableFactory, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\View\LayoutInterface $layout, \Magento\Framework\View\LayoutFactory $layoutFactory, \Magento\Framework\App\State $appState, \Magento\Framework\UrlInterface $urlModel, \Pelago\Emogrifier $emogrifier, \Magento\Email\Model\Source\Variables $configVariables, $variables = array(), \Magento\Framework\Css\PreProcessor\Adapter\CssInliner $cssInliner = null)
    {
        $this->___init();
        parent::__construct($string, $logger, $escaper, $assetRepo, $scopeConfig, $coreVariableFactory, $storeManager, $layout, $layoutFactory, $appState, $urlModel, $emogrifier, $configVariables, $variables, $cssInliner);
    }

    /**
     * {@inheritdoc}
     */
    public function cssDirective($construction)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'cssDirective');
        if (!$pluginInfo) {
            return parent::cssDirective($construction);
        } else {
            return $this->___callPlugins('cssDirective', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getCssFilesContent(array $files)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getCssFilesContent');
        if (!$pluginInfo) {
            return parent::getCssFilesContent($files);
        } else {
            return $this->___callPlugins('getCssFilesContent', func_get_args(), $pluginInfo);
        }
    }
}
