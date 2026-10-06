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
namespace Webkul\MpBraintree\Gateway\Request;

use Magento\Payment\Gateway\Request\BuilderInterface;
use Webkul\MpBraintree\Gateway\Helper\SubjectReader;
use Magento\Framework\ObjectManager\TMap;
use Magento\Framework\ObjectManager\TMapFactory;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Webkul\MpBraintree\Observer\DataAssignObserver;
use Webkul\MpBraintree\Gateway\Config\Config;
use Webkul\MpBraintree\Model\Adapter\MpBraintreeAdapter;

/**
 * Class CustomerDataBuilder
 */
class SellerDataBuilder implements BuilderInterface
{

    /**
     * One-time-use token that references a payment method provided by your customer,
     * such as a credit card or PayPal account.
     *
     * The nonce serves as proof that the user has authorized payment (e.g. credit card number or PayPal details).
     * This should be sent to your server and used with any of Braintree's server-side client libraries
     * that accept new or saved payment details.
     * This can be passed instead of a payment_method_token parameter.
     */
    const PAYMENT_METHOD_NONCE = 'paymentMethodNonce';

    /**
     * The merchant account ID used to create a transaction.
     * Currency is also determined by merchant account ID.
     * If no merchant account ID is specified, Braintree will use your default merchant account.
     */
    const MERCHANT_ACCOUNT_ID = 'merchantAccountId';

    /**
     * commission as application service fee for admin
     */
    const SERVICE_FEE = 'serviceFeeAmount';

    /**
     * Order ID
     */
    const ORDER_ID = 'orderId';

    /**
     * seller id
     */
    const SELLER = 'seller';

    /**
     * amount to pay seller
     */
    const AMOUNT = 'amount';

    /**
     * payment method token
     */
    const PAYMENT_METHOD_TOKEN = 'paymentMethodToken';

    /**
     * @var array
     */
    protected $_finalCart = [];

    /**
     * $_newvar variable to check if seller shipping used.
     *
     * @var string
     */
    protected $_newvar;

    /**
     * @var ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * @var SubjectReader
     */
    private $subjectReader;

    /**
     * @var array
     */
    private $builders;

    /**
     * @var Webkul\MpBraintree\Helper\Data
     */
    private $_helper;
    /**
     * @var PriceCurrencyInterface
     */
    protected $_priceCurrency;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var MpBraintreeAdapter
     */
    protected $adapter;

    /**
     * @var string
     */
    protected $_paymentMethodToken;

    /**
     * @var \Magento\Customer\Model\CustomerFactory
     */
    protected $customerFactory;

    /**
     * Constructor
     *
     * @param SubjectReader $subjectReader
     */
    public function __construct(
        SubjectReader $subjectReader,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Webkul\MpBraintree\Helper\Data $helper,
        array $builders = [],
        TMapFactory $tmapFactory,
        PriceCurrencyInterface $priceCurrency,
        Config $config,
        MpBraintreeAdapter $adapter,
        \Magento\Customer\Model\CustomerFactory $customerFactory
    ) {
    
        $this->subjectReader = $subjectReader;
        $this->_objectManager = $objectManager;
        $this->_checkoutSession = $checkoutSession;
        $this->_helper = $helper;
        $this->builders = $tmapFactory->create(
            [
                'array' => $builders,
                'type' => BuilderInterface::class
            ]
        );
        $this->_priceCurrency = $priceCurrency;
        $this->config = $config;
        $this->adapter = $adapter;
        $this->customerFactory = $customerFactory;
    }

    /**
     * @inheritdoc
     */
    public function build(array $buildSubject)
    {
        $paymentDO = $this->subjectReader->readPayment($buildSubject);
        $this->getPaymentMethodToken($paymentDO);
        $request = $this->buildRequestData($buildSubject);
        $order = $paymentDO->getOrder();
        $finalCart = $this->createFinalCart($order);
        $this->saveSellerData($paymentDO, $finalCart);
      
        $cartData = [];
        foreach ($finalCart as $fc) {
            $paymentData = $this->createPaymentData($fc, $paymentDO);
            $cartData[] = array_merge($paymentData, $request);
        }
        
        return [
            self::SELLER => $cartData
        ];
    }

    /**
     * save seller data for future transactions
     *
     * @param object $paymentDO
     * @param array $finalCart
     * @return void
     */
    public function saveSellerData($paymentDO, $finalCart)
    {
        foreach ($finalCart as $key => $cart) {
            foreach ($cart as $k => $c) {
                $paymentDO->getPayment()->setAdditionalInformation($k.'_cart_'.$key, $c);
            }
        }
    }

    /**
     * create payment data to create transaction on braintree
     *
     * @param array $cartData
     * @param object $paymentDo
     * @return void
     */
    public function createPaymentData($cartData, $paymentDo)
    {
        
        $paymentData = [
            self::AMOUNT => $cartData['price'],
            self::PAYMENT_METHOD_TOKEN => $this->_paymentMethodToken,
            self::ORDER_ID => $paymentDo->getOrder()->getOrderIncrementId(),
            'seller_id' => $cartData['seller']
        ];

        if ($cartData['seller'] && isset($cartData['sub_merchant_id']) && $cartData['sub_merchant_id']) {
            $paymentData[self::MERCHANT_ACCOUNT_ID] = $cartData['sub_merchant_id'];
            $paymentData[self::SERVICE_FEE] = $cartData['commission'];
        } else {
            $paymentData[self::MERCHANT_ACCOUNT_ID] = $this->config->getMerchantAccountId();
        }

        return $paymentData;
    }

    /**
     * create|get payment method token from braintree
     *
     * @param object $paymentDo
     * @return void
     */
    public function getPaymentMethodToken($paymentDo)
    {
        $order = $paymentDo->getOrder();
        $customerArray['firstName'] = $order->getBillingAddress()->getFirstname();
        $customerArray['lastName'] = $order->getBillingAddress()->getLastname();
        $customerArray['email'] = $order->getBillingAddress()->getEmail();
        $customerArray['company'] = $order->getBillingAddress()->getCompany();
        $customerArray['paymentMethodNonce'] = $paymentDo->getPayment()->getAdditionalInformation(
            DataAssignObserver::PAYMENT_METHOD_NONCE
        );
        if ($paymentDo->getOrder()->getCustomerId()) {
            $customerId = $order->getCustomerId();
            $braintreeCustomer = $this->adapter->findCustomer('customer_'.$customerId);
            if ($braintreeCustomer && $braintreeCustomer->id) {
                $this->_paymentMethodToken = $braintreeCustomer->paymentMethods[0]->token;
                return;
            } else {
                $customerArray['id'] = 'customer_'.$order->getCustomerId();
            }
        }
        $result = $this->adapter->createCustomer($customerArray);

        if ($result->success) {
            $this->_paymentMethodToken = $result->customer->paymentMethods[0]->token;
        } else {
            throw new \Magento\Framework\Exception\LocalizedException(__("not able to create customer"));
        }
    }

    /**
     * create request for braintree transaction
     *
     * @param object $buildSubject
     * @return array
     */
    private function buildRequestData($buildSubject)
    {
        $result = [];
        foreach ($this->builders as $builder) {
            // @TODO implement exceptions catching
            $result = $this->merge($result, $builder->build($buildSubject));
        }

        return $result;
    }

    /**
     * Merge function for builders
     *
     * @param array $result
     * @param array $builder
     * @return array
     */
    protected function merge(array $result, array $builder)
    {
        return array_replace_recursive($result, $builder);
    }

    /**
     * create final cart for seller
     *
     * @param \Magento\Sales\Model\Order $order
     * @return void
     */
    private function createFinalCart($order)
    {

        if ($order) {
            $order = $this->_objectManager
              ->create('Magento\Quote\Model\Quote')
              ->load($this->_checkoutSession->getQuoteId());
            $cart = $this->getSellerCart($order);
            usort($cart, function ($a, $b) {
                // compare seller id(s)
                return $a['data']['seller_id'] - $b['data']['seller_id'];
            });
            $commission = 0;
            /**
             * $orderShippingTaxAmount get shipping tax amount if any.
             *
             * @var decimal
             */
            $orderShippingTaxAmount = $order->getShippingAddress()
              ->getData('shipping_tax_amount');
            $finalcart = [];
            $i = 0;
            $adminTaxAmount = 0;
            
            foreach ($cart as $item) {
                $accessToken = '';
                $publishKey = '';
                $temp = $item['data'];
                $commission += $temp['commission'];
                $braintreeSubMerchantId = '';
                if ($temp['seller_id'] != 0) {
                    $braintreeSubMerchantId = $this->getSubmerchantId($temp['seller_id']);
                }
                    
                $adminTaxAmount += $temp['tax_amount'];
                
                if ($i == 0) {
                    $finalcart[$i]['shippingprice'] = $temp['shipping_price'];
                    $finalcart[$i]['commission'] = $temp['commission'];
                    $finalcart[$i]['price'] = $temp['price'];
                    $finalcart[$i]['products'] = $temp['product_id'];
                    $finalcart[$i]['taxamount'] = $temp['tax_amount'];
                    $finalcart[$i]['seller'] = $temp['seller_id'];
                    $finalcart[$i]['sub_merchant_id'] = $braintreeSubMerchantId;
                    ++$i;
                } else {
                    if ($temp['seller_id'] == $finalcart[$i - 1]['seller']) {
                        $finalcart[$i - 1]['price'] =
                        $this->_objectManager->get("\Magento\Framework\Pricing\PriceCurrencyInterface")->round(
                            $finalcart[$i - 1]['price'] + $temp['price']
                        );


                        $finalcart[$i - 1]['commission'] = $finalcart[$i - 1]['commission'] + $temp['commission'];
                        $finalcart[$i - 1]['products'] =
                        $finalcart[$i - 1]['products'].','.$temp['product_id'];

                        $finalcart[$i - 1]['taxamount'] =
                        $finalcart[$i - 1]['taxamount'] +
                        $temp['tax_amount'];
                    } else {
                        $finalcart[$i]['shippingprice'] = $temp['shipping_price'];
                        $finalcart[$i]['commission'] = $temp['commission'];
                        $finalcart[$i]['price'] = $temp['price'];
                        $finalcart[$i]['products'] = $temp['product_id'];
                        $finalcart[$i]['taxamount'] = $temp['tax_amount'];
                        $finalcart[$i]['seller'] = $temp['seller_id'];
                        $finalcart[$i]['sub_merchant_id'] = $braintreeSubMerchantId;
                        ++$i;
                    }
                }
            }
            
            $status = 0;
            $index = 0;
            $counter = 0;
            foreach ($finalcart as $cart) {
                if (!isset($cart['seller']) || $cart['seller'] == 0) {
                    $status = 1;
                    $index = $counter;
                }
                ++$counter;
            }

            $quoteshipPrice = 0;
            if ($this->_newvar != 'webkul') {
                $quoteshipPrice = $order->getShippingAddress()->getBaseShippingAmount();
            }

            /**
             * if admin product
             */
            if ($status == 1) {
                $finalcart[$index]['price'] =
                $finalcart[$index]['price'] + $quoteshipPrice;

                $finalcart[$index]['shippingprice'] =
                $finalcart[$index]['shippingprice'] +
                $quoteshipPrice;
            } else {
                $marketplaceHelper = $this->_objectManager->create(
                    'Webkul\Marketplace\Helper\Data'
                );
                /**
                 * if tax to admin or admin shipping both are set
                 */
                if (!$marketplaceHelper->getConfigTaxManage() || $quoteshipPrice != 0) {
                    /**
                     * if admin shipping is used
                     */
                    if ($this->_newvar == '') {
                        $finalcart[$counter]['price'] =
                        $this->_priceCurrency->round(
                            $quoteshipPrice + $orderShippingTaxAmount
                        );
                    } elseif ($orderShippingTaxAmount !== 0) {
                        $finalcart[$counter]['price'] = $orderShippingTaxAmount;
                    } else {
                        $finalcart[$counter]['price'] = 0;
                    }

                    $finalcart[$counter]['seller'] = 0;
                    if (!$marketplaceHelper->getConfigTaxManage()) {
                        $finalcart[$counter]['price'] =  $this->_priceCurrency->round($finalcart[$counter]['price']+$order->getBaseTaxAmount());
                    }

                    $finalcart[$counter]['products'] = null;
                }
            }
        }

        return $finalcart;
    }

    /**
     * get submerchant id of transaction
     *
     * @param int $sellerId
     * @return string
     */
    private function getSubmerchantId($sellerId)
    {
        if ($sellerId) {
            $seller = $this->customerFactory->create()->load($sellerId);
            $merchantStatus = $seller->getSubMerchantStatus();
            if ($seller->getBraintreeSubmerchantId() && $merchantStatus) {
                return $seller->getBraintreeSubmerchantId();
            } elseif ($seller->getBraintreeSubmerchantId()) {
                try {
                    $merchant = $this->adapter->findSubMerchant($seller->getBraintreeSubmerchantId());
                    if ($merchant->status == 'active') {
                        return $seller->getBraintreeSubmerchantId();
                    }
                } catch (\Exception $e) {
                    return '';
                }
            }
        }
        return '';
    }

    /**
     * create seller wise cart data
     *
     * @param object $order
     * @return array
     */
    private function getSellerCart($order)
    {
        $finalCart = [];
        if ($order) {
            $cartItems = $order->getAllVisibleItems();
            $cart = [];
            $i = 0;
            $orderShippingTaxAmount = 0;
            $orderShippingAmount = 0;
            $customerAddressId = 0;
            $sellerId = 0;
            $commissionDetail = [];
            // var_dump($order->getBaseDiscountAmount());die;
            if (!empty($order->getShippingAddress())) {
                /**
                 * $shipmeth shipping method code.
                 *
                 * @var string
                 */
                $shipmeth = $order->getShippingAddress()->getShippingMethod();
                /**
                 * $orderShippingTaxAmount get shipping tax amount if any.
                 *
                 * @var decimal
                 */
                $orderShippingTaxAmount = $order->getShippingAddress()
                    ->getData('shipping_tax_amount');

                /**
                 * $orderShippingAmount order shipping amount.
                 *
                 * @var decimal
                 */
                $orderShippingAmount = $order->getShippingAddress()
                    ->getBaseShippingAmount();

                /**
                 * $customerAddressId customer shipping address id.
                 *
                 * @var int
                 */
                $customerAddressId = $order->getShippingAddress()
                    ->getCustomerAddressId();
            } else {
                /**
                 * $shipmeth if shipping address not set them shipping method is none.
                 */
                $shipmeth = '';
                /**
                 * [$customerAddressId billing address id.
                 */
                $customerAddressId = $order->getBillingAddress()
                    ->getCustomerAddressId();
            }
            /**
             * $customerAddressId if no shipping address id found then get billing address id.
             */
            if ($customerAddressId == null) {
                $customerAddressId = $order->getBillingAddress()
                    ->getCustomerAddressId();
            }
           
            $methods = $this->_objectManager->create(
                'Magento\Shipping\Model\Config'
            )->getActiveCarriers();
            $options = [];
            $allmethods = [];
            $shipinf = [];
            foreach ($methods as $_code => $_method) {
                array_push($allmethods, $_code);
            }

            /**
             * $shipmeth if marketplace multishipping is set then seller wise shipping amount.
             */
            if ($shipmeth == 'mp_multi_shipping_mp_multi_shipping') {
                $this->_newvar = 'webkul';
                /**
                 * $shippinginfo get multi shipping details from sesssion.
                 *
                 * @var array
                 */
                $shippinginfo = $this->_objectManager->get("\Magento\Framework\Session\SessionManager")->getData(
                    'selected_shipping'
                );
                foreach ($shippinginfo as $key => $val) {
                    $shipinf[] = ['seller' => $key,'amount' => $val['amount']];
                }
            } else {
                $shipmethod = explode('_', $shipmeth, 2);
                /**
                 * $shippinginfo get shipping info details from session no multi shipping.
                 *
                 * @var array
                 */
                $shippinginfo = $this->_objectManager->get("\Magento\Framework\Session\SessionManager")->getShippingInfo();
                /*
                 * create seller wise shipping details array
                 */
                if (in_array($shipmethod[0], $allmethods)) {
                    if (!empty($shippinginfo[$shipmethod[0]])) {
                        foreach ($shippinginfo[$shipmethod[0]] as $key) {
                            $this->_newvar = 'webkul';
                            foreach ($key['submethod'] as $k => $v) {
                                if ($k == $shipmethod[1]) {
                                    $shipinf[] = [
                                            'seller' => $key['seller_id'],
                                            'amount' => $v['cost'],
                                        ];
                                }
                            }
                        }
                    }
                }
            }
            /**
             * $marketplaceHelper get marketplace helper.
             *
             * @var Webkul\Marketplace\Helper\Data
             */
            $marketplaceHelper = $this->_objectManager->create(
                'Webkul\Marketplace\Helper\Data'
            );
            /*
             * dispatch event for advance commission module
             */
            $this->_objectManager->get('\Magento\Framework\Event\Manager')->dispatch(
                'mp_advance_commission_rule',
                ['order' => $order]
            );

            /**
             * $advanceCommissionRule advance commssion rule from session if set.
             */
            $advanceCommissionRule = $this->_objectManager->get('\Magento\Customer\Model\Session')->getData(
                'advancecommissionrule'
            );

            /*
             * iterate through cart items to create seller wise payment details
             */
            foreach ($cartItems as $item) {
                // var_dump($item->getBaseDiscountAmount());die;
                $invoiceprice = 0;
                $itemId = $item->getProductId();
                $sellerId = 0;
                /**
                 * $assignSellerId variable to store assign seller id.
                 *
                 * @var int
                 */
                $assignSellerId = $this->_helper->getAssignSellerId($item);

                $seller = $this->_objectManager->create(
                    'Webkul\Marketplace\Model\ProductFactory'
                )->create()->getCollection();

                /*
                 * check if assign seller id exists then add filter for seller id else product id
                 */
                if ($assignSellerId) {
                    $sellerId = $assignSellerId;
                } else {
                    $seller->addFieldToFilter('mageproduct_id', $itemId);
                    if ($seller->getSize() > 0) {
                        foreach ($seller as $obj) {
                            $sellerId = $obj->getSellerId();
                        }
                    }
                }

                $tempcoms = 0;
                /*
                 * get advance commission rule 
                 */
                if (!$marketplaceHelper->getUseCommissionRule()) {
                    /*
                     * dispatch event for the calculation of advance commission
                     */
                    $this->_objectManager->get('\Magento\Framework\Event\Manager')->dispatch(
                        'mp_advance_commission',
                        ['id' => $itemId]
                    );
                    /**
                     * [$advancecommission get Advance commission from the session.
                     *
                     * @var decimal
                     */
                    $advancecommission = $this->_objectManager->get('\Magento\Customer\Model\Session')->getData(
                        'commission'
                    );
                    /*
                     * check if advance commission is set then calculate commission
                     */
                    if ($advancecommission != '') {
                        $percent = $advancecommission;
                        $commType = $marketplaceHelper->getCommissionType();
                        if ($commType == 'fixed') {
                            $tempcoms = $percent;
                        } else {
                            $tempcoms = ($item->getBaseRowTotal() * $advancecommission) / 100;
                        }
                        if ($tempcoms > $item->getBaseRowTotal()) {
                            $tempcoms = $item->getBaseRowTotal() * $marketplaceHelper->getConfigCommissionRate() / 100;
                        }

                        $commissionDetail['id'] = $sellerId;
                    }
                } else {
                    /*
                     * check if advance commission is not set then set calculate advance commission 
                     */
                    if (count($advanceCommissionRule)) {
                        if ($advanceCommissionRule[$item->getId()]['type'] == 'fixed') {
                            $tempcoms = $advanceCommissionRule[$item->getId()]['amount'];
                        } else {
                            $tempcoms =
                                ($item->getRowTotal() * $advanceCommissionRule[$item->getId()]['amount']) / 100;
                        }

                        $commissionDetail['id'] = $sellerId;
                    }
                }

                /*
                 * if there is no advance commission then calculate normal commission
                 */
                if (!$tempcoms) {
                    $commissionDetail = $this->_helper->getSellerDetail($sellerId);

                    if ($commissionDetail['id'] !== 0
                        && $commissionDetail['commission'] !== 0
                    ) {
                        $tempcoms = $this->_objectManager->get("\Magento\Framework\Pricing\PriceCurrencyInterface")->round(
                            ($item->getRowTotal() * $commissionDetail['commission']) / 100,
                            2
                        );
                    }
                }

                /**
                 * $price price after commission.
                 *
                 * @var decimal
                 */
                $price = $this->_objectManager->get("\Magento\Framework\Pricing\PriceCurrencyInterface")->round($item->getBaseRowTotal());
                /**
                 * $invoiceprice row total of product.
                 *
                 * @var decimal
                 */
                $invoiceprice = $item->getBaseRowTotal();
                /**
                 * include tax amount if tax management done by seller
                 */
                if ($sellerId && $marketplaceHelper->getConfigTaxManage()) {
                    $price = $this->_objectManager->get("\Magento\Framework\Pricing\PriceCurrencyInterface")->round($price+$item->getBaseTaxAmount());
                } elseif (!$sellerId) {
                    /**
                     * else tax managed by admin
                     */
                    $price = $this->_objectManager->get("\Magento\Framework\Pricing\PriceCurrencyInterface")->round($item->getBaseRowTotal() + $item->getBaseTaxAmount() + $orderShippingTaxAmount);
                }


                $shippingprice = 0;
                if ($this->_newvar == 'webkul') {
                    $custid = 0;

                    $custid = $sellerId;

                    foreach ($shipinf as $k => $key) {
                        if ($key['seller'] == $custid) {
                            $price = $price + $key['amount'];
                            $shippingprice = $key['amount'];
                            $shipinf[$k]['amount'] = 0;
                        }
                    }
                }
                /*
                 * create seller wise array for payment 
                 */
                if ($orderShippingTaxAmount !== 0
                    && ($commissionDetail['id'] == 0)
                ) {
                    $this->_adminShipTaxAmt = 1;
                    $cart[$i]['data'] = [
                        'seller_id' => $commissionDetail['id'],
                        'commission' => $tempcoms,
                        'product_id' => $item->getProductId(),
                        'price' => $price,
                        'shipping_price' => $shippingprice,
                        'tax_amount' => $this->_objectManager->get("\Magento\Framework\Pricing\PriceCurrencyInterface")->round($item->getBaseTaxAmount() + $orderShippingTaxAmount),
                    ];
                } else {
                    $cart[$i]['data'] = [
                        'seller_id' => $commissionDetail['id'],
                        'commission' => $tempcoms,
                        'product_id' => $item->getProductId(),
                        'price' => $price,
                        'shipping_price' => $shippingprice,
                        'tax_amount' => $item->getBaseTaxAmount(),
                    ];
                }
                ++$i;
            }
            return $cart;
        } else {
            throw new \Magento\Framework\Exception\LocalizedException(
                _(
                    'There was an error capturing the transaction: Please contact admin'
                )
            );
        }
    }

    /**
     * get item discount amount
     *
     * @param Magento\Sales\Model\Order\Item $item
     * @return float
     */
    public function getItemDiscount($item)
    {
        //TO-DO calculate marketplace seller coupons discount
        if ($item->getBaseDiscountAmount() > 0) {
            return $item->getBaseDiscountAmount();
        }
        return 0;
    }
}
