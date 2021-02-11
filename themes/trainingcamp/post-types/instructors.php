<?php

add_action('init', 'trainingcamp_instructors_init');

function trainingcamp_instructors_init() {
    $labels = array(
        'name'               => __('Instructors', 'trainingcamp'),
        'singular_name'      => __('Instructors', 'trainingcamp'),
        'add_new'            => __('Add New', 'trainingcamp'),
        'add_new_item'       => __('Add New Instructor', 'trainingcamp'),
        'edit_item'          => __('Edit Instructor', 'trainingcamp'),
        'new_item'           => __('New Instructor', 'trainingcamp'),
        'all_items'          => __('All Instructors', 'trainingcamp'),
        'view_item'          => __('View Instructor', 'trainingcamp'),
        'search_items'       => __('Search Instructors', 'trainingcamp'),
        'not_found'          => __('No Instructors found', 'trainingcamp'),
        'not_found_in_trash' => __('No Instructors found in Trash', 'trainingcamp'),
        'parent_item_colon'  => '',
        'menu_name'          => __('Instructors', 'trainingcamp')
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
        'supports'           => array('title','thumbnail'),
        'show_in_nav_menus'  => true,
        'show_in_admin_bar'  => true
    );
    register_post_type('instructors', $args);
}

