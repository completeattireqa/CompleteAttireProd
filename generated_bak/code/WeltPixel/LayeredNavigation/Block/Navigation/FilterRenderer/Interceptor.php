<?php
namespace WeltPixel\LayeredNavigation\Block\Navigation\FilterRenderer;

/**
 * Interceptor class for @see \WeltPixel\LayeredNavigation\Block\Navigation\FilterRenderer
 */
class Interceptor extends \WeltPixel\LayeredNavigation\Block\Navigation\FilterRenderer implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\WeltPixel\LayeredNavigation\Helper\Data $wpHelper, \WeltPixel\LayeredNavigation\Model\AttributeOptions $attributeOptions, \Magento\Framework\Registry $registry, \Magento\Directory\Model\Currency $currency, \Magento\Framework\View\Element\Template\Context $context, array $data = array())
    {
        $this->___init();
        parent::__construct($wpHelper, $attributeOptions, $registry, $currency, $context, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function render(\Magento\Catalog\Model\Layer\Filter\FilterInterface $filter)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'render');
        if (!$pluginInfo) {
            return parent::render($filter);
        } else {
            return $this->___callPlugins('render', func_get_args(), $pluginInfo);
        }
    }
}
