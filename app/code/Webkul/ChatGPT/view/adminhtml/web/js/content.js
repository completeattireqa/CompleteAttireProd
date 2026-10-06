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
    var skipCount,total;
    $.widget('mage.fetchContent', {
        _create: function () {
          alert('hi i am here');
        }
    });
    return $.mage.fetchcontent;
});
