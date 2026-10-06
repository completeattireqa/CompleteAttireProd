<?php
namespace WeSupply\Toolbox\Controller\Webhook\Returns;

/**
 * Interceptor class for @see \WeSupply\Toolbox\Controller\Webhook\Returns
 */
class Interceptor extends \WeSupply\Toolbox\Controller\Webhook\Returns implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Action\Context $context, \Magento\Framework\App\ProductMetadataInterface $productMetadata, \Magento\Framework\App\ResourceConnection $resourceConnection, \Magento\Framework\Controller\Result\JsonFactory $jsonFactory, \Magento\Framework\Serialize\Serializer\Json $json, \Magento\Sales\Model\OrderRepository $orderRepository, \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder, \Magento\Sales\Model\Order\Invoice $invoice, \Magento\Sales\Controller\Adminhtml\Order\CreditmemoLoader $creditMemoLoader, \Magento\Sales\Api\CreditmemoManagementInterface $creditMemoManagement, \Magento\Sales\Model\Order\Email\Sender\CreditmemoSender $creditMemoSender, \Magento\Store\Model\StoreManagerInterface $storeManager, \WeSupply\Toolbox\Api\GiftcardInterface $giftCardInterface, \WeSupply\Toolbox\Api\Data\ReturnslistInterface $returnsList, \WeSupply\Toolbox\Api\WeSupplyApiInterface $weSupplyApiInterface, \WeSupply\Toolbox\Helper\Data $helper, \WeSupply\Toolbox\Logger\Logger $logger, \WeSupply\Toolbox\Model\Webhook $webhook)
    {
        $this->___init();
        parent::__construct($context, $productMetadata, $resourceConnection, $jsonFactory, $json, $orderRepository, $searchCriteriaBuilder, $invoice, $creditMemoLoader, $creditMemoManagement, $creditMemoSender, $storeManager, $giftCardInterface, $returnsList, $weSupplyApiInterface, $helper, $logger, $webhook);
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
