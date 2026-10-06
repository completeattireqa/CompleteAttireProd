define(
    [
        'jquery',
        "mage/mage",
        "mage/calendar",
        'Magento_Ui/js/modal/modal'
    ],
    function ($) {
        $.widget('webkul.mpBraintreeJs', {
            _create: function () {
                var self = this;
                $("body .wantpartner").on('click', function () {
                    //console.log($('[name="mpbraintree[individual][dateOfBirth]"]'));
                    $('[name="mpbraintree[individual][dateOfBirth]"]').calendar({});
                });
                

                $('body').on('click', '#tosAccepted', function () {
                    e.preventDefault();
                    modal({message: "Please accept terms and conditions"});
                });

                $('body').on('click', '[name="mpbraintree[tosAccepted]"]', function (e) {
                    
                    if ($(this).is(':checked')) {
                        $(this).val(true);
                    } else {
                        $(this).val(false);
                    }
                });

                $('body').on('change', '[name="mpbraintree[funding][destination]"]', function () {
                    var dest = $(this).val();
                    switch (dest) {
                        case "bank":
                            $('.depend-on-destination').hide();
                            $("."+dest).show();
                        break;
                        case "mobile_phone" :
                            $('.depend-on-destination').hide();
                            $("."+dest).show();
                        break;
                        case "email" :
                            $('.depend-on-destination').hide();
                            $("."+dest).show();
                    }
                });

                $("body").on("change", "#locality", function () {
                    self.fetchRegionList($(this).val());
                });
            },

             /**
              * function to get the states of the country
              */
            fetchRegionList: function ($countryId) {
                var self = this;
                ajaxUrl = self.options.braintree.regionListAjaxUrl;
                $.ajax({
                    url: ajaxUrl,
                    method: "post",
                    showLoader: true,
                    data: {
                        country_code: $countryId
                    },
                    dataType: "json",
                    success: function (response) {
                        if (response.length > 0) {
                            $('#braintreeregion').attr('disabled',false).show();
                            $('#braintreeregionText').attr('disabled',true).hide();
             
                            var html = '';
                            $.each(response, function ($key, $value) {
                                html+='<option value="'+$value['value']+'">'+$value['label']+'</option>';
                            });
                            $("#braintreeregion").html(html);
                        } else {
                            $('#braintreeregion').attr('disabled',true).hide();
                            $('#braintreeregionText').attr('disabled',false).show();
                        }
                    },
                    error: function () {
                        console.error("some error occured");
                    }
                });
            }
        });

        return $.webkul.mpBraintreeJs;
    }
);