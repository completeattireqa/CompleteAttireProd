/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_ChatGPT
 * @author    Webkul Software Private Limited
 * @copyright Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
/*jshint jquery:true*/
define([
    'jquery',
    'mage/translate',
    'Magento_Ui/js/modal/alert'
], function ($,$t,alert) {
    'use strict';
    var skipCount,total, success;
    $.widget('amzmageconnect.productProfiler', {
        _create: function () {
            var self = this;
            skipCount = 0;
            success = 0;
            var storeId = $('#wk_current_store_id').val();
            var promptTarget = $('#prompt_target').val();
            var contentType = $('#content_type').val();
            var total = self.options.productCount;
            var productIds = self.options.productIds;
            var errors = [];
            if (total > 0) {
                importProduct(1,productIds);
            }
            function importProduct(count,productIds)
            {
                count = count;
                $.ajax({
                    type: 'post',
                    url:self.options.importUrl,
                    async: true,
                    dataType: 'json',
                    data : { count:count,
                    'productId' :productIds[count-1],
                    storeId,
                    promptTarget,
                    contentType,
                    form_key: window.FORM_KEY },
                    success:function (data) {
                        if (data['error'] == 1) {
                            errors.push(data['msg']);
                            if(data['skip']){
                                skipCount++;
                            }
                        } else {
                            success++;
                        }
                        var width = (100/total)*count;
                        $(self.options.progressBarSelector).animate({width: width+"%"},'slow', function () {
                            if (count == total) {
                                // finishImporting(count, skipCount);
                                errors = errors.filter((item, i, ar) => ar.indexOf(item) === i);
                                if(errors.length > 0){
                                    if(!skipCount){
                                        $('.wk-mu-success.wk-mu-box').text($t('Content Importing Failed.'));
                                    } else if (skipCount && success){
                                        $('.wk-mu-success.wk-mu-box').text($t('Successfully imported content for %1 %2(s).'.replace('%1', count - skipCount).replace('%2', promptTarget)));
                                    } else {
                                        $('.wk-mu-success.wk-mu-box').text($t('Content Importing Failed.'));
                                    }
                                } else {
                                    $('.wk-mu-success.wk-mu-box').text($t('Successfully imported content for %1 %2(s).'.replace('%1', count - skipCount).replace('%2', promptTarget)));
                                }
                                for(var i = 0; i < errors.length; i++){
                                    $('.wk-mu-error-msg-container').append($('<div>')
                                                        .addClass('message message-error error')
                                                        .text(errors[i]));
                                }
                                $('.wk-mu-note').text($t("Finished Execution."));
                                $('.wk-mu-go-back-on-completion').removeClass('wk-display-none');
                                $(self.options.infoBarSelector).text($t("Completed"));
                            } else {
                                count++;
                                $(self.options.currentSelector).text(count);
                                importProduct(count,productIds);
                            }
                        });
                    }
                });
            }
            function finishImporting(count, skipCount)
            {
                $.ajax({
                    type: 'post',
                    url:self.options.importUrl,
                    async: true,
                    dataType: 'json',
                    data : {count:count,skip:skipCount },
                    success:function (data) {
                        $(self.options.fieldsetSelector).append(data['msg']);
                    }
                });
            }
        }
    });
    return $.mage.productProfiler;
});
