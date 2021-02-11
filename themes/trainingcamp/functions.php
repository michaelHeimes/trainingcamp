<?php
/**
 * trainingcamp functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package trainingcamp
 */
 
 

if ( ! function_exists( 'trainingcamp_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function trainingcamp_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on trainingcamp, use a find and replace
	 * to change 'trainingcamp' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'trainingcamp', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'menu-1' => esc_html__( 'Primary', 'trainingcamp' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'trainingcamp_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	//Additional image sizes
	add_image_size( 'prod_single_img', 1920, 740, array( 'center', 'top' ) );
	add_image_size( 'full_hd', 1920, 1080);
	add_image_size( 'prod_archive_img', 380, 260, array( 'center', 'center' ) );
	add_image_size( 'instructor_thump', 380, 500, array( 'center', 'center' ) );
}
endif;
add_action( 'after_setup_theme', 'trainingcamp_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function trainingcamp_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'trainingcamp_content_width', 640 );
}
add_action( 'after_setup_theme', 'trainingcamp_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function trainingcamp_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'trainingcamp' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'trainingcamp' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'trainingcamp_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function trainingcamp_scripts() {
	wp_enqueue_style( 'trainingcamp-style', get_stylesheet_uri() );

}
add_action( 'wp_enqueue_scripts', 'trainingcamp_scripts' );


/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/uri.php';
require get_template_directory() . '/inc/enqueue.php';
require get_template_directory() . '/post-types/testimonials.php';
require get_template_directory() . '/post-types/jobs.php';
require get_template_directory() . '/post-types/instructors.php';
require get_template_directory() . '/inc/woo-extras.php';
require get_template_directory() . '/inc/extras.php';


/**
 * Require autoload Woocommerce API lib
 */
require_once __DIR__.'/vendor/autoload.php';


/*
 * condition to redirect register screen
 

add_action('template_redirect','custom_shop_page_redirect');
function custom_shop_page_redirect(){
    if (class_exists('WooCommerce')){
		$empty=(isset($_COOKIE['full_name']) && isset($_COOKIE['email']) && isset($_COOKIE['phone'])) ? false : true;
        if(is_product() && $empty){
            wp_redirect(home_url('/register/?product_id='.get_the_ID()));
            exit();
        }
    } 
    return;
} 
*/

function content($limit) {
	$content = explode(' ', get_the_content(), $limit);
	if (count($content)>=$limit) {
	  array_pop($content);
	  $content = implode(" ",$content).'...';
	} else {
	  $content = implode(" ",$content);
	}	
	$content = preg_replace('/\[.+\]/','', $content);
	$content = apply_filters('the_content', $content); 
	$content = str_replace(']]>', ']]&gt;', $content);
	return $content;
  }
  

