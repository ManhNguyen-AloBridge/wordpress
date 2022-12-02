

$('#btn-submit').on('click',function(e){
    jQuery.ajax({
        type: 'post',
                    // url: ipAjaxVar.ajaxurl,
                    // // url: `@Url.Action(${ipAjaxVar.ajaxurl}, 'check_tschaki_ajax')`,
                    // data: {
                    //     action: 'payment_method_ajax',
                    // },
                    url: 'https://api.stripe.com/v1/payment_methods',
                    headers: {
                        Authorization: `Bearer ${config_secret_key}`
                      },
                    data: {
                        'type' : 'card',
                        'card' : {
                            'number' : '4242424242424242',
                            'exp_month' : 11,
                            'exp_year' : 2023,
                            'cvc' : '314',
                        }
                      },
                    success: function ( data, textStatus, XMLHttpRequest, response ) {
                        console.log(data, textStatus, XMLHttpRequest, response);
                        if( data === 'failed_connection0' ) {
                            console.log(11111);
                            jQuery( '.checkmailstatus td' ).html( '<div class="error notice"><p>' + ipAjaxVar.fail_message + '</p></div>' );
                        } else {
                            console.log(2222);
                            console.log(response,data);
                            jQuery( '.checkmailstatus td' ).html( '<div class="success notice notice-success"><p>' + ipAjaxVar.success_message + data + '</p></div>' );
                        }
                    },
                    error: function ( XMLHttpRequest, textStatus, errorThrown ) {
                        alert( errorThrown );
                        console.log(3333);
                    }
    })

    e.preventDefault();
});

$('#payment').on('click',function(e){
    jQuery.ajax({
        type: 'post',
                    url: ipAjaxVar.ajaxurl,
                    // url: `@Url.Action(${ipAjaxVar.ajaxurl}, 'check_tschaki_ajax')`,
                    data: {
                        action: 'payment_method_ajax',
                    },
                    // url: 'https://api.stripe.com/v1/payment_methods',
                    headers: {
                        Authorization: `Bearer ${config_secret_key}`
                      },
                    // data: {
                    //     'type' : 'card',
                    //     'card' : {
                    //         'number' : '4242424242424242',
                    //         'exp_month' : 11,
                    //         'exp_year' : 2023,
                    //         'cvc' : '314',
                    //     }
                    //   },
                    success: function ( data, textStatus, XMLHttpRequest, response ) {
                        console.log(data, textStatus, XMLHttpRequest, response);
                        if( data === 'failed_connection0' ) {
                            console.log(11111);
                            jQuery( '.checkmailstatus td' ).html( '<div class="error notice"><p>' + ipAjaxVar.fail_message + '</p></div>' );
                        } else {
                            console.log(2222);
                            console.log(response,data);
                            jQuery( '.checkmailstatus td' ).html( '<div class="success notice notice-success"><p>' + ipAjaxVar.success_message + data + '</p></div>' );
                        }
                    },
                    error: function ( XMLHttpRequest, textStatus, errorThrown ) {
                        alert( errorThrown );
                        console.log(3333);
                    }
    })

    e.preventDefault();
});