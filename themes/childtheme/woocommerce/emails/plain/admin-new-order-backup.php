<?php
/**
 * Admin new order email (plain text)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/plain/admin-new-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author		WooThemes
 * @package 	WooCommerce/Templates/Emails/Plain
 * @version		2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//echo "= " . $email_heading . " =\n\n";

echo sprintf( __( 'Student Name: %s.', 'woocommerce' ), $order->get_formatted_billing_full_name() ) . "\n\n";
echo sprintf( __( 'Student Email: %s.', 'woocommerce' ), $order->get_billing_email() ) . "\n\n";
echo sprintf( __( 'Student Day Phone: %s.', 'woocommerce' ), $order->get_billing_phone() ) . "\n\n";
echo sprintf( __( 'Company Name: %s.', 'woocommerce' ), $order->get_billing_company() ) . "\n\n";
echo sprintf( __( 'Student Address1: %s.', 'woocommerce' ), $order->get_billing_address_1() ) . "\n\n";
/*echo sprintf( __( 'Student Address2: %s.', 'woocommerce' ), $order->get_billing_address_2() ) . "\n\n";*/
echo sprintf( __( 'Student City: %s.', 'woocommerce' ), $order->get_billing_city() ) . "\n\n";
//echo sprintf( __( 'Student Region: %s.', 'woocommerce' ), $order->get_billing_email() ) . "\n\n";
echo sprintf( __( 'Student Region: %s.', 'woocommerce' ), $order->get_billing_state() ) . "\n\n";
echo sprintf( __( 'Student Zip: %s.', 'woocommerce' ), $order->get_billing_postcode() ) . "\n\n";
echo sprintf( __( 'Student Country: %s.', 'woocommerce' ), $order->get_billing_country() ) . "\n\n";
echo sprintf( __( 'Referred BY: %s.', 'woocommerce' ),get_post_meta( $order->get_order_number(), 'additional_hear_about', true )) . "\n\n";
echo sprintf( __( 'AA code: %s.', 'woocommerce' ), get_post_meta( $order->get_order_number(), 'additional_alumni_code', true )) . "\n\n";
echo sprintf( __( 'Approving Manager: %s.', 'woocommerce' ), get_post_meta( $order->get_order_number(), 'additional_name', true ) ) . "\n\n";
echo sprintf( __( 'Approving Manager Telephone: %s.', 'woocommerce' ), get_post_meta( $order->get_order_number(), 'additional_phone_number', true ) ) . "\n\n";
echo sprintf( __( 'Approving Manager Email: %s.', 'woocommerce' ), get_post_meta( $order->get_order_number(), 'additional_email', true )) . "\n\n";
echo sprintf( __( 'Approving Manager Title: %s.', 'woocommerce' ), get_post_meta( $order->get_order_number(), 'additional_name', true )) . "\n\n";
echo sprintf( __( 'Payment method: %s.', 'woocommerce' ), $order->get_payment_method_title() ) . "\n\n";

if(!empty(get_post_meta( $order->id, '_gi_bill_number', true ))){
 echo sprintf( __( 'GI Bill Chapter: %s.', 'woocommerce' ), get_post_meta( $order->id, '_gi_bill_number', true )) . "\n\n"; 
}

if(!empty(get_post_meta( $order->id, '_po_note', true ))){
 echo sprintf( __( 'GI Bill Duty Status: %s.', 'woocommerce' ), get_post_meta( $order->id, '_po_note', true )) . "\n\n"; 
}

if(!empty(get_post_meta( $order->id, '_self_fund_number', true ))){
 echo sprintf( __( 'SelfFund Note: %s.', 'woocommerce' ), get_post_meta( $order->id, '_self_fund_number', true )) . "\n\n"; 
}

if(!empty(get_post_meta( $order->id, '_account_number', true ))){
 echo sprintf( __( 'PO Number: %s.', 'woocommerce' ), get_post_meta( $order->id, '_account_number', true )) . "\n\n"; 
}

if(!empty(get_post_meta( $order->id, '_purchase_note', true ))){
 echo sprintf( __( 'PO Notes: %s.', 'woocommerce' ), get_post_meta( $order->id, '_purchase_note', true )) . "\n\n"; 
}

if(!empty(get_post_meta( $order->id, '_purchase_name', true ))){
 echo sprintf( __( 'Accounts Payable Manager: %s.', 'woocommerce' ), get_post_meta( $order->id, '_purchase_name', true )) . "\n\n"; 
}

if(!empty(get_post_meta( $order->id, '_purchase_phone', true ))){
 echo sprintf( __( 'Accounts Payable Manager Telephone: %s.', 'woocommerce' ), get_post_meta( $order->id, '_purchase_phone', true )) . "\n\n"; 
}

if(!empty(get_post_meta( $order->id, '_purchase_email', true ))){
 echo sprintf( __( 'Accounts Payable Manager Email: %s.', 'woocommerce' ), get_post_meta( $order->id, '_purchase_email', true )) . "\n\n"; 
}

$index=1;
foreach ( $order->get_items() as $item_id => $item ) {
	if ( apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {	
		$product = $item->get_product();
		echo  'Course Abbeviation'.$index.': '.$product->get_sku(). "\n\n"; 
		echo  'Course Name'.$index.': '.apply_filters( 'woocommerce_order_item_name',
		 $item->get_name(), $item, false ). "\n\n"; 
		echo 'Course Quantity'.$index.': ' . apply_filters( 'woocommerce_email_order_item_quantity', $item->get_quantity(), $item ). "\n\n"; 

		$variation_id = $item->get_variation_id();
		$start_date=get_post_meta( $variation_id, '_start_date', true );
		$end_date=get_post_meta( $variation_id, '_end_date', true );
		$location=$item->get_meta_data();
		echo 'Course Date'.$index.': ' . $start_date. "\n\n"; 
		echo 'Course End Date'.$index.': ' . $end_date. "\n\n"; 
		echo 'Course Location'.$index.': ' .$product->get_attributes()['pa_location']. "\n\n"; 

		$index = $index+1;
		
	}
}

/*echo "=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";*/

/**
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
/*do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );*/

/*echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";*/

/**
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
/*do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );*/

/**
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
/*do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );*/

/*echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

echo apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) );*/