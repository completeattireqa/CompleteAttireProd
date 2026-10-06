/**
 * Webkul Software
 *
 * @category  Webkul
 * @package   Webkul_Blog
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

/*jshint jquery:true*/
require(
    [
        'jquery',
        'Magento_Ui/js/modal/modal'
    ],
    function (
        $,
        modal
    ) {
        var options = {
            type: 'popup',
            responsive: true,
            innerScroll: true,
            title: 'Email',
            buttons: [{
                text: $.mage.__('Continue'),
                class: '',
                click: function () {
                    var email = $("#email").val();
                    if (email == '') {
                        $("#emailErr").html('Please enter your email id');
                        $("#emailErr").attr('style','color:red;');
                        return false;
                    }
                    var emailCheck = validateEmail(email);
                    if (!emailCheck) {
                        $("#emailErr").html('Please enter valid email id');
                        return false;
                    }
                   $("#customer_email").val(email);
                    $('form#commentSave').submit();
                    this.closeModal();
                }
            }]
        };
        $(document).ready(function () {
        var popup = modal(options, $('#popup-modal'));
        $('body').on('click', '#click-me', function () {
            var name = $("#fullName").val();
            var comment = $("#comment").val();
            var website = $("#website").val();
            var error = 0;
            if (name == '') {
                $("#fullnameErr").html('Please enter fullName');
                error = 1;
            }
            if (comment == '') {
                $("#commentErr").html('Please add comment');
                error = 1;
            }
            if (website) {
                if (isUrlValid(website) == false) {
                    $("#websiteErr").html('Please enter valid website url');
                    error = 1;
                }
            }

            if (error == 0) {
                $("#popup-modal").modal("openModal");
            }
        });
    });
    $('body').on('change', '.comment', function () {
        var validt = $(this).val();
        var regex = /(<([^>]+)>)/ig;
        var mainvald = validt .replace(regex, "");
        $(this).val(mainvald);
    });
    function validateEmail(sEmail)
    {
        var filter = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        //var filter = /^[w-.+]+@[a-zA-Z0-9.-]+.[a-zA-z0-9]{2,4}$/;
        if (filter.test(sEmail)) {
        return true;
        } else {
        return false;
        }

    }

    }
);