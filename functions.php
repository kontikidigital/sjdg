<?php

/**
 * Sant Joan de Gracia.
 *
 * This file adds functions to the Sant Joan de Gracia Theme.
 *
 * @package Sant Joan de Gracia
 * @author  Max Terbeck
 * @license GPL-2.0+
 * @link    https://www.mediactiu.com/
 */
// Starts the engine.
require_once get_template_directory() . '/lib/init.php';

// Defines the child theme (do not remove).
define('CHILD_THEME_NAME', 'Sant Joan de Gracia');
define('CHILD_THEME_URL', 'https://www.mediactiu.com/');
define('CHILD_THEME_VERSION', '2.8.6');

// Sets up the Theme.
require_once get_stylesheet_directory() . '/lib/theme-defaults.php';

add_action('after_setup_theme', 'sjdg_localization_setup');

/**
 * Sets localization (do not remove).
 *
 * @since 1.0.0
 */
function sjdg_localization_setup() {

    load_child_theme_textdomain('sjdg', get_stylesheet_directory() . '/languages');
}

// Adds helper functions.
require_once get_stylesheet_directory() . '/lib/helper-functions.php';

// Adds image upload and color select to Customizer.
require_once get_stylesheet_directory() . '/lib/customize.php';

// Includes Customizer CSS.
require_once get_stylesheet_directory() . '/lib/output.php';

// Adds WooCommerce support.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php';

// Adds the required WooCommerce styles and Customizer CSS.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php';

// Adds the Genesis Connect WooCommerce notice.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php';

// Adds Gutenberg support.
require_once get_stylesheet_directory() . '/lib/gutenberg/init.php';

// Adds CPT support
require_once get_stylesheet_directory() . '/lib/cpt-fulls-parroquials.php';

// Adds Custom Sidebars support
require_once get_stylesheet_directory() . '/lib/custom-sidebar.php';

add_action('wp_enqueue_scripts', 'sjdg_enqueue_scripts_styles');

/**
 * Enqueues scripts and styles.
 *
 * @since 1.0.0
 */
function sjdg_enqueue_scripts_styles() {


    wp_enqueue_style('dashicons');

    $suffix = ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) ? '' : '.min';
    wp_enqueue_script(
            'sjdg-responsive-menu', get_stylesheet_directory_uri() . "/js/responsive-menus{$suffix}.js", array('jquery'), CHILD_THEME_VERSION, true
    );

    wp_localize_script(
            'sjdg-responsive-menu', 'genesis_responsive_menu', sjdg_responsive_menu_settings()
    );

    wp_enqueue_script(
            'sjdg', get_stylesheet_directory_uri() . '/js/global-sjdg.js', array('jquery'), CHILD_THEME_VERSION, true
    );
  
      wp_enqueue_script('equalheights', get_stylesheet_directory_uri() . '/js/jquery.equalheights.min.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('equalheights-init', get_stylesheet_directory_uri() . '/js/equalheights-init.js', array('equalheights'), '1.0.0', true);

}

add_action('wp_enqueue_scripts', 'sjdg_fonts');

function sjdg_fonts() {

    wp_enqueue_style('sjdg-fonts', get_bloginfo('stylesheet_directory') . '/fonts/sjdg-fonts.css', array(), CHILD_THEME_VERSION);
//     wp_enqueue_style(
//             'sjdg-gfonts', '//fonts.googleapis.com/css?=Montserrat:300,400,500,600,700|Poppins:400,600,700', array(), CHILD_THEME_VERSION
//     );

}

/**
 * Defines responsive menu settings.
 *
 * @since 2.3.0
 */
function sjdg_responsive_menu_settings() {

    $settings = array(
        'mainMenu' => __('Menu', 'sjdg'),
        'menuIconClass' => 'dashicons-before dashicons-menu',
        'subMenu' => __('Submenu', 'sjdg'),
        'subMenuIconClass' => 'dashicons-before dashicons-arrow-down-alt2',
        'menuClasses' => array(
            'combine' => array(
                '.nav-primary',
            ),
            'others' => array(),
        ),
    );

    return $settings;
}

// Adds support for HTML5 markup structure.
add_theme_support(
        'html5', array(
    'caption',
    'comment-form',
    'comment-list',
    'gallery',
    'search-form',
        )
);

// Adds support for accessibility.
add_theme_support(
        'genesis-accessibility', array(
    '404-page',
    'drop-down-menu',
    'headings',
    'search-form',
    'skip-links',
        )
);

// Adds viewport meta tag for mobile browsers.
add_theme_support(
        'genesis-responsive-viewport'
);

// Adds custom logo in Customizer > Site Identity.
add_theme_support(
        'custom-logo', array(
    'height' => 120,
    'width' => 700,
    'flex-height' => true,
    'flex-width' => true,
        )
);

// Renames primary and secondary navigation menus.
add_theme_support(
        'genesis-menus', array(
    'primary' => __('Header Menu', 'sjdg'),
    'secondary' => __('Footer Menu', 'sjdg'),
        )
);

// Adds image sizes.
add_image_size('sidebar-featured', 75, 75, true);

// Adds support for after entry widget.
add_theme_support('genesis-after-entry-widget-area');

// Adds support for 3-column footer widgets.
add_theme_support('genesis-footer-widgets', 3);

// Removes header right widget area.
unregister_sidebar('header-right');

// Removes secondary sidebar.
unregister_sidebar('sidebar-alt');

// Removes site layouts.
genesis_unregister_layout('content-sidebar-sidebar');
genesis_unregister_layout('sidebar-content-sidebar');
genesis_unregister_layout('sidebar-sidebar-content');

// Removes output of primary navigation right extras.
remove_filter('genesis_nav_items', 'genesis_nav_right', 10, 2);
remove_filter('wp_nav_menu_items', 'genesis_nav_right', 10, 2);

add_action('genesis_theme_settings_metaboxes', 'sjdg_remove_metaboxes');

/**
 * Removes output of unused admin settings metaboxes.
 *
 * @since 2.6.0
 *
 * @param string $_genesis_admin_settings The admin screen to remove meta boxes from.
 */
function sjdg_remove_metaboxes($_genesis_admin_settings) {

    remove_meta_box('genesis-theme-settings-header', $_genesis_admin_settings, 'main');
    remove_meta_box('genesis-theme-settings-nav', $_genesis_admin_settings, 'main');
}

add_filter('genesis_customizer_theme_settings_config', 'sjdg_remove_customizer_settings');

/**
 * Removes output of header settings in the Customizer.
 *
 * @since 2.6.0
 *
 * @param array $config Original Customizer items.
 * @return array Filtered Customizer items.
 */
function sjdg_remove_customizer_settings($config) {

    unset($config['genesis']['sections']['genesis_header']);
    return $config;
}

// Displays custom logo.
add_action('genesis_site_title', 'the_custom_logo', 0);

//* Remove the edit link
add_filter('genesis_edit_post_link', '__return_false');

//* Remove 'You are here' from the front of breadcrumb trail
function sjdg_prefix_breadcrumb($args) {
    $args['labels']['prefix'] = '';

    return $args;
}

add_filter('genesis_breadcrumb_args', 'sjdg_prefix_breadcrumb');

//* Change the text at the front of breadcrumb trail
function sjdg_home_text_breadcrumb($args) {

    $args['home'] = __('Inici', 'sjdg');

    return $args;
}

add_filter('genesis_breadcrumb_args', 'sjdg_home_text_breadcrumb');

//* Change the breadcrumb separator
function sjdg_change_breadcrumb_separator($args) {
    $args['sep'] = ' &rsaquo; ';
    return $args;
}

add_filter('genesis_breadcrumb_args', 'sjdg_change_breadcrumb_separator');

// Repositions primary navigation menu.
remove_action('genesis_after_header', 'genesis_do_nav');
add_action('genesis_header', 'genesis_do_nav', 12);

// Repositions the secondary navigation menu.
remove_action('genesis_after_header', 'genesis_do_subnav');
//add_action('genesis_before_footer', 'genesis_do_subnav', 5);

add_filter('wp_nav_menu_args', 'sjdg_secondary_menu_args');

/**
 * Reduces secondary navigation menu to one level depth.
 *
 * @since 2.2.3
 *
 * @param array $args Original menu options.
 * @return array Menu options with depth set to 1.
 */
function sjdg_secondary_menu_args($args) {

    if ('secondary' !== $args['theme_location']) {
        return $args;
    }

    $args['depth'] = 1;
    return $args;
}

add_filter('genesis_author_box_gravatar_size', 'sjdg_author_box_gravatar');

/**
 * Modifies size of the Gravatar in the author box.
 *
 * @since 2.2.3
 *
 * @param int $size Original icon size.
 * @return int Modified icon size.
 */
function sjdg_author_box_gravatar($size) {

    return 90;
}

add_filter('genesis_comment_list_args', 'sjdg_comments_gravatar');

/**
 * Modifies size of the Gravatar in the entry comments.
 *
 * @since 2.2.3
 *
 * @param array $args Gravatar settings.
 * @return array Gravatar settings with modified size.
 */
function sjdg_comments_gravatar($args) {

    $args['avatar_size'] = 60;
    return $args;
}

// Remove Footer
remove_action('genesis_footer', 'genesis_do_footer');
remove_action('genesis_footer', 'genesis_footer_markup_open', 5);
remove_action('genesis_footer', 'genesis_footer_markup_close', 15);


/* Enews Extended Shortcode */
// Register enews widget area
genesis_register_widget_area(
        array(
            'id' => 'enews',
            'name' => __('eNews', 'sjdg'),
            'description' => __('This opt-in form will appear using the shortcode [enews]', 'sjdg'),
        )
);

// Create a custom [enews] shortcode which displays enews widget area
add_shortcode('enews', 'sjdg_enews_shortcode');

function sjdg_enews_shortcode() {

    ob_start();
    genesis_widget_area('enews');
    $enews = ob_get_clean();

    return $enews;
}

//* Customize the entry meta in the entry header (requires HTML5 theme support)
add_filter('genesis_post_info', 'sjdg_post_info_filter');

function sjdg_post_info_filter($post_info) {
    $post_info = '[post_date]';
    return $post_info;
}

//* Remove Featured Image from Entry Content and add it in Entry Header above the Post Title
remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'genesis_do_post_image', 5 );

/**
 * Add Read More button below post excerpts/content on archives.
 */
add_action( 'genesis_entry_content', 'sjdg_custom_add_read_more' );
function sjdg_custom_add_read_more() {
    // if this is a singular page, abort.
    if ( is_singular() ) {
        return;
    }

    printf( '<a href="%s" class="more"></a>', get_the_permalink() );
}

/* Limit Search Results to Posts */
function sjdg_searchfilter($query) {
 
    if ($query->is_search && !is_admin() ) {
        $query->set('post_type',array('post'));
    }
 
return $query;
}
 
add_filter('pre_get_posts','sjdg_searchfilter');

//* Customize search form input box text
add_filter( 'genesis_search_text', 'sjdg_search_text' );
function sjdg_search_text( $text ) {
	return esc_attr( 'Cercador' );
}

//* Customize search form input button text
add_filter( 'genesis_search_button_text', 'sjdg_search_button_text' );
function sjdg_search_button_text( $text ) {

	return esc_attr( '&#xf179;' );

}

/* Keep Blog Archive Highlighted */
function add_custom_class($classes=array(), $menu_item=false) {
    if ( is_singular('post') && !is_page() && 'Notícies' == $menu_item->title && 
            !in_array( 'current-menu-item', $classes ) ) {
        $classes[] = 'current-menu-blog';        
    }                    
    return $classes;
}
 add_filter('nav_menu_css_class', 'add_custom_class', 100, 2); 

/*
 * Display Hero Image on Pages Header
 */
add_action('genesis_after_header', 'sjdg_page_hero_header');

function sjdg_page_hero_header() {
    $imatge_capcalera = get_field('capcalera_pagines');
  if ( is_page() && $imatge_capcalera ) {
    
        ?>
        <style>
            .site-inner {
                margin-top: 0 !important;
            }
        </style>
        <div class="hero-image">
            <?php echo wp_get_attachment_image($imatge_capcalera, 'full'); ?>
        </div>
        <?php
    }
}

/**
 * Allows visitors to page forward/backwards in any direction within month view
 * an "infinite" number of times (ie, outwith the populated range of months).
 */
if ( class_exists( 'Tribe__Events__Main' ) ) {
	class ContinualMonthViewPagination {
	    public function __construct() {
	        add_filter( 'tribe_events_the_next_month_link', array( $this, 'next_month' ) );
	        add_filter( 'tribe_events_the_previous_month_link', array( $this, 'previous_month' ) );
	    }
	    public function next_month() {
	        $url = tribe_get_next_month_link();
	        $text = tribe_get_next_month_text();
	        $date = Tribe__Events__Main::instance()->nextMonth( tribe_get_month_view_date() );
	        return '<a data-month="' . $date . '" href="' . $url . '" rel="next">' . $text . ' <span>&raquo;</span></a>';
	    }
	    public function previous_month() {
	        $url = tribe_get_previous_month_link();
	        $text = tribe_get_previous_month_text();
	        $date = Tribe__Events__Main::instance()->previousMonth( tribe_get_month_view_date() );
	        return '<a data-month="' . $date . '" href="' . $url . '" rel="prev"><span>&laquo;</span> ' . $text . ' </a>';
	    }
	}
	new ContinualMonthViewPagination;
}
