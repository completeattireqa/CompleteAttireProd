<?php
namespace WeltPixel\UserProfile\Controller\Account\Edit;

/**
 * Interceptor class for @see \WeltPixel\UserProfile\Controller\Account\Edit
 */
class Interceptor extends \WeltPixel\UserProfile\Controller\Account\Edit implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory, \Magento\Framework\View\Result\PageFactory $pageFactory, \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator, \Magento\Framework\App\Action\Context $context, \WeltPixel\UserProfile\Helper\Data $profileHelper, \WeltPixel\UserProfile\Model\UserProfileFactory $userProfileFactory, \WeltPixel\UserProfile\Model\UserProfileFields $userProfileFields, \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory, \Magento\Framework\Filesystem $filesystem, \Magento\Framework\Image\AdapterFactory $imageFactory)
    {
        $this->___init();
        parent::__construct($resultRedirectFactory, $pageFactory, $formKeyValidator, $context, $profileHelper, $userProfileFactory, $userProfileFields, $fileUploaderFactory, $filesystem, $imageFactory);
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
