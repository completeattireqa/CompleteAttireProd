<?php
/**
 * Webkul Software.
 *
 * @category Webkul
 *
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\MpBraintree\Model;

use Braintree\WebhookNotification;
use Magento\Customer\Model\Session;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Order\Payment\Transaction;
use Magento\Sales\Model\Order\Email\Sender\InvoiceSender;
use Webkul\MpBraintree\Logger\CronLogger as Logger;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Braintree\Model\Adapter\BraintreeSearchAdapter;

class BraintreeHooksManager implements \Webkul\MpBraintree\Api\BraintreeHooksManagerInterface
{

    /**
     * @var Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * $_scopeConfig.
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * $_helper.
     *
     * @var \Webkul\MpBraintree\Helper\Data
     */
    protected $_helper;

    /**
     * $_orderRepository.
     *
     * @var OrderRepositoryInterface
     */
    protected $_orderRepository;

    /**
     * $_transactionBuilder.
     *
     * @var Transaction
     */
    protected $_transactionBuilder;

    /**
     * @var InvoiceSender
     */
    protected $_invoiceSender;

    /**
     * $_checkoutSession.
     *
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * $_logger.
     *
     * @var Webkul\MpBraintree\Logger\BraintreeLogger
     */
    protected $_logger;

    /**
     * @var PriceCurrencyInterface
     */
    protected $_priceCurrency;

    /**
     * ObjectManager
     */
    protected $_objectManager;

    /**
     * braintree configurationBraintree_WebhookNotification
     *
     * @var Webkul\Braintree\Gateway\Config\Config
     */
    protected $config;
    
    /**
     * braintree payment adapter
     *
     * @var Webkul\Braintree\Model\Adapter\MpBraintreeAdapter
     */
    protected $adapter;

    /**
     * webhook notification data
     *
     * @var array
     */
    protected $_webhookNotification = [];

    /**
     * @var BraintreeSearchAdapter
     */
    protected $braintreeSearchAdapter;

    /**
     * @var Magento\Customer\Model\CustomerFactory
     */
    protected $customerFactory;

    /**
     * @var Webkul\Marketplace\Model\Product
     */
    protected $marketplaceProducts;

    /**
     * @var \Webkul\Marketplace\Model\Seller
     */
    protected $marketplaceSeller;

    /**
     * @var Magento\ConfigurableProduct\Model\ResourceModel\Product\Type\Configurable
     */
    protected $configurableType;

    /**
     * @var Magento\Catalog\Model\Product\Action
     */
    protected $catalogAction;

    /**
     * @var Webkul\MpBraintree\Model\BraintreeOrderManagement
     */
    protected $braintreeOrderManager;

    /**
     * @var \Webkul\Marketplace\Model\Sellertransaction
     */
    protected $sellerTransaction;

    /**
     * @var Webkul\MpBraintree\Model\Email
     */
    protected $emailSender;

    public function __construct(
        Session $customerSession,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Webkul\MpBraintree\Helper\Data $helper,
        OrderRepositoryInterface $orderRepository,
        \Magento\Checkout\Model\Session $checkoutSession,
        Transaction\BuilderInterface $transactionBuilder,
        InvoiceSender $invoiceSender,
        PriceCurrencyInterface $priceCurrency,
        Logger $logger,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Webkul\MpBraintree\Gateway\Config\Config $config,
        \Webkul\MpBraintree\Model\Adapter\MpBraintreeAdapter $adapter,
        BraintreeSearchAdapter $braintreeSearchAdapter,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Webkul\Marketplace\Model\ProductFactory $marketplaceProductsFactory,
        \Magento\ConfigurableProduct\Model\ResourceModel\Product\Type\Configurable $configurableType,
        \Magento\Catalog\Model\Product\Action $catalogAction,
        \Webkul\Marketplace\Model\SellerFactory $marketplaceSeller,
        \Webkul\MpBraintree\Model\BraintreeOrderManagement $braintreeOrderManager,
        \Webkul\Marketplace\Model\SellertransactionFactory $sellerTransaction,
        \Webkul\MpBraintree\Model\Email $emailSender
    ) {
        $this->_helper = $helper;
        $this->_customerSession = $customerSession;
        $this->_scopeConfig = $scopeConfig;
        $this->_orderRepository = $orderRepository;
        $this->_checkoutSession = $checkoutSession;
        $this->_transactionBuilder = $transactionBuilder;
        $this->_invoiceSender = $invoiceSender;
        $this->_logger = $logger;
        $this->_priceCurrency = $priceCurrency;
        $this->_objectManager = $objectManager;
        $this->config = $config;
        $this->adapter = $adapter;
        $this->braintreeSearchAdapter = $braintreeSearchAdapter;
        $this->_customerFactory = $customerFactory;
        $this->marketplaceProducts = $marketplaceProductsFactory;
        $this->configurableType = $configurableType;
        $this->catalogAction = $catalogAction;
        $this->marketplaceSeller = $marketplaceSeller;
        $this->braintreeOrderManager = $braintreeOrderManager;
        $this->sellerTransaction = $sellerTransaction;
        $this->emailSender = $emailSender;
    }

    /**
     * parse webhook data from braintree
     *
     * @param array $post
     * @return void
     */
    public function parseHooksData($post)
    {
        if (isset($post["bt_signature"]) &&
            isset($post["bt_payload"])
        ) {
            $this->_webhookNotification = $this->adapter->webhookParse(
                $post["bt_signature"],
                $post["bt_payload"]
            );
            $this->_logger->debug('webkook notification received: '.print_r($this->_webhookNotification));
            try {
                switch ($webhookNotification->kind) {
                    case WebhookNotification::SUB_MERCHANT_ACCOUNT_APPROVED:
                        $this->subMerchantApprovedHandler();
                        break;
                    case WebhookNotification::SUB_MERCHANT_ACCOUNT_DECLINED:
                        $this->subMerchantDeclinedHandler();
                        break;
                    case WebhookNotification::DISBURSEMENT_EXCEPTION:
                        $this->disbursementExceptionHandler();
                        break;
                    case WebhookNotification::DISBURSEMENT:
                        $this->disbursementHandler();
                        break;
                    case WebhookNotification::TRANSACTION_DISBURSED:
                        $this->transactionDisbursementHandler();
                        break;
                    case WebhookNotification::DISPUTE_OPENED:
                        $this->disputeOpenHandler();
                        break;
                    case WebhookNotification::DISPUTE_WON:
                        $this->disputeWonHandler();
                        break;
                    case WebhookNotification::DISPUTE_LOST:
                        $this->disputeLostHandler();
                        break;
                    default:
                        $this->_logger->debug("not able to find any webhook kind");
                }
            } catch (\Exception $e) {
                $this->_logger->debug("Hook Manager: Exception : ".print_r($e->getStackTrace(), true));
            }
        } else {
            // $this->emailSender->sendSellerDeclineMail(
            //     ['myvar1' => "test name", 'myvar2' => "this is test message"],
            //     ['name' => "test name", 'email' => "ashutosh045@webkul.com"]
            // );
            $this->_logger->debug("invalid request: ".print_r($post, true));
        }
    }

    /**
     * sub merchant approved handler
     *
     * @return void
     */
    public function subMerchantApprovedHandler()
    {
        $this->_logger->debug("Hook Manager: Hook for sub merchant approval called : ", (array)$post);
        $status = $this->_webhookNotification->merchantAccount->status;
        $merchantId = $this->_webhookNotification->merchantAccount->id;
        $customer = $this->_customerFactory->create()->getCollection()->addFieldToFilter('braintree_submerchant_id', ['eq'=>$merchantId]);
        if ($customer->getSize()) {
            $this->updateSubmerchantStatus($customer, $status);
            $this->_logger->debug("Hook Manager: submerchant status updated to : ".$status." for email ".$customer->getEmail());
        } else {
            $this->_logger->debug("Hook Manager: merchant id not found : ".$merchantId);
        }
    }

    /**
     * sub merchant declined handler
     *
     * @return void
     */
    public function subMerchantDeclinedHandler()
    {
        $this->_logger->debug("Hook for sub merchant decline called : ", (array)$post);
        $status = $this->_webhookNotification->merchantAccount->status;
        $merchantId = $this->_webhookNotification->merchantAccount->id;
        $exceptionMessage = $this->_webhookNotification->message;
        $customerCol = $this->_customerFactory->create()->getCollection()->addFieldToFilter('braintree_submerchant_id', ['eq'=>$merchantId]);
        if ($customerCol->getSize()) {
            $customer = $customerCol->getLastItem();
            $this->updateSubmerchantStatus($customer, $status);
            $this->emailSender->sendSellerDeclineMail(
                ['myvar1' => $customer->getName(), 'myvar2' => $exceptionMessage],
                ['name' => $customer->getName(), 'email' => $customer->getEmail()]
            );
            $this->_logger->debug("Hook Manager: submerchant status updated to : ".$status." for email ".$customer->getEmail());
        } else {
            $this->_logger->debug("Hook Manager: merchant id not found : ".$merchantId);
        }
    }

    /**
     * bank transfer error handler for merchant
     *
     * @return void
     */
    public function disbursementExceptionHandler()
    {
        $this->_logger->debug("Hook for disbursement exception : ", (array)$post);
        $transactionIds = $this->_webhookNotification->disbursement->transactionIds;

        $submerchantAccount = $this->_webhookNotification->disbursement->merchantAccount->id;

        $exceptionMessage = $this->_webhookNotification->disbursement->exceptionMessage;
        foreach ($transactionIds as $txnId) {
            $transaction = $this->braintreeOrderManager->getTransactionByTxnId($txnId);
            $transaction->setIsClosed(0);
            $sellerTrn = $this->sellerTransaction->create()->getCollection->addFieldToFilter("onlinetr_id", ['eq' => $transaction->getTransactionId()]);
            if ($sellerTrn->getSize() > 0) {
                foreach ($sellerTrn as $trn) {
                    $trn->setCustomNote("Payment didn't transfer to Bank-". $exceptionMessage)->save();
                }
            }
            $transaction->save();
        }

        $customerCol = $this->_customerFactory->create()->getCollection()->addFieldToFilter('braintree_submerchant_id', ['eq'=>$merchantId]);
        if ($customerCol->getSize()) {
            $customer = $customerCol->getLastItem();
            $this->updateSubmerchantStatus($customer, $status);
            $this->emailSender->sendSellerDeclineMail(
                ['myvar1' => $customer->getName(), 'myvar2' => $exceptionMessage],
                ['name' => $customer->getName(), 'email' => $customer->getEmail()]
            );
            $this->_logger->debug("Hook Manager: submerchant status updated to : ".$status." for email ".$customer->getEmail());
        } else {
            $this->_logger->debug("Hook Manager: merchant id not found : ".$merchantId);
        }
    }

    /**
     * bank transfer success handler for transaction of merchant
     *
     * @return void
     */
    public function disbursementHandler()
    {
        $this->_logger->debug("Hook for disbursement : ", (array)$post);
        $success = $webhookNotification->disbursement->success;
        $transactionIds = $webhookNotification->disbursement->transactionIds;
        $submerchantAccount = $webhookNotification->disbursement->merchantAccount->id;
        if ($success) {
            foreach ($transactionIds as $txnId) {
                $transaction = $this->braintreeOrderManager->getTransactionByTxnId($txnId);
                $transaction->setIsClosed(1);
                $sellerTrn = $this->sellerTransaction->create()->getCollection->addFieldToFilter("onlinetr_id", ['eq' => $transaction->getTransactionId()]);
                if ($sellerTrn->getSize() > 0) {
                    foreach ($sellerTrn as $trn) {
                        $trn->setCustomNote("Payment transfer to Bank")->save();
                    }
                }
                $transaction->save();
            }
        } else {
            $customerCol = $this->_customerFactory->create()->getCollection()->addFieldToFilter('braintree_submerchant_id', ['eq'=>$merchantId]);
            if ($customerCol->getSize()) {
                $customer = $customerCol->getLastItem();
                $this->updateSubmerchantStatus($customer, $status);
                $this->emailSender->sendSellerDeclineMail(
                    ['myvar1' => $customer->getName(), 'myvar2' => $exceptionMessage],
                    ['name' => $customer->getName(), 'email' => $customer->getEmail()]
                );
                $this->_logger->debug("Hook Manager: submerchant status updated to : ".$status." for email ".$customer->getEmail());
            } else {
                $this->_logger->debug("Hook Manager: merchant id not found : ".$merchantId);
            }
        }
    }

    /**
     * bank transfer success handler for single transaction of merchant
     *
     * @return void
     */
    public function transactionDisbursementHandler()
    {
        $this->_logger->debug("Hook for transaction disbursement : ", (array)$post);
        $disbursementDetails = $webhookNotification->transaction->disbursementDetails;
        $success = $disbursementDetails->success;
        $txnId = $webhookNotification->transaction->id;
        $submerchantAccount = $webhookNotification->transaction->merchantAccountId;
        if ($success) {
            $transaction = $this->braintreeOrderManager->getTransactionByTxnId($txnId);
            $sellerTrn = $this->sellerTransaction->create()->getCollection->addFieldToFilter("onlinetr_id", ['eq' => $transaction->getTransactionId()]);
            if ($sellerTrn->getSize() > 0) {
                foreach ($sellerTrn as $trn) {
                    $trn->setCustomNote("Payment transfer to Bank")->save();
                }
            }
            $transaction->save();
        } else {
            $customerCol = $this->_customerFactory->create()->getCollection()->addFieldToFilter('braintree_submerchant_id', ['eq'=>$merchantId]);
            if ($customerCol->getSize()) {
                $customer = $customerCol->getLastItem();
                $this->updateSubmerchantStatus($customer, $status);
                $this->emailSender->sendSellerDeclineMail(
                    ['myvar1' => $customer->getName(), 'myvar2' => $exceptionMessage],
                    ['name' => $customer->getName(), 'email' => $customer->getEmail()]
                );
                $this->_logger->debug("Hook Manager: submerchant status updated to : ".$status." for email ".$customer->getEmail());
            } else {
                $this->_logger->debug("Hook Manager: merchant id not found : ".$merchantId);
            }
        }
    }

    /**
     * payment despute open at braintree
     *
     * @return void
     */
    public function disputeOpenHandler()
    {
        $this->_logger->debug("Hook for despute open : ", (array)$post);
        $dispute = $this->_webhookNotification->dispute;
        $txnId = $this->_webhookNotification->dispute->transaction->id;
        $message = "Dispute has been opened by the customer ".$dispute->reason;
        $transaction = $this->braintreeOrderManager->getTransactionByTxnId($txnId);
        $sellerTrn = $this->sellerTransaction->create()->getCollection->addFieldToFilter("onlinetr_id", ['eq' => $transaction->getTransactionId()]);
        if ($sellerTrn->getSize() > 0) {
            foreach ($sellerTrn as $trn) {
                $trn->setCustomNote($message)->save();
            }
        }
    }

    /**
     * payment despute won at braintree
     *
     * @return void
     */
    public function disputeWonHandler()
    {
        $this->_logger->debug("Hook for dispute won : ", (array)$post);
        $dispute = $this->_webhookNotification->dispute;
        $txnId = $this->_webhookNotification->transaction->id;
        $message = "Dispute won-reverse transaction ".$dispute->reason;
        $transaction = $this->braintreeOrderManager->getTransactionByTxnId($txnId);
        $sellerTrn = $this->sellerTransaction->create()->getCollection->addFieldToFilter("onlinetr_id", ['eq' => $transaction->getTransactionId()]);
        if ($sellerTrn->getSize() > 0) {
            foreach ($sellerTrn as $trn) {
                $trn->setCustomNote($message)->save();
            }
        }
    }

    /**
     * payment despute lost at braintree
     *
     * @return void
     */
    public function disputeLostHandler()
    {
        $this->_logger->debug("Hook for dispute lost : ", (array)$post);
        $dispute = $this->_webhookNotification->dispute;
        $txnId = $this->_webhookNotification->transaction->id;
        $message = "Dispute lost-no further action required ".$dispute->reason;
        $transaction = $this->braintreeOrderManager->getTransactionByTxnId($txnId);
        $sellerTrn = $this->sellerTransaction->create()->getCollection->addFieldToFilter("onlinetr_id", ['eq' => $transaction->getTransactionId()]);
        if ($sellerTrn->getSize() > 0) {
            foreach ($sellerTrn as $trn) {
                $trn->setCustomNote($message)->save();
            }
        }
    }

    /**
     * update seller submerchant status
     *
     * @param int $customerId
     * @return bool
     */
    public function updateSubmerchantStatus($customer, $status)
    {
        try {
            $customerModel = $customer->getDataModel();
            $customerModel->setCustomAttribute("sub_merchant_status", $status);
            $customer->updateData()->save();
            if (!$status) {
                $status = $this->disableSeller($customer->getId());
                $this->disableSellerProducts($customer->getId());
            }
            return true;
        } catch (\Exception $e) {
            return false;
            $this->_logger->debug("Hook Manager: submerchant seller failed");
        }
    }

    /**
     * disbale seller
     *
     * @param inty $sellerId
     * @return bool
     */
    public function disableSeller($sellerId)
    {
        try {
            $sellers = $this->marketplaceSeller->create()
            ->getCollection()
            ->addFieldToFilter('seller_id', $seller->getSellerId());
            if ($sellers->getSize() > 0) {
                foreach ($sellers as $seller) {
                    $seller->setIsSeller(0)->save();
                    return true;
                }
            }
        } catch (\Exception $e) {
            return false;
            $this->_logger->debug("Hook Manager: seller disable failed: ".$e->getMessage());
        }
    }


    /**
     * disable seller products if seller is on vacation.
     *
     * @param id $sellerId seller id
     */
    public function disableSellerProducts($sellerId)
    {
        $status = \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_DISABLED;
        $allStores = $this->getAllStores();
        $productIds = [];
        $sellerProducts = $this->getSellerProductData($sellerId);
        if ($sellerProducts->getSize() > 0) {
            foreach ($sellerProducts as $productInfo) {
                if ($productInfo->getMageproductId()) {
                    if ($this->checkIfAssociate($productInfo->getMageproductId())) {
                        continue;
                    }
                    $productIds[] = $productInfo->getMageproductId();
                    $productInfo->setStatus(2);
                    $productInfo->save();
                }
            }
            foreach ($allStores as $storeId) {
                $this->catalogAction->updateAttributes($productIds, ['status' => $status], $storeId);
            }
        }
    }

    /**
     * function to get sellers products.
     *
     * @param int $sellerId seller id
     *
     * @return \Webkul\Marketplace\Model\Product
     */
    public function getSellerProductData($sellerId)
    {
        $model = $this->marketplaceProducts->create()
                    ->getCollection()
                    ->addFieldToFilter('seller_id', ['eq' => $sellerId]);

        return $model;
    }

    /**
     * check if product is child product.
     *
     * @param int $productId product id
     *
     * @return bool
     */
    public function checkIfAssociate($productId)
    {
        $product = $this->configurableType->getParentIdsByChild($productId);
        if (isset($product[0])) {
            return true;
        }

        return false;
    }
}
