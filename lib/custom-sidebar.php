<?php
/**
 * Sant Joan de Gracia.
 *
 * This file adds customized widget areas to the front end to the Sant Joan de Gracia Theme.
 *
 * @package Sant Joan de Gracia
 * @author  Max Terbeck
 * @license GPL-2.0+
 * @link    https://www.mediactiu.com/
 */

// Register Blog Sidebar widget area
genesis_register_widget_area(
	array(
		'id'          => 'secondary-sidebar',
		'name'        => __( 'Sidebar Agenda', 'sjdg' ),
		'description' => __( 'Sidebar for Calendar', 'sjdg' ),
	)
);

genesis_register_widget_area(
	array(
		'id'          => 'tertiary-sidebar',
		'name'        => __( 'Sidebar Full Parroquial', 'sjdg' ),
		'description' => __( 'Sidebar for Content Management Section', 'sjdg' ),
	)
);

add_action( 'genesis_after_header', 'sjdg_change_genesis_primary_sidebar' );
/**
 * Show custom sidebars in Primary Sidebar location for blog pages and static Pages
 */
function sjdg_change_genesis_primary_sidebar() {

	if ( is_post_type_archive( 'tribe_events' ) ) { // for archives and single post pages
		// remove Primary Sidebar from the Primary Sidebar area
		remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );

		// show Blog Sidebar in Primary Sidebar area
		add_action( 'genesis_sidebar', function() {
			dynamic_sidebar( 'secondary-sidebar' );
		} );
	} else {
	if ( is_post_type_archive( 'fullparroquial' ) ) { // for archives and single post pages
		// remove Primary Sidebar from the Primary Sidebar area
		remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );

		// show Blog Sidebar in Primary Sidebar area
		add_action( 'genesis_sidebar', function() {
			dynamic_sidebar( 'tertiary-sidebar' );
		} );
    
  }
}
}