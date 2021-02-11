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
                var data = {
                    'action': 'pricing_request',
                    'data': form.serialize()
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
