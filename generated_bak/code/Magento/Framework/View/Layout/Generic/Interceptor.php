<?php
namespace Magento\Framework\View\Layout\Generic;

/**
 * Interceptor class for @see \Magento\Framework\View\Layout\Generic
 */
class Interceptor extends \Magento\Framework\View\Layout\Generic implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory, $data = array())
    {
        $this->___init();
        parent::__construct($uiComponentFactory, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function build(\Magento\Framework\View\Element\UiComponentInterface $component)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'build');
        if (!$pluginInfo) {
            return parent::build($component);
        } else {
            return $this->___callPlugins('build', func_get_args(), $pluginInfo);
        }
    }
}
