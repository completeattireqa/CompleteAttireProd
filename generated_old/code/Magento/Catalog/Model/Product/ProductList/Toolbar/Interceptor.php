<?php
namespace Magento\Catalog\Model\Product\ProductList\Toolbar;

/**
 * Interceptor class for @see \Magento\Catalog\Model\Product\ProductList\Toolbar
 */
class Interceptor extends \Magento\Catalog\Model\Product\ProductList\Toolbar implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Request\Http $request)
    {
        $this->___init();
        parent::__construct($request);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getOrder');
        if (!$pluginInfo) {
            return parent::getOrder();
        } else {
            return $this->___callPlugins('getOrder', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDirection()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getDirection');
        if (!$pluginInfo) {
            return parent::getDirection();
        } else {
            return $this->___callPlugins('getDirection', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getMode()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getMode');
        if (!$pluginInfo) {
            return parent::getMode();
        } else {
            return $this->___callPlugins('getMode', func_get_args(), $pluginInfo);
        }
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
    public function getCurrentPage()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getCurrentPage');
        if (!$pluginInfo) {
            return parent::getCurrentPage();
        } else {
            return $this->___callPlugins('getCurrentPage', func_get_args(), $pluginInfo);
        }
    }
}
