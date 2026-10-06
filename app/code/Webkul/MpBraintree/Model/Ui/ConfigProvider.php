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
namespace Webkul\MpBraintree\Model\Ui;

use Webkul\MpBraintree\Gateway\Request\SellerDataBuilder;
use Magento\Checkout\Model\ConfigProviderInterface;
use Webkul\MpBraintree\Gateway\Config\Config;
use Webkul\MpBraintree\Model\Adapter\MpBraintreeAdapter;
use Magento\Framework\Locale\ResolverInterface;

/**
 * Class ConfigProvider
 */
final class ConfigProvider implements ConfigProviderInterface
{
    const CODE = 'mpbraintree';

    // const CC_VAULT_CODE = 'mpbraintree_cc_vault';

    /**
     * @var Config
     */
    private $config;

    /**
     * @var BraintreeAdapter
     */
    private $adapter;

    /**
     * @var string
     */
    private $clientToken = '';

    /**
     * @var Magento\Store\Api\Data\StoreInterface
     */
    protected $store;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * Constructor
     *
     * @param Config $config
     * @param PayPalConfig $payPalConfig No longer used by internal code and not recommended.
     * @param BraintreeAdapter $adapter
     * @param ResolverInterface $localeResolver No longer used by internal code and not recommended.
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __construct(
        Config $config,
        MpBraintreeAdapter $adapter,
        ResolverInterface $localeResolver,
        \Magento\Store\Api\Data\StoreInterface $store,
        \Magento\Customer\Model\Session $customerSession
    ) {
        $this->config = $config;
        $this->adapter = $adapter;
        $this->store = $store;
        $this->customerSession = $customerSession;
    }

    /**
     * Retrieve assoc array of checkout configuration
     *
     * @return array
     */
    public function getConfig()
    {
        //echo $this->config->getMerchantId();die;
        return [
            'payment' => [
                self::CODE => [
                    'isActive' => $this->config->isActive($this->store->getId()),
                    'environment' => $this->config->getEnvironment(),
                    'merchantId' => $this->config->getMerchantId($this->store->getId()),
                    'tokenizationKey' => $this->config->getTokenizationKey($this->store->getId()),
                    'locale' => strtolower($this->store->getLocaleCode()),
                    'clientToken' => $this->getClientToken(),
                    'vaultEnable' => $this->config->getCcVaultActive()
                ]
            ]
        ];
    }

    /**
     * Generate a new client token if necessary
     * @return string
     */
    public function getClientToken()
    {
        if (empty($this->clientToken)) {
            $params = [];

            $merchantAccountId = $this->config->getMerchantAccountId($this->store->getId());
            if (!empty($merchantAccountId)) {
                $params[SellerDataBuilder::MERCHANT_ACCOUNT_ID] = $merchantAccountId;
                $params["version"] = 3;
                
                if ($this->customerSession->getCustomerId() && $this->config->getCcVaultActive()) {
                    $braintreeCustomer = $this->adapter->findCustomer('customer_'.$this->customerSession->getCustomerId());
            
                    if ($braintreeCustomer && $braintreeCustomer->id) {
                        $params['options'] = [
                            "failOnDuplicatePaymentMethod" => true,
                            "verifyCard" => true
                        ];
                        $params["customerId"] = $braintreeCustomer->id;
                    }
                }
            }
            
            $this->clientToken = $this->adapter->generate($params);
        }

        return $this->clientToken;
    }
}
