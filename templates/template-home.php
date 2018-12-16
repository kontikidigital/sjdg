<?php
/*
  Template Name: Pàgina d'inici
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

// Remove div.site-inner's div.wrap
add_filter('genesis_structural_wrap-site-inner', '__return_empty_string');

//* Remove .site-inner
add_filter('genesis_markup_site-inner', '__return_null');
add_filter('genesis_markup_content-sidebar-wrap', '__return_null');
add_filter('genesis_markup_content', '__return_null');

// Force full width content layout.
add_filter('genesis_pre_get_option_site_layout', '__genesis_return_full_width_content');

// Remove the breadcrumb navigation.
remove_action('genesis_before_loop', 'genesis_do_breadcrumbs');

// Remove Page Title.
remove_action('genesis_entry_header', 'genesis_do_post_title');

// Do not show Featured image if set in Theme Settings > Content Archives.
add_filter('genesis_pre_get_option_content_archive_thumbnail', '__return_false');

// Remove the post content
remove_action('genesis_entry_content', 'genesis_do_post_content');
remove_action('genesis_loop', 'genesis_do_loop');

// Add custom body class
add_filter('body_class', 'sgdg_home_body_class');

function sgdg_home_body_class($classes) {
    $classes[] = 'home-page';
    return $classes;
}

/*
 * Display Everything
 */
add_action('genesis_before_content', 'sjdg_home_content');
add_action('genesis_before_content', 'sjdg_home_3', 30);

/**
 *  Hero Slider
 */
function sjdg_home_content() {
    //Set variables
    $slider = get_field('slider');
    $introduccio = get_field('introduccio');
    $horaris = get_field('horaris');
    $agenda = get_field('agenda');
    $imatge_de_fons_de_lagenda = get_field('imatge_de_fons_de_lagenda');

    /*
     * Set the HTML and Content
     */
    //Slider
    if ($slider) {
        ?>
        <div id="home-slider">
            <?php echo do_shortcode($slider); ?>
        </div>
        <?php
    }
    //Introduccio
    if ($introduccio && $horaris) {
        ?>
        <div id="home-1">
            <div class="home-intro-text">
                <?php echo $introduccio; ?>
            </div>
            <div class="home-intro-horaris">
                <?php echo $horaris; ?>
              <a class="horaris-more" href="<?php echo site_url('#');?>"><?php echo __('Més horaris &rarr;', 'sjdg'); ?></a>
            </div>
        </div>
        <?php
    }
    //Agenda
    /* Repeater Field */
    $agenda_items = get_post_meta(get_the_ID(), 'agenda_items', true);
    $agenda_intro = get_post_meta(get_the_ID(), 'agenda', true);

    if ($agenda_items) {
        ?>
        <div class="home-2" style="background-image:url(<?php echo get_field('imatge_de_fons_de_lagenda'); ?>);">
            <div class="agenda-box">
                <div class="agenda-info-wrapper">
                    <h2>Agenda</h2>
                    <p class="semi-bold"><?php echo $agenda_intro; ?></p>
                    <a class="semi-bold agenda-more" href="<?php echo site_url('/agenda/');?>"><?php echo __('Veure tot el calendari &rarr;', 'sjdg'); ?></a>

                </div> <!--agenda-info-wrapper-->
                <div class="agenda-item-wrapper"><?php
                    // Ensure the global $post variable is in scope
                    global $post;

                    // Retrieve the next 3 upcoming events
                    $events = tribe_get_events(array(
                        'posts_per_page' => 3,
                    ));

                    // Loop through the events: set up each one as
                    // the current post then use template tags to
                    // display the title and content
                    foreach ($events as $post) {
                        setup_postdata($post);

                        // This time, let's throw in an event-specific
                        // template tag to show the date after the title!
                        echo '<div class="agenda-item">';
                        echo '<div class="agenda-header">';
                        echo tribe_get_start_date($post);
                        echo '</div> <!--agenda-header-->';
                        echo '<div class="agenda-item-title">';
                        echo "$post->post_title";
                        echo '</div><!--agenda-item-title-->';
                        echo '</div><!--agenda-item-->';
                    }
                    echo '</div> <!--agenda-item-wrapper-->';
                    ?>
                </div> <!--agenda-box-->
            </div> <!--home-2--> <?php
        } //if $agenda
    }

    function sjdg_home_3() {
        ?>
        <div id="home-3">
            <div class="recent-posts">
                <h2><?php echo __('Actualitat', 'sjdg'); ?></h2>
                <ul>
                    <?php
                    $loop = new WP_Query(array(
                        'posts_per_page' => 2,
                        'post_type' => 'post',
                        'post_status' => 'publish'
                    ));

                    if ($loop->have_posts()):
                        while ($loop->have_posts()): $loop->the_post();
                            echo '<li class="featured-post">';
                            echo '<a class="entry-image-link" href="' . get_permalink() . '">' . get_the_post_thumbnail(get_the_ID(), 'full') . '</a>';
                            echo '<div class="featured-post-content">';
                            echo '<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
                            echo '<p>' . get_the_excerpt() . '</p>';
                            echo '<a class="more" href="' . get_permalink() . '"></a>';
                            echo '</div>';

                            echo '</li>';

                        endwhile;
                        echo '</div>';
                    endif;
                    wp_reset_postdata();
                    ?>
                </ul>
                <!--</div> recent-posts-->
                <div class="full-parroquial-wrapper">
                    <a href="<?php echo site_url('/fulls-parroquials/');?>"><img src="<?php echo site_url('/wp-content/uploads/2018/11/Banner-Full-parroquial-horizontal.png');?>"/></a>
                    <div class="home-form-wrapper">
                      <img class="form-background" src="<?php echo site_url('/wp-content/uploads/2018/11/form-backgroundnotext.png');?>"/>
                      <div class="inner-form"><?php echo do_shortcode('[enews]'); ?></div>                   
                    </div>
                </div>
           
        </div> <!--home-3-->
        <div id="sponsors">
            <h2>Sponsors</h2>
            <?php kw_sc_logo_carousel('sponsors'); ?>
        </div>
        <?php
    }

    genesis();
