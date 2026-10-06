<?php
namespace WeltPixel\AdvancedWishlist\Controller\Multiwishlist\Update;

/**
 * Interceptor class for @see \WeltPixel\AdvancedWishlist\Controller\Multiwishlist\Update
 */
class Interceptor extends \WeltPixel\AdvancedWishlist\Controller\Multiwishlist\Update implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Wishlist\Model\WishlistFactory $wishlistFactory, \Magento\Customer\Model\Session $customerSession, \Magento\Framework\App\Action\Context $context)
    {
        $this->___init();
        parent::__construct($wishlistFactory, $customerSession, $context);
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
