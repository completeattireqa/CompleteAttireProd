/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_MpBraintree
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
/*browser:true*/
/*global define*/
define(
    [
        'ko',
        'jquery',
        'Magento_Checkout/js/view/payment/default',
        'Magento_Checkout/js/action/set-payment-information',
        'Magento_Checkout/js/action/select-payment-method',
        'Magento_Checkout/js/checkout-data',
        'Magento_Checkout/js/model/quote',
        'Magento_Checkout/js/model/totals',
        'mage/translate',
        'mage/url',
        'Magento_Checkout/js/model/payment/additional-validators',
        "https://js.braintreegateway.com/web/dropin/1.3.1/js/dropin.min.js"
    ],
    function (
        ko,
        $,
        Component,
        setPaymentInformationAction,
        selectPaymentMethodAction,
        checkoutData,
        quote,
        totals,
        $t,
        url,
        additionalValidators,
        braintreeSdk
    ) {
        'use strict';
        /**
         * braintreeConfig contains all the payment configuration
         */
         var braintreeConfig = window.checkoutConfig.payment.mpbraintree;
         /**
          * customerEmail customer email
          */
         var customerEmail = window.customerData.email;
         var customerCountry = window.customerData.defaultCountryId;

        return Component.extend(
            {
                //redirectAfterPlaceOrder: false,
                defaults: {
                    template: 'Webkul_MpBraintree/payment/mpbraintree',
                    paymentNonce: null,
                    displayPlaceOrder: false,
                    showAuthorize: false,
                    authorizeButtonTitle: $t('Authorize'),
                    orderPlaceButtonTitle: $t('Place Order'),
                    canSaveCard: 0,
                    storeInVaultOnSuccess: 0,
                    paymentMethodRequestable: false
                },

                /**
                 * @override
                 */
                initObservable: function () {
                    this._super()
                        .observe(
                            [
                                'paymentNonce',
                                'displayPlaceOrder',
                                'showAuthorize',
                                'authorizeButtonTitle',
                                'canSaveCard',
                                'storeInVaultOnSuccess',
                                'paymentMethodRequestable',
                                'orderPlaceButtonTitle'
                            ]
                        );
                        this.createBraintreePayment();
                    return this;
                },
              
                /**
                 * validate  to validate the payment method fields at checkout page
                 *
                 * @return boolean
                 */
                validate: function () {
                    if (this.paymentNonce) {
                        return true;
                    } else {
                        this.messageContainer.addErrorMessage({message: $t("Please select a card or create a new card")});
                        return false;
                    }
                },

                /**
                 * selectPaymentMethod called when payment method is selected
                 *
                 * @return boolean
                 */
                selectPaymentMethod: function () {
                    selectPaymentMethodAction(this.getData());
                    checkoutData.setSelectedPaymentMethod('mpbraintree');
                    return true;
                  
                },

                /**
                 * create baintree fropin ui and place order
                 */
                createBraintreePayment: function () {
                    var self = this;

                    braintreeSdk.create({
                        authorization: braintreeConfig.clientToken,
                        container: '#mpbraintree-container',
                        locale: braintreeConfig.locale
                    }, function (createErr, instance) {
                        if (createErr) {
                            self.messageContainer.addErrorMessage({message: $t(createErr.message)});
                            self.isPlaceOrderActionAllowed(false);
                            return;
                        }
                        self.showAuthorize(true);
                        if (braintreeConfig.vaultEnable && window.isCustomerLoggedIn) {
                            self.authorizeButtonTitle($t("Authorize And Pay"));
                            self.orderPlaceButtonTitle($t("Authorize And Pay"));
                            self.paymentMethodRequestable(true);
                        }
                        $('button.mpbraintree-authorize').on('click', function () {
                            instance.requestPaymentMethod(function (requestPaymentMethodErr, payload) {
                                //console.log(payload);
                                if (requestPaymentMethodErr) {
                                    //console.log(requestPaymentMethodErr);
                                    self.messageContainer.addErrorMessage({message: requestPaymentMethodErr._braintreeWebError.message});
                                    return;
                                }
                                self.displayPlaceOrder(true);
                                self.paymentNonce(payload.nonce);
                                if (payload.vaulted) {
                                    $(".checkout.mpbraintree").trigger("click");
                                }

                            });
                        });

                        instance.on('paymentMethodRequestable', function (event) {
                            self.paymentMethodRequestable(true);
                        });

                        instance.on('noPaymentMethodRequestable', function () {
                            self.displayPlaceOrder(false);
                            self.paymentMethodRequestable(false);
                        });

                    });
                },

                /**
                 * on checkbox check update save in vault status
                 */
                updateValutStatus: function () {
                    if ($('.canSaveCard').is(':checked')) {
                        this.storeInVaultOnSuccess(1);
                    } else {
                        this.storeInVaultOnSuccess(0);
                    }
                },

                /**
                 * totals set order totals from quote
                 */
                totals: quote.getTotals(),
              
                /**
                 * getGrandTotal get order grand total
                 *
                 * @return decimal
                 */
                getGrandTotal:function () {
                    var price = 0;
                    if (this.totals()) {
                        price = totals.getSegment('grand_total').value;
                    }
                    return price;
                },

                /**
                 * getData set payment method data for making it available in PaymentMethod Class
                 *
                 * @return object
                 */
                getData: function () {
                    var self = this;
                    return {
                        'method': 'mpbraintree',
                        'additional_data': {
                            'payment_method_nonce': self.paymentNonce(),
                            'storeInVaultOnSuccess':self.storeInVaultOnSuccess()
                        },
                    };
                }
            }
        );
    }
);