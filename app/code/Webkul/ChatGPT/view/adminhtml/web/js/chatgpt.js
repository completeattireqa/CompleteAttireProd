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
    function handleMutation(mutationsList) {
        mutationsList.forEach(function (mutation) {
            if (mutation.type === 'childList') {
                var htmlCodeOption = $(mutation.addedNodes).find('#content-type-4');
                if (htmlCodeOption.length > 0) {
                    var htmlCode = $('#content-type-4');
                    $('#menu-section-chatgpt').find('.pagebuilder-panel-menu-sections-child ul').append(htmlCode);
                }
            }
        });
    }
    // Create a MutationObserver
    var observer = new MutationObserver(handleMutation);
    // Start observing the entire document for changes to its children
    observer.observe(document, { childList: true, subtree: true });

    var button = "Fill description with Chat GPT";
    $('#buttonsproduct_form_short_description').append(
        '<button id ="chatgpt_short" name="fetch" style="position:relative;" >'+(buttonTitle)+'</button>'
        )
    $('#buttonscategory_form_description').append(
        '<button id ="chatgpt_category_desc" name="fetch" style="position:relative;" >'+(buttonTitle)+'</button>'
        )
    $('#buttonscms_page_form_content').append(
        '<button id ="chatgpt_cms_desc" name="fetch" style="position:relative;" >'+(buttonTitle)+'</button>'
        )
        var storeLocale = $('#store_locale').val();
        var promptTarget = $('#prompt_target').val();
        var routeName = $('#route_name').val();
        var divCheckingInterval = setInterval(function(){
        if($("#buttonsproduct_form_description")){
            clearInterval(divCheckingInterval);
            $('#buttonsproduct_form_description').append(
            '<button id ="chatgpt_desc" name="fetch" style="position:relative;" >'+(buttonTitle)+
            '</button>'
            )
            $('#chatgpt_desc').on('click',()=>{
                if(tinymce.activeEditor != null){
                    var productName =  tinymce.activeEditor.getContent();
                    var div = document.createElement("div");
                    div.innerHTML = productName;
                    productName  = div.innerText;
                }
                else{
                    productName = $('#product_form_description').val();
                }
            if(productName.includes('\\')){
                productName = productName.substr(productName.indexOf('\\')+2);
            }
            else{
                productName='';
            }
            productName = productName !=''?productName :$("[name='product[name]']").val();
            if(!productName || productName==''){

                alert({
                            title: 'Note',
                            content: 'Please fill product name',
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
                    name:productName,
                    type:'long',
                    promptTarget,
                    storeLocale,
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
                    if(tinymce.EditorManager.get('product_form_description')!=null){
                        tinymce.EditorManager.get('product_form_description').setContent('');
                        tinymce.EditorManager.get('product_form_description').focus();
                        tinymce.EditorManager.get('product_form_description').nodeChanged();

                        tinymce.EditorManager.get('product_form_description').setContent(data.result);
                        tinymce.EditorManager.get('product_form_description').focus();
                        tinymce.EditorManager.get('product_form_description').nodeChanged();
                    }
                    else{
                        $('#product_form_description').val('');
                        $('#product_form_description').focus();
                        $('#product_form_description').val(data.result);
                        $('#product_form_description').focus();
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
        }
        }, 100);

        $('#chatgpt_short').on('click',()=>{
            let productName= $("[name='product[name]']").val();
            
            if(!productName || productName==''){
                alert({
                            title: 'Note',
                            content: 'Please fill product name',
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
                url:path,
                dataType: 'json',
                data:{
                    name:productName,
                    type:'short',
                    promptTarget,
                    storeLocale,
                    form_key: window.FORM_KEY,
                },
                success:(data)=>{
                    if(data.error){
                        var msg = data.error.message;
                        if(data.error.code == 'invalid_api_key'){
                            let errmsg = data.error.message.split(':');
                            msg = errmsg[0];
                        }
                        $('body').trigger('processStop');
                        alert({
                            title: 'Error',
                            content: msg,
                            actions: {
                                always: function(){
                                    return false;
                                }
                            }
                        });
                        return false;
                    }
                    if(tinymce.EditorManager.get('product_form_short_description')!=null){
                        tinymce.EditorManager.get('product_form_short_description').setContent('');
                        tinymce.EditorManager.get('product_form_short_description').focus();

                        tinymce.EditorManager.get('product_form_short_description').setContent(data.result);
                        tinymce.EditorManager.get('product_form_short_description').focus();

                        tinymce.EditorManager.get('product_form_short_description').nodeChanged();
                    }
                    else{
                        $('#product_form_short_description').val('');
                        $('#product_form_short_description').focus();
                        $('#product_form_short_description').val(data.result);
                        $('#product_form_short_description').focus();
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
        });

        $('#chatgpt_category_desc').on('click',()=>{
            if(tinymce.activeEditor != null){
                var categoryName =  tinymce.activeEditor.getContent();
                var div = document.createElement("div");
                div.innerHTML = categoryName;
                categoryName  = div.innerText;
            }
            else{
                categoryName = $('#category_form_description').val();
            }
            if(categoryName.includes('\\')){
                categoryName  = categoryName.substr(categoryName.indexOf('\\')+2);
            }
            else{
                categoryName ='';
            }
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
                    type:'desc',
                    promptTarget,
                    storeLocale,
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
                    if(tinymce.EditorManager.get('category_form_description')!=null){
                        tinymce.EditorManager.get('category_form_description').setContent('');
                        tinymce.EditorManager.get('category_form_description').focus();
                        tinymce.EditorManager.get('category_form_description').nodeChanged();

                        tinymce.EditorManager.get('category_form_description').setContent(data.result);
                        tinymce.EditorManager.get('category_form_description').focus();
                        tinymce.EditorManager.get('category_form_description').nodeChanged();
                    }
                    else{
                        $('#category_form_description').val('');
                        $('#category_form_description').focus();
                        $('#category_form_description').val(data.result);
                        $('#category_form_description').focus();
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

        $('#chatgpt_cms_desc').on('click',()=>{
            if(tinymce.activeEditor != null){
                var pageTitle =  tinymce.activeEditor.getContent();
                var div = document.createElement("div");
                div.innerHTML = pageTitle;
                pageTitle  = div.innerText;
            }
            else{
                pageTitle = $('#cms_page_form_content').val();
            }
            if(pageTitle.includes('\\')){
                pageTitle  = pageTitle.substr(pageTitle.indexOf('\\')+2);
            }
            else{
                pageTitle ='';
            }
            pageTitle  = pageTitle !=''?pageTitle  :$("input[name='title']").val();
            if(!pageTitle  || pageTitle ==''){
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
                    name:pageTitle,
                    type:'long',
                    promptTarget,
                    storeLocale,
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
                    if(tinymce.EditorManager.get('cms_page_form_content')!=null){
                        tinymce.EditorManager.get('cms_page_form_content').setContent('');
                        tinymce.EditorManager.get('cms_page_form_content').focus();
                        tinymce.EditorManager.get('cms_page_form_content').nodeChanged();

                        tinymce.EditorManager.get('cms_page_form_content').setContent(data.result);
                        tinymce.EditorManager.get('cms_page_form_content').focus();
                        tinymce.EditorManager.get('cms_page_form_content').nodeChanged();
                    }
                    else{
                        $('#cms_page_form_content').val('');
                        $('#cms_page_form_content').focus();
                        $('#cms_page_form_content').val(data.result);
                        $('#cms_page_form_content').focus();
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
