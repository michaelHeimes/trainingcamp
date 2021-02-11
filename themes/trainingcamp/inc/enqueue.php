<?php
/**
 * Enqueue scripts and styles.
 */

function trainingcamp_enqueue_styles()
{
    $template = get_post_meta( get_the_ID(), '_wp_page_template', true );

    if(is_singular('product')){
        wp_enqueue_style('trainingcamp-product-style', trainingcamp_get_css_uri('course-details'));
        wp_enqueue_style('trainingcamp-home-style', trainingcamp_get_css_uri('home'));
        //wp_enqueue_style('trainingcamp-app-style', trainingcamp_get_css_uri('app'));
    }

    if(is_tax('product_cat')){
        $term_id=get_queried_object()->term_id;
        $term = get_term($term_id, 'product_cat');
        $termParent = $term->parent;
        if($termParent===0){
            wp_enqueue_style('trainingcamp-parent_term-style', trainingcamp_get_css_uri('training-courses'));
        }else{
            wp_enqueue_style('trainingcamp-child_term-style', trainingcamp_get_css_uri('courses-group'));
        }

    }

    if(is_search()){
        wp_enqueue_style('trainingcamp-search-style', trainingcamp_get_css_uri('search-results'));
    }

    if(is_404()){
        wp_enqueue_style('trainingcamp-404-style', trainingcamp_get_css_uri('error-page'));
    }

    if (function_exists('is_cart')){
        if(is_cart()){
            wp_enqueue_style('trainingcamp-cart-style', trainingcamp_get_css_uri('cart'));
        }
        if(is_checkout()){
            wp_enqueue_style('trainingcamp-checkout-style', trainingcamp_get_css_uri('checkout'));
            wp_enqueue_style('trainingcamp-calendar-style', 'http://addtocalendar.com/atc/1.5/atc-style-blue.css');
        }
    }

    if(is_front_page()){
        wp_enqueue_style('trainingcamp-home-style', trainingcamp_get_css_uri('home'));
    }

    switch ($template) {
        case 'templates/special-offers.php':
            wp_enqueue_style('trainingcamp-special-style', trainingcamp_get_css_uri('special-offers'));
            break;
        case 'templates/about.php':
            wp_enqueue_style('trainingcamp-about-style', trainingcamp_get_css_uri('about'));
            break;
        case 'templates/jobs.php':
            wp_enqueue_style('trainingcamp-jobs-style', trainingcamp_get_css_uri('jobs'));
            break;
        case 'templates/single-solution.php':
            wp_enqueue_style('trainingcamp-solutions-style', trainingcamp_get_css_uri('solutions'));
            break;
        case 'templates/instructors.php':
            wp_enqueue_style('trainingcamp-instructors-style', trainingcamp_get_css_uri('instructors'));
            break;
        case 'templates/contact.php':
            wp_enqueue_style('trainingcamp-contact-style', trainingcamp_get_css_uri('contact-us'));
            break;
        case 'default':
            if(!is_front_page())
                wp_enqueue_style('trainingcamp-global-style', trainingcamp_get_css_uri('global'));
            break;
        case 'templates/pricing.php':
            /*if (is_user_logged_in()){
                wp_enqueue_style('trainingcamp-pricing-style', trainingcamp_get_css_uri('pricing-schedules'));
            }else{
                wp_enqueue_style('trainingcamp-login-style', trainingcamp_get_css_uri('login-register'));
            }*/
            wp_enqueue_style('trainingcamp-pricing-style', trainingcamp_get_css_uri('pricing-schedules'));
            break;

        case 'templates/register.php':
            /*if (is_user_logged_in()){
                wp_enqueue_style('trainingcamp-pricing-style', trainingcamp_get_css_uri('pricing-schedules'));
            }else{
                wp_enqueue_style('trainingcamp-login-style', trainingcamp_get_css_uri('login-register'));
            }*/
            wp_enqueue_style('trainingcamp-pricing-style', trainingcamp_get_css_uri('pricing-schedules'));
            break;

            case 'templates/course-pricing.php':
            /*if (is_user_logged_in()){
                wp_enqueue_style('trainingcamp-pricing-style', trainingcamp_get_css_uri('pricing-schedules'));
            }else{
                wp_enqueue_style('trainingcamp-login-style', trainingcamp_get_css_uri('login-register'));
            }*/
            
            wp_enqueue_style('trainingcamp-home-style', trainingcamp_get_css_uri('home'));
            wp_enqueue_style('trainingcamp-pricing-style', trainingcamp_get_css_uri('pricing-schedules'));
            break;
            
            case 'templates/course-price-noreq.php':
            /*if (is_user_logged_in()){
                wp_enqueue_style('trainingcamp-pricing-style', trainingcamp_get_css_uri('pricing-schedules'));
            }else{
                wp_enqueue_style('trainingcamp-login-style', trainingcamp_get_css_uri('login-register'));
            }*/
            
            wp_enqueue_style('trainingcamp-home-style', trainingcamp_get_css_uri('home'));
            wp_enqueue_style('trainingcamp-pricing-style', trainingcamp_get_css_uri('pricing-schedules'));
            break;
	case 'templates/enterprise-solutions-template.php':
           wp_enqueue_style('trainingcamp-enterprise-solutions-style', trainingcamp_get_custom_css_uri('flex'));
            wp_enqueue_style('trainingcamp-enterprise-solutions-style', trainingcamp_get_custom_css_uri('animate'));
            
           wp_enqueue_style('trainingcamp-enterprise-solutions-style', trainingcamp_get_custom_css_uri('font-awesome'));
           wp_enqueue_style('trainingcamp-enterprise-solutions-style', trainingcamp_get_custom_css_uri('foundation'));
           wp_enqueue_style('trainingcamp-enterprise-solutions-style', trainingcamp_get_custom_css_uri('foundation-prototype'));
            break;
    }

}
add_action('wp_enqueue_scripts', 'trainingcamp_enqueue_styles');

function trainingcamp_enqueue_scripts()
{
    $template = get_post_meta( get_the_ID(), '_wp_page_template', true );

    wp_deregister_script('jquery');
    wp_register_script('jquery', ('//ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js'), '20170215', false);
    wp_enqueue_script('jquery');

    if(!is_404()){
        wp_enqueue_script("trainingcamp-global-script", trainingcamp_get_js_uri('global'), array('jquery'), '20170215', true);
        //wp_enqueue_script("trainingcamp-mailchimp-script", get_template_directory_uri().'/js/subscribe.js', array('jquery'), '20170215', true);
    }

    if (is_singular('product')){
        wp_enqueue_script("trainingcamp-product-script",trainingcamp_get_js_uri('course-details'), array('jquery'), '20150312', true);
    //    wp_enqueue_script("trainingcamp-app-script",get_template_directory_uri().'/js/shop-app.min.js', array('jquery'), '20150312', true);
    }

    if(is_tax('product_cat')){
        $term_id=get_queried_object()->term_id;
        $term = get_term($term_id, 'product_cat');
        $termParent = $term->parent;
        if($termParent===0){
            wp_enqueue_script("trainingcamp-loadmore-script",get_template_directory_uri().'/js/loadmore_products.js', array('jquery'), '20150312', true);
        }else{

        }
    }

    if(is_search()){
        wp_enqueue_script("trainingcamp-search-script",trainingcamp_get_js_uri('search-results'), array('jquery'), '20150312', true);
    }

    if(function_exists('is_checkout')){
        if(is_checkout()){
            wp_enqueue_script("trainingcamp-checkout-script",trainingcamp_get_js_uri('checkout'), array('jquery'), '20150312', true);
        }
    }

    if(is_front_page()){
        wp_enqueue_script("trainingcamp-home-script",trainingcamp_get_js_uri('home'), array('jquery'), '20150312', true);
    }

    switch ($template) {
        case 'templates/special-offers.php':
            wp_enqueue_script("trainingcamp-special-script",trainingcamp_get_js_uri('special-offers'), array('jquery'), '20150312', true);
            wp_enqueue_script("trainingcamp-loadmore-script",get_template_directory_uri().'/js/loadmore_products.js', array('jquery'), '20150312', true);
            break;
        case 'templates/instructors.php':
            wp_enqueue_script("trainingcamp-loadmore-script",get_template_directory_uri().'/js/loadmore_instructors.js', array('jquery'), '20150312', true);
            break;
        case 'templates/pricing.php':
            wp_enqueue_script("trainingcamp-validate-script", 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js', array('jquery'), '20150312', true);
            wp_enqueue_script("trainingcamp-pricing-script",trainingcamp_get_js_uri('pricing-schedules'), array('jquery'), '20150312', true);
            wp_enqueue_script("trainingcamp-pricing_app-script",get_template_directory_uri().'/js/pricing-app.min.js', array('jquery'), '20150312', true);
            wp_enqueue_script("trainingcamp-pricing-form-script",get_template_directory_uri().'/js/pricing-form.js', array('jquery'), '20150312', true);
            wp_localize_script( 'trainingcamp-pricing-form-script', 'ajax_auth_object', array(
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
            ));
            //
            break;
	 case 'templates/register.php':
                wp_enqueue_script("trainingcamp-validate-script", 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js', array('jquery'), '20150312', true);
            wp_enqueue_script("trainingcamp-pricing-script",trainingcamp_get_js_uri('pricing-schedules'), array('jquery'), '20150312', true);
            wp_enqueue_script("trainingcamp-pricing_app-script",get_template_directory_uri().'/js/pricing-app.min.js', array('jquery'), '20150312', true);
            //wp_enqueue_script("trainingcamp-pricing-form-script",get_template_directory_uri().'/js/pricing-form.js', array('jquery'), '20150312', true);
            wp_enqueue_script("trainingcamp-register-script",get_template_directory_uri().'/js/register.js', array('jquery'), '20150312', true);
            wp_localize_script( 'trainingcamp-register-script', 'ajax_auth_object', array(
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
            ));
            //
            break;

            case 'templates/course-pricing.php':
              wp_enqueue_script("trainingcamp-validate-script", 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js', array('jquery'), '20150312', true);
            wp_enqueue_script("trainingcamp-pricing-script",trainingcamp_get_js_uri('pricing-schedules'), array('jquery'), '20150312', true);
            wp_enqueue_script("trainingcamp-pricing_app-script",get_template_directory_uri().'/js/pricing-app.min.js', array('jquery'), '20150312', true);
            wp_enqueue_script("trainingcamp-pricing-form-script",get_template_directory_uri().'/js/pricing-form.js', array('jquery'), '20150312', true);
            wp_localize_script( 'trainingcamp-pricing-form-script', 'ajax_auth_object', array(
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
            ));
            wp_enqueue_script("trainingcamp-home-script",trainingcamp_get_js_uri('home'), array('jquery'), '20150312', true);
            //
            break;
            case 'templates/course-price-noreq.php':
              wp_enqueue_script("trainingcamp-validate-script", 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js', array('jquery'), '20150312', true);
            wp_enqueue_script("trainingcamp-pricing-script",trainingcamp_get_js_uri('pricing-schedules'), array('jquery'), '20150312', true);
            wp_enqueue_script("trainingcamp-pricing_app-script",get_template_directory_uri().'/js/pricing-app.min.js', array('jquery'), '20150312', true);
            wp_enqueue_script("trainingcamp-pricing-form-script",get_template_directory_uri().'/js/pricing-form.js', array('jquery'), '20150312', true);
            wp_localize_script( 'trainingcamp-pricing-form-script', 'ajax_auth_object', array(
                'ajaxurl' => admin_url( 'admin-ajax.php' ),
            ));
            wp_enqueue_script("trainingcamp-home-script",trainingcamp_get_js_uri('home'), array('jquery'), '20150312', true);
            //
            break;
	case 'templates/cart.php':
            wp_enqueue_script("trainingcamp-course-pricing-script",get_template_directory_uri().'/js/cart-billing.js', array('jquery'),'20150312', true);
            break;
	case 'templates/enterprise-solutions-template.php':
            wp_enqueue_script("trainingcamp-enterprise-solutions-script",get_template_directory_uri().'/js/assessment.js', array('jquery'),'20150312', true);
            wp_enqueue_script("trainingcamp-enterprise-solutions-script",get_template_directory_uri().'/js/jquery.js', array('jquery'),'20150312', true);
            break;
//		case 'templates/cart.php':
//            wp_enqueue_script("trainingcamp-course-pricing-script",get_template_directory_uri().'/js/cart-billing.js', array('jquery'), '20150312', true);
  //          break
    }

}
add_action('wp_enqueue_scripts', 'trainingcamp_enqueue_scripts');
