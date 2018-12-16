<?php
/*
  Template Name: Pàgina contingut
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
//add_filter('genesis_structural_wrap-site-inner', '__return_empty_string');
//* Remove .site-inner
//add_filter('genesis_markup_site-inner', '__return_null');
//add_filter('genesis_markup_content-sidebar-wrap', '__return_null');
//add_filter('genesis_markup_content', '__return_null');
// Force full width content layout.
add_filter('genesis_pre_get_option_site_layout', '__genesis_return_full_width_content');

// Reposition the breadcrumb navigation.
remove_action('genesis_before_loop', 'genesis_do_breadcrumbs');
add_action('genesis_before_content', 'genesis_do_breadcrumbs', 10);

// Remove Page Title.
remove_action('genesis_entry_header', 'genesis_do_post_title');

// Do not show Featured image if set in Theme Settings > Content Archives.
add_filter('genesis_pre_get_option_content_archive_thumbnail', '__return_false');

// Remove the post content
remove_action('genesis_entry_content', 'genesis_do_post_content');
remove_action('genesis_loop', 'genesis_do_loop');

// Add custom body class
add_filter('body_class', 'sgdg_contingut_body_class');

function sgdg_contingut_body_class($classes) {
    $classes[] = 'contingut-page';
    return $classes;
}

/*
 * Display Hero Image
 */
add_action('genesis_after_header', 'sjdg_contingut_hero');

function sjdg_contingut_hero() {
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
add_action('genesis_before_content', 'sjdg_contingut_content', 20);

function sjdg_contingut_content() {
    $continguts = get_post_meta(get_the_ID(), 'continguts', true);
    if ($continguts) {
        for ($i = 0; $i < $continguts; $i++) {
            $title = esc_html(get_post_meta(get_the_ID(), 'continguts_' . $i . '_titol', true));
            $imatge_1 = (int) get_post_meta(get_the_ID(), 'continguts_' . $i . '_imatge_1', true);
            $imatge_2 = (int) get_post_meta(get_the_ID(), 'continguts_' . $i . '_imatge_2', true);
            $resum = esc_html(get_post_meta(get_the_ID(), 'continguts_' . $i . '_resum', true));
            $text_complet = esc_html(get_post_meta(get_the_ID(), 'continguts_' . $i . '_text_complet', true));

            // Thumbnail field returns image ID, so grab image. If none provided, use default image
            $imatge_1 = $imatge_1 ? wp_get_attachment_image($imatge_1, 'full') : '<img src="' . get_stylesheet_directory_uri() . '/images/default-image.png" />';

            // Displayed in two columns, so using column classes
            $class = 0 == $i || 0 == $i % 2 ? 'image-text' : 'text-image';

            // Build the video box
            ?>
            <div class="<?php echo $class; ?>">
                <div class="contingut-images">

                    <?php echo $imatge_1; ?>

                    <div class="text-complet i-<?php echo $i; ?>">
                        <?php echo wp_get_attachment_image($imatge_2, 'full') ?>
                    </div>
                </div>
                <div class="contingut-text">
                    <h2><?php echo $title; ?></h2>
                    <div class="resum i-<?php echo $i; ?>">
                        <?php echo $resum; ?>
                    </div>
                    <div class="text-complet i-<?php echo $i; ?>">
                        <?php echo $text_complet; ?>
                    </div>
                    <a class="more-<?php echo $i; ?> <?php echo $i; ?>"></a>

                </div>

            </div>
            <?php
        } //for
    } //if continguts
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        $(".more-0").click(function () {
            this.classList.toggle("active");
            $(".i-0").toggle(300);

        });
        $(".more-1").click(function () {
            this.classList.toggle("active");
            $(".i-1").toggle(300);

        });
        $(".more-2").click(function () {
            this.classList.toggle("active");
            $(".i-2").toggle(300);

        });
        $(".more-3").click(function () {
            this.classList.toggle("active");
            $(".i-3").toggle(300);

        });
    });

</script>

<?php
genesis();
