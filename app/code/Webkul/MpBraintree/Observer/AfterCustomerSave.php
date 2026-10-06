<?php
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_MpBraintree
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
namespace Webkul\MpBraintree\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Api\Data\PaymentInterface;
use Braintree\Configuration;
use Webkul\MpBraintree\Gateway\Config\Config as BraintreeConfig;
use Webkul\MpBraintree\Model\Source\Environment;

/**
 * Class AfterCustomerSave
 */
class AfterCustomerSave implements ObserverInterface
{

    /**
     * braintree cofig
     */
    protected $config;

    /**
     * RequestInterface
     */
    protected $_request;

    /**
     * @var \Webkul\MpBraintree\Model\Adapter\MpBraintreeAdapter
     */
    protected $_adapter;

    /**
     * @var Magento\Directory\Model\RegionFactory
     */
    protected $_region;

    /**
     * @var Magento\Directory\Model\CountryFactory
     */
    protected $_country;

    /**
     * @var Webkul\MpBraintree\Helper\Data
     */
    protected $_braintreeHelper;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;


    /**
     * @var Magento\Customer\Model\Customer
     */
    protected $customer;

    public function __construct(
        BraintreeConfig $config,
        \Magento\Framework\App\RequestInterface $request,
        \Webkul\MpBraintree\Model\Adapter\MpBraintreeAdapter $adapter,
        \Magento\Directory\Model\RegionFactory $region,
        \Magento\Directory\Model\CountryFactory $country,
        \Webkul\MpBraintree\Helper\Data $braintreeHelper,
        \Magento\Customer\Model\CustomerFactory $customer,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Message\ManagerInterface $messageManager
    ) {
        $this->config = $config;
        $this->_request = $request;
        $this->_adapter = $adapter;
        $this->_region = $region->create();
        $this->_country = $country->create();
        $this->_braintreeHelper = $braintreeHelper;
        $this->_storeManager = $storeManager;
        $this->customer = $customer->create();
        $this->messageManager = $messageManager;
    }
    
    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            $data = $this->_request->getParams();
            if (isset($data['mpbraintree'])) {
                $customerEmail = $observer->getEmail();
                $this->customer->setWebsiteId($this->_storeManager->getStore()->getWebsiteId())->loadByEmail($customerEmail);
                $customerData = $this->customer->getDataModel();
                $brainTreeData = $data['mpbraintree'];
                $address = $this->addressFilter($brainTreeData['address']);

                unset($brainTreeData['address']);
                $brainTreeData['individual'] = array_merge($brainTreeData['individual'], ['address' => $address]);
                $brainTreeData['business'] = array_merge($brainTreeData['business'], ['address' => $address]);

                $this->validate($brainTreeData);

                $submerchantId = '';
                if (isset($brainTreeData['id']) && $brainTreeData['id']) {
                    $submerchantId = $brainTreeData['id'];
                    $result = $this->_adapter->updateSubMerchant($submerchantId, $brainTreeData);
                    if ($result->success && $result->merchantAccount->status == "active") {
                        $customerData->setCustomAttribute('sub_merchant_status', 1);
                        $this->customer->updateData($customerData);
                        $this->customer->save();
                    }
                } else {
                    if (isset($brainTreeData['id'])) {
                        unset($brainTreeData['id']);
                    }
                    $result = $this->_adapter->addSubMerchant($brainTreeData);
                    if ($result->success) {
                        $submerchantStatus = 0;
                        try {
                            $subMerchantAccount = $this->_adapter->findSubMerchant($result->merchantAccount->id);
                            if ($subMerchantAccount->status == 'active') {
                                $submerchantStatus = 1;
                            }
                        } catch (\Exception $e) {
                            $this->_braintreeHelper->createLog("Exception while updating submerchant", $e->getTrace());
                        }
                        $customerData->setCustomAttribute('sub_merchant_status', $submerchantStatus);
                        $customerData->setCustomAttribute('braintree_submerchant_id', $result->merchantAccount->id);
                        $this->customer->updateData($customerData);
                        $this->customer->save();
                    } else {
                        $this->_braintreeHelper->createLog("Exception while updating submerchant", $e->getTrace());
                    }
                }
            }
        } catch (\Exception $e) {
            $this->messageManager->addError(__("not able to update braintree submerchant account details %1", $e->getMessage()));
            $this->_braintreeHelper->createLog("Exception while updating submerchant", $e->getTrace());
        }
    }

    /**
     * filter the address data
     *
     * @return array
     */
    public function addressFilter($address)
    {
        $address['region'] = $this->getRegionName($address['region']);
        $address['locality'] = $this->getCountryName($address['locality']);
        $address['streetAddress'] = $this->getStreetAddress($address['streetAddress']);
        return $address;
    }

    /**
     * validate data if required
     *
     * @param array $data
     * @return bool
     */
    private function validate($data = [])
    {
        if (count($data)  > 0) {
            return true;
        }
    }

    /**
     * get street address
     *
     * @param stringh $streetAddress
     * @return string
     */
    public function getStreetAddress($streetAddress)
    {
        if ($this->config->getEnvironment() == 'sandbox') {
            return '111 Main St';
        }
        return $streetAddress;
    }

    /**
     * get region name
     *
     * @return string
     */
    private function getRegionName($region)
    {
        if ($this->config->getEnvironment() == 'sandbox') {
            return 'IL';
        }

        if (!is_numeric($region)) {
            return $region;
        } else {
            $id = $this->_request->getParam('region_id');
            return $this->_region->load($id)->getName();
        }
    }

    /**
     * get country name
     *
     * @param int $id
     * @return string
     */
    private function getCountryName($id)
    {
        if ($this->config->getEnvironment() == 'sandbox') {
            return 'Chicago';
        }
        
        if (is_numeric($id)) {
            return $this->_country->load($id)->getName();
        } else {
            return $this->_country->loadByCode($id)->getName();
        }
    }
}
