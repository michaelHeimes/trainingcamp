<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header(); ?>

<?php
if(is_tax('product_cat')){
	$term_id=get_queried_object()->term_id;
	$term = get_term($term_id, 'product_cat');
	$termParent = $term->parent;
	if ($termParent===0){
		get_template_part('template-parts/product/archive','parent-category');
	}else{
		get_template_part('template-parts/product/archive','child-category');
	}
}
?>


<?php get_footer();
