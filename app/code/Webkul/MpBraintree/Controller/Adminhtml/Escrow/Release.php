<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_MpBraintree
 * @author    Webkul
 * @copyright Copyright (c) 2010-2016 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\MpBraintree\Controller\Adminhtml\Escrow;

use Magento\Framework\Controller\ResultFactory;

use Magento\Backend\App\Action;

/**
 * Webkul MpBraintree escrow release
 */
class Release extends \Magento\Backend\App\Action
{
    /**
     * @var \Webkul\MpBraintree\Model\Adapter\MpBraintreeAdapter
     */
    protected $adapter;

    /**
     * braintree order manager
     *
     * @var Webkul\MpBraintree\Model\BraintreeOrderManagement
     */
    protected $_braintreOrderManager;

    /**
     * @param Action\Context $context
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Webkul\MpBraintree\Model\Adapter\MpBraintreeAdapter $adapter,
        \Webkul\MpBraintree\Api\BraintreeOrderManagementInterface $braintreOrderManager
    ) {
        parent::__construct($context);
        $this->adapter = $adapter;
        $this->_braintreOrderManager = $braintreOrderManager;
    }

    /**
     * Check for is allowed
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Webkul_MpBraintree::release_from_escrow');
    }

    /**
     * release from escrow
     *
     * @return void
     */
    public function execute()
    {
        $transactionId = $this->getRequest()->getParam("transaction_id");
        $orderId = $this->getRequest()->getParam("order_id");
        if ($transactionId) {
            try {
                $this->adapter->releaseFromEscrow($transactionId);
                $sellerId = $this->_braintreOrderManager->getSellerFromTransactionId($transactionId, $orderId);
                if ($sellerId) {
                    $this->_braintreOrderManager->payToSeller($orderId, $sellerId, $transactionId);
                }
                $this->messageManager->addSuccess(__("transaction successfully released from escrow"));
            } catch (\Exception $e) {
                $this->messageManager->addError(__($e->getMessage()));
            }
        } else {
            $this->messageManager->addError(__("Invalid request"));
        }
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('sales/order/view', ['order_id' => $orderId]);
    }
}
