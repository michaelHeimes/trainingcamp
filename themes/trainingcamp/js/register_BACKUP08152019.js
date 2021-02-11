$(document).ready(function(){

   var form=$('form#register-course');
   var container = form.find('div.errors_wrap');
   var select_category =form.find('select[name="product_category"]');
   var select_product =form.find('select[name="products"]');

 select_product.on('change',function(){
                if($(this).val().length>0){
 if(select_product.val().length>0){		
//       var id = $(this).children(":selected").attr("id");
//       $("input[name=course_redirect_url]").val(id);
var id = window.location.origin + '/'+ 'pricing-schedules/?product_id=' + select_product.val()
       $("input[name=course_redirect_url]").val(id);
}
                }
            });


function updateQueryStringParameter(uri, key, value) {
  var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
  var separator = uri.indexOf('?') !== -1 ? "&" : "?";
  if (uri.match(re)) {
    return uri.replace(re, '$1' + key + "=" + value + '$2');
  }
  else {
    return uri + separator + key + "=" + value;
  }
}

function getQueryStringValue (key) {  
  return decodeURIComponent(window.location.search.replace(new RegExp("^(?:.*[&\\?]" + encodeURIComponent(key).replace(/[\.\+\*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));  
}  

	var data = {
                        'action': 'get_all_products_url',
			'id':getQueryStringValue("product_id")
                    };
                    $.ajax({
                        url: '/wp-admin/admin-ajax.php',
                        data: data,
                        type: 'POST',
                        beforeSend: function(){
                            select_product.html('<option value="">Course of interest</option>');
                            jcf.replaceAll();                            
                        },
                        success: function (res) {
			 if(res.success){
                                select_product.html(res.options_html);
				select_product.removeAttr('disabled');
                                select_product.parent().removeClass('not-allowed');                              
                                jcf.replaceAll();
                            }
                        }
                    });



    if (form.length>0){

        //Send submission on request form
        form.validate({
            rules: {
                email:{
                    email: true
                }
            },
            submitHandler: function () {
               /* var data = {
                    'action': 'register_request',
                    'data': form.serialize()
                };*/
                var formdata = form.serialize();
                var d = new Date();
                formdata = formdata+"&date_of_request="+d;
                var data = {
                    'action': 'pricing_request',
                    'data': formdata
                };
                $.ajax({
                    url: ajax_auth_object.ajaxurl,
                    data: data,
                    type: 'POST',
                    cache: false,
                    success: function (res) {
 window.location = $("input[name=course_redirect_url]").val();                    
 //   window.location = $("form").serializeArray()[8].value                        
// alert($("form").serializeArray()[8].value)
                        
                    }
                });
                return false;
            }
        });


        //Send submission on add-to-cart action
        /*
        var add_to_cart_btn=$(document).find('button.single_add_to_cart_button');
        add_to_cart_btn.on('click',function(e){
            e.preventDefault();
            var _this_form=$(this).parents('form');
            var serialized_add_form=_this_form.serialize();
            var serizlized_request_form=form.serialize();
            var serialized_data=serialized_add_form+'&'+serizlized_request_form;

            var data = {
                'action': 'pricing_request',
                'data': serialized_data
            };
            $.ajax({
                url: ajax_auth_object.ajaxurl,
                data: data,
                type: 'POST',
                success: function (res) {
                    if (res.success){
                        _this_form.submit();
                    }
                    return false;
                }
            });
            return false;
        });
        */


    }
});
