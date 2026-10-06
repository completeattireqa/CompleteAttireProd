/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_MpBraintree
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        /**
         * braintreeConfig contains all the payment configuration
         */
         var braintreeConfig = window.checkoutConfig.payment.mpbraintree;
        /**
         * push stripe renderer in the default renderer list
         */
        if (braintreeConfig.isActive) {
            rendererList.push(
                {
                    type: 'mpbraintree',
                    component: 'Webkul_MpBraintree/js/view/payment/method-renderer/mpbraintree'
                }
            );
        }

        return Component.extend({});
    }
);