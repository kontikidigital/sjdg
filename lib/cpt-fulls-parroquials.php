<?php

if (!function_exists('sjdg_fulls')) {

// Register Custom Post Type
    function sjdg_fulls() {

        $labels = array(
            'name' => _x('Fulls Parroquials', 'Post Type General Name', 'sjdg'),
            'singular_name' => _x('Full Parroquial', 'Post Type Singular Name', 'sjdg'),
            'menu_name' => __('Fulls Parroquials', 'sjdg'),
            'name_admin_bar' => __('Full Parroquial', 'sjdg'),
            'archives' => __('Full Parroquial Archives', 'sjdg'),
            'attributes' => __('Full Parroquial Attributes', 'sjdg'),
            'parent_item_colon' => __('Parent Full Parroquial:', 'sjdg'),
            'all_items' => __('All Fulls Parroquials', 'sjdg'),
            'add_new_item' => __('Add New Full Parroquial', 'sjdg'),
            'add_new' => __('Add New', 'sjdg'),
            'new_item' => __('New Full Parroquial', 'sjdg'),
            'edit_item' => __('Edit Full Parroquial', 'sjdg'),
            'update_item' => __('Update Full Parroquial', 'sjdg'),
            'view_item' => __('View Full Parroquial', 'sjdg'),
            'view_items' => __('View Fulls Parroquials', 'sjdg'),
            'search_items' => __('Search Full Parroquial', 'sjdg'),
            'not_found' => __('Not found', 'sjdg'),
            'not_found_in_trash' => __('Not found in Trash', 'sjdg'),
            'featured_image' => __('Featured Image', 'sjdg'),
            'set_featured_image' => __('Set featured image', 'sjdg'),
            'remove_featured_image' => __('Remove featured image', 'sjdg'),
            'use_featured_image' => __('Use as featured image', 'sjdg'),
            'insert_into_item' => __('Insert into full parroquial', 'sjdg'),
            'uploaded_to_this_item' => __('Uploaded to this full parroquial', 'sjdg'),
            'items_list' => __('Fulls Parroquials list', 'sjdg'),
            'items_list_navigation' => __('Fulls Parroquials list navigation', 'sjdg'),
            'filter_items_list' => __('Filter Fulls Parroquials list', 'sjdg'),
        );
        $rewrite = array(
            'slug' => __('full-parroquial', 'sjdg'),
            'with_front' => false,
            'pages' => true,
            'feeds' => true,
        );
        $args = array(
            'label' => __('Full Parroquial', 'sjdg'),
            'description' => __('Fulls Parroquials Post Type', 'sjdg'),
            'labels' => $labels,
            'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
//            'taxonomies' => array('editorial', 'series', 'full parroquial_author', 'available_language', 'dist_countries', 'full parroquial_category', 'readers_age', 'availability'),
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 5,
            'menu_icon' => 'dashicons-full parroquial',
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => __('fulls-parroquials', 'sjdg'),
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'rewrite' => $rewrite,
            'capability_type' => 'post',
        );
        register_post_type('fullparroquial', $args);
    }

    add_action('init', 'sjdg_fulls', 0);
}
