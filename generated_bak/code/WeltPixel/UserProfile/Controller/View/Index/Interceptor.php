<?php
namespace WeltPixel\UserProfile\Controller\View\Index;

/**
 * Interceptor class for @see \WeltPixel\UserProfile\Controller\View\Index
 */
class Interceptor extends \WeltPixel\UserProfile\Controller\View\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $pageFactory, \WeltPixel\UserProfile\Helper\Data $profileHelper, \WeltPixel\UserProfile\Model\UserProfileFactory $userProfileFactory, \Magento\Customer\Model\Session $customerSession)
    {
        $this->___init();
        parent::__construct($context, $pageFactory, $profileHelper, $userProfileFactory, $customerSession);
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
