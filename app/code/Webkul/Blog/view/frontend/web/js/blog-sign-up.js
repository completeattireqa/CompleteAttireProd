/**
 * Webkul Software
 *
 * @category  Webkul
 * @package   Webkul_Blog
 * @author    Webkul
 * @copyright Copyright (c) 2010-2018 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

/*jshint jquery:true*/
define(
    [
    'jquery',
    'mage/translate',
    'Magento_Ui/js/modal/alert',
    ],
    function ($,$t,alert) {
        'use strict';
        $.widget(
            'mage.blogSignUp',
            {
                _create: function () {
                    var self = this;
                    var signup =self.options.signUp;
                    $("#email_address").parent().parent().parent().append($(signup));
                }
            }
        );
        return $.mage.blogSignUp;
    }
);

