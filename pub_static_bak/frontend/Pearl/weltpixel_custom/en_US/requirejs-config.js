(function(require){
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            checkoutBalance:    'Magento_Customer/js/checkout-balance',
            address:            'Magento_Customer/address',
            changeEmailPassword: 'Magento_Customer/change-email-password',
            passwordStrengthIndicator: 'Magento_Customer/js/password-strength-indicator',
            zxcvbn: 'Magento_Customer/js/zxcvbn',
            addressValidation: 'Magento_Customer/js/addressValidation'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            'rowBuilder':             'Magento_Theme/js/row-builder',
            'toggleAdvanced':         'mage/toggle',
            'translateInline':        'mage/translate-inline',
            'sticky':                 'mage/sticky',
            'tabs':                   'mage/tabs',
            'zoom':                   'mage/zoom',
            'collapsible':            'mage/collapsible',
            'dropdownDialog':         'mage/dropdown',
            'dropdown':               'mage/dropdowns',
            'accordion':              'mage/accordion',
            'loader':                 'mage/loader',
            'tooltip':                'mage/tooltip',
            'deletableItem':          'mage/deletable-item',
            'itemTable':              'mage/item-table',
            'fieldsetControls':       'mage/fieldset-controls',
            'fieldsetResetControl':   'mage/fieldset-controls',
            'redirectUrl':            'mage/redirect-url',
            'loaderAjax':             'mage/loader',
            'menu':                   'mage/menu',
            'popupWindow':            'mage/popup-window',
            'validation':             'mage/validation/validation',
            'welcome':                'Magento_Theme/js/view/welcome',
            'breadcrumbs':            'Magento_Theme/js/view/breadcrumbs'
        }
    },
    paths: {
        'jquery/ui': 'jquery/jquery-ui'
    },
    deps: [
        'jquery/jquery.mobile.custom',
        'mage/common',
        'mage/dataPost',
        'mage/bootstrap'
    ],
    config: {
        mixins: {
            'Magento_Theme/js/view/breadcrumbs': {
                'Magento_Theme/js/view/add-home-breadcrumb': true
            }
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    'waitSeconds': 0,
    'map': {
        '*': {
            'ko': 'knockoutjs/knockout',
            'knockout': 'knockoutjs/knockout',
            'mageUtils': 'mage/utils/main',
            'rjsResolver': 'mage/requirejs/resolver'
        }
    },
    'shim': {
        'jquery/jquery-migrate': ['jquery'],
        'jquery/jquery.hashchange': ['jquery', 'jquery/jquery-migrate'],
        'jquery/jstree/jquery.hotkeys': ['jquery'],
        'jquery/hover-intent': ['jquery'],
        'mage/adminhtml/backup': ['prototype'],
        'mage/captcha': ['prototype'],
        'mage/common': ['jquery'],
        'mage/new-gallery': ['jquery'],
        'mage/webapi': ['jquery'],
        'jquery/ui': ['jquery'],
        'MutationObserver': ['es6-collections'],
        'tinymce': {
            'exports': 'tinymce'
        },
        'moment': {
            'exports': 'moment'
        },
        'matchMedia': {
            'exports': 'mediaCheck'
        },
        'jquery/jquery-storageapi': {
            'deps': ['jquery/jquery.cookie']
        }
    },
    'paths': {
        'jquery/validate': 'jquery/jquery.validate',
        'jquery/hover-intent': 'jquery/jquery.hoverIntent',
        'jquery/file-uploader': 'jquery/fileUploader/jquery.fileupload-fp',
        'jquery/jquery.hashchange': 'jquery/jquery.ba-hashchange.min',
        'prototype': 'legacy-build.min',
        'jquery/jquery-storageapi': 'jquery/jquery.storageapi.min',
        'text': 'mage/requirejs/text',
        'domReady': 'requirejs/domReady',
        'tinymce': 'tiny_mce/tiny_mce_src'
    },
    'deps': [
        'jquery/jquery-migrate'
    ],
    'config': {
        'mixins': {
            'jquery/jstree/jquery.jstree': {
                'mage/backend/jstree-mixin': true
            }
        },
        'text': {
            'headers': {
                'X-Requested-With': 'XMLHttpRequest'
            }
        }
    }
};

require(['jquery'], function ($) {
    'use strict';

    $.noConflict();
});

require.config(config);
})();
(function() {
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
 var config = {
 	map: {
 		'*': {
 			lofallOwlCarousel: 'Lof_All/lib/owl.carousel/owl.carousel.min',
 			lofallBootstrap: 'Lof_All/lib/bootstrap/js/bootstrap.min',
 			lofallColorbox: 'Lof_All/lib/colorbox/jquery.colorbox.min',
 			lofallFancybox: 'Lof_All/lib/fancybox/jquery.fancybox.pack',
 			lofallFancyboxMouseWheel: 'Lof_All/lib/fancybox/jquery.mousewheel-3.0.6.pack'
 		}
 	},
 	shim: {
        'Lof_All/lib/bootstrap/js/bootstrap.min': {
            'deps': ['jquery']
        },
        'Lof_All/lib/bootstrap/js/bootstrap': {
            'deps': ['jquery']
        },
        'Lof_All/lib/owl.carousel/owl.carousel': {
            'deps': ['jquery']
        },
        'Lof_All/lib/owl.carousel/owl.carousel.min': {
        	'deps': ['jquery']
        },
        'Lof_All/lib/fancybox/jquery.fancybox': {
            'deps': ['jquery']  
        },
        'Lof_All/lib/fancybox/jquery.fancybox.pack': {
            'deps': ['jquery']  
        },
        'Lof_All/lib/colorbox/jquery.colorbox': {
            'deps': ['jquery']  
        },
        'Lof_All/lib/colorbox/jquery.colorbox.min': {
            'deps': ['jquery']  
        }
    }
 };
require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            compareList:            'Magento_Catalog/js/list',
            relatedProducts:        'Magento_Catalog/js/related-products',
            upsellProducts:         'Magento_Catalog/js/upsell-products',
            productListToolbarForm: 'Magento_Catalog/js/product/list/toolbar',
            catalogGallery:         'Magento_Catalog/js/gallery',
            priceBox:               'Magento_Catalog/js/price-box',
            priceOptionDate:        'Magento_Catalog/js/price-option-date',
            priceOptionFile:        'Magento_Catalog/js/price-option-file',
            priceOptions:           'Magento_Catalog/js/price-options',
            priceUtils:             'Magento_Catalog/js/price-utils',
            catalogAddToCart:       'Magento_Catalog/js/catalog-add-to-cart'
        }
    },
    config: {
        mixins: {
            'Magento_Theme/js/view/breadcrumbs': {
                'Magento_Catalog/js/product/breadcrumbs': true
            }
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            addToCart: 'Magento_Msrp/js/msrp'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            bundleOption:   'Magento_Bundle/bundle',
            priceBundle:    'Magento_Bundle/js/price-bundle',
            slide:          'Magento_Bundle/js/slide',
            productSummary: 'Magento_Bundle/js/product-summary'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            creditCardType: 'Magento_Payment/cc-type'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            quickSearch: 'Magento_Search/form-mini'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            giftMessage:    'Magento_Sales/gift-message',
            ordersReturns:  'Magento_Sales/orders-returns'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            discountCode:           'Magento_Checkout/js/discount-codes',
            shoppingCart:           'Magento_Checkout/js/shopping-cart',
            regionUpdater:          'Magento_Checkout/js/region-updater',
            sidebar:                'Magento_Checkout/js/sidebar',
            checkoutLoader:         'Magento_Checkout/js/checkout-loader',
            checkoutData:           'Magento_Checkout/js/checkout-data',
            proceedToCheckout:      'Magento_Checkout/js/proceed-to-checkout'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            configurable: 'Magento_ConfigurableProduct/js/configurable'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            requireCookie: 'Magento_Cookie/js/require-cookie',
            cookieNotices: 'Magento_Cookie/js/notices'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            transparent: 'Magento_Payment/transparent'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            orderReview: 'Magento_Paypal/order-review',
            paypalCheckout: 'Magento_Paypal/js/paypal-checkout'
        }
    },
    paths: {
        paypalInContextExpressCheckout: 'https://www.paypalobjects.com/api/checkout'
    },
    shim: {
        paypalInContextExpressCheckout: {
            exports: 'paypal'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            downloadable: 'Magento_Downloadable/downloadable'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            giftOptions:    'Magento_GiftMessage/gift-options',
            extraOptions:   'Magento_GiftMessage/extra-options'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    paths: {
        'ui/template': 'Magento_Ui/templates'
    },
    map: {
        '*': {
            uiElement:      'Magento_Ui/js/lib/core/element/element',
            uiCollection:   'Magento_Ui/js/lib/core/collection',
            uiComponent:    'Magento_Ui/js/lib/core/collection',
            uiClass:        'Magento_Ui/js/lib/core/class',
            uiEvents:       'Magento_Ui/js/lib/core/events',
            uiRegistry:     'Magento_Ui/js/lib/registry/registry',
            consoleLogger:  'Magento_Ui/js/lib/logger/console-logger',
            uiLayout:       'Magento_Ui/js/core/renderer/layout',
            buttonAdapter:  'Magento_Ui/js/form/button-adapter'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            multiShipping: 'Magento_Multishipping/js/multi-shipping',
            orderOverview: 'Magento_Multishipping/js/overview',
            payment: 'Magento_Multishipping/js/payment',
            billingLoader: 'Magento_Checkout/js/checkout-loader'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            pageCache:  'Magento_PageCache/js/page-cache'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            transparent: 'Magento_Payment/transparent'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            braintree: 'https://js.braintreegateway.com/js/braintree-2.32.0.min.js'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            recentlyViewedProducts: 'Magento_Reports/js/recently-viewed'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            loadPlayer: 'Magento_ProductVideo/js/load-player',
            fotoramaVideoEvents: 'Magento_ProductVideo/js/fotorama-add-video-events'
        }
    },
    shim: {
        vimeoAPI: {}
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            captcha: 'Magento_Captcha/captcha'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright 2016 Amazon.com, Inc. or its affiliates. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 *  http://aws.amazon.com/apache2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */

var config = {
    map: {
        '*': {
            amazonLogout: 'Amazon_Login/js/amazon-logout',
            amazonOAuthRedirect: 'Amazon_Login/js/amazon-redirect',
            amazonCsrf: 'Amazon_Login/js/amazon-csrf'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright 2016 Amazon.com, Inc. or its affiliates. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 *  http://aws.amazon.com/apache2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */
var config = {
    map: {
        '*': {
            amazonCore: 'Amazon_Payment/js/amazon-core',
            amazonWidgetsLoader: 'Amazon_Payment/js/amazon-widgets-loader',
            amazonButton: 'Amazon_Payment/js/amazon-button',
            amazonProductAdd: 'Amazon_Payment/js/amazon-product-add',
            bluebird: 'Amazon_Payment/js/lib/bluebird.min',
            amazonPaymentConfig: 'Amazon_Payment/js/model/amazonPaymentConfig',
            sjcl: 'Amazon_Payment/js/lib/sjcl.min'
        }
    },
    config: {
        mixins: {
            'Amazon_Payment/js/action/place-order': {
                'Amazon_Payment/js/model/place-order-mixin': true
            }
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            catalogSearch: 'Magento_CatalogSearch/form-mini'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            wishlist:       'Magento_Wishlist/js/wishlist',
            addToWishlist:  'Magento_Wishlist/js/add-to-wishlist',
            wishlistSearch: 'Magento_Wishlist/js/search'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * BSS Commerce Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://bsscommerce.com/Bss-Commerce-License.txt
 *
 * @category  BSS
 * @package   Bss_GroupedProductOption
 * @author    Extension Team
 * @copyright Copyright (c) 2017-2018 BSS Commerce Co. ( http://bsscommerce.com )
 * @license   http://bsscommerce.com/Bss-Commerce-License.txt
 */

var config = {
    map: {
        '*': {
            'bss/groupedProductOptionSwatch': 'Bss_GroupedProductOption/js/configurable/swatch-renderer',
            'bss/groupedProductOptionConfigurable': 'Bss_GroupedProductOption/js/configurable/configurable',
            catalogAddToCart: 'Bss_GroupedProductOption/js/catalog-add-to-cart',
            theBssValidationMethod: "Bss_GroupedProductOption/js/validate/file-validate"
        }
    }
};
require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/action/place-order': {
                'Magento_CheckoutAgreements/js/model/place-order-mixin': true
            },
            'Magento_Checkout/js/action/set-payment-information': {
                'Magento_CheckoutAgreements/js/model/set-payment-information-mixin': true
            }
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            editTrigger: 'mage/edit-trigger',
            addClass: 'Magento_Translation/add-class'
        }
    },
    deps: [
        'mage/translate-inline'
    ]
};

require.config(config);
})();
(function() {
/**
 * This file is part of the Klarna KP module
 *
 * (c) Klarna Bank AB (publ)
 *
 * For the full copyright and license information, please view the NOTICE
 * and LICENSE files that were distributed with this source code.
 */
var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/action/get-payment-information': {
                'Klarna_Kp/js/action/override': true
            }
        }
    },
    map: {
        '*': {
            klarnapi: 'https://x.klarnacdn.net/kp/lib/v1/api.js'
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    map: {
        '*': {
            'taxToggle': 'Magento_Weee/tax-toggle'
        }
    }
};

require.config(config);
})();
(function() {
var config = {
    'paths': {
        'dmpt': 'Dotdigitalgroup_Email/js/dmpt'
    },
    'shim': {
        'dmpt': {
            exports: '_dmTrack'
        }
    }
};

require.config(config);
})();
(function() {
var config = {
    paths: {
        temandoCheckoutFieldsDefinition: 'Temando_Shipping/js/model/fields-definition',
        temandoDeliveryOptions: 'Temando_Shipping/js/model/delivery-options',
        temandoShippingRatesValidator: 'Temando_Shipping/js/model/shipping-rates-validator/temando',
        temandoShippingRatesValidationRules: 'Temando_Shipping/js/model/shipping-rates-validation-rules/temando'
    }
};

require.config(config);
})();
(function() {
/**
 * @copyright  Vertex. All rights reserved.  https://www.vertexinc.com/
 * @author     Mediotype                     https://www.mediotype.com/
 */

var config = {
    map: {
        '*': {
            'set-checkout-messages': 'Vertex_Tax/js/model/set-checkout-messages'
        }
    }
};

require.config(config);
})();
(function() {
var config = {
    map: {
        '*': {
            wesupplyestimations: 'WeSupply_Toolbox/js/wesupplyestimations',
            iframeResizer: 'https://cdnjs.cloudflare.com/ajax/libs/iframe-resizer/4.1.1/iframeResizer.min.js',
            wesupplyOrderView: 'WeSupply_Toolbox/js/embedded/wesupplyOrderView',
            loadIframe: 'WeSupply_Toolbox/js/embedded/loadIframe',
            deliveryEstimate: 'WeSupply_Toolbox/js/estimations/delivery'
        }
    },
    shim: {
        wesupplyestimations: {
            deps: ['jquery']
        },
        wesupplyOrderView: {
            deps: ['jquery']
        },
        loadIframe: {
            deps: ['jquery']
        },
        iframeResizer: {
            deps: ['jquery']
        },
        deliveryEstimate: {
            deps: ['jquery']
        }
    }
};
require.config(config);
})();
(function() {
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_Marketplace
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
var config = {
    map: {
        '*': {
            colorpicker: 'Webkul_Marketplace/js/colorpicker',
            verifySellerShop: 'Webkul_Marketplace/js/account/verify-seller-shop',
            editSellerProfile: 'Webkul_Marketplace/js/account/edit-seller-profile',
            sellerDashboard: 'Webkul_Marketplace/js/account/seller-dashboard',
            sellerAddProduct: 'Webkul_Marketplace/js/product/seller-add-product',
            sellerEditProduct: 'Webkul_Marketplace/js/product/seller-edit-product',
            sellerCreateConfigurable: 'Webkul_Marketplace/js/product/attribute/create',
            sellerProductList: 'Webkul_Marketplace/js/product/seller-product-list',
            sellerOrderHistory: 'Webkul_Marketplace/js/order/history',
            sellerOrderShipment: 'Webkul_Marketplace/js/order/shipment',
            colorPickerFunction: 'Webkul_Marketplace/js/color-picker-function',
            productGallery:     'Webkul_Marketplace/js/product-gallery',
            baseImage:          'Webkul_Marketplace/catalog/base-image-uploader',
            newVideoDialog:  'Webkul_Marketplace/js/new-video-dialog',
            openVideoModal:  'Webkul_Marketplace/js/video-modal',
            productAttributes:  'Webkul_Marketplace/catalog/product-attributes',
            configurableAttribute:  'Webkul_Marketplace/catalog/product/attribute',
            relatedProduct: 'Webkul_Marketplace/js/product/related-product',
            upsellProduct: 'Webkul_Marketplace/js/product/upsell-product',
            crosssellProduct: 'Webkul_Marketplace/js/product/crosssell-product',
            notification : 'Webkul_Marketplace/js/notification',
            separateSellerProductList: 'Webkul_Marketplace/js/product/separate-seller-product-list',
            formButtonAction: 'Webkul_Marketplace/js/form-button-action',
            'Magento_Ui/js/form/element/date':  'Webkul_Marketplace/js/form/element/date'
        }
    },
    paths: {
        "colorpicker": 'js/colorpicker'
    },
    "shim": {
        "colorpicker" : ["jquery"]
    }
};

require.config(config);
})();
(function() {
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_Customattribute
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
 /*jshint jquery:true*/
var config = {
    map: {
        '*': {
            addAttribute: 'Webkul_Customattribute/js/add-attribute',
        }
    }
};

require.config(config);
})();
(function() {
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_MpBraintree
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

var config = {
    map: {
        '*': {
            mpBrainTreeJs: 'Webkul_MpBraintree/js/mpBrainTreeJs'
        }
    }
};
require.config(config);
})();
(function() {
/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_MpGroupedProduct
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

var config = {
    map: {
        '*': {
            groupedProduct: 'Webkul_MpGroupedProduct/js/grouped-product',
            groupedProductAdd: 'Webkul_MpGroupedProduct/js/grouped-product-add'
        }
    }
};
require.config(config);
})();
(function() {
var config = {
    map: {
        '*': {
            ajaxinfinitescroll: 'WeltPixel_AjaxInfiniteScroll/js/ajaxinfinitescroll'
        }
    },
    paths: {
        ias: 'WeltPixel_AjaxInfiniteScroll/js/jquery-ias.min'
    },
    shim : {
        ias: ['jquery']
    }
};

require.config(config);
})();
(function() {
var config = {
    config: {
        mixins: {
            'mage/sticky': {
                'WeltPixel_CustomHeader/js/sticky-mixin': true
            }
        }
    }
};
require.config(config);
})();
(function() {
var config = {
    map: {
        '*': {
            designelements_base: 'WeltPixel_DesignElements/js/designelements_base',
            designelements_default: 'WeltPixel_DesignElements/js/designelements_default',
            toggles_accordions_tabs: 'WeltPixel_DesignElements/js/toggles_accordions_tabs',
            jRespond: 'WeltPixel_DesignElements/js/canvas/jRespond',
            Morphext: 'WeltPixel_DesignElements/js/canvas/Morphext',
            headings_blockquotes: 'WeltPixel_DesignElements/js/headings_blockquotes',
            smooth_scrolling:  'WeltPixel_DesignElements/js/smooth_scrolling',
            Alert: 'WeltPixel_DesignElements/js/bootstrap/alert',
            Button: 'WeltPixel_DesignElements/js/bootstrap/button',
            Dropdown: 'WeltPixel_DesignElements/js/bootstrap/dropdown',
            testimonialsGrid:  'WeltPixel_DesignElements/js/testimonialsGrid',
            flexslider: 'WeltPixel_DesignElements/js/canvas/jquery.flexslider',
            load_flex_slider: 'WeltPixel_DesignElements/js/load_flex_slider',
            stellar: 'WeltPixel_DesignElements/js/canvas/jquery.parallax',
            load_parallax: 'WeltPixel_DesignElements/js/load_parallax',
            jquery_important: 'WeltPixel_DesignElements/js/canvas/jquery.important',
            animations:  'WeltPixel_DesignElements/js/animations',
            aos_animation:  'WeltPixel_DesignElements/js/aos',
            jquery_transition: 'WeltPixel_DesignElements/js/canvas/jquery.transition',
            btt_button:  'WeltPixel_DesignElements/js/btt_button',
        }
    },
    shim: {
        "mage/tabs": {
            deps: ['toggles_accordions_tabs']
        },
        Morphext: {
            deps: ['jquery']
        },
        toggles_accordions_tabs: {
            deps: ['jquery']
        },
        Alert: {
            deps: ['jquery']
        },
        Button: {
            deps: ['jquery']
        },
        Dropdown: {
            deps: ['jquery']
        },
        flexslider: {
            deps: ['jquery']
        },
        stellar: {
            deps: ['jquery']
        },
        jquery_important: {
            deps: ['jquery', 'jquery/ui']
        },
        jquery_transition: {
            deps: ['jquery']
        }
    }
};
require.config(config);
})();
(function() {
var config = {
    map: {
        '*': {
            full_page: 'WeltPixel_FullPageScroll/js/jquery.fullPage.min',
            scrolloverflow: 'WeltPixel_FullPageScroll/js/scrolloverflow.min',
            fullpagescroll: 'WeltPixel_FullPageScroll/js/fullPageScroll'
        }
    }
};
require.config(config);
})();
(function() {
var config = {
    map: {
        '*': {
            weltpixel_gtm: 'WeltPixel_GoogleTagManager/js/weltpixel_gtm',
            weltpixel_persistentLayer: 'WeltPixel_GoogleTagManager/js/weltpixel_persistentlayer'
        }
    }
};
require.config(config);
})();
(function() {
var config = {
    map: {
        '*': {
            Instafeed: 'WeltPixel_InstagramWidget/js/Instafeed',
            shufflejs: 'WeltPixel_InstagramWidget/js/Shuffle',
            polyfill: 'WeltPixel_InstagramWidget/js/Polyfill',
        }
    },
    shim: {
        Instafeed: {
            deps: ['jquery']
        },
        shufflejs : {
            deps: ['polyfill']
        }
    }
};
require.config(config);
})();
(function() {
var config = {
    paths: {
        wpFilterSelect: 'WeltPixel_LayeredNavigation/js/wpFilterSelect',
        wpInstantSearch: 'WeltPixel_LayeredNavigation/js/wpInstantSearch',
        jqueryTouch: 'WeltPixel_LayeredNavigation/js/jqueryUiTouch.min'
    },
    shim: {
        jqueryTouch: ['jquery', 'jquery/ui','jquery/validate']

    }
};

require.config(config);
})();
(function() {
var config = {
    map: {
        '*': {
            owl_carousel: 'WeltPixel_OwlCarouselSlider/js/owl.carousel',
            owl_config: 'WeltPixel_OwlCarouselSlider/js/owl.config',
            owlAjax: 'WeltPixel_OwlCarouselSlider/js/owlAjax'
        }
    },
    shim: {
        owl_carousel: {
            deps: ['jquery']
        },
        owl_config: {
            deps: ['jquery','owl_carousel']
        },
        owlAjax: {
            deps: ['jquery','owl_carousel', 'owl_config']
        }
    }
};
require.config(config);
})();
(function() {
var config = {
    paths: {
        navigationJs: 'WeltPixel_NavigationLinks/js/navigation_js'
    },
    config: {
        mixins: {
            'mage/menu': {
                'WeltPixel_NavigationLinks/js/menu-mixin': true
            }
        }
    }
};
require.config(config);
})();
(function() {
var config = {
    map: {
        '*': {
            wpProductLabels: 'WeltPixel_ProductLabels/js/weltpixel_productlabels'
        }
    }
};
require.config(config);
})();
(function() {
var config = {
    map: {
        '*': {
            productPage: 'WeltPixel_ProductPage/js/productPage',
        }
    },
    shim: {
        productPage: {
            deps: ['jquery']
        }
    }
};
require.config(config);
})();
(function() {
var config = {
    map: {
        '*': {
            weltpixel_quickcart: 'WeltPixel_QuickCart/js/quickcart'
        }
    }
};
require.config(config);
})();
(function() {
var config = {
    map: {
        '*': {
            magnificPopup: 'WeltPixel_Quickview/js/jquery.magnific-popup.min',            
            weltpixel_quickview: 'WeltPixel_Quickview/js/weltpixel_quickview'
        }
    },
    shim: {
        magnificPopup: {
            deps: ['jquery']
        }
    }
};
require.config(config);
})();
(function() {
var config = {
    paths: {
        arv: 'WeltPixel_RecentlyViewedBar/js/arv',
        arvAjax: 'WeltPixel_RecentlyViewedBar/js/arvAjax'
    },
    shim: {
        jqueryTouch: ['jquery', 'jquery/ui']

    }
};

require.config(config);
})();
(function() {
var config = {
    map: {
        '*': {
            weltpixel_searchautocomplete: 'WeltPixel_SearchAutoComplete/js/searchautocomplete'
        }
    }
};
require.config(config);
})();
(function() {
var config = {
    map: {
        '*': {
            'sociallogin': 'WeltPixel_SocialLogin/js/sociallogin',
            'slReferer': 'WeltPixel_SocialLogin/js/slreferer'
        }
    }
};
require.config(config);
})();
(function() {
var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/view/registration': {
                'WeltPixel_ThankYouPage/js/view/registration': true
            }
        }
    }
};
require.config(config);
})();
(function() {
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

var config = {
    deps: [
        'Magento_Theme/js/responsive',
        'Magento_Theme/js/theme'
    ]
};

require.config(config);
})();
(function() {
var config = {
    config: {
        mixins: {
            'Magento_Swatches/js/swatch-renderer': {
                'WeltPixel_CategoryPage/js/swatch-renderer': true
            }
        }
    }
};
require.config(config);
})();



})(require);