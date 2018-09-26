<?php
function drum_customize_register( $wp_customize ) {
	// Add Footer Panel
	$wp_customize->add_panel( 'footer', array(
		'title' => __( 'Footer' ),
		'description' => '',
		'priority' => 160
	));
	
	// Add Social Section to Footer Panel
	$wp_customize->add_section('social_networks_section', array(
		'title' => 'Social',
		'panel' => 'footer',
		'description' => '',
		'priority' => 120,
	));
	// Add Featured Images Settings Section
	$wp_customize->add_section('featured_section', array(
		'title' => 'Featured Images',
		'description' => '',
		'priority' => 120,
	));
	// Add Company Locations Section to Footer Panel
	$wp_customize->add_section('locations_section', array(
		'title' => 'Locations',
		'panel' => 'footer',
		'description' => '',
		'priority' => 120,
	));
	// Add Global Settings Section
	$wp_customize->add_section('global_section', array(
		'title' => 'Global Settings',
		'description' => '',
		'priority' => 120,
	));
}
add_action( 'customize_register', 'drum_customize_register' );

// Set site logo using Wordpress Customizer
function drum_logo_customize_register( $wp_customize ) {
    $wp_customize->add_setting( 'site_logo' ); // Add setting for logo uploader
    // Add control for logo uploader (actual uploader)
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'drum_logo', array(
        'label'    => __( 'Upload Logo', 'drum' ),
        'section'  => 'title_tagline',
        'description'  => 'Please try to keep the <strong>logo width to 250 pixels</strong>.',
        'settings' => 'site_logo',
    )));
}
add_action( 'customize_register', 'drum_logo_customize_register' );

// Set admin logo using Wordpress Customizer
function admin_logo_customize_register( $wp_customize ) {
    $wp_customize->add_setting( 'admin_logo' ); // Add setting for logo uploader
    // Add control for logo uploader (actual uploader)
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'admin_logo', array(
        'label'    => __( 'Admin Logo', 'drum' ),
        'section'  => 'global_section',
        'description'  => 'This logo displays in the top left of the admin at <strong>20 pixels wide</strong>.',
        'settings' => 'admin_logo',
    )));
}
add_action( 'customize_register', 'admin_logo_customize_register' );

if( class_exists('Kirki') ) { 
	Kirki::add_field( 'social_networks_field', array(
		'type'        => 'repeater',
		'label'       => esc_attr__( 'Social Networks', 'textdomain' ),
		'section'     => 'social_networks_section',
		'priority'    => 10,
		'row_label' => array(
			'type' => 'field',
			'value' => esc_attr__('Social Network', 'textdomain' ),
			'field' => 'network_select',
		),
		'settings'    => 'social_networks',
		'fields' => array(
			'network_select' => array(
				'type'		=> 'select',
				'label'       => __( 'Social Network', 'textdomain' ),
				'default'     => '',
				'priority'    => 10,
				'choices'     => array(
					'' => esc_attr__( 'Select Social Network', 'textdomain' ),
					'facebook' => esc_attr__( 'Facebook', 'textdomain' ),
					'twitter' => esc_attr__( 'Twitter', 'textdomain' ),
					'google' => esc_attr__( 'Google +', 'textdomain' ),
					'linkedin' => esc_attr__( 'LinkedIn', 'textdomain' ),
					'youtube' => esc_attr__( 'YouTube', 'textdomain' ),
					'instagram' => esc_attr__( 'Instagram', 'textdomain' ),
					'pinterest-p' => esc_attr__( 'Pinterest', 'textdomain' ),
					'houzz' => esc_attr__( 'Houzz', 'textdomain' ),
					'rss' => esc_attr__( 'RSS', 'textdomain' ),
				),
			),
			'link_url' => array(
				'type'        => 'link',
				'label'       => esc_attr__( 'URL', 'textdomain' ),
				'default'     => '',
			),
		)
	) );
	
	Kirki::add_field( 'default_featured_image_field', array(
		'type'        => 'image',
		'settings'    => 'default_featured',
		'label'       => esc_attr__( 'Default Featured Image', 'textdomain' ),
		'description' => esc_attr__( 'Will be sized and cropped to ' . $GLOBALS['featured_image_size'] . ' pixels.', 'textdomain' ),
		'section'     => 'featured_section',
		'default'     => '',
		'choices'     => array(
			'save_as' => 'id',
		),
	) );
	
	Kirki::add_field( 'featured_dimensions', array(
		'type'        => 'dimensions',
		'settings'    => 'featured_dimensions',
		'label'       => esc_attr__( 'Featured Image Dimensions', 'textdomain' ),
		'section'     => 'featured_section',
		'default'     => array(
			'width'  => '1400px',
			'height' => '380px',
		),
	));

	Kirki::add_field( 'home_featured_dimensions', array(
		'type'        => 'dimensions',
		'settings'    => 'home_featured_dimensions',
		'label'       => esc_attr__( 'Homepage Featured Image Dimensions', 'textdomain' ),
		'section'     => 'featured_section',
		'default'     => array(
			'width'  => '1400px',
			'height' => '380px',
		),
	));
	
	Kirki::add_field( 'locations_field', array(
		'type'        => 'repeater',
		'label'       => esc_attr__( 'Company Locations', 'textdomain' ),
		'section'     => 'locations_section',
		'priority'    => 10,
		'row_label' => array(
			'type' => 'field',
			'value' => esc_attr__('Location', 'textdomain' ),
			'field' => 'loc_title',
		),
		'settings'    => 'locations',
		'fields' => array(
			'loc_title' => array(
				'type'        => 'text',
				'label'       => esc_attr__( 'Title', 'textdomain' ),
				'default'     => '',
			),
			'loc_address' => array(
				'type'        => 'text',
				'label'       => esc_attr__( 'Street Address', 'textdomain' ),
				'default'     => '',
			),
			'loc_address_2' => array(
				'type'        => 'text',
				'label'       => esc_attr__( 'Street Address Line 2', 'textdomain' ),
				'default'     => '',
			),
			'loc_city' => array(
				'type'        => 'text',
				'label'       => esc_attr__( 'City', 'textdomain' ),
				'default'     => '',
			),
			'loc_state' => array(
				'type'        => 'text',
				'label'       => esc_attr__( 'State', 'textdomain' ),
				'default'     => '',
			),
			'loc_zip' => array(
				'type'        => 'text',
				'label'       => esc_attr__( 'Zip Code', 'textdomain' ),
				'default'     => '',
			),
			'loc_phone' => array(
				'type'        => 'text',
				'label'       => esc_attr__( 'Phone', 'textdomain' ),
				'default'     => '',
			),
			'loc_email' => array(
				'type'        => 'text',
				'label'       => esc_attr__( 'Email', 'textdomain' ),
				'default'     => '',
			),
		)
	));
	Kirki::add_field( 'sr_field', array(
		'type'        => 'checkbox',
		'settings'    => 'sr_toggle',
		'label'       => esc_attr__( 'Enable ScrollReveal', 'textdomain' ),
		'section'     => 'global_section',
		'default'     => true,
	));
	Kirki::add_field( 'wysiwyg_colors_field', array(
		'type'        => 'repeater',
		'label'       => esc_attr__( 'WYSIWYG Colors', 'textdomain' ),
		'section'     => 'global_section',
		'priority'    => 10,
		'row_label' => array(
			'type'  => 'field',
			'value' => esc_attr__('Color', 'textdomain' ),
			'field' => 'color_name',
		),
		'settings'    => 'wysiwyg_colors',
		'fields' => array(
			'color_name' => array(
				'type'        => 'text',
				'label'       => esc_attr__( 'Color Name', 'textdomain' ),
				'default'     => '',
			),
			'color' => array(
				'type'        => 'color',
				'label'       => esc_attr__( 'Color', 'textdomain' ),
			),
		)
	));	
	Kirki::add_field( 'terms_page_field', array(
		'type'        => 'dropdown-pages',
		'settings'    => 'terms_page',
		'label'       => esc_attr__( 'Terms Page', 'textdomain' ),
		'section'     => 'global_section',
		'default'     => true,
	));
	Kirki::add_field( 'privacy_page_field', array(
		'type'        => 'dropdown-pages',
		'settings'    => 'privacy_page',
		'label'       => esc_attr__( 'Privacy Page', 'textdomain' ),
		'section'     => 'global_section',
		'default'     => true,
	));
	Kirki::add_field( 'newsletter_form_field', array(
		'type'     => 'text',
		'settings' => 'newsletter_gfid',
		'label'    => __( 'Newsletter Form ID', 'textdomain' ),
		'section'  => 'global_section',
		'priority' => 10,
	));	
}
