<?php
namespace WeltPixel\UserProfile\Controller\View\Editable;

/**
 * Interceptor class for @see \WeltPixel\UserProfile\Controller\View\Editable
 */
class Interceptor extends \WeltPixel\UserProfile\Controller\View\Editable implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session $customerSession, \WeltPixel\UserProfile\Model\UserProfileFactory $userProfileFactory)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $userProfileFactory);
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
