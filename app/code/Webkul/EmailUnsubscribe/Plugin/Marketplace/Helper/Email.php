<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_EmailUnsubscribe
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\EmailUnsubscribe\Plugin\Marketplace\Helper;

use Webkul\Marketplace\Helper\Email as MpEmailHelper;
use Webkul\EmailUnsubscribe\Model\UnsubscribeSellerFactory;
use Magento\Customer\Model\CustomerFactory;
use Magento\Store\Model\StoreManagerInterface;
use Webkul\Marketplace\Helper\Data;
use Psr\Log\LoggerInterface;

class Email
{
    /**
     * @var \Webkul\EmailUnsubscribe\Model\UnsubscribeSeller
     */
    protected $unsubscribeSeller;

    /**
     * @var \Magento\Customer\Model\Customer
     */
    protected $customerFactory;

    /**
     * @var \Magento\Store\Model\StoreManager
     */
    protected $_storeManager;

    /**
     * @var \Webkul\Marketplace\Helper\Data
     */
    protected $mpHelper;
    
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @param UnsubscribeSellerFactory    $unsubscribeSeller
     * @param CustomerFactory             $customerFactory
     * @param StoreManagerInterface       $storeManager
     * @param Data                        $mpHelper
     * @param LoggerInterface             $logger
     */
    public function __construct(
        UnsubscribeSellerFactory $unsubscribeSeller,
        CustomerFactory $customerFactory,
        StoreManagerInterface $storeManager,
        Data $mpHelper,
        LoggerInterface $logger
    ) {
        $this->unsubscribeSeller = $unsubscribeSeller;
        $this->customerFactory = $customerFactory;
        $this->_storeManager = $storeManager;
        $this->mpHelper = $mpHelper;
        $this->logger = $logger;
    }

    /**
     * @param MpEmailHelper $subject
     * @param callable $proceed
     * @param array $data
     * @param array $emailTemplateVariables
     * @param array $senderInfo
     * @param array $receiverInfo
     */
    public function aroundSendQuerypartnerEmail(
        MpEmailHelper $subject,
        callable $proceed,
        $data,
        $emailTemplateVariables,
        $senderInfo,
        $receiverInfo
    ) {
        $sellerId = $this->getSellerId($receiverInfo);
        if ($sellerId) {
            $url = $this->_storeManager->getStore()->getBaseUrl().
                'email/index/unsubscribe/seller_id/'.$sellerId;
            // $emailTemplateVariables['email'] = $receiverInfo['email'];
            $emailTemplateVariables['unsubscribetext'] = '
                    You have received this message because you subscribed to receive communications 
                    from Complete Attire L.L.C. This email was sent to '.$receiverInfo['email'].'. If 
                    you prefer not to receive further communications from us. Please visit our <a 
                    href="'.$url.'">Unsubscribe</a> page to be removed from this list.';
            return $proceed($data, $emailTemplateVariables, $senderInfo, $receiverInfo);
        }
    }

    /**
     * @param MpEmailHelper $subject
     * @param callable $proceed
     * @param array $emailTemplateVariables
     * @param array $senderInfo
     * @param array $receiverInfo
     */
    public function aroundSendPlacedOrderEmail(
        MpEmailHelper $subject,
        callable $proceed,
        $emailTemplateVariables,
        $senderInfo,
        $receiverInfo
    ) {
        $sellerId = $this->getSellerId($receiverInfo);
        if ($sellerId) {
            $url = $this->_storeManager->getStore()->getBaseUrl().
                'email/index/unsubscribe/seller_id/'.$sellerId;
            // $emailTemplateVariables['email'] = $receiverInfo['email'];
            $emailTemplateVariables['unsubscribetext'] = '
                    You have received this message because you subscribed to receive communications 
                    from Complete Attire L.L.C. This email was sent to '.$receiverInfo['email'].'. If 
                    you prefer not to receive further communications from us. Please visit our <a 
                    href="'.$url.'">Unsubscribe</a> page to be removed from this list.';
            return $proceed($emailTemplateVariables, $senderInfo, $receiverInfo);
        }
    }

    /**
     * @param MpEmailHelper $subject
     * @param callable $proceed
     * @param array $emailTemplateVariables
     * @param array $senderInfo
     * @param array $receiverInfo
     */
    public function aroundSendInvoicedOrderEmail(
        MpEmailHelper $subject,
        callable $proceed,
        $emailTemplateVariables,
        $senderInfo,
        $receiverInfo
    ) {
        $sellerId = $this->getSellerId($receiverInfo);
        if ($sellerId) {
            $url = $this->_storeManager->getStore()->getBaseUrl().
                'email/index/unsubscribe/seller_id/'.$sellerId;
            // $emailTemplateVariables['email'] = $receiverInfo['email'];
            $emailTemplateVariables['unsubscribetext'] = '
                    You have received this message because you subscribed to receive communications 
                    from Complete Attire L.L.C. This email was sent to '.$receiverInfo['email'].'. If 
                    you prefer not to receive further communications from us. Please visit our <a 
                    href="'.$url.'">Unsubscribe</a> page to be removed from this list.';
            return $proceed($emailTemplateVariables, $senderInfo, $receiverInfo);
        }
    }

    /**
     * @param MpEmailHelper $subject
     * @param callable $proceed
     * @param array $emailTemplateVariables
     * @param array $senderInfo
     * @param array $receiverInfo
     */
    public function aroundSendLowStockNotificationMail(
        MpEmailHelper $subject,
        callable $proceed,
        $emailTemplateVariables,
        $senderInfo,
        $receiverInfo
    ) {
        $sellerId = $this->getSellerId($receiverInfo);
        if ($sellerId) {
            $url = $this->_storeManager->getStore()->getBaseUrl().
                'email/index/unsubscribe/seller_id/'.$sellerId;
            // $emailTemplateVariables['email'] = $receiverInfo['email'];
            $emailTemplateVariables['unsubscribetext'] = '
                    You have received this message because you subscribed to receive communications 
                    from Complete Attire L.L.C. This email was sent to '.$receiverInfo['email'].'. If 
                    you prefer not to receive further communications from us. Please visit our <a 
                    href="'.$url.'">Unsubscribe</a> page to be removed from this list.';
            return $proceed($emailTemplateVariables, $senderInfo, $receiverInfo);
        }
    }

    /**
     * @param MpEmailHelper $subject
     * @param callable $proceed
     * @param array $emailTemplateVariables
     * @param array $senderInfo
     * @param array $receiverInfo
     */
    public function aroundSendSellerPaymentEmail(
        MpEmailHelper $subject,
        callable $proceed,
        $emailTemplateVariables,
        $senderInfo,
        $receiverInfo
    ) {
        $sellerId = $this->getSellerId($receiverInfo);
        if ($sellerId) {
            $url = $this->_storeManager->getStore()->getBaseUrl().
                'email/index/unsubscribe/seller_id/'.$sellerId;
            // $emailTemplateVariables['email'] = $receiverInfo['email'];
            $emailTemplateVariables['unsubscribetext'] = '
                    You have received this message because you subscribed to receive communications 
                    from Complete Attire L.L.C. This email was sent to '.$receiverInfo['email'].'. If 
                    you prefer not to receive further communications from us. Please visit our <a 
                    href="'.$url.'">Unsubscribe</a> page to be removed from this list.';
            return $proceed($emailTemplateVariables, $senderInfo, $receiverInfo);
        }
    }

    /**
     * @param MpEmailHelper $subject
     * @param callable $proceed
     * @param array $emailTemplateVariables
     * @param array $senderInfo
     * @param array $receiverInfo
     */
    public function aroundSendProductStatusMail(
        MpEmailHelper $subject,
        callable $proceed,
        $emailTemplateVariables,
        $senderInfo,
        $receiverInfo
    ) {
        $sellerId = $this->getSellerId($receiverInfo);
        if ($sellerId) {
            $url = $this->_storeManager->getStore()->getBaseUrl().
                'email/index/unsubscribe/seller_id/'.$sellerId;
            // $emailTemplateVariables['email'] = $receiverInfo['email'];
            $emailTemplateVariables['unsubscribetext'] = '
                    You have received this message because you subscribed to receive communications 
                    from Complete Attire L.L.C. This email was sent to '.$receiverInfo['email'].'. If 
                    you prefer not to receive further communications from us. Please visit our <a 
                    href="'.$url.'">Unsubscribe</a> page to be removed from this list.';
            return $proceed($emailTemplateVariables, $senderInfo, $receiverInfo);
        }
    }

    /**
     * @param MpEmailHelper $subject
     * @param callable $proceed
     * @param array $emailTemplateVariables
     * @param array $senderInfo
     * @param array $receiverInfo
     */
    public function aroundSendProductUnapproveMail(
        MpEmailHelper $subject,
        callable $proceed,
        $emailTemplateVariables,
        $senderInfo,
        $receiverInfo
    ) {
        $sellerId = $this->getSellerId($receiverInfo);
        if ($sellerId) {
            $url = $this->_storeManager->getStore()->getBaseUrl().
                'email/index/unsubscribe/seller_id/'.$sellerId;
            // $emailTemplateVariables['email'] = $receiverInfo['email'];
            $emailTemplateVariables['unsubscribetext'] = '
                    You have received this message because you subscribed to receive communications 
                    from Complete Attire L.L.C. This email was sent to '.$receiverInfo['email'].'. If 
                    you prefer not to receive further communications from us. Please visit our <a 
                    href="'.$url.'">Unsubscribe</a> page to be removed from this list.';
            return $proceed($emailTemplateVariables, $senderInfo, $receiverInfo);
        }
    }

    /**
     * @param MpEmailHelper $subject
     * @param callable $proceed
     * @param array $emailTemplateVariables
     * @param array $senderInfo
     * @param array $receiverInfo
     */
    public function aroundSendSellerApproveMail(
        MpEmailHelper $subject,
        callable $proceed,
        $emailTemplateVariables,
        $senderInfo,
        $receiverInfo
    ) {
        $sellerId = $this->getSellerId($receiverInfo);
        if ($sellerId) {
            $url = $this->_storeManager->getStore()->getBaseUrl().
                'email/index/unsubscribe/seller_id/'.$sellerId;
            // $emailTemplateVariables['email'] = $receiverInfo['email'];
            $emailTemplateVariables['unsubscribetext'] = '
                    You have received this message because you subscribed to receive communications 
                    from Complete Attire L.L.C. This email was sent to '.$receiverInfo['email'].'. If 
                    you prefer not to receive further communications from us. Please visit our <a 
                    href="'.$url.'">Unsubscribe</a> page to be removed from this list.';
            return $proceed($emailTemplateVariables, $senderInfo, $receiverInfo);
        }
    }

    /**
     * @param MpEmailHelper $subject
     * @param callable $proceed
     * @param array $emailTemplateVariables
     * @param array $senderInfo
     * @param array $receiverInfo
     */
    public function aroundSendSellerDisapproveMail(
        MpEmailHelper $subject,
        callable $proceed,
        $emailTemplateVariables,
        $senderInfo,
        $receiverInfo
    ) {
        $sellerId = $this->getSellerId($receiverInfo);
        if ($sellerId) {
            $url = $this->_storeManager->getStore()->getBaseUrl().
                'email/index/unsubscribe/seller_id/'.$sellerId;
            // $emailTemplateVariables['email'] = $receiverInfo['email'];
            $emailTemplateVariables['unsubscribetext'] = '
                    You have received this message because you subscribed to receive communications 
                    from Complete Attire L.L.C. This email was sent to '.$receiverInfo['email'].'. If 
                    you prefer not to receive further communications from us. Please visit our <a 
                    href="'.$url.'">Unsubscribe</a> page to be removed from this list.';
            return $proceed($emailTemplateVariables, $senderInfo, $receiverInfo);
        }
    }

    /**
     * @param MpEmailHelper $subject
     * @param callable $proceed
     * @param array $emailTemplateVariables
     * @param array $senderInfo
     * @param array $receiverInfo
     */
    public function aroundSendSellerDenyMail(
        MpEmailHelper $subject,
        callable $proceed,
        $emailTemplateVariables,
        $senderInfo,
        $receiverInfo
    ) {
        $sellerId = $this->getSellerId($receiverInfo);
        if ($sellerId) {
            $url = $this->_storeManager->getStore()->getBaseUrl().
                'email/index/unsubscribe/seller_id/'.$sellerId;
            // $emailTemplateVariables['email'] = $receiverInfo['email'];
            $emailTemplateVariables['unsubscribetext'] = '
                    You have received this message because you subscribed to receive communications 
                    from Complete Attire L.L.C. This email was sent to '.$receiverInfo['email'].'. If 
                    you prefer not to receive further communications from us. Please visit our <a 
                    href="'.$url.'">Unsubscribe</a> page to be removed from this list.';
            return $proceed($emailTemplateVariables, $senderInfo, $receiverInfo);
        }
    }

    /**
     * @param MpEmailHelper $subject
     * @param callable $proceed
     * @param array $emailTemplateVariables
     * @param array $senderInfo
     * @param array $receiverInfo
     */
    public function aroundSendProductDenyMail(
        MpEmailHelper $subject,
        callable $proceed,
        $emailTemplateVariables,
        $senderInfo,
        $receiverInfo
    ) {
        $sellerId = $this->getSellerId($receiverInfo);
        if ($sellerId) {
            $url = $this->_storeManager->getStore()->getBaseUrl().
                'email/index/unsubscribe/seller_id/'.$sellerId;
            // $emailTemplateVariables['email'] = $receiverInfo['email'];
            $emailTemplateVariables['unsubscribetext'] = '
                    You have received this message because you subscribed to receive communications 
                    from Complete Attire L.L.C. This email was sent to '.$receiverInfo['email'].'. If 
                    you prefer not to receive further communications from us. Please visit our <a 
                    href="'.$url.'">Unsubscribe</a> page to be removed from this list.';
            return $proceed($emailTemplateVariables, $senderInfo, $receiverInfo);
        }
    }

    public function aroundGenerateTemplate(
        MpEmailHelper $subject,
        callable $proceed,
        $emailTemplateVariables,
        $senderInfo,
        $receiverInfo
    ) {
        if (!isset($emailTemplateVariables['unsubscribetext'])) {
            $emailTemplateVariables['unsubscribetext'] = '';
        }
        return $proceed($emailTemplateVariables, $senderInfo, $receiverInfo);
    }

    /**
     * Get Seller Id from the receiver info.
     * @param array $receiverInfo
     * @return int $sellerId
     */
    public function getSellerId($receiverInfo)
    {
        $sellerId = 0;
        $customer = $this->customerFactory->create()->getCollection()
            ->addFieldToFilter(
                'email',
                $receiverInfo['email']
            );

        if (count($customer)) {
            foreach ($customer as $cust) {
                $sellerId = $cust->getId();
            }
        }
        
        if ($sellerId) {
            $isSeller = 0;
            $model = $this->mpHelper->getSellerCollectionObj($sellerId);
            foreach ($model as $value) {
                $isSeller = 1;
            }
            if ($isSeller) {
                $sellerColl = $this->unsubscribeSeller->create()->getCollection()
                    ->addFieldToFilter(
                        'seller_id',
                        $sellerId
                    )->addFieldToFilter(
                        'status',
                        1
                    );
                if (count($sellerColl)) {
                    return false;
                }
            }
        }
        return $sellerId;
    }
}
