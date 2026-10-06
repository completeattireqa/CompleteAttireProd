/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_ChatGPT
 * @author    Webkul Software Private Limited
 * @copyright Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

define([
  'jquery',
  'Magento_Ui/js/modal/alert',
  "mage/translate",
  'jquery/ui',
  'mage/validation',
  "mage/mage",
  "prototype"
],function($, alert) {
  'use strict';
  return function (config) {
  $('#section-inputs').text('');
  const categorySelect = $('#select-category');
  const subCategorySelect = $('#select-subcategory');
  const templateSelect = $('#select-template');
  const languageSelect = $('#select-language');
  const countrySelect = $('#select-country');
  const voiceToneSelect = $('#select-tone-of-voice');
  const writingStyleSelect = $('#select-writing-style');
  const saveTemplate = $('#save-template');
  const $sectionGlobal = $('#section-global');
  const $sectionInputs = $('#section-inputs');
  const promptTextarea = $('#promptTextarea');
  const executeTemplateButton = $('#executeTemplate');
  
  const globalVars = {};
  let selectedTemplateData;
  let settings;
  let templateVars = {};
  const ICON_HELP_SVG = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-help-circle"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>';

  const initUI = () => {
      $('.btn-close').click(function(e){
        post('widget.close');
      });
      $sectionGlobal.on('change', 'select', function(e){
          prepareTemplateString();
          $('.mage-error').remove();
          this.removeAttribute('pristine');
          const name = this.dataset.name;
      });
      
      $sectionInputs.on('keyup', 'input, textarea', function(e){
          prepareTemplateString();
          this.removeAttribute('pristine');
      });
  
      $sectionInputs.on('change', 'input, select', function(e){
          prepareTemplateString();
          this.removeAttribute('pristine');
      });
      categorySelect.change(function(){
          reset();
          subCategorySelect.prop('disabled',true);
          subCategorySelect.innerHTML = '<option value="">Select a sub-category</option>';
          templateSelect.innerHTML = '<option value="">Select a template</option>';
          subCategorySelect.prop('disabled',true);
          templateSelect.prop('disabled',true);
          executeTemplateButton.prop('disabled',true);

          const selectedCategory = categorySelect.val();
          if (selectedCategory !== 'Choose a category' && selectedCategory!=="") {
              categorySelect.parent('div').append($('#loader-image'));
              categorySelect.parent('div').find($('#loader-image')).removeClass('hidden');
              var base = BASE_URL;
              var base = base.split('chatgpt');
              var path = base[0]+'chatgpt/prompttemplates/getcategories';
              $.ajax({
                  type: "POST",
                  url: path,
                  data: {
                      form_key: window.FORM_KEY
                  },
                  success: function(data){
                      if(!data.error){
                          subCategorySelect.find('option:not(:first)').remove();
                          templateSelect.find('option:not(:first)').remove();
                          const subcategories = data[selectedCategory].subcategories;
                          for (const subcategory in subcategories) {
                              const option = document.createElement('option');
                              option.value = subcategory;
                              option.textContent = subcategories[subcategory];
                              subCategorySelect.append(option);
                          }
                          subCategorySelect.prop('disabled',false);
                          categorySelect.parent('div').find($('#loader-image')).addClass('hidden');
                      }
                      else{
                        categorySelect.parent('div').find($('#loader-image')).addClass('hidden');
                          alert({
                              title: 'Error',
                              content: data.message,
                              actions: {
                                  always: function(){}
                              }
                          });
                      }
                  },
                  error: function(data){
                      subCategorySelect.find('option:not(:first)').remove();
                      templateSelect.find('option:not(:first)').remove();
                  }
              });
          }
      });
      subCategorySelect.change(function(){
          reset();
          templateSelect.innerHTML = '<option value="">Select a template</option>';
          templateSelect.prop('disabled',true);
          executeTemplateButton.prop('disabled',true);

          const selectedSubCategory = subCategorySelect.val();
          if (selectedSubCategory) {
              subCategorySelect.parent('div').append($('#loader-image'));
              subCategorySelect.parent('div').find($('#loader-image')).removeClass('hidden');
              var base = BASE_URL;
              var base = base.split('chatgpt');
              var path = base[0]+'chatgpt/prompttemplates/gettemplates';
              $.ajax({
                  type: "POST",
                  url: path,
                  data: {
                      subcat: selectedSubCategory,
                      form_key: window.FORM_KEY
                  },
                  success: function(templates){
                      if(!templates.error){
                          templateSelect.find('option:not(:first)').remove();
                          for (const template in templates) {
                              const option = document.createElement('option');
                              option.value = template;
                              option.textContent = templates[template].name;
                              if(config.templates == templates[template].name){
                                option.selected = 'selected';
                              }
                              templateSelect.append(option);
                          }
                          templateSelect.change();
                          templateSelect.prop('disabled',false);
                          subCategorySelect.parent('div').find($('#loader-image')).addClass('hidden');
                      }
                      else{
                        subCategorySelect.parent('div').find($('#loader-image')).addClass('hidden');
                          alert({
                              title: 'Error',
                              content: data.message,
                              actions: {
                                  always: function(){}
                              }
                          });
                      }
                  },
                  error: function(data){
                      templateSelect.find('option:not(:first)').remove();
                  }
                  });
          }
      });

      templateSelect.change(function(){
          executeTemplateButton.prop('disabled',!templateSelect.value);
          chooseTemplate();
      });
  }
  initUI();
  function chooseTemplate() {
      reset();
      const selectedTemplate = templateSelect.val();
      var base = BASE_URL;
      var base = base.split('chatgpt');
      var path = base[0]+'chatgpt/prompttemplates/gettemplate';
      if (selectedTemplate) {
          templateSelect.parent('div').append($('#loader-image'));
          templateSelect.parent('div').find($('#loader-image')).removeClass('hidden');
          $.ajax({
              type: "POST",
              url: path,
              data: {
                  id: selectedTemplate,
                  form_key: window.FORM_KEY
              },
              success: function(data){
                  if(!data.error){
                      const response = data;
                      selectedTemplateData = response;
                      processTemplate(response);
                      templateSelect.parent('div').find($('#loader-image')).addClass('hidden');
                  }
                  else{
                      alert({
                          title: 'Error',
                          content: data.message,
                          actions: {
                              always: function(){}
                          }
                      });
                  }
              },
              error: function(data){
                  templateSelect.parent('div').find($('#loader-image')).addClass('hidden');
                  selectedTemplate.find('option:not(:first)').remove();
                  templateSelect.find('option:not(:first)').remove();
              }
          });
      } else {
      promptTextarea.value = '';
      selectedTemplateData = null;
      }
    }
    const processTemplate = (data) => {
      var sectionGlobal = config.section_global;
      data.global_variables.map(item => {
        const key = 'select-' + item.name.replace(/_/g, '-');
        if(sectionGlobal){
          $("#"+key+" option:contains(" + sectionGlobal[key] + ")").prop("selected", true);
        }
        $(`#section-global > div[data-id=${key}]`).removeClass('hidden');
      });
      // data.input_grid = '"input_1 input_1 input_1 input_1 input_1 input_1 input_2 input_2 input_3 input_3 input_3 input_3" "input_4 input_4 input_4 input_4 input_4 input_4 input_4 input_4 input_4 input_4 input_4 input_4"';
      renderInputs(data.input_variables, data.input_grid);
      $('#section-description').text('Description: ' + data.description);
      $('#section-prompt').removeClass('hidden');
      $('#section-execute').removeClass('hidden');
      var templateString = prepareTemplateString();
      $('#promptTextarea').text(config.prompt ? config.prompt : templateString.prompt);
      $('#promptTextarea').val(config.prompt ? config.prompt : templateString.prompt);
      $('body').trigger('processStop');
    };
    const getGlobalInputs = async () => {
      try {
          var voiceTones = $('#select-tone-of-voice');
          var voiceTonesObj = {}; // Object to store key-value pairs
          $('option', voiceTones).each(function() {
            var value = $(this).val(); // Get the value attribute of the option
            var text = $(this).text(); // Get the text of the option
            voiceTonesObj[value] = text; // Add key-value pair to the object
          });
          var writingStyles = $('#select-writing-style');
          var writingStylesObj = {}; // Object to store key-value pairs
          $('option', writingStyles).each(function() {
            var value = $(this).val(); // Get the value attribute of the option
            var text = $(this).text(); // Get the text of the option
            writingStylesObj[value] = text; // Add key-value pair to the object
          });
        globalVars.voiceTones = voiceTonesObj;
        globalVars.writingStyles = writingStylesObj;
      } catch (err) {
        console.log(err);
      }
    };
    getGlobalInputs();
    const prepareTemplateString = (params) => {
      var sectionGlobal = config.section_global;
      if (!params) params = {};
      let subst = {};
      let hasEmptyFields = false;
      $sectionInputs.find('input').map((index, input) => {
        const val = input.value.trim().replace(/"/g, '');
        const name = input.dataset.name;
        subst[name] = val;
        if (val === '') hasEmptyFields = true;
      });
      $sectionInputs.find('textarea').map((index, input) => {
        const val = input.value.trim().replace(/"/g, '');
        const name = input.dataset.name;
        subst[name] = val;
        if (val === '') hasEmptyFields = true;
      });
      $sectionInputs.find('select').map((index, input) => {
        const val = input.value.trim().replace(/"/g, '');
        const name = input.dataset.name;
        subst[name] = val;
        if (val === '') hasEmptyFields = true;
      });
      $sectionGlobal.find('select').map((index, select) => {
        let val = select.value;
        const name = select.dataset.name;
        if (name === 'tone_of_voice') {
          if (val === 'default') val = '';
          else val = `You have a ${globalVars.voiceTones[val]} tone of voice.`;
        }
        if (name === 'writing_style') {
          if (val === 'default') val = '';
          else val = `You have a ${globalVars.writingStyles[val]} writing style.`;
        }
        subst[name] = val;
      });
      if (params.urlData) {
        for (let key in params.urlData) {
          subst[key] = params.urlData[key];
        }
      }
      if (!selectedTemplateData) return;
      let prompt = selectedTemplateData.prompt;
      for (const key in subst) {
        const re = new RegExp(`{${key}}`, 'g');
        prompt = prompt.replace(re, subst[key]);
      }
      if (!params.leavePrompt) promptTextarea.val(prompt);
      return {
        hasEmptyFields,
        prompt
      };
    };
    
    const renderInputs = (inputs, grid) => {
      var sectionInput = config.section_inputs;
      if (grid) {
        $sectionInputs.removeClass('row').addClass('grid');
        $sectionInputs[0].style.gridTemplateAreas = grid;
      }
      else {
        $sectionInputs.removeClass('grid').addClass('row');
      }
      inputs.map(input => {
        if (input.type === 'text') {
          const html = `
            <div class="flex-full-width" style='grid-area: ${input.name}'>
              <label>${input.label} <span class="help" title="${input.help_text}">${ICON_HELP_SVG}</span></label>
              <input type="text" class="admin__control-text" placeholder="${input.label}" data-name="${input.name}" value="${sectionInput && sectionInput[input.name] ? sectionInput[input.name].value : input.default_text ? input.default_text : '{{importContentFor}}'}">
            </div>`;
          $sectionInputs.append(html);
        }
        if (input.type === 'URL' || input.type === 'SERP' || input.type === 'YouTube_Video_URL') {
          var type = input.type.toLowerCase();
          const html = `
            <div class="flex-full-width" style='grid-area: ${input.name}' data-type="${type}">
              <label>${input.label} <span class="help" title="${input.help_text}">${ICON_HELP_SVG}</span></label>
              <input type="text" placeholder="${input.label}" data-name="${input.name}" value="${input.default_text || ''}">
            </div>
            <div style="grid-area: ${input.name}_button" class="button-item">
              <button data-type="${type}" data-target="${input.name}">Get Data</button>
              <img class="spinner hidden" src="/img/spinner32.gif" />
              <span class="input-clear hidden" data-target="${input.name}">clear</span>
            </div>`;
          $sectionInputs.append(html);
          executeTemplateButton.disabled = true;
        }
        else if (input.type === 'number') {
          const html = `
            <div class="flex-item" style='grid-area: ${input.name}'>
              <label>${input.label} <span class="help" title="${input.help_text}">${ICON_HELP_SVG}</span></label>
              <input type="number" class="admin__control-text" data-name="${input.name}" value="${sectionInput && sectionInput[input.name] ? sectionInput[input.name].value : input.default_text ? input.default_text : ''}">
            </div>`;
          $sectionInputs.append(html);
        }
        else if (input.type === 'dropdown') {
          let optionsHTML = '';
          let options = input.options.split(/\s*,\s*/).map(option => {
            optionsHTML += `<option value="${option}">${option}</option>`;
          });
          const html = `
            <div class="flex-item" style='grid-area: ${input.name}'>
            <label>${input.label} <span class="help" title="${input.help_text}">${ICON_HELP_SVG}</span></label>
            <select class="admin__control-select" data-name="${input.name}">${optionsHTML}</select>
            `;
          $sectionInputs.append(html);
        }
        else if (input.type === 'textarea') {
          const html = `
            <div class="flex-full-width" style='grid-area: ${input.name}'>
              <label>${input.label} <span class="help" title="${input.help_text}">${ICON_HELP_SVG}</span></label>
              <textarea class="textarea" data-name="${input.name}" rows="4">${sectionInput && sectionInput[input.name].value ? sectionInput[input.name].value : input.default_text ? input.default_text : '{{importContentFor}}'}</textarea>
            </div>`;
          $sectionInputs.append(html);
        }
      });
      $sectionInputs.find('.input-clear').click(function(e){
        const target = this.dataset.target;
        $(`[data-name="${target}"]`).val('')[0].disabled = false;
        for (var key in templateVars) {
          if (key.indexOf(target) === 0) delete templateVars[key];
        }
        prepareTemplateString({
          urlData: templateVars
        });
        this.classList.add('hidden');
      });
  
      $sectionInputs.find('button').click(function(e){
        e.preventDefault();
        const self = this;
        const type = this.dataset.type;
        const target = this.dataset.target;
        const $input = $(`[data-name="${target}"]`);
        let val = $input.val();
        if (!val) return;
        if (type === 'url') {
          if (!val.match(/https?:\/\/.*/)) {
            val = 'https://' + val;
          }
        }
        if (type === 'serp') {
          val = 'https://www.google.com/search?q=' + encodeURIComponent(val);
        }
        $input[0].disabled = true;
        self.disabled = true;
        const $spinner = $(this).parent().find('.spinner');
        $spinner.removeClass('hidden');
        chrome.runtime.sendMessage({
          cmd: 'ajax.getPageHTML',
          data: {
            url: val
          }
        }, async function(response){
          $spinner.addClass('hidden');
          self.disabled = false;
          if (response.error) {
            console.log(response);
            return;
          }
          $(self).parent().find('.input-clear').removeClass('hidden');
          executeTemplateButton.disabled = false;
          const pageData = await processPageHTML(type, response.data);
          prepareAdvancedVars(type, target, pageData);
          prepareTemplateString({
            urlData: templateVars
          });
        });
      });
    };

    const prepareAdvancedVars = (type, target, pageData) => {
      const vars = templateVars;
      if (type === 'url') {
        vars[target + '.title'] = pageData.title;
        vars[target + '.description'] = pageData.description;
        vars[target + '.content'] = pageData.cleanFullText;
        vars[target + '.total_words'] = pageData.wordsTotal;
        vars[target + '.headings'] = pageData.allHeaders;
        vars[target + '.headings_h1'] = pageData.headers[0].join('\n');
        vars[target + '.headings_h2'] = pageData.headers[1].join('\n');
        vars[target + '.headings_h3'] = pageData.headers[2].join('\n');
        vars[target + '.headings_h4'] = pageData.headers[3].join('\n');
        vars[target + '.headings_h5'] = pageData.headers[4].join('\n');
        vars[target + '.headings_h6'] = pageData.headers[5].join('\n');
      }
      else if (type === 'youtube_video_url') {
        vars[target + '.title'] = pageData.title;
        vars[target + '.description'] = pageData.description;
        vars[target + '.tags'] = pageData.tags;
        vars[target + '.transcript'] = pageData.transcript;
      }
      else if (type === 'serp') {
        let titles = [];
        let descriptions = [];
        pageData.results.map(function(item){
          titles.push(item.title);
          descriptions.push(item.description);
        });
        vars[target + '.titles'] = titles.join('\n');
        vars[target + '.descriptions'] = descriptions.join('\n');
        vars[target + '.related_keywords'] = pageData.relatedKeywords.join('\n');
        vars[target + '.pasf_keywords'] = pageData.pasfKeywords.join('\n');
      }
      return vars;
    };
  saveTemplate.click(function () {
    var isInValid = validationPromptTemplateForm();
    if(!isInValid){
      var sectionGlobalData = getSectionGlobalData();
      var sectionInputsData = getSectionInputsData();
      var formData = {
        entity_id: (config && config.entity_id) ?? config.entity_id,
        category: $('#select-category :selected').text(),
        sub_category: $('#select-subcategory :selected').text(),
        templates: $('#select-template :selected').text(),
        template_title: $('input[name="template_title"]').val(),
        section_global: sectionGlobalData,
        section_inputs: sectionInputsData,
        prompt: $('#promptTextarea').val()
      }
      var base = BASE_URL;
      var base = base.split('chatgpt');
      var path = base[0]+'chatgpt/prompttemplates/save';
      $.ajax({
        type: 'post',
        url: path,
        async: true,
        showLoader: true,
        dataType: 'json',
        showLoader: true,
        data : formData,
        success:(data)=>{
          if(data.error){
              var msg = data.msg;
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
          if(data.status){
            alert({
              title: 'Success',
              content: data.msg,
              actions: {
                  always: function(){}
              }
          });
          if(data.redirect){
            window.location = data.url;
          }
          }
        },
        error:(data)=>{
            $('body').trigger('processStop');
            alert({
                title: 'Error',
                content: data.msg,
                actions: {
                    always: function(){}
                }
            });
          }
      });
    }
  })
  const validationPromptTemplateForm = () => {
    $('.mage-error').remove();
    var promptTemplateForm = $('#save-chatgpt-prompt-template');
    var formElements = promptTemplateForm.find(':input');
    promptTemplateForm.mage('validation', {});
    var count = 0;
    formElements.each(function() {
      var element = $(this);
      if(element.attr('id') != 'save-template' && element.attr('id') != 'reset'){
        var elementValue = element.val();
        if(elementValue == null || elementValue == ''){
          count++;
          element.parent().append('<label id="'+element.attr('id')+'-error" class="mage-error" for="'+element.attr('id')+'">This is a required field.</label>');
          element[0].scrollIntoView();
        }
      }
    })
    return count;
  }

  const getSectionGlobalData = () => {
    var sectionGlobalData = [];
      $('#section-global').find('.field').each(function() {
        var element = $(this);
        if(!element.hasClass('hidden')){
          var id = element.data('id');
          sectionGlobalData[id] = $('#'+id+' :selected').text()
        }
      })
    return Object.assign({}, sectionGlobalData);
  }
  const getSectionInputsData = () => {
    var sectionInputsData = [];
      $('#section-inputs').find(':input').each(function() {
        var element = $(this);
        if(!element.hasClass('hidden')){
          var name = element.data('name');
          sectionInputsData[name] = {'label': element.parent('div').find('label').text(), 'value': element.val()}
        }
      })
    return Object.assign({}, sectionInputsData);
  }
  const reset = () => {
      $('.mage-error').remove();
      $('#section-description').text('Please browse through our categories and sub-categories above and select a prompt template that you\'d like to execute');
      $('#section-global > div[data-id]').addClass('hidden');
      $('#section-inputs').text('');
      $('#section-prompt').addClass('hidden');
      $('#section-execute').addClass('hidden');
      promptTextarea.value = '';
  };
  if(config.entity_id){
    $('body').trigger('processStart');
    subCategorySelect.change();
  }
  
  }
});

