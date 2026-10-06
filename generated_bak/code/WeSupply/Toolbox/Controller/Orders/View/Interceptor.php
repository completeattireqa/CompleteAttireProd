<?php
namespace WeSupply\Toolbox\Controller\Orders\View;

/**
 * Interceptor class for @see \WeSupply\Toolbox\Controller\Orders\View
 */
class Interceptor extends \WeSupply\Toolbox\Controller\Orders\View implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \WeSupply\Toolbox\Helper\Data $helper, \Magento\Framework\View\Result\PageFactory $pageFactory, \Magento\Framework\Session\SessionManagerInterface $session)
    {
        $this->___init();
        parent::__construct($context, $helper, $pageFactory, $session);
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
