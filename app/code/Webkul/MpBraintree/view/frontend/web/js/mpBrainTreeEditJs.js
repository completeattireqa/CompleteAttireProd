define(
    [
        'jquery',
        "mage/mage",
        "mage/calendar",
        'Magento_Ui/js/modal/modal'
    ],
    function ($) {
        $.widget('webkul.mpBraintreeEditJs', {
            _create: function () {

                $("#dateOfBirth").calendar({
                    showTime: false,
                    dateFormat: "yy-mm-dd"
                });
                var destValue = $("#destination").val();
                destinationUpdate(destValue);

                $('body').on('click', '#tosAccepted', function (e) {
                        
                    if ($(this).is(':checked')) {
                        $(this).val(1);
                    } else {
                        $(this).val(0);
                    }
                });
                
                $('body').on('change', '#destination', function () {
                    var dest = $(this).val();
                    destinationUpdate(dest);
                });

                function destinationUpdate(dest)
                {

                    switch (dest) {
                        case "bank":
                            $('body .depend-on-destination').hide();
                            $("body .depend-on-destination."+dest).show();
                        break;
                        case "mobile_phone" :
                            $('body .depend-on-destination').hide();
                            $("body .depend-on-destination."+dest).show();
                        break;
                        case "email" :
                            $('body .depend-on-destination.depend-on-destination').hide();
                            $("."+dest).show();
                    }
                }

                $("#isBusinessAccount").on("change", function () {
                    if ($(this).is(":checked")) {
                        $(this).val(1);
                        $(".isBusinessAccountFieldset").show();
                    } else {
                        $(this).val(0);
                        $(".isBusinessAccountFieldset").hide();
                    }
                });



                // $("body").on("change", "#locality", function() {
                //     self.fetchRegionList($(this).val());
                // });
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

        return $.webkul.mpBraintreeEditJs;
    }
);