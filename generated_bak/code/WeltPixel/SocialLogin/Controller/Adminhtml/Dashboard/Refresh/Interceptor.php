<?php
namespace WeltPixel\SocialLogin\Controller\Adminhtml\Dashboard\Refresh;

/**
 * Interceptor class for @see \WeltPixel\SocialLogin\Controller\Adminhtml\Dashboard\Refresh
 */
class Interceptor extends \WeltPixel\SocialLogin\Controller\Adminhtml\Dashboard\Refresh implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory, \WeltPixel\SocialLogin\Model\Analytics $analyticsModel)
    {
        $this->___init();
        parent::__construct($context, $resultPageFactory, $analyticsModel);
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
