<?php

	/**
	 * For full documentation, please visit: http://docs.reduxframework.com/
	 * For a more extensive sample-config file, you may look at:
	 * https://github.com/reduxframework/redux-framework/blob/master/sample/sample-config.php
	 */

	if ( ! class_exists( 'Redux' ) ) {
			return;
	}

	// This is our option name where all the Redux data is stored.
	$opt_name = "alchemists_data";

	/**
	 * ---> SET ARGUMENTS
	 * All the possible arguments for Redux.
	 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
	 * */

	$theme = wp_get_theme(); // For use with some settings. Not necessary.

	$args = array(
			'opt_name' => 'alchemists_data',
			'dev_mode' => FALSE,
			'disable_tracking' => TRUE,
			'use_cdn' => TRUE,
			'display_name' => $theme->get( 'Name' ),
			'display_version' => $theme->get( 'Version' ),
			'page_slug' => '_options',
			'page_title' => esc_html__('Theme Options', 'alchemists'),
			'admin_bar' => TRUE,
			'menu_type' => 'menu',
			'menu_title' => esc_html__('Theme Options', 'alchemists'),
			'admin_bar_icon' => 'dashicons-admin-generic',
			'allow_sub_menu' => TRUE,
			'page_parent_post_type' => 'alchemists_options_post_type',
			'customizer' => TRUE,
			'hints' => array(
				'icon'          => 'el el-question-sign',
				'icon_position' => 'right',
				'icon_size'     => 'normal',
				'tip_style'     => array(
					'color' => 'dark',
				),
				'tip_position' => array(
					'my' => 'top left',
					'at' => 'bottom right',
				),
				'tip_effect' => array(
					'show' => array(
						'duration' => '500',
						'event'    => 'mouseover',
					),
					'hide' => array(
						'duration' => '500',
						'event'    => 'mouseleave unfocus',
					),
				),
			),
			'output' => TRUE,
			'output_tag' => TRUE,
			'settings_api' => TRUE,
			'cdn_check_time' => '1440',
			'compiler' => TRUE,
			'page_permissions' => 'manage_options',
			'save_defaults' => TRUE,
			'show_import_export' => TRUE,
			'transient_time' => '3600',
			'network_sites' => TRUE,
	);

	Redux::setArgs( $opt_name, $args );

	/*
	 * ---> END ARGUMENTS
	 */




	/*
	 *
	 * ---> START SECTIONS
	 *
	 */

	// ACTUAL DECLARATION OF SECTIONS

	// General Settings
	Redux::setSection( $opt_name, array(
		'title'     => esc_html__('General Settings', 'alchemists'),
		'icon'      => 'el-icon-cogs',
		'id'        => 'alchemists__section-general',
		'fields'    => array(
			array(
				'id'        => 'alchemists__opt-logo-standard',
				'type'      => 'media',
				'url'       => true,
				'title'     => esc_html__('Custom Logo', 'alchemists'),
				'compiler'  => 'true',
				//'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'      => esc_html__('Upload your image or specify the image URL.', 'alchemists'),
			),
			array(
				'id'        => 'alchemists__opt-logo-retina',
				'type'      => 'media',
				'url'       => true,
				'title'     => esc_html__('Custom Logo @2x', 'alchemists'),
				'compiler'  => 'true',
				//'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'      => esc_html__('Upload your image for retina displays or specify the image URL. It should be x2 time bigger than standard logo image.', 'alchemists'),
			),
			array(
				'id'             => 'alchemists__opt-logo-width',
				'type'           => 'dimensions',
				'units'          => array( 'px' ),
				'units_extended' => 'false',
				'title'          => esc_html__( 'Custom Logo Width', 'alchemists' ),
				'subtitle'       => esc_html__( 'Set your Logo width.', 'alchemists' ),
				'desc'           => esc_html__( 'Logo width can be set in px. Height will automatically calculated. Default is 148px', 'alchemists' ),
				'height'         => false,
				'mode'           => array(
					'width'  => true,
					'height' => false,
				),
				'hint'        => array(
					'content'   => esc_html__( 'Default is 148px', 'alchemists' ),
				),
			),
			array(
				'id'             => 'alchemists__opt-logo-width-mobile',
				'type'           => 'dimensions',
				'units'          => array( 'px' ),
				'units_extended' => 'false',
				'title'          => esc_html__( 'Custom Logo Width on Mobile', 'alchemists' ),
				'subtitle'       => esc_html__( 'Set your Logo width on Mobile devices.', 'alchemists' ),
				'desc'           => esc_html__( 'Logo width can be set in px. Height will automatically calculated. Default is 97px', 'alchemists' ),
				'height'         => false,
				'mode'           => array(
					'width'  => true,
					'height' => false,
				),
				'hint'        => array(
					'content'   => esc_html__( 'Default is 97px', 'alchemists' ),
				),
			),
			array(
				'id'        => 'alchemists__opt-logo-position',
				'type'      => 'switch',
				'title'     => esc_html__( 'Adjust Logo Position?', 'alchemists'),
				'subtitle'  => esc_html__( 'Enable Logo Position Adjustments.', 'alchemists'),
				'default'   => 0,
				'on'        => esc_html__('Yes', 'alchemists'),
				'off'       => esc_html__('No', 'alchemists'),
			),
			array(
				'id'             => 'alchemists__opt-logo-position-desktop',
				'type'           => 'spacing',
				'mode'           => 'absolute',
				'units'          => array('px'),
				'units_extended' => 'false',
				'top'            => false,
				'left'           => false,
				'title'          => esc_html__( 'Logo Position - Desktop', 'alchemists' ),
				'subtitle'       => esc_html__( 'Adjust Logo position for desktops.', 'alchemists' ),
				'desc'           => esc_html__( 'Use this field to adjust Logo position. You can also use negative values. Note: For screens more than 992px', 'alchemists' ),
				'default'        => array(
					'bottom' => '0px',
					'right'  => '0px',
					'units'  => 'px',
				),
				'required'       => array('alchemists__opt-logo-position', '=', '1'),
			),
			array(
				'id'             => 'alchemists__opt-logo-position-mobile',
				'type'           => 'spacing',
				'mode'           => 'absolute',
				'units'          => array('px'),
				'units_extended' => 'false',
				'top'            => false,
				'left'           => false,
				'title'          => esc_html__( 'Logo Position - Mobile', 'alchemists' ),
				'subtitle'       => esc_html__( 'Adjust Logo position for mobile devices.', 'alchemists' ),
				'desc'           => esc_html__( 'Use this field to adjust Logo position. You can also use negative values. Note: For screens less than 991px', 'alchemists' ),
				'default'        => array(
					'bottom' => '5px',
					'right'  => '0px',
					'units'  => 'px',
				),
				'required'       => array('alchemists__opt-logo-position', '=', '1'),
			),
		)
	) );


	// Header
	Redux::setSection( $opt_name, array(
		'title'     => esc_html__( 'Header', 'alchemists' ),
		'icon'      => 'el-icon-arrow-up',
		'id'        => 'alchemists__section-header',
		'fields'    => array(

		)
	) );

	// Header Top Bar
	Redux::setSection( $opt_name, array(
		'title'      => esc_html__( 'Top Bar', 'alchemists' ),
		'subsection' => true,
		'id'         => 'alchemists__subsection-header-top-bar',
		'fields'     => array(
			array(
				'id'        => 'alchemists__header-top-bar',
				'type'      => 'switch',
				'title'     => esc_html__('Show Top Bar?', 'alchemists'),
				'default'   => 1,
				'on'        => esc_html__('Yes', 'alchemists'),
				'off'       => esc_html__('No', 'alchemists'),
			),
			array(
				'id'        => 'alchemists__header-top-bar-links',
				'type'      => 'switch',
				'title'     => esc_html__('Show Top Menu?', 'alchemists'),
				'default'   => 1,
				'on'        => esc_html__('Yes', 'alchemists'),
				'off'       => esc_html__('No', 'alchemists'),
				'required'  => array('alchemists__header-top-bar', '=', '1'),
			),
		)
	) );

	// Header Primary
	Redux::setSection( $opt_name, array(
		'title'      => esc_html__( 'Primary', 'alchemists' ),
		'subsection' => true,
		'id'         => 'alchemists__subsection-header-primary',
		'fields'     => array(
			// Header Primary Height
			array(
				'id'       => 'alchemists__header-primary-height',
				'type'     => 'slider',
				'title'    => esc_html__( 'Nav Height', 'alchemists' ),
				'desc'     => esc_html__( 'Set Header Primary/Navigation height in px', 'alchemists' ),
				'default'  => 62,
				'min'      => 50,
				'step'     => 1,
				'max'      => 120,
				'display_value' => 'text',
			),
			array(
				'id'        => 'alchemists__header-primary-social',
				'type'      => 'switch',
				'title'     => esc_html__('Show Social Links?', 'alchemists'),
				'default'   => 1,
				'on'        => esc_html__('Yes', 'alchemists'),
				'off'       => esc_html__('No', 'alchemists'),
			),
			array(
				'id'       => 'alchemists__header-primary-social-links',
				'type'     => 'sortable',
				'title'    => esc_html__( 'Social Media Links', 'alchemists' ),
				'subtitle' => esc_html__( 'Define and reorder these links however you want.', 'alchemists' ),
				'desc'     => esc_html__( 'Leave empty a field if you don\'t want to display particular social media link.', 'alchemists' ),
				'label'    => true,
				'mode'     => 'text',
				'options'  => array(
					esc_html__( 'Facebook URL', 'alchemists' ) => '',
					esc_html__( 'Twitter URL', 'alchemists' )   => '',
					esc_html__( 'Google+ URL', 'alchemists' ) => '',
					esc_html__( 'LinkedIn URL', 'alchemists' ) => '',
					esc_html__( 'Instagram URL', 'alchemists' ) => '',
					esc_html__( 'Github URL', 'alchemists' ) => '',
					esc_html__( 'VK URL', 'alchemists' ) => '',
					esc_html__( 'YouTube URL', 'alchemists' ) => '',
					esc_html__( 'Pinterest URL', 'alchemists' ) => '',
					esc_html__( 'Tumblr URL', 'alchemists' ) => '',
					esc_html__( 'Dribbble URL', 'alchemists' ) => '',
					esc_html__( 'Vimeo URL', 'alchemists' ) => '',
					esc_html__( 'Flickr URL', 'alchemists' ) => '',
					esc_html__( 'Yelp URL', 'alchemists' ) => '',
				),
				'default'  => array(
					esc_html__( 'Facebook URL', 'alchemists' )   => '#',
					esc_html__( 'Twitter URL', 'alchemists' )   => '#',
					esc_html__( 'Google+ URL', 'alchemists' ) => '#',
					esc_html__( 'LinkedIn URL', 'alchemists' ) => '',
					esc_html__( 'Instagram URL', 'alchemists' ) => '',
					esc_html__( 'Github URL', 'alchemists' ) => '',
					esc_html__( 'VK URL', 'alchemists' ) => '',
					esc_html__( 'YouTube URL', 'alchemists' ) => '',
					esc_html__( 'Pinterest URL', 'alchemists' ) => '',
					esc_html__( 'Tumblr URL', 'alchemists' ) => '',
					esc_html__( 'Dribbble URL', 'alchemists' ) => '',
					esc_html__( 'Vimeo URL', 'alchemists' ) => '',
					esc_html__( 'Flickr URL', 'alchemists' ) => '',
					esc_html__( 'Yelp URL', 'alchemists' ) => '',
				),
				'required'  => array('alchemists__header-primary-social', '=', '1'),
			),

			array(
				'id'       => 'alchemists__mobile-nav-width',
				'type'     => 'slider',
				'title'    => esc_html__( 'Mobile Nav Width', 'alchemists' ),
				'desc'     => esc_html__( 'Set Mobile Nav Custom Width in px', 'alchemists' ),
				'default'  => 270,
				'min'      => 200,
				'step'     => 1,
				'max'      => 320,
				'display_value' => 'text',
			),

		)
	) );

	// Header Secondary
	Redux::setSection( $opt_name, array(
		'title'      => esc_html__( 'Secondary', 'alchemists' ),
		'subsection' => true,
		'id'         => 'alchemists_subsection-header-secondary',
		'fields'     => array(

			// Search Form
			array(
				'id'        => 'alchemists__header-search-form',
				'type'      => 'switch',
				'title'     => esc_html__('Show Search Form?', 'alchemists'),
				'default'   => 1,
				'on'        => esc_html__('Yes', 'alchemists'),
				'off'       => esc_html__('No', 'alchemists'),
			),

			// Email - Primary
			array(
				'id'        => 'alchemists__header-secondary-info-1',
				'type'      => 'switch',
				'title'     => esc_html__('Show Primary Email?', 'alchemists'),
				'default'   => 1,
				'on'        => esc_html__('Yes', 'alchemists'),
				'off'       => esc_html__('No', 'alchemists'),
			),
			array(
				'id'        => 'alchemists__header-secondary-info-1-label',
				'type'      => 'text',
				'title'     => esc_html__( 'Label for Primary Email Address', 'alchemists' ),
				'default'   => esc_html__( 'Join Our Team!', 'alchemists' ),
				'required'  => array('alchemists__header-secondary-info-1', '=', '1'),
			),
			array(
				'id'        => 'alchemists__header-secondary-info-1-email',
				'type'      => 'text',
				'title'     => esc_html__('Primary Email address', 'alchemists'),
				'default'   => 'tryouts@alchemists.com',
				'required'  => array('alchemists__header-secondary-info-1', '=', '1'),
				'desc'      => esc_html__( 'As an option you can also enter a simple link, e.g. yoursite.com', 'alchemists'),
			),
			array(
				'id'        => 'alchemists__header-secondary-info-1-icon-custom',
				'type'      => 'text',
				'title'     => esc_html__('Primary Email Custom Icon', 'alchemists'),
				'desc'      => __( 'Add your custom icon, e.g. <code>&lt;i class="fa fa-user"&gt;&lt;/i&gt;</code> or <code>&lt;img src="PATH_TO_IMAGE" /&gt;</code>', 'alchemists'),
				'default'   => '',
				'required'  => array('alchemists__header-secondary-info-1', '=', '1'),
			),

			// Email - Secondary
			array(
				'id'        => 'alchemists__header-secondary-info-2',
				'type'      => 'switch',
				'title'     => esc_html__('Show Secondary Email?', 'alchemists'),
				'default'   => 1,
				'on'        => esc_html__('Yes', 'alchemists'),
				'off'       => esc_html__('No', 'alchemists'),
			),
			array(
				'id'        => 'alchemists__header-secondary-info-2-label',
				'type'      => 'text',
				'title'     => esc_html__( 'Label for Secondary Email address', 'alchemists' ),
				'default'   => esc_html__( 'Contact Us', 'alchemists' ),
				'required'  => array('alchemists__header-secondary-info-2', '=', '1'),
			),
			array(
				'id'        => 'alchemists__header-secondary-info-2-email',
				'type'      => 'text',
				'title'     => esc_html__('Secondary Email address', 'alchemists'),
				'default'   => 'info@alchemists.com',
				'required'  => array('alchemists__header-secondary-info-2', '=', '1'),
				'desc'      => esc_html__( 'As an option you can also enter a simple link, e.g. yoursite.com', 'alchemists'),
			),
			array(
				'id'        => 'alchemists__header-secondary-info-2-icon-custom',
				'type'      => 'text',
				'title'     => esc_html__('Secondary Email Custom Icon', 'alchemists'),
				'desc'      => __( 'Add your custom icon, e.g. <code>&lt;i class="fa fa-user"&gt;&lt;/i&gt;</code> or <code>&lt;img src="PATH_TO_IMAGE" /&gt;</code>', 'alchemists'),
				'default'   => '',
				'required'  => array('alchemists__header-secondary-info-2', '=', '1'),
			),


			// Shopping Cart
			array(
				'id'        => 'alchemists__header-shopping-cart-notice',
				'type'      => 'info',
				'notice'    => true,
				'icon'      => 'el el-icon-warning-sign',
				'style'     => 'warning',
				'title'     => esc_html__('WooCommerce Options', 'alchemists'),
				'desc'      => esc_html__('The following options are available if WooCommerce installed.', 'alchemists')
			),
			array(
				'id'        => 'alchemists__header-shopping-cart',
				'type'      => 'switch',
				'title'     => esc_html__('Show Shopping Cart?', 'alchemists'),
				'default'   => 1,
				'on'        => esc_html__('Yes', 'alchemists'),
				'off'       => esc_html__('No', 'alchemists'),
			),
			array(
				'id'        => 'alchemists__header-shopping-cart-icon-custom',
				'type'      => 'text',
				'title'     => esc_html__('Shopping Cart Custom Icon', 'alchemists'),
				'desc'      => __( 'Add your custom icon, e.g. <code>&lt;i class="fa fa-user"&gt;&lt;/i&gt;</code> or <code>&lt;img src="PATH_TO_IMAGE" /&gt;</code>', 'alchemists'),
				'default'   => '',
				'required'  => array('alchemists__header-shopping-cart', '=', '1'),
			),

		)
	) );



	// Pushy Panel
	Redux::setSection( $opt_name, array(
		'title'      => esc_html__( 'Pushy Panel', 'alchemists' ),
		'subsection' => true,
		'id'         => 'alchemists__subsection-header-pushy-panel',
		'fields'     => array(
			array(
				'id'        => 'alchemists__header-pushy-panel',
				'type'      => 'switch',
				'title'     => esc_html__('Show Side Panel?', 'alchemists'),
				'default'   => 1,
				'on'        => esc_html__('Yes', 'alchemists'),
				'off'       => esc_html__('No', 'alchemists'),
			),
			array(
				'id'        => 'alchemists__header-pushy-panel-logo',
				'type'      => 'switch',
				'title'     => esc_html__('Add Logo to the Side Panel?', 'alchemists'),
				'default'   => 1,
				'on'        => esc_html__('Yes', 'alchemists'),
				'off'       => esc_html__('No', 'alchemists'),
				'required'  => array('alchemists__header-pushy-panel', '=', '1'),
			),
			array(
				'id'        => 'alchemists__opt-logo-pushy-standard',
				'type'      => 'media',
				'url'       => true,
				'title'     => esc_html__('Custom Logo', 'alchemists'),
				'compiler'  => 'true',
				//'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'      => esc_html__('Upload your image or specify the image URL.', 'alchemists'),
				'required'  => array('alchemists__header-pushy-panel-logo', '=', '1'),
			),
			array(
				'id'        => 'alchemists__opt-logo-pushy-retina',
				'type'      => 'media',
				'url'       => true,
				'title'     => esc_html__('Custom Logo @2x', 'alchemists'),
				'compiler'  => 'true',
				//'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'      => esc_html__('Upload your image for retina displays or specify the image URL. It should be x2 time bigger than standard logo image.', 'alchemists'),
				'required'  => array('alchemists__header-pushy-panel-logo', '=', '1'),
			),
			array(
				'id'             => 'alchemists__opt-logo-pushy-width',
				'type'           => 'dimensions',
				'units'          => array( 'px' ),
				'units_extended' => 'false',
				'title'          => esc_html__( 'Custom Logo Width', 'alchemists' ),
				'subtitle'       => esc_html__( 'Set your Logo width.', 'alchemists' ),
				'desc'           => esc_html__( 'Logo width can be set in px. Height will automatically calculated. Note: 94px by default.', 'alchemists' ),
				'output'         => array( '.pushy-panel__logo-img' ),
				'height'         => false,
				'mode'           => array(
					'width'  => true,
					'height' => false,
				),
				'required'  => array('alchemists__header-pushy-panel-logo', '=', '1'),
			),
		)
	) );


	// Page Heading
	Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'Page Heading', 'alchemists' ),
		'id'     => 'alchemists__section-page-heading',
		'icon'   => 'el el-website',
		'fields' => array(

		)
	) );


	// Page Heading: Title
	Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'Title', 'alchemists' ),
		'id'     => 'alchemists__section-page-heading-title',
		'subsection' => true,
		'fields' => array(
			array(
				'id'          => 'alchemists__page-title-background',
				'type'        => 'background',
				'output'      => array('.page-heading'),
				'title'       => esc_html__('Page Heading Background', 'alchemists'),
			),
			array(
				'id'          => 'alchemists__opt-page-title-overlay-on',
				'type'        => 'switch',
				'title'       => esc_html__('Add Overlay on Page Heading Image?', 'alchemists'),
				'subtitle'    => esc_html__('Turn on to add color overlay.', 'alchemists'),
				'default'     => 1,
				'on'          => esc_html__( 'Yes', 'alchemists' ),
				'off'         => esc_html__( 'No', 'alchemists' ),
			),
			array(
				'id'          => 'alchemists__opt-paget-title-overlay',
				'type'        => 'background',
				'output'      => array('.page-heading::before'),
				'title'       => esc_html__('Page Heading Overlay Background', 'alchemists'),
				'required'    => array('alchemists__opt-page-title-overlay-on', '=', '1'),
			),
			array(
				'id'          => 'alchemists__opt-page-title-spacing-on',
				'type'        => 'switch',
				'title'       => esc_html__('Customize Page Heading Padding?', 'alchemists'),
				'subtitle'    => esc_html__('Turn on to customize top padding.', 'alchemists'),
				'default'     => 0,
				'on'          => esc_html__( 'Yes', 'alchemists' ),
				'off'         => esc_html__( 'No', 'alchemists' ),
			),
			array(
				'id'             => 'alchemists__opt-page-title-spacing-desktop',
				'type'           => 'spacing',
				'mode'           => 'padding',
				'units'          => array('px'),
				'units_extended' => 'false',
				'left'           => false,
				'right'          => false,
				'title'          => esc_html__('Page Headings Paddings - Desktop', 'alchemists'),
				'subtitle'       => esc_html__('Set paddings for Desktop.', 'alchemists'),
				'desc'           => esc_html__('You can set Top Paddings for the Page Headings. Applied only for desktops.', 'alchemists'),
				'default'            => array(
					'padding-top'     => '110px',
					'padding-bottom'  => '106px',
					'units'           => 'px',
				),
				'required'  => array('alchemists__opt-page-title-spacing-on', '=', '1'),
			),
			array(
				'id'             => 'alchemists__opt-page-title-spacing-tablet',
				'type'           => 'spacing',
				'mode'           => 'padding',
				'units'          => array('px'),
				'units_extended' => 'false',
				'left'           => false,
				'right'          => false,
				'title'          => esc_html__('Page Headings Paddings - Tablet', 'alchemists'),
				'subtitle'       => esc_html__('Set paddings for Tablets.', 'alchemists'),
				'desc'           => esc_html__('You can set Top Paddings for the Page Headings. Applied only for tablets.', 'alchemists'),
				'default'            => array(
					'padding-top'     => '50px',
					'padding-bottom'  => '50px',
					'units'           => 'px',
				),
				'required'  => array('alchemists__opt-page-title-spacing-on', '=', '1'),
			),
			array(
				'id'             => 'alchemists__opt-page-title-spacing-mobile',
				'type'           => 'spacing',
				'mode'           => 'padding',
				'units'          => array('px'),
				'units_extended' => 'false',
				'left'           => false,
				'right'          => false,
				'title'          => esc_html__('Page Headings Paddings - Mobile', 'alchemists'),
				'subtitle'       => esc_html__('Set paddings for Mobile devices.', 'alchemists'),
				'desc'           => esc_html__('You can set Top Paddings for the Page Headings. Applied only for mobile devices.', 'alchemists'),
				'default'            => array(
					'padding-top'     => '50px',
					'padding-bottom'  => '50px',
					'units'           => 'px',
				),
				'required'  => array('alchemists__opt-page-title-spacing-on', '=', '1'),
			),
			array(
				'id'          => 'alchemists__opt-page-title-highlight',
				'type'        => 'switch',
				'title'       => esc_html__('Highlight Page Heading Last Word?', 'alchemists'),
				'subtitle'    => esc_html__('The last word highlighted by default.', 'alchemists'),
				'default'     => 1,
				'on'          => esc_html__( 'Yes', 'alchemists' ),
				'off'         => esc_html__( 'No', 'alchemists' ),
			),
			array(
				'id'          => 'alchemists__opt-page-title-breadcrumbs',
				'type'        => 'switch',
				'title'       => esc_html__('Show Breadcrumbs?', 'alchemists'),
				'subtitle'    => esc_html__('Turn on to show Breadcrumbs', 'alchemists'),
				'default'     => 1,
				'on'          => esc_html__( 'Yes', 'alchemists' ),
				'off'         => esc_html__( 'No', 'alchemists' ),
			),
			array(
				'id'          => 'alchemists__custom_breadcrumbs',
				'type'        => 'switch',
				'title'       => esc_html__('Customize Breadcrumbs Colors?', 'alchemists'),
				'subtitle'    => esc_html__('Turn on to change colors for Breadcrumbs.', 'alchemists'),
				'required'    => array('alchemists__opt-page-title-breadcrumbs', '=', '1'),
				'default'     => false,
				'on'          => esc_html__( 'Yes', 'alchemists' ),
				'off'         => esc_html__( 'No', 'alchemists' ),
			),
			array(
				'id'          => 'alchemists__opt-page-title-breadcrumbs-color',
				'type'        => 'link_color',
				'title'       => esc_html__( 'Breadcrumbs Link Color', 'alchemists' ),
				'subtitle'    => esc_html__( 'Color for Breadcrumbs links.', 'alchemists' ),
				'output'      => array( '.breadcrumbs ul.trail-items > li > a' ),
				'default'     => array(
					'regular' => '#fff',
					'hover'   => '#ffdc11',
					'active'  => '#ffdc11',
				),
				'required'    => array(
					array('alchemists__opt-page-title-breadcrumbs', '=', '1',),
					array('alchemists__custom_breadcrumbs', '=', '1',),
				),
			),
			array(
				'id'          => 'alchemists__opt-page-title-breadcrumbs-txt-color',
				'type'        => 'color',
				'output'      => array( '.breadcrumbs ul.trail-items > li.trail-end' ),
				'title'       => esc_html__( 'Breadcrumbs Current Crumb Color', 'alchemists' ),
				'subtitle'    => esc_html__( 'Color for Breadcrumbs Current text.', 'alchemists' ),
				'default'     => '#9a9da2',
				'required'    => array(
					array('alchemists__opt-page-title-breadcrumbs', '=', '1',),
					array('alchemists__custom_breadcrumbs', '=', '1',),
				),
			),
			array(
				'id'          => 'alchemists__opt-page-title-breadcrumbs-sep-color',
				'type'        => 'color',
				'title'       => esc_html__( 'Breadcrumbs Separator Color', 'alchemists' ),
				'subtitle'    => esc_html__( 'Color for Breadcrumbs Separator.', 'alchemists' ),
				'default'     =>  '#9a9da2',
				'required'    => array(
					array('alchemists__opt-page-title-breadcrumbs', '=', '1',),
					array('alchemists__custom_breadcrumbs', '=', '1',),
				),
			),
		)
	) );


	// Hero Unit: Static
	Redux::setSection( $opt_name, array(
		'title'      => esc_html__( 'Hero Unit - Static', 'alchemists' ),
		'id'         => 'alchemists__subsection-hero-static',
		'subsection' => true,
		'fields'     => array(

			// Hero Static -- Content
			array(
				'id'       => 'alchemists__hero-static--section-content-start',
				'type'     => 'section',
				'title'    => esc_html__( 'Content', 'alchemists' ),
				'subtitle' => esc_html__( 'Customize Hero Static output.', 'alchemists' ),
				'indent'   => true
			),
			array(
				'id'        => 'alchemists__opt-page-heading-hero-title',
				'type'      => 'text',
				'title'     => esc_html__( 'Title', 'alchemists' ),
				'validate'  => 'html',
				'desc'      => esc_html__( 'Enter Hero Unit Title.', 'alchemists' ),
				'default'   => wp_kses_post( __( 'The <span class="text-primary">Alchemists</span>', 'alchemists' ) ),
			),
			array(
				'id'        => 'alchemists__opt-page-heading-hero-subtitle',
				'type'      => 'text',
				'title'     => esc_html__( 'Subtitle', 'alchemists' ),
				'desc'      => esc_html__( 'Enter Hero Unit Subtitle.', 'alchemists' ),
				'default'   => esc_html__( 'Elric Bros School', 'alchemists' ),
			),
			array(
				'id'        => 'alchemists__opt-page-heading-hero-desc',
				'type'      => 'textarea',
				'rows'      => 2,
				'title'     => esc_html__( 'Description', 'alchemists' ),
				'default'   => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipisi nel elit, sed do eiusmod tempor incididunt ut labore et dolore.', 'alchemists' ),
			),
			array(
				'id'        => 'alchemists__opt-page-heading-hero-btn',
				'type'      => 'switch',
				'title'     => esc_html__('Show Button?', 'alchemists'),
				'subtitle'  => esc_html__('Turn on to display button.', 'alchemists'),
				'default'   => 1,
				'on'        => esc_html__( 'Yes', 'alchemists' ),
				'off'       => esc_html__( 'No', 'alchemists' ),
			),
			array(
				'id'        => 'alchemists__opt-page-heading-hero-btn-txt',
				'type'      => 'text',
				'title'     => esc_html__( 'Button Text', 'alchemists' ),
				'desc'      => esc_html__( 'Enter Button Text.', 'alchemists' ),
				'default'   => esc_html__( 'Read More', 'alchemists' ),
				'required'  => array('alchemists__opt-page-heading-hero-btn', '=', '1'),
			),
			array(
				'id'        => 'alchemists__opt-page-heading-hero-btn-link',
				'type'      => 'text',
				'title'     => esc_html__( 'Button Link', 'alchemists' ),
				'desc'      => esc_html__( 'Enter Button Link.', 'alchemists' ),
				'default'   => '#',
				'required'  => array('alchemists__opt-page-heading-hero-btn', '=', '1'),
			),
			array(
				'id'       => 'alchemists__hero-static--section-content-end',
				'type'     => 'section',
				'indent'   => false,
			),


			// Hero Static -- Styling
			array(
				'id'       => 'alchemists__hero-static--section-styling-start',
				'type'     => 'section',
				'title'    => esc_html__( 'Styling', 'alchemists' ),
				'subtitle' => esc_html__( 'Customize Hero Static styling.', 'alchemists' ),
				'indent'   => true
			),
			array(
				'id'          => 'alchemists__opt-page-heading-hero-bg',
				'type'        => 'background',
				'output'      => array('.hero-unit'),
				'title'       => esc_html__('Hero Unit Background', 'alchemists'),
				'preview'     => true,
				'default'     => array(
					'background-color'      => '#27313b',
					'background-image'      => get_template_directory_uri() . '/assets/images/header_bg.jpg',
					'background-repeat'     => 'no-repeat',
					'background-position'   => 'center top',
					'background-attachment' => 'inherit',
					'background-size'       => 'cover',
				)
			),
			array(
				'id'          => 'alchemists__opt-page-heading-hero-desc-color',
				'type'        => 'color',
				'title'       => esc_html__( 'Description Text Color', 'alchemists' ),
				'desc'        => esc_html__( 'Pick a custom color for the description text.', 'alchemists' ),
				'output'      => array('.hero-unit__desc'),
				'validate'    => 'color',
				'transparent' => false
			),
			array(
				'id'        => 'alchemists__opt-page-heading-hero-stars',
				'type'      => 'switch',
				'title'     => esc_html__('Show Stars?', 'alchemists'),
				'subtitle'  => esc_html__('Turn on to display stars.', 'alchemists'),
				'default'   => 1,
				'on'        => esc_html__( 'Yes', 'alchemists' ),
				'off'       => esc_html__( 'No', 'alchemists' ),
			),
			array(
				'id'             => 'alchemists__opt-page-heading-hero-height',
				'type'           => 'dimensions',
				'units'          => array( 'px' ),
				'units_extended' => 'false',
				'title'          => esc_html__( 'Hero Unit Height', 'alchemists' ),
				'subtitle'       => esc_html__( 'Set your custom height.', 'alchemists' ),
				'width'          => false,
				'mode'           => array(
					'width'  => false,
					'height' => true,
				),
				'hint'        => array(
					'content'   => esc_html__( 'Default is 640px', 'alchemists' ),
				),
			),
			array(
				'id'             => 'alchemists__opt-page-heading-hero-height-sm',
				'type'           => 'dimensions',
				'units'          => array( 'px' ),
				'units_extended' => 'false',
				'title'          => esc_html__( 'Hero Unit Height (Mobile)', 'alchemists' ),
				'subtitle'       => esc_html__( 'Set your custom height.', 'alchemists' ),
				'width'          => false,
				'mode'           => array(
					'width'  => false,
					'height' => true,
				),
				'hint'        => array(
					'content'   => esc_html__( 'Default is 400px', 'alchemists' ),
				),
			),
			array(
				'id'             => 'alchemists__opt-page-heading-hero-img',
				'type'           => 'switch',
				'title'          => esc_html__('Show Hero Image?', 'alchemists'),
				'subtitle'       => esc_html__('Turn on to display Hero Image.', 'alchemists'),
				'default'        => 1,
				'on'             => esc_html__( 'Yes', 'alchemists' ),
				'off'            => esc_html__( 'No', 'alchemists' ),
			),
			array(
				'id'             => 'alchemists__opt-page-heading-hero-img-upload',
				'type'           => 'media',
				'url'            => true,
				'title'          => esc_html__('Custom Hero Image', 'alchemists'),
				'compiler'       => true,
				'desc'           => esc_html__('Upload your image or specify the image URL.', 'alchemists'),
				'required'       => array('alchemists__opt-page-heading-hero-img', '=', '1'),
			),
			array(
				'id'             => 'alchemists__opt-page-heading-hero-align',
				'type'           => 'select',
				'title'          => esc_html__('Alignment', 'alchemists'),
				'subtitle'       => esc_html__('Select prefered text alignment', 'alchemists'),
				'options'        => array(
					'left'   => esc_html__( 'Left', 'alchemists' ),
					'center' => esc_html__( 'Center', 'alchemists' ),
					'right'  => esc_html__( 'Right', 'alchemists' ),
				),
				'default'   => 'left',
				'required'       => array('alchemists__opt-page-heading-hero-img', '=', '0'),
			),
			array(
				'id'       => 'alchemists__hero-static--section-styling-end',
				'type'     => 'section',
				'indent'   => false,
			),


		)
	) );


	// Hero Unit: Slider
	Redux::setSection( $opt_name, array(
		'title'      => esc_html__( 'Hero Unit - Posts Slider', 'alchemists' ),
		'id'         => 'alchemists__subsection-hero-posts-slider',
		'subsection' => true,
		'fields'     => array(

			// Hero Post Slider -- Content
			array(
				'id'       => 'alchemists__hero-posts-slider--section-content-start',
				'type'     => 'section',
				'title'    => esc_html__( 'Post Options', 'alchemists' ),
				'subtitle' => esc_html__( 'Customize posts output.', 'alchemists' ),
				'indent'   => true
			),
			array(
				'id'       => 'alchemists__hero-posts-slider--per-page',
				'type'     => 'spinner',
				'title'    => esc_html__( 'Number of Posts', 'alchemists' ),
				'subtitle' => esc_html__( 'Number of Blog Posts to display', 'alchemists' ),
				'desc'     => esc_html__( 'Use arrows to increase/decrease the number of posts to display.', 'alchemists' ),
				'default'  => '3',
				'min'      => '1',
				'step'     => '1',
				'max'      => '24',
			),
			array(
				'id'       => 'alchemists__hero-posts-slider--orderby',
				'type'     => 'select',
				'title'    => esc_html__( 'Order By', 'alchemists' ),
				'subtitle' => esc_html__( 'Posts Order By', 'alchemists' ),
				'desc'     => esc_html__( 'Sort retrieved posts by parameter.', 'alchemists' ),
				'options'   => array(
					'date'          => esc_html__( 'Date', 'alchemists' ),
					'ID'            => esc_html__( 'ID', 'alchemists' ),
					'author'        => esc_html__( 'Author', 'alchemists' ),
					'title'         => esc_html__( 'Title', 'alchemists' ),
					'modified'      => esc_html__( 'Modified', 'alchemists' ),
					'comment_count' => esc_html__( 'Comment count', 'alchemists' ),
					'menu_order'    => esc_html__( 'Menu order', 'alchemists' ),
					'rand'          => esc_html__( 'Random', 'alchemists' ),
				),
				'default'   => 'date'
			),
			array(
				'id'       => 'alchemists__hero-posts-slider--order',
				'type'     => 'button_set',
				'title'    => esc_html__( 'Order', 'alchemists' ),
				'subtitle' => esc_html__( 'Posts Order', 'alchemists' ),
				'desc'     => esc_html__( 'Designates the ascending or descending order of the "orderby" parameter.', 'alchemists' ),
				'options' => array(
					'DESC' => 'Descending',
					'ASC' => 'Ascending',
				 ),
				'default' => 'DESC'
			),
			array(
				'id'          => 'alchemists__hero-posts-slider--categories',
				'type'        => 'select',
				'multi'       => true,
				'title'       => esc_html__( 'Categories', 'alchemists' ),
				'subtitle'    => esc_html__( 'Select posts categories', 'alchemists' ),
				'desc'        => esc_html__( 'Show posts associated with certain categories.', 'alchemists' ),
				'placeholder' => esc_html__( 'Select categories', 'alchemists' ),
				'data'        => 'categories',
			),
			array(
				'id'          => 'alchemists__hero-posts-slider--tags',
				'type'        => 'select',
				'multi'       => true,
				'title'       => esc_html__( 'Tags', 'alchemists' ),
				'subtitle'    => esc_html__( 'Select posts tags', 'alchemists' ),
				'desc'        => esc_html__( 'Show posts associated with certain tags.', 'alchemists' ),
				'placeholder' => esc_html__( 'Select tags', 'alchemists' ),
				'data'        => 'tags',
			),
			array(
				'id'       => 'alchemists__hero-posts-slider',
				'type'     => 'select',
				'multi'    => true,
				'title'    => esc_html__( 'Posts', 'alchemists' ),
				'subtitle' => esc_html__( 'Specify posts to retrieve', 'alchemists' ),
				'desc'     => esc_html__( 'Each selected post will be displayed as a separate slide in Hero Posts Slider if enabled.', 'alchemists' ),
				'data'     => 'posts',
				'placeholder' => esc_html__( 'Select posts', 'alchemists' ),
				'args' => array(
					'posts_per_page' => -1,
				),
			),
			array(
				'id'        => 'alchemists__hero-posts-meta',
				'type'      => 'switch',
				'title'     => esc_html__('Enable Post Meta?', 'alchemists'),
				'subtitle'  => esc_html__('Turn on to show Post Meta Info.', 'alchemists'),
				'desc'      => esc_html__('Includes date, views, likes, comments.', 'alchemists'),
				'default'   => 1,
				'on'        => esc_html__( 'Yes', 'alchemists' ),
				'off'       => esc_html__( 'No', 'alchemists' ),
			),
			array(
				'id'        => 'alchemists__hero-posts-meta',
				'type'      => 'switch',
				'title'     => esc_html__('Post Meta', 'alchemists'),
				'subtitle'  => esc_html__('Turn on to show Posts Meta Info.', 'alchemists'),
				'desc'      => esc_html__('Includes date, views, likes, comments.', 'alchemists'),
				'default'   => 1,
				'on'        => esc_html__( 'Show', 'alchemists' ),
				'off'       => esc_html__( 'Hide', 'alchemists' ),
			),
			array(
				'id'        => 'alchemists__hero-posts-author',
				'type'      => 'switch',
				'title'     => esc_html__('Post Author', 'alchemists'),
				'subtitle'  => esc_html__('Turn on to show Post Author.', 'alchemists'),
				'desc'      => esc_html__('Includes avatar, author display name, author nickname.', 'alchemists'),
				'default'   => 1,
				'on'        => esc_html__( 'Show', 'alchemists' ),
				'off'       => esc_html__( 'Hide', 'alchemists' ),
			),
			array(
				'id'        => 'alchemists__hero-posts-category',
				'type'      => 'switch',
				'title'     => esc_html__('Post Category', 'alchemists'),
				'subtitle'  => esc_html__('Turn on to show Post Category.', 'alchemists'),
				'desc'      => esc_html__('Post Category displayed above the Post Title.', 'alchemists'),
				'default'   => 1,
				'on'        => esc_html__( 'Show', 'alchemists' ),
				'off'       => esc_html__( 'Hide', 'alchemists' ),
			),
			array(
				'id'        => 'alchemists__hero-posts-thumb-category',
				'type'      => 'switch',
				'title'     => esc_html__('Post Category in Thumbs', 'alchemists'),
				'subtitle'  => esc_html__('Turn on to show Category label in Thumbs.', 'alchemists'),
				'desc'      => esc_html__('Post Category label displayed above the Post Title in Thumbs controls.', 'alchemists'),
				'default'   => 1,
				'on'        => esc_html__( 'Show', 'alchemists' ),
				'off'       => esc_html__( 'Hide', 'alchemists' ),
			),
			array(
				'id'        => 'alchemists__hero-posts-height',
				'type'      => 'switch',
				'title'     => esc_html__('Customize Height?', 'alchemists'),
				'subtitle'  => esc_html__('Turn on to to customize Posts Slider height.', 'alchemists'),
				'default'   => 0,
				'on'        => esc_html__( 'Yes', 'alchemists' ),
				'off'       => esc_html__( 'No', 'alchemists' ),
			),
			array(
				'id'             => 'alchemists__hero-posts-height-desktop',
				'type'           => 'dimensions',
				'units'          => array( 'px' ),
				'units_extended' => 'false',
				'title'          => esc_html__( 'Height - Desktop', 'alchemists' ),
				'subtitle'       => esc_html__( 'Set your custom height.', 'alchemists' ),
				'width'          => false,
				'mode'           => array(
					'width'  => false,
					'height' => true,
				),
				'hint'        => array(
					'content'   => esc_html__( 'Default is 720px', 'alchemists' ),
				),
				'required'       => array('alchemists__hero-posts-height', '=', '1'),
			),
			array(
				'id'             => 'alchemists__hero-posts-height-tablet-landscape',
				'type'           => 'dimensions',
				'units'          => array( 'px' ),
				'units_extended' => 'false',
				'title'          => esc_html__( 'Height - Tablet Landscape', 'alchemists' ),
				'subtitle'       => esc_html__( 'Set your custom height.', 'alchemists' ),
				'width'          => false,
				'mode'           => array(
					'width'  => false,
					'height' => true,
				),
				'hint'        => array(
					'content'   => esc_html__( 'Default is 640px', 'alchemists' ),
				),
				'required'       => array('alchemists__hero-posts-height', '=', '1'),
			),
			array(
				'id'             => 'alchemists__hero-posts-height-tablet-portrait',
				'type'           => 'dimensions',
				'units'          => array( 'px' ),
				'units_extended' => 'false',
				'title'          => esc_html__( 'Height - Tablet Portrait', 'alchemists' ),
				'subtitle'       => esc_html__( 'Set your custom height.', 'alchemists' ),
				'width'          => false,
				'mode'           => array(
					'width'  => false,
					'height' => true,
				),
				'hint'        => array(
					'content'   => esc_html__( 'Default is 480px', 'alchemists' ),
				),
				'required'       => array('alchemists__hero-posts-height', '=', '1'),
			),
			array(
				'id'             => 'alchemists__hero-posts-height-mobile',
				'type'           => 'dimensions',
				'units'          => array( 'px' ),
				'units_extended' => 'false',
				'title'          => esc_html__( 'Height - Mobile', 'alchemists' ),
				'subtitle'       => esc_html__( 'Set your custom height.', 'alchemists' ),
				'width'          => false,
				'mode'           => array(
					'width'  => false,
					'height' => true,
				),
				'hint'        => array(
					'content'   => esc_html__( 'Default is 320px', 'alchemists' ),
				),
				'required'       => array('alchemists__hero-posts-height', '=', '1'),
			),
			array(
				'id'       => 'alchemists__hero-posts-slider--section-content-end',
				'type'     => 'section',
				'indent'   => false,
			),

			// Hero Post Slider -- Settings
			array(
				'id'       => 'alchemists__hero-posts-slider--section-settings-start',
				'type'     => 'section',
				'title'    => esc_html__( 'Slider Settings', 'alchemists' ),
				'subtitle' => esc_html__( 'Setting up your Slider settings.', 'alchemists' ),
				'indent'   => true,
			),
			array(
				'id'        => 'alchemists__hero-posts-autoplay',
				'type'      => 'switch',
				'title'     => esc_html__( 'Autoplay', 'alchemists' ),
				'subtitle'  => esc_html__( 'Enables slider autoplay.', 'alchemists' ),
				'desc'      => esc_html__( 'Autoplay enabled by default.', 'alchemists' ),
				'default'   => 1,
				'on'        => esc_html__( 'On', 'alchemists' ),
				'off'       => esc_html__( 'Off', 'alchemists' ),
			),
			array(
				'id'       => 'alchemists__hero-posts-autoplay-speed',
				'type'     => 'slider',
				'title'    => esc_html__( 'Autoplay Speed', 'alchemists' ),
				'subtitle' => esc_html__( 'Delay duration between slide animation.', 'alchemists' ),
				'desc'     => esc_html__( 'Duration in seconds, Min: 3, max: 20, step: 0.5, default value: 8', 'alchemists' ),
				'default'  => 8,
				'min'      => 3,
				'step'     => 0.5,
				'max'      => 20,
				'resolution' => 0.1,
				'display_value' => 'text',
				'required'    => array(
					array('alchemists__hero-posts-autoplay', '=', '1'),
				),
			),
			array(
				'id'       => 'alchemists__hero-posts-slider--section-settings-end',
				'type'     => 'section',
				'indent'   => false,
			),
		)
	) );


	// Blog & Posts
	Redux::setSection( $opt_name, array(
		'title'     => esc_html__('Blog & Posts', 'alchemists'),
		'icon'      => 'el-icon-cogs',
		'id'        => 'alchemists__section-blog-post',
		'fields'    => array(
			array(
				'id'        => 'alchemists__opt-blog-filter',
				'type'      => 'switch',
				'title'     => esc_html__('Enable Posts Filter?', 'alchemists'),
				'subtitle'  => esc_html__('Turn on to show Posts Filter.', 'alchemists'),
				'desc'      => esc_html__('Posts Filter displayed by default.', 'alchemists'),
				'default'   => 1,
				'on'        => esc_html__( 'Yes', 'alchemists' ),
				'off'       => esc_html__( 'No', 'alchemists' ),
			),
			array(
				'id'        => 'alchemists__posts-filter-sorter',
				'type'      => 'sorter',
				'title'     => esc_html__( 'Posts Filter', 'alchemists' ),
				'subtitle'  => esc_html__( 'Elements order in the filter.', 'alchemists' ),
				'desc'      => esc_html__( 'Organize how you want the Posts Filters element to appear on a blog page.', 'alchemists' ),
				'compiler'  => 'true',
				'options'   => array(
					'enabled'   => array(
						'filter__category' => esc_html__( 'Categories', 'alchemists' ),
						'filter__orderby'  => esc_html__( 'Order By', 'alchemists' ),
						'filter__order'    => esc_html__( 'Order', 'alchemists' ),
						'filter__author'   => esc_html__( 'Author', 'alchemists' ),
					),
					'disabled'  => array(),
				),
				'required' => array( 'alchemists__opt-blog-filter', '=', '1' ),
			),
			array(
				'id'        => 'alchemists__blog-posts-style',
				'type'      => 'image_select',
				'compiler'  => true,
				'title'     => esc_html__('Blog Style', 'alchemists'),
				'subtitle'  => esc_html__('Posts style displayed on Blog page.', 'alchemists'),
				'desc'      => esc_html__('Select prefered Blog style.', 'alchemists'),
				'options'   => array(
					'1' => array(
						'alt' => esc_html__('Cards (fitrows)', 'alchemists'),
						'img' => get_template_directory_uri() . '/admin/images/blog-1.png'
					),
					'2' => array(
						'alt' => esc_html__('List (Left Thumbnail)', 'alchemists'),
						'img' => get_template_directory_uri() . '/admin/images/blog-2.png'
					),
					'3' => array(
						'alt' => esc_html__('List (Large Thumbnail)', 'alchemists'),
						'img' => get_template_directory_uri() . '/admin/images/blog-3.png'
					),
					'4' => array(
						'alt' => esc_html__('Masonry', 'alchemists'),
						'img' => get_template_directory_uri() . '/admin/images/blog-4.png'
					),
				),
				'default'   => '2'
			),
			array(
				'id'        => 'alchemists__blog-sidebar',
				'type'      => 'image_select',
				'compiler'  => true,
				'title'     => esc_html__('Sidebar Position', 'alchemists'),
				'subtitle'  => esc_html__('Blog Sidebar Position.', 'alchemists'),
				'desc'      => esc_html__('Select sidebar alignment for classic Blog.', 'alchemists'),
				'options'   => array(
					'1' => array(
						'alt' => esc_html__('Right Sidebar', 'alchemists'),
						'img' => ReduxFramework::$_url . 'assets/img/2cr.png'
					),
					'2' => array(
						'alt' => esc_html__('Left Sidebar', 'alchemists'),
						'img' => ReduxFramework::$_url . 'assets/img/2cl.png'
					),
					'3' => array(
						'alt' => esc_html__('No Sidebar', 'alchemists'),
						'img' => ReduxFramework::$_url . 'assets/img/1c.png'
					),
				),
				'default'   => '1'
			),
			array(
				'id'        => 'alchemists__opt-social-counters',
				'type'      => 'switch',
				'title'     => esc_html__('Add Social Counters between Posts?', 'alchemists'),
				'subtitle'  => esc_html__('Turn on to add Social Counter.', 'alchemists'),
				'desc'      => esc_html__('Social Counters displayed for Masontry Blog Style.', 'alchemists'),
				'default'   => 1,
				'on'        => esc_html__( 'Yes', 'alchemists' ),
				'off'       => esc_html__( 'No', 'alchemists' ),
				'required' => array('alchemists__blog-posts-style', '=', '4'),
			),
			array(
				'id'        => 'alchemists__opt-social-counters-fb',
				'type'      => 'text',
				'validate'  => 'numeric',
				'title'     => esc_html__( 'Facebook Counter Position', 'alchemists' ),
				'desc'      => esc_html__( 'Number of post where Facebook Counter will be displayed. Enter 0 to not display counter.', 'alchemists' ),
				'default'   => 2,
				'required' => array('alchemists__opt-social-counters', '=', '1'),
			),
			array(
				'id'        => 'alchemists__opt-social-counters-twitter',
				'type'      => 'text',
				'validate'  => 'numeric',
				'title'     => esc_html__( 'Twitter Counter Position', 'alchemists' ),
				'desc'      => esc_html__( 'Number of post where Twitter Counter will be displayed. Enter 0 to not display counter.', 'alchemists' ),
				'default'   => 4,
				'required' => array('alchemists__opt-social-counters', '=', '1'),
			),
			array(
				'id'        => 'alchemists__opt-social-counters-gplus',
				'type'      => 'text',
				'validate'  => 'numeric',
				'title'     => esc_html__( 'Google+ Counter Position', 'alchemists' ),
				'desc'      => esc_html__( 'Number of post where Google+ Counter will be displayed. Enter 0 to not display counter.', 'alchemists' ),
				'default'   => 8,
				'required' => array('alchemists__opt-social-counters', '=', '1'),
			),
			array(
				'id'        => 'alchemists__opt-social-counters-instagram',
				'type'      => 'text',
				'validate'  => 'numeric',
				'title'     => esc_html__( 'Instagram Counter Position', 'alchemists' ),
				'desc'      => esc_html__( 'Number of post where Instagram Counter will be displayed. Enter 0 to not display counter.', 'alchemists' ),
				'default'   => 0,
				'required' => array('alchemists__opt-social-counters', '=', '1'),
			),
		)
	) );

	// Posts
	Redux::setSection( $opt_name, array(
		'title'      => esc_html__( 'Posts', 'alchemists' ),
		'subsection' => true,
		'id'         => 'alchemists__subsection-posts',
		'fields'     => array(
			array(
				'id'             => 'alchemists__posts-categories',
				'type'           => 'switch',
				'title'          => esc_html__('Show Categories?', 'alchemists'),
				'subtitle'       => esc_html__('Posts categories displayed by default.', 'alchemists'),
				'default'        => 1,
				'on'             => esc_html__( 'Yes', 'alchemists' ),
				'off'            => esc_html__( 'No', 'alchemists' ),
			),
			array(
				'id'       => 'alchemists__categories-group-1',
				'type'     => 'select',
				'multi'    => true,
				'title'    => esc_html__( 'Categories Group 1', 'alchemists' ),
				'subtitle' => esc_html__( 'Select categories for Group 1', 'alchemists' ),
				'desc'     => esc_html__( 'Assign post categories to Group 1.', 'alchemists' ),
				'data'     => 'categories',
				'required' => array('alchemists__posts-categories', '=', '1'),
			),
			array(
				'id'       => 'alchemists__categories-group-2',
				'type'     => 'select',
				'multi'    => true,
				'title'    => esc_html__( 'Categories Group 2', 'alchemists' ),
				'subtitle' => esc_html__( 'Select categories for Group 2', 'alchemists' ),
				'desc'     => esc_html__( 'Assign post categories to Group 3.', 'alchemists' ),
				'data'     => 'categories',
				'required' => array('alchemists__posts-categories', '=', '1'),
			),
			array(
				'id'       => 'alchemists__categories-group-3',
				'type'     => 'select',
				'multi'    => true,
				'title'    => esc_html__( 'Categories Group 3', 'alchemists' ),
				'subtitle' => esc_html__( 'Select categories for Group 3', 'alchemists' ),
				'desc'     => esc_html__( 'Assign post categories to Group 3.', 'alchemists' ),
				'data'     => 'categories',
				'required' => array('alchemists__posts-categories', '=', '1'),
			),
		)
	) );


	// Single Post
	Redux::setSection( $opt_name, array(
		'title'      => esc_html__( 'Single Post', 'alchemists' ),
		'id'         => 'alchemists__subsection-single-post',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'        => 'alchemists__opt-single-post-layout',
				'type'      => 'select',
				'title'     => esc_html__('Single Post Layout', 'alchemists'),
				'subtitle'  => esc_html__('Select Single Post Layout', 'alchemists'),
				'options'   => array(
					'1' => esc_html__( 'Layout 1', 'alchemists' ),
					'2' => esc_html__( 'Layout 2', 'alchemists' ),
					'3' => esc_html__( 'Layout 3', 'alchemists' ),
				),
				'default'   => '1'
			),
			array(
				'id'        => 'alchemists__opt-single-post-social',
				'type'      => 'switch',
				'title'     => esc_html__('Show Social Sharing?', 'alchemists'),
				'subtitle'  => esc_html__('Turn on to show social sharing buttons.', 'alchemists'),
				'desc'      => esc_html__('Social sharing buttons displayed by default.', 'alchemists'),
				'default'   => 1,
				'on'        => esc_html__( 'Yes', 'alchemists' ),
				'off'       => esc_html__( 'No', 'alchemists' ),
			),
			array(
				'id'        => 'alchemists__opt-single-post-social-sorter',
				'type'      => 'sorter',
				'title'     => esc_html__( 'Social Sharing Sorter', 'alchemists' ),
				'subtitle'  => esc_html__( 'Organize social sharing link.', 'alchemists' ),
				'desc'      => esc_html__( 'Drag and drop social sharing links from "Disabled" to "Enabled" group to display them on Single Post Page.', 'alchemists' ),
				'compiler'  => 'true',
				'options'   => array(
					'enabled'   => array(
						'social_facebook'    => esc_html__( 'Facebook', 'alchemists' ),
						'social_twitter'     => esc_html__( 'Twitter', 'alchemists' ),
						'social_google-plus' => esc_html__( 'Google+', 'alchemists' ),
					),
					'disabled'  => array(
						'social_linkedin'    => esc_html__( 'Linkedin', 'alchemists' ),
						'social_vk'          => esc_html__( 'VK', 'alchemists' ),
						'social_ok'          => esc_html__( 'Odnoklassniki', 'alchemists' ),
						'social_whatsapp'    => esc_html__( 'WhatsApp', 'alchemists' ),
						'social_viber'       => esc_html__( 'Viber', 'alchemists' ),
					),
				),
				'required'  => array('alchemists__opt-single-post-social', '=', '1'),
			),
			array(
				'id'        => 'alchemists__opt-single-post-author',
				'type'      => 'switch',
				'title'     => esc_html__('Show Post Author Box on Single Post?', 'alchemists'),
				'subtitle'  => esc_html__('Turn on to show post author box.', 'alchemists'),
				'desc'      => esc_html__('Post Author Box contains name, email, avatar and description.', 'alchemists'),
				'default'   => 1,
				'off'       => esc_html__( 'No', 'alchemists' ),
				'on'        => esc_html__( 'Yes', 'alchemists' ),
			),
		)
	) );

	// Content Settings
	Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'Content', 'alchemists' ),
		'id'     => 'alchemists__section-content',
		'icon'   => 'el el-indent-left',
		'fields' => array(
			array(
				'id'          => 'alchemists__opt-content-padding-on',
				'type'        => 'switch',
				'title'       => esc_html__( 'Customize Content Paddings?', 'alchemists' ),
				'subtitle'    => esc_html__( 'Turn on to customize the content paddings.', 'alchemists' ),
				'default'     => 0,
				'on'          => esc_html__( 'Yes', 'alchemists' ),
				'off'         => esc_html__( 'No', 'alchemists' ),
			),
			array(
				'id'             => 'alchemists__opt-content-padding-desktop',
				'type'           => 'spacing',
				'mode'           => 'padding',
				'units'          => array('px'),
				'units_extended' => 'false',
				'left'           => false,
				'right'          => false,
				'title'          => esc_html__('Content Paddings - Desktop', 'alchemists'),
				'subtitle'       => esc_html__('Set paddings for Desktop.', 'alchemists'),
				'desc'           => esc_html__('You can set paddings for the Content section. Applied only for desktops.', 'alchemists'),
				'default'            => array(
					'padding-top'     => '60px',
					'padding-bottom'  => '60px',
					'units'           => 'px',
				),
				'required'  => array('alchemists__opt-content-padding-on', '=', '1'),
			),
			array(
				'id'             => 'alchemists__opt-content-padding-tablet',
				'type'           => 'spacing',
				'mode'           => 'padding',
				'units'          => array('px'),
				'units_extended' => 'false',
				'left'           => false,
				'right'          => false,
				'title'          => esc_html__('Content Paddings - Tablet', 'alchemists'),
				'subtitle'       => esc_html__('Set paddings for Tablets.', 'alchemists'),
				'desc'           => esc_html__('You can set paddings for the Content section. Applied only for tablets.', 'alchemists'),
				'default'            => array(
					'padding-top'     => '60px',
					'padding-bottom'  => '60px',
					'units'           => 'px',
				),
				'required'  => array('alchemists__opt-content-padding-on', '=', '1'),
			),
			array(
				'id'             => 'alchemists__opt-content-padding-mobile',
				'type'           => 'spacing',
				'mode'           => 'padding',
				'units'          => array('px'),
				'units_extended' => 'false',
				'left'           => false,
				'right'          => false,
				'title'          => esc_html__('Content Paddings - Mobile', 'alchemists'),
				'subtitle'       => esc_html__('Set paddings for Mobile devices.', 'alchemists'),
				'desc'           => esc_html__('You can set paddings for the Content section. Applied only for mobile devices.', 'alchemists'),
				'default'            => array(
					'padding-top'     => '30px',
					'padding-bottom'  => '30px',
					'units'           => 'px',
				),
				'required'  => array('alchemists__opt-content-padding-on', '=', '1'),
			),
		)
	) );


	// Footer Settings
	Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'Footer', 'alchemists' ),
		'id'     => 'alchemists__section-footer',
		'icon'   => 'el el-arrow-down',
		'fields' => array(

		)
	) );

	// Footer Logo
	Redux::setSection( $opt_name, array(
		'title'      => esc_html__( 'Footer Logo', 'alchemists' ),
		'id'         => 'alchemists__subsection-footer-logo',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'        => 'alchemists__opt-footer-logo',
				'type'      => 'switch',
				'title'     => esc_html__('Display Footer Logo?', 'alchemists'),
				'subtitle'  => esc_html__('Turn on to show the Footer Logo.', 'alchemists'),
				'default'   => 1,
				'on'        => esc_html__( 'Yes', 'alchemists' ),
				'off'       => esc_html__( 'No', 'alchemists' ),
			),
			array(
				'id'        => 'alchemists__opt-logo-footer-standard',
				'type'      => 'media',
				'url'       => true,
				'title'     => esc_html__('Footer Custom Logo', 'alchemists'),
				'compiler'  => 'true',
				'desc'      => esc_html__('Upload your image or specify the image URL.', 'alchemists'),
				'required'    => array('alchemists__opt-footer-logo', '=', '1'),
			),
			array(
				'id'        => 'alchemists__opt-logo-footer-retina',
				'type'      => 'media',
				'url'       => true,
				'title'     => esc_html__('Footer Custom Logo @2x', 'alchemists'),
				'compiler'  => 'true',
				'desc'      => esc_html__('Upload your image for retina displays or specify the image URL. It should be x2 time bigger than standard logo image.', 'alchemists'),
				'required'    => array('alchemists__opt-footer-logo', '=', '1'),
			),
		)
	) );


	// Footer Widgets
	Redux::setSection( $opt_name, array(
		'title'      => esc_html__( 'Footer Widgets', 'alchemists' ),
		'id'         => 'alchemists__subsection-footer-widgets',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'        => 'alchemists__opt-footer-widgets',
				'type'      => 'switch',
				'title'     => esc_html__('Footer Widgets', 'alchemists'),
				'subtitle'  => esc_html__('Footer Widgets are displayed by default.', 'alchemists'),
				'default'   => 1,
				'on'        => esc_html__( 'Enable', 'alchemists' ),
				'off'       => esc_html__( 'Disable', 'alchemists' ),
			),
			array(
				'id'        => 'alchemists__opt-footer-widgets-layout',
				'type'      => 'image_select',
				'compiler'  => true,
				'title'     => esc_html__('Footer Widgets Layout', 'alchemists'),
				'subtitle'  => esc_html__('Select footer widgets layout (not equal or equal).', 'alchemists'),
				'options'   => array(
					'1' => array(
						'alt' => esc_html__( '3 Columns (equal)', 'alchemists' ),
						'img' => get_template_directory_uri() . '/admin/images/footer-cols-3.png'
					),
					'2' => array(
						'alt' => esc_html__( '4 Columns (equal)', 'alchemists' ),
						'img' => get_template_directory_uri() . '/admin/images/footer-cols-4.png'
					),
				),
				'default'   => 1,
				'required'  => array('alchemists__opt-footer-widgets', '=', '1'),
			),
		)
	) );

	// Footer Sponsors
	Redux::setSection( $opt_name, array(
		'title'      => esc_html__( 'Footer Sponsors', 'alchemists' ),
		'id'         => 'alchemists__subsection-footer-sponsors',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'        => 'alchemists__footer-sponsors',
				'type'      => 'switch',
				'title'     => esc_html__('Footer Sponsors', 'alchemists'),
				'subtitle'  => esc_html__('Footer Sponsors are hidden by default.', 'alchemists'),
				'default'   => 0,
				'on'        => esc_html__( 'Enable', 'alchemists' ),
				'off'       => esc_html__( 'Disable', 'alchemists' ),
			),
			array(
				'id'       => 'alchemists__footer-sponsors-title',
				'type'     => 'text',
				'title'    => esc_html__( 'Sponsors Title', 'alchemists' ),
				'subtitle' => esc_html__( 'Displayed before the images', 'alchemists' ),
				'default'  => esc_html__( 'Our Sponsors:', 'alchemists' ),
				'required' => array( 'alchemists__footer-sponsors', '=', '1' ),
			),
			array(
				'id'       => 'alchemists__footer-sponsors-images',
				'type'     => 'gallery',
				'title'    => esc_html__( 'Add/Edit Sponsors Images', 'alchemists' ),
				'desc'     => esc_html__( 'Create a list of Sponsors by selecting existing or uploading new images', 'alchemists' ),
				'required' => array( 'alchemists__footer-sponsors', '=', '1' ),
			),
		)
	) );

	// Footer Secondary
	Redux::setSection( $opt_name, array(
		'title'      => esc_html__( 'Secondary Footer', 'alchemists' ),
		'id'         => 'alchemists__subsection-footer-secondary',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'        => 'alchemists__opt-secondary',
				'type'      => 'switch',
				'title'     => esc_html__('Show Secondary Footer?', 'alchemists'),
				'subtitle'  => esc_html__('Turn on to show Footer Secondary Area', 'alchemists'),
				'default'   => 1,
				'on'        => esc_html__( 'Yes', 'alchemists' ),
				'off'       => esc_html__( 'No', 'alchemists' ),
			),
			array(
				'id'        => 'alchemists__footer-secondary-copyright--info',
				'type'      => 'info',
				'notice'    => true,
				'icon'      => 'el el-icon-info-circle',
				'style'     => 'info',
				'title'     => esc_html__( 'Soccer Version', 'alchemists' ),
				'desc'      => __('Displayed only for Soccer version.', 'alchemists')
			),
			array(
				'id'        => 'alchemists__footer-secondary-copyright',
				'type'      => 'editor',
				'title'     => esc_html__( 'Copyright Text', 'alchemists' ),
				'subtitle'  => esc_html__( 'Add copyright text here.', 'alchemists' ),
				'default'   => '<a href="//themeforest.net/item/alchemists-sports-club-and-news-wordpress-theme/20256220?ref=dan_fisher">The Alchemists</a> 2017 &nbsp; | &nbsp; All Rights Reserved',
				'compiler'  => true,
				'args'      => array(
					'teeny'         => true,
					'media_buttons' => false,
					'quicktags'     => true,
					'textarea_rows' => 2,
				),
				'required'  => array('alchemists__opt-secondary', '=', '1'),
			),
		)
	) );


	// Styling Options
	Redux::setSection( $opt_name, array(
		'title'     => esc_html__( 'Styling', 'alchemists' ),
		'icon'      => 'el-icon-tint',
		'id'        => 'alchemists__section-styling',
		'fields'    => array(
			array(
				'id'        => 'alchemists__color-preset',
				'type'      => 'image_select',
				'compiler'  => false,
				'presets'   => true,
				'title'     => esc_html__('Color Presets', 'alchemists'),
				'desc'      => esc_html__('Choose color preset you want to use.', 'alchemists'),
				'default'   => '1',
				'options'   => array(

					// Color Scheme: Basketball
					'1' => array(
						'alt' => esc_html__( 'Basketball', 'alchemists' ),
						'img' => get_template_directory_uri() . '/admin/images/pallete-basketball.png',
						'presets' => array(
							'color-primary'        => '#ffdc11',
							'color-primary-darken' => '#ffcc00',
							'color-dark'           => '#1e2024',
							'color-dark-lighten'   => '#292c31',
							'color-gray'           => '#9a9da2',
							'color-2'              => '#31404b',
							'color-3'              => '#ff7e1f',
							'color-4'              => '#9a66ca',
						)
					),

					// Color Scheme: Soccer
					'2' => array(
						'alt' => esc_html__( 'Soccer', 'alchemists' ),
						'img' => get_template_directory_uri() . '/admin/images/pallete-soccer.png',
						'presets' => array(
							'color-primary'        => '#38a9ff',
							'color-primary-darken' => '#1892ed',
							'color-dark'           => '#1e2024',
							'color-dark-lighten'   => '#292c31',
							'color-gray'           => '#9a9da2',
							'color-2'              => '#31404b',
							'color-3'              => '#07e0c4',
							'color-4'              => '#c2ff1f',
							'color-4-darken'       => '#9fe900',
						)
					),
				),
			),

			array(
				'id'          => 'color-primary',
				'type'        => 'color',
				'title'       => esc_html__( 'Primary Color', 'alchemists' ),
				'subtitle'    => esc_html__( 'Pick a primary color.', 'alchemists' ),
				'default'     => '#ffdc11',
				'validate'    => 'color',
				'transparent' => false
			),
			array(
				'id'          => 'color-primary-darken',
				'type'        => 'color',
				'title'       => esc_html__( 'Primary Color - Alt', 'alchemists' ),
				'subtitle'    => esc_html__( 'Pick a primary alt color.', 'alchemists' ),
				'default'     => '#ffcc00',
				'validate'    => 'color',
				'transparent' => false
			),
			array(
				'id'          => 'color-dark',
				'type'        => 'color',
				'title'       => esc_html__( 'Dark Color', 'alchemists' ),
				'subtitle'    => esc_html__( 'Pick a dark color.', 'alchemists' ),
				'default'     => '#1e2024',
				'validate'    => 'color',
				'transparent' => false
			),
			array(
				'id'          => 'color-dark-lighten',
				'type'        => 'color',
				'title'       => esc_html__( 'Dark Color - Lighten', 'alchemists' ),
				'subtitle'    => esc_html__( 'Pick a dark lighten color.', 'alchemists' ),
				'default'     => '#292c31',
				'validate'    => 'color',
				'transparent' => false
			),
			array(
				'id'          => 'color-gray',
				'type'        => 'color',
				'title'       => esc_html__( 'Gray Color', 'alchemists' ),
				'subtitle'    => esc_html__( 'Pick a gray color.', 'alchemists' ),
				'default'     => '#9a9da2',
				'validate'    => 'color',
				'transparent' => false
			),
			array(
				'id'          => 'color-2',
				'type'        => 'color',
				'title'       => esc_html__( 'Secondary Color', 'alchemists' ),
				'subtitle'    => esc_html__( 'Pick a secondary color.', 'alchemists' ),
				'default'     => '#31404b',
				'validate'    => 'color',
				'transparent' => false
			),
			array(
				'id'          => 'color-3',
				'type'        => 'color',
				'title'       => esc_html__( 'Tertiary Color', 'alchemists' ),
				'subtitle'    => esc_html__( 'Pick a tertiary color.', 'alchemists' ),
				'default'     => '#ff7e1f',
				'validate'    => 'color',
				'transparent' => false
			),
			array(
				'id'          => 'color-4',
				'type'        => 'color',
				'title'       => esc_html__( 'Quaternary Color', 'alchemists' ),
				'subtitle'    => esc_html__( 'Pick a quaternary color.', 'alchemists' ),
				'default'     => '#9a66ca',
				'validate'    => 'color',
				'transparent' => false
			),
			array(
				'id'          => 'color-4-darken',
				'type'        => 'color',
				'title'       => esc_html__( 'Quaternary Color - Alt', 'alchemists' ),
				'subtitle'    => esc_html__( 'Pick a quaternary alt color.', 'alchemists' ),
				'validate'    => 'color',
				'transparent' => false,
				'required'    => array('alchemists__color-preset', '=', '2'),
			),

		)
	) );


	// Styling: Body
	Redux::setSection( $opt_name, array(
		'title'      => esc_html__( 'Base', 'alchemists' ),
		'id'         => 'alchemists__subsection-styling-body',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'          => 'alchemists__body-bg',
				'type'        => 'background',
				'output'      => array('body'),
				'title'       => esc_html__( 'Body Background', 'alchemists' ),
				'subtitle'    => esc_html__( 'Body styling options', 'alchemists' ),
				'desc'        => esc_html__( 'Customize Body Background with color, background image, background position etc.', 'alchemists' ),
			),
			array(
				'id'          => 'alchemists__link-color',
				'type'        => 'link_color',
				'active'      => false,
				'title'       => esc_html__( 'Link Color', 'alchemists' ),
				'subtitle'    => esc_html__( 'Color for links.', 'alchemists' ),
			),
		)
	) );


	// Styling: Top Bar
	Redux::setSection( $opt_name, array(
		'title'      => esc_html__( 'Top Bar', 'alchemists' ),
		'subsection' => true,
		'id'         => 'alchemists__subsection-styling-top-bar',
		'fields'     => array(
			// Top Bar Background
			array(
				'id'          => 'alchemists__header-top-bar-bg',
				'type'        => 'color',
				'title'       => esc_html__( 'Top Bar Background', 'alchemists' ),
				'desc'        => esc_html__( 'Customize Top Bar Background Color.', 'alchemists' ),
			),
			// Top Bar Highlight
			array(
				'id'          => 'alchemists__header-top-bar-highlight',
				'type'        => 'color',
				'title'       => esc_html__( 'Hover & Highlight Color', 'alchemists' ),
				'desc'        => esc_html__( 'Header Top Bar hover & highlight color.', 'alchemists' ),
			),
			// Top Bar Text Color
			array(
				'id'          => 'alchemists__header-top-bar-text-color',
				'type'        => 'color',
				'title'       => esc_html__( 'Base & Text Color', 'alchemists' ),
				'desc'        => esc_html__( 'Header Top Bar base & text color.', 'alchemists' ),
			),
			// Top Bar Divider Color
			array(
				'id'          => 'alchemists__header-top-bar-divider-color',
				'type'        => 'color',
				'title'       => esc_html__( 'Text Divider Color', 'alchemists' ),
				'desc'        => esc_html__( 'Header Top Bar text divider color.', 'alchemists' ),
			),

		)
	) );


	// Styling: Header Primary
	Redux::setSection( $opt_name, array(
		'title'      => esc_html__( 'Header Primary', 'alchemists' ),
		'subsection' => true,
		'id'         => 'alchemists__subsection-styling-header-primary',
		'fields'     => array(
			// Header Primary Background
			array(
				'id'          => 'alchemists__header-primary-bg',
				'type'        => 'color',
				'title'       => esc_html__( 'Background', 'alchemists' ),
				'desc'        => esc_html__( 'Customize Header Primary Background Color.', 'alchemists' ),
			),
			// Header Primary Font Color
			array(
				'id'          => 'alchemists__header-primary-font-color',
				'type'        => 'link_color',
				'active'      => false,
				'title'       => esc_html__( 'Links Color', 'alchemists' ),
				'desc'        => esc_html__( 'Customize Header Primary Links Color.', 'alchemists' ),
			),
			// Header Primary Border Height
			array(
				'id'             => 'alchemists__header-primary-border-height',
				'type'           => 'dimensions',
				'units'          => array( 'px' ),
				'units_extended' => 'false',
				'title'          => esc_html__( 'Link Border Height', 'alchemists' ),
				'desc'           => esc_html__( 'Set Border Height for hovered and activate Navigation items in px (2px by default).', 'alchemists' ),
				'width'          => false,
				'mode'           => array(
					'width'  => false,
					'height' => true,
				),
			),
			// Header Primary Border Color
			array(
				'id'          => 'alchemists__header-primary-border-color',
				'type'        => 'color',
				'title'       => esc_html__( 'Link Border Color', 'alchemists' ),
				'desc'        => esc_html__( 'Appeared on hover and active Navigation items.', 'alchemists' ),
			),
			// Submenu Background
			array(
				'id'          => 'alchemists__header-primary-submenu-bg',
				'type'        => 'color',
				'title'       => esc_html__( 'Submenu & Megamenu Background', 'alchemists' ),
				'desc'        => esc_html__( 'Customize Dropdown Menu Background Color.', 'alchemists' ),
			),
			// Submenu Border Color
			array(
				'id'          => 'alchemists__header-primary-submenu-border-color',
				'type'        => 'color',
				'title'       => esc_html__( 'Submenu Border Color', 'alchemists' ),
				'desc'        => esc_html__( 'Border color for Submenu.', 'alchemists' ),
			),
			// Submenu Link Color
			array(
				'id'          => 'alchemists__header-primary-submenu-link-color',
				'type'        => 'link_color',
				'active'      => false,
				'title'       => esc_html__( 'Submenu Links Color', 'alchemists' ),
				'desc'        => esc_html__( 'Customize Submenu Links Color.', 'alchemists' ),
			),
			// Megamenu Link Color
			array(
				'id'          => 'alchemists__header-primary-megamenu-link-color',
				'type'        => 'link_color',
				'active'      => false,
				'title'       => esc_html__( 'Megamenu Links Color', 'alchemists' ),
				'desc'        => esc_html__( 'Customize Megamenu Links Color.', 'alchemists' ),
			),
			// Megamenu Title Color
			array(
				'id'          => 'alchemists__header-primary-megamenu-title-color',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Megamenu Column Title Color', 'alchemists' ),
				'desc'        => esc_html__( 'Title displayed for each column in Megamenu.', 'alchemists' ),
			),
			// Megamenu Post Title Color
			array(
				'id'          => 'alchemists__header-primary-megamenu-post-title-color',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Megamenu Post Title Color', 'alchemists' ),
				'desc'        => esc_html__( 'Title displayed for posts in Megamenu.', 'alchemists' ),
			),
			// Mobile Nav Background Color
			array(
				'id'          => 'alchemists__header-primary-mobile-nav-bg',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Mobile Nav Background Color', 'alchemists' ),
				'desc'        => esc_html__( 'Background color for Navigation on mobile devices.', 'alchemists' ),
			),
			// Mobile Nav Links Color
			array(
				'id'          => 'alchemists__header-primary-mobile-link-color',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Mobile Nav Link Color', 'alchemists' ),
				'desc'        => esc_html__( 'Links color in Navigation on mobile devices.', 'alchemists' ),
			),
			// Mobile Nav Border Color
			array(
				'id'          => 'alchemists__header-primary-mobile-border-color',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Mobile Nav Border Color', 'alchemists' ),
				'desc'        => esc_html__( 'Border color for Navigation on mobile devices.', 'alchemists' ),
			),
			// Mobile Nav Submenu Background Color
			array(
				'id'          => 'alchemists__header-primary-mobile-sub-bg',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Mobile Nav Submenu Background', 'alchemists' ),
				'desc'        => esc_html__( 'Backgroud color for Navigation Submenu on mobile devices.', 'alchemists' ),
			),
			// Mobile Nav Submenu Link Color
			array(
				'id'          => 'alchemists__header-primary-mobile-sub-link-color',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Mobile Nav Submenu Links Color', 'alchemists' ),
				'desc'        => esc_html__( 'Links color for Navigation Submenu on mobile devices.', 'alchemists' ),
			),
		)
	) );


	// Styling: Header Secondary
	Redux::setSection( $opt_name, array(
		'title'      => esc_html__( 'Header Secondary', 'alchemists' ),
		'subsection' => true,
		'id'         => 'alchemists__subsection-styling-header-secondary',
		'fields'     => array(
			// Header Secondary Background
			array(
				'id'          => 'alchemists__header-secondary-bg',
				'type'        => 'color',
				'title'       => esc_html__( 'Background', 'alchemists' ),
				'desc'        => esc_html__( 'Customize Header Secondary Background Color.', 'alchemists' ),
			),
			// Header Info Block Color
			array(
				'id'          => 'alchemists__header-info-block-color',
				'type'        => 'color',
				'title'       => esc_html__( 'Icons Color', 'alchemists' ),
				'desc'        => esc_html__( 'Used to change color for icons in Header Secondary.', 'alchemists' ),
			),
			// Header Info Block Title Color
			array(
				'id'          => 'alchemists__header-info-block-title-color',
				'type'        => 'color',
				'title'       => esc_html__( 'Titles Color', 'alchemists' ),
				'desc'        => esc_html__( 'Used to change color for title in Header Secondary.', 'alchemists' ),
			),
			// Header Info Block Link Color
			array(
				'id'          => 'alchemists__header-info-link-color',
				'type'        => 'link_color',
				'active'      => false,
				'title'       => esc_html__( 'Links Color', 'alchemists' ),
				'subtitle'    => esc_html__( 'Color for links in the Header Secondary.', 'alchemists' ),
			),
			// Header Info Block Link Color - Mobile
			array(
				'id'          => 'alchemists__header-info-link-color-mobile',
				'type'        => 'link_color',
				'active'      => false,
				'title'       => esc_html__( 'Links Color - Mobile', 'alchemists' ),
				'subtitle'    => esc_html__( 'Color for links in the Header Secondary on mobile devices.', 'alchemists' ),
			),
			// Header Info Block Cart Summary Color
			array(
				'id'          => 'alchemists__header-info-block-cart-sum-color',
				'type'        => 'color',
				'title'       => esc_html__( 'Cart Summary Color', 'alchemists' ),
				'desc'        => esc_html__( 'Changes cart summary color in the Header Secondary.', 'alchemists' ),
			),
			// Header Info Block Cart Summary Color - Mobile
			array(
				'id'          => 'alchemists__header-info-block-cart-sum-color-mobile',
				'type'        => 'color',
				'title'       => esc_html__( 'Cart Summary Color - Mobile', 'alchemists' ),
				'desc'        => esc_html__( 'Changes cart summary color in the Header Secondary on mobile devices.', 'alchemists' ),
			),
		)
	) );


	// Styling: Pushy Panel
	Redux::setSection( $opt_name, array(
		'title'      => esc_html__( 'Pushy Panel', 'alchemists' ),
		'subsection' => true,
		'id'         => 'alchemists__subsection-styling-pushy-panel',
		'fields'     => array(
			// Pushy Panel Color
			array(
				'id'        => 'alchemists__pushy-panel-color',
				'type'      => 'select',
				'title'     => esc_html__('Pushy Panel Color Scheme', 'alchemists'),
				'subtitle'  => esc_html__('Select Pushy Panel Color Scheme', 'alchemists'),
				'options'   => array(
					'light' => esc_html__( 'Light', 'alchemists' ),
					'dark'  => esc_html__( 'Dark', 'alchemists' ),
				),
				'default'   => 'light'
			),
		)
	) );


	// Styling: Blog
	Redux::setSection( $opt_name, array(
		'title'      => esc_html__( 'Blog', 'alchemists' ),
		'subsection' => true,
		'id'         => 'alchemists__subsection-styling-blog',
		'fields'     => array(
			// Categories Group 1 - Color
			array(
				'id'          => 'alchemists__blog-cat-group-1',
				'type'        => 'color',
				'title'       => esc_html__( 'Categories Group 1 - Color', 'alchemists' ),
				'desc'        => esc_html__( 'Customize color for Categories Group 1 (post category label and floating action button)', 'alchemists' ),
			),
			// Categories Group 2 - Color
			array(
				'id'          => 'alchemists__blog-cat-group-2',
				'type'        => 'color',
				'title'       => esc_html__( 'Categories Group 2 - Color', 'alchemists' ),
				'desc'        => esc_html__( 'Customize color for Categories Group 2 (post category label and floating action button)', 'alchemists' ),
			),
			// Categories Group 3 - Color
			array(
				'id'          => 'alchemists__blog-cat-group-3',
				'type'        => 'color',
				'title'       => esc_html__( 'Categories Group 3 - Color', 'alchemists' ),
				'desc'        => esc_html__( 'Customize color for Categories Group 3 (post category label and floating action button)', 'alchemists' ),
			),
		)
	) );


	// Styling: Footer
	Redux::setSection( $opt_name, array(
		'title'      => esc_html__( 'Footer', 'alchemists' ),
		'subsection' => true,
		'id'         => 'alchemists__subsection-styling-footer',
		'fields'     => array(
			// Footer Widgets Background
			array(
				'id'          => 'alchemists__footer-widgets-bg',
				'type'        => 'background',
				'output'      => array('.footer-widgets'),
				'title'       => esc_html__( 'Footer Widgets Background', 'alchemists' ),
				'desc'        => esc_html__( 'Customize Footer Widgets Background.', 'alchemists' ),
			),
			// Footer Secondary Background
			array(
				'id'          => 'alchemists__footer-secondary-bg',
				'type'        => 'color',
				'title'       => esc_html__( 'Footer Secondary Background Color', 'alchemists' ),
				'desc'        => esc_html__( 'Customize Footer Secondary Background Color.', 'alchemists' ),
			),
			// Footer Side Decoration Background
			array(
				'id'          => 'alchemists__footer-side-decoration-bg',
				'type'        => 'color',
				'title'       => esc_html__( 'Footer Side Decoration Color', 'alchemists' ),
				'desc'        => esc_html__( 'Customize Footer Secondary Background Color.', 'alchemists' ),
			),
		)
	) );


	// Typography
	Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'Typography', 'alchemists' ),
		'id'     => 'alchemists__section-typography',
		'icon'   => 'el-icon-font'
	) );


	// General Typography
	Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'General', 'alchemists' ),
		'id'     => 'alchemists__subsection-typography-general',
		'subsection' => true,
		'fields' => array(
			array(
				'id'          => 'alchemists__custom_body_font',
				'type'        => 'switch',
				'title'       => esc_html__('Customize Body font?', 'alchemists'),
				'subtitle'    => esc_html__('Turn on to use custom fonts for the theme main text.', 'alchemists'),
				'default'     => false,
			),
			array(
				'id'        => 'alchemists__typography-body',
				'type'      => 'typography',
				'title'     => esc_html__('Body Font', 'alchemists'),
				'subtitle'  => esc_html__('Specify the body font properties.', 'alchemists'),
				'google'    => true,
				'text-align' => false,
				'units'      => 'px',
				'required'   => array('alchemists__custom_body_font', '=', '1'),
			),
			array(
				'id'          => 'alchemists__custom_heading_font',
				'type'        => 'switch',
				'title'       => esc_html__('Customize Headings?', 'alchemists'),
				'subtitle'    => esc_html__('Turn on to use custom fonts, change color etc. for the theme Headings.', 'alchemists'),
				'default'     => false,
			),
			array(
				'id'          => 'font-family-accent',
				'type'        => 'typography',
				'title'       => esc_html__('Font Family Accent', 'alchemists'),
				'subtitle'    => esc_html__('Used for headings, titles, tabs, labels etc.', 'alchemists'),
				'google'      => true,
				'line-height' => false,
				'text-align'  => false,
				'font-size'   => false,
				'font-weight' => false,
				'font-style'  => false,
				'color'       => false,
				'default'     => array(
					'font-family'   => 'Montserrat',
					'google'        => true,
				),
				'required'    => array('alchemists__custom_heading_font', '=', '1'),
			),
			array(
				'id'          => 'headings-typography',
				'type'        => 'typography',
				'title'       => esc_html__('Headings', 'alchemists'),
				'subtitle'    => esc_html__('Specify H1-H6 headings font properties.', 'alchemists'),
				'google'      => true,
				'line-height' => false,
				'text-align'  => false,
				'font-size'   => false,
				'font-weight' => false,
				'font-style'  => false,
				'default'     => array(
					'color'         => '#31404b',
					'font-family'   => 'Montserrat',
					'google'        => true,
				),
				'required'    => array('alchemists__custom_heading_font', '=', '1'),
			),
			array(
				'id'          => 'alchemists__custom_heading_fonts_separately',
				'type'        => 'switch',
				'title'       => esc_html__('Customize Headings separately?', 'alchemists'),
				'subtitle'    => esc_html__('Turn on to customze each Heading separately.', 'alchemists'),
				'default'     => false,
				'required'    => array('alchemists__custom_heading_font', '=', '1'),
			),
			array(
				'id'          => 'typography-h1',
				'type'        => 'typography',
				'title'       => esc_html__('H1 Heading', 'alchemists'),
				'subtitle'    => esc_html__('Specify the H1 heading font properties.', 'alchemists'),
				'google'      => true,
				'output'      => array('h1'),
				'units'       => 'px',
				'line-height' => false,
				'text-align'  => false,
				'required'    => array( 'alchemists__custom_heading_fonts_separately', '=', '1' ),
			),
			array(
				'id'          => 'typography-h2',
				'type'        => 'typography',
				'title'       => esc_html__('H2 Heading', 'alchemists'),
				'subtitle'    => esc_html__('Specify the H2 heading font properties.', 'alchemists'),
				'google'      => true,
				'output'      => array('h2'),
				'units'       => 'px',
				'line-height' => false,
				'text-align'  => false,
				'required'    => array( 'alchemists__custom_heading_fonts_separately', '=', '1' ),
			),
			array(
				'id'          => 'typography-h3',
				'type'        => 'typography',
				'title'       => esc_html__('H3 Heading', 'alchemists'),
				'subtitle'    => esc_html__('Specify the H3 heading font properties.', 'alchemists'),
				'google'      => true,
				'output'      => array('h3'),
				'units'       => 'px',
				'line-height' => false,
				'text-align'  => false,
				'required'    => array( 'alchemists__custom_heading_fonts_separately', '=', '1' ),
			),
			array(
				'id'          => 'typography-h4',
				'type'        => 'typography',
				'title'       => esc_html__('H4 Heading', 'alchemists'),
				'subtitle'    => esc_html__('Specify the H4 heading font properties.', 'alchemists'),
				'google'      => true,
				'output'      => array('h4'),
				'units'       => 'px',
				'line-height' => false,
				'text-align'  => false,
				'required'    => array( 'alchemists__custom_heading_fonts_separately', '=', '1' ),
			),
			array(
				'id'          => 'typography-h5',
				'type'        => 'typography',
				'title'       => esc_html__('H5 Heading', 'alchemists'),
				'subtitle'    => esc_html__('Specify the H5 heading font properties.', 'alchemists'),
				'google'      => true,
				'output'      => array('h5'),
				'units'       => 'px',
				'line-height' => false,
				'text-align'  => false,
				'required'    => array( 'alchemists__custom_heading_fonts_separately', '=', '1' ),
			),
			array(
				'id'          => 'typography-h6',
				'type'        => 'typography',
				'title'       => esc_html__('H6 Heading', 'alchemists'),
				'subtitle'    => esc_html__('Specify the H6 heading font properties.', 'alchemists'),
				'google'      => true,
				'output'      => array('h6'),
				'units'       => 'px',
				'line-height' => false,
				'text-align'  => false,
				'required'    => array( 'alchemists__custom_heading_fonts_separately', '=', '1' ),
			),
		)
	) );


	// Header
	Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'Header', 'alchemists' ),
		'id'     => 'alchemists__subsection-typography-header',
		'subsection' => true,
		'fields' => array(
			array(
				'id'          => 'alchemists__custom_nav-font',
				'type'        => 'switch',
				'title'       => esc_html__('Customize Navigation?', 'alchemists'),
				'subtitle'    => esc_html__('Turn on to use custom fonts for Navigation.', 'alchemists'),
				'default'     => false,
			),
			array(
				'id'          => 'alchemists__nav-font',
				'type'        => 'typography',
				'title'       => esc_html__('Navigation Typography', 'alchemists'),
				'subtitle'    => esc_html__('Used for the main navigation.', 'alchemists'),
				'google'      => true,
				'line-height' => false,
				'text-align'  => false,
				'color'       => false,
				'text-transform' => true,
				'required'    => array('alchemists__custom_nav-font', '=', '1'),
			),

			array(
				'id'          => 'alchemists__nav-font-sub',
				'type'        => 'typography',
				'title'       => esc_html__('Navigation Dropdown Typography', 'alchemists'),
				'subtitle'    => esc_html__('Used for the main navigation.', 'alchemists'),
				'google'      => true,
				'line-height' => false,
				'text-align'  => false,
				'color'       => false,
				'text-transform' => true,
				'required'    => array('alchemists__custom_nav-font', '=', '1'),
			),
		)
	) );


	// Page Preloader Options
	Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'Preloader', 'alchemists' ),
		'id'     => 'alchemists__section-pageloader',
		'icon'   => 'el el-repeat',
		'fields' => array(
			array(
				'id'        => 'alchemists__opt-pageloader',
				'type'      => 'switch',
				'title'     => esc_html__('Use Preloader?', 'alchemists'),
				'subtitle'  => esc_html__('Turn on to use page pre-loader.', 'alchemists'),
				'desc'      => esc_html__('If turned on you will see spinner before content will be shown.', 'alchemists'),
				'default'   => 1,
				'on'        => esc_html__( 'Yes', 'alchemists' ),
				'off'       => esc_html__( 'No', 'alchemists' ),
			),
			array(
				'id'        => 'alchemists__opt-custom_pageloader',
				'type'      => 'switch',
				'title'     => esc_html__('Customize Preloader?', 'alchemists'),
				'subtitle'  => esc_html__('Turn on to change colors, size, speen of preloader.', 'alchemists'),
				'default'   => false,
				'on'        => esc_html__( 'Yes', 'alchemists' ),
				'off'       => esc_html__( 'No', 'alchemists' ),
				'required'  => array('alchemists__opt-pageloader', '=', '1'),
			),
			array(
				'id'                    => 'alchemists__opt-preloader-bg',
				'type'                  => 'color',
				'title'                 => esc_html__('Preloader Background Color', 'alchemists'),
				'subtitle'              => esc_html__('Choose background color your pre-loader screen.', 'alchemists'),
				'transparent'           => false,
				'required'              => array(
					array('alchemists__opt-pageloader', '=', '1'),
					array('alchemists__opt-custom_pageloader', '=', '1'),
				),
			),
			array(
				'id'             => 'alchemists__opt-preloader-size',
				'type'           => 'dimensions',
				'units'          => array( 'px' ),
				'units_extended' => 'false',
				'title'          => esc_html__( 'Spinner Size', 'alchemists' ),
				'subtitle'       => esc_html__( 'Set up the spinner size.', 'alchemists' ),
				'desc'           => esc_html__( 'Spinner size can be set in px.', 'alchemists' ),
				'height'         => false,
				'mode'           => array(
					'width'  => true,
					'height' => false,
				),
				'required'  => array(
					array('alchemists__opt-pageloader', '=', '1'),
					array('alchemists__opt-custom_pageloader', '=', '1'),
				),
			),
			array(
				'id'          => 'alchemists__opt-preloader-color',
				'type'        => 'color',
				'title'       => esc_html__( 'Spinning Part Color', 'alchemists' ),
				'subtitle'    => esc_html__( 'Choose color for spinning part.', 'alchemists' ),
				'transparent' => false,
				'required'    => array(
					array('alchemists__opt-pageloader', '=', '1'),
					array('alchemists__opt-custom_pageloader', '=', '1'),
				),
			),
			array(
				'id'          => 'alchemists__opt-preloader-color-secondary',
				'type'        => 'color',
				'title'       => esc_html__( 'Spinner Bar Color', 'alchemists' ),
				'subtitle'    => esc_html__( 'Choose color for spinning bar.', 'alchemists' ),
				'transparent' => false,
				'required'    => array(
					array('alchemists__opt-pageloader', '=', '1'),
					array('alchemists__opt-custom_pageloader', '=', '1'),
				),
			),
			array(
				'id'       => 'alchemists__opt-preloader-spin-duration',
				'type'     => 'slider',
				'title'    => esc_html__( 'Spinner Animation Duration', 'alchemists' ),
				'desc'     => esc_html__( 'Duration in seconds, Min: 0, max: 2, step: .1, default value: .8.', 'alchemists' ),
				'default'  => 0.8,
				'min'      => 0,
				'step'     => 0.1,
				'max'      => 2,
				'resolution' => 0.1,
				'display_value' => 'text',
				'required'    => array(
					array('alchemists__opt-pageloader', '=', '1'),
					array('alchemists__opt-custom_pageloader', '=', '1'),
				),
			),
		)
	) );


	// Social
	Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'Social', 'alchemists' ),
		'id'     => 'alchemists__section-social',
		'icon'   => 'el-icon-globe',
		'fields' => array(

		)
	) );


	// Facebook
	Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'Facebook', 'alchemists' ),
		'subsection' => true,
		'id'         => 'alchemists__subsection-social-facebook',
		'fields' => array(
			array(
				'id'        => 'alchemists__social-facebook-notice',
				'type'      => 'info',
				'notice'    => true,
				'icon'      => 'el el-icon-info-circle',
				'style'     => 'info',
				'title'     => esc_html__( 'Facebook Token', 'alchemists' ),
				'desc'      => sprintf( __( 'Check next article about generating Facebook Token <a href="%s">How to get a Facebook Access Token</a>', 'alchemists' ), 'https://smashballoon.com/custom-facebook-feed/access-token/' ),
			),
			array(
				'id'       => 'alchemists__opt-social-fb-user',
				'type'     => 'text',
				'title'    => esc_html__( 'Facebook User', 'alchemists' ),
				'desc'     => esc_html__( 'Enter Facebook User Name.', 'alchemists' ),
			),
			array(
				'id'       => 'alchemists__opt-social-fb-token',
				'type'     => 'text',
				'title'    => esc_html__( 'Facebook Token', 'alchemists' ),
				'desc'     => esc_html__( 'Enter Facebook Token.', 'alchemists' ),
			),
		)
	) );

	// Twitter
	Redux::setSection( $opt_name, array(
		'title'      => esc_html__( 'Twitter', 'alchemists' ),
		'subsection' => true,
		'id'         => 'alchemists__subsection-social-twitter',
		'fields' => array(
			array(
				'id'        => 'alchemists__social-twitter-notice',
				'type'      => 'info',
				'notice'    => true,
				'icon'      => 'el el-icon-info-circle',
				'style'     => 'info',
				'title'     => esc_html__( 'Twitter API', 'alchemists' ),
				'desc'      => sprintf( __( '<a href="%s">Create an app</a> to get Twitter API details.', 'alchemists' ), 'https://apps.twitter.com' ),
			),
			array(
				'id'       => 'alchemists__opt-social-tw-user',
				'type'     => 'text',
				'title'    => esc_html__( 'Twitter User', 'alchemists' ),
				'desc'     => esc_html__( 'Enter Twitter Username.', 'alchemists' ),
			),
			array(
				'id'       => 'alchemists__opt-social-tw-consumer-key',
				'type'     => 'text',
				'title'    => esc_html__( 'Twitter Consumer Key', 'alchemists' ),
				'desc'     => esc_html__( 'Enter Twitter Consumer Key.', 'alchemists' ),
			),
			array(
				'id'       => 'alchemists__opt-social-tw-consumer-secret',
				'type'     => 'text',
				'title'    => esc_html__( 'Twitter Consumer Secret', 'alchemists' ),
				'desc'     => esc_html__( 'Enter Twitter Consumer Secret.', 'alchemists' ),
			),
			array(
				'id'       => 'alchemists__opt-social-tw-access-token',
				'type'     => 'text',
				'title'    => esc_html__( 'Twitter Access Token', 'alchemists' ),
				'desc'     => esc_html__( 'Enter Twitter Access Token.', 'alchemists' ),
			),
			array(
				'id'       => 'alchemists__opt-social-tw-access-token-secret',
				'type'     => 'text',
				'title'    => esc_html__( 'Twitter Access Token Secret', 'alchemists' ),
				'desc'     => esc_html__( 'Enter Access Token Secret.', 'alchemists' ),
			),
		)
	) );


	// Google+
	Redux::setSection( $opt_name, array(
		'title'      => esc_html__( 'Google+', 'alchemists' ),
		'subsection' => true,
		'id'         => 'alchemists__subsection-social-google',
		'fields' => array(
			array(
				'id'        => 'alchemists__social-google-notice',
				'type'      => 'info',
				'notice'    => true,
				'icon'      => 'el el-icon-info-circle',
				'style'     => 'info',
				'title'     => esc_html__( 'Google API Key', 'alchemists' ),
				'desc'      => sprintf( __( 'In order to get access to your Google+ account info you are required to provide a Google+ API Key. Please check <a href="%s">this</a> article.', 'alchemists' ), 'https://www.slickremix.com/docs/get-api-key-for-google/' ),
			),
			array(
				'id'       => 'alchemists__opt-social-gplus-user',
				'type'     => 'text',
				'title'    => esc_html__( 'Google+ ID', 'alchemists' ),
				'desc'     => esc_html__( 'Enter Google+ ID.', 'alchemists' ),
			),
			array(
				'id'       => 'alchemists__opt-social-gplus-key',
				'type'     => 'text',
				'title'    => esc_html__( 'Google+ Key', 'alchemists' ),
				'desc'     => esc_html__( 'Enter Google+ Key.', 'alchemists' ),
			),
		)
	) );


	// Instagram
	Redux::setSection( $opt_name, array(
		'title'      => esc_html__( 'Instagram', 'alchemists' ),
		'subsection' => true,
		'id'         => 'alchemists__subsection-social-instagram',
		'fields' => array(
			array(
				'id'        => 'alchemists__social-instagram-notice',
				'type'      => 'info',
				'notice'    => true,
				'icon'      => 'el el-icon-info-circle',
				'style'     => 'info',
				'title'     => esc_html__( 'Instagram Token', 'alchemists' ),
				'desc'      => sprintf( __( 'In order to get access to your Instagram account info you are required to provide an Instagram Access Token. You can generate it here <a href="%s">Instagram Access Token Generator</a>', 'alchemists' ), 'http://instagram.pixelunion.net' ),
			),
			array(
				'id'       => 'alchemists__opt-social-insta-user',
				'type'     => 'text',
				'title'    => esc_html__( 'Instagram Username', 'alchemists' ),
				'desc'     => esc_html__( 'Enter Instagram Username.', 'alchemists' ),
			),
			array(
				'id'       => 'alchemists__opt-social-insta-token',
				'type'     => 'text',
				'title'    => esc_html__( 'Instagram Token', 'alchemists' ),
				'desc'     => esc_html__( 'Enter Instagram Token.', 'alchemists' ),
			),
		)
	) );


	// 404 Page Options
	Redux::setSection( $opt_name, array(
		'title'  => esc_html__( '404 Page', 'alchemists' ),
		'id'     => 'alchemists__section-404-page',
		'icon'   => 'el el-error',
		'fields' => array(
			array(
				'id'        => 'alchemists__opt-404-image',
				'type'      => 'media',
				'url'       => true,
				'title'     => esc_html__('Page 404 Image', 'alchemists'),
				'subtitle'  => esc_html__('This image displayed only on Page 404.', 'alchemists'),
				'compiler'  => 'true',
				'desc'      => esc_html__('Upload your image or specify the image URL.', 'alchemists'),
			),
			array(
				'id'       => 'alchemists__opt-404-page-heading',
				'type'     => 'text',
				'title'    => esc_html__( 'Page Header Title', 'alchemists' ),
				'subtitle' => esc_html__( 'Change 404 Page Header Title.', 'alchemists' ),
				'desc'     => esc_html__( 'This text appears below the Header.', 'alchemists' ),
			),
			array(
				'id'       => 'alchemists__opt-404-page-title',
				'type'     => 'text',
				'title'    => esc_html__( 'Title', 'alchemists' ),
				'subtitle' => esc_html__( 'Change Page 404 Title.', 'alchemists' ),
				'desc'     => esc_html__( 'This text appears above 404 image.', 'alchemists' ),
			),
			array(
				'id'       => 'alchemists__opt-404-page-subtitle',
				'type'     => 'text',
				'title'    => esc_html__( 'Subtitle', 'alchemists' ),
				'subtitle' => esc_html__( 'Change Page 404 Subtitle.', 'alchemists' ),
				'desc'     => esc_html__( 'This text appears above 404 Title.', 'alchemists' ),
			),
			array(
				'id'      => 'alchemists__opt-404-desc',
				'type'    => 'textarea',
				'title'   => esc_html__( 'Description', 'alchemists' ),
			),
			array(
				'id'        => 'alchemists__opt-404-btn',
				'type'      => 'switch',
				'title'     => esc_html__('Show Primary Button?', 'alchemists'),
				'subtitle'  => esc_html__('Turn on to display primary button.', 'alchemists'),
				'desc'      => esc_html__('This button linked to main page.', 'alchemists'),
				'default'   => 1,
				'on'        => esc_html__( 'Yes', 'alchemists' ),
				'off'       => esc_html__( 'No', 'alchemists' ),
			),
			array(
				'id'       => 'alchemists__opt-404-btn-txt',
				'type'     => 'text',
				'title'    => esc_html__( 'Primary Button Text', 'alchemists' ),
				'subtitle' => esc_html__( 'Change Primary Button text.', 'alchemists' ),
				'desc'     => esc_html__( 'Primary button linked to the Home page.', 'alchemists' ),
				'required' => array('alchemists__opt-404-btn', '=', '1'),
			),
			array(
				'id'       => 'alchemists__opt-404-btn-link',
				'type'     => 'text',
				'title'    => esc_html__( 'Primary Button URL', 'alchemists' ),
				'subtitle' => esc_html__( 'Change Primary Button URL.', 'alchemists' ),
				'required' => array('alchemists__opt-404-btn', '=', '1'),
			),
			array(
				'id'        => 'alchemists__opt-404-btn-secondary',
				'type'      => 'switch',
				'title'     => esc_html__('Show Secondary Button?', 'alchemists'),
				'subtitle'  => esc_html__('Turn on to display secondary button.', 'alchemists'),
				'desc'      => esc_html__('You can link this button any page.', 'alchemists'),
				'default'   => 1,
				'on'        => esc_html__( 'Yes', 'alchemists' ),
				'off'       => esc_html__( 'No', 'alchemists' ),
			),
			array(
				'id'       => 'alchemists__opt-404-btn-secondary-txt',
				'type'     => 'text',
				'title'    => esc_html__( 'Secondary Button Text', 'alchemists' ),
				'subtitle' => esc_html__( 'Change Secondary Button text.', 'alchemists' ),
				'desc'     => esc_html__( 'Secondary button linked to the Blog page.', 'alchemists' ),
				'required' => array('alchemists__opt-404-btn-secondary', '=', '1'),
			),
			array(
				'id'       => 'alchemists__opt-404-btn-secondary-link',
				'type'     => 'text',
				'title'    => esc_html__( 'Secondary Button URL', 'alchemists' ),
				'subtitle' => esc_html__( 'Change Secondary Button URL.', 'alchemists' ),
				'required' => array('alchemists__opt-404-btn-secondary', '=', '1'),
			),
		)
	) );

	// SportsPress Options
	Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'SportsPress', 'alchemists' ),
		'id'     => 'alchemists__section-sportspress',
		'icon'   => get_template_directory_uri() . '/admin/images/sp.png',
		'fields' => array(

		)
	) );

	// Team
	Redux::setSection( $opt_name, array(
		'title'      => esc_html__( 'Team', 'alchemists' ),
		'subsection' => true,
		'id'         => 'alchemists__section-sp-team',
		'fields' => array(
			array(
				'id'        => 'alchemists__team-subpages',
				'type'      => 'sorter',
				'title'     => esc_html__( 'Team Subpages Layout', 'alchemists' ),
				'subtitle'  => esc_html__( 'Organize Team Subpages order.', 'alchemists' ),
				'desc'      => esc_html__( 'Organize how you want the team subpages to appear on a single team page.', 'alchemists' ),
				'compiler'  => 'true',
				'options'   => array(
					'enabled'   => array(
						'roster'    => esc_html__( 'Roster', 'alchemists' ),
						'standings' => esc_html__( 'Standings', 'alchemists' ),
						'results'   => esc_html__( 'Latest Results', 'alchemists' ),
						'schedule'  => esc_html__( 'Schedule', 'alchemists' ),
						'gallery'   => esc_html__( 'Gallery', 'alchemists' ),
					),
					'disabled'  => array(),
				),
			),
			// Permalinks Notice
			array(
				'id'        => 'alchemists__team-subpages-notice--slug',
				'type'      => 'info',
				'notice'    => true,
				'icon'      => 'el el-icon-warning-sign',
				'style'     => 'warning',
				'title'     => esc_html__('Change Permalinks', 'alchemists'),
				'desc'      => __('After changing slugs go to <strong>Settings > Permalinks</strong> and click on <strong>Save Changes</strong> button.', 'alchemists')
			),
			array(
				'id'        => 'alchemists__team-subpages-label--overview',
				'type'      => 'text',
				'title'     => esc_html__( 'Overview - Label', 'alchemists' ),
				'desc'      => esc_html__( 'Label for Overview Team subpage.', 'alchemists' ),
				'default'   => esc_html__( 'Overview', 'alchemists' ),
			),
			array(
				'id'        => 'alchemists__team-subpages-label--roster',
				'type'      => 'text',
				'title'     => esc_html__( 'Roster - Label', 'alchemists' ),
				'desc'      => esc_html__( 'Label for Roster Team subpage.', 'alchemists' ),
				'default'   => esc_html__( 'Roster', 'alchemists' ),
			),
			array(
				'id'        => 'alchemists__team-subpages-slug--roster',
				'type'      => 'text',
				'title'     => esc_html__( 'Roster - Slug', 'alchemists' ),
				'desc'      => esc_html__( 'Slug for Roster Team subpage.', 'alchemists' ),
				'default'   => 'roster',
			),
			array(
				'id'        => 'alchemists__team-subpages-label--standings',
				'type'      => 'text',
				'title'     => esc_html__( 'Standings - Label', 'alchemists' ),
				'desc'      => esc_html__( 'Label for Standings Team subpage.', 'alchemists' ),
				'default'   => esc_html__( 'Standings', 'alchemists' ),
			),
			array(
				'id'        => 'alchemists__team-subpages-slug--standings',
				'type'      => 'text',
				'title'     => esc_html__( 'Standings - Slug', 'alchemists' ),
				'desc'      => esc_html__( 'Slug for Standings Team subpage.', 'alchemists' ),
				'default'   => 'standings',
			),
			array(
				'id'        => 'alchemists__team-subpages-label--results',
				'type'      => 'text',
				'title'     => esc_html__( 'Latest Results - Label', 'alchemists' ),
				'desc'      => esc_html__( 'Label for Latest Results Team subpage.', 'alchemists' ),
				'default'   => esc_html__( 'Latest Results', 'alchemists' ),
			),
			array(
				'id'        => 'alchemists__team-subpages-slug--results',
				'type'      => 'text',
				'title'     => esc_html__( 'Results - Slug', 'alchemists' ),
				'desc'      => esc_html__( 'Slug for Results Team subpage.', 'alchemists' ),
				'default'   => 'results',
			),
			array(
				'id'        => 'alchemists__team-subpages-label--schedule',
				'type'      => 'text',
				'title'     => esc_html__( 'Schedule - Label', 'alchemists' ),
				'desc'      => esc_html__( 'Label for Schedule Team subpage.', 'alchemists' ),
				'default'   => esc_html__( 'Schedule', 'alchemists' ),
			),
			array(
				'id'        => 'alchemists__team-subpages-slug--schedule',
				'type'      => 'text',
				'title'     => esc_html__( 'Schedule - Slug', 'alchemists' ),
				'desc'      => esc_html__( 'Slug for Schedule Team subpage.', 'alchemists' ),
				'default'   => 'schedule',
			),
			array(
				'id'        => 'alchemists__team-subpages-label--gallery',
				'type'      => 'text',
				'title'     => esc_html__( 'Gallery - Label', 'alchemists' ),
				'desc'      => esc_html__( 'Label for Gallery Team subpage.', 'alchemists' ),
				'default'   => esc_html__( 'Gallery', 'alchemists' ),
			),
			array(
				'id'        => 'alchemists__team-subpages-slug--gallery',
				'type'      => 'text',
				'title'     => esc_html__( 'Gallery - Slug', 'alchemists' ),
				'desc'      => esc_html__( 'Slug for Gallery Team subpage.', 'alchemists' ),
				'default'   => 'gallery',
			),
		)
	) );

	// Player
	Redux::setSection( $opt_name, array(
		'title'      => esc_html__( 'Player', 'alchemists' ),
		'subsection' => true,
		'id'         => 'alchemists__section-sp-player',
		'fields' => array(
			array(
				'id'          => 'alchemists__player-title-custom',
				'type'        => 'switch',
				'title'       => esc_html__('Customize Single Player Page Heading Background?', 'alchemists'),
				'subtitle'    => esc_html__('Turn on to change background image, colors.', 'alchemists'),
				'default'     => 0,
				'on'          => esc_html__( 'Yes', 'alchemists' ),
				'off'         => esc_html__( 'No', 'alchemists' ),
			),
			array(
				'id'          => 'alchemists__player-title-background',
				'type'        => 'background',
				'output'      => array('.player-heading'),
				'title'       => esc_html__('Single Player Page Heading Background', 'alchemists'),
				'required'    => array('alchemists__player-title-custom', '=', '1'),
			),
			array(
				'id'          => 'alchemists__player-title-overlay-on',
				'type'        => 'switch',
				'title'       => esc_html__('Add Overlay on Single Player Page Heading?', 'alchemists'),
				'subtitle'    => esc_html__('Turn on to add color overlay.', 'alchemists'),
				'default'     => 1,
				'on'          => esc_html__( 'Yes', 'alchemists' ),
				'off'         => esc_html__( 'No', 'alchemists' ),
				'required'    => array('alchemists__player-title-custom', '=', '1'),
			),
			array(
				'id'          => 'alchemists__player-title-overlay',
				'type'        => 'background',
				'output'      => array('.player-heading::after'),
				'title'       => esc_html__('Single Player Page Heading Overlay', 'alchemists'),
				'subtitle'    => esc_html__('Adds color or/and image overlay.', 'alchemists'),
				'required'    => array(
					'alchemists__player-title-custom', '=', '1',
					'alchemists__player-title-overlay-on', '=', '1',
				),
			),
			array(
				'id'        => 'alchemists__player-info-layout',
				'type'      => 'select',
				'title'     => esc_html__('Player Info Details Layout', 'alchemists'),
				'subtitle'  => esc_html__('Select the player info layout displayed in the Page Heading.', 'alchemists'),
				'options'   => array(
					'horizontal' => esc_html__( 'Horizontal', 'alchemists' ),
					'vertical'   => esc_html__( 'Vertical', 'alchemists' ),
				),
				'default'   => 'horizontal'
			),
			array(
				'id'        => 'alchemists__player-subpages',
				'type'      => 'sorter',
				'title'     => esc_html__( 'Player Subpages Layout', 'alchemists' ),
				'subtitle'  => esc_html__( 'Organize Player Subpages order.', 'alchemists' ),
				'desc'      => esc_html__( 'Organize how you want the team subpages to appear on a single player page.', 'alchemists' ),
				'compiler'  => 'true',
				'options'   => array(
					'enabled'   => array(
						'stats'   => esc_html__( 'Statistics', 'alchemists' ),
						'bio'     => esc_html__( 'Biography', 'alchemists' ),
						'news'    => esc_html__( 'Related News', 'alchemists' ),
						'gallery' => esc_html__( 'Gallery', 'alchemists' ),
					),
					'disabled'  => array(),
				),
			),
			// Permalinks Notice
			array(
				'id'        => 'alchemists__player-subpages-notice--slug',
				'type'      => 'info',
				'notice'    => true,
				'icon'      => 'el el-icon-warning-sign',
				'style'     => 'warning',
				'title'     => esc_html__('Change Permalinks', 'alchemists'),
				'desc'      => __('After changing slugs go to <strong>Settings > Permalinks</strong> and click on <strong>Save Changes</strong> button.', 'alchemists')
			),
			array(
				'id'        => 'alchemists__player-subpages-label--overview',
				'type'      => 'text',
				'title'     => esc_html__( 'Overview - Label', 'alchemists' ),
				'desc'      => esc_html__( 'Label for Overview Player subpage.', 'alchemists' ),
				'default'   => esc_html__( 'Overview', 'alchemists' ),
			),
			array(
				'id'        => 'alchemists__player-subpages-label--stats',
				'type'      => 'text',
				'title'     => esc_html__( 'Statistics - Label', 'alchemists' ),
				'desc'      => esc_html__( 'Label for Statistics Player subpage.', 'alchemists' ),
				'default'   => esc_html__( 'Full Statistics', 'alchemists' ),
			),
			array(
				'id'        => 'alchemists__player-subpages-slug--stats',
				'type'      => 'text',
				'title'     => esc_html__( 'Statistics - Slug', 'alchemists' ),
				'desc'      => esc_html__( 'Slug for Statistics Player subpage.', 'alchemists' ),
				'default'   => 'stats',
			),
			array(
				'id'        => 'alchemists__player-subpages-label--bio',
				'type'      => 'text',
				'title'     => esc_html__( 'Biography - Label', 'alchemists' ),
				'desc'      => esc_html__( 'Label for Biography Player subpage.', 'alchemists' ),
				'default'   => esc_html__( 'Biography', 'alchemists' ),
			),
			array(
				'id'        => 'alchemists__player-subpages-slug--bio',
				'type'      => 'text',
				'title'     => esc_html__( 'Biography - Slug', 'alchemists' ),
				'desc'      => esc_html__( 'Slug for Biography Player subpage.', 'alchemists' ),
				'default'   => 'bio',
			),
			array(
				'id'        => 'alchemists__player-subpages-label--news',
				'type'      => 'text',
				'title'     => esc_html__( 'Related News - Label', 'alchemists' ),
				'desc'      => esc_html__( 'Label for Related News Player subpage.', 'alchemists' ),
				'default'   => esc_html__( 'Related News', 'alchemists' ),
			),
			array(
				'id'        => 'alchemists__player-subpages-slug--news',
				'type'      => 'text',
				'title'     => esc_html__( 'Related News - Slug', 'alchemists' ),
				'desc'      => esc_html__( 'Slug for Related News Player subpage.', 'alchemists' ),
				'default'   => 'news',
			),
			array(
				'id'        => 'alchemists__player-subpages-label--gallery',
				'type'      => 'text',
				'title'     => esc_html__( 'Gallery - Label', 'alchemists' ),
				'desc'      => esc_html__( 'Label for Gallery Player subpage.', 'alchemists' ),
				'default'   => esc_html__( 'Gallery', 'alchemists' ),
			),
			array(
				'id'        => 'alchemists__player-subpages-slug--gallery',
				'type'      => 'text',
				'title'     => esc_html__( 'Gallery - Slug', 'alchemists' ),
				'desc'      => esc_html__( 'Slug for Gallery Player subpage.', 'alchemists' ),
				'default'   => 'gallery',
			),
		)
	) );

	// WooCommerce Options
	Redux::setSection( $opt_name, array(
		'title'  => esc_html__( 'WooCommerce', 'alchemists' ),
		'id'     => 'alchemists__section-woocommerce',
		'icon'   => 'el el-shopping-cart',
		'fields' => array(
			array(
				'id'        => 'alchemists__shop-sidebar',
				'type'      => 'image_select',
				'compiler'  => true,
				'title'     => esc_html__('Shop Sidebar', 'alchemists'),
				'desc'      => esc_html__('Select sidebar position for Shop.', 'alchemists'),
				'options'   => array(
					'left_sidebar' => array(
						'alt' => esc_html__( 'Left Sidebar', 'alchemists' ),
						'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
					'right_sidebar' => array(
						'alt' => esc_html__( 'Right Sidebar', 'alchemists' ),
						'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
					'no_sidebar' => array(
						'alt' => esc_html__( 'No Sidebar', 'alchemists' ),
						'img' => ReduxFramework::$_url . 'assets/img/1c.png'),
				),
				'default'   => 'left_sidebar'
			),
			array(
				'id'        => 'alchemists__shop-related-columns',
				'type'      => 'select',
				'title'     => esc_html__('Related Products Columns', 'alchemists'),
				'subtitle'  => esc_html__('Select the number of columns for the related products', 'alchemists'),
				'options'   => array(
					'2' => '2',
					'3' => '3',
					'4' => '4'
				),
				'default'   => '4'
			),
			array(
				'id'       => 'alchemists__shop-related-per-page',
				'type'     => 'text',
				'title'    => esc_html__( 'Related products per page', 'alchemists' ),
				'subtitle' => esc_html__( 'Number of products of Related Products.', 'alchemists' ),
				'desc'     => esc_html__( 'Change the number of products fore Related Products.', 'alchemists' ),
				'default'  => '4'
			),
		)
	) );

	// Custom CSS
	Redux::setSection( $opt_name, array(
		'title'     => esc_html__('Custom CSS', 'alchemists'),
		'icon'      => 'el-icon-css',
		'id'        => 'alchemists__section-custom-css',
		'fields'    => array(
			array(
				'id'        => 'alchemists__custom-css',
				'type'      => 'ace_editor',
				'title'     => esc_html__( 'CSS Code', 'alchemists' ),
				'subtitle'  => esc_html__( 'Paste your CSS code here.', 'alchemists' ),
				'mode'      => 'css',
				'theme'     => 'monokai',
				'desc'      => esc_html__( 'Any custom CSS can be added here, it will override the theme CSS.', 'alchemists' ),
				'default'   => ""
			),
		)
	) );

	Redux::setSection( $opt_name, array(
		'title'     => esc_html__('Import / Export', 'alchemists'),
		'desc'      => esc_html__('Import and Export your theme settings from file, text or URL.', 'alchemists'),
		'icon'      => 'el-icon-refresh',
		'id'        => 'alchemists__section-import-export',
		'fields'    => array(
			array(
				'id'            => 'opt-import-export',
				'type'          => 'import_export',
				'full_width'    => false,
			),
		),
	) );

	if ( file_exists( get_parent_theme_file_path( 'readme.txt' ) ) ) {
		Redux::setSection( $opt_name, array(
			'icon'      => 'el-icon-list-alt',
			'id'        => 'alchemists__section-theme-info',
			'title'     => esc_html__( 'Theme Information', 'alchemists' ),
			'fields'    => array(
				array(
					'id'        => '17',
					'type'      => 'raw',
					'markdown'  => true,
					'content'   => file_get_contents( get_parent_theme_file_path( 'readme.txt' ) )
				),
			),
		) );
	}
