<?php
namespace WeltPixel\UserProfile\Controller\View\Save;

/**
 * Interceptor class for @see \WeltPixel\UserProfile\Controller\View\Save
 */
class Interceptor extends \WeltPixel\UserProfile\Controller\View\Save implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session $customerSession, \WeltPixel\UserProfile\Model\UserProfileFactory $userProfileFactory, \Psr\Log\LoggerInterface $logger, \WeltPixel\UserProfile\Helper\Renderer $profileRendererHelper, \Magento\Framework\Filesystem $fileSystem, \Magento\Framework\Filesystem\Io\File $fileSystemIo, \WeltPixel\UserProfile\Model\UserProfileFields $userProfileFields)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $userProfileFactory, $logger, $profileRendererHelper, $fileSystem, $fileSystemIo, $userProfileFields);
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
