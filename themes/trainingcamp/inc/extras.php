<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package trainingcamp
 */

add_filter('show_admin_bar', '__return_false');

function per_pages(){
    return array(2,4,6);
}


/**
 * Add acf options page
 *
 */
if( function_exists('acf_add_options_page') ) {

    acf_add_options_page();

}


/**
 * Get first page ID by page template
 *
 */
function get_page_ID_by_page_template($template_name){
    global $wpdb;
    $page_ID = $wpdb->get_var("SELECT post_id FROM $wpdb->postmeta WHERE meta_value = '$template_name' AND meta_key = '_wp_page_template'");
    return $page_ID;
}


/**
 * get_template_part with params
 *
 */
function hm_get_template_part( $file, $template_args = array(), $cache_args = array() ) {
    $template_args = wp_parse_args( $template_args );
    $cache_args = wp_parse_args( $cache_args );
    if ( $cache_args ) {
        foreach ( $template_args as $key => $value ) {
            if ( is_scalar( $value ) || is_array( $value ) ) {
                $cache_args[$key] = $value;
            } else if ( is_object( $value ) && method_exists( $value, 'get_id' ) ) {
                $cache_args[$key] = call_user_method( 'get_id', $value );
            }
        }
        if ( ( $cache = wp_cache_get( $file, serialize( $cache_args ) ) ) !== false ) {
            if ( ! empty( $template_args['return'] ) )
                return $cache;
            echo $cache;
            return;
        }
    }
    $file_handle = $file;
    do_action( 'start_operation', 'hm_template_part::' . $file_handle );
    if ( file_exists( get_stylesheet_directory() . '/' . $file . '.php' ) )
        $file = get_stylesheet_directory() . '/' . $file . '.php';
    elseif ( file_exists( get_template_directory() . '/' . $file . '.php' ) )
        $file = get_template_directory() . '/' . $file . '.php';
    ob_start();
    $return = require( $file );
    $data = ob_get_clean();
    do_action( 'end_operation', 'hm_template_part::' . $file_handle );
    if ( $cache_args ) {
        wp_cache_set( $file, $data, serialize( $cache_args ), 3600 );
    }
    if ( ! empty( $template_args['return'] ) )
        if ( $return === false )
            return false;
        else
            return $data;
    echo $data;
}


/**
 * Template redirect
 *
 */
add_action( 'template_redirect', 'wp_redirect_post' );
function wp_redirect_post() {
    if(is_singular('testimonials') || is_post_type_archive('testimonials') || is_tax('product_tag') || is_post_type_archive('jobs') || is_singular('jobs') || is_tag() || is_author() || is_category()){
        wp_redirect( home_url(), 301 );
        exit;
    }
    if(is_shop()){
        wp_redirect( get_term_link(12), 301 );
        exit;
    }
}


/**
 * Allow SVG through WordPress Media Uploader
 *
 */
add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {
    global $wp_version;
    if( $wp_version == '4.7' || ( (float) $wp_version < 4.7 ) ) { return $data; }
    $filetype = wp_check_filetype( $filename, $mimes );
    return [ 'ext' => $filetype['ext'], 'type' => $filetype['type'], 'proper_filename' => $data['proper_filename'] ];
}, 10, 4 );

function cc_mime_types( $mimes ){
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );


/**
 * Get post_excerpt by post_id
 *
 */
function custom_get_the_excerpt($post_id) {
    global $post;
    $save_post = $post;
    $post = get_post($post_id);
    $output = get_the_excerpt();
    $post = $save_post;
    return $output;
}


/**
 * Check parent terms of Products categories
 *
 */
add_action('save_post', 'assign_parent_terms', 10, 2);
function assign_parent_terms($post_id, $post){
    $arrayPostTypeAllowed = array('product');
    $arrayTermsAllowed = array('product_cat');

    //Check post type
    if(!in_array($post->post_type, $arrayPostTypeAllowed)){

        return $post_id;

    }else{

        // get all assigned terms
        foreach($arrayTermsAllowed AS $t_name){
            $terms = wp_get_post_terms($post_id, $t_name );
            if (count($terms)>0){
                foreach($terms as $term){

                    while($term->parent != 0 && !has_term( $term->parent, $t_name, $post )){

                        // move upward until we get to 0 level terms
                        wp_set_post_terms($post_id, array($term->parent), $t_name, true);
                        $term = get_term($term->parent, $t_name);
                    }
                }
            }
        }

    }
}


/**
 * Get products ids where variations is guaranteed
 *
 */
function get_products_with_guaranteed_variations(){
    global $wpdb;
    $guaranteed_variations = $wpdb->get_results( "
		SELECT DISTINCT post.post_parent FROM `$wpdb->posts` AS post
		INNER JOIN `$wpdb->postmeta` as meta ON ( post.ID = meta.post_id )
		WHERE 1=1
		AND ( ( meta.meta_key = '_guarant' AND meta.meta_value LIKE '%yes%' ) )
		AND post.post_type = 'product_variation'
		AND (post.post_status = 'publish' OR post.post_status = 'private')
		GROUP BY post.ID ORDER BY post.post_date DESC
	" );
    $guaranteed_variations=wp_list_pluck( $guaranteed_variations, 'post_parent' );
    return $guaranteed_variations;
}


/**
 * Get products ids where variations is sold_out
 *
 */
function get_products_with_sold_out_variations(){
    global $wpdb;
    $sold_out_variations = $wpdb->get_results( "
		SELECT DISTINCT post.post_parent FROM `$wpdb->posts` AS post
		INNER JOIN `$wpdb->postmeta` as meta ON ( post.ID = meta.post_id )
		WHERE 1=1
		AND ( ( meta.meta_key = '_soldOut' AND meta.meta_value LIKE '%yes%' ) )
		AND post.post_type = 'product_variation'
		AND (post.post_status = 'publish' OR post.post_status = 'private')
		GROUP BY post.ID ORDER BY post.post_date DESC
	" );
    $sold_out_variations=wp_list_pluck( $sold_out_variations, 'post_parent' );
    return $sold_out_variations;
}





/**
 * Change standard queries
 *
 */
add_action('pre_get_posts', 'change_query');
function change_query($query)
{
    if ( $query->is_main_query() && !is_admin()){

        if(is_tax('product_cat')){
            $query->set( 'posts_per_page', 5000);
            $query->set( 'orderby', 'modified');
            $query->set( 'order', 'DESC');
            $sale_products_ids=wc_get_product_ids_on_sale();
            $query->set( 'post__not_in', $sale_products_ids);
            //Filtering in Course Group
            $checked_cats=(isset($_GET['category'])) ? $_GET['category'] : '';
            $checked_cats=($checked_cats) ? explode(",", $checked_cats) : array();
            if(count($checked_cats)>0){
                $query->set
                (
                    'tax_query', array(
                        array(
                            'taxonomy' => 'product_tag',
                            'field'   => 'slug',
                            'terms'    => $checked_cats
                        )
                    )
                );
            }
        }


        if(is_search()){
            if (isset($_GET['per-page']) && in_array($_GET['per-page'],per_pages()))
                $query->set( 'posts_per_page', $_GET['per-page']);
            else
                $query->set( 'posts_per_page', 20);

            //Filtering by SPECIAL OFFERS(product with sale), GUARANTEED TO RUN (meta field on variation)
            if(isset($_GET['special']) && $_GET['special']=='on' && (!isset($_GET['guaranteed']) || $_GET['guaranteed']!='on') ){
                $sale_products_ids=wc_get_product_ids_on_sale();
                $query->set( 'post__in', $sale_products_ids);
            }
            if(isset($_GET['guaranteed']) && $_GET['guaranteed']=='on' && (!isset($_GET['special']) || $_GET['special']!='on') ){
                $guaranteed_variations=get_products_with_guaranteed_variations();
                $query->set( 'post__in', $guaranteed_variations);
            }
            if(isset($_GET['special']) && $_GET['special']=='on' && isset($_GET['guaranteed']) && $_GET['guaranteed']=='on'){
                $res=array();
                $sale_products_ids=wc_get_product_ids_on_sale();
                $guaranteed_variations=get_products_with_guaranteed_variations();
                if (count($sale_products_ids)>0 && count($guaranteed_variations)>0){
                    $res=array_intersect($sale_products_ids,$guaranteed_variations);
                }elseif(count($sale_products_ids)>0){
                    $res=$sale_products_ids;
                }elseif(count($guaranteed_variations)>0){
                    $res=$guaranteed_variations;
                }
                $query->set( 'post__in', $res);
            }
            
            //Filtering by SPECIAL OFFERS(product with sale), Sold Out (meta field on variation)
             if(isset($_GET['special']) && $_GET['special']=='on' && (!isset($_GET['sold_out']) || $_GET['sold_out']!='on') ){
                $sale_products_ids=wc_get_product_ids_on_sale();
                $query->set( 'post__in', $sale_products_ids);
            }
            if(isset($_GET['sold_out']) && $_GET['sold_out']=='on' && (!isset($_GET['special']) || $_GET['special']!='on') ){
                $sold_out_variations=get_products_with_sold_out_variations();
                $query->set( 'post__in', $sold_out_variations);
            }
            if(isset($_GET['special']) && $_GET['special']=='on' && isset($_GET['sold_out']) && $_GET['sold_out']=='on'){
                $res=array();
                $sale_products_ids=wc_get_product_ids_on_sale();
                $sold_out_variations=get_products_with_sold_out_variations();
                if (count($sale_products_ids)>0 && count($sold_out_variations)>0){
                    $res=array_intersect($sale_products_ids,$sold_out_variations);
                }elseif(count($sale_products_ids)>0){
                    $res=$sale_products_ids;
                }elseif(count($sold_out_variations)>0){
                    $res=$sold_out_variations;
                }
                $query->set( 'post__in', $res);
            }
        }

    }
}


/**
 * Login by email
 *
 */
//remove_filter( 'authenticate', 'wp_authenticate_username_password', 20, 3 );
//add_filter( 'authenticate', 'custom_authenticate', 20, 3 );
function custom_authenticate($user, $username, $password){
    if ( is_a( $user, 'WP_User' ) ) {
        return $user;
    }
    if ( ! empty( $username ) && is_email( $username ) ) {
        $user = get_user_by( 'email', $username );
        if ( isset( $user, $user->user_login, $user->user_status ) ) {
            if ( 0 === intval( $user->user_status ) ) {
                $username = $user->user_login;
                return wp_authenticate_username_password( null, $username, $password );
            }
        }
    }
    if ( ! empty( $username ) || ! empty( $password ) ) {
        return false;
    } else {
        return wp_authenticate_username_password( null, "", "" );
    }
}


/**
 * Show errors by ajax
 *
 */
function check_errors($errors){
    if ( $errors->get_error_code() ){
        $errors_response=array();
        foreach($errors->errors as $error_type){
            $errors_response[]=$error_type[0];
        }
        $errors_text='<ul class="list-errors">';
        foreach($errors_response as $error){
            $errors_text.='<li>'.$error.'</li>';
        }
        $errors_text.='</ul>';
        wp_send_json(array('loggedin'=>false,'message'=>$errors_text));
    }
}


/**
 * Login user
 *
 */
function auth_user_login($user_login, $password,$remember='on', $login)
{
    $info = array();
    $info['user_login'] = $user_login;
    $info['user_password'] = $password;
    $info['remember'] =($remember=='on') ? true : false;

    $user_signon = wp_signon( $info, false );
    if ( is_wp_error($user_signon) ){
        wp_send_json(array('loggedin'=>false, 'message'=>__('Wrong username or password.')));
    } else {
        wp_set_current_user($user_signon->ID);
        wp_send_json(array('loggedin'=>true, 'message'=>__($login.' successful, redirecting...')));
    }

    die();
}
function submit_login(){
    parse_str($_POST['data'], $data);
    if ($data && is_array($data) && count($data)>0) {
        $errors = new WP_Error();
        $wp_nonce=$data['form-login'];
        if (!wp_verify_nonce($wp_nonce, 'ajax-login-nonce' ) ){
            $errors->add('not_verify_nonce','Failed security check');
            check_errors($errors);
        }else{
            auth_user_login($data['username'], $data['password'],'on', 'Login');
        }
    }
    die;
}
add_action('wp_ajax_submit_login', 'submit_login');
add_action('wp_ajax_nopriv_submit_login', 'submit_login');


/**
 * Forgot password
 *
 */
add_action( 'wp_ajax_nopriv_ajaxforgotpassword', 'ajax_forgotPassword' );
add_action( 'wp_ajax_ajaxforgotpassword', 'ajax_forgotPassword' );
function ajax_forgotPassword(){

    // First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-forgot-nonce', 'security' );

    global $wpdb;

    $account = $_POST['user_login'];

    if( empty( $account ) ) {
        $error = 'Enter an username or e-mail address.';
    } else {
        if(is_email( $account )) {
            if( email_exists($account) )
                $get_by = 'email';
            else
                $error = 'There is no user registered with that email address.';
        }
        else if (validate_username( $account )) {
            if( username_exists($account) )
                $get_by = 'login';
            else
                $error = 'There is no user registered with that username.';
        }
        else
            $error = 'Invalid username or e-mail address.';
    }

    if(empty ($error)) {
        // lets generate our new password
        //$random_password = wp_generate_password( 12, false );
        $random_password = wp_generate_password();


        // Get user data by field and data, fields are id, slug, email and login
        $user = get_user_by( $get_by, $account );

        $update_user = wp_update_user( array ( 'ID' => $user->ID, 'user_pass' => $random_password ) );

        // if  update user return true then lets send user an email containing the new password
        if( $update_user ) {
            $output = str_replace(array('http://','https://','www.'), '',site_url());
            $from = 'noreply@'.$output; // Set whatever you want like mail@yourdomain.com

            $to = $user->user_email;
            $subject = 'Your new password';
            $sender = 'From: TrainingCamp <'.$from.'>' . "\r\n";

            $message = 'Your new password is: '.$random_password;

            $headers[] = 'MIME-Version: 1.0' . "\r\n";
            $headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers[] = "X-Mailer: PHP \r\n";
            $headers[] = $sender;

            $mail = wp_mail( $to, $subject, $message, $headers );
            if( $mail )
                $success = 'Check your email address for you new password.';
            else
                $error = 'System is unable to send you mail containg your new password.';
        } else {
            $error = 'Oops! Something went wrong while updaing your account.';
        }
    }

    if( ! empty( $error ) )
        echo json_encode(array('loggedin'=>false, 'message'=>__($error)));

    if( ! empty( $success ) )
        echo json_encode(array('loggedin'=>false, 'message'=>__($success)));

    die();
}


/**
 * Registration
 *
 */
function submit_form(){

    $posted_data =  isset( $_POST ) ? $_POST : array();
    $file_data = isset( $_FILES ) ? $_FILES : array();

    $data = array_merge( $posted_data, $file_data );

    if ($data && is_array($data) && count($data)>0) {
        $user_meta_boxes=array(
            'billing_phone'
        );

        $required_fields=array(
            'first_name',
            'last_name',
            'user_email',
            'user_pass',
            'user_pass_confirmation',
        );


        $errors = new WP_Error();
        $wp_nonce=$data['_wpnonce'];
        if (!wp_verify_nonce($wp_nonce, 'form_registration' ) ){
            $errors->add('not_verify_nonce','Failed security check');
            check_errors($errors);
        }else{

            foreach($required_fields as $key){
                if (empty($data[$key])){
                    $errors->add('empty_field','Please enter all required fields');
                }
            }
            check_errors($errors);
            foreach ($data as $key => $value) {
                if (!empty($value)){
                    switch ($key) {
                        case 'user_email':
                            if (!is_email($value)) {
                                $errors->add('invalid_user_email', 'Account email address is not correct.');
                            } elseif (email_exists($value)) {
                                $errors->add('user_email_exists', 'You email address is already registered, please choose another one.');
                            }
                            break;
                    }
                }
            }
            if (!empty($data['user_pass']) && !empty($data['user_pass_confirmation'])){
                $pass=$data['user_pass'];
                $pass_confirm=$data['user_pass_confirmation'];
                if (strlen($pass)<8){
                    $errors->add('short_pass', 'Your password must contain at least 8 characters.');
                }elseif($pass<>$pass_confirm){
                    $errors->add('pass_not_confirm', 'Password do not match');
                }
            }
            check_errors($errors);

            $username = sanitize_user( current( explode( '@', $data['user_email'] ) ), true );
            $append     = 1;
            $o_username = $username;
            while ( username_exists( $username ) ) {
                $username = $o_username . $append;
                $append ++;
            }

            $user_id = wp_insert_user( array ('first_name' => apply_filters('pre_user_first_name', $data['first_name']), 'last_name' => apply_filters('pre_user_last_name', $data['last_name']), 'user_pass' => apply_filters('pre_user_user_pass', $data['user_pass']), 'user_login' => apply_filters('pre_user_user_login', $username), 'user_email' => apply_filters('pre_user_user_email', $data['user_email']), 'role' => 'customer' ) );

            if( is_wp_error($user_id) ) {
                $errors->add('user_create_error', 'Error on user creation.');
                check_errors($errors);
            } else {
                do_action('user_register', $user_id);
                foreach($user_meta_boxes as $user_meta){
                    update_user_meta( absint( $user_id ), $user_meta, wp_kses_post( $data[$user_meta] ) );
                }

                update_user_meta( absint( $user_id ), 'billing_first_name', wp_kses_post( $data['first_name'] ) );
                update_user_meta( absint( $user_id ), 'billing_last_name', wp_kses_post( $data['last_name'] ) );

                wp_new_user_notification($user_id, $data['user_pass']);

                auth_user_login($data['user_email'], $data['user_pass'],'on','Registration');

            }

        }
    }

    die;
}
add_action('wp_ajax_submit_form', 'submit_form');
add_action('wp_ajax_nopriv_submit_form', 'submit_form');


/**
 * Logout
 *
 */
add_action('wp_ajax_custom_ajax_logout', 'custom_ajax_logout_func');
function custom_ajax_logout_func(){
    check_ajax_referer( 'ajax-logout-nonce', 'ajaxsecurity' );
    wp_clear_auth_cookie();
    wp_logout();
    ob_clean(); // probably overkill for this, but good habit
    wp_die();
}

/**
 * Remove Contact Form 7 styles
 *
 */
add_action( 'wp_enqueue_scripts', 'ac_remove_cf7_scripts' );
function ac_remove_cf7_scripts() {
    wp_deregister_style( 'contact-form-7' );
}


/**
 * Reinit Contact Form 7 fields handler
 *
 */
remove_action( 'wpcf7_init', 'wpcf7_add_form_tag_text' );
add_action( 'wpcf7_init', 'wpcf7_add_form_tag_text_clone' );
function wpcf7_add_form_tag_text_clone() {
    wpcf7_add_form_tag(
        array( 'text', 'text*', 'email', 'email*', 'url', 'url*', 'tel', 'tel*' ),
        'wpcf7_text_form_tag_handler_clone', true );
}
function wpcf7_text_form_tag_handler_clone( $tag ) {
    $tag = new WPCF7_FormTag( $tag );

    if ( empty( $tag->name ) ) {
        return '';
    }

    $validation_error = wpcf7_get_validation_error( $tag->name );

    $class = wpcf7_form_controls_class( $tag->type, 'wpcf7-text' );

    if ( in_array( $tag->basetype, array( 'email', 'url', 'tel' ) ) ) {
        $class .= ' wpcf7-validates-as-' . $tag->basetype;
    }

    if ( $validation_error ) {
        $class .= ' wpcf7-not-valid';
    }

    $atts = array();

    $atts['size'] = $tag->get_size_option( '40' );
    $atts['maxlength'] = $tag->get_maxlength_option();
    $atts['minlength'] = $tag->get_minlength_option();

    if ( $atts['maxlength'] && $atts['minlength']
        && $atts['maxlength'] < $atts['minlength'] ) {
        unset( $atts['maxlength'], $atts['minlength'] );
    }

    $atts['class'] = $tag->get_class_option( $class );
    $atts['id'] = $tag->get_id_option();
    $atts['tabindex'] = $tag->get_option( 'tabindex', 'int', true );

    $atts['autocomplete'] = $tag->get_option( 'autocomplete',
        '[-0-9a-zA-Z]+', true );

    if ( $tag->has_option( 'readonly' ) ) {
        $atts['readonly'] = 'readonly';
    }

    if ( $tag->is_required() ) {
        $atts['aria-required'] = 'true';
    }

    $atts['aria-invalid'] = $validation_error ? 'true' : 'false';

    $value = (string) reset( $tag->values );

    if ( $tag->has_option( 'placeholder' ) || $tag->has_option( 'watermark' ) ) {
        $atts['placeholder'] = $value;
        $value = '';
    }

    $value = $tag->get_default_option( $value );

    $value = wpcf7_get_hangover( $tag->name, $value );

    $atts['value'] = $value;

    if ( wpcf7_support_html5() ) {
        $atts['type'] = $tag->basetype;
    } else {
        $atts['type'] = 'text';
    }

    $atts['name'] = $tag->name;


    $label_text=$atts['placeholder'];
    $label_for=$atts['id'];

    $atts = wpcf7_format_atts( $atts );


    $html = sprintf(
        '<span class="wpcf7-form-control-wrap %1$s"><input %2$s /><label for="'.$label_for.'">'.$label_text.'</label>%3$s</span>',
        sanitize_html_class( $tag->name ), $atts, $validation_error );

    return $html;
}

remove_action( 'wpcf7_init', 'wpcf7_add_form_tag_textarea' );
add_action( 'wpcf7_init', 'wpcf7_add_form_tag_textarea_clone' );
function wpcf7_add_form_tag_textarea_clone() {
    wpcf7_add_form_tag( array( 'textarea', 'textarea*' ),
        'wpcf7_textarea_form_tag_handler_clone', true );
}
function wpcf7_textarea_form_tag_handler_clone( $tag ) {
    $tag = new WPCF7_FormTag( $tag );

    if ( empty( $tag->name ) ) {
        return '';
    }

    $validation_error = wpcf7_get_validation_error( $tag->name );

    $class = wpcf7_form_controls_class( $tag->type );

    if ( $validation_error ) {
        $class .= ' wpcf7-not-valid';
    }

    $atts = array();

    $atts['cols'] = $tag->get_cols_option( '40' );
    $atts['rows'] = $tag->get_rows_option( '10' );
    $atts['maxlength'] = $tag->get_maxlength_option();
    $atts['minlength'] = $tag->get_minlength_option();

    if ( $atts['maxlength'] && $atts['minlength'] && $atts['maxlength'] < $atts['minlength'] ) {
        unset( $atts['maxlength'], $atts['minlength'] );
    }

    $atts['class'] = $tag->get_class_option( $class );
    $atts['id'] = $tag->get_id_option();
    $atts['tabindex'] = $tag->get_option( 'tabindex', 'int', true );

    $atts['autocomplete'] = $tag->get_option( 'autocomplete',
        '[-0-9a-zA-Z]+', true );

    if ( $tag->has_option( 'readonly' ) ) {
        $atts['readonly'] = 'readonly';
    }

    if ( $tag->is_required() ) {
        $atts['aria-required'] = 'true';
    }

    $atts['aria-invalid'] = $validation_error ? 'true' : 'false';

    $value = empty( $tag->content )
        ? (string) reset( $tag->values )
        : $tag->content;

    if ( $tag->has_option( 'placeholder' ) || $tag->has_option( 'watermark' ) ) {
        $atts['placeholder'] = $value;
        $value = '';
    }

    $value = $tag->get_default_option( $value );

    $value = wpcf7_get_hangover( $tag->name, $value );

    $atts['name'] = $tag->name;

    $label_text=$atts['placeholder'];
    $label_for=$atts['id'];
    $atts = wpcf7_format_atts( $atts );

    $html = sprintf(
        '<span class="wpcf7-form-control-wrap %1$s"><textarea %2$s>%3$s</textarea><label for="'.$label_for.'">'.$label_text.'</label>%4$s</span>',
        sanitize_html_class( $tag->name ), $atts,
        esc_textarea( $value ), $validation_error );

    return $html;
}


/**
 * Change query for relationship product on New Courses/Special offers
 *
 */
add_filter('acf/fields/relationship/query/name=special_related_products1', 'my_relationship_query', 10, 3);
function my_relationship_query( $args, $field, $post_id ) {
    $args['post__in']=wc_get_product_ids_on_sale();
    // return
    return $args;
}
add_filter('acf/fields/relationship/query/name=special_related_products', 'my_relationship_query1', 10, 3);
function my_relationship_query1( $args, $field, $post_id ) {
    $args['post__not_in']=wc_get_product_ids_on_sale();
    // return
    return $args;
}


/**
 * Redirect customer user from wp-admin to home page
 *
 */
add_filter( 'woocommerce_prevent_admin_access', '__return_false' );
add_action( 'admin_init', 'prevent_access',99 );
function prevent_access(){
    $prevent_access = false;

    if ( 'yes' === get_option( 'woocommerce_lock_down_admin', 'yes' ) && ! is_ajax() && basename( $_SERVER["SCRIPT_FILENAME"] ) !== 'admin-post.php' ) {
        $has_cap     = false;
        $access_caps = array( 'edit_posts', 'manage_woocommerce', 'view_admin_dashboard' );

        foreach ( $access_caps as $access_cap ) {
            if ( current_user_can( $access_cap ) ) {
                $has_cap = true;
                break;
            }
        }

        if ( ! $has_cap ) {
            $prevent_access = true;
        }
    }

    if ( $prevent_access ) {
        wp_safe_redirect( site_url());
        exit;
    }
}


/**
 * Let's stop WordPress re-ordering my categories/taxonomies when I select them
 *
 */
add_filter('wp_terms_checklist_args','stop_reordering_my_categories');
function stop_reordering_my_categories($args) {
    $args['checked_ontop'] = false;
    return $args;
}


/**
 * Random number for Kvalue field on Pricing form
 *
 */
function randomNumber($length) {
    $result = '';

    for($i = 0; $i < $length; $i++) {
        $result .= mt_rand(0, 9);
    }

    return $result;
}


/**
 * Set/unset test cookies
 *
 */
//add_action( 'init', 'setting_my_first_cookie' );
function setting_my_first_cookie() {
    //Remove cookies
    unset($_COOKIE['full_name']);
    unset($_COOKIE['email']);
    unset($_COOKIE['phone']);
    setcookie("full_name", null, strtotime('-1 week'), COOKIEPATH, COOKIE_DOMAIN);
    setcookie("email", null, strtotime('-1 week'), COOKIEPATH, COOKIE_DOMAIN);
    setcookie("phone", null, strtotime('-1 week'), COOKIEPATH, COOKIE_DOMAIN);

    //Set cookies
    /*setcookie("full_name","aa",strtotime('+1 week'), COOKIEPATH, COOKIE_DOMAIN);
    setcookie("email","bb@bb.bb",strtotime('+1 week'), COOKIEPATH, COOKIE_DOMAIN);
    setcookie("phone","123456789",strtotime('+1 week'), COOKIEPATH, COOKIE_DOMAIN);*/
}
