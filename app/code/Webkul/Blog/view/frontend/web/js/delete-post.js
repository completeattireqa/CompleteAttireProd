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
            'mage.deletePost',
            {
                _create: function () {
                    var self = this;
                    var deletePostClass =self.options.delete;
                    $(deletePostClass).click(
                        function () {
                            var decision=confirm($t(" Are you sure you want to delete this Post ? "));
                            if (decision === true) {
                                var $url=$(this).attr('data-url');
                                window.location = $url;
                            }
                        }
                    );
                }
            }
        );
        return $.mage.deletePost;
    }
);

