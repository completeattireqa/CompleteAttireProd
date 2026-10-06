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
    "jquery",
    'Magento_Ui/js/modal/alert',
    "mage/translate",
    "mage/mage",
    "prototype"
], function ($,alert,$t) {
    'use strict';
    var storeLocale = $('#store_locale').val();
    var storeId = $('#store_id').val();
    var promptTarget = $('#prompt_target').val();
    var routeName = $('#route_name').val();

    $('#wk_chatgpt_category_seo_import').on('click',()=>{
        var categoryName ='';
        categoryName  = categoryName !=''?categoryName  :$("[name='name']").val();
        if(!categoryName  || categoryName ==''){
            alert({
                        title: 'Note',
                        content: 'Please fill category name',
                        actions: {
                            always: function(){}
                        }
                    });
            return false;
        }
        $('body').trigger('processStart');
        var base = BASE_URL;
        var routeName = $('#route_name').val();
        var base = base.split(routeName);
        var path = base[0]+'chatgpt/chatgpt/individual';
        $.ajax({
            type:'POST',
            url: path,
            dataType: 'json',
            data:{
                name:categoryName,
                type:'seo',
                promptTarget,
                storeLocale,
                storeId,
                form_key: window.FORM_KEY,
            },
            success:(data)=>{
                if(data.error) {
                    alert({
                        title: 'Error',
                        content: data.error.message,
                        actions: {
                            always: function(){
                                return false;
                            }
                        }
                    });
                    $('body').trigger('processStop');
                    return false;
                }
                if(data.result.MetaTitle){
                    $('input[name="meta_title"]').val(data.result.MetaTitle);
                }
                if(data.result.MetaKeyWords){
                    $('[name="meta_keywords"]').val(data.result.MetaKeyWords);
                }
                if(data.result.MetaKeyword){
                    $('[name="meta_keywords"]').val(data.result.MetaKeyword);
                }
                if(data.result.MetaDescription){
                    $('[name="meta_description"]').val(data.result.MetaDescription);
                }
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
    })
});
