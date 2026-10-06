<?php
/**
 * Webkul Software
 *
 * @category  Webkul
 * @package   Webkul_MpBraintree
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\MpBraintree\Model\Adapter;

use Braintree\ClientToken;
use Braintree\Configuration;
use Braintree\CreditCard;
use Braintree\Customer;
use Braintree\PaymentMethod;
use Braintree\PaymentMethodNonce;
use Braintree\Transaction;
use Braintree\MerchantAccount;
use Webkul\MpBraintree\Gateway\Config\Config as MpBraintreeConfig;
use Webkul\MpBraintree\Model\Source\Environment;
use Braintree\Exception\NotFound;
use Braintree\WebhookNotification;

/**
 * Class MpBraintreeAdapter
 * @codeCoverageIgnore
 */
class MpBraintreeAdapter
{

    /**
     * @var Config
     */
    private $config;

    /**
     * @var Magento\Store\Api\Data\StoreInterface
     */
    protected $store;

    /**
     * @param Config $config
     */
    public function __construct(MpBraintreeConfig $config, \Magento\Store\Api\Data\StoreInterface $store)
    {
        $this->config = $config;
        $this->store = $store;
        $this->initCredentials();
    }

    /**
     * Initializes credentials.
     *
     * @return void
     */
    protected function initCredentials()
    {
        if ($this->config->getValue(MpBraintreeConfig::KEY_ENVIRONMENT) == Environment::ENVIRONMENT_PRODUCTION) {
            $this->environment(Environment::ENVIRONMENT_PRODUCTION);
        } else {
            $this->environment(Environment::ENVIRONMENT_SANDBOX);
        }
        $this->merchantId($this->config->getValue(MpBraintreeConfig::KEY_MERCHANT_ID, $this->store->getId()));
        $this->publicKey($this->config->getValue(MpBraintreeConfig::KEY_PUBLIC_KEY, $this->store->getId()));
        $this->privateKey($this->config->getValue(MpBraintreeConfig::KEY_PRIVATE_KEY, $this->store->getId()));
    }

    /**
     * @param string|null $value
     * @return mixed
     */
    public function environment($value = null)
    {
        return Configuration::environment($value);
    }

    /**
     * @param string|null $value
     * @return mixed
     */
    public function merchantId($value = null)
    {
        return Configuration::merchantId($value);
    }

    /**
     * @param string|null $value
     * @return mixed
     */
    public function privateKey($value = null)
    {
        return Configuration::privateKey($value);
    }

    /**
     * @param string|null $value
     * @return mixed
     */
    public function publicKey($value = null)
    {
        return Configuration::publicKey($value);
    }

    /**
     * @param string $token
     * @return \Braintree\CreditCard|null
     */
    public function find($token)
    {
        try {
            return CreditCard::find($token);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * @param array $filters
     * @return \Braintree\ResourceCollection
     */
    public function search(array $filters)
    {
        return Transaction::search($filters);
    }

    /**
     * @param array $params
     * @return \Braintree\Result\Successful|\Braintree\Result\Error|null
     */
    public function generate(array $params = [])
    {
        try {
            return ClientToken::generate($params);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param string $token
     * @return \Braintree\Result\Successful|\Braintree\Result\Error
     */
    public function createNonce($token)
    {
        return PaymentMethodNonce::create($token);
    }

    /**
     * @param array $attributes
     * @return \Braintree\Result\Successful|\Braintree\Result\Error
     */
    public function sale(array $attributes)
    {
        $sellerId = 0;
        if (isset($attributes['seller_id'])) {
            $sellerId = $attributes['seller_id'];
            unset($attributes['seller_id']);
        }
        $transaction = Transaction::sale($attributes);
        if ($transaction->transaction instanceof Transaction) {
            $transaction->transaction->sellerId = $sellerId;
        }
        
        return $transaction;
    }

    /**
     * @param string $transactionId
     * @param null|float $amount
     * @return \Braintree\Result\Successful|\Braintree\Result\Error
     */
    public function submitForSettlement($transactionId, $amount = null)
    {
        return Transaction::submitForSettlement($transactionId, $amount);
    }

    /**
     * @param string $transactionId
     * @return \Braintree\Result\Successful|\Braintree\Result\Error
     */
    public function void($transactionId)
    {
        return Transaction::void($transactionId);
    }

    /**
     * @param string $transactionId
     * @param null|float $amount
     * @return \Braintree\Result\Successful|\Braintree\Result\Error
     */
    public function refund($transactionId, $amount = null)
    {
        if ($amount && $amount > 0) {
            return Transaction::refund($transactionId, $amount);
        } else {
            return Transaction::refund($transactionId);
        }
    }

    /**
     * Clone original transaction
     * @param string $transactionId
     * @param array $attributes
     * @return mixed
     */
    public function cloneTransaction($transactionId, array $attributes)
    {
        return Transaction::cloneTransaction($transactionId, $attributes);
    }

    /**
     * create submerchant
     * @param array $data
     * @return mixed
     */
    public function addSubMerchant(array $data)
    {
        $data['masterMerchantAccountId'] = $this->config->getMerchantAccountId($this->store->getId());
        return MerchantAccount::create($data);
    }

    /**
     * update submerchant
     * @param string $submerchantId
     * @param array $data
     * @return mixed
     */
    public function updateSubMerchant($submerchantId, array $data)
    {
        $data['masterMerchantAccountId'] = $this->config->getMerchantAccountId($this->store->getId());
        return MerchantAccount::update($submerchantId, $data);
    }

    /**
     * find submerchant
     * @param string $submerchantId
     * @return mixed
     */
    public function findSubMerchant($submerchantId)
    {
        return MerchantAccount::find($submerchantId);
    }

    /**
     * create customer for merchant
     * @param array $data
     * @return mixed
     */
    public function createCustomer(array $data)
    {
        return Customer::create($data);
    }

    /**
     * create payment method for customer
     * @param array $data
     * @return mixed
     */
    public function createPaymentMethod(array $data)
    {
        return PaymentMethod::create($data);
    }

    /**
     * find customer by id on merchant account
     *
     * @param string $id
     *
     * @return string|boolean
     */
    public function findCustomer($id)
    {
        try {
            return Customer::find($id);
        } catch (NotFound $e) {
            return false;
        }
    }

    /**
     * hold transaction in escrow on merchant account
     *
     * @param string $id
     *
     * @return mixed
     */
    public function holdInEscrow($id)
    {
        return Transaction::holdInEscrow($id);
    }

    /**
     * parse webhook notification
     *
     * @param string $signature
     * @param string $payload
     * @return mixed
     */
    public function webhookParse($signature, $payload)
    {
        return WebhookNotification::parse($signature, $payload);
    }

    /**
     * notifindTransactionfication
     *
     * @param string $transactionId
     * @return mixed
     */
    public function findTransaction($transactionId)
    {
        return Transaction::find($transactionId);
    }

    /**
     * release funds from escrow
     *
     * @param string $transactionId
     * @return mixed
     */
    public function releaseFromEscrow($transactionId)
    {
        return Transaction::releaseFromEscrow($transactionId);
    }
}
