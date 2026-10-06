<?php
namespace Webkul\MpAdvancedCommission\Controller\Adminhtml\Ajax\Check;

/**
 * Interceptor class for @see \Webkul\MpAdvancedCommission\Controller\Adminhtml\Ajax\Check
 */
class Interceptor extends \Webkul\MpAdvancedCommission\Controller\Adminhtml\Ajax\Check implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $pageFactory, \Magento\Framework\Json\Helper\Data $jsonHelper)
    {
        $this->___init();
        parent::__construct($context, $pageFactory, $jsonHelper);
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
