$(document).ready(function () {    

    var config = {};
    $.getJSON( "/config.json", function(data) {
        config= data;
    });
    

// 15-Minute OnSite Needs Assessment
$("#assessment").submit(function (e) {
    e.preventDefault(e);
var body = {};

            body.FormName = 'assessment';
            body.FirstName = $('#firstName').val();
            body.LastName = $('#lastName').val();
            body.Email = $('#email').val();
            body.Phone = $('#phone').val();
            body.Organization = $('#organization').val();
            body.Description = 'Enterprise 15-Minute OnSite Needs Assessment';
            body.categoryInterest = 'landingpage.enterprise';

            $('#thanks').foundation('open');

            $.ajax({
                async: false,
                url: config.apiUrl,
                method: "post",
                dataType: 'json',
                contentType: "application/json",
                data: JSON.stringify(body),
                crossDomain: true,
                success: function (data) {

                    return true;
                },
                error: function () {
                    return false;
                }
            });
        });
    });
