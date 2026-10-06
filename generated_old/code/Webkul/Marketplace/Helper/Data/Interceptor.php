<?php
namespace Webkul\Marketplace\Helper\Data;

/**
 * Interceptor class for @see \Webkul\Marketplace\Helper\Data
 */
class Interceptor extends \Webkul\Marketplace\Helper\Data implements \Magento\Framework\Interception\InterceptorInterface
{
    use \Magento\Framework\Interception\Interceptor;

    public function __construct(\Magento\Framework\App\Helper\Context $context, \Magento\Framework\ObjectManagerInterface $objectManager, \Magento\Customer\Model\SessionFactory $customerSessionFactory, \Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\CollectionFactory $collectionFactory, \Magento\Framework\App\Http\Context $httpContext, \Magento\Catalog\Model\ResourceModel\Product $product, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Directory\Model\Currency $currency, \Magento\Framework\Locale\CurrencyInterface $localeCurrency, \Magento\Framework\App\Cache\ManagerFactory $cacheManagerFactory, \Magento\Framework\View\Element\BlockFactory $blockFactory)
    {
        $this->___init();
        parent::__construct($context, $objectManager, $customerSessionFactory, $collectionFactory, $httpContext, $product, $storeManager, $currency, $localeCurrency, $cacheManagerFactory, $blockFactory);
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomer()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getCustomer');
        if (!$pluginInfo) {
            return parent::getCustomer();
        } else {
            return $this->___callPlugins('getCustomer', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerId()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getCustomerId');
        if (!$pluginInfo) {
            return parent::getCustomerId();
        } else {
            return $this->___callPlugins('getCustomerId', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isCustomerLoggedIn()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isCustomerLoggedIn');
        if (!$pluginInfo) {
            return parent::isCustomerLoggedIn();
        } else {
            return $this->___callPlugins('isCustomerLoggedIn', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isSeller()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isSeller');
        if (!$pluginInfo) {
            return parent::isSeller();
        } else {
            return $this->___callPlugins('isSeller', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isRightSeller($productId = '')
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isRightSeller');
        if (!$pluginInfo) {
            return parent::isRightSeller($productId);
        } else {
            return $this->___callPlugins('isRightSeller', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSellerData()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSellerData');
        if (!$pluginInfo) {
            return parent::getSellerData();
        } else {
            return $this->___callPlugins('getSellerData', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSellerProductData()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSellerProductData');
        if (!$pluginInfo) {
            return parent::getSellerProductData();
        } else {
            return $this->___callPlugins('getSellerProductData', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSellerProductDataByProductId($productId = '')
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSellerProductDataByProductId');
        if (!$pluginInfo) {
            return parent::getSellerProductDataByProductId($productId);
        } else {
            return $this->___callPlugins('getSellerProductDataByProductId', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSellerDataBySellerId($sellerId = '')
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSellerDataBySellerId');
        if (!$pluginInfo) {
            return parent::getSellerDataBySellerId($sellerId);
        } else {
            return $this->___callPlugins('getSellerDataBySellerId', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSellerDataByShopUrl($shopUrl = '')
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSellerDataByShopUrl');
        if (!$pluginInfo) {
            return parent::getSellerDataByShopUrl($shopUrl);
        } else {
            return $this->___callPlugins('getSellerDataByShopUrl', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getRootCategoryIdByStoreId($storeId = '')
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getRootCategoryIdByStoreId');
        if (!$pluginInfo) {
            return parent::getRootCategoryIdByStoreId($storeId);
        } else {
            return $this->___callPlugins('getRootCategoryIdByStoreId', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAllStores()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getAllStores');
        if (!$pluginInfo) {
            return parent::getAllStores();
        } else {
            return $this->___callPlugins('getAllStores', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentStoreId()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getCurrentStoreId');
        if (!$pluginInfo) {
            return parent::getCurrentStoreId();
        } else {
            return $this->___callPlugins('getCurrentStoreId', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getWebsiteId()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getWebsiteId');
        if (!$pluginInfo) {
            return parent::getWebsiteId();
        } else {
            return $this->___callPlugins('getWebsiteId', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAllWebsites()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getAllWebsites');
        if (!$pluginInfo) {
            return parent::getAllWebsites();
        } else {
            return $this->___callPlugins('getAllWebsites', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSingleStoreStatus()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSingleStoreStatus');
        if (!$pluginInfo) {
            return parent::getSingleStoreStatus();
        } else {
            return $this->___callPlugins('getSingleStoreStatus', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSingleStoreModeStatus()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSingleStoreModeStatus');
        if (!$pluginInfo) {
            return parent::getSingleStoreModeStatus();
        } else {
            return $this->___callPlugins('getSingleStoreModeStatus', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setCurrentStore($storeId)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'setCurrentStore');
        if (!$pluginInfo) {
            return parent::setCurrentStore($storeId);
        } else {
            return $this->___callPlugins('setCurrentStore', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentCurrencyCode()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getCurrentCurrencyCode');
        if (!$pluginInfo) {
            return parent::getCurrentCurrencyCode();
        } else {
            return $this->___callPlugins('getCurrentCurrencyCode', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getBaseCurrencyCode()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getBaseCurrencyCode');
        if (!$pluginInfo) {
            return parent::getBaseCurrencyCode();
        } else {
            return $this->___callPlugins('getBaseCurrencyCode', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigAllowCurrencies()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getConfigAllowCurrencies');
        if (!$pluginInfo) {
            return parent::getConfigAllowCurrencies();
        } else {
            return $this->___callPlugins('getConfigAllowCurrencies', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrencyRates($currency, $toCurrencies = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getCurrencyRates');
        if (!$pluginInfo) {
            return parent::getCurrencyRates($currency, $toCurrencies);
        } else {
            return $this->___callPlugins('getCurrencyRates', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrencySymbol()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getCurrencySymbol');
        if (!$pluginInfo) {
            return parent::getCurrencySymbol();
        } else {
            return $this->___callPlugins('getCurrencySymbol', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getPriceFormat()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getPriceFormat');
        if (!$pluginInfo) {
            return parent::getPriceFormat();
        } else {
            return $this->___callPlugins('getPriceFormat', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAllowedSets()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getAllowedSets');
        if (!$pluginInfo) {
            return parent::getAllowedSets();
        } else {
            return $this->___callPlugins('getAllowedSets', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAllowedProductTypes()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getAllowedProductTypes');
        if (!$pluginInfo) {
            return parent::getAllowedProductTypes();
        } else {
            return $this->___callPlugins('getAllowedProductTypes', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTaxClassModel()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getTaxClassModel');
        if (!$pluginInfo) {
            return parent::getTaxClassModel();
        } else {
            return $this->___callPlugins('getTaxClassModel', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getVisibilityOptionArray()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getVisibilityOptionArray');
        if (!$pluginInfo) {
            return parent::getVisibilityOptionArray();
        } else {
            return $this->___callPlugins('getVisibilityOptionArray', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isSellerExist()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isSellerExist');
        if (!$pluginInfo) {
            return parent::isSellerExist();
        } else {
            return $this->___callPlugins('isSellerExist', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSeller()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSeller');
        if (!$pluginInfo) {
            return parent::getSeller();
        } else {
            return $this->___callPlugins('getSeller', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSellerCollectionObj($sellerId)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSellerCollectionObj');
        if (!$pluginInfo) {
            return parent::getSellerCollectionObj($sellerId);
        } else {
            return $this->___callPlugins('getSellerCollectionObj', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSellerCollectionObjByShop($shopUrl)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSellerCollectionObjByShop');
        if (!$pluginInfo) {
            return parent::getSellerCollectionObjByShop($shopUrl);
        } else {
            return $this->___callPlugins('getSellerCollectionObjByShop', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getFeedTotal($sellerId)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getFeedTotal');
        if (!$pluginInfo) {
            return parent::getFeedTotal($sellerId);
        } else {
            return $this->___callPlugins('getFeedTotal', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSelleRating($sellerId)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSelleRating');
        if (!$pluginInfo) {
            return parent::getSelleRating($sellerId);
        } else {
            return $this->___callPlugins('getSelleRating', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getCatatlogGridPerPageValues()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getCatatlogGridPerPageValues');
        if (!$pluginInfo) {
            return parent::getCatatlogGridPerPageValues();
        } else {
            return $this->___callPlugins('getCatatlogGridPerPageValues', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getCaptchaEnable()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getCaptchaEnable');
        if (!$pluginInfo) {
            return parent::getCaptchaEnable();
        } else {
            return $this->___callPlugins('getCaptchaEnable', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultTransEmailId()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getDefaultTransEmailId');
        if (!$pluginInfo) {
            return parent::getDefaultTransEmailId();
        } else {
            return $this->___callPlugins('getDefaultTransEmailId', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAdminEmailId()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getAdminEmailId');
        if (!$pluginInfo) {
            return parent::getAdminEmailId();
        } else {
            return $this->___callPlugins('getAdminEmailId', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAllowedCategoryIds()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getAllowedCategoryIds');
        if (!$pluginInfo) {
            return parent::getAllowedCategoryIds();
        } else {
            return $this->___callPlugins('getAllowedCategoryIds', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIsProductEditApproval()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getIsProductEditApproval');
        if (!$pluginInfo) {
            return parent::getIsProductEditApproval();
        } else {
            return $this->___callPlugins('getIsProductEditApproval', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIsPartnerApproval()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getIsPartnerApproval');
        if (!$pluginInfo) {
            return parent::getIsPartnerApproval();
        } else {
            return $this->___callPlugins('getIsPartnerApproval', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIsProductApproval()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getIsProductApproval');
        if (!$pluginInfo) {
            return parent::getIsProductApproval();
        } else {
            return $this->___callPlugins('getIsProductApproval', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAllowedAttributesetIds()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getAllowedAttributesetIds');
        if (!$pluginInfo) {
            return parent::getAllowedAttributesetIds();
        } else {
            return $this->___callPlugins('getAllowedAttributesetIds', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAllowedProductType()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getAllowedProductType');
        if (!$pluginInfo) {
            return parent::getAllowedProductType();
        } else {
            return $this->___callPlugins('getAllowedProductType', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getUseCommissionRule()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getUseCommissionRule');
        if (!$pluginInfo) {
            return parent::getUseCommissionRule();
        } else {
            return $this->___callPlugins('getUseCommissionRule', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getCommissionType()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getCommissionType');
        if (!$pluginInfo) {
            return parent::getCommissionType();
        } else {
            return $this->___callPlugins('getCommissionType', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIsOrderManage()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getIsOrderManage');
        if (!$pluginInfo) {
            return parent::getIsOrderManage();
        } else {
            return $this->___callPlugins('getIsOrderManage', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigCommissionRate()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getConfigCommissionRate');
        if (!$pluginInfo) {
            return parent::getConfigCommissionRate();
        } else {
            return $this->___callPlugins('getConfigCommissionRate', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigTaxManage()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getConfigTaxManage');
        if (!$pluginInfo) {
            return parent::getConfigTaxManage();
        } else {
            return $this->___callPlugins('getConfigTaxManage', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getlowStockNotification()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getlowStockNotification');
        if (!$pluginInfo) {
            return parent::getlowStockNotification();
        } else {
            return $this->___callPlugins('getlowStockNotification', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getlowStockQty()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getlowStockQty');
        if (!$pluginInfo) {
            return parent::getlowStockQty();
        } else {
            return $this->___callPlugins('getlowStockQty', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getActiveColorPicker()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getActiveColorPicker');
        if (!$pluginInfo) {
            return parent::getActiveColorPicker();
        } else {
            return $this->___callPlugins('getActiveColorPicker', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSellerPolicyApproval()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSellerPolicyApproval');
        if (!$pluginInfo) {
            return parent::getSellerPolicyApproval();
        } else {
            return $this->___callPlugins('getSellerPolicyApproval', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getUrlRewrite()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getUrlRewrite');
        if (!$pluginInfo) {
            return parent::getUrlRewrite();
        } else {
            return $this->___callPlugins('getUrlRewrite', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getReviewStatus()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getReviewStatus');
        if (!$pluginInfo) {
            return parent::getReviewStatus();
        } else {
            return $this->___callPlugins('getReviewStatus', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getMarketplaceHeadLabel()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getMarketplaceHeadLabel');
        if (!$pluginInfo) {
            return parent::getMarketplaceHeadLabel();
        } else {
            return $this->___callPlugins('getMarketplaceHeadLabel', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getMarketplacelabel1()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getMarketplacelabel1');
        if (!$pluginInfo) {
            return parent::getMarketplacelabel1();
        } else {
            return $this->___callPlugins('getMarketplacelabel1', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getMarketplacelabel2()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getMarketplacelabel2');
        if (!$pluginInfo) {
            return parent::getMarketplacelabel2();
        } else {
            return $this->___callPlugins('getMarketplacelabel2', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getMarketplacelabel3()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getMarketplacelabel3');
        if (!$pluginInfo) {
            return parent::getMarketplacelabel3();
        } else {
            return $this->___callPlugins('getMarketplacelabel3', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getMarketplacelabel4()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getMarketplacelabel4');
        if (!$pluginInfo) {
            return parent::getMarketplacelabel4();
        } else {
            return $this->___callPlugins('getMarketplacelabel4', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDisplayBanner()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getDisplayBanner');
        if (!$pluginInfo) {
            return parent::getDisplayBanner();
        } else {
            return $this->___callPlugins('getDisplayBanner', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getBannerImage()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getBannerImage');
        if (!$pluginInfo) {
            return parent::getBannerImage();
        } else {
            return $this->___callPlugins('getBannerImage', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getBannerContent()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getBannerContent');
        if (!$pluginInfo) {
            return parent::getBannerContent();
        } else {
            return $this->___callPlugins('getBannerContent', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDisplayIcon()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getDisplayIcon');
        if (!$pluginInfo) {
            return parent::getDisplayIcon();
        } else {
            return $this->___callPlugins('getDisplayIcon', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIconImage1()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getIconImage1');
        if (!$pluginInfo) {
            return parent::getIconImage1();
        } else {
            return $this->___callPlugins('getIconImage1', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIconImageLabel1()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getIconImageLabel1');
        if (!$pluginInfo) {
            return parent::getIconImageLabel1();
        } else {
            return $this->___callPlugins('getIconImageLabel1', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIconImage2()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getIconImage2');
        if (!$pluginInfo) {
            return parent::getIconImage2();
        } else {
            return $this->___callPlugins('getIconImage2', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIconImageLabel2()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getIconImageLabel2');
        if (!$pluginInfo) {
            return parent::getIconImageLabel2();
        } else {
            return $this->___callPlugins('getIconImageLabel2', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIconImage3()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getIconImage3');
        if (!$pluginInfo) {
            return parent::getIconImage3();
        } else {
            return $this->___callPlugins('getIconImage3', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIconImageLabel3()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getIconImageLabel3');
        if (!$pluginInfo) {
            return parent::getIconImageLabel3();
        } else {
            return $this->___callPlugins('getIconImageLabel3', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIconImage4()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getIconImage4');
        if (!$pluginInfo) {
            return parent::getIconImage4();
        } else {
            return $this->___callPlugins('getIconImage4', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIconImageLabel4()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getIconImageLabel4');
        if (!$pluginInfo) {
            return parent::getIconImageLabel4();
        } else {
            return $this->___callPlugins('getIconImageLabel4', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getMarketplacebutton()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getMarketplacebutton');
        if (!$pluginInfo) {
            return parent::getMarketplacebutton();
        } else {
            return $this->___callPlugins('getMarketplacebutton', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getMarketplaceprofile()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getMarketplaceprofile');
        if (!$pluginInfo) {
            return parent::getMarketplaceprofile();
        } else {
            return $this->___callPlugins('getMarketplaceprofile', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSellerlisttopLabel()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSellerlisttopLabel');
        if (!$pluginInfo) {
            return parent::getSellerlisttopLabel();
        } else {
            return $this->___callPlugins('getSellerlisttopLabel', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSellerlistbottomLabel()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSellerlistbottomLabel');
        if (!$pluginInfo) {
            return parent::getSellerlistbottomLabel();
        } else {
            return $this->___callPlugins('getSellerlistbottomLabel', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProductHintStatus()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProductHintStatus');
        if (!$pluginInfo) {
            return parent::getProductHintStatus();
        } else {
            return $this->___callPlugins('getProductHintStatus', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProductHintCategory()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProductHintCategory');
        if (!$pluginInfo) {
            return parent::getProductHintCategory();
        } else {
            return $this->___callPlugins('getProductHintCategory', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProductHintName()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProductHintName');
        if (!$pluginInfo) {
            return parent::getProductHintName();
        } else {
            return $this->___callPlugins('getProductHintName', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProductHintDesc()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProductHintDesc');
        if (!$pluginInfo) {
            return parent::getProductHintDesc();
        } else {
            return $this->___callPlugins('getProductHintDesc', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProductHintShortDesc()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProductHintShortDesc');
        if (!$pluginInfo) {
            return parent::getProductHintShortDesc();
        } else {
            return $this->___callPlugins('getProductHintShortDesc', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProductHintSku()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProductHintSku');
        if (!$pluginInfo) {
            return parent::getProductHintSku();
        } else {
            return $this->___callPlugins('getProductHintSku', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProductHintPrice()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProductHintPrice');
        if (!$pluginInfo) {
            return parent::getProductHintPrice();
        } else {
            return $this->___callPlugins('getProductHintPrice', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProductHintSpecialPrice()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProductHintSpecialPrice');
        if (!$pluginInfo) {
            return parent::getProductHintSpecialPrice();
        } else {
            return $this->___callPlugins('getProductHintSpecialPrice', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProductHintStartDate()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProductHintStartDate');
        if (!$pluginInfo) {
            return parent::getProductHintStartDate();
        } else {
            return $this->___callPlugins('getProductHintStartDate', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProductHintEndDate()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProductHintEndDate');
        if (!$pluginInfo) {
            return parent::getProductHintEndDate();
        } else {
            return $this->___callPlugins('getProductHintEndDate', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProductHintQty()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProductHintQty');
        if (!$pluginInfo) {
            return parent::getProductHintQty();
        } else {
            return $this->___callPlugins('getProductHintQty', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProductHintStock()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProductHintStock');
        if (!$pluginInfo) {
            return parent::getProductHintStock();
        } else {
            return $this->___callPlugins('getProductHintStock', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProductHintTax()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProductHintTax');
        if (!$pluginInfo) {
            return parent::getProductHintTax();
        } else {
            return $this->___callPlugins('getProductHintTax', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProductHintWeight()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProductHintWeight');
        if (!$pluginInfo) {
            return parent::getProductHintWeight();
        } else {
            return $this->___callPlugins('getProductHintWeight', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProductHintImage()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProductHintImage');
        if (!$pluginInfo) {
            return parent::getProductHintImage();
        } else {
            return $this->___callPlugins('getProductHintImage', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProductHintEnable()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProductHintEnable');
        if (!$pluginInfo) {
            return parent::getProductHintEnable();
        } else {
            return $this->___callPlugins('getProductHintEnable', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProfileHintStatus()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProfileHintStatus');
        if (!$pluginInfo) {
            return parent::getProfileHintStatus();
        } else {
            return $this->___callPlugins('getProfileHintStatus', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProfileHintBecomeSeller()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProfileHintBecomeSeller');
        if (!$pluginInfo) {
            return parent::getProfileHintBecomeSeller();
        } else {
            return $this->___callPlugins('getProfileHintBecomeSeller', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProfileHintShopurl()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProfileHintShopurl');
        if (!$pluginInfo) {
            return parent::getProfileHintShopurl();
        } else {
            return $this->___callPlugins('getProfileHintShopurl', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProfileHintTw()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProfileHintTw');
        if (!$pluginInfo) {
            return parent::getProfileHintTw();
        } else {
            return $this->___callPlugins('getProfileHintTw', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProfileHintFb()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProfileHintFb');
        if (!$pluginInfo) {
            return parent::getProfileHintFb();
        } else {
            return $this->___callPlugins('getProfileHintFb', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProfileHintCn()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProfileHintCn');
        if (!$pluginInfo) {
            return parent::getProfileHintCn();
        } else {
            return $this->___callPlugins('getProfileHintCn', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProfileHintBc()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProfileHintBc');
        if (!$pluginInfo) {
            return parent::getProfileHintBc();
        } else {
            return $this->___callPlugins('getProfileHintBc', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProfileHintShop()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProfileHintShop');
        if (!$pluginInfo) {
            return parent::getProfileHintShop();
        } else {
            return $this->___callPlugins('getProfileHintShop', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProfileHintBanner()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProfileHintBanner');
        if (!$pluginInfo) {
            return parent::getProfileHintBanner();
        } else {
            return $this->___callPlugins('getProfileHintBanner', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProfileHintLogo()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProfileHintLogo');
        if (!$pluginInfo) {
            return parent::getProfileHintLogo();
        } else {
            return $this->___callPlugins('getProfileHintLogo', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProfileHintLoc()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProfileHintLoc');
        if (!$pluginInfo) {
            return parent::getProfileHintLoc();
        } else {
            return $this->___callPlugins('getProfileHintLoc', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProfileHintDesc()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProfileHintDesc');
        if (!$pluginInfo) {
            return parent::getProfileHintDesc();
        } else {
            return $this->___callPlugins('getProfileHintDesc', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProfileHintReturnPolicy()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProfileHintReturnPolicy');
        if (!$pluginInfo) {
            return parent::getProfileHintReturnPolicy();
        } else {
            return $this->___callPlugins('getProfileHintReturnPolicy', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProfileHintShippingPolicy()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProfileHintShippingPolicy');
        if (!$pluginInfo) {
            return parent::getProfileHintShippingPolicy();
        } else {
            return $this->___callPlugins('getProfileHintShippingPolicy', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProfileHintCountry()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProfileHintCountry');
        if (!$pluginInfo) {
            return parent::getProfileHintCountry();
        } else {
            return $this->___callPlugins('getProfileHintCountry', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProfileHintMeta()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProfileHintMeta');
        if (!$pluginInfo) {
            return parent::getProfileHintMeta();
        } else {
            return $this->___callPlugins('getProfileHintMeta', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProfileHintMetaDesc()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProfileHintMetaDesc');
        if (!$pluginInfo) {
            return parent::getProfileHintMetaDesc();
        } else {
            return $this->___callPlugins('getProfileHintMetaDesc', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProfileHintBank()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProfileHintBank');
        if (!$pluginInfo) {
            return parent::getProfileHintBank();
        } else {
            return $this->___callPlugins('getProfileHintBank', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getProfileUrl()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getProfileUrl');
        if (!$pluginInfo) {
            return parent::getProfileUrl();
        } else {
            return $this->___callPlugins('getProfileUrl', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getCollectionUrl()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getCollectionUrl');
        if (!$pluginInfo) {
            return parent::getCollectionUrl();
        } else {
            return $this->___callPlugins('getCollectionUrl', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getLocationUrl()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getLocationUrl');
        if (!$pluginInfo) {
            return parent::getLocationUrl();
        } else {
            return $this->___callPlugins('getLocationUrl', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getFeedbackUrl()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getFeedbackUrl');
        if (!$pluginInfo) {
            return parent::getFeedbackUrl();
        } else {
            return $this->___callPlugins('getFeedbackUrl', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getRewriteUrl($targetUrl)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getRewriteUrl');
        if (!$pluginInfo) {
            return parent::getRewriteUrl($targetUrl);
        } else {
            return $this->___callPlugins('getRewriteUrl', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getRewriteUrlPath($targetUrl)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getRewriteUrlPath');
        if (!$pluginInfo) {
            return parent::getRewriteUrlPath($targetUrl);
        } else {
            return $this->___callPlugins('getRewriteUrlPath', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTargetUrlPath()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getTargetUrlPath');
        if (!$pluginInfo) {
            return parent::getTargetUrlPath();
        } else {
            return $this->___callPlugins('getTargetUrlPath', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getPlaceholderImage()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getPlaceholderImage');
        if (!$pluginInfo) {
            return parent::getPlaceholderImage();
        } else {
            return $this->___callPlugins('getPlaceholderImage', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSellerProCount($sellerId)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSellerProCount');
        if (!$pluginInfo) {
            return parent::getSellerProCount($sellerId);
        } else {
            return $this->___callPlugins('getSellerProCount', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getMediaUrl()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getMediaUrl');
        if (!$pluginInfo) {
            return parent::getMediaUrl();
        } else {
            return $this->___callPlugins('getMediaUrl', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getMaxDownloads()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getMaxDownloads');
        if (!$pluginInfo) {
            return parent::getMaxDownloads();
        } else {
            return $this->___callPlugins('getMaxDownloads', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getConfigPriceWebsiteScope()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getConfigPriceWebsiteScope');
        if (!$pluginInfo) {
            return parent::getConfigPriceWebsiteScope();
        } else {
            return $this->___callPlugins('getConfigPriceWebsiteScope', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSkuType()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSkuType');
        if (!$pluginInfo) {
            return parent::getSkuType();
        } else {
            return $this->___callPlugins('getSkuType', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSkuPrefix()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSkuPrefix');
        if (!$pluginInfo) {
            return parent::getSkuPrefix();
        } else {
            return $this->___callPlugins('getSkuPrefix', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSellerProfileDisplayFlag()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSellerProfileDisplayFlag');
        if (!$pluginInfo) {
            return parent::getSellerProfileDisplayFlag();
        } else {
            return $this->___callPlugins('getSellerProfileDisplayFlag', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAutomaticUrlRewrite()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getAutomaticUrlRewrite');
        if (!$pluginInfo) {
            return parent::getAutomaticUrlRewrite();
        } else {
            return $this->___callPlugins('getAutomaticUrlRewrite', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getYouTubeApiKey()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getYouTubeApiKey');
        if (!$pluginInfo) {
            return parent::getYouTubeApiKey();
        } else {
            return $this->___callPlugins('getYouTubeApiKey', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAllowedControllersBySetData($allowedModule)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getAllowedControllersBySetData');
        if (!$pluginInfo) {
            return parent::getAllowedControllersBySetData($allowedModule);
        } else {
            return $this->___callPlugins('getAllowedControllersBySetData', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isSellerGroupModuleInstalled()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isSellerGroupModuleInstalled');
        if (!$pluginInfo) {
            return parent::isSellerGroupModuleInstalled();
        } else {
            return $this->___callPlugins('isSellerGroupModuleInstalled', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isAllowedAction($actionName = '')
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isAllowedAction');
        if (!$pluginInfo) {
            return parent::isAllowedAction($actionName);
        } else {
            return $this->___callPlugins('isAllowedAction', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getPageLayout()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getPageLayout');
        if (!$pluginInfo) {
            return parent::getPageLayout();
        } else {
            return $this->___callPlugins('getPageLayout', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDisplayBannerLayout2()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getDisplayBannerLayout2');
        if (!$pluginInfo) {
            return parent::getDisplayBannerLayout2();
        } else {
            return $this->___callPlugins('getDisplayBannerLayout2', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getBannerImageLayout2()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getBannerImageLayout2');
        if (!$pluginInfo) {
            return parent::getBannerImageLayout2();
        } else {
            return $this->___callPlugins('getBannerImageLayout2', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getBannerContentLayout2()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getBannerContentLayout2');
        if (!$pluginInfo) {
            return parent::getBannerContentLayout2();
        } else {
            return $this->___callPlugins('getBannerContentLayout2', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getBannerButtonLayout2()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getBannerButtonLayout2');
        if (!$pluginInfo) {
            return parent::getBannerButtonLayout2();
        } else {
            return $this->___callPlugins('getBannerButtonLayout2', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTermsConditionUrlLayout2()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getTermsConditionUrlLayout2');
        if (!$pluginInfo) {
            return parent::getTermsConditionUrlLayout2();
        } else {
            return $this->___callPlugins('getTermsConditionUrlLayout2', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDisplayBannerLayout3()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getDisplayBannerLayout3');
        if (!$pluginInfo) {
            return parent::getDisplayBannerLayout3();
        } else {
            return $this->___callPlugins('getDisplayBannerLayout3', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getBannerImageLayout3()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getBannerImageLayout3');
        if (!$pluginInfo) {
            return parent::getBannerImageLayout3();
        } else {
            return $this->___callPlugins('getBannerImageLayout3', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getBannerContentLayout3()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getBannerContentLayout3');
        if (!$pluginInfo) {
            return parent::getBannerContentLayout3();
        } else {
            return $this->___callPlugins('getBannerContentLayout3', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getBannerButtonLayout3()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getBannerButtonLayout3');
        if (!$pluginInfo) {
            return parent::getBannerButtonLayout3();
        } else {
            return $this->___callPlugins('getBannerButtonLayout3', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTermsConditionUrlLayout3()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getTermsConditionUrlLayout3');
        if (!$pluginInfo) {
            return parent::getTermsConditionUrlLayout3();
        } else {
            return $this->___callPlugins('getTermsConditionUrlLayout3', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDisplayIconLayout3()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getDisplayIconLayout3');
        if (!$pluginInfo) {
            return parent::getDisplayIconLayout3();
        } else {
            return $this->___callPlugins('getDisplayIconLayout3', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIconImage1Layout3()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getIconImage1Layout3');
        if (!$pluginInfo) {
            return parent::getIconImage1Layout3();
        } else {
            return $this->___callPlugins('getIconImage1Layout3', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIconImageLabel1Layout3()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getIconImageLabel1Layout3');
        if (!$pluginInfo) {
            return parent::getIconImageLabel1Layout3();
        } else {
            return $this->___callPlugins('getIconImageLabel1Layout3', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIconImage2Layout3()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getIconImage2Layout3');
        if (!$pluginInfo) {
            return parent::getIconImage2Layout3();
        } else {
            return $this->___callPlugins('getIconImage2Layout3', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIconImageLabel2Layout3()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getIconImageLabel2Layout3');
        if (!$pluginInfo) {
            return parent::getIconImageLabel2Layout3();
        } else {
            return $this->___callPlugins('getIconImageLabel2Layout3', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIconImage3Layout3()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getIconImage3Layout3');
        if (!$pluginInfo) {
            return parent::getIconImage3Layout3();
        } else {
            return $this->___callPlugins('getIconImage3Layout3', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIconImageLabel3Layout3()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getIconImageLabel3Layout3');
        if (!$pluginInfo) {
            return parent::getIconImageLabel3Layout3();
        } else {
            return $this->___callPlugins('getIconImageLabel3Layout3', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIconImage4Layout3()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getIconImage4Layout3');
        if (!$pluginInfo) {
            return parent::getIconImage4Layout3();
        } else {
            return $this->___callPlugins('getIconImage4Layout3', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIconImageLabel4Layout3()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getIconImageLabel4Layout3');
        if (!$pluginInfo) {
            return parent::getIconImageLabel4Layout3();
        } else {
            return $this->___callPlugins('getIconImageLabel4Layout3', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIconImage5Layout3()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getIconImage5Layout3');
        if (!$pluginInfo) {
            return parent::getIconImage5Layout3();
        } else {
            return $this->___callPlugins('getIconImage5Layout3', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIconImageLabel5Layout3()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getIconImageLabel5Layout3');
        if (!$pluginInfo) {
            return parent::getIconImageLabel5Layout3();
        } else {
            return $this->___callPlugins('getIconImageLabel5Layout3', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getMarketplacelabel1Layout3()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getMarketplacelabel1Layout3');
        if (!$pluginInfo) {
            return parent::getMarketplacelabel1Layout3();
        } else {
            return $this->___callPlugins('getMarketplacelabel1Layout3', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getMarketplacelabel2Layout3()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getMarketplacelabel2Layout3');
        if (!$pluginInfo) {
            return parent::getMarketplacelabel2Layout3();
        } else {
            return $this->___callPlugins('getMarketplacelabel2Layout3', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getMarketplacelabel3Layout3()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getMarketplacelabel3Layout3');
        if (!$pluginInfo) {
            return parent::getMarketplacelabel3Layout3();
        } else {
            return $this->___callPlugins('getMarketplacelabel3Layout3', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getOrderApprovalRequired()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getOrderApprovalRequired');
        if (!$pluginInfo) {
            return parent::getOrderApprovalRequired();
        } else {
            return $this->___callPlugins('getOrderApprovalRequired', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAllowProductLimit()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getAllowProductLimit');
        if (!$pluginInfo) {
            return parent::getAllowProductLimit();
        } else {
            return $this->___callPlugins('getAllowProductLimit', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getGlobalProductLimitQty()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getGlobalProductLimitQty');
        if (!$pluginInfo) {
            return parent::getGlobalProductLimitQty();
        } else {
            return $this->___callPlugins('getGlobalProductLimitQty', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getOrderedPricebyorder($order, $price)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getOrderedPricebyorder');
        if (!$pluginInfo) {
            return parent::getOrderedPricebyorder($order, $price);
        } else {
            return $this->___callPlugins('getOrderedPricebyorder', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isSellerCouponModuleInstalled()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isSellerCouponModuleInstalled');
        if (!$pluginInfo) {
            return parent::isSellerCouponModuleInstalled();
        } else {
            return $this->___callPlugins('isSellerCouponModuleInstalled', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getCustomerSharePerWebsite()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getCustomerSharePerWebsite');
        if (!$pluginInfo) {
            return parent::getCustomerSharePerWebsite();
        } else {
            return $this->___callPlugins('getCustomerSharePerWebsite', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isMpcashondeliveryModuleInstalled()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isMpcashondeliveryModuleInstalled');
        if (!$pluginInfo) {
            return parent::isMpcashondeliveryModuleInstalled();
        } else {
            return $this->___callPlugins('isMpcashondeliveryModuleInstalled', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getFormatedPrice($price = 0)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getFormatedPrice');
        if (!$pluginInfo) {
            return parent::getFormatedPrice($price);
        } else {
            return $this->___callPlugins('getFormatedPrice', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIsSeparatePanel()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getIsSeparatePanel');
        if (!$pluginInfo) {
            return parent::getIsSeparatePanel();
        } else {
            return $this->___callPlugins('getIsSeparatePanel', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIsAdminViewCategoryTree()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getIsAdminViewCategoryTree');
        if (!$pluginInfo) {
            return parent::getIsAdminViewCategoryTree();
        } else {
            return $this->___callPlugins('getIsAdminViewCategoryTree', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getControllerMappedPermissions()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getControllerMappedPermissions');
        if (!$pluginInfo) {
            return parent::getControllerMappedPermissions();
        } else {
            return $this->___callPlugins('getControllerMappedPermissions', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isMpSellerProductSearchModuleInstalled()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isMpSellerProductSearchModuleInstalled');
        if (!$pluginInfo) {
            return parent::isMpSellerProductSearchModuleInstalled();
        } else {
            return $this->___callPlugins('isMpSellerProductSearchModuleInstalled', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getImageSize($image)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getImageSize');
        if (!$pluginInfo) {
            return parent::getImageSize($image);
        } else {
            return $this->___callPlugins('getImageSize', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isSellerSliderModuleInstalled()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isSellerSliderModuleInstalled');
        if (!$pluginInfo) {
            return parent::isSellerSliderModuleInstalled();
        } else {
            return $this->___callPlugins('isSellerSliderModuleInstalled', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function validateXssString($value = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'validateXssString');
        if (!$pluginInfo) {
            return parent::validateXssString($value);
        } else {
            return $this->___callPlugins('validateXssString', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSellerDashboardLogoUrl()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSellerDashboardLogoUrl');
        if (!$pluginInfo) {
            return parent::getSellerDashboardLogoUrl();
        } else {
            return $this->___callPlugins('getSellerDashboardLogoUrl', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function clearCache()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'clearCache');
        if (!$pluginInfo) {
            return parent::clearCache();
        } else {
            return $this->___callPlugins('clearCache', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getWeightUnit()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getWeightUnit');
        if (!$pluginInfo) {
            return parent::getWeightUnit();
        } else {
            return $this->___callPlugins('getWeightUnit', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentCurrencyPrice($currencyRate, $basePrice)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getCurrentCurrencyPrice');
        if (!$pluginInfo) {
            return parent::getCurrentCurrencyPrice($currencyRate, $basePrice);
        } else {
            return $this->___callPlugins('getCurrentCurrencyPrice', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSellerRegistrationUrl()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSellerRegistrationUrl');
        if (!$pluginInfo) {
            return parent::getSellerRegistrationUrl();
        } else {
            return $this->___callPlugins('getSellerRegistrationUrl', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isProfileCompleted()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isProfileCompleted');
        if (!$pluginInfo) {
            return parent::isProfileCompleted();
        } else {
            return $this->___callPlugins('isProfileCompleted', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestVar()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getRequestVar');
        if (!$pluginInfo) {
            return parent::getRequestVar();
        } else {
            return $this->___callPlugins('getRequestVar', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isSellerFilterActive()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isSellerFilterActive');
        if (!$pluginInfo) {
            return parent::isSellerFilterActive();
        } else {
            return $this->___callPlugins('isSellerFilterActive', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSellerInfo($sellerId)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSellerInfo');
        if (!$pluginInfo) {
            return parent::getSellerInfo($sellerId);
        } else {
            return $this->___callPlugins('getSellerInfo', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSellerProductCollection($sellerId, $productId = 0, $productCount = 0)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getSellerProductCollection');
        if (!$pluginInfo) {
            return parent::getSellerProductCollection($sellerId, $productId, $productCount);
        } else {
            return $this->___callPlugins('getSellerProductCollection', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDisplayCardType()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getDisplayCardType');
        if (!$pluginInfo) {
            return parent::getDisplayCardType();
        } else {
            return $this->___callPlugins('getDisplayCardType', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getImageUrl($product, $imageType = 'product_page_image_small')
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getImageUrl');
        if (!$pluginInfo) {
            return parent::getImageUrl($product, $imageType);
        } else {
            return $this->___callPlugins('getImageUrl', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function allowSellerFilter()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'allowSellerFilter');
        if (!$pluginInfo) {
            return parent::allowSellerFilter();
        } else {
            return $this->___callPlugins('allowSellerFilter', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getAdminFilterDisplayName()
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'getAdminFilterDisplayName');
        if (!$pluginInfo) {
            return parent::getAdminFilterDisplayName();
        } else {
            return $this->___callPlugins('getAdminFilterDisplayName', func_get_args(), $pluginInfo);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isModuleOutputEnabled($moduleName = null)
    {
        $pluginInfo = $this->pluginList->getNext($this->subjectType, 'isModuleOutputEnabled');
        if (!$pluginInfo) {
            return parent::isModuleOutputEnabled($moduleName);
        } else {
            return $this->___callPlugins('isModuleOutputEnabled', func_get_args(), $pluginInfo);
        }
    }
}
