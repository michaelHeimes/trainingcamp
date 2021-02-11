//Login
var login_form = $('form#login-form');
if (login_form.length > 0) {
    login_form.validate({
        rules: {
            username:{
                email: true
            }
        },
        errorPlacement: function (error, element) {
        },
        submitHandler: function () {
            var data = {
                'action': 'submit_login',
                'data': login_form.serialize()
            };
            $.ajax({
                url: ajax_auth_object.ajaxurl,
                data: data,
                type: 'POST',
                cache: false,
                success: function (res) {
                    $('div.status', $(login_form)).html(res.message);
                    if (res.loggedin == true) {
                        window.location = ajax_auth_object.redirecturl;
                    }
                }
            });
            return false;
        }
    });

}


//Lostpassword
var lostpass_form = $('form[name="lostpasswordform"]');
if (lostpass_form.length > 0) {
    lostpass_form.validate({
        rules: {
            user_login:{
                email: true
            }
        },
        errorPlacement: function (error, element) {
        },
        submitHandler: function () {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                cache: false,
                url: ajax_auth_object.ajaxurl,
                data: {
                    'action': 'ajaxforgotpassword',
                    'user_login': $('#user_login').val(),
                    'security': $('#forgotsecurity').val()
                },
                success: function (data) {
                    $('div.status', lostpass_form).text(data.message);
                }
            });
        }
    });
}


//Registration
var form_wrap = $('form#registration_form');
if (form_wrap.length > 0) {
    form_wrap.validate({
        rules: {
            user_email:{
                email: true
            },
            user_pass:{
                minlength: 8
            },
            user_pass_confirmation: {
                equalTo: "#user_pass"
            }
        },
        errorPlacement: function (error, element) {
        },
        submitHandler: function (form) {
            var formdata = new FormData(this);
            var other_data = $(form_wrap).serializeArray();
            $.each(other_data, function (key, input) {
                formdata.append(input.name, input.value);
            });

            formdata.append('action', 'submit_form');

            $.ajax({
                url: ajax_auth_object.ajaxurl,
                data: formdata,
                type: 'POST',
                processData: false,
                contentType: false,
                cache: false,
                dataType: 'json',
                success: function (res) {
                    $('div.status', $(form_wrap)).html(res.message);
                    if (res.loggedin == true) {
                        window.location = ajax_auth_object.redirecturl;
                    }
                }
            });
            return false;
        }
    });
}