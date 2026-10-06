/**
 * Webkul Software test
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
            'mage.menuForPermitted',
            {
                _create: function () {
                    var self = this;
                    var menu =self.options.menu;
                    var wknewblog = self.options.wknewblog;
                    jQuery(menu).hover(
                        function () {
                            jQuery(wknewblog).css('display','block');
                        }
                    );
                    jQuery(menu).mouseleave(
                        function () {
                             jQuery(wknewblog).css('display','none');
                        }
                    );
                    jQuery(wknewblog).hover(
                        function () {
                            jQuery(this).show();
                        }
                    );
                    jQuery(wknewblog).mouseleave(
                        function () {
                            jQuery(this).hide();
                        }
                    );
                }
            }
        );
        return $.mage.menuForPermitted;
    }
);

