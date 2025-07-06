    // -------   Mail Send ajax

     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    
     $(document).ready(function() {
        var form = $('#myForm'); // contact form
        var submit = $('.submit-btn'); // submit button
        var alert = $('.alert-msg'); // alert div for show alert message


        // form submit event
        form.on('submit', function(e) {
            e.preventDefault(); // prevent default form submit

            $.ajax({
                url: '/manage-subscribers/add-subscriber', // form action url
                type: 'POST', // form submit method get/post
                dataType: 'json', // request type html/json/xml
                data: form.serialize(), // serialize form data
                beforeSend: function() {
                    alert.fadeOut();
                    submit.html('Subscribing....'); // change submit button text
                    $('#show_subscription_process').css({'display': 'block'})
                },
                success: function(data) {
                    console.log(data)
                    alert.html(data).fadeIn(); // fade in response data
                    form.trigger('reset'); // reset form
                    submit.attr("style", "display: none !important"); // reset submit button text
                    $('#show_subscription_process').css({'display': 'none'})
                    $('#success_subscribe').fadeIn()
                    $('.modal').modal('hide');
                    $('#success_subscribe').modal('show');
                },
                error: function(e) {
                    if(e.responseJSON.message === "The email has already been taken."){
                        $('#show_subscription_process').css({'display': 'none'})
                        $('#already_subscribe').fadeIn()
                        $('.modal').modal('hide');
                        $('#already_subscribe').modal('show');
                    }else {
                        $('#show_subscription_process').css({'display': 'none'})
                        $('#error_subscribe').fadeIn()
                        $('.modal').modal('hide');
                        $('#error_subscribe').modal('show');
                    }
                }
            });
        });
    });
