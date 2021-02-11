<?php

add_action('init', 'trainingcamp_testimonials_init');

function trainingcamp_testimonials_init() {
    $labels = array(
        'name'               => __('Testimonials', 'trainingcamp'),
        'singular_name'      => __('Testimonials', 'trainingcamp'),
        'add_new'            => __('Add New', 'trainingcamp'),
        'add_new_item'       => __('Add New Testimonial', 'trainingcamp'),
        'edit_item'          => __('Edit Testimonial', 'trainingcamp'),
        'new_item'           => __('New Testimonial', 'trainingcamp'),
        'all_items'          => __('All Testimonials', 'trainingcamp'),
        'view_item'          => __('View Testimonial', 'trainingcamp'),
        'search_items'       => __('Search Testimonials', 'trainingcamp'),
        'not_found'          => __('No Testimonials found', 'trainingcamp'),
        'not_found_in_trash' => __('No Testimonials found in Trash', 'trainingcamp'),
        'parent_item_colon'  => '',
        'menu_name'          => __('Testimonials', 'trainingcamp')
    );
    $args   = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => false,
        'capability_type'    => 'page',
        'rewrite'            => false,
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 21,
        'supports'           => array('title'),
        'show_in_nav_menus'  => true,
        'show_in_admin_bar'  => true
    );
    register_post_type('testimonials', $args);
}

