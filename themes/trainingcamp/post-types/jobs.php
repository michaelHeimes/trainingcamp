<?php

add_action('init', 'trainingcamp_jobs_init');

function trainingcamp_jobs_init() {
    $labels = array(
        'name'               => __('Jobs', 'trainingcamp'),
        'singular_name'      => __('Jobs', 'trainingcamp'),
        'add_new'            => __('Add New', 'trainingcamp'),
        'add_new_item'       => __('Add New Job', 'trainingcamp'),
        'edit_item'          => __('Edit Job', 'trainingcamp'),
        'new_item'           => __('New Job', 'trainingcamp'),
        'all_items'          => __('All Jobs', 'trainingcamp'),
        'view_item'          => __('View Job', 'trainingcamp'),
        'search_items'       => __('Search Jobs', 'trainingcamp'),
        'not_found'          => __('No Jobs found', 'trainingcamp'),
        'not_found_in_trash' => __('No Jobs found in Trash', 'trainingcamp'),
        'parent_item_colon'  => '',
        'menu_name'          => __('Jobs', 'trainingcamp')
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
    register_post_type('jobs', $args);
}

