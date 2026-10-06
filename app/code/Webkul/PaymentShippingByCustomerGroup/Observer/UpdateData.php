<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_PaymentShippingByCustomerGroup
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\PaymentShippingByCustomerGroup\Observer;

use Magento\Framework\Event\ObserverInterface;
use \Magento\Framework\Message\ManagerInterface;

class UpdateData implements ObserverInterface
{
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Webkul\PaymentShippingByCustomerGroup\Helper\Data $helper
     */
    public function __construct(
        \Magento\Customer\Model\GroupFactory $customerGroup,
        \Magento\Framework\App\RequestInterface $request,
        \Webkul\PaymentShippingByCustomerGroup\Helper\Data $helper,
        ManagerInterface $messageManager
    ) {
        $this->request = $request;
        $this->customerGroup = $customerGroup;
        $this->helper = $helper;
        $this->_messageManager = $messageManager;
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        try {
            $params = $this->request->getParams();
            $groupModel = $this->customerGroup->create();
            if (isset($params['id'])) {
                $coll=$groupModel->getCollection()->addFieldToFilter('customer_group_id', ['eq' => $params['id']]);
            } else {
                $coll=$groupModel->getCollection()->addFieldToFilter('customer_group_code', ['eq' => $params['code']]);
            }
            if (isset($params['available_shippings'])) {
                $shippings = implode(',', $params['available_shippings']);
            } else {
                $shippings = null;
            }
            if (isset($params['available_payments'])) {
                $payments = implode(',', $params['available_payments']);
            } else {
                $payments = null;
            }
            foreach ($coll as $collection) {
                $collection->setShippingMethods($shippings);
                $collection->setPaymentMethods($payments);
            }
            $coll->save();
        } catch (\Exception $e) {
            $this->_messageManager->addError(__('Something went wrong.'));
        }
    }
}
