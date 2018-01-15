<?php
/**
 * Importer function
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The importer class.
 */
class ODI_Importer {

	/**
	 * Class Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// Return if not in admin
		if ( ! is_admin() || is_customize_preview() ) {
			return;
		}

		// Disable Woo Wizard
		add_filter( 'woocommerce_enable_setup_wizard', false );

		// Start things
		add_action( 'admin_init', array( $this, 'init' ) );

		// Allows xml uploads
		add_filter( 'upload_mimes', array( $this, 'allow_xml_uploads' ) );
	}

	/**
	 * Register the AJAX method
	 *
	 * @since 1.0.0
	 */
	public function init() {
		add_action( 'wp_ajax_ocean_import_demo_data', array( $this, 'ocean_importer' ) );		
	}

	/**
	 * Return data
	 *
	 * @since 1.0.0
	 */
	public static function get_data() {

		// Demos url
		$url = 'https://raw.githubusercontent.com/oceanwp/oceanwp-sample-data/master/';

		$data = array(

			'architect' => array(
				'categories'        => array( 'Business' ),
				'xml_file'     		=> $url . 'architect/sample-data.xml',
				'theme_settings' 	=> $url . 'architect/oceanwp-export.json',
				'widgets_file'  	=> $url . 'architect/widgets.wie',
				'home_title'  		=> 'Home',
				'blog_title'  		=> 'Blog',
				'posts_to_show'  	=> '3',
				'elementor_width'  	=> '1220',
				'is_shop'  			=> false,
			),
			
			'blogger' => array(
				'categories'        => array( 'Blog' ),
				'xml_file'     		=> $url . 'blogger/sample-data.xml',
				'theme_settings' 	=> $url . 'blogger/oceanwp-export.json',
				'widgets_file'  	=> $url . 'blogger/widgets.wie',
				'home_title'  		=> '',
				'blog_title'  		=> 'Home',
				'posts_to_show'  	=> '12',
				'is_shop'  			=> false,
			),
			
			'coach' => array(
				'categories'        => array( 'Business', 'Sport', 'One Page' ),
				'xml_file'     		=> $url . 'coach/sample-data.xml',
				'theme_settings' 	=> $url . 'coach/oceanwp-export.json',
				'widgets_file'  	=> $url . 'coach/widgets.wie',
				'home_title'  		=> 'Home',
				'blog_title'  		=> 'Blog',
				'posts_to_show'  	=> '3',
				'is_shop'  			=> false,
			),
			
			'gym' => array(
				'categories'        => array( 'Business', 'Sport' ),
				'xml_file'     		=> $url . 'gym/sample-data.xml',
				'theme_settings' 	=> $url . 'gym/oceanwp-export.json',
				'widgets_file'  	=> $url . 'gym/widgets.wie',
				'home_title'  		=> 'Home',
				'blog_title'  		=> 'News',
				'posts_to_show'  	=> '3',
				'elementor_width'  	=> '1100',
				'is_shop'  			=> false,
			),
			
			'lawyer' => array(
				'categories'        => array( 'Business' ),
				'xml_file'     		=> $url . 'lawyer/sample-data.xml',
				'theme_settings' 	=> $url . 'lawyer/oceanwp-export.json',
				'widgets_file'  	=> $url . 'lawyer/widgets.wie',
				'home_title'  		=> 'Home',
				'blog_title'  		=> 'Blog',
				'posts_to_show'  	=> '3',
				'elementor_width'  	=> '1220',
				'is_shop'  			=> false,
			),
			
			'megagym' => array(
				'categories'        => array( 'Business', 'Sport', 'One Page' ),
				'xml_file'     		=> $url . 'megagym/sample-data.xml',
				'theme_settings' 	=> $url . 'megagym/oceanwp-export.json',
				'widgets_file'  	=> $url . 'megagym/widgets.wie',
				'home_title'  		=> 'Home',
				'blog_title'  		=> 'Blog',
				'posts_to_show'  	=> '3',
				'is_shop'  			=> false,
			),
			
			'personal' => array(
				'categories'        => array( 'Blog' ),
				'xml_file'     		=> $url . 'personal/sample-data.xml',
				'theme_settings' 	=> $url . 'personal/oceanwp-export.json',
				'widgets_file'  	=> $url . 'personal/widgets.wie',
				'home_title'  		=> '',
				'blog_title'  		=> 'Home',
				'posts_to_show'  	=> '3',
				'is_shop'  			=> false,
			),
			
			'simple' => array(
				'categories'        => array( 'eCommerce' ),
				'xml_file'     		=> $url . 'simple/sample-data.xml',
				'theme_settings' 	=> $url . 'simple/oceanwp-export.json',
				'widgets_file'  	=> $url . 'simple/widgets.wie',
				'home_title'  		=> 'Home',
				'blog_title'  		=> 'Blog',
				'posts_to_show'  	=> '3',
				'elementor_width'  	=> '1100',
				'is_shop'  			=> true,
				'catalog_img' 		=> array(
					'width'     => '348',
					'height' 	=> '464',
				),
				'single_img' 		=> array(
					'width'     => '454',
					'height' 	=> '608',
				),
				'thumbnails_img' 	=> array(
					'width'     => '90',
					'height' 	=> '120',
				),
			),
			
			'store' => array(
				'categories'        => array( 'eCommerce' ),
				'xml_file'     		=> $url . 'store/sample-data.xml',
				'theme_settings' 	=> $url . 'store/oceanwp-export.json',
				'widgets_file'  	=> $url . 'store/widgets.wie',
				'home_title'  		=> 'Home',
				'blog_title'  		=> 'Blog',
				'posts_to_show'  	=> '3',
				'elementor_width'  	=> '1220',
				'is_shop'  			=> true,
				'catalog_img' 		=> array(
					'width'     => '265',
					'height' 	=> '354',
				),
				'single_img' 		=> array(
					'width'     => '504',
					'height' 	=> '674',
				),
				'thumbnails_img' 	=> array(
					'width'     => '93',
					'height' 	=> '120',
				),
			),
			
			'stylish' => array(
				'categories'        => array( 'Business' ),
				'xml_file'     		=> $url . 'stylish/sample-data.xml',
				'theme_settings' 	=> $url . 'stylish/oceanwp-export.json',
				'home_title'  		=> 'Home',
				'blog_title'  		=> 'Blog',
				'posts_to_show'  	=> '12',
				'elementor_width'  	=> '1420',
				'is_shop'  			=> false,
			),
			
			'travel' => array(
				'categories'        => array( 'Blog' ),
				'xml_file'     		=> $url . 'travel/sample-data.xml',
				'theme_settings' 	=> $url . 'travel/oceanwp-export.json',
				'widgets_file'  	=> $url . 'travel/widgets.wie',
				'home_title'  		=> 'Home',
				'blog_title'  		=> 'Blog',
				'posts_to_show'  	=> '4',
				'elementor_width'  	=> '1220',
				'is_shop'  			=> false,
			),
			
			'lingerie' => array(
				'categories'        => array( 'eCommerce' ),
				'xml_file'     		=> $url . 'lingerie/sample-data.xml',
				'theme_settings' 	=> $url . 'lingerie/oceanwp-export.json',
				'widgets_file'  	=> $url . 'lingerie/widgets.wie',
				'home_title'  		=> 'Home',
				'blog_title'  		=> 'Blog',
				'posts_to_show'  	=> '3',
				'elementor_width'  	=> '1220',
				'is_shop'  			=> true,
				'catalog_img' 		=> array(
					'width'     => '265',
					'height' 	=> '352',
				),
				'single_img' 		=> array(
					'width'     => '433',
					'height' 	=> '578',
				),
				'thumbnails_img' 	=> array(
					'width'     => '90',
					'height' 	=> '120',
				),
			),
			
			'yoga' => array(
				'categories'        => array( 'Business', 'Sport' ),
				'xml_file'     		=> $url . 'yoga/sample-data.xml',
				'theme_settings' 	=> $url . 'yoga/oceanwp-export.json',
				'widgets_file'  	=> $url . 'yoga/widgets.wie',
				'home_title'  		=> 'Home',
				'blog_title'  		=> 'Blog',
				'posts_to_show'  	=> '3',
				'is_shop'  			=> false,
			),

		);

		// Return
		return $data;

	}

	/**
	 * Get the category list of all categories used in the predefined demo imports array.
	 *
	 * @since 1.0.2
	 */
	public static function get_all_categories( $demo_imports ) {
		$categories = array();

		foreach ( $demo_imports as $item ) {
			if ( ! empty( $item['categories'] ) && is_array( $item['categories'] ) ) {
				foreach ( $item['categories'] as $category ) {
					$categories[ sanitize_key( $category ) ] = $category;
				}
			}
		}

		if ( empty( $categories ) ) {
			return false;
		}

		return $categories;
	}

	/**
	 * Return the concatenated string of demo import item categories.
	 * These should be separated by comma and sanitized properly.
	 *
	 * @since 1.0.2
	 */
	public static function get_item_categories( $item ) {
		$sanitized_categories = array();

		if ( isset( $item['categories'] ) ) {
			foreach ( $item['categories'] as $category ) {
				$sanitized_categories[] = sanitize_key( $category );
			}
		}

		if ( ! empty( $sanitized_categories ) ) {
			return implode( ',', $sanitized_categories );
		}

		return false;
	}

	/**
	 * Allows xml uploads so we can import from github
	 *
	 * @since 1.0.0
	 */
	public function allow_xml_uploads( $mimes ) {
		$mimes = array_merge( $mimes, array(
			'xml' 	=> 'application/xml'
		) );
		return $mimes;
	}

	/**
	 * Importer
	 *
	 * @since 1.0.0
	 */
	public function ocean_importer() {

		// Include settings importer
		include ODI_PATH . 'includes/class/class-settings-importer.php';

		// Include widgets importer
		include ODI_PATH . 'includes/class/class-widget-importer.php';

		if ( current_user_can( 'manage_options' ) ) {

			if ( ! isset( $_POST['demo_type'] ) || '' == trim( $_POST['demo_type'] ) ) {
				$demo_type = 'architect';
			} else {
				$demo_type = $_POST['demo_type'];
			}

			// Get demo data
			$demo = self::get_data()[ $demo_type ];

			// Content file
			$xml_file 			= isset ( $demo['xml_file'] ) ? $demo['xml_file'] : '';

			// Settings file
			$theme_settings 	= isset ( $demo['theme_settings'] ) ? $demo['theme_settings'] : '';

			// Widgets file
			$widgets_file 		= isset ( $demo['widgets_file'] ) ? $demo['widgets_file'] : '';

			// Elementor width setting
			if ( $demo['elementor_width'] ) {
				$elementor_width = isset ( $demo['elementor_width'] ) ? $demo['elementor_width'] : '';
			}

			// Reading settings
			$homepage_title 	= isset ( $demo['home_title'] ) ? $demo['home_title'] : 'Home';
			$blog_title 		= isset ( $demo['blog_title'] ) ? $demo['blog_title'] : 'Blog';

			// Posts to show on the blog page
			$posts_to_show 		= isset ( $demo['posts_to_show'] ) ? $demo['posts_to_show'] : '';

			// If shop demo
			$shop_demo 			= isset ( $demo['is_shop'] ) ? $demo['is_shop'] : false;

			// Woo catalog images sizes
			$catalog_img 		= isset ( $demo['catalog_img'] ) ? $demo['catalog_img'] : '';
			$c_width 			= isset ( $catalog_img['width'] ) ? $catalog_img['width'] : '';
			$c_height 			= isset ( $catalog_img['height'] ) ? $catalog_img['height'] : '';

			// Woo single product image sizes
			$single_img 		= isset ( $demo['single_img'] ) ? $demo['single_img'] : '';
			$s_width 			= isset ( $single_img['width'] ) ? $single_img['width'] : '';
			$s_height 			= isset ( $single_img['height'] ) ? $single_img['height'] : '';

			// Woo product thumbnails images sizes
			$thumbnails_img 	= isset ( $demo['thumbnails_img'] ) ? $demo['thumbnails_img'] : '';
			$t_width 			= isset ( $thumbnails_img['width'] ) ? $thumbnails_img['width'] : '';
			$t_height 			= isset ( $thumbnails_img['height'] ) ? $thumbnails_img['height'] : '';

			// Import Posts, Pages, Images, Menus.
			$this->process_xml( $xml_file );

			// Assign WooCommerce pages if WooCommerce Exists
			if ( class_exists( 'WooCommerce' ) && $shop_demo ) {

				$woopages = array(
					'woocommerce_shop_page_id' 				=> 'Shop',
					'woocommerce_cart_page_id' 				=> 'Cart',
					'woocommerce_checkout_page_id' 			=> 'Checkout',
					'woocommerce_pay_page_id' 				=> 'Checkout &#8594; Pay',
					'woocommerce_thanks_page_id' 			=> 'Order Received',
					'woocommerce_myaccount_page_id' 		=> 'My Account',
					'woocommerce_edit_address_page_id' 		=> 'Edit My Address',
					'woocommerce_view_order_page_id' 		=> 'View Order',
					'woocommerce_change_password_page_id' 	=> 'Change Password',
					'woocommerce_logout_page_id' 			=> 'Logout',
					'woocommerce_lost_password_page_id' 	=> 'Lost Password'
				);

				foreach ( $woopages as $woo_page_name => $woo_page_title ) {

					$woopage = get_page_by_title( $woo_page_title );
					if ( isset( $woopage ) && $woopage->ID ) {
						update_option( $woo_page_name, $woopage->ID );
					}

				}

				// Catalog images sizes
				if ( $catalog_img ) {
					$catalog = array(
						'width' 	=> $c_width,
						'height'	=> $c_height,
						'crop'		=> 1
					);
					update_option( 'shop_catalog_image_size', $catalog );
				}

				// Single product image sizes
				if ( $single_img ) {
					$single = array(
						'width' 	=> $s_width,
						'height'	=> $s_height,
						'crop'		=> 1
					);
					update_option( 'shop_single_image_size', $single );
				}

				// Product thumbnails image sizes
				if ( $thumbnails_img ) {
					$thumbnail = array(
						'width' 	=> $t_width,
						'height'	=> $t_height,
						'crop'		=> 1
					);
					update_option( 'shop_thumbnail_image_size', $thumbnail );
				}

				// We no longer need to install pages
				delete_option( '_wc_needs_pages' );
				delete_transient( '_wc_activation_redirect' );

			}

			// Import settings
			if ( $theme_settings ) {
				$settings_importer = new ODI_Settings_Importer();
				$settings_importer->process_import_file( $theme_settings );
			}

			// Import widgets
			if ( $widgets_file ) {
				$widgets_importer = new ODI_Widget_Importer();
				$widgets_importer->process_import_file( $widgets_file );
			}

			// Set imported menus to registered theme locations
			$locations 	= get_theme_mod( 'nav_menu_locations' );
			$menus 		= wp_get_nav_menus();

			if ( $menus ) {
				
				foreach ( $menus as $menu ) {

					if ( $menu->name == 'Main Menu' ) {
						$locations['main_menu'] = $menu->term_id;
					} else if ( $menu->name == 'Top Menu' ) {
						$locations['topbar_menu'] = $menu->term_id;
					} else if ( $menu->name == 'Footer Menu' ) {
						$locations['footer_menu'] = $menu->term_id;
					} else if ( $menu->name == 'Sticky Footer' ) {
						$locations['sticky_footer_menu'] = $menu->term_id;
					}

				}

			}

			// Set menus to locations
			set_theme_mod( 'nav_menu_locations', $locations );

			// Disable Elementor default settings
			update_option( 'elementor_disable_color_schemes', 'yes' );
			update_option( 'elementor_disable_typography_schemes', 'yes' );
			if ( $elementor_width ) {
				update_option( 'elementor_container_width', $elementor_width );
			}

			// Assign front page and posts page (blog page).
		    $home_page 	= get_page_by_title( $homepage_title );
		    $blog_page 	= get_page_by_title( $blog_title );

		    update_option( 'show_on_front', 'page' );

		    if ( isset( $home_page ) && $home_page->ID ) {
				update_option( 'page_on_front', $home_page->ID );
			}

			if ( isset( $blog_page ) && $blog_page->ID ) {
				update_option( 'page_for_posts', $blog_page->ID );
			}

			// Posts to show on the blog page
			if ( $posts_to_show ) {
				update_option( 'posts_per_page', $posts_to_show );
			}

			echo 'imported';

			exit;

		}

	}

	/**
	 * Import XML data
	 *
	 * @since 1.0.0
	 */
	public function process_xml( $file ) {
		
		$response = ODI_Helpers::get_remote( $file );

		// No sample data found
		if ( $response === false ) {
			return new WP_Error( 'xml_import_error', __( 'Can not retrieve sample data xml file. Github may be down at the momment please try again later. If you still have issues contact the theme developer for assistance.', 'ocean-demo-import' ) );
		}

		// Write sample data content to temp xml file
		$temp_xml = ODI_PATH .'includes/temp.xml';
		file_put_contents( $temp_xml, $response );

		// Set temp xml to attachment url for use
		$attachment_url = $temp_xml;

		// If file exists lets import it
		if ( file_exists( $attachment_url ) ) {
			$this->import_xml( $attachment_url );
		} else {
			// Import file can't be imported - we should die here since this is core for most people.
			return new WP_Error( 'xml_import_error', __( 'The xml import file could not be accessed. Please try again or contact the theme developer.', 'ocean-demo-import' ) );
		}

	}
	
	/**
	 * Import XML file
	 *
	 * @since 1.0.0
	 */
	private function import_xml( $file ) {

		// Make sure importers constant is defined
		if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
			define( 'WP_LOAD_IMPORTERS', true );
		}

		// Import file location
		$import_file = ABSPATH . 'wp-admin/includes/import.php';

		// Include import file
		if ( ! file_exists( $import_file ) ) {
			return;
		}

		// Include import file
		require_once( $import_file );

		// Define error var
		$importer_error = false;

		if ( ! class_exists( 'WP_Importer' ) ) {
			$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';

			if ( file_exists( $class_wp_importer ) ) {
				require_once $class_wp_importer;
			} else {
				$importer_error = __( 'Can not retrieve class-wp-importer.php', 'ocean-demo-import' );
			}
		}

		if ( ! class_exists( 'WP_Import' ) ) {
			$class_wp_import = ODI_PATH . 'includes/class/class-wordpress-importer.php';

			if ( file_exists( $class_wp_import ) ) {
				require_once $class_wp_import;
			} else {
				$importer_error = __( 'Can not retrieve wordpress-importer.php', 'ocean-demo-import' );
			}
		}

		// Display error
		if ( $importer_error ) {
			return new WP_Error( 'xml_import_error', $importer_error );
		} else {

			// No error, lets import things...
			if ( ! is_file( $file ) ) {
				$importer_error = __( 'Sample data file appears corrupt or can not be accessed.', 'ocean-demo-import' );
				return new WP_Error( 'xml_import_error', $importer_error );
			} else {
				$importer = new WP_Import();
				$importer->fetch_attachments = true;
				$importer->import( $file );

				// Clear sample data content from temp xml file
				$temp_xml = ODI_PATH .'includes/temp.xml';
				file_put_contents( $temp_xml, '' );
			}
		}
	}

}
new ODI_Importer();