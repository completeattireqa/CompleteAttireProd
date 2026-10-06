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
            'mage.contentValidate',
            {
                _create: function () {
                    var self = this;
                    var descriptionId =self.options.descriptionId;
                    var saveButton =self.options.saveButton;
                    $(".button").click(function (e) {
                        var validate = validateEntries();
                        if (validate) {
                            e.preventDefault();
                            $(descriptionId).empty()
                            $('#description-error').remove();
                            var desc = $('#description_ifr').contents().find('#tinymce').text();
                            if (desc === "" || desc === null) {
                                $(descriptionId).parent().append('<div class="mage-error" generated="true" id="description-error">This is a required field.</div>');
                                console.log($(".mage-error").attr("style"));
                            } else {
                                $('.button').css('opacity','0.7');
                                $('.button').css('cursor','default');
                                $('.button').attr('disabled','disabled');
                                $('#custom-form').submit();
                            }
                        }
                    });
                    
                    $('.input-text').change(function () {
                        var validt = $(this).val();
                        var regex = /(<([^>]+)>)/ig;
                        var mainvald = validt .replace(regex, "");
                        $(this).val(mainvald);
                    });
        
                    function validateEntries()
                    {
                        var flag = 1;
                        if ($("#subject").val() == null || $("#subject").val() == "") {
                            flag = 0;
                        }
                        if ($("#metakeywords").val() == null || $("#metakeywords").val() == "") {
                            flag = 0;
                        }
                        if ($("#metadescription").val() == null || $("#metadescription").val() == "") {
                            flag = 0;
                        }
                        if ($("#tag").val() == null || $("#tag").val() == "") {
                            flag = 0;
                        }
                        return flag;
                    }
               }

            }
        );
        return $.mage.contentValidate;
    }
);

