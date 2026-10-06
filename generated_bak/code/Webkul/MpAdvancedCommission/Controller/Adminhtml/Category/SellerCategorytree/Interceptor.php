<?php
namespace Webkul\MpAdvancedCommission\Controller\Adminhtml\Category\SellerCategorytree;

/**
 * Interceptor class for @see \Webkul\MpAdvancedCommission\Controller\Adminhtml\Category\SellerCategorytree
 */
class Interceptor extends \Webkul\MpAdvancedCommission\Controller\Adminhtml\Category\SellerCategorytree implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Catalog\Api\CategoryRepositoryInterface $categoryRepository, \Magento\Catalog\Model\ResourceModel\Category $categoryResourceModel, \Magento\Customer\Model\Customer $customer, \Magento\Framework\Json\Helper\Data $jsonHelper)
    {
        $this->___init();
        parent::__construct($context, $categoryRepository, $categoryResourceModel, $customer, $jsonHelper);
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
