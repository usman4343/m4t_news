<?php
/**
 * alchemists functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Alchemists
 */


/**
 * Theme defines
 */
define( 'ACF_LITE', ! defined( 'ALC_DEV_MODE' ) );
define( 'THEME_VERSION', wp_get_theme( get_template() )->get( 'Version' )  );


if ( ! function_exists( 'alchemists_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function alchemists_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on alchemists, use a find and replace
	 * to change 'alchemists' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'alchemists', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for WooCommerce
	 */
	add_theme_support( 'woocommerce' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 380, 370, true ); // Normal post thumbnails
	add_image_size('alchemists_thumbnail', 380, 270, true); // Thumbnail Normal
	add_image_size('alchemists_thumbnail-alt', 380, 200, true); // Thumbnail Normal
	add_image_size('alchemists_thumbnail-xs', 80, 80, true); // Thumbnail XS
	add_image_size('alchemists_thumbnail-sm', 280, 218, true); // Thumbnail SM
	add_image_size('alchemists_thumbnail-n', 500, 280, true); // Thumbnail Normal
	add_image_size('alchemists_thumbnail-lg', 773, 380, true); // Thumbnail Large
	add_image_size('alchemists_thumbnail-lg-alt', 773, 408, true); // Thumbnail Large
	add_image_size('alchemists_thumbnail-player', 356, 400, false); // Player Normal
	add_image_size('alchemists_thumbnail-player-lg', 380, 570, true); // Player Large
	add_image_size('alchemists_thumbnail-player-lg-fit', 470, 580, false); // Player Large - fit
	add_image_size('alchemists_thumbnail-player-sm', 189, 198, array('left', 'top')); // Player Small
	add_image_size('alchemists_thumbnail-player-block', 140, 210, true); // Player Small (Team Blocks)
	add_image_size('alchemists_team-logo-sm-fit', 70, 70, false ); // Team Logo Small - fit
	add_image_size('alchemists_team-logo-fit', 100, 100, false ); // Team Logo Normal - fit
	add_image_size('alchemists_player-xxs', 40, 40, array('center', 'top')); // Thumbnail XXS

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary'       => esc_html__( 'Primary Menu', 'alchemists' ),
		'top_menu'      => esc_html__( 'Top Menu', 'alchemists' ),
		'footer_menu'   => esc_html__( 'Footer Menu', 'alchemists' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'video',
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * Declare support for Sportspress.
	 */
	add_theme_support( 'sportspress' );

}
endif;
add_action( 'after_setup_theme', 'alchemists_setup' );


/**
 * Load ACF fields
 */
if ( ! defined( 'ALC_DEV_MODE' ) ) {
	require_once get_template_directory() . '/inc/acf-fields.php';
}


/**
 * Add Redux Framework & extras
 */
if ( class_exists('ReduxFrameworkPlugin') ) {

	// Init Redux Framework
	require get_template_directory() . '/admin/admin-init.php';

	// Remove Redux demo mode link
	function alchemists_remove_demo_mode_link() {
		remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2 );
		remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );
	}
	add_action('init', 'alchemists_remove_demo_mode_link');

	// Remove Redux Dashboard meta
	function alchemists_remove_dashboard_meta() {
		remove_meta_box( 'redux_dashboard_widget', 'dashboard', 'side', 'high' );
	}
	add_action( 'admin_init', 'alchemists_remove_dashboard_meta' );

	/**
	 * Load theme styling
	 */
	require_once get_template_directory() . '/inc/custom-styling.php';
}


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function alchemists_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'alchemists_content_width', 640 );
}
add_action( 'after_setup_theme', 'alchemists_content_width', 0 );


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function alchemists_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'alchemists' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'alchemists' ),
		'before_widget' => '<div id="%1$s" class="widget widget--sidebar card %2$s"><div class="widget__content card__content">',
		'after_widget'  => '</div></div>',
		'before_title'  => '</div><div class="widget__title card__header"><h4>',
		'after_title'   => '</h4></div><div class="widget__content card__content">',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Home - Sidebar 1', 'alchemists' ),
		'id'            => 'home-sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'alchemists' ),
		'before_widget' => '<div id="%1$s" class="widget widget--sidebar card %2$s"><div class="widget__content card__content">',
		'after_widget'  => '</div></div>',
		'before_title'  => '</div><div class="widget__title card__header"><h4>',
		'after_title'   => '</h4></div><div class="widget__content card__content">',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Home - Sidebar 2', 'alchemists' ),
		'id'            => 'home-sidebar-2',
		'description'   => esc_html__( 'Add widgets here.', 'alchemists' ),
		'before_widget' => '<div id="%1$s" class="widget widget--sidebar card %2$s"><div class="widget__content card__content">',
		'after_widget'  => '</div></div>',
		'before_title'  => '</div><div class="widget__title card__header"><h4>',
		'after_title'   => '</h4></div><div class="widget__content card__content">',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Home - Sidebar 3', 'alchemists' ),
		'id'            => 'home-sidebar-3',
		'description'   => esc_html__( 'Add widgets here.', 'alchemists' ),
		'before_widget' => '<div id="%1$s" class="widget widget--sidebar card %2$s"><div class="widget__content card__content">',
		'after_widget'  => '</div></div>',
		'before_title'  => '</div><div class="widget__title card__header"><h4>',
		'after_title'   => '</h4></div><div class="widget__content card__content">',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Megamenu Widget Area 1', 'alchemists' ),
		'id'            => 'megamenu-sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'alchemists' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Megamenu Widget Area 2', 'alchemists' ),
		'id'            => 'megamenu-sidebar-2',
		'description'   => esc_html__( 'Add widgets here.', 'alchemists' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>'
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Pushy Panel', 'alchemists' ),
		'id'            => 'alchemists-sidebar-pushy-panel',
		'description'   => esc_html__( 'This panel slides from right side and works only on desktop.', 'alchemists' ),
		'before_widget' => '<div id="%1$s" class="widget widget--side-panel %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget__title">',
		'after_title'   => '</h4>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget Area 1', 'alchemists' ),
		'id'            => 'alchemists-footer-widget-1',
		'description'   => esc_html__( '1st Footer Widget Area.', 'alchemists' ),
		'before_widget' => '<div id="%1$s" class="widget widget--footer %2$s"><div class="widget__content">',
		'after_widget'  => '</div></div>',
		'before_title'  => '</div><h4 class="widget__title">',
		'after_title'   => '</h4><div class="widget__content">',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget Area 2', 'alchemists' ),
		'id'            => 'alchemists-footer-widget-2',
		'description'   => esc_html__( '2nd Footer Widget Area', 'alchemists' ),
		'before_widget' => '<div id="%1$s" class="widget widget--footer %2$s"><div class="widget__content">',
		'after_widget'  => '</div></div>',
		'before_title'  => '</div><h4 class="widget__title">',
		'after_title'   => '</h4><div class="widget__content">',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget Area 3', 'alchemists' ),
		'id'            => 'alchemists-footer-widget-3',
		'description'   => esc_html__( '3rd Footer Widget Area', 'alchemists' ),
		'before_widget' => '<div id="%1$s" class="widget widget--footer %2$s"><div class="widget__content">',
		'after_widget'  => '</div></div>',
		'before_title'  => '</div><h4 class="widget__title">',
		'after_title'   => '</h4><div class="widget__content">',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Footer Widget Area 4', 'alchemists' ),
		'id'            => 'alchemists-footer-widget-4',
		'description'   => esc_html__( '4th Footer Widget Area', 'alchemists' ),
		'before_widget' => '<div id="%1$s" class="widget widget--footer %2$s"><div class="widget__content">',
		'after_widget'  => '</div></div>',
		'before_title'  => '</div><h4 class="widget__title">',
		'after_title'   => '</h4><div class="widget__content">',
	) );
}
add_action( 'widgets_init', 'alchemists_widgets_init' );

function alchemists_woo_widgets_init() {
	// Woocommerce Shop Sidebar
	if( alchemists_wc_exists() ){
		register_sidebar( array(
			'name'          => esc_html__( 'Shop Sidebar', 'alchemists' ),
			'id'            => 'alchemists-shop-sidebar',
			'description'   => esc_html__( 'Shop Sidebar that appears on Shop pages.', 'alchemists' ),
			'before_widget' => '<div id="%1$s" class="widget widget--sidebar card %2$s"><div class="widget__content card__content">',
			'after_widget'  => '</div></div>',
			'before_title'  => '</div><div class="widget__title card__header"><h4>',
			'after_title'   => '</h4></div><div class="widget__content card__content">',
		));
	}
}
add_action( 'widgets_init', 'alchemists_woo_widgets_init' );


/*
	* This theme styles the visual editor to resemble the theme style,
	* specifically font, colors, icons, and column width.
	*/
add_editor_style( array( 'assets/css/editor-style.css') );


/**
 * Enqueue scripts and styles.
 */
if( !function_exists( 'alchemists_scripts' ) ) {
	function alchemists_scripts() {

		// Styles
		// Vendors CSS
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/vendor/bootstrap/css/bootstrap.min.css', array(), '3.3.7' );
		wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/assets/fonts/font-awesome/css/font-awesome.min.css', array(), '4.7.0' );
		wp_enqueue_style( 'simpleicons', get_template_directory_uri() . '/assets/fonts/simple-line-icons/css/simple-line-icons.css', array(), '2.4.0' );
		wp_enqueue_style( 'magnificpopup', get_template_directory_uri() . '/assets/vendor/magnific-popup/dist/magnific-popup.css', array(), '1.1.0' );
		wp_enqueue_style( 'slick', get_template_directory_uri() . '/assets/vendor/slick/slick.css', array(), '1.6.0' );

		// Main CSS
		if ( alchemists_sp_preset('soccer') ) {
			wp_enqueue_style( 'alchemists-style', get_template_directory_uri() . '/assets/css/style-soccer.css', array(), THEME_VERSION );
		} else {
			wp_enqueue_style( 'alchemists-style', get_template_directory_uri() . '/assets/css/style-basketball.css', array(), THEME_VERSION );
		}

		// If using a child theme, auto-load the parent theme style.
		if ( is_child_theme() ) {
			wp_enqueue_style( 'alchemists-parent-info', trailingslashit( get_template_directory_uri() ) . 'style.css' );
		} else {
			wp_enqueue_style( 'alchemists-info', get_stylesheet_uri() );
		}

		// Add styles if WooCommerce installed
		if( alchemists_wc_exists() ) {
			if ( alchemists_sp_preset('soccer') ) {
				wp_enqueue_style( 'woocommerce', get_template_directory_uri() . '/assets/css/woocommerce-soccer.css', array(), false);
			} else {
				wp_enqueue_style( 'woocommerce', get_template_directory_uri() . '/assets/css/woocommerce-basketball.css', array(), false);
			}
		}

		// Add styles if Sporspress installed
		if ( class_exists( 'SportsPress' ) ) {
			if ( alchemists_sp_preset('soccer') ) {
				wp_enqueue_style( 'alchemists-sportspress', get_template_directory_uri() . '/assets/css/sportspress-soccer.css', array(), THEME_VERSION);
			} else {
				wp_enqueue_style( 'alchemists-sportspress', get_template_directory_uri() . '/assets/css/sportspress-basketball.css', array(), THEME_VERSION);
			}
		}


		//Scripts
		wp_enqueue_script( 'alchemists-core', get_template_directory_uri() . '/assets/js/core-min.js', array('jquery'), '1.0.0', true );
		wp_enqueue_script( 'alchemists-init', get_template_directory_uri() . '/assets/js/init-min.js', array('jquery'), THEME_VERSION, true );
		wp_enqueue_script( 'alchemists-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

		wp_register_script( 'alchemists-social-counters', get_template_directory_uri() . '/assets/vendor/social-counters/social-counters-api-min.js', array(), '1.0.0', true );
		wp_register_script( 'alchemists-instafeed', get_template_directory_uri() . '/assets/vendor/instafeed/instafeed.min.js', array(), '1.9.3', true );
		wp_register_script( 'alchemists-chartjs', get_template_directory_uri() . '/assets/vendor/chartjs/chart-min.js', array(), '2.7.0', true );

		wp_enqueue_script( 'alchemists-social-counters', get_template_directory_uri() . '/assets/vendor/social-counters/social-counters-api-min.js', array(), '1.0.0', true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'alchemists_scripts' );
}

// Load child style.css and enqueue it after the all styles
if ( is_child_theme() ) {
	function alchemists_load_child_theme_styles() {
		wp_enqueue_style( 'alchemists-child', get_stylesheet_uri() );
	}
	add_action( 'wp_enqueue_scripts', 'alchemists_load_child_theme_styles', 99 );
}


// Shortcodes in Menu
add_filter('wp_nav_menu_items', 'do_shortcode');


/**
 * Set Default Favicon (can be changed with has_site_icon WP 4.3+)
 */
if(!function_exists('alchemists_wp_site_icon')) {
	function alchemists_wp_site_icon() {
		if ( ! ( function_exists( 'has_site_icon' ) && has_site_icon() ) ) {

			if ( alchemists_sp_preset('soccer') ) {
				echo '<link rel="shortcut icon" href="' . esc_url( get_template_directory_uri() ) . '/assets/images/soccer/favicons/favicon.ico" type="image/x-icon" />' . "\n";
				echo '<link rel="apple-touch-icon" sizes="120x120" href="' . esc_url( get_template_directory_uri() ) .'/assets/images/soccer/favicons/favicon-120.png">' . "\n";
				echo '<link rel="apple-touch-icon" sizes="152x152" href="' . esc_url( get_template_directory_uri() ) . '/assets/images/soccer/favicons/favicon-152.png">' . "\n";
			} else {
				echo '<link rel="shortcut icon" href="' . esc_url( get_template_directory_uri() ) . '/assets/images/favicons/favicon.ico" type="image/x-icon" />' . "\n";
				echo '<link rel="apple-touch-icon" sizes="120x120" href="' . esc_url( get_template_directory_uri() ) .'/assets/images/favicons/favicon-120.png">' . "\n";
				echo '<link rel="apple-touch-icon" sizes="152x152" href="' . esc_url( get_template_directory_uri() ) . '/assets/images/favicons/favicon-152.png">' . "\n";
			}

		}
	}
}
add_action('wp_head', 'alchemists_wp_site_icon');


/**
 * Page Preloader
 */
if ( ! function_exists('alchemists_page_preloader')) {
	function alchemists_page_preloader() {
		$alchemists_data = get_option('alchemists_data');
		$preloader = isset( $alchemists_data['alchemists__opt-pageloader'] ) ? $alchemists_data['alchemists__opt-pageloader'] : true;

		// Check if Preloader enabled
		if ( $preloader ) : ?>
			<div id="js-preloader-overlay" class="preloader-overlay">
				<div id="js-preloader" class="preloader"></div>
			</div>
		<?php endif;
	}
}
add_action( 'alchemists_before_body_content', 'alchemists_page_preloader' );


// Load Social Counters scripts (hooked in inc/widgets/widget-social-counters.php by wp_enqueue_scripts)
if(!function_exists('alchemists_social_widget_load')) {
	function alchemists_social_widget_load () {
		wp_enqueue_script('alchemists-social-counters');
	}
}

// Load Instagram scripts (hooked in inc/widgets/widget-instagram-feed.php by wp_enqueue_scripts)
if(!function_exists('alchemists_instafeed_widget_load')) {
	function alchemists_instafeed_widget_load () {
		wp_enqueue_script('alchemists-instafeed');
	}
}

/**
 * Admin styling fix
 */
if(!function_exists('alchemists_custom_admin_css')) {
	function alchemists_custom_admin_css(){
		if( is_admin() ) {
			wp_enqueue_style( 'alchemists-custom-admin', get_template_directory_uri(). '/admin/css/custom-admin.css', array(), THEME_VERSION);
		}
	}
}
add_action( 'admin_enqueue_scripts', 'alchemists_custom_admin_css' );



/**
 * Visual Composer Functions
 */
if(!function_exists('alchemists_vc_exists')) {
	function alchemists_vc_exists() {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php');
		if ( is_plugin_active('js_composer/js_composer.php')) {
		 return true;
		}
		else {
			return false;
		}
	}
}

/**
 * SportsPress global functions
 */
include get_template_directory() . '/inc/sp-global-functions.php';


// Include Visual Composer custom functions
if( alchemists_vc_exists() == true) {
	include get_template_directory() . '/inc/vc-functions.php';
	include get_template_directory() . '/inc/vc-templates.php';
}

/**
 * SportsPress functions
 */
if( class_exists( 'SportsPress' ) ) {
	include get_template_directory() . '/inc/sp-functions.php';
}


/**
 * WooCommerce functions
 */
function alchemists_wc_exists() {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php');
	if ( is_plugin_active('woocommerce/woocommerce.php') ) {
		return true;
	}
	else {
		return false;
	}
}
if ( alchemists_wc_exists() == true) {
	include get_template_directory() . '/inc/wc-functions.php';
}


/**
 * Disabled update notification for premium plugins
 */
if ( ! defined( 'ALC_DEV_MODE' ) ) {

	add_action( 'acf/init', 'alchemists_acf_updates' );
	function alchemists_acf_updates() {
		acf_update_setting( 'show_updates', false );
	}
}


/**
 * Fallbacks
 */
require_once get_template_directory() . '/inc/fallbacks.php';

/**
 * Load TGMPA
 */
require_once get_template_directory() . '/admin/tgm/tgm-init.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/widgets.php';


/**
 * Load Menu Custom Fields on backend
 */
require_once get_template_directory() . '/admin/menu-item-custom-fields/menu-item-custom-fields.php';

if(!function_exists('alchemists_menus_hook')) {
	function alchemists_menus_hook() {
		wp_enqueue_script( 'alchemists-menus-scripts', get_template_directory_uri() . '/admin/js/min/menus-scripts-min.js', array( 'jquery' ), false, true );
		wp_enqueue_style( 'alchemists-menus-styles', get_template_directory_uri() . '/admin/css/menus-styles.css' );
	}

	if ( alchemists_theme_is_menus() ) {
		add_action( 'admin_init', 'alchemists_menus_hook' );
	}
}

/**
 * Load Menu Custom Fields on frontend
 */
require_once get_template_directory() . '/admin/custom-nav-walker/custom-nav-walker.php';


/**
 * SportsPress Referral
 */
function sportspress_pro_url_theme_9( $url ) {
  return add_query_arg( 'theme', '9', $url );
}
add_filter( 'sportspress_pro_url', 'sportspress_pro_url_theme_9' );
