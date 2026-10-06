<?php
namespace Magento\Catalog\Block\Product\Widget\Html\Pager;

/**
 * Interceptor class for @see \Magento\Catalog\Block\Product\Widget\Html\Pager
 */
class Interceptor extends \Magento\Catalog\Block\Product\Widget\Html\Pager implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\Template\Context $context, array $data = array())
    {
        $this->___init();
        parent::__construct($context, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getLimit()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getLimit');
        if (!$pluginInfo) {
            return parent::getLimit();
        } else {
            return $this->___callPlugins('getLimit', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAvailableLimit()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getAvailableLimit');
        if (!$pluginInfo) {
            return parent::getAvailableLimit();
        } else {
            return $this->___callPlugins('getAvailableLimit', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isLimitCurrent($limit)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isLimitCurrent');
        if (!$pluginInfo) {
            return parent::isLimitCurrent($limit);
        } else {
            return $this->___callPlugins('isLimitCurrent', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getPageUrl($page)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getPageUrl');
        if (!$pluginInfo) {
            return parent::getPageUrl($page);
        } else {
            return $this->___callPlugins('getPageUrl', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getLimitUrl($limit)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getLimitUrl');
        if (!$pluginInfo) {
            return parent::getLimitUrl($limit);
        } else {
            return $this->___callPlugins('getLimitUrl', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function canShowFirst()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'canShowFirst');
        if (!$pluginInfo) {
            return parent::canShowFirst();
        } else {
            return $this->___callPlugins('canShowFirst', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function canShowLast()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'canShowLast');
        if (!$pluginInfo) {
            return parent::canShowLast();
        } else {
            return $this->___callPlugins('canShowLast', func_get_args(), $pluginInfo);
        }
    }
}
