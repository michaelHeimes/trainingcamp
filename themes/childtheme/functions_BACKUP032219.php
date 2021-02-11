<?php

function trainingcamp_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'trainingcamp_add_woocommerce_support' );
add_action( 'woocommerce_thankyou', 'order_received_empty_cart_action', 10, 1 );

function order_received_empty_cart_action( $order_id ){
    WC()->cart->empty_cart();
}

function register_session(){
    if( !session_id() )
        session_start();
}

add_action('init','register_session',1);
add_filter( 'woocommerce_rest_check_permissions', 'my_woocommerce_rest_check_permissions', 90, 4 );

function my_woocommerce_rest_check_permissions( $permission, $context, $object_id, $post_type  ){
  return true;
}

// register the ajax action for authenticated users
add_action('wp_ajax_delete_product_variation_ajax', 'delete_product_variation_ajax');
// register the ajax action for unauthenticated users
add_action('wp_ajax_nopriv_delete_product_variation_ajax', 'delete_product_variation_ajax');

// handle the ajax request
function delete_product_variation_ajax() {
    $json = $_REQUEST['json_data'];    
    $key = 'end_date';
    $UTC = new DateTimeZone("UTC");
    $json_array = json_decode(json_encode($json), true);
        $now = new DateTime();    
        $now->setTimezone( $UTC ); 
        foreach($json_array as $item){
            $dataObject = $item; 
            $date = new DateTime($dataObject[$key]);  
            $date->setTimezone( $UTC );          
            if($date < $now) {
                $text = $text."-".$dataObject['id'];
              wp_delete_post($dataObject['id'],false);
            }
        }
        wp_send_json(array('success'=>'true'));    
}

function custom_discount_type( $discount_types ) {
    $discount_types['custom_discount'] =__( 'Special discount', 'woocommerce' );
    return $discount_types;
    }

// add the hooks
add_filter( 'woocommerce_coupon_discount_types', 'custom_discount_type',10, 1);
add_filter( 'woocommerce_calculated_total', 'custom_calculated_total', 10, 2 );

function custom_calculated_total( $total, $cart ){
    global $woocommerce;
    $coupon_id = 'flat2000';
    $coupon_id2 = 'flat2500';
    global $woocommerce;

        if(in_array($coupon_id, $woocommerce->cart->get_applied_coupons())){
            $couponData = new WC_Coupon($coupon_id);                                    
            $cart->coupon_discount_totals[$coupon_id] = $woocommerce->cart->subtotal - ($couponData->amount * $woocommerce->cart->cart_contents_count);
            $total = $couponData->amount * $woocommerce->cart->cart_contents_count; 
            if($woocommerce->cart->subtotal<$total){
                $cart->coupon_discount_totals[$coupon_id] = 0;
                return $woocommerce->cart->subtotal;
            }
        }else if(in_array($coupon_id2, $woocommerce->cart->get_applied_coupons())){
            $coupon2Data = new WC_Coupon($coupon_id2);            
            $cart->coupon_discount_totals[$coupon_id2] = $woocommerce->cart->subtotal - ($coupon2Data->amount * $woocommerce->cart->cart_contents_count);
            $total = $coupon2Data->amount * $woocommerce->cart->cart_contents_count;    
            if($woocommerce->cart->subtotal<$total){
                $cart->coupon_discount_totals[$coupon_id2] = 0;
                return $woocommerce->cart->subtotal;
            }  
        }
  
    return $total ; 
}

add_filter( 'default_checkout_billing_country', 'bbloomer_change_default_checkout_country' );
 
function bbloomer_change_default_checkout_country() {
  return 'US'; 
}

//function filter_woocommerce_get_discounted_price( $price, $values, $instance,$coupon ) { 
    //$price represents the current product price without discount
    //$values represents the product object
    //$instance represent the cart object 
    
  //  global $woocommerce;
   // $coupon_id = 'flat2000';
   // $coupon_id2 = 'flat2500';
   // global $woocommerce;
    
    //foreach ($variable as $woocommerce->cart->applied_coupons) {
     //   if(in_array($coupon_id, $woocommerce->cart->get_applied_coupons())){
       //     $couponData = new WC_Coupon($coupon_id);
        //    $price = $couponData->amount * $woocommerce->cart->cart_contents_count; 
      //  }else if(in_array($coupon_id2, $woocommerce->cart->get_applied_coupons())){
        //    $couponData = new WC_Coupon($coupon_id2);
       // $price = $couponData->amount * $woocommerce->cart->cart_contents_count;    
//        }
   //}
   
   // return $price ; 
  //  }
     //add_filter('woocommerce_get_discounted_price','filter_woocommerce_get_discounted_price', 10, 3 ); 
     


add_filter( 'woocommerce_default_address_fields' , 'optional_default_address_fields' );

function optional_default_address_fields( $address_fields ) {
	$address_fields['company']['required'] = false;
	$address_fields['postcode']['required'] = false;
	$address_fields['city']['required'] = false;
	$address_fields['state']['required'] = false;
	$address_fields['address_1']['required'] = false;
	$address_fields['country']['required'] = false;
	return $address_fields;
}

add_filter( 'woocommerce_email_subject_new_order', 'custom_email_subject', 20, 2 );

function custom_email_subject( $formated_subject, $order ){
    return sprintf( __('!Registration %s', 'woocommerce'), 
        $order->get_formatted_billing_full_name()
    );
}

add_action( 'woocommerce_before_checkout_form', 'action_before_checkout_form' );
  function action_before_checkout_form(){
	  // HERE define the default payment gateway ID
	  $default_payment_gateway_id = 'pay_later';
  
      WC()->session->set('chosen_payment_method', $default_payment_gateway_id); ?>

   <script type="text/javascript">
    (function($){
 
        $('#billing-slider').click(function(){
    
    if($(this).is(':checked')){
        $('#checkout-payment-container').fadeIn('fast');
        //$('#payment_method').val("on")
        if("payment_method_paypal" === $(".custom-ul").find(".active").attr('id')){        
            $('#payment_method').val("paypal")
        }else if("payment_method_authorize_net_aim" === $(".custom-ul").find(".active").attr('id')){            
            $('#payment_method').val("authorize_net_aim")
        }  
//alert("test");
       // $('#company-info-container').fadeIn('slow');
    } else {
        $('#checkout-payment-container').fadeOut('fast'); 
	$('#payment_method').val("pay_later")        
        // $('#payment_method_authorize_net_aim').removeClass('active');    
        // $('#authorize_net_aim').removeClass('active');   
       // $('#company-info-container').fadeOut('slow');
        }
});
    })(jQuery);
    </script><?php

  }

