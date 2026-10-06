<?php
namespace Bss\CustomerApproval\Controller\Account\Confirm;

/**
 * Interceptor class for @see \Bss\CustomerApproval\Controller\Account\Confirm
 */
class Interceptor extends \Bss\CustomerApproval\Controller\Account\Confirm implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Customer\Model\Session $customerSession, \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Customer\Api\AccountManagementInterface $customerAccountManagement, \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository, \Magento\Customer\Helper\Address $addressHelper, \Magento\Framework\UrlFactory $urlFactory, \Magento\Framework\Controller\Result\Redirect $resultFactory, \Bss\CustomerApproval\Helper\Data $helper)
    {
        $this->___init();
        parent::__construct($context, $customerSession, $scopeConfig, $storeManager, $customerAccountManagement, $customerRepository, $addressHelper, $urlFactory, $resultFactory, $helper);
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
