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
 * Class CustomerRegister
 */
class CustomerRegister implements ObserverInterface
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
        \Magento\Customer\Model\CustomerFactory $customer
    ) {
        $this->config = $config;
        $this->_request = $request;
        $this->_adapter = $adapter;
        $this->_region = $region->create();
        $this->_country = $country->create();
        $this->_braintreeHelper = $braintreeHelper;
        $this->customer = $customer->create();
    }
    
    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            $data = $this->_request->getParams();
            if (!empty($data['is_seller']) && !empty($data['profileurl']) && $data['is_seller'] == 1 && isset($data['mpbraintree'])) {
                $customerData = $observer->getCustomer();
                $brainTreeData = $data['mpbraintree'];
                $this->validate($brainTreeData);
                $brainTreeData = $this->createIndividualData($brainTreeData);
                $brainTreeData = $this->createBusinessData($brainTreeData);
                $brainTreeData = $this->createFundingData($brainTreeData);
                if (isset($brainTreeData['address'])) {
                    unset($brainTreeData['address']);
                }
                $result = $this->_adapter->addSubMerchant($brainTreeData);
           
                $this->_braintreeHelper->createLog('braintree create submerchant log: ', (array)$result);
                if ($result->success) {
                    $submerchantStatus = 0;
                    try {
                        $subMerchantAccount = $this->_adapter->findSubMerchant($result->merchantAccount->id);
                        if ($subMerchantAccount->status == 'active') {
                            $submerchantStatus = 1;
                        }
                    } catch (\Exception $e) {
                        //todo log data
                        $this->_braintreeHelper->createLog("Exception while creating submerchant", $e->getTrace());
                    }
                    $customerData->setCustomAttribute('sub_merchant_status', $submerchantStatus);
                    $customerData->setCustomAttribute('braintree_submerchant_id', $result->merchantAccount->id);
                    $this->customer->updateData($customerData);
                    $this->customer->save();
                }
            }
        } catch (\Exception $e) {
            // echo $e->getMessage();die;
            $this->_braintreeHelper->createLog("Exception while creating submerchant", $e->getTrace());
        }
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
     * create individual customer data
     *
     * @param array $braintreeData
     * @return array
     */
    private function createIndividualData($braintreeData = [])
    {
        $data = $this->_request->getParams();
        $braintreeData['individual']['firstName'] = $data['firstname'];
        $braintreeData['individual']['lastName'] = $data['lastname'];
        $braintreeData['individual']['email'] = $data['email'];
        $braintreeData['individual']['address'] = [
            'streetAddress' => $this->getStreet(),
            'locality' => $this->getCountryName($data['mpbraintree']['address']['locality']),
            'region' => $this->getRegionName(),
            'postalCode' => $data['mpbraintree']['address']['postalCode'],
        ];
        return $braintreeData;
    }

    /**
     * create business data
     *
     * @param array $braintreeData
     * @return array
     */
    private function createBusinessData($braintreeData = [])
    {
        $data = $this->_request->getParams();
        $braintreeData['business']['address'] = [
            'streetAddress' => $this->getStreet(),
            'locality' => $this->getCountryName($data['mpbraintree']['address']['locality']),
            'region' => $this->getRegionName(),
            'postalCode' => $data['mpbraintree']['address']['postalCode'],
        ];
        return $braintreeData;
    }

    /**
     * create funding data
     *
     * @param array $braintreeData
     * @return array
     */
    private function createFundingData($braintreeData = [])
    {
        return $braintreeData;
    }

    /**
     * create street data
     *
     * @return array
     */
    private function getStreet()
    {
        if ($this->config->getEnvironment() == 'sandbox') {
            return '111 Main St';
        }
        $street = $this->_request->getParam('mpbraintree');
        return $street['address']['streetAddress'];
    }

    /**
     * get region name
     *
     * @return string
     */
    private function getRegionName()
    {
        if ($this->config->getEnvironment() == 'sandbox') {
            return 'IL';
        }
        $region = $this->_request->getParam('mpbraintree');
        if (isset($region['address']['region']) && !is_string($region['address']['region'])) {
            return $region['address']['region'];
        } else {
            $id = $region['address']['region'];
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
