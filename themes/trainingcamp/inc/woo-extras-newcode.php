<?php
/**
 * Disable all woocommerce css
 *
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );


/**
 * Add script for single product - admin panel
 *
 */
function woo_add_admin_scripts(){
    wp_enqueue_script('init-datapicker', get_stylesheet_directory_uri().'/js/woo-admin.js', array('jquery'), false, true );
}
add_action('admin_enqueue_scripts', 'woo_add_admin_scripts');


/**
 * Clone woocommerce_wp_text_input - creator text for woocommerce
 *
 */
function woocommerce_wp_text_input_clone( $field ) {
    global $thepostid, $post;

    $thepostid              = empty( $thepostid ) ? $post->ID : $thepostid;
    $field['placeholder']   = isset( $field['placeholder'] ) ? $field['placeholder'] : '';
    $field['class']         = isset( $field['class'] ) ? $field['class'] : 'short';
    $field['style']         = isset( $field['style'] ) ? $field['style'] : '';
    $field['wrapper_class'] = isset( $field['wrapper_class'] ) ? $field['wrapper_class'] : '';
    $field['value']         = isset( $field['value'] ) ? $field['value'] : get_post_meta( $thepostid, $field['id'], true );
    $field['name']          = isset( $field['name'] ) ? $field['name'] : $field['id'];
    $field['type']          = isset( $field['type'] ) ? $field['type'] : 'text';
    $data_type              = empty( $field['data_type'] ) ? '' : $field['data_type'];

    switch ( $data_type ) {
        case 'price' :
            $field['class'] .= ' wc_input_price';
            $field['value']  = wc_format_localized_price( $field['value'] );
            break;
        case 'decimal' :
            $field['class'] .= ' wc_input_decimal';
            $field['value']  = wc_format_localized_decimal( $field['value'] );
            break;
        case 'stock' :
            $field['class'] .= ' wc_input_stock';
            $field['value']  = wc_stock_amount( $field['value'] );
            break;
        case 'url' :
            $field['class'] .= ' wc_input_url';
            $field['value']  = esc_url( $field['value'] );
            break;

        default :
            break;
    }

    // Custom attribute handling
    $custom_attributes = array();

    if ( ! empty( $field['custom_attributes'] ) && is_array( $field['custom_attributes'] ) ) {

        foreach ( $field['custom_attributes'] as $attribute => $value ){
            $custom_attributes[] = esc_attr( $attribute ) . '="' . esc_attr( $value ) . '"';
        }
    }

    echo '<p class="form-field ' . esc_attr( $field['id'] ) . '_field ' . esc_attr( $field['wrapper_class'] ) . '"><label for="' . esc_attr( $field['id'] ) . '">' . wp_kses_post( $field['label'] ) . '</label><input type="' . esc_attr( $field['type'] ) . '" class="' . esc_attr( $field['class'] ) . '" style="' . esc_attr( $field['style'] ) . '" name="' . esc_attr( $field['name'] ) . '" id="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $field['value'] ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" ' . implode( ' ', $custom_attributes ) . ' /> ';

    if ( ! empty( $field['description'] ) ) {

        if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
            echo wc_help_tip( $field['description'] );
        } else {
            echo '<span class="description">' . wp_kses_post( $field['description'] ) . '</span>';
        }
    }
    echo '</p>';
}



/**
 * Create new fields for variations
 *
 */

add_action( 'woocommerce_product_after_variable_attributes', 'variation_settings_fields', 10, 3 );
function variation_settings_fields( $loop, $variation_data, $variation ) {
    // Text Field - Start and End dates
    woocommerce_wp_text_input_clone(
        array(
            'id'          => '_start_date[' . $variation->ID . ']',
            'label'       => __( 'Start date', 'woocommerce' ),
            'placeholder' => 'yy-mm-dd',
            'wrapper_class'=> 'date_wrap',
            'class'       => 'sale_price_dates_from course_date',
            'desc_tip'    => false,
            'description' => '',
            'value'       => get_post_meta( $variation->ID, '_start_date', true )
        )
    );
    woocommerce_wp_text_input_clone(
        array(
            'id'          => '_end_date[' . $variation->ID . ']',
            'label'       => __( 'End date', 'woocommerce' ),
            'placeholder' => 'yy-mm-dd',
            'wrapper_class'=> 'date_wrap',
            'class'       => 'sale_price_dates_to course_date',
            'desc_tip'    => false,
            'description' => '',
            'value'       => get_post_meta( $variation->ID, '_end_date', true )
        )
    );

    // Checkbox Field - Guaranteed to run
    woocommerce_wp_checkbox(
        array(
            'id'            => '_guarant[' . $variation->ID . ']',
            'label'         => __('Guaranteed to run?', 'woocommerce' ),
            'value'         => get_post_meta( $variation->ID, '_guarant', true ),
            'style'         => 'margin-left:10px;'
        )
    );
    
    // Checkbox Field - Sold out
    woocommerce_wp_checkbox(
        array(
            'id'            => '_soldOut[' . $variation->ID . ']',
            'label'         => __('Sold out?', 'woocommerce' ),
            'value'         => get_post_meta( $variation->ID, '_soldOut', true ),
            'style'         => 'margin-left:10px;'
        )
    );
}


/**
 * Save new fields for variations
 *
 */
add_action( 'woocommerce_save_product_variation', 'save_variation_settings_fields', 10, 2 );
function save_variation_settings_fields( $post_id )
{
    // Text Field
    $start_date = $_POST['_start_date'][$post_id];
    if (isset($start_date)) {
        update_post_meta($post_id, '_start_date', esc_attr($start_date));
    }
    $end_date = $_POST['_end_date'][$post_id];
    if (isset($end_date)) {
        update_post_meta($post_id, '_end_date', esc_attr($end_date));
    }
    // Checkbox Field
    $guaranteed = $_POST['_guarant'][$post_id];
    $sold_out = $_POST['_soldOut'][$post_id];
    update_post_meta($post_id, '_guarant', esc_attr($guaranteed));
    update_post_meta($post_id, '_soldOut', esc_attr($sold_out));
}


/**
 * Reinit view template for variations on load variations - Woocommerce single product on admin panel
 *
 */
remove_action( 'wp_ajax_woocommerce_load_variations', array( 'WC_AJAX', 'load_variations' ) );
add_action( 'wp_ajax_woocommerce_load_variations', 'load_variations' );
function load_variations(){
    ob_start();

    check_ajax_referer( 'load-variations', 'security' );

    // Check permissions again and make sure we have what we need
    if ( ! current_user_can( 'edit_products' ) || empty( $_POST['product_id'] ) || empty( $_POST['attributes'] ) ) {
        die( -1 );
    }

    global $post;

    $product_id = absint( $_POST['product_id'] );
    $post       = get_post( $product_id ); // Set $post global so its available like within the admin screens
    $per_page   = ! empty( $_POST['per_page'] ) ? absint( $_POST['per_page'] ) : 10;
    $page       = ! empty( $_POST['page'] ) ? absint( $_POST['page'] ) : 1;

    // Get attributes
    $attributes        = array();
    $posted_attributes = wp_unslash( $_POST['attributes'] );

    foreach ( $posted_attributes as $key => $value ) {
        $attributes[ $key ] = array_map( 'wc_clean', $value );
    }

    // Get tax classes
    $tax_classes           = WC_Tax::get_tax_classes();
    $tax_class_options     = array();
    $tax_class_options[''] = __( 'Standard', 'woocommerce' );

    if ( ! empty( $tax_classes ) ) {
        foreach ( $tax_classes as $class ) {
            $tax_class_options[ sanitize_title( $class ) ] = esc_attr( $class );
        }
    }

    // Set backorder options
    $backorder_options = array(
        'no'     => __( 'Do not allow', 'woocommerce' ),
        'notify' => __( 'Allow, but notify customer', 'woocommerce' ),
        'yes'    => __( 'Allow', 'woocommerce' )
    );

    // set stock status options
    $stock_status_options = array(
        'instock'    => __( 'In stock', 'woocommerce' ),
        'outofstock' => __( 'Out of stock', 'woocommerce' )
    );

    $parent_data = array(
        'id'                   => $product_id,
        'attributes'           => $attributes,
        'tax_class_options'    => $tax_class_options,
        'sku'                  => get_post_meta( $product_id, '_sku', true ),
        'weight'               => wc_format_localized_decimal( get_post_meta( $product_id, '_weight', true ) ),
        'length'               => wc_format_localized_decimal( get_post_meta( $product_id, '_length', true ) ),
        'width'                => wc_format_localized_decimal( get_post_meta( $product_id, '_width', true ) ),
        'height'               => wc_format_localized_decimal( get_post_meta( $product_id, '_height', true ) ),
        'tax_class'            => get_post_meta( $product_id, '_tax_class', true ),
        'backorder_options'    => $backorder_options,
        'stock_status_options' => $stock_status_options
    );

    if ( ! $parent_data['weight'] ) {
        $parent_data['weight'] = wc_format_localized_decimal( 0 );
    }

    if ( ! $parent_data['length'] ) {
        $parent_data['length'] = wc_format_localized_decimal( 0 );
    }

    if ( ! $parent_data['width'] ) {
        $parent_data['width'] = wc_format_localized_decimal( 0 );
    }

    if ( ! $parent_data['height'] ) {
        $parent_data['height'] = wc_format_localized_decimal( 0 );
    }

    // Get variations
    $args = apply_filters( 'woocommerce_ajax_admin_get_variations_args', array(
        'post_type'      => 'product_variation',
        'post_status'    => array( 'private', 'publish' ),
        'posts_per_page' => $per_page,
        'paged'          => $page,

        //Sort by date
        'meta_key'       => '_start_date',
        'orderby' => 'meta_value',
        'order' => 'ASC',
        //'orderby'        => array( 'menu_order' => 'ASC', 'ID' => 'DESC' ),
        'post_parent'    => $product_id
    ), $product_id );

    $variations = get_posts( $args );
    $loop = 0;

    if ( $variations ) {

        foreach ( $variations as $variation ) {
            $variation_id     = absint( $variation->ID );
            $variation_meta   = get_post_meta( $variation_id );
            $variation_data   = array();
            $shipping_classes = get_the_terms( $variation_id, 'product_shipping_class' );
            $variation_fields = array(
                '_sku'                   => '',
                '_stock'                 => '',
                '_regular_price'         => '',
                '_sale_price'            => '',
                '_weight'                => '',
                '_length'                => '',
                '_width'                 => '',
                '_height'                => '',
                '_download_limit'        => '',
                '_download_expiry'       => '',
                '_downloadable_files'    => '',
                '_downloadable'          => '',
                '_virtual'               => '',
                '_thumbnail_id'          => '',
                '_sale_price_dates_from' => '',
                '_sale_price_dates_to'   => '',
                '_manage_stock'          => '',
                '_stock_status'          => '',
                '_backorders'            => null,
                '_tax_class'             => null,
                '_variation_description' => ''
            );

            foreach ( $variation_fields as $field => $value ) {
                $variation_data[ $field ] = isset( $variation_meta[ $field ][0] ) ? maybe_unserialize( $variation_meta[ $field ][0] ) : $value;
            }

            // Add the variation attributes
            $variation_data = array_merge( $variation_data, wc_get_product_variation_attributes( $variation_id ) );

            // Formatting
            $variation_data['_regular_price'] = wc_format_localized_price( $variation_data['_regular_price'] );
            $variation_data['_sale_price']    = wc_format_localized_price( $variation_data['_sale_price'] );
            $variation_data['_weight']        = wc_format_localized_decimal( $variation_data['_weight'] );
            $variation_data['_length']        = wc_format_localized_decimal( $variation_data['_length'] );
            $variation_data['_width']         = wc_format_localized_decimal( $variation_data['_width'] );
            $variation_data['_height']        = wc_format_localized_decimal( $variation_data['_height'] );
            $variation_data['_thumbnail_id']  = absint( $variation_data['_thumbnail_id'] );
            $variation_data['image']          = $variation_data['_thumbnail_id'] ? wp_get_attachment_thumb_url( $variation_data['_thumbnail_id'] ) : '';
            $variation_data['shipping_class'] = $shipping_classes && ! is_wp_error( $shipping_classes ) ? current( $shipping_classes )->term_id : '';
            $variation_data['menu_order']     = $variation->menu_order;
            $variation_data['_stock']         = '' === $variation_data['_stock'] ? '' : wc_stock_amount( $variation_data['_stock'] );

            include( get_template_directory() . '/inc/html-variation-admin.php' );

            $loop++;
        }
    }
    die();
}


/**
 * Show Variable product type as the default in the select box.
 *
 */
add_filter( 'default_product_type', 'change_default_product_type' );
function change_default_product_type() {
    return 'variable';
}


/**
 * Remove product types we do not want to be shown.
 *
 */
add_filter( 'product_type_selector', 'product_type_selector', 10, 2 );
function product_type_selector( $product_types ) {
    unset( $product_types['grouped'] );
    unset( $product_types['simple'] );
    unset( $product_types['external'] );
    return $product_types;
}


/**
 * Update price, sale price by save Product post
 *
 */
add_action('acf/save_post', 'update_price_after_save_acf_fields',20,1);
function update_price_after_save_acf_fields( $post_id ) {
    $post_type=get_post_type($post_id);
    if ($post_type=='product'){
        $product_rows=get_field('product_details',$post_id);
        $price=0; $sale_price=0; $sale_difference=0;
        if (is_array($product_rows) && count($product_rows)>0){
            foreach($product_rows as $product_row){
                if ($product_row['product_details_discount']!=1){
                    $price+=$product_row['product_details_cost'];
                }else{
                    $sale_difference+=$product_row['product_details_cost'];
                }
            }
        }

        $sale_price=($sale_difference>0) ? $price-$sale_difference : '';

        $product=wc_get_product($post_id);
        $variations=$product->get_available_variations();
        if ($price>0 && is_array($variations) && count($variations)>0){
            foreach($variations as $variation){
                $date_from='';$date_to='';
                _wc_save_product_price( $variation['variation_id'], $price, $sale_price, $date_from, $date_to );
            }
            //Clear product transitions
            wc_delete_product_transients( $post_id );
            //Sync with parent product
            WC_Product_Variable::sync($post_id);
        }
    }

}


/**
 * Add custom fields to woocommerce REST endpoint
 *
 */
add_filter( 'woocommerce_rest_prepare_product', 'custom_products_api_data', 90, 2 );
function custom_products_api_data( $response, $post ) {

    $product = wc_get_product( $post );
    if ( $product->is_type( 'variable' ) && $product->has_child() ) {
        $response->data['variations_meta_fields'] =array();
        $variations=$product->get_available_variations();
        if (is_array($variations) && count($variations)>0){
            foreach($variations as $variation){
                $taxonomy = 'pa_location';
                $meta = get_post_meta($variation['variation_id'], 'attribute_'.$taxonomy, true);
                //$term = get_term_by('slug', $meta, $taxonomy);
                $response->data['variations_meta_fields'][$variation['variation_id']]=array(
                    'start_date'=>get_post_meta( $variation['variation_id'], '_start_date', true ),
                    'end_date'=>get_post_meta( $variation['variation_id'], '_end_date', true ),
                    'guaranteed'=>get_post_meta( $variation['variation_id'], '_guarant', true ),
                    'sold_out'=>get_post_meta( $variation['variation_id'], '_soldOut', true ),
                    'slug'=>$meta
                );

            }
        }
    }

    $response->data['pricing_details']=get_field('product_details',$post->ID);

    return $response;
}


/**
 * Reinit product_tag taxonomy - add hierarchy, change view to category
 *
 */
function register_taxonomy_pro_tags() {
    # the post types that the taxonomy is registered to
    $post_types = array('product');
    # set this to the taxonomy name
    $tax_name = 'product_tag';
    # load the already created taxonomy as array so we can
    # pass it back in as $args to register_taxonomy
    $tax = (array)get_taxonomy($tax_name);
    /*echo '<pre>'.var_export($tax,true).'</pre>';
    die;*/

    if ($tax) {
        # adjust the hierarchical necessities
        $tax['hierarchical'] = true;
        $tax['meta_box_cb'] = 'post_categories_meta_box';
        $tax['rewrite']['hierarchical'] = true;

        # cast caps to array as expected by register_taxonomy
        $tax['capabilities'] = (array)$tax['cap'];
        # cast labels to array
        $tax['labels'] = (array)$tax['labels'];
        # register the taxonomy with our new settings
        register_taxonomy($tax_name, array('product'), $tax);
    }
}
add_action('init', 'register_taxonomy_pro_tags', 9999);



/**
 * Get all the products and url
 *
 */
add_action('wp_ajax_get_all_products_url', 'get_all_products_url');
add_action('wp_ajax_nopriv_get_all_products_url', 'get_all_products_url');
function get_all_products_url(){
    $success=false;
    $options_html='<option value="">Course of interest</option>';
    //if(isset($_POST['term_id'])){
        //$term_id=$_POST['term_id'];
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => -1,
             'orderby' => 'title',
            'order'   => 'ASC',
        );
        $query=new WP_Query($args);
        if ($query->have_posts()){
            $success=true;
            while($query->have_posts()){
                $query->the_post();
                if(isset($_POST['id']) ){
                $term_id=$_POST['id'];
                if(strcmp($term_id,get_the_ID())==0){
                    //$one_product_html='<option value="'.$_GET['product_id'].'" id="'.get_permalink($_GET['product_id']) .'" selected="selected">'.$product_name.'</option>';
                    $options_html.='<option value="'.get_the_ID().'" id="'.get_permalink(get_the_ID()).'" selected="selected">'.get_the_title().'</option>';
            }else{
                    $options_html.='<option value="'.get_the_ID().'" id="'.get_permalink(get_the_ID()).'">'.get_the_title().'</option>';
            }
                }else{
      
                        $options_html.='<option value="'.get_the_ID().'" id="'.get_permalink(get_the_ID()).'">'.get_the_title().'</option>';
      
                }
		
            }
        }
        wp_reset_postdata();
   // }
    wp_send_json(array('success'=>$success,'options_html'=>$options_html));
    die;
}

/**
 * Get products by product category
 *
 */
add_action('wp_ajax_get_products', 'get_products');
add_action('wp_ajax_nopriv_get_products', 'get_products');
function get_products(){
    $success=false;
    $options_html='<option value="">Course of interest</option>';
    if(isset($_POST['term_id'])){
        $term_id=$_POST['term_id'];
        $args = array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order'   => 'ASC',
            'tax_query' => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'term_id',
                    'terms'    => $term_id
                )
            )
        );
        $query=new WP_Query($args);
        if ($query->found_posts>0){
            $success=true;
            while($query->have_posts()){
                $query->the_post();
                $options_html.='<option value="'.get_the_ID().'">'.get_the_title().'</option>';
            }
        }
        wp_reset_postdata();
    }
    wp_send_json(array('success'=>$success,'options_html'=>$options_html));
    die;
}

/**
 * Get all the products
 *
 */
add_action('wp_ajax_get_all_products', 'get_all_products');
add_action('wp_ajax_nopriv_get_all_products', 'get_all_products');
function get_all_products(){
    $success=false;
    $options_html='<option value="">Course of interest</option>';
    //if(isset($_POST['term_id'])){
        //$term_id=$_POST['term_id'];
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => -1,
        );
        $query=new WP_Query($args);
        if ($query->have_posts()){
            $success=true;
            while($query->have_posts()){
                $query->the_post();
                if(isset($_POST['id']) ){
                $term_id=$_POST['id'];
                if(strcmp($term_id,get_the_ID())==0){
                    $options_html.='<option value="'.get_the_ID().'" selected="selected">'.get_the_title().'</option>';
            }else{
                    $options_html.='<option value="'.get_the_ID().'">'.get_the_title().'</option>';
            }
                }else{
      
                        $options_html.='<option value="'.get_the_ID().'">'.get_the_title().'</option>';
      
                }
		
            }
        }
        wp_reset_postdata();
   // }
    wp_send_json(array('success'=>$success,'options_html'=>$options_html));
    die;
}

/**
 * Manage WooCommerce styles and scripts.
 *
 */
function grd_woocommerce_script_cleaner() {

    // Remove the generator tag
    remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );
    // Unless we're in the store, remove all the cruft!
    //if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
        wp_dequeue_style( 'woocommerce_frontend_styles' );
        wp_dequeue_style( 'woocommerce-general');
        wp_dequeue_style( 'woocommerce-layout' );
        wp_dequeue_style( 'woocommerce-smallscreen' );
        wp_dequeue_style( 'woocommerce_fancybox_styles' );
        wp_dequeue_style( 'woocommerce_chosen_styles' );
        wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
        wp_dequeue_style( 'select2' );
        wp_dequeue_script( 'wc-add-payment-method' );
        wp_dequeue_script( 'wc-lost-password' );
        wp_dequeue_script( 'wc_price_slider' );
        wp_dequeue_script( 'wc-single-product' );
        wp_dequeue_script( 'wc-add-to-cart' );
        wp_dequeue_script( 'select2' );
        wp_dequeue_script( 'wc-cart-fragments' );
        wp_dequeue_script( 'wc-credit-card-form' );
        wp_dequeue_script( 'wc-checkout' );
        wp_dequeue_script( 'wc-add-to-cart-variation' );
        wp_dequeue_script( 'wc-single-product' );
        wp_dequeue_script( 'wc-cart' );
        wp_dequeue_script( 'wc-chosen' );
        wp_dequeue_script( 'woocommerce' );
        wp_dequeue_script( 'prettyPhoto' );
        wp_dequeue_script( 'prettyPhoto-init' );
        wp_dequeue_script( 'jquery-blockui' );
        wp_dequeue_script( 'jquery-placeholder' );
        wp_dequeue_script( 'jquery-payment' );
        wp_dequeue_script( 'fancybox' );
        wp_dequeue_script( 'jqueryui' );

        wp_dequeue_style('sv-wc-payment-gateway-payment-form');
    //}
}
add_action( 'wp_enqueue_scripts', 'grd_woocommerce_script_cleaner', 99 );


/**
 * Manage WooCommerce billing fields
 *
 */
add_filter("woocommerce_checkout_fields", "order_fields");
function order_fields($fields){
    $order = array(
        "billing_first_name"=>__('Name', 'trainingcamp'),
        "billing_email"=>__('Email', 'trainingcamp'),
        "billing_phone"=>__('Phone', 'trainingcamp'),
        "billing_company"=>__('Company (if applicable)', 'trainingcamp'),
        "billing_address_1"=>__('Street Address', 'trainingcamp'),
        "billing_address_2"=>__('Address Line 2', 'trainingcamp'),
        "billing_city"=>__('City', 'trainingcamp'),
        "billing_state"=>__('State', 'trainingcamp'),
        "billing_postcode"=>__('ZipCode', 'trainingcamp'),
        "billing_country"=>__('Country', 'trainingcamp'),
        "payment_method"=>__('Method','trainingcamp')
    );
    $ordered_fields=array();
    foreach($order as $field=>$label) {
        $ordered_fields[$field] = $fields["billing"][$field];
    }
    $fields["billing"] = $ordered_fields;

    if((isset($_COOKIE['full_name']) && isset($_COOKIE['email']) && isset($_COOKIE['phone']))){
        $fields['billing']['billing_first_name']['default'] = $_COOKIE['full_name'];
        $fields['billing']['billing_email']['default'] = $_COOKIE['email'];
        $fields['billing']['billing_phone']['default'] = $_COOKIE['phone'];
        // $fields['billing']['billing_company']['default'] = $_COOKIE['company'];
        // $fields['billing']['billing_address_1']['default'] = $_COOKIE['billing_address_1'];
        // $fields['billing']['billing_address_2']['default'] = $_COOKIE['billing_address_2'];
        // $fields['billing']['billing_city']['default'] = $_COOKIE['billing_city'];
        // $fields['billing']['billing_state']['default'] = $_COOKIE['billing_state'];
        // $fields['billing']['billing_postcode']['default'] = $_COOKIE['billing_postcode'];
        // $fields['billing']['billing_country']['default'] = $_COOKIE['billing_country'];
    }

    return $fields;
}


/**
 * Edit checkout fields
 *
 */
require get_template_directory() . '/inc/checkout-fields.php';

/**
 * Hide Payment Description
 *
 */
add_filter('wc_authorize_net_aim_payment_form_description','stripe_description',20,1);
function stripe_description($description){
    return '';
}


/**
 * Change html attributes for checkout fields
 *
 */
add_filter('woocommerce_form_field_args','wc_form_field_args',10,3);
function wc_form_field_args( $args, $key, $value = null ) {
    /*$fields_ids=array(
        'billing_first_name',
        'billing_last_name',
        'billing_email',
        'billing_phone'
    );
    if((in_array($args['id'],$fields_ids))){
        $args['label'] ='';
        $args['type']='hidden';
    }*/

    $fields_ids_payment=array(
        'wc-authorize-net-aim-expiry',
        'wc-authorize-net-aim-account-number',
        'wc-authorize-net-aim-csc',

        'billing_first_name',
        'billing_email',
        'billing_phone',
        'billing_company',
        'billing_address_1',
        'billing_address_2',
        'billing_city',
        'billing_state',
        'billing_postcode',
        'billing_country',
        'payment_method'
    );

    if($args['id']=='billing_first_name') $args['label']='Name';

    if((in_array($args['id'],$fields_ids_payment))){
        $args['placeholder'] =$args['label'];
        //$args['label']='';
        $args['input_class'][]='form-control input-text';
        $args['class'][]='form-row-wide';
    }
    if($args['id']=='billing_city'){
        $args['class'][]='form-row-first';
    }

    if($args['id']=='billing_state'){
        $args['class'][]='form-row-last';
    }
    return $args;
}


/**
 * Show only error notices
 *
 */
add_filter('woocommerce_notice_types','notice_types');
function notice_types(){
    return array('error');
}


/**
 * Get product by Woo API
 *
 */
use Automattic\WooCommerce\Client;
use Automattic\WooCommerce\HttpClient\HttpClientException;
function get_product_by_api($product_id){
    try{
        $api = new Client(
            site_url(),
            'ck_6f84ad4e53e8f8abed95620f8d367752e0bf9c14',
            'cs_9b5636d55d0ad2d1d64a5afe84cc789ec82a7327',
            [
                'wp_api' => true,
                'version' => 'wc/v1',
            ]
        );
        wp_send_json(array('status'=>true,'response'=>$api->get('products/'.$product_id)));
    } catch( HttpClientException $e ){
        wp_send_json(array('status'=>false,'response'=>$e->getMessage()));
    }
}
add_action('wp_ajax_get_variations_by_post_id', 'get_variations_by_post_id');
add_action('wp_ajax_nopriv_get_variations_by_post_id', 'get_variations_by_post_id');
function get_variations_by_post_id(){
    $product_id=$_POST['post_id'];
    get_product_by_api($product_id);
    die;
}


/**
 * Add start_date for Order items in admin
 *
 */
add_action('woocommerce_after_order_itemmeta','additional_itemmeta');
function additional_itemmeta($item_id){
    $variation_id = wc_get_order_item_meta( $item_id, '_variation_id', true );
    $start_date=get_post_meta( $variation_id, '_start_date', true );
    if($start_date)
        echo '<table cellspacing="0" class="display_meta"><tbody><tr><th style="color: red">Start date:</th><td><p>'.$start_date.'</p></td></tr></tbody></table>';
}


/**
 * Get products by product category
 *
 */
function search_engine_query_string($url = false) {

    if(!$url && !$url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : false) {
        return '';
    }

    $parts_url = parse_url($url);
    $query = isset($parts_url['query']) ? $parts_url['query'] : (isset($parts_url['fragment']) ? $parts_url['fragment'] : '');
    if(!$query) {
        return '';
    }
    parse_str($query, $parts_query);
    return isset($parts_query['q']) ? $parts_query['q'] : (isset($parts_query['p']) ? $parts_query['p'] : '');

}

add_action('wp_ajax_show_details', 'show_details');
add_action('wp_ajax_nopriv_show_details', 'show_details');
function show_details(){
     parse_str($_POST['data'], $data);
     
        if (isset($data['noreq']) && $data['noreq']=='yes')
            wp_send_json(array('success'=>true));

    if ($data && is_array($data) && count($data)>0) {
        
        /*if (isset($data['noreq']) && $data['noreq']=='yes')
            wp_send_json(array('success'=>true));*/

        $required_fields=array(
           'full_name', 'email', 'phone', 'user_ip', 'from_cookies', 'noreq', 'products'
        );
        


        foreach($required_fields as $key){
            if (empty($data[$key])){
                wp_send_json(array('success'=>false));
            }
        }

        $product_id=$data['products'];
        $product=wc_get_product($product_id);
        if (!is_object($product)){
            wp_send_json(array('success'=>false));
        }
        
        $product_name=$product->get_name();

        $output = str_replace(array('http://','https://','www.'), '',site_url());
        $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

        $headers = "From: ".$blogname." <noreply@".$output.">";
        
        $message = sprintf(__('Date of Request: %s'),$data['date_of_request']). "\r\n\r\n";
        $message .= sprintf(__('Name: %s'), $data['full_name']) . "\r\n\r\n";
        $message .= sprintf(__('Email: %s'), $data['email']) . "\r\n\r\n";
        $message .= sprintf(__('Email2: %s'), $data['email']) . "\r\n\r\n";
        $message .= sprintf(__('Tel: %s'), $data['phone']) . "\r\n\r\n";
        //$message .= sprintf(__('KValue: %s'), $data['kvalue']) . "\r\n\r\n";
        $message .= sprintf(__('Course Name: %s'),$product_name) . "\r\n\r\n";
        $message .= sprintf(__('Course: %s'),$product->get_sku()) . "\r\n\r\n";
        $message .= sprintf(__('HTTP_REFERER: %s'), $_SERVER['HTTP_REFERER']) . "\r\n\r\n";
        $message .= sprintf(__('SearchQueryString: %s'), $_SERVER['search_engine_query_string']) . "\r\n\r\n";      
        
        

        // $subject=(isset($data['from_cookies']) && $data['from_cookies']=='yes') ? $product_name.' - LOCCHECK' : '!Registration - '.$product_name.' - '.$data['full_name'];
        $subject = "LOCCHECK ".$data['full_name'];
        // $email_to=(get_field('pricing_emails_request',$pricing_page_id)) ? get_field('pricing_emails_request',$pricing_page_id) : get_option('admin_email');
        
         $variation = new WC_Product_Variation($data['variation_id']);
            if ($variation){
                $var_names=array();
                foreach($variation->get_variation_attributes() as $name => $attr) {
                    $name = substr($name, 10);
                    $var_names[]= $variation->get_attribute($name);
                }
                $var_names = implode('; ',$var_names);
                $start_date=get_post_meta( $data['variation_id'], '_start_date', true );
                $message .= sprintf(__('Location: %s'),$var_names) . "\r\n\r\n";
                $message .= sprintf(__('ClassStartDate: %s'),$start_date) . "\r\n\r\n";
                
            }
            $message .= sprintf(__('IP: %s'), $data['user_ip']) . "\r\n\r\n";
        
        $email_to = array('sunderrajanr@mavinapps.com', 
         'goldmine@trainingcamp.com', 'ttcwebsiteemail@gmail.com', 
         'tcsharedmailbox@trainingcamp.com', 'mmcnelis@trainingcamp.com',
          'ttcenroll@gmail.com');
         //if (wp_mail($email_to, $subject, $message, $headers)){
                       
             
             wp_mail($email_to, $subject, $message, $headers);
             wp_send_json(array('success'=>true));
         // }else{
         //     wp_send_json(array('success'=>false));
         // }
    }

}

/**
 * Get products by product category
 *
 */
add_action('wp_ajax_register_request', 'register_request');
add_action('wp_ajax_nopriv_register_request', 'register_request');
function register_request(){
     parse_str($_POST['data'], $data);

setcookie("full_name",$data['full_name'],strtotime('+1 year'), '/', $_SERVER['HTTP_HOST']);
setcookie("email",$data['email'],strtotime('+1 year'), '/', $_SERVER['HTTP_HOST']);
setcookie("phone",$data['phone'],strtotime('+1 year'), '/', $_SERVER['HTTP_HOST']);

    if ($data && is_array($data) && count($data)>0) {
        
        /*if (isset($data['noreq']) && $data['noreq']=='yes')
            wp_send_json(array('success'=>true));*/

        $required_fields=array(
           'full_name', 'email', 'phone', 'user_ip', 'from_cookies', 'noreq', 'products'
        );


        foreach($required_fields as $key){
            if (empty($data[$key])){
                wp_send_json(array('success'=>false));
            }
        }

        $product_id=$data['products'];
        $product=wc_get_product($product_id);
        if (!is_object($product)){
            wp_send_json(array('success'=>false));
        }
        
        $product_name=$product->get_name();

        $output = str_replace(array('http://','https://','www.'), '',site_url());
        $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

        $headers = "From: ".$blogname." <noreply@".$output.">";

        $message = sprintf(__('Name: %s'), $data['full_name']) . "\r\n\r\n";
        $message .= sprintf(__('Email: %s'), $data['email']) . "\r\n\r\n";
        $message .= sprintf(__('Tel: %s'), $data['phone']) . "\r\n\r\n";
        $message .= sprintf(__('IP: %s'), $data['user_ip']) . "\r\n\r\n";
        //$message .= sprintf(__('KValue: %s'), $data['kvalue']) . "\r\n\r\n";
        //$message .= sprintf(__('User IP: %s'), $data['user_ip']) . "\r\n\r\n";
        $message .= sprintf(__('Course Name: %s'),$variation->get_sku()) . "\r\n\r\n";

        // $subject=(isset($data['from_cookies']) && $data['from_cookies']=='yes') ? $product_name.' - LOCCHECK' : '!Registration - '.$product_name.' - '.$data['full_name'];
        $subject = "!Pricing Request " . $data['full_name'];
        // $email_to=(get_field('pricing_emails_request',$pricing_page_id)) ? get_field('pricing_emails_request',$pricing_page_id) : get_option('admin_email');
        $email_to = array('sunderrajanr@mavinapps.com', 
         'goldmine@trainingcamp.com', 'ttcwebsiteemail@gmail.com', 
         'tcsharedmailbox@trainingcamp.com', 'mmcnelis@trainingcamp.com',
          'ttcenroll@gmail.com');
         //if (wp_mail($email_to, $subject, $message, $headers)){
            
             setcookie("full_name",$data['full_name'],strtotime('+1 year'), '/', $_SERVER['HTTP_HOST']);
             setcookie("email",$data['email'],strtotime('+1 year'), '/', $_SERVER['HTTP_HOST']);
             setcookie("phone",$data['phone'],strtotime('+1 year'), '/', $_SERVER['HTTP_HOST']);
             
             wp_mail($email_to, $subject, $message, $headers);
             wp_send_json(array('success'=>true));
         // }else{
         //     wp_send_json(array('success'=>false));
         // }
    }

}

/*
 * Get State list based on country code
 *
*/

add_action('wp_ajax_checkout_states', 'checkout_states');
add_action('wp_ajax_nopriv_checkout_states', 'checkout_states');
function checkout_states(){
    parse_str($_POST['data'], $data);    
    if ($data && is_array($data) && count($data)>0) {
        $countries_obj = new WC_Countries();
        $countries_array = $countries_obj->get_countries();
        $country_states_array = $countries_obj->get_states();
        // Get the state array:
        $state_array = $country_states_array[$data['countrycode']];
        wp_send_json(array('success'=>true,'states'=>$state_array, 'coutnry_state'=>$country_states_array));
    }
}


/**
 * Get products by product category
 *
 */
add_action('wp_ajax_pricing_request', 'pricing_request');
add_action('wp_ajax_nopriv_pricing_request', 'pricing_request');
function pricing_request(){
    parse_str($_POST['data'], $data);
    if ($data && is_array($data) && count($data)>0) {
        
        if (isset($data['noreq']) && $data['noreq']=='yes')
            wp_send_json(array('success'=>true));

        $required_fields=array(
           'full_name', 'email', 'phone', 'user_ip', 'from_cookies', 'noreq', 'products'
        );


        foreach($required_fields as $key){
            if (empty($data[$key])){
                wp_send_json(array('success'=>false));
            }
        }

        $product_id=$data['products'];
        $product=wc_get_product($product_id);
        if (!is_object($product)){
            wp_send_json(array('success'=>false,'ss'));
        }

        $pricing_page_id=get_page_ID_by_page_template('templates/pricing.php');

        $product_name=$product->get_name();

        $output = str_replace(array('http://','https://','www.'), '',site_url());
        $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

        $headers = "From: ".$blogname." <noreply@".$output.">";
        //$headers = "From: TrainingCamp <noreply@".$output.">";

        $message = sprintf(__('Student Name: %s'), $data['full_name']) . "\r\n\r\n";
        $message .= sprintf(__('Student Email: %s'), $data['email']) . "\r\n\r\n";
        $message .= sprintf(__('Student Day Phone: %s'), $data['phone']) . "\r\n\r\n";
        //$message .= sprintf(__('KValue: %s'), $data['kvalue']) . "\r\n\r\n";
        //$message .= sprintf(__('User IP: %s'), $data['user_ip']) . "\r\n\r\n";
        $message .= sprintf(__('Course Name: %s'),$product_name) . "\r\n\r\n";


        if(isset($data['variation_id']) && !empty($data['variation_id'])){
            $variation = new WC_Product_Variation($data['variation_id']);
            if ($variation){
                $var_names=array();
                foreach($variation->get_variation_attributes() as $name => $attr) {
                    $name = substr($name, 10);
                    $var_names[]= $variation->get_attribute($name);
                }
                $var_names = implode('; ',$var_names);
                $start_date=get_post_meta( $data['variation_id'], '_start_date', true );
                $message .= sprintf(__('Location: %s'),$var_names) . "\r\n\r\n";
                $message .= sprintf(__('Start date: %s'),$start_date) . "\r\n\r\n";
            }

            //$email_to=(get_field('pricing_emails_add_to_cart',$pricing_page_id)) ? get_field('pricing_emails_add_to_cart',$pricing_page_id) : get_option('admin_email');
            $email_to = array('sunderrajanr@mavinapps.com', 
            'goldmine@trainingcamp.com', 'ttcwebsiteemail@gmail.com', 
            'tcsharedmailbox@trainingcamp.com', 'mmcnelis@trainingcamp.com',
             'ttcenroll@gmail.com');
            $subject=$product_name.' - Add to cart - '.$data['full_name'];
            if (wp_mail($email_to, $subject, $message, $headers)){
                wp_send_json(array('success'=>true));
               // wp_mail($email_to, $subject, $message, $headers);
            }else{
                wp_send_json(array('success'=>false));
            }

        }else{
        
        $message = sprintf(__('Date of Request: %s'),$data['date_of_request']) . "\r\n\r\n";    
        $message .= sprintf(__('Name: %s'), $data['full_name']) . "\r\n\r\n";
        $message .= sprintf(__('Email: %s'), $data['email']) . "\r\n\r\n";
        $message .= sprintf(__('Email2: %s'), $data['email']) . "\r\n\r\n";
        $message .= sprintf(__('Tel: %s'), $data['phone']) . "\r\n\r\n";
        $message .= sprintf(__('Course: %s'),$product->get_sku()) . "\r\n\r\n";
        $message .= sprintf(__('IP: %s'), $data['user_ip']) . "\r\n\r\n";
        $message .= sprintf(__('HTTP_REFERER: %s'), $_SERVER['HTTP_REFERER']) . "\r\n\r\n";
        $message .= sprintf(__('SearchQueryString: %s'), $_SERVER['search_engine_query_string']) . "\r\n\r\n";
        
        

           // $subject=(isset($data['from_cookies']) && $data['from_cookies']=='yes') ? $product_name.' - LOCCHECK' : '!Registration - '.$product_name.' - '.$data['full_name'];
            $subject = "Pricing Request ".$data['full_name'];
           // $email_to=(get_field('pricing_emails_request',$pricing_page_id)) ? get_field('pricing_emails_request',$pricing_page_id) : get_option('admin_email');
           $email_to = array('sunderrajanr@mavinapps.com', 
            'goldmine@trainingcamp.com', 'ttcwebsiteemail@gmail.com', 
            'tcsharedmailbox@trainingcamp.com', 'mmcnelis@trainingcamp.com',
             'ttcenroll@gmail.com');
            if (wp_mail($email_to, $subject, $message, $headers)){
               // setcookie("full_name",$data['full_name'],strtotime('+1 year'), '/', $_SERVER['HTTP_HOST']);
               // setcookie("email",$data['email'],strtotime('+1 year'), '/', $_SERVER['HTTP_HOST']);
               // setcookie("phone",$data['phone'],strtotime('+1 year'), '/', $_SERVER['HTTP_HOST']);
			    setcookie("full_name",$data['full_name'],strtotime('+1 year'), '/', $_SERVER['HTTP_HOST']);
                setcookie("email",$data['email'],strtotime('+1 year'), '/', $_SERVER['HTTP_HOST']);
                setcookie("phone",$data['phone'],strtotime('+1 year'), '/', $_SERVER['HTTP_HOST']);
                wp_send_json(array('success'=>true));
                //wp_mail($email_to, $subject, $message, $headers);
            }else{
                wp_send_json(array('success'=>false));
            }

        }


    }else{
        wp_send_json(array('success'=>false));
    }
    die;
}
