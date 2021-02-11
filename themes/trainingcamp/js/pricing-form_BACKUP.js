$(document).ready(function(){

    // function sortList(ul) {
    //     var ul = document.getElementById(ul);
      
    //     Array.from(ul.getElementsByTagName("LI"))
    //       .sort((a, b) => a.textContent.localeCompare(b.textContent))
    //       .forEach(li => ul.appendChild(li));
    //   }
      
    //   sortList("location-array");

    

    var form=$('form#select-product');

	//form.find('button').removeAttr('disabled');
	//form.find('button').parent().removeClass('not-allowed');
	//window.getProducts();

    
    function readCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    }

    if(readCookie("full_name") !=null && getParam('product_id') != null){
        document.getElementById("pricing-form-tab").style.display = 'none';
        window.getProducts();
    }
   
 function getParam( name )
    {
        name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
        var regexS = "[\\?&]"+name+"=([^&#]*)";
        var regex = new RegExp( regexS );
        var results = regex.exec( window.location.href );
        if( results == null )
        return null;
        else
        return results[1];
    }



    if (form.length>0){

	 if(document.referrer == "http://35.184.192.132/register/"){
             //form.submit();
             window.getProducts();
         }

        var container = form.find('div.errors_wrap');
        var select_category =form.find('select[name="product_category"]');
        var select_product =form.find('select[name="products"]');
        

        
            var term_id=118;
            var data = {
                'action': 'get_products',
                'term_id': term_id
            };
            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                data: data,
                type: 'POST',
                beforeSend: function(){
                    select_product.html('<option value="">Course of interest</option>');
                    jcf.replaceAll();
                    form.find('button').attr('disabled','disabled');
                    form.find('button').parent().addClass('not-allowed');
                },
                success: function (res) {
                    if(res.success){
                        select_product.html(res.options_html);
                        select_product.removeAttr('disabled');
                        select_product.parent().removeClass('not-allowed');
                        jcf.replaceAll();
                        var urlParams = new URLSearchParams(location.search);
                        if (urlParams.has('product_id')){
                        $('form#select-product').find('select[name="products"]').val(urlParams.get('product_id')).change();
                        }
                    }
                }
            });
        
        
        
        //Update listing courses by change category
        if (select_category.length>0 && select_product.length>0){
        
            select_category.on('change',function(){
                if(select_category.val().length>0){
                    var term_id=select_category.val();
                    var data = {
                        'action': 'get_products',
                        'term_id': term_id
                    };
                    $.ajax({
                        url: '/wp-admin/admin-ajax.php',
                        data: data,
                        type: 'POST',
                        beforeSend: function(){
                            select_product.html('<option value="">Course of interest</option>');
                            jcf.replaceAll();
                            form.find('button').attr('disabled','disabled');
                            form.find('button').parent().addClass('not-allowed');
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
                }
            });

            select_product.on('change',function(){
                if($(this).val().length>0){
                    form.find('button').removeAttr('disabled');
                    form.find('button').parent().removeClass('not-allowed');
                }
            });
        }


        //Send submission on request form
        form.validate({
            rules: {
                email:{
                    email: true
                }
            },
            errorLabelContainer: container,
            submitHandler: function () {
                var formdata = form.serialize();
                var date = new Date();
                
                // Format day/month/year to two digits
                var formattedDate = ('0' + date.getDate()).slice(-2);
                var formattedMonth = ('0' + (date.getMonth() + 1)).slice(-2);
                var formattedYear = date.getFullYear().toString().substr(2,2);
            
                // Combine and format date string
                var dateString = formattedMonth + '/' + formattedDate + '/' + formattedYear;
                
                
                formdata = formdata+"&date_of_request="+dateString;
                var data = {
                    'action': 'pricing_request',
                    'data': formdata
                };
                $.ajax({
                    url: ajax_auth_object.ajaxurl,
                    data: data,
                    type: 'POST',
                    cache: false,
                    beforeSend: function(){
                        form.find('button').attr('disabled','disabled');
                        form.find('button').parent().addClass('not-allowed');
                    },
                    success: function (res) {
                        if (!res.success){
                            $(container).show().text('There was an error trying to send your request. Please try again later.')
                        }else{
                            form.find('button').removeAttr('disabled');
                            form.find('button').parent().removeClass('not-allowed');
                             document.getElementById("pricing-form-tab").style.display = 'none';                                                      
                            window.getProducts();
                            
                            // var ul = $("#location-array");
                            // console.log("UL")
                            // Array.from(ul.getElementsByTagName("LI"))
                            // .sort((a, b) => a.textContent.localeCompare(b.textContent))
                            // .forEach(li => ul.appendChild(li));
                        }
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
