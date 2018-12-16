<?php
/**
 * Template to show `portfolio` CPT entries grouped by month.
 */
//Removes Title and Description on CPT Archive
remove_action('genesis_before_loop', 'genesis_do_cpt_archive_title_description');

// Remove default loop.
remove_action('genesis_loop', 'genesis_do_loop');


/*
 * Display Hero Image
 */
add_action('genesis_after_header', 'sjdg_serveis_hero');

function sjdg_serveis_hero() {
    ?>
    <style>
        .site-inner {
            margin-top: 0 !important;
        }
    </style>

    <div class="hero-image">
        <img src="//santjoandegracia.cat/mediactiu/wp-content/uploads/2018/11/hero-contingut.jpg" />
    </div>
    <?php
}

// Add custom loop.
add_action('genesis_loop', 'sk_custom_loop');

/**
 * This function outputs posts grouped by month - year.
 */
function sk_custom_loop() {
// WP_Query arguments.
    $args = array(
        'post_type' => array('fullparroquial'),
        'posts_per_page' => -1,
        'order' => 'DESC',
    );

// The Query.
    $query = new WP_Query($args);

// The Loop.
    if ($query->have_posts()) {
        echo '<div id="full-parroquial"><h1 class="archive-title">' . post_type_archive_title('', false) . '</h1>';
        echo '<p>Dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna.</p>';
        echo '<ul class="flex-full-parroquial">';
        while ($query->have_posts()) {
            $query->the_post();
            $titol = esc_html(get_post_meta(get_the_ID(), 'titol', true));
            $date = get_post_meta(get_the_ID(), 'data', true);
            $pdf = get_post_meta(get_the_ID(), 'pdf', true);
            $imatge = get_post_meta(get_the_ID(), 'imatge', true);
            // get raw date
            // make date object
            $date = new DateTime($date);
            $url = wp_get_attachment_url($pdf);


            // current post's published date month.
            $current_post_month = get_the_date('F');

//             if (0 === $query->current_post) { // for the oldest post, show the Month Year.
//                 echo '<h2 class="date">';
//                 the_date('F Y');
//                 echo '</h2>';
//             } else { // for all other posts, get the month of the previous post in the loop.
                $p = $query->current_post - 1;
                $previous_post_month = mysql2date('F', $query->posts[$p]->post_date);
//             }

            // if the current post's month does not match with that of the next one, show the Month Year.
            if ($previous_post_month !== $current_post_month) {
                echo '<h2 class="date">';
                the_date('F Y');
                echo '</h2>';
            }

            // show the linked title.
            ?>

            <li class="featured-post">
                <a href="<?php echo $url; ?>" target="_blank">
                    <?php echo wp_get_attachment_image($imatge, 'full'); ?>
                    <div class="featured-post-content">
                        <p><?php echo $date->format('j M Y'); ?></p>
                        <h3><?php echo get_the_title(); ?></h3>
                    </div>
                </a>
            </li>
            <?php
        }
        echo '</ul></div>';
    } else {
        // no posts found.
    }

    // Restore original Post Data.
    wp_reset_postdata();
}

genesis();
