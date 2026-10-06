<?php
namespace WeltPixel\EnhancedEmail\Block\MenuLine;

/**
 * Interceptor class for @see \WeltPixel\EnhancedEmail\Block\MenuLine
 */
class Interceptor extends \WeltPixel\EnhancedEmail\Block\MenuLine implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\WeltPixel\EnhancedEmail\Helper\Data $_helper, \Magento\Framework\View\Element\Template\Context $context, \Magento\Framework\Data\Tree\NodeFactory $nodeFactory, \Magento\Framework\Data\TreeFactory $treeFactory, array $data = array())
    {
        $this->___init();
        parent::__construct($_helper, $context, $nodeFactory, $treeFactory, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function getHtml($outermostClass = '', $childrenWrapClass = '', $limit = 0)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getHtml');
        if (!$pluginInfo) {
            return parent::getHtml($outermostClass, $childrenWrapClass, $limit);
        } else {
            return $this->___callPlugins('getHtml', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentities()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getIdentities');
        if (!$pluginInfo) {
            return parent::getIdentities();
        } else {
            return $this->___callPlugins('getIdentities', func_get_args(), $pluginInfo);
        }
    }
}
