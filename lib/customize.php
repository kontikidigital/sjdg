<?php
/**
 * Sant Joan de Gracia.
 *
 * This file adds the Customizer additions to the Sant Joan de Gracia Theme.
 *
 * @package Sant Joan de Gracia
 * @author  Max Terbeck
 * @license GPL-2.0+
 * @link    https://www.mediactiu.com/
 */

add_action( 'customize_register', 'sjdg_customizer_register' );
/**
 * Registers settings and controls with the Customizer.
 *
 * @since 2.2.3
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function sjdg_customizer_register( $wp_customize ) {

	$wp_customize->add_setting(
		'sjdg_link_color',
		array(
			'default'           => sjdg_customizer_get_default_link_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'sjdg_link_color',
			array(
				'description' => __( 'Change the color of post info links, hover color of linked titles, hover color of menu items, and more.', 'sjdg' ),
				'label'       => __( 'Link Color', 'sjdg' ),
				'section'     => 'colors',
				'settings'    => 'sjdg_link_color',
			)
		)
	);

	$wp_customize->add_setting(
		'sjdg_accent_color',
		array(
			'default'           => sjdg_customizer_get_default_accent_color(),
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'sjdg_accent_color',
			array(
				'description' => __( 'Change the default hovers color for button.', 'sjdg' ),
				'label'       => __( 'Accent Color', 'sjdg' ),
				'section'     => 'colors',
				'settings'    => 'sjdg_accent_color',
			)
		)
	);

	$wp_customize->add_setting(
		'sjdg_logo_width',
		array(
			'default'           => 350,
			'sanitize_callback' => 'absint',
		)
	);

	// Add a control for the logo size.
	$wp_customize->add_control(
		'sjdg_logo_width',
		array(
			'label'       => __( 'Logo Width', 'sjdg' ),
			'description' => __( 'The maximum width of the logo in pixels.', 'sjdg' ),
			'priority'    => 9,
			'section'     => 'title_tagline',
			'settings'    => 'sjdg_logo_width',
			'type'        => 'number',
			'input_attrs' => array(
				'min' => 100,
			),

		)
	);

}
