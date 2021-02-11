$(document).ready(function(){

    //Mailchimp subscribe
    ajaxMailChimpForm($(".subscribe-form"), $(".subscribe-form .subscribe-result"));

    function ajaxMailChimpForm($form, $resultElement){
        $form.submit(function(e) {
            e.preventDefault();
            if (!isValidEmail($form)) {
                var error =  "A valid email address must be provided.";
                $resultElement.html(error);
                $resultElement.css("color", "red");
            } else {
                $resultElement.css("color", "#3c3c3c");
                $resultElement.html("Subscribing...");
                submitSubscribeForm($form, $resultElement);
            }
        });
    }
    function isValidEmail($form) {
        var email = $form.find("input[type='email']").val();
        if (!email || !email.length) {
            return false;
        } else if (email.indexOf("@") == -1) {
            return false;
        }
        return true;
    }

    function submitSubscribeForm($form, $resultElement) {
        $.ajax({
            type: "GET",
            url: $form.attr("action"),
            data: $form.serialize(),
            cache: false,
            dataType: "jsonp",
            jsonp: "c", // trigger MailChimp to return a JSONP response
            contentType: "application/json; charset=utf-8",
            error: function(error){

            },
            success: function(data){
                if (data.result != "success") {
                    var message = data.msg || "Sorry. Unable to subscribe. Please try again later.";
                    $resultElement.css("color", "red");
                    if (data.msg && data.msg.indexOf("already subscribed") >= 0) {
                        message = "You're already subscribed. Thank you.";
                        $resultElement.css("color", "#3c3c3c");
                    }
                    $resultElement.html(message);
                } else {
                    $resultElement.css("color", "#3c3c3c");
                    $resultElement.html("Please confirm the subscription in your inbox.");
                }
            }
        });
    }

});