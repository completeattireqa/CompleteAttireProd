<?php
namespace Magento\Framework\Css\PreProcessor\Adapter\CssInliner;

/**
 * Interceptor class for @see \Magento\Framework\Css\PreProcessor\Adapter\CssInliner
 */
class Interceptor extends \Magento\Framework\Css\PreProcessor\Adapter\CssInliner implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\State $appState)
    {
        $this->___init();
        parent::__construct($appState);
    }

    /**
     * {@inheritdoc}
     */
    public function setHtml($html)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setHtml');
        if (!$pluginInfo) {
            return parent::setHtml($html);
        } else {
            return $this->___callPlugins('setHtml', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setCss($css)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setCss');
        if (!$pluginInfo) {
            return parent::setCss($css);
        } else {
            return $this->___callPlugins('setCss', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function disableStyleBlocksParsing()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'disableStyleBlocksParsing');
        if (!$pluginInfo) {
            return parent::disableStyleBlocksParsing();
        } else {
            return $this->___callPlugins('disableStyleBlocksParsing', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function process()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'process');
        if (!$pluginInfo) {
            return parent::process();
        } else {
            return $this->___callPlugins('process', func_get_args(), $pluginInfo);
        }
    }
}
