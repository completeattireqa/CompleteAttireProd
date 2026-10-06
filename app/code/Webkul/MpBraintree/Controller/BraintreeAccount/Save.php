<?php
/**
 * Webkul Software.
 *
 * @category Webkul
 * @package Webkul_MpBraintree
 * @author Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license https://store.webkul.com/license.html
 */
namespace Webkul\MpBraintree\Controller\BraintreeAccount;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Quote\Api\Data\PaymentInterface;
use Braintree\Configuration;
use Webkul\MpBraintree\Gateway\Config\Config as BraintreeConfig;
use Magento\Framework\Data\Form\FormKey\Validator as FormKeyValidator;
use Webkul\MpBraintree\Model\Source\Environment;

class Save extends Action
{

   /**
    * braintree cofig
    */
    protected $config;

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
     * @var Magento\Customer\Model\Customer
     */
    protected $customer;

    /**
     * @var Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * @var Webkul\Marketplace\Helper\Data
     */
    protected $_marketplaceHelper;

    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    protected $_formKeyValidator;

    /**
     * @param Context                         $context
     * @param PageFactory                     $resultPageFactory
     * @param \Magento\Customer\Model\Session $customerSession   customer session
     */
    public function __construct(
        Context $context,
        BraintreeConfig $config,
        \Webkul\MpBraintree\Model\Adapter\MpBraintreeAdapter $adapter,
        \Magento\Directory\Model\RegionFactory $region,
        \Magento\Directory\Model\CountryFactory $country,
        \Webkul\MpBraintree\Helper\Data $braintreeHelper,
        \Magento\Customer\Model\CustomerFactory $customer,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Webkul\Marketplace\Helper\Data $marketplaceHelper,
        FormKeyValidator $formKeyValidator,
        \Magento\Customer\Model\Session $customerSession
    ) {

        $this->config = $config;
        $this->_adapter = $adapter;
        $this->_region = $region->create();
        $this->_country = $country->create();
        $this->_braintreeHelper = $braintreeHelper;
        $this->_storeManager = $storeManager;
        $this->customer = $customer->create();
        $this->_marketplaceHelper = $marketplaceHelper;
        $this->_formKeyValidator = $formKeyValidator;
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    /**
     * save braintree details
     *
     * @return void
     */
    public function execute()
    {
        if ($this->getRequest()->isPost()) {
            try {
                $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
                if (!$this->_formKeyValidator->validate($this->getRequest())) {
                    return $resultRedirect->setPath('*/*/index', ['_secure' => $this->getRequest()->isSecure()]);
                }
                $data = $this->getRequest()->getParams();
                if (isset($data['mpbraintree'])) {
                    $this->customer->load($this->_marketplaceHelper->getCustomerId());
                    $customerData = $this->customer->getDataModel();
                    $brainTreeData = $data['mpbraintree'];
                    $isBusinessAccount = isset($data["isBusinessAccount"])?$data["isBusinessAccount"]:false;
                    $address = $this->addressFilter($brainTreeData['address']);

                    unset($brainTreeData['address']);
                    $brainTreeData['individual'] = array_merge($brainTreeData['individual'], ['address' => $address]);
                    if ($isBusinessAccount) {
                        $brainTreeData['business'] = array_merge($brainTreeData['business'], ['address' => $address]);
                    }

                    $this->validate($brainTreeData);
                    if (!$isBusinessAccount && isset($brainTreeData['business'])) {
                        unset($brainTreeData['business']);
                    }
                    $submerchantId = '';
                    if (isset($brainTreeData['id']) && $brainTreeData['id']) {
                        $submerchantId = $brainTreeData['id'];
                        $result = $this->_adapter->updateSubMerchant($submerchantId, $brainTreeData);
                        if ($result->success && $result->merchantAccount->status == "active") {
                            $customerData->setCustomAttribute('sub_merchant_status', 1);
                            $this->customer->updateData($customerData);
                            $this->customer->save();
                        }
                        $this->messageManager->addSuccess(__("braintree details successfully updated"));
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
                                $this->messageManager->addSuccess(__("braintree details successfully saved"));
                            } catch (\Exception $e) {
                                $this->messageManager->addSuccess(__($e->getMessage()));
                                $this->_braintreeHelper->createLog("Exception while updating submerchant", $e->getTrace());
                            }
                            $customerData->setCustomAttribute('sub_merchant_status', $submerchantStatus);
                            $customerData->setCustomAttribute('braintree_submerchant_id', $result->merchantAccount->id);
                            $this->customer->updateData($customerData);
                            $this->customer->save();
                        } else {
                            $this->messageManager->addError(__("not able to update braintree account details"));
                        }
                    }
                }
            } catch (\Exception $e) {
                $this->messageManager->addError(__("not able to update braintree submerchant account details %1", $e->getMessage()));
                $this->_braintreeHelper->createLog("Exception while updating submerchant", $e->getTrace());
            }
              return $resultRedirect->setPath('mpbraintree/braintreeaccount/index');
        }
        return $resultRedirect->setPath('*/*/index', ['_secure' => $this->getRequest()->isSecure()]);
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
            return $this->_region->load($region)->getName();
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
            // return $this->_country->loadByCode($id)->getName();
            return $id;
        }
    }
}
