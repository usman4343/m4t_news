<?php

/**
 * TGM Init Class
 */

include_once get_template_directory() . '/admin/tgm/class-tgm-plugin-activation.php';

if ( ! function_exists('alchemists_register_required_plugins')) {
	function alchemists_register_required_plugins() {

		$plugins = array(
			array(
				'name' 		     => 'Redux Framework',
				'slug' 		     => 'redux-framework',
				'required' 	   => true,
			),
			array(
				'name'         => 'Advanced Custom Fields Pro',
				'slug'         => 'advanced-custom-fields-pro',
				'source'       => 'http://dan-fisher.com/tf/alchemists-wp/downloads/bZP6ZqVC/advanced-custom-fields-pro.zip',
				'required'     => true,
				'version'      => '5.6.7'
			),
			array(
				'name' 		     => 'SportsPress',
				'slug' 		     => 'sportspress',
				'required' 	   => true,
			),
			array(
				'name'         => 'Visual Composer',
				'slug'         => 'js_composer',
				'source'       => 'http://dan-fisher.com/tf/alchemists-wp/downloads/bZP6ZqVC/js_composer.zip',
				'required'     => true,
				'version'      => '5.4.5'
			),
			array(
				'name' 		     => 'Alchemists Advanced Posts',
				'slug' 		     => 'alc-advanced-posts',
				'source'       => get_template_directory() . '/inc/plugins/alc-advanced-posts.zip',
				'required' 	   => true,
				'version'      => '1.0.3'
			),
			array(
				'name'         => 'Alchemists SCSS Compiler',
				'slug'         => 'alc-scss',
				'source'       => get_template_directory() . '/inc/plugins/alc-scss.zip',
				'required'     => true,
				'version'      => '2.0.2',
			),
			array(
				'name' 		     => 'One Click Demo Import',
				'slug' 		     => 'one-click-demo-import',
				'required' 	   => false,
			),
			array(
				'name'         => 'Envato Market',
				'slug'         => 'envato-market',
				'required'     => false,
				'source'       => 'https://github.com/envato/wp-envato-market/archive/master.zip',
				'external_url' => 'https://github.com/envato/wp-envato-market',
				'version'      => '1.0.0-RC2'
			),
			array(
				'name' 		     => 'Contact Form 7',
				'slug' 		     => 'contact-form-7',
				'required' 	   => false,
			),
			array(
				'name' 		     => 'Breadcrumb Trail',
				'slug' 		     => 'breadcrumb-trail',
				'required' 	   => true,
			),
			array(
				'name' 		     => 'MailChimp for WordPress',
				'slug' 		     => 'mailchimp-for-wp',
				'required' 	   => false,
			),
			array(
				'name' 		     => 'Easy Custom Sidebars',
				'slug' 		     => 'easy-custom-sidebars',
				'required' 	   => false,
			),
			array(
				'name'         => 'DF Twitter Widget',
				'slug'         => 'df-twitter-widget',
				'source'       => 'https://github.com/danfisher85/df-twitter-widget/archive/master.zip',
				'external_url' => 'https://github.com/danfisher85/df-twitter-widget',
				'required'     => false,
				'version'      => '1.0.1'
			),
			array(
				'name' 		     => 'WooCommerce',
				'slug' 		     => 'woocommerce',
				'required' 	   => false,
			),
			array(
				'name'         => 'WooCommerce Grid / List toggle',
				'slug'         => 'woocommerce-grid-list-toggle',
				'source'       => 'https://github.com/danfisher85/woocommerce-grid-list-toggle/archive/master.zip',
				'external_url' => 'https://github.com/danfisher85/woocommerce-grid-list-toggle',
				'required'     => false,
				'version'      => '1.1.0'
			),
			array(
				'name' 		     => 'Color Filters for WooCommerce',
				'slug' 		     => 'color-filters',
				'required' 	   => false,
			),
			array(
				'name' 		     => 'Nav Menu Roles',
				'slug' 		     => 'nav-menu-roles',
				'required' 	   => true,
			),
		);

		$config = array(
			'id'             => 'alchemists',         	    // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path'   => '',                        	// Default absolute path to pre-packaged plugins
			'menu'           => 'tgmpa-install-plugins',    // Menu slug
			'has_notices'    => true,                       // Show admin notices or not
			'is_automatic'   => true,					   	          // Automatically activate plugins after installation or not
			'dismissable'    => true,                       // If false, a user cannot dismiss the nag message.
			'dismiss_msg'    => '',                         // If 'dismissable' is false, this message will be output at top of nag.
			'message'        => '',
		);

		tgmpa( $plugins, $config );

	}
}

add_action( 'tgmpa_register', 'alchemists_register_required_plugins' );
