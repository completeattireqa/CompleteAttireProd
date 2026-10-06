/**
 * Webkul Software
 *
 * @category  Webkul
 * @package   Webkul_MpGroupedProduct
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
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
            'mage.groupedProductAdd',
            {
                _create: function () {
                    var self = this;
                    var stockId = self.options.stockId;
                    var buttonId = self.options.buttonId;
                    var productIds = self.options.productIds;
                    var productType = self.options.productType;
                    if (productType == 'grouped') {
                        $(stockId).attr("disabled",true).removeClass("required-entry");
                        $(stockId).parent().parent().hide();
                        $("#price").attr("disabled",true).removeClass("required-entry");
                        $("#price").parent().parent().hide();
                        $("#special-price").attr("disabled",true).removeClass("required-entry");
                        $("#special-price").parent().parent().hide();
                        $("#special-from-date").attr("disabled",true).removeClass("required-entry");
                        $("#special-from-date").parent().parent().hide();
                        $("#special-to-date").attr("disabled",true).removeClass("required-entry");
                        $("#special-to-date").parent().parent().hide();
                        $("input[name='product[weight]']").val(0).closest(".field").hide();
                        $("#tax-class-id").attr("disabled",true).removeClass("required-entry");
                        $("#tax-class-id").parent().parent().hide();
                        $('#mp_product_cart_limit').closest(".field").remove();
                    }
                    $("#tax-class-id").attr("disabled",true);
                    $('.wk-add-grouped-button').on(
                        'click',
                        function () {
                            if (productIds.length) {
                                productIds.each(
                                    function (value) {
                                        if ($('#wk_mpgrouped_products').find('#row-'+value).is(":visible")) {
                                            $('#idscheck'+value).closest('tr').hide();
                                        }
                                    }
                                );
                            }
                        }
                    );
                }
            }
        );
        return $.mage.groupedProductAdd;
    }
);
