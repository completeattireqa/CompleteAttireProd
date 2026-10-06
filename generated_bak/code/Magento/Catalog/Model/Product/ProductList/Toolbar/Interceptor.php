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
}
