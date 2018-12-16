<?php
/*
  Template Name: Full Parroquial
 */

/**
 * Add attributes for site-inner element.
 *
 * @since 2.0.0
 *
 * @param array $attributes Existing attributes.
 *
 * @return array Amended attributes.
 */
add_filter('genesis_attr_site-inner', 'sjdg_attributes_site_inner');

function sjdg_attributes_site_inner($attributes) {
    $attributes['role'] = 'main';
    $attributes['itemprop'] = 'mainContentOfPage';
    return $attributes;
}

// Force full width content layout.
//add_filter('genesis_pre_get_option_site_layout', '__genesis_return_full_width_content');
// Reposition the breadcrumb navigation.
remove_action('genesis_before_loop', 'genesis_do_breadcrumbs');
add_action('genesis_before_content', 'genesis_do_breadcrumbs', 10);

// Remove Page Title.
//remove_action('genesis_entry_header', 'genesis_do_post_title');
// Do not show Featured image if set in Theme Settings > Content Archives.
add_filter('genesis_pre_get_option_content_archive_thumbnail', '__return_false');

// Remove the post content
//remove_action('genesis_entry_content', 'genesis_do_post_content');
//remove_action('genesis_loop', 'genesis_do_loop');
// Add custom body class
add_filter('body_class', 'sgdg_full_body_class');

function sgdg_full_body_class($classes) {
    $classes[] = 'full-parroquial-page';
    return $classes;
}

/*
 * Display Hero Image
 */
add_action('genesis_after_header', 'sjdg_serveis_hero');

function sjdg_serveis_hero() {
    $imatge_capcalera = get_field('imatge_capcalera');
    if ($imatge_capcalera) {
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

/*
 * Display Everything
 */
add_action('genesis_after_entry_content', 'sjdg_full_parroquial_contingut', 10);

// Tramits
function sjdg_full_parroquial_contingut() {
    $full = get_post_meta(get_the_ID(), 'full_parroquial', true);


    if ($full) {
        ?>

        <div id="full-parroquial">
            <ul>
                <?php
                for ($i = 0; $i < $full; $i++) {
                    $titol = esc_html(get_post_meta(get_the_ID(), 'full_parroquial_' . $i . '_titol', true));
                    $date = get_post_meta(get_the_ID(), 'full_parroquial_' . $i . '_data', true);
                    $pdf = get_post_meta(get_the_ID(), 'full_parroquial_' . $i . '_pdf', true);
                    $imatge = get_post_meta(get_the_ID(), 'full_parroquial_' . $i . '_imatge', true);
                    // get raw date
// make date object
                    $date = new DateTime($date);
                    $url = wp_get_attachment_url($pdf);
                    ?>
                    <li class="featured-post">
                        <a href="<?php echo $url; ?>" target="_blank">
                            <?php echo wp_get_attachment_image($imatge, 'full'); ?>
                            <div class="featured-post-content">
                                <p><?php echo $date->format('j M Y'); ?></p>
                                <h3><?php echo $titol; ?></h3>
                            </div>
                        </a>
                    </li>
                <?php } //for    ?>
            </ul>
        </div> <!--tramits-->
        <?php
    } //if
}

genesis();
