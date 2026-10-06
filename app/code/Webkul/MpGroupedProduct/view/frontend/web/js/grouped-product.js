define([
    'jquery',
    'mage/template',
    'jquery/ui',
    'Magento_Ui/js/modal/modal',
    'mage/translate',
    'mage/adminhtml/grid'
], function ($, mageTemplate) {
    'use strict';

    $.widget('mage.groupedProduct', {
        /**
         * Create widget
         * @private
         */
        _create: function () {
            this.$grid = this.element.find('[data-role=grouped-product-grid]');
            this.$grid.sortable({
                distance: 8,
                items: '[data-role=row]',
                tolerance: 'pointer',
                cancel: ':input',
                update: $.proxy(function () {
                    this.element.trigger('resort');
                }, this)
            });

            this.productTmpl = mageTemplate('#group-product-template');

            $.each(
                this.$grid.data('products'),
                $.proxy(function (index, product) {
                    this._add(null, product);
                }, this)
            );

            this._on({
                'add': '_add',
                'resort': '_resort',
                'click [data-column=actions] [data-role=delete]': '_remove'
            });

            this._bindDialog();
            this._updateGridVisibility();
        },

        /**
         * Add product to grouped grid
         * @param {EventObject} event
         * @param {Object} product
         * @private
         */
        _add: function (event, product) {
            var tmpl,
            productExists;
            tmpl = this.productTmpl({
                data: product
            });

            $(tmpl).appendTo(this.$grid.find('tbody'));
        },

        /**
         * Remove product
         * @param {EventObject} event
         * @private
         */
        _remove: function (event) {
            $(event.target).closest('[data-role=row]').remove();
            this.element.trigger('resort');
            this._updateGridVisibility();
            var idd = $(event.target).closest('[data-role=row]').find('button').attr('id');
            var ids = idd.split('-');
            var id = ids[ids.length-1];
            var firstEnd = "td.mageproduct_id div:contains(";
            var lastEnd = ")";
            $(firstEnd+id+lastEnd).closest('tr').show().addClass("deleted");
        },

        /**
         * Resort products
         * @private
         */
        _resort: function () {
            this.element.find('[data-role=position]').each($.proxy(function (index, element) {
                $(element).val(index + 1);
            }, this));
        },

        /**
         * Create modal for show product
         * @private
         */
        _bindDialog: function () {
            var condChk;
            var widget = this,
                selectedProductList = {},
                popup = $('[data-role=add-product-dialog]');

            popup.modal({
                type: 'slide',
                innerScroll: true,
                title: $.mage.__('Add Products to Group'),
                modalClass: 'grouped',
                open: function () {
                    $(this).addClass('admin__scope-old'); // ToDo UI: remove with old styles removal
                },
                buttons: [{
                    id: 'grouped-product-dialog-apply-button',
                    text: $.mage.__('Add Selected Products'),
                    'class': 'action-primary action-add',
                    click: function () {console.log(selectedProductList)
                        if ('on' in selectedProductList || condChk == true) {
                            selectedProductList = widget._selectAll();;
                        }
                        $.each(selectedProductList, function (index, product) {
                            widget._add(null, product);
                            $('#idscheck'+index).closest('tr').hide();
                        });
                        widget._resort();
                        widget._updateGridVisibility();
                        jQuery("ul.action-menu li span.action-menu-item:nth-child(1)").click();
                        popup.modal('closeModal');
                    }
                }]
            });
            popup.on("click",".action-menu-item", $.proxy(function (event) { 
                if($(this).text() == 'Select All') {
                    condChk = true;
                } else {
                    condChk=false;
                }
            }));
            popup.on('click', '[data-role=row]', function (event) {
                var target = $(event.target);
                if (!target.is('input')) {
                    target.closest('[data-role=row]')
                        .find('[data-column=entity_ids] input')
                        .prop('checked', function (element, value) {
                            return !value;
                        })
                        .trigger('change');
                }
            });
           
            popup.on('change',".admin__control-checkbox",$.proxy(function (event) {
                var element = $(event.target),
                    product = {};
                if (element.is(':checked')) {
                    var tr = element.closest('tr');
                    product.id = element.val();
                    product.qty = 0;
                    product.name = $.trim(tr.find('.col-name .data-grid-cell-content').html());
                    product.sku = $.trim(tr.find('.col-sku .data-grid-cell-content').html());
                    product.price = $.trim(tr.find('.col-price .data-grid-cell-content').html());
                    element.closest('[data-role=row]').find('[data-column]').each(function (index, element) {
                        product[$(element).data('column')] = $.trim($(element).text());
                    });
                    selectedProductList[product.id] = product;
                } else {
                    delete selectedProductList[element.val()];
                }
                console.log(selectedProductList);
            }, this)
            );

            var gridPopup = $(this.options.gridPopup).data('gridObject');

            $('[data-role=add-product]').on('click', function (event) {
                event.preventDefault();
                popup.modal('openModal');
                selectedProductList = {};
            });
            $('#grouped_grid_popup').on('gridajaxsettings', function (event, ajaxSettings) {
                var ids = widget.$grid.find('[data-role=id]').map(function (index, element) {
                    return $(element).val();
                }).toArray();
                ajaxSettings.data.filter = $.extend(ajaxSettings.data.filter || {}, {
                    'entity_ids': ids
                });
            })
        },

        /**
         * create selected productList in case of select all
         */
        _selectAll: function (){
            var selectedProductList={};
            jQuery(".admin__data-grid-wrap tbody tr").each(function(){
                var product = {};
                var tr = jQuery(this);
                if($(tr).is(':visible')) {
                    var element = this.closest('input[type="ckeckbox"]');
                    product.id = $.trim(tr.find('.mageproduct_id .data-grid-cell-content').html());
                    product.qty = 0;
                    product.name = $.trim(tr.find('.col-name .data-grid-cell-content').html());
                    product.sku = $.trim(tr.find('.col-sku .data-grid-cell-content').html());
                    product.price = $.trim(tr.find('.col-price .data-grid-cell-content').html());
                    selectedProductList[product.id] = product;
                }
            });
            return selectedProductList;
        },

        /**
         * Show or hide message
         * @private
         */
        _updateGridVisibility: function () {
            var showGrid = this.element.find('[data-role=id]').length > 0;
            this.element.find('.grid-container').toggle(showGrid);
            this.element.find('.no-products-message').toggle(!showGrid);
        }
    });
    return $.mage.groupedProduct;
});
