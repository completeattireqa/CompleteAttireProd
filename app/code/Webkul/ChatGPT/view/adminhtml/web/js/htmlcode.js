/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/* global MediabrowserUtility, widgetTools, MagentovariablePlugin */
define([
    'jquery',
    'Magento_Ui/js/form/element/textarea',
    'Magento_Ui/js/modal/alert',
    'mage/url',
    'mage/adminhtml/wysiwyg/widget'
], function ($,Textarea,alert,urlBuilder) {
    'use strict';

    var HTML_ID_PLACEHOLDER = 'HTML_ID_PLACEHOLDER';

    return Textarea.extend({
        defaults: {
            elementTmpl: 'Webkul_ChatGPT/html-code'
        },

        /**
         * Click event for Insert Widget Button
         */
        clickInsertWidget: function () {
            return widgetTools.openDialog(
                this.widgetUrl.replace(HTML_ID_PLACEHOLDER, this.uid)
            );
        },

        /**
         * Click event for Insert Image Button
         */
        clickInsertImage: function () {
            return MediabrowserUtility.openDialog(
                this.imageUrl.replace(HTML_ID_PLACEHOLDER, this.uid)
            );
        },

        /**
         * Click event for Insert Variable Button
         */
        clickInsertVariable: function () {
            return MagentovariablePlugin.loadChooser(
                this.variableUrl,
                this.uid
            );
        },

        getChatGptContent: function(){
            var elem = $('.admin__control-textarea');
            var base = BASE_URL;
            var routeName = $('#route_name').val();
            if(routeName == "adminhtml"){
                var module = 'admin';
                base = base.replace(new RegExp(`(.*?${module}.*?)${module}`), `$1${routeName}`);
            }
            var base = base.split(routeName);
            var path = base[0]+'chatgpt/chatgpt/individual';
            let importContentFor = elem.val();
            var div = document.createElement("div");
            var storeLocale = $('#store_locale').val();
            var storeId = $('#store_id').val();
            var promptTarget = $('#prompt_target').val();
            var routeName = $('#route_name').val();
            div.innerHTML = importContentFor;
            importContentFor = div.innerText;
            if(promptTarget == 'page'){
                storeId = $("select[name='store_id'] option:selected:first").val();
            }
            if(!storeId){
                storeId = $('#store_id').val();
            }
            if(importContentFor.includes('\\')){
                importContentFor = importContentFor.substr(importContentFor.indexOf('\\')+2);
            }
            else{
                importContentFor='';
            }
            importContentFor = importContentFor !=''?importContentFor : this.getImportContentFor(promptTarget);
            if(!importContentFor || importContentFor==''){

                alert({
                            title: 'Note',
                            content: 'Please write your query to get content',
                            actions: {
                                always: function(){}
                            }
                        });
                return false;
            }
            $('body').trigger('processStart');
            $.ajax({
                type:'POST',
                url:path,
                dataType: 'json',
                data:{
                    name:importContentFor,
                    promptTarget,
                    type:'short',
                    storeLocale,
                    storeId,
                    form_key: window.FORM_KEY
                },
                success:(data)=>{
                    if(data.error) {
                        var msg = data.error.message;
                        if(data.error.code == 'invalid_api_key'){
                            let errmsg = data.error.message.split(':');
                            msg = errmsg[0];
                        }
                        alert({
                            title: 'Error',
                            content: msg,
                            actions: {
                                always: function(){
                                    return false;
                                }
                            }
                        });
                    }
                    $('textarea[name="html"]').val(data.result);
                    $('textarea[name="html"]').change();
                    $('body').trigger('processStop');
                },
                error:(data)=>{
                    $('body').trigger('processStop');
                    alert({
                        title: 'Error',
                        content: 'Something went wrong in chatGPT',
                        actions: {
                            always: function(){}
                        }
                    });
                }

            });
           

        },
        gptActive: function() {
            let active = false;
            var base = BASE_URL;
            var routeName = $('#route_name').val();
            if(routeName == "adminhtml"){
                var module = 'admin';
                base = base.replace(new RegExp(`(.*?${module}.*?)${module}`), `$1${routeName}`);
            }
            var base = base.split(routeName);
            var path = base[0]+'chatgpt/chatgpt/config';
            var promptTarget = $('#prompt_target').val();
            var storeId = $('#store_id').val();
            if(promptTarget == 'page'){
                storeId = $("select[name='store_id'] option:selected:first").val();
            }
            if(!storeId){
                storeId = $('#store_id').val();
            }
            $.ajax({
                type:'POST',
                url:path,
                async:false,
                dataType: 'json',
                data:{
                    storeId,
                    form_key: window.FORM_KEY
                },
                success:(data)=>{
                   active = parseInt(data);
                },
                error:(data)=>{
                    $('body').trigger('processStop');
                    alert({
                        title: 'Error',
                        content: 'Something went wrong in chatGPT',
                        actions: {
                            always: function(){}
                        }
                    });
                }

            });

            return active;
        },
        getImportContentFor: function(promptTarget){
            var returnValue = '';
            switch (promptTarget) {
                case 'product':
                    returnValue = $("[name='product[name]']").val();
                    break;
                case 'category':
                    returnValue = $("[name='name']").val();
                    break;
                case 'page':
                case 'cms_page':
                    returnValue = $("input[name='title']").val();
                    break;
                default:
                    returnValue= '';
                    break;
            }
            return returnValue;
        }
    });
});
