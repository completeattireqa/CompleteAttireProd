<?php
namespace Bss\CustomerApproval\Controller\Adminhtml\Index\MassDisapproved;

/**
 * Interceptor class for @see \Bss\CustomerApproval\Controller\Adminhtml\Index\MassDisapproved
 */
class Interceptor extends \Bss\CustomerApproval\Controller\Adminhtml\Index\MassDisapproved implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Ui\Component\MassAction\Filter $filter, \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $collectionFactory, \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository, \Bss\CustomerApproval\Model\ResourceModel\Options $optionModel)
    {
        $this->___init();
        parent::__construct($context, $filter, $collectionFactory, $customerRepository, $optionModel);
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
