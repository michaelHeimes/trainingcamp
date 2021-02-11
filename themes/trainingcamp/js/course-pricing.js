$(document).ready(function(){

    var form=$('form#course-pricing');
    var container = form.find('div.errors_wrap');
    var select_category =form.find('select[name="product_category"]');
    var select_product =form.find('select[name="products"]');
 
    select_product.on('change',function(){
        if($(this).val().length>0){
            form.find('button').removeAttr('disabled');
            form.find('button').parent().removeClass('not-allowed');
        }
    });


 function getQueryStringValue (key) {  
   return decodeURIComponent(window.location.search.replace(new RegExp("^(?:.*[&\\?]" + encodeURIComponent(key).replace(/[\.\+\*]/g, "\\$&") + "(?:\\=([^&]*))?)?.*$", "i"), "$1"));  
 }  
 
     var data = {
                         'action': 'get_all_products'
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
             submitHandler: function () {
                window.getProducts();
             }
         });
 
 
         //Send submission on add-to-cart action
        
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
          
 
     }
 });
 
