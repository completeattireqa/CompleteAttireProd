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
namespace Webkul\MpBraintree\Gateway\Config;

/**
 * Class Config
 */
class Config extends \Magento\Payment\Gateway\Config\Config
{
    const KEY_ENVIRONMENT = 'environment';
    const KEY_ACTIVE = 'active';
    const TITLE = 'title';
    const KEY_MERCHANT_ID = 'merchant_id';
    const KEY_MERCHANT_ACCOUNT_ID = 'account_id';
    const KEY_TOKENIZATION_KEY = 'tokenization_key';
    const KEY_PUBLIC_KEY = 'public_key';
    const KEY_PRIVATE_KEY = 'private_key';
    const KEY_THRESHOLD_AMOUNT = 'min_order_total';
    const KEY_MAX_ORDER_TOTAL = 'max_order_total';
    const KEY_VERIFY_ALLOW_SPECIFIC = 'allowspecific';
    const KEY_VERIFY_SPECIFIC = 'specificcountry';
    const KEY_TNC = 'tnc';
    const CODE_3DSECURE = 'three_d_secure';
    const CC_VAULT_ACTIVE = 'cc_vault_active';
    const HOLD_IN_ESCROW = 'hold';
    const KEY_AUTO_RELEASE = 'auto_release';
    const KEY_ESCROW_HOLD_DAYS = 'escrow_hold_days';
    const KEY_USE_CVV = 'use_cvv';
    const KEY_SPECIFIC_COUNTRIES = 'specificcountry';

    /**
     * get public key
     *
     * @return string
     */
    public function getPublicKey($storeId = null)
    {
        return $this->getValue(self::KEY_PUBLIC_KEY, $storeId);
    }

    /**
     * get private key
     *
     * @return string
     */
    public function getPrivateKey($storeId = null)
    {
        return $this->getValue(self::KEY_PRIVATE_KEY, $storeId);
    }

    /**
     * get tokenization key
     *
     * @return string
     */
    public function getTokenizationKey($storeId = null)
    {
        return $this->getValue(self::KEY_TOKENIZATION_KEY, $storeId);
    }

    /**
     * get terms and conditions
     *
     * @return string
     */
    public function getTnC()
    {
        return $this->getValue(self::KEY_TNC);
    }

    /**
     * get if 3d secure enabled
     *
     * @return boolean
     */
    public function getCode3DSecure()
    {
        return (bool) $this->getValue(self::CODE_3DSECURE);
    }

    /**
     * if vault enabled
     *
     * @return boolean
     */
    public function getCcVaultActive()
    {
        return (bool) $this->getValue(self::CC_VAULT_ACTIVE);
    }

    /**
     * if hold in escrow enabled
     *
     * @return boolean
     */
    public function getHoldInEscrow()
    {
        return (bool) $this->getValue(self::HOLD_IN_ESCROW);
    }

    /**
     * get if escrow auto release
     *
     * @return boolean
     */
    public function getEscrowAutoRelease()
    {
        return (bool) $this->getValue(self::KEY_AUTO_RELEASE);
    }

    /**
     * get escrow days
     *
     * @return int
     */
    public function getEscrowDays()
    {
        return $this->getValue(self::KEY_ESCROW_HOLD_DAYS);
    }

    /**
     * Check if cvv field is enabled
     * @return boolean
     */
    public function isCvvEnabled()
    {
        return (bool) $this->getValue(self::KEY_USE_CVV);
    }

    /**
     * Get threshold amount for 3d secure
     * @return float
     */
    public function getThresholdAmount()
    {
        return (double) $this->getValue(self::KEY_THRESHOLD_AMOUNT);
    }

    /**
     * get maximum order total to allow payment method
     *
     * @return void
     */
    public function getMaxOrderTotalAmount()
    {
        return (double) $this->getValue(self::KEY_MAX_ORDER_TOTAL);
    }

    /**
     * Get list of specific countries for 3d secure
     * @return array
     */
    public function getSpecificCountries()
    {
        return explode(',', $this->getValue(self::KEY_SPECIFIC_COUNTRIES));
    }

    /**
     * @return string
     */
    public function getEnvironment()
    {
        return $this->getValue(Config::KEY_ENVIRONMENT);
    }

    /**
     * @return string
     */
    public function getMerchantId($storeId = null)
    {
        return $this->getValue(Config::KEY_MERCHANT_ID, $storeId);
    }

    /**
     * Get Payment configuration status
     * @return bool
     */
    public function isActive($storeId = null)
    {
        return (bool) $this->getValue(self::KEY_ACTIVE, $storeId) && $this->ifBraintreeDetailsFilled();
    }

    /**
     * Get Merchant account ID
     *
     * @return string
     */
    public function getMerchantAccountId($storeId = null)
    {
        return $this->getValue(self::KEY_MERCHANT_ACCOUNT_ID, $storeId);
    }

    /**
     * check if braintree payment method can be used at checkout
     *
     * @return bool
     */
    protected function ifBraintreeDetailsFilled()
    {
        if ($this->getMerchantAccountId() && $this->getMerchantId() && $this->getPublicKey() && $this->getPrivateKey()) {
            return true;
        } else {
            return false;
        }
    }
}
