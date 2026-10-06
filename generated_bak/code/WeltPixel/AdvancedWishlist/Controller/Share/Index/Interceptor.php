<?php
namespace WeltPixel\AdvancedWishlist\Controller\Share\Index;

/**
 * Interceptor class for @see \WeltPixel\AdvancedWishlist\Controller\Share\Index
 */
class Interceptor extends \WeltPixel\AdvancedWishlist\Controller\Share\Index implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\View\Result\PageFactory $pageFactory, \Magento\Wishlist\Model\WishlistFactory $wishlistFactory, \WeltPixel\AdvancedWishlist\Helper\Data $wishlistHelper, \Magento\Framework\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($pageFactory, $wishlistFactory, $wishlistHelper, $context);
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
