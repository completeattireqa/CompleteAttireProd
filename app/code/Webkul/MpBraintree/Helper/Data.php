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
namespace Webkul\MpBraintree\Helper;

use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Customer\Model\Session;
use Magento\Framework\Data\Form\FormKey\Validator as FormKeyValidator;

/**
 * Stripe data helper.
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const METHOD_CODE = \Webkul\MpBraintree\Model\Ui\ConfigProvider::CODE;

    /**
     * @var Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $_date;

    /**
     * Customer session.
     *
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * @var ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    protected $_formKeyValidator;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $_productRepository;

    /**
     * @var \Webkul\MpBraintree\Logger\BraintreeLogger
     */
    protected $_braintreeLogger;

    /**
     * @var \Magento\Directory\Model\Config\Source\Country
     */
    protected $_country;

    /**
     * @var \Magento\Directory\Model\RegionFactory
     */
    protected $_regionFactory;

    /**
     * @param Magento\Framework\App\Helper\Context        $context
     * @param Magento\Directory\Model\Currency            $currency
     * @param Magento\Customer\Model\Session              $customerSession
     * @param Magento\Framework\UrlInterface              $url
     * @param Magento\Catalog\Model\ResourceModel\Product $product
     * @param Magento\Store\Model\StoreManagerInterface   $_storeManager
     */
    public function __construct(
        Session $customerSession,
        \Magento\Framework\App\Helper\Context $context,
        FormKeyValidator $formKeyValidator,
        DateTime $date,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Webkul\MpBraintree\Logger\BraintreeLogger $braintreeLogger,
        \Webkul\Marketplace\Model\ResourceModel\Product\CollectionFactory $sellerProductCollectionFactory,
        \Webkul\Marketplace\Model\ResourceModel\Saleperpartner\CollectionFactory $saleperpartnerCollectionFactory,
        \Webkul\Marketplace\Helper\Data $marketplaceHelperData,
        \Magento\Directory\Model\Config\Source\Country $country,
        \Magento\Framework\App\ProductMetadataInterface $productMetadata,
        \Magento\Directory\Model\RegionFactory $regionFactory
    ) {

        $this->_date = $date;
        $this->_customerSession = $customerSession;
        $this->_objectManager = $objectManager;
        $this->_formKeyValidator = $formKeyValidator;
        $this->_storeManager = $storeManager;
        $this->_productRepository = $productRepository;
        $this->_braintreeLogger = $braintreeLogger;
        $this->_sellerProductCollectionFactory = $sellerProductCollectionFactory;
        $this->_saleperpartnerCollectionFactory = $saleperpartnerCollectionFactory;
        $this->_marketplaceHelperData = $marketplaceHelperData;
        $this->_country  = $country;
        $this->_productMetadata = $productMetadata;
        $this->_regionFactory = $regionFactory;
        parent::__construct($context);
    }

    /**
     * function to get Config Data.
     *
     * @return string
     */
    public function getConfigValue($field = false)
    {
        if ($field) {
            return $this->scopeConfig
                ->getValue(
                    'payment/'.self::METHOD_CODE.'/'.$field,
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORE
                );
        } else {
            return;
        }
    }

    /**
     * getCanDebug can create log.
     *
     * @return int
     */
    public function getCanDebug()
    {
        return 1;
    }

    /**
     * create braintree payment logs
     *
     * @return void
     */
    public function createLog($msg, $context)
    {
        if ($this->getCanDebug()) {
            $this->_braintreeLogger->debug($msg, $context);
        }
    }

    /**
     * getMediaUrl get media url
     *
     * @return string
     */
    public function getMediaUrl()
    {
        return $this->_storeManager->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }

    /**
     * getSellerDetail get seller commission details
     *
     * @param  string $sellerId
     * @return array
     */
    public function getSellerDetail($sellerId = '')
    {
        if ($sellerId) {
            $sellerdetails = $this->_saleperpartnerCollectionFactory
                ->create()
                ->addFieldToFilter('seller_id', $sellerId);
            if (count($sellerdetails)) {
                foreach ($sellerdetails as $temp) {
                    if ($temp->getCommissionRate() > 0) {
                        return [
                            'id' => $temp->getSellerId(),
                            'commission' => $temp->getCommissionRate(),
                        ];
                    } else {
                        return [
                            'id' => $temp->getSellerId(),
                            'commission' => $this->_marketplaceHelperData->getConfigCommissionRate(),
                        ];
                    }
                }
            } else {
                return [
                    'id' => $sellerId,
                    'commission' => $this->_marketplaceHelperData->getConfigCommissionRate(),
                ];
            }
        } else {
            return ['id' => 0,'commission' => 0];
        }
    }

    /**
     * [getAssignSellerId function to get assign seller id from order item.
     *
     * @param object $item
     *
     * @return int
     */
    public function getAssignSellerId($item)
    {
        // Get Info Buy Request from quote item,
        $itemOption = $this->_objectManager
            ->create('Magento\Quote\Model\Quote\Item\Option')
            ->getCollection()
            ->addFieldToFilter('item_id', $item->getId())
            ->addFieldToFilter('code', 'info_buyRequest');


        foreach ($itemOption as $option) {
            $info = $option->getValue();
        }
        //Magento version check
        if (preg_match("/^2\.[0-1]\.\d/", $this->_productMetadata->getVersion())) {
            $info = unserialize($info);
        }
        if (preg_match("/^2\.2\.\d/", $this->_productMetadata->getVersion())) {
            $info = json_decode($info, true);
        }

        //Get mpassignproduct_id from $info
        $assignId = 0;
        $sellerId = 0;
        if (array_key_exists('mpassignproduct_id', $info)) {
            $assignId = $info['mpassignproduct_id'];
            $mpassignModel = $this->_objectManager
                ->create('Webkul\MpAssignProduct\Model\Items')
                ->load($assignId);
            $sellerId = $mpassignModel->getSellerId();
        }

        return $sellerId;
    }

    /**
     * get country list
     *
     * @return array
     */
    public function getCountryList()
    {
        $countries = $this->_country->toOptionArray(false, 'US');
        unset($countries[0]);
        return $countries;
    }

    /**
     * get country wise regions
     *
     * @param int $countryId
     * @return array
     */
    public function getRegionList($countryId)
    {
        $regionCollection = $this->_regionFactory->create()->getCollection()->addCountryFilter(
            $countryId
        );

        $regions = $regionCollection->toOptionArray();
        if (!$regions) {
            $regions = [['value' => '', 'label' => '*']];
        }

        return $regions;
    }
}
