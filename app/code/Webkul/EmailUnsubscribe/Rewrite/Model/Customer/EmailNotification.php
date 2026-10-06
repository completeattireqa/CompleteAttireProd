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
namespace Webkul\EmailUnsubscribe\Rewrite\Model\Customer;

use Magento\Customer\Model\EmailNotification as CustomerEmail;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Mail\Template\SenderResolverInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Customer\Helper\View as CustomerViewHelper;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Framework\Exception\LocalizedException;
use Webkul\EmailUnsubscribe\Model\UnsubscribeSellerFactory;
use Webkul\Marketplace\Helper\Data;
use Magento\Customer\Model\CustomerFactory;
use Magento\Customer\Model\CustomerRegistry;

class EmailNotification extends CustomerEmail
{
    private $customerRegistry;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var TransportBuilder
     */
    private $transportBuilder;

    /**
     * @var CustomerViewHelper
     */
    protected $customerViewHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataProcessor;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var SenderResolverInterface
     */
    private $senderResolver;

    public function __construct(
        CustomerRegistry $customerRegistry,
        StoreManagerInterface $storeManager,
        TransportBuilder $transportBuilder,
        CustomerViewHelper $customerViewHelper,
        DataObjectProcessor $dataProcessor,
        ScopeConfigInterface $scopeConfig,
        UnsubscribeSellerFactory $unsubscribeSeller,
        Data $mpHelper,
        CustomerFactory $customerFactory,
        \Magento\Framework\App\Request\Http $request,
        SenderResolverInterface $senderResolver
    ) {
        parent::__construct(
            $customerRegistry,
            $storeManager,
            $transportBuilder,
            $customerViewHelper,
            $dataProcessor,
            $scopeConfig,
            $senderResolver
        );
        $this->customerRegistry = $customerRegistry;
        $this->storeManager = $storeManager;
        $this->transportBuilder = $transportBuilder;
        $this->scopeConfig = $scopeConfig;
        $this->senderResolver = $senderResolver ?: ObjectManager::getInstance()->get(SenderResolverInterface::class);
        $this->unsubscribeSeller = $unsubscribeSeller;
        $this->mpHelper = $mpHelper;
        $this->customerFactory = $customerFactory;
        $this->_request = $request;
    }

    /**
     * Send email with new account related information
     *
     * @param CustomerInterface $customer
     * @param string $type
     * @param string $backUrl
     * @param string $storeId
     * @param string $sendemailStoreId
     * @return void
     * @throws LocalizedException
     */
    public function newAccount(
        CustomerInterface $customer,
        $type = self::NEW_ACCOUNT_EMAIL_REGISTERED,
        $backUrl = '',
        $storeId = 0,
        $sendemailStoreId = null
    ) {
        $types = self::TEMPLATE_TYPES;

        if (!isset($types[$type])) {
            throw new LocalizedException(__('Please correct the transactional account email type.'));
        }

        if (!$storeId) {
            $storeId = $this->getWebsiteStoreId($customer, $sendemailStoreId);
        }

        $store = $this->storeManager->getStore($customer->getStoreId());

        $customerEmailData = $this->getFullCustomerObject($customer);

        $this->sendEmailTemplate(
            $customer,
            $types[$type],
            self::XML_PATH_REGISTER_EMAIL_IDENTITY,
            ['customer' => $customerEmailData, 'back_url' => $backUrl, 'store' => $store],
            $storeId
        );
    }

    /**
     * Send corresponding email template
     *
     * @param CustomerInterface $customer
     * @param string $template configuration path of email template
     * @param string $sender configuration path of email identity
     * @param array $templateParams
     * @param int|null $storeId
     * @param string $email
     * @return void
     * @throws \Magento\Framework\Exception\MailException
     */
    private function sendEmailTemplate(
        $customer,
        $template,
        $sender,
        $templateParams = [],
        $storeId = null,
        $email = null
    ) {
        $sellerId = $this->getSellerId([
            'email' => $customer->getEmail()
        ]);
        $data = $this->_request->getParams();
        $isSeller = 0;
        if ($data['is_seller']) {
            $isSeller = $data['is_seller'];
        }
        if (!$isSeller) {
            $templateParams['unsubscribetext'] = '';
        } else {
            if (!$sellerId) {
                return $this;
            } else {
                $url = $this->storeManager->getStore()->getBaseUrl().'email/index/unsubscribe/seller_id/'.$sellerId;
                $templateParams['unsubscribetext'] = '
                    You have received this message because you subscribed to receive communications 
                    from Complete Attire L.L.C. This email was sent to '.$customer->getEmail().'. If 
                    you prefer not to receive further communications from us. Please visit our <a 
                    href="'.$url.'">Unsubscribe</a> page to be removed from this list.';
            }
        }
        
        $templateId = $this->scopeConfig->getValue($template, 'store', $storeId);
        if ($email === null) {
            $email = $customer->getEmail();
        }

        /** @var array $from */
        $from = $this->senderResolver->resolve(
            $this->scopeConfig->getValue($sender, 'store', $storeId),
            $storeId
        );

        $transport = $this->transportBuilder->setTemplateIdentifier($templateId)
            ->setTemplateOptions(['area' => 'frontend', 'store' => $storeId])
            ->setTemplateVars($templateParams)
            ->setFrom($from)
            ->addTo($email, $this->customerViewHelper->getCustomerName($customer))
            ->getTransport();

        $transport->sendMessage();
    }

    /**
     * Create an object with data merged from Customer and CustomerSecure
     *
     * @param CustomerInterface $customer
     * @return \Magento\Customer\Model\Data\CustomerSecure
     */
    private function getFullCustomerObject($customer)
    {
        // No need to flatten the custom attributes or nested objects since the only usage is for email templates and
        // object passed for events
        $mergedCustomerData = $this->customerRegistry->retrieveSecureData($customer->getId());
        $customerData = $this->dataProcessor
            ->buildOutputDataArray($customer, \Magento\Customer\Api\Data\CustomerInterface::class);
        $mergedCustomerData->addData($customerData);
        $mergedCustomerData->setData('name', $this->customerViewHelper->getCustomerName($customer));
        return $mergedCustomerData;
    }

    /**
     * Get either first store ID from a set website or the provided as default
     *
     * @param CustomerInterface $customer
     * @param int|string|null $defaultStoreId
     * @return int
     */
    private function getWebsiteStoreId($customer, $defaultStoreId = null)
    {
        if ($customer->getWebsiteId() != 0 && empty($defaultStoreId)) {
            $storeIds = $this->storeManager->getWebsite($customer->getWebsiteId())->getStoreIds();
            $defaultStoreId = reset($storeIds);
        }
        return $defaultStoreId;
    }

    /**
     * Send email to customer when his email and password is changed
     *
     * @param CustomerInterface $customer
     * @param string $email
     * @return void
     */
    private function emailAndPasswordChanged(CustomerInterface $customer, $email)
    {
        $storeId = $customer->getStoreId();
        if (!$storeId) {
            $storeId = $this->getWebsiteStoreId($customer);
        }

        $customerEmailData = $this->getFullCustomerObject($customer);

        $this->sendEmailTemplate(
            $customer,
            self::XML_PATH_CHANGE_EMAIL_AND_PASSWORD_TEMPLATE,
            self::XML_PATH_FORGOT_EMAIL_IDENTITY,
            ['customer' => $customerEmailData, 'store' => $this->storeManager->getStore($storeId)],
            $storeId,
            $email
        );
    }

    /**
     * Send email to customer when his email is changed
     *
     * @param CustomerInterface $customer
     * @param string $email
     * @return void
     */
    private function emailChanged(CustomerInterface $customer, $email)
    {
        $storeId = $customer->getStoreId();
        if (!$storeId) {
            $storeId = $this->getWebsiteStoreId($customer);
        }

        $customerEmailData = $this->getFullCustomerObject($customer);

        $this->sendEmailTemplate(
            $customer,
            self::XML_PATH_CHANGE_EMAIL_TEMPLATE,
            self::XML_PATH_FORGOT_EMAIL_IDENTITY,
            ['customer' => $customerEmailData, 'store' => $this->storeManager->getStore($storeId)],
            $storeId,
            $email
        );
    }

    /**
     * Send email to customer when his password is reset
     *
     * @param CustomerInterface $customer
     * @return void
     */
    private function passwordReset(CustomerInterface $customer)
    {
        $storeId = $customer->getStoreId();
        if (!$storeId) {
            $storeId = $this->getWebsiteStoreId($customer);
        }

        $customerEmailData = $this->getFullCustomerObject($customer);

        $this->sendEmailTemplate(
            $customer,
            self::XML_PATH_RESET_PASSWORD_TEMPLATE,
            self::XML_PATH_FORGOT_EMAIL_IDENTITY,
            ['customer' => $customerEmailData, 'store' => $this->storeManager->getStore($storeId)],
            $storeId
        );
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
            $data = $this->_request->getParams();
            if ($data['is_seller']) {
                $isSeller = $data['is_seller'];
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
