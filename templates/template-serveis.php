<?php
/*
  Template Name: Pàgina serveis
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
add_filter('body_class', 'sgdg_serveis_body_class');

function sgdg_serveis_body_class($classes) {
    $classes[] = 'serveis-page';
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
add_action('genesis_before_content', 'sjdg_serveis_content', 20);

add_action('genesis_before_content', 'sjdg_tramits_contingut', 30);

function sjdg_serveis_content() {
    //Serveis
    $serveis = get_post_meta(get_the_ID(), 'serveis', true);
    if ($serveis) {
        for ($i = 0; $i < $serveis; $i++) {
            $title = esc_html(get_post_meta(get_the_ID(), 'serveis_' . $i . '_titol', true));
            $imatge = (int) get_post_meta(get_the_ID(), 'serveis_' . $i . '_imatge', true);
            $resum = esc_html(get_post_meta(get_the_ID(), 'serveis_' . $i . '_resum', true));
            $enllac_text_complet = esc_url(get_post_meta(get_the_ID(), 'serveis_' . $i . '_enllac_al_text_complet', true));
            $background_color = get_post_meta(get_the_ID(), 'serveis_' . $i . '_color_de_fons_text', true);
            // Thumbnail field returns image ID, so grab image. If none provided, use default image
            $imatge = $imatge ? wp_get_attachment_image($imatge, 'full') : '<img src="' . get_stylesheet_directory_uri() . '/images/default-image.png" />';

// Displayed in two columns, so using column classes
//            $class = 0 == $i || 0 == $i % 2 ? 'image-text' : 'text-image';
// Build the box
            ?>
            <div id="serveis">
                <?php if (0 == $i || 0 == $i % 2) {
                    ?>
                    <div class="image-text" style="background-color:<?php echo $background_color; ?>;">
                        <div class="serveis-images">
                            <?php echo $imatge; ?>
                        </div> <!-- serveis-images-->
                        <div class="serveis-text-overlay" style="background-color:<?php echo $background_color; ?>;">
                            <div class="serveis-text">
                                <h2><?php echo $title; ?></h2>
                                <div class="resum">
                                    <?php echo $resum; ?>
                                </div> <!-- resum-->
                                <?php if ($enllac_text_complet) { ?>
                                    <div class="link-text-complet">
                                        <?php echo $enllac_text_complet; ?>
                                    </div> <!-- link-text-complet-->
                                <?php } ?>
                            </div> <!-- serveis-text-->
                        </div> <!-- serveis-text-overlay-->
                    </div> <!-- image-text-->
                <?php } else { ?>
                  <div class="image-text mobile" style="background-color:<?php echo $background_color; ?>;">
                        <div class="serveis-images">
                            <?php echo $imatge; ?>
                        </div> <!-- serveis-images-->
                        <div class="serveis-text-overlay" style="background-color:<?php echo $background_color; ?>;">
                            <div class="serveis-text">
                                <h2><?php echo $title; ?></h2>
                                <div class="resum">
                                    <?php echo $resum; ?>
                                </div> <!-- resum-->
                                <?php if ($enllac_text_complet) { ?>
                                    <div class="link-text-complet">
                                        <?php echo $enllac_text_complet; ?>
                                    </div> <!-- link-text-complet-->
                                <?php } ?>
                            </div> <!-- serveis-text-->
                        </div> <!-- serveis-text-overlay-->
                    </div> <!-- image-text-->
              
                    <div class="text-image medium-size" style="background-color:<?php echo $background_color; ?>;">
                        <div class="serveis-text-overlay" style="background-color:<?php echo $background_color; ?>;">
                            <div class="serveis-text">
                                <h2><?php echo $title; ?></h2>
                                <div class="resum">
                                    <?php echo $resum; ?>
                                </div> <!--resum-->
                                <?php if ($enllac_text_complet) { ?>
                                    <div class="link-text-complet">
                                        <?php echo $enllac_text_complet; ?>
                                    </div> <!-- link-text-complet-->
                                <?php } ?> <!-- if ($enllac_text_complet)-->
                            </div> <!-- serveis-text-->
                        </div> <!-- serveis-text-overlay-->
                        <div class="serveis-images">
                            <?php echo $imatge; ?>
                        </div> <!-- serveis-images-->
                    </div> <!-- text-image--> <?php
             
              
               } ?> <!-- else-->
            </div> <!-- serveis-->

            <?php
        }
    }
}

// Tramits
function sjdg_tramits_contingut() {
    $intro_tramits = esc_html(get_post_meta(get_the_ID(), 'text_introductori_tramits', true));
    $tramits = get_post_meta(get_the_ID(), 'tramits', true);


    if ($tramits) {
        ?>
        <div class="serveis-bottom-division"></div>
        <div class="serveis-bottom">
        <div id="tramits">
            <div class="tramits-intro">
                <h2><?php echo __('Tramits', 'sjdg'); ?></h2>
                <p><?php echo $intro_tramits; ?></p>
            </div> <!--tramits-intro-->
            <?php
            for ($i = 0; $i < $tramits; $i++) {
                $titol_tramit = esc_html(get_post_meta(get_the_ID(), 'tramits_' . $i . '_titol_tramit', true));
                $text_tramit = esc_html(get_post_meta(get_the_ID(), 'tramits_' . $i . '_text_tramit', true));
                $enllac_tramit = esc_url(get_post_meta(get_the_ID(), 'tramits_' . $i . '_enllac_tramit', true));
                $accordion_background_color = get_post_meta(get_the_ID(), 'tramits_' . $i . '_color_de_fons', true);
                $titol_arxiu = esc_html(get_post_meta(get_the_ID(), 'tramits_' . $i . '_titol_arxiu', true));
                $arxiu = get_post_meta(get_the_ID(), 'tramits_' . $i . '_arxiu', true);
                $url = wp_get_attachment_url($arxiu);
                ?>
                <button class="accordion" style="background-color:<?php echo $accordion_background_color; ?>;"><span><?php echo $titol_tramit; ?></span></button>
                <div class="panel">
                    <p><?php echo $text_tramit; ?>
                        <?php echo $enllac_tramit; ?></p>
                  <?php if ($titol_arxiu && $arxiu) {?>
                    <a class="tramits-download" href="<?php echo $url; ?>" target="_blank"><?php echo $titol_arxiu; ?></a>
                  <?php } ?>
                  
                </div> <!--panel-->
            <?php } //for ?>
        </div> <!--tramits-->
        <div id="contacte">         
          <div class="home-form-wrapper">
            <img class="form-background" src="<?php echo site_url('/wp-content/uploads/2018/11/fons-contacte.jpg');?>"/>
            <div class="inner-form">
              <h2><?php echo __('Contacta amb nosaltres', 'sjdg'); ?></h2>
              <?php echo do_shortcode('[contact-form-7 id="100" title="Contacte_serveis"]'); ?>
            </div><!--inner-form-->              
          </div><!--home-form-wrapper-->
       </div><!--contacte-->
    </div><!--serveis-bottom-->


    <?php } //if ?>

    <script>
        var acc = document.getElementsByClassName("accordion");
        var i;
         for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function () {
               for(var j = 0; j < acc.length; j++) {
                acc[j].nextElementSibling.style.maxHeight = null;
                acc[j].classList.remove('active');
              }
               this.classList.toggle("active");
                var panel = this.nextElementSibling;
                
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null;
                } else {
                    panel.style.maxHeight = panel.scrollHeight + "px";
                }
            });
        }

    </script>

   <?php
}

genesis();
