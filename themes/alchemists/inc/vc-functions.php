<?php
/**
 * Visual Composer Functions
 *
 * @author    Dan Fisher
 * @package   Alchemists
 * @version   1.0.0
 * @version   2.2.0
 */

/**
 * Force Visual Composer to initialize as "built into the theme". This will hide certain tabs under the Settings->Visual Composer page
 */
add_action( 'vc_before_init', 'alchemists_vcSetAsTheme' );
function alchemists_vcSetAsTheme() {
	vc_set_as_theme( $disable_updater = true );
}

// Enable Visual Composer to post, page and custom post types
if( function_exists( 'vc_set_default_editor_post_types' ) ){
	vc_set_default_editor_post_types( array(
		'page',
		'post',
		'product',
		'sp_event',
		'sp_team',
		'sp_player',
		'sp_staff',
		'sp_list',
		'sp_calendar'
	) );
}

/**
 * Override default VC widget title
 */
add_filter('wpb_widget_title', 'alchemists_override_widget_title', 10, 2);
function alchemists_override_widget_title($output = '', $params = array('')) {
	$extraclass = (isset($params['extraclass'])) ? " " . $params['extraclass'] : "";
	return '<h4 class="' . $extraclass . '">' . $params['title'] . '</h4>';
}


/**
 * Customize default VC elements
 */
add_action( 'init', 'alchemists_customize_default_elements' );
function alchemists_customize_default_elements() {

	if ( function_exists( 'vc_remove_element' ) ) {
		vc_remove_element( 'vc_tta_pageable' );
		vc_remove_element( 'vc_pinterest' );
		vc_remove_element( 'vc_googleplus' );
		vc_remove_element( 'vc_facebook' );
		vc_remove_element( 'vc_tweetmeme' );
		vc_remove_element( 'vc_tta_tour' );
		vc_remove_element( 'vc_tta_tabs' );
		vc_remove_element( 'vc_pie' );
		vc_remove_element( 'vc_round_chart' );
		vc_remove_element( 'vc_line_chart' );
		vc_remove_element( 'vc_toggle' );
		vc_remove_element( 'vc_flickr' );
		vc_remove_element( 'vc_progress_bar' );
	}
}

/**
 * Add custom SimpleLine icons
 *
 * @param $icons - taken from filter - vc_map param field settings['source']
 *     provided icons (default empty array). If array categorized it will
 *     auto-enable category dropdown
 *
 * @since 1.0
 * @return array - of icons for iconpicker, can be categorized, or not.
 */
function alc_iconpicker_type_simpleline( $icons ) {
	/**
	 * @version 2.4.0
	 */
	$simpleline = array(
		array( 'icon-user' => 'user' ),
		array( 'icon-people' => 'people' ),
		array( 'icon-user-female' => 'user-female' ),
		array( 'icon-user-follow' => 'user-follow' ),
		array( 'icon-user-following' => 'user-following' ),
		array( 'icon-user-unfollow' => 'user-unfollow' ),
		array( 'icon-login' => 'login' ),
		array( 'icon-logout' => 'logout' ),
		array( 'icon-emotsmile' => 'emotsmile' ),
		array( 'icon-phone' => 'phone' ),
		array( 'icon-call-end' => 'call-end' ),
		array( 'icon-call-in' => 'call-in' ),
		array( 'icon-call-out' => 'call-out' ),
		array( 'icon-map' => 'map' ),
		array( 'icon-location-pin' => 'location-pin' ),
		array( 'icon-direction' => 'direction' ),
		array( 'icon-directions' => 'directions' ),
		array( 'icon-compass' => 'compass' ),
		array( 'icon-layers' => 'layers' ),
		array( 'icon-menu' => 'menu' ),
		array( 'icon-list' => 'list' ),
		array( 'icon-options-vertical' => 'options-vertical' ),
		array( 'icon-options' => 'options' ),
		array( 'icon-arrow-down' => 'arrow-down' ),
		array( 'icon-arrow-left' => 'arrow-left' ),
		array( 'icon-arrow-right' => 'arrow-right' ),
		array( 'icon-arrow-up' => 'arrow-up' ),
		array( 'icon-arrow-up-circle' => 'arrow-up-circle' ),
		array( 'icon-arrow-left-circle' => 'arrow-left-circle' ),
		array( 'icon-arrow-right-circle' => 'arrow-right-circle' ),
		array( 'icon-arrow-down-circle' => 'arrow-down-circle' ),
		array( 'icon-check' => 'check' ),
		array( 'icon-clock' => 'clock' ),
		array( 'icon-plus' => 'plus' ),
		array( 'icon-minus' => 'minus' ),
		array( 'icon-close' => 'close' ),
		array( 'icon-event' => 'event' ),
		array( 'icon-exclamation' => 'exclamation' ),
		array( 'icon-organization' => 'organization' ),
		array( 'icon-trophy' => 'trophy' ),
		array( 'icon-screen-smartphone' => 'screen-smartphone' ),
		array( 'icon-screen-desktop' => 'screen-desktop' ),
		array( 'icon-plane' => 'plane' ),
		array( 'icon-notebook' => 'notebook' ),
		array( 'icon-mustache' => 'mustache' ),
		array( 'icon-mouse' => 'mouse' ),
		array( 'icon-magnet' => 'magnet' ),
		array( 'icon-energy' => 'energy' ),
		array( 'icon-disc' => 'disc' ),
		array( 'icon-cursor' => 'cursor' ),
		array( 'icon-cursor-move' => 'cursor-move' ),
		array( 'icon-crop' => 'crop' ),
		array( 'icon-chemistry' => 'chemistry' ),
		array( 'icon-speedometer' => 'speedometer' ),
		array( 'icon-shield' => 'shield' ),
		array( 'icon-screen-tablet' => 'screen-tablet' ),
		array( 'icon-magic-wand' => 'magic-wand' ),
		array( 'icon-hourglass' => 'hourglass' ),
		array( 'icon-graduation' => 'graduation' ),
		array( 'icon-ghost' => 'ghost' ),
		array( 'icon-game-controller' => 'game-controller' ),
		array( 'icon-fire' => 'fire' ),
		array( 'icon-eyeglass' => 'eyeglass' ),
		array( 'icon-envelope-open' => 'envelope-open' ),
		array( 'icon-envelope-letter' => 'envelope-letter' ),
		array( 'icon-bell' => 'bell' ),
		array( 'icon-badge' => 'badge' ),
		array( 'icon-anchor' => 'anchor' ),
		array( 'icon-wallet' => 'wallet' ),
		array( 'icon-vector' => 'vector' ),
		array( 'icon-speech' => 'speech' ),
		array( 'icon-puzzle' => 'puzzle' ),
		array( 'icon-printer' => 'printer' ),
		array( 'icon-present' => 'present' ),
		array( 'icon-playlist' => 'playlist' ),
		array( 'icon-pin' => 'pin' ),
		array( 'icon-picture' => 'picture' ),
		array( 'icon-handbag' => 'handbag' ),
		array( 'icon-globe-alt' => 'globe-alt' ),
		array( 'icon-globe' => 'globe' ),
		array( 'icon-folder-alt' => 'folder-alt' ),
		array( 'icon-folder' => 'folder' ),
		array( 'icon-film' => 'film' ),
		array( 'icon-feed' => 'feed' ),
		array( 'icon-drop' => 'drop' ),
		array( 'icon-drawer' => 'drawer' ),
		array( 'icon-docs' => 'docs' ),
		array( 'icon-doc' => 'doc' ),
		array( 'icon-diamond' => 'diamond' ),
		array( 'icon-cup' => 'cup' ),
		array( 'icon-calculator' => 'calculator' ),
		array( 'icon-bubbles' => 'bubbles' ),
		array( 'icon-briefcase' => 'briefcase' ),
		array( 'icon-book-open' => 'book-open' ),
		array( 'icon-basket-loaded' => 'basket-loaded' ),
		array( 'icon-basket' => 'basket' ),
		array( 'icon-bag' => 'bag' ),
		array( 'icon-action-undo' => 'action-undo' ),
		array( 'icon-action-redo' => 'action-redo' ),
		array( 'icon-wrench' => 'wrench' ),
		array( 'icon-umbrella' => 'umbrella' ),
		array( 'icon-trash' => 'trash' ),
		array( 'icon-tag' => 'tag' ),
		array( 'icon-support' => 'support' ),
		array( 'icon-frame' => 'frame' ),
		array( 'icon-size-fullscreen' => 'size-fullscreen' ),
		array( 'icon-size-actual' => 'size-actual' ),
		array( 'icon-shuffle' => 'shuffle' ),
		array( 'icon-share-alt' => 'share-alt' ),
		array( 'icon-share' => 'share' ),
		array( 'icon-rocket' => 'rocket' ),
		array( 'icon-question' => 'question' ),
		array( 'icon-pie-chart' => 'pie-chart' ),
		array( 'icon-pencil' => 'pencil' ),
		array( 'icon-note' => 'note' ),
		array( 'icon-loop' => 'loop' ),
		array( 'icon-home' => 'home' ),
		array( 'icon-grid' => 'grid' ),
		array( 'icon-graph' => 'graph' ),
		array( 'icon-microphone' => 'microphone' ),
		array( 'icon-music-tone-alt' => 'music-tone-alt' ),
		array( 'icon-music-tone' => 'music-tone' ),
		array( 'icon-earphones-alt' => 'earphones-alt' ),
		array( 'icon-earphones' => 'earphones' ),
		array( 'icon-equalizer' => 'equalizer' ),
		array( 'icon-like' => 'like' ),
		array( 'icon-dislike' => 'dislike' ),
		array( 'icon-control-start' => 'control-start' ),
		array( 'icon-control-rewind' => 'control-rewind' ),
		array( 'icon-control-play' => 'control-play' ),
		array( 'icon-control-pause' => 'control-pause' ),
		array( 'icon-control-forward' => 'control-forward' ),
		array( 'icon-control-end' => 'control-end' ),
		array( 'icon-volume-1' => 'volume-1' ),
		array( 'icon-volume-2' => 'volume-2' ),
		array( 'icon-volume-off' => 'volume-off' ),
		array( 'icon-calendar' => 'calendar' ),
		array( 'icon-bulb' => 'bulb' ),
		array( 'icon-chart' => 'chart' ),
		array( 'icon-ban' => 'ban' ),
		array( 'icon-bubble' => 'bubble' ),
		array( 'icon-camrecorder' => 'camrecorder' ),
		array( 'icon-camera' => 'camera' ),
		array( 'icon-cloud-download' => 'cloud-download' ),
		array( 'icon-cloud-upload' => 'cloud-upload' ),
		array( 'icon-envelope' => 'envelope' ),
		array( 'icon-eye' => 'eye' ),
		array( 'icon-flag' => 'flag' ),
		array( 'icon-heart' => 'heart' ),
		array( 'icon-info' => 'info' ),
		array( 'icon-key' => 'key' ),
		array( 'icon-link' => 'link' ),
		array( 'icon-lock' => 'lock' ),
		array( 'icon-lock-open' => 'lock-open' ),
		array( 'icon-magnifier' => 'magnifier' ),
		array( 'icon-magnifier-add' => 'magnifier-add' ),
		array( 'icon-magnifier-remove' => 'magnifier-remove' ),
		array( 'icon-paper-clip' => 'paper-clip' ),
		array( 'icon-paper-plane' => 'paper-plane' ),
		array( 'icon-power' => 'power' ),
		array( 'icon-refresh' => 'refresh' ),
		array( 'icon-reload' => 'reload' ),
		array( 'icon-settings' => 'settings' ),
		array( 'icon-star' => 'star' ),
		array( 'icon-symbol-female' => 'symbol-female' ),
		array( 'icon-symbol-male' => 'symbol-male' ),
		array( 'icon-target' => 'target' ),
		array( 'icon-credit-card' => 'credit-card' ),
		array( 'icon-paypal' => 'paypal' ),
		array( 'icon-social-tumblr' => 'social-tumblr' ),
		array( 'icon-social-twitter' => 'social-twitter' ),
		array( 'icon-social-facebook' => 'social-facebook' ),
		array( 'icon-social-instagram' => 'social-instagram' ),
		array( 'icon-social-linkedin' => 'social-linkedin' ),
		array( 'icon-social-pinterest' => 'social-pinterest' ),
		array( 'icon-social-github' => 'social-github' ),
		array( 'icon-social-google' => 'social-google' ),
		array( 'icon-social-reddit' => 'social-reddit' ),
		array( 'icon-social-skype' => 'social-skype' ),
		array( 'icon-social-dribbble' => 'social-dribbble' ),
		array( 'icon-social-behance' => 'social-behance' ),
		array( 'icon-social-foursqare' => 'social-foursqare' ),
		array( 'icon-social-soundcloud' => 'social-soundcloud' ),
		array( 'icon-social-spotify' => 'social-spotify' ),
		array( 'icon-social-stumbleupon' => 'social-stumbleupon' ),
		array( 'icon-social-youtube' => 'social-youtube' ),
		array( 'icon-social-dropbox' => 'social-dropbox' ),
		array( 'icon-social-vkontakte' => 'social-vkontakte' ),
		array( 'icon-social-stea' => 'social-stea' ),
	);

	return array_merge( $icons, $simpleline );
}
add_filter( 'vc_iconpicker-type-simpleline', 'alc_iconpicker_type_simpleline' );


if ( ! function_exists( 'alc_enqueue_simpleline_icon_style_editor' ) ) {
	function alc_enqueue_simpleline_icon_style_editor() {
		wp_enqueue_style( 'alc-simpleline', get_template_directory_uri() . '/assets/fonts/simple-line-icons/css/simple-line-icons.css', array(), '2.4.0' );
	}
}
add_action( 'vc_backend_editor_enqueue_js_css', 'alc_enqueue_simpleline_icon_style_editor' );
add_action( 'vc_frontend_editor_enqueue_js_css', 'alc_enqueue_simpleline_icon_style_editor' );



/**
 * Add new elements to Visual Composer
 */


// Custom Elements
if ( function_exists( 'vc_map' ) ) {
	add_action( 'init', 'alchemists_vc_elements' );
}

if ( ! function_exists( 'alchemists_vc_elements' ) ) {
	function alchemists_vc_elements() {

		// Posts
		$posts = get_posts(array(
			'post_type' => 'post',
			'posts_per_page' => 9999,
		));
		$posts_array = array();

		if( $posts ){
			foreach($posts as $post){
				$posts_array[$post->post_title] = $post->ID;
			}
		}


		// Post Categories
		$posts_categories = get_terms( 'category' );
		$posts_categories_array = array();

		foreach( $posts_categories as $posts_category ) {
			$posts_categories_array[] = array(
				'label' => $posts_category->name,
				'value' => $posts_category->slug
			);
		}


		// Post Tags
		$posts_tags = get_terms( 'post_tag' );
		$posts_tags_array = array();

		foreach( $posts_tags as $posts_tag ) {
			$posts_tags_array[] = array(
				'label' => $posts_tag->name,
				'value' => $posts_tag->slug
			);
		}


		// Order by
		$order_by_array = array(
			esc_html__( 'Date', 'alchemists' )          => 'date',
			esc_html__( 'ID', 'alchemists' )            => 'ID',
			esc_html__( 'Author', 'alchemists' )        => 'author',
			esc_html__( 'Title', 'alchemists' )         => 'title',
			esc_html__( 'Modified', 'alchemists' )      => 'modified',
			esc_html__( 'Comment count', 'alchemists' ) => 'comment_count',
			esc_html__( 'Menu order', 'alchemists' )    => 'menu_order',
			esc_html__( 'Random', 'alchemists' )        => 'rand',
		);

		// Order
		$order_array = array(
			esc_html__( 'Descending', 'alchemists' ) => 'DESC',
			esc_html__( 'Ascending', 'alchemists' )  => 'ASC',
		);


		// Albums categories
		$album_categories = get_terms( 'catalbums' );
		$album_categories_array = array();

		if(!empty($album_categories) and !is_wp_error($album_categories)) {
			foreach ( $album_categories as $album_category ) {
				$album_categories_array[] = array(
					'label' => $album_category->name,
					'value' => $album_category->slug
				);
			}
		}



		// ALC: Images Carousel
		vc_map( array(
			'name'        => esc_html__( 'ALC: Awards Carousel', 'alchemists' ),
			'base'        => 'alc_images_carousel',
			'icon'        => get_template_directory_uri() . '/admin/images/js_composer/alc_images_carousel.png',
			'category'    => esc_html__( 'ALC', 'alchemists' ),
			'description' => esc_html__( 'Animated carousel with images.', 'alchemists' ),
			'params'      => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Widget title', 'alchemists' ),
					'param_name'  => 'title',
					'description' => esc_html__( 'Enter text used as widget title (Note: located above content element).', 'alchemists' ),
					'admin_label' => true,
				),
				array(
					'type'        => 'attach_images',
					'heading'     => esc_html__( 'Images', 'alchemists' ),
					'param_name'  => 'images',
					'value'       => '',
					'description' => esc_html__( 'Select images from media library.', 'alchemists' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Carousel size', 'alchemists' ),
					'param_name'  => 'img_size',
					'value'       => 'full',
					'description' => esc_html__( 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size. If used slides per view, this will be used to define carousel wrapper size.', 'alchemists' ),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'On click action', 'alchemists' ),
					'param_name'  => 'onclick',
					'value'       => array(
						esc_html__( 'None', 'alchemists' ) => 'link_no',
						esc_html__( 'Open custom links', 'alchemists' ) => 'custom_link',
					),
					'description' => esc_html__( 'Select action for click event.', 'alchemists' ),
				),
				array(
					'type'        => 'exploded_textarea_safe',
					'heading'     => esc_html__( 'Custom links', 'alchemists' ),
					'param_name'  => 'custom_links',
					'description' => esc_html__( 'Enter links for each slide (Note: divide links with linebreaks (Enter)).', 'alchemists' ),
					'dependency' => array(
						'element' => 'onclick',
						'value'   => array( 'custom_link' ),
					),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Custom link target', 'alchemists' ),
					'param_name'  => 'custom_links_target',
					'description' => esc_html__( 'Select how to open custom links.', 'alchemists' ),
					'dependency'  => array(
						'element' => 'onclick',
						'value'   => array( 'custom_link' ),
					),
					'value'       => vc_target_param_list(),
				),
				vc_map_add_css_animation(),
				array(
					'type'        => 'el_id',
					'heading'     => esc_html__( 'Element ID', 'alchemists' ),
					'param_name'  => 'el_id',
					'description' => esc_html__( 'Enter element ID (Note: make sure it is unique and valid.', 'alchemists' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Extra class name', 'alchemists' ),
					'param_name'  => 'el_class',
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'alchemists' ),
				),
				array(
					'type'        => 'css_editor',
					'heading'     => esc_html__( 'CSS box', 'alchemists' ),
					'param_name'  => 'css',
					'group'       => esc_html__( 'Design Options', 'alchemists' ),
				),
			)
		) );



		// ALC: Newslog
		vc_map( array(
			'name'        => esc_html__( 'ALC: Newslog Static', 'alchemists' ),
			'base'        => 'alc_newslog',
			'icon'        => get_template_directory_uri() . '/admin/images/js_composer/alc_newslog.png',
			'category'    => esc_html__( 'ALC', 'alchemists' ),
			'js_view'     => 'VcColumnView',
			'as_parent'   => array(
				'only' => 'alc_newslog_item'
			),
			'description' => esc_html__( 'A list of items.', 'alchemists' ),
			'params'      => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Widget title', 'alchemists' ),
					'param_name'  => 'title',
					'description' => esc_html__( 'Enter text used as widget title (Note: located above content element).', 'alchemists' ),
					'admin_label' => true,
				),
				vc_map_add_css_animation(),
				array(
					'type'        => 'el_id',
					'heading'     => esc_html__( 'Element ID', 'alchemists' ),
					'param_name'  => 'el_id',
					'description' => esc_html__( 'Enter element ID (Note: make sure it is unique and valid.', 'alchemists' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Extra class name', 'alchemists' ),
					'param_name'  => 'el_class',
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'alchemists' ),
				),
				array(
					'type'        => 'css_editor',
					'heading'     => esc_html__( 'CSS box', 'alchemists' ),
					'param_name'  => 'css',
					'group'       => esc_html__( 'Design Options', 'alchemists' ),
				),
			)
		) );


		// ALC: Newslog Item
		vc_map( array(
			'name'        => esc_html__( 'ALC: Newslog Item', 'alchemists' ),
			'base'        => 'alc_newslog_item',
			'icon'        => get_template_directory_uri() . '/admin/images/js_composer/alc_newslog.png',
			'category'    => esc_html__( 'ALC', 'alchemists' ),
			'as_child'    => array(
				'only' => 'alc_newslog'
			),
			'description' => esc_html__( 'An item for log list.', 'alchemists' ),
			'params'      => array(
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Type', 'alchemists' ),
					'param_name'  => 'item_type',
					'description' => esc_html__( 'Select type of item', 'alchemists' ),
					'value'       => array(
						esc_html__( 'Injury', 'alchemists' ) => 'injury',
						esc_html__( 'Join', 'alchemists' ) => 'join',
						esc_html__( 'Exit', 'alchemists' ) => 'exit',
						esc_html__( 'Award', 'alchemists' ) => 'award',
					),
				),
				array(
					'type'        => 'textarea_html',
					'heading'     => esc_html__( 'Content', 'alchemists' ),
					'param_name'  => 'content',
					'value'       => esc_html__( 'Your description goes here', 'alchemists' ),
					'description' => esc_html__( 'Enter a short text about event.', 'alchemists' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Date', 'alchemists' ),
					'param_name'  => 'date',
					'description' => esc_html__( 'Enter a date in any format.', 'alchemists' ),
					'admin_label' => true,
				),
			)
		) );


		// ALC: Social Buttons
		vc_map( array(
			'name'        => esc_html__( 'ALC: Social Buttons', 'alchemists' ),
			'base'        => 'alc_social_buttons',
			'icon'        => get_template_directory_uri() . '/admin/images/js_composer/alc_social_buttons.png',
			'category'    => esc_html__( 'ALC', 'alchemists' ),
			'description' => esc_html__( 'A block with social buttons.', 'alchemists' ),
			'params'      => array(
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Layout Style', 'alchemists' ),
					'param_name'  => 'layout_style',
					'value'       => array(
						esc_html__( 'Default', 'alchemists' ) => 'default',
						esc_html__( 'Grid', 'alchemists' ) => 'grid',
						esc_html__( 'Columns', 'alchemists' ) => 'columns',
					),
					'description' => esc_html__( 'Select style for social buttons.', 'alchemists' ),
					'admin_label' => true,
				),
				array(
					'type'        => 'param_group',
					'heading'     => esc_html__( 'Buttons', 'alchemists' ),
					'param_name'  => 'values',
					'value' => urlencode( json_encode( array(
						array(
							'label' => esc_html__( 'Select Statistic', 'alchemists' ),
							'value' => '',
						),
						array(
							'label' => esc_html__( 'Select Statistic', 'alchemists' ),
							'value' => '',
						),
					) ) ),
					'params' => array(
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Title', 'alchemists' ),
							'param_name'  => 'btn_label',
							'holder'      => 'div',
							'value'       => esc_html__( 'Title goes here', 'alchemists' ),
							'description' => esc_html__( 'Enter short title.', 'alchemists'),
							'admin_label' => true,
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Subtitle', 'alchemists' ),
							'param_name'  => 'btn_label_2',
							'holder'      => 'div',
							'value'       => esc_html__( 'Follow Me', 'alchemists' ),
							'description' => esc_html__( 'Enter short subtitle.', 'alchemists'),
							'admin_label' => true,
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'URL', 'alchemists'),
							'param_name'  => 'btn_link',
							'holder'      => 'div',
							'description' => esc_html__( 'Enter URL to your social account.', 'alchemists' ),
						),
						array(
							'type'        => 'dropdown',
							'heading'     => esc_html__( 'Social Network', 'alchemists'),
							'param_name'  => 'btn_type',
							'value'       => array(
								esc_html__( 'Facebook', 'alchemists' ) => 'fb',
								esc_html__( 'Twitter', 'alchemists' ) => 'twitter',
								esc_html__( 'Google+', 'alchemists' ) => 'gplus',
								esc_html__( 'Instagram', 'alchemists' ) => 'instagram',
							),
							'holder'      => 'div',
							'description' => esc_html__( 'Select social network', 'alchemists' ),
						),
					),
				),
				vc_map_add_css_animation(),
				array(
					'type'        => 'el_id',
					'heading'     => esc_html__( 'Element ID', 'alchemists' ),
					'param_name'  => 'el_id',
					'description' => esc_html__( 'Enter element ID (Note: make sure it is unique and valid.', 'alchemists' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Extra class name', 'alchemists' ),
					'param_name'  => 'el_class',
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'alchemists' ),
				),
				array(
					'type'        => 'css_editor',
					'heading'     => esc_html__( 'CSS box', 'alchemists' ),
					'param_name'  => 'css',
					'group'       => esc_html__( 'Design Options', 'alchemists' ),
				),
			)
		) );



		// ALC: Post Loop
		vc_map( array(
			'name'        => esc_html__( 'ALC: Post Loop', 'alchemists' ),
			'base'        => 'alc_post_loop',
			'icon'        => get_template_directory_uri() . '/admin/images/js_composer/alc_post_loop.png',
			'category'    => esc_html__( 'ALC', 'alchemists' ),
			'description' => esc_html__( 'Posts in grid, list etc.', 'alchemists' ),
			'params'      => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Widget title', 'alchemists' ),
					'param_name'  => 'title',
					'description' => esc_html__( 'Enter text used as widget title (Note: located above content element).', 'alchemists' ),
					'admin_label' => true,
				),
				array(
					'type'        => 'vc_link',
					'heading'     => esc_html__( 'Button URL (Link)', 'alchemists' ),
					'param_name'  => 'link',
					'description' => esc_html__( 'Add button to header.', 'alchemists' ),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Layout', 'alchemists'),
					'param_name'  => 'posts_layout',
					'value'       => array(
						esc_html__( 'Cards 2 cols', 'alchemists' ) => 'grid_2cols',
						esc_html__( 'List - Card', 'alchemists' ) => 'grid_1col',
						esc_html__( 'List - Left Thumb', 'alchemists' ) => 'list_left_thumb',
						esc_html__( 'List - Center Thumb', 'alchemists' ) => 'list_lg_thumb',
						esc_html__( 'List - Simple', 'alchemists' ) => 'list_simple',
						esc_html__( 'List - Simple (1st Post Extented)', 'alchemists' ) => 'list_simple_1st_ext',
						esc_html__( 'List - Simple Horizontal', 'alchemists' ) => 'list_simple_hor',
						esc_html__( 'List - Small Thumb', 'alchemists' ) => 'list_thumb_sm',
						esc_html__( 'Cards - Masonry', 'alchemists' ) => 'masonry',
					),
					'description' => esc_html__( 'Select Post Layout', 'alchemists' ),
				),
				array(
					'type' => 'autocomplete',
					'heading' => esc_html__( 'Categories', 'alchemists' ),
					'param_name' => 'taxonomies_categories',
					'settings' => array(
						'multiple' => true,
						'min_length' => 1,
						'groups' => true,
						// In UI show results grouped by groups, default false
						'unique_values' => true,
						// In UI show results except selected. NB! You should manually check values in backend, default false
						'display_inline' => true,
						// In UI show results inline view, default false (each value in own line)
						'delay' => 500,
						// delay for search. default 500
						'auto_focus' => true,
						// auto focus input, default true
						'sortable' => true,
						'no_hide' => true,
						'values' => $posts_categories_array
					),
					'param_holder_class' => 'vc_not-for-custom',
					'description' => esc_html__( 'Filter posts by categories.', 'alchemists' ),
				),
				array(
					'type' => 'autocomplete',
					'heading' => esc_html__( 'Tags', 'alchemists' ),
					'param_name' => 'taxonomies_tags',
					'settings' => array(
						'multiple' => true,
						'min_length' => 1,
						'groups' => true,
						// In UI show results grouped by groups, default false
						'unique_values' => true,
						// In UI show results except selected. NB! You should manually check values in backend, default false
						'display_inline' => true,
						// In UI show results inline view, default false (each value in own line)
						'delay' => 500,
						// delay for search. default 500
						'auto_focus' => true,
						// auto focus input, default true
						'sortable' => true,
						'no_hide' => true,
						'values' => $posts_tags_array
					),
					'param_holder_class' => 'vc_not-for-custom',
					'description' => esc_html__( 'Filter posts by tags.', 'alchemists' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Items per page', 'alchemists' ),
					'param_name' => 'items_per_page',
					'description' => esc_html__( 'Number of items to show per page.', 'alchemists' ),
					'value' => '10',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Offset', 'alchemists' ),
					'param_name' => 'offset',
					'description' => esc_html__( 'Number of post to displace or pass over.', 'alchemists' ),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Order', 'alchemists'),
					'param_name'  => 'order',
					'value'       => $order_array,
					'description' => esc_html__( 'Sort retrieved posts.', 'alchemists' ),
					'edit_field_class' => 'vc_col-sm-6',
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Order By', 'alchemists'),
					'param_name'  => 'order_by',
					'value'       => $order_by_array,
					'description' => esc_html__( 'Sort retrieved posts.', 'alchemists' ),
					'edit_field_class' => 'vc_col-sm-6',
				),
				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__( 'Disable Excerpt?', 'alchemists' ),
					'param_name'  => 'disable_excerpt',
					'value'       => array(
						esc_html__( 'Yes', 'alchemists' ) => '1'
					),
					'description' => esc_html__( 'If checked Excerpt will be hidden.', 'alchemists' ),
				),
				vc_map_add_css_animation(),
				array(
					'type'        => 'el_id',
					'heading'     => esc_html__( 'Element ID', 'alchemists' ),
					'param_name'  => 'el_id',
					'description' => esc_html__( 'Enter element ID (Note: make sure it is unique and valid.', 'alchemists' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Extra class name', 'alchemists' ),
					'param_name'  => 'el_class',
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'alchemists' ),
				),
				array(
					'type'        => 'css_editor',
					'heading'     => esc_html__( 'CSS box', 'alchemists' ),
					'param_name'  => 'css',
					'group'       => esc_html__( 'Design Options', 'alchemists' ),
				),
			)
		) );



		// ALC: Post Slider
		vc_map( array(
			'name'        => esc_html__( 'ALC: Post Slider', 'alchemists' ),
			'base'        => 'alc_post_slider',
			'icon'        => get_template_directory_uri() . '/admin/images/js_composer/alc_post_slider.png',
			'category'    => esc_html__( 'ALC', 'alchemists' ),
			'description' => esc_html__( 'Animated filtered posts slider.', 'alchemists' ),
			'params'      => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Widget title', 'alchemists' ),
					'param_name'  => 'title',
					'description' => esc_html__( 'Enter text used as widget title (Note: located above content element).', 'alchemists' ),
					'admin_label' => true,
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Slides to show', 'alchemists'),
					'param_name'  => 'slide_to_show',
					'value'       => array(
						esc_html__( '1 Slide', 'alchemists' ) => 'slide_1',
						esc_html__( '4 Slides', 'alchemists' ) => 'slide_4',
					),
					'description' => esc_html__( 'Select Post Layout', 'alchemists' ),
				),
				array(
					'type' => 'autocomplete',
					'heading' => esc_html__( 'Categories', 'alchemists' ),
					'param_name' => 'taxonomies_categories',
					'settings' => array(
						'multiple' => true,
						'min_length' => 1,
						'groups' => true,
						// In UI show results grouped by groups, default false
						'unique_values' => true,
						// In UI show results except selected. NB! You should manually check values in backend, default false
						'display_inline' => true,
						// In UI show results inline view, default false (each value in own line)
						'delay' => 500,
						// delay for search. default 500
						'auto_focus' => true,
						// auto focus input, default true
						'sortable' => true,
						'no_hide' => true,
						'values' => $posts_categories_array
					),
					'param_holder_class' => 'vc_not-for-custom',
					'description' => esc_html__( 'Filter posts by categories.', 'alchemists' ),
					'dependency' => array(
						'element' => 'display_filter',
						'value'   => array( '1' ),
					),
				),
				array(
					'heading'       => esc_html__( 'Add Categories Filter?', 'alchemists' ),
					'type'          => 'checkbox',
					'param_name'    => 'display_filter',
					'value'         => array(
						esc_html__( 'Yes', 'alchemists' ) => '1'
					),
					'description' => esc_html__( 'This filter will be shown if categories selected.', 'alchemists' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Items per page', 'alchemists' ),
					'param_name' => 'items_per_page',
					'description' => esc_html__( 'Number of items to show per page.', 'alchemists' ),
					'value' => '10',
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Offset', 'alchemists' ),
					'param_name' => 'offset',
					'description' => esc_html__( 'Number of post to displace or pass over.', 'alchemists' ),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Order', 'alchemists'),
					'param_name'  => 'order',
					'value'       => $order_array,
					'description' => esc_html__( 'Sort retrieved posts.', 'alchemists' ),
					'edit_field_class' => 'vc_col-sm-6',
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Order By', 'alchemists'),
					'param_name'  => 'order_by',
					'value'       => $order_by_array,
					'description' => esc_html__( 'Sort retrieved posts.', 'alchemists' ),
					'edit_field_class' => 'vc_col-sm-6',
				),
				array(
					'type'          => 'checkbox',
					'heading'       => esc_html__( 'Autoplay?', 'alchemists' ),
					'group'         => esc_html__( 'Options', 'alchemists' ),
					'param_name'    => 'autoplay',
					'value'         => array(
						esc_html__( 'Yes', 'alchemists' ) => '1'
					),
					'description' => esc_html__( 'Automatically starts animating.', 'alchemists' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Autoplay Speed', 'alchemists' ),
					'group'       => esc_html__( 'Options', 'alchemists' ),
					'param_name'  => 'autoplay_speed',
					'description' => esc_html__( 'Autoplay Speed.', 'alchemists' ),
					'value'       => '5000',
					'dependency' => array(
						'element' => 'autoplay',
						'value'   => array( '1' ),
					),
				),
				array(
					'type'          => 'checkbox',
					'heading'       => esc_html__( 'Prev/Nav Arrows?', 'alchemists' ),
					'group'         => esc_html__( 'Options', 'alchemists' ),
					'param_name'    => 'arrows',
					'value'         => array(
						esc_html__( 'Yes', 'alchemists' ) => '1'
					),
					'description' => esc_html__( 'Show next/prev buttons.', 'alchemists' ),
				),
				vc_map_add_css_animation(),
				array(
					'type'        => 'el_id',
					'heading'     => esc_html__( 'Element ID', 'alchemists' ),
					'param_name'  => 'el_id',
					'description' => esc_html__( 'Enter element ID (Note: make sure it is unique and valid.', 'alchemists' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Extra class name', 'alchemists' ),
					'param_name'  => 'el_class',
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'alchemists' ),
				),
				array(
					'type'        => 'css_editor',
					'heading'     => esc_html__( 'CSS box', 'alchemists' ),
					'param_name'  => 'css',
					'group'       => esc_html__( 'Design Options', 'alchemists' ),
				),
			)
		) );



		// ALC: Post Carousel
		vc_map( array(
			'name'        => esc_html__( 'ALC: Post Carousel', 'alchemists' ),
			'base'        => 'alc_post_carousel',
			'icon'        => get_template_directory_uri() . '/admin/images/js_composer/alc_post_carousel.png',
			'category'    => esc_html__( 'ALC', 'alchemists' ),
			'description' => esc_html__( 'Animated filtered posts carousel.', 'alchemists' ),
			'params'      => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Items per page', 'alchemists' ),
					'param_name'  => 'items_per_page',
					'description' => esc_html__( 'Number of items to show per page.', 'alchemists' ),
					'value'       => '10',
				),
				array(
					'type' => 'autocomplete',
					'heading' => esc_html__( 'Categories', 'alchemists' ),
					'param_name' => 'taxonomies_categories',
					'settings' => array(
						'multiple' => true,
						'min_length' => 1,
						'groups' => true,
						// In UI show results grouped by groups, default false
						'unique_values' => true,
						// In UI show results except selected. NB! You should manually check values in backend, default false
						'display_inline' => true,
						// In UI show results inline view, default false (each value in own line)
						'delay' => 500,
						// delay for search. default 500
						'auto_focus' => true,
						// auto focus input, default true
						'sortable' => true,
						'no_hide' => true,
						'values' => $posts_categories_array
					),
					'param_holder_class' => 'vc_not-for-custom',
					'description' => esc_html__( 'Filter posts by categories.', 'alchemists' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Offset', 'alchemists' ),
					'param_name' => 'offset',
					'description' => esc_html__( 'Number of post to displace or pass over.', 'alchemists' ),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Order', 'alchemists'),
					'param_name'  => 'order',
					'value'       => $order_array,
					'description' => esc_html__( 'Sort retrieved posts.', 'alchemists' ),
					'edit_field_class' => 'vc_col-sm-6',
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Order By', 'alchemists'),
					'param_name'  => 'order_by',
					'value'       => $order_by_array,
					'description' => esc_html__( 'Sort retrieved posts.', 'alchemists' ),
					'edit_field_class' => 'vc_col-sm-6',
				),
				array(
					'type'          => 'checkbox',
					'heading'       => esc_html__( 'Autoplay?', 'alchemists' ),
					'group'         => esc_html__( 'Options', 'alchemists' ),
					'param_name'    => 'autoplay',
					'value'         => array(
						esc_html__( 'Yes', 'alchemists' ) => '1'
					),
					'description' => esc_html__( 'Automatically starts animating.', 'alchemists' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Autoplay Speed', 'alchemists' ),
					'group'       => esc_html__( 'Options', 'alchemists' ),
					'param_name'  => 'autoplay_speed',
					'description' => esc_html__( 'Autoplay Speed.', 'alchemists' ),
					'value'       => '7000',
					'dependency' => array(
						'element' => 'autoplay',
						'value'   => array( '1' ),
					),
				),
				array(
					'type'          => 'checkbox',
					'heading'       => esc_html__( 'Prev/Nav Arrows?', 'alchemists' ),
					'group'         => esc_html__( 'Options', 'alchemists' ),
					'param_name'    => 'arrows',
					'value'         => array(
						esc_html__( 'Yes', 'alchemists' ) => '1'
					),
					'description' => esc_html__( 'Show next/prev buttons.', 'alchemists' ),
				),
				vc_map_add_css_animation(),
				array(
					'type'        => 'el_id',
					'heading'     => esc_html__( 'Element ID', 'alchemists' ),
					'param_name'  => 'el_id',
					'description' => esc_html__( 'Enter element ID (Note: make sure it is unique and valid.', 'alchemists' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Extra class name', 'alchemists' ),
					'param_name'  => 'el_class',
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'alchemists' ),
				),
				array(
					'type'        => 'css_editor',
					'heading'     => esc_html__( 'CSS box', 'alchemists' ),
					'param_name'  => 'css',
					'group'       => esc_html__( 'Design Options', 'alchemists' ),
				),
			)
		) );



		// ALC: Featured Post
		vc_map( array(
			'name'        => esc_html__( 'ALC: Featured Post', 'alchemists' ),
			'base'        => 'alc_featured_post',
			'icon'        => get_template_directory_uri() . '/admin/images/js_composer/alc_featured_post.png',
			'category'    => esc_html__( 'ALC', 'alchemists' ),
			'description' => esc_html__( 'A single post as a banner.', 'alchemists' ),
			'params'      => array(
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Style', 'alchemists'),
					'param_name'  => 'post_style',
					'value'       => array(
						esc_html__( 'Style 1', 'alchemists' ) => 'style_1',
						esc_html__( 'Style 2', 'alchemists' ) => 'style_2',
					),
					'description' => esc_html__( 'Select Post Style.', 'alchemists' ),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Post', 'alchemists' ),
					'param_name'  => 'post_id',
					'value'       => $posts_array,
					'description' => esc_html__( 'Select a post to display.', 'alchemists' ),
					'admin_label' => true,
				),
				array(
					'type'        => 'attach_image',
					'heading'     => esc_html__( 'Image', 'alchemists' ),
					'param_name'  => 'image',
					'value'       => '',
					'description' => esc_html__( 'Select image from media library.', 'alchemists' ),
					'dependency' => array(
						'element' => 'post_style',
						'value'   => array( 'style_1' ),
					),
				),
				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__( 'Disable Categories?', 'alchemists' ),
					'group'       => esc_html__( 'Customize', 'alchemists' ),
					'param_name'  => 'disable_cats',
					'value'       => array(
						esc_html__( 'Yes', 'alchemists' ) => '1'
					),
					'description' => esc_html__( 'If checked categories label(s) will be hidden.', 'alchemists' ),
				),
				array(
					'type'        => 'textarea_html',
					'heading'     => esc_html__( 'Custom Title', 'alchemists' ),
					'group'       => esc_html__( 'Customize', 'alchemists' ),
					'param_name'  => 'content',
					'description' => esc_html__( 'Enter your custom title here.', 'alchemists' ),
					'value'       => '',
				),
				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__( 'Disable Excerpt?', 'alchemists' ),
					'group'       => esc_html__( 'Customize', 'alchemists' ),
					'param_name'  => 'disable_excerpt',
					'value'       => array(
						esc_html__( 'Yes', 'alchemists' ) => '1'
					),
					'description' => esc_html__( 'If checked Excerpt will be hidden.', 'alchemists' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Excerpt Size (in words)', 'alchemists' ),
					'group'       => esc_html__( 'Customize', 'alchemists' ),
					'param_name'  => 'excerpt_size',
					'description' => esc_html__( 'Enter the number of words for Excerpt.', 'alchemists' ),
					'value'       => '13',
					'dependency' => array(
						'element' => 'disable_excerpt',
						'value_not_equal_to' => array( '1' ),
					),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Custom Excerpt', 'alchemists' ),
					'group'       => esc_html__( 'Customize', 'alchemists' ),
					'param_name'  => 'custom_excerpt',
					'description' => esc_html__( 'Enter your custom excerpt here.', 'alchemists' ),
					'value'       => '',
					'dependency' => array(
						'element' => 'disable_excerpt',
						'value_not_equal_to' => array( '1' ),
					),
				),
				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__( 'Disable Button?', 'alchemists' ),
					'group'       => esc_html__( 'Customize', 'alchemists' ),
					'param_name'  => 'disable_btn',
					'value'       => array(
						esc_html__( 'Yes', 'alchemists' ) => '1'
					),
					'description' => esc_html__( 'If checked button will be hidden.', 'alchemists' ),
				),
				array(
					'type'        => 'vc_link',
					'heading'     => esc_html__( 'Custom Button', 'alchemists' ),
					'group'       => esc_html__( 'Customize', 'alchemists' ),
					'param_name'  => 'btn',
					'description' => esc_html__( 'Custom button link and label.', 'alchemists' ),
					'dependency'  => array(
						'element' => 'disable_btn',
						'value_not_equal_to' => array( '1' ),
					),
				),
				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__( 'Disable Date?', 'alchemists' ),
					'group'       => esc_html__( 'Customize', 'alchemists' ),
					'param_name'  => 'disable_date',
					'value'       => array(
						esc_html__( 'Yes', 'alchemists' ) => '1'
					),
					'description' => esc_html__( 'If checked date will be hidden.', 'alchemists' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Custom Date/Subtitle', 'alchemists' ),
					'group'       => esc_html__( 'Customize', 'alchemists' ),
					'param_name'  => 'custom_date',
					'description' => esc_html__( 'Enter your custom date/subtitle here.', 'alchemists' ),
					'value'       => '',
					'dependency' => array(
						'element' => 'disable_date',
						'value_not_equal_to' => array( '1' ),
					),
				),
				vc_map_add_css_animation(),
				array(
					'type'        => 'el_id',
					'heading'     => esc_html__( 'Element ID', 'alchemists' ),
					'param_name'  => 'el_id',
					'description' => esc_html__( 'Enter element ID (Note: make sure it is unique and valid.', 'alchemists' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Extra class name', 'alchemists' ),
					'param_name'  => 'el_class',
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'alchemists' ),
				),
				array(
					'type'        => 'css_editor',
					'heading'     => esc_html__( 'CSS box', 'alchemists' ),
					'param_name'  => 'css',
					'group'       => esc_html__( 'Design Options', 'alchemists' ),
				),
			)
		) );


		// ALC: Button
		vc_map( array(
			'name'        => esc_html__( 'ALC: Button', 'alchemists' ),
			'base'        => 'alc_btn',
			'icon'        => get_template_directory_uri() . '/admin/images/js_composer/alc_btn.png',
			'category'    => esc_html__( 'ALC', 'alchemists' ),
			'description' => esc_html__( 'Simple button.', 'alchemists' ),
			'params'      => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Text', 'alchemists' ),
					'param_name'  => 'title',
					'value'       => esc_html__( 'Text on the button', 'alchemists' ),
					'admin_label' => true,
				),
				array(
					'type'        => 'vc_link',
					'heading'     => esc_html__( 'URL (Link)', 'alchemists' ),
					'param_name'  => 'link',
					'description' => esc_html__( 'Add link to button.', 'alchemists' ),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Type', 'alchemists' ),
					'param_name'  => 'type',
					'value'       => array(
						esc_html__( 'Fill', 'alchemists' )    => 'fill',
						esc_html__( 'Outline', 'alchemists' ) => 'outline',
					),
					'description' => esc_html__( 'Select button type.', 'alchemists' ),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Color', 'alchemists' ),
					'param_name'  => 'color',
					'value'       => array(
						esc_html__( 'Default', 'alchemists' )         => 'default',
						esc_html__( 'Primary', 'alchemists' )         => 'primary',
						esc_html__( 'Primary Inverse', 'alchemists' ) => 'primary-inverse',
						esc_html__( 'Success', 'alchemists' )         => 'success',
						esc_html__( 'Info', 'alchemists' )            => 'info',
						esc_html__( 'Warning', 'alchemists' )         => 'warning',
						esc_html__( 'Danger', 'alchemists' )          => 'danger',
					),
					'description' => esc_html__( 'Select button color style.', 'alchemists' ),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Size', 'alchemists' ),
					'param_name'  => 'size',
					'value'       => array(
						esc_html__( 'Large', 'alchemists' )       => 'lg',
						esc_html__( 'Medium', 'alchemists' )      => 'medium',
						esc_html__( 'Small', 'alchemists' )       => 'sm',
						esc_html__( 'Extra Small', 'alchemists' ) => 'xs',
					),
					'description' => esc_html__( 'Select button size.', 'alchemists' ),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Alignment', 'alchemists' ),
					'param_name'  => 'align',
					'description' => esc_html__( 'Select button alignment.', 'alchemists' ),
					'value'       => array(
						esc_html__( 'Inline', 'alchemists' ) => 'inline',
						// default as well
						esc_html__( 'Left', 'alchemists' )   => 'left',
						// default as well
						esc_html__( 'Right', 'alchemists' )  => 'right',
						esc_html__( 'Center', 'alchemists' ) => 'center',
					),
				),
				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__( 'Set full width button?', 'alchemists' ),
					'param_name'  => 'btn_block',
					'dependency' => array(
						'element'            => 'align',
						'value_not_equal_to' => 'inline',
					),
				),
				vc_map_add_css_animation(),
				array(
					'type'        => 'el_id',
					'heading'     => esc_html__( 'Element ID', 'alchemists' ),
					'param_name'  => 'el_id',
					'description' => esc_html__( 'Enter element ID (Note: make sure it is unique and valid.', 'alchemists' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Extra class name', 'alchemists' ),
					'param_name'  => 'el_class',
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'alchemists' ),
				),
			)
		) );



		// ALC: Icobox
		vc_map( array(
			'name'        => esc_html__( 'ALC: Icobox', 'alchemists' ),
			'base'        => 'alc_icobox',
			'icon'        => get_template_directory_uri() . '/admin/images/js_composer/alc_icobox.png',
			'category'    => esc_html__( 'ALC', 'alchemists' ),
			'description' => esc_html__( 'Block with icon and text.', 'alchemists' ),
			'params'      => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Title', 'alchemists' ),
					'param_name'  => 'title',
					'value'       => esc_html__( 'Title of the box', 'alchemists' ),
					'admin_label' => true,
				),
				array(
					'type'        => 'textarea',
					'heading'     => esc_html__( 'Description', 'alchemists' ),
					'param_name'  => 'description',
					'value'       => esc_html__( 'Your description goes here', 'alchemists' ),
					'description' => esc_html__( 'Enter a short text here.', 'alchemists' ),
				),
				array(
					'type'        => 'vc_link',
					'heading'     => esc_html__( 'URL (Link)', 'alchemists' ),
					'param_name'  => 'link',
					'description' => esc_html__( 'Add link to the box.', 'alchemists' ),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Alignment', 'alchemists' ),
					'param_name'  => 'align',
					'description' => esc_html__( 'Select box alignment.', 'alchemists' ),
					'value'       => array(
						esc_html__( 'Center', 'alchemists' ) => 'center',
						esc_html__( 'Left', 'alchemists' )   => 'left',
						esc_html__( 'Right', 'alchemists' )  => 'right',
					),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Icon library', 'alchemists' ),
					'value' => array(
						esc_html__( 'Font Awesome', 'alchemists' ) => 'fontawesome',
						esc_html__( 'Open Iconic', 'alchemists' ) => 'openiconic',
						esc_html__( 'Typicons', 'alchemists' ) => 'typicons',
						esc_html__( 'Entypo', 'alchemists' ) => 'entypo',
						esc_html__( 'Linecons', 'alchemists' ) => 'linecons',
						esc_html__( 'Mono Social', 'alchemists' ) => 'monosocial',
						esc_html__( 'Material', 'alchemists' ) => 'material',
						esc_html__( 'SimpleLine', 'alchemists' ) => 'simpleline',
					),
					'admin_label' => true,
					'param_name' => 'i_type',
					'description' => esc_html__( 'Select icon library.', 'alchemists' ),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'alchemists' ),
					'param_name' => 'i_icon_fontawesome',
					'value' => 'fa fa-adjust',
					// default value to backend editor admin_label
					'settings' => array(
						'emptyIcon' => false,
						// default true, display an "EMPTY" icon?
						'iconsPerPage' => 4000,
						// default 100, how many icons per/page to display, we use (big number) to display all icons in single page
					),
					'dependency' => array(
						'element' => 'i_type',
						'value' => 'fontawesome',
					),
					'description' => esc_html__( 'Select icon from library.', 'alchemists' ),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'alchemists' ),
					'param_name' => 'i_icon_openiconic',
					'value' => 'vc-oi vc-oi-dial',
					// default value to backend editor admin_label
					'settings' => array(
						'emptyIcon' => false,
						// default true, display an "EMPTY" icon?
						'type' => 'openiconic',
						'iconsPerPage' => 4000,
						// default 100, how many icons per/page to display
					),
					'dependency' => array(
						'element' => 'i_type',
						'value' => 'openiconic',
					),
					'description' => esc_html__( 'Select icon from library.', 'alchemists' ),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'alchemists' ),
					'param_name' => 'i_icon_typicons',
					'value' => 'typcn typcn-adjust-brightness',
					// default value to backend editor admin_label
					'settings' => array(
						'emptyIcon' => false,
						// default true, display an "EMPTY" icon?
						'type' => 'typicons',
						'iconsPerPage' => 4000,
						// default 100, how many icons per/page to display
					),
					'dependency' => array(
						'element' => 'i_type',
						'value' => 'typicons',
					),
					'description' => esc_html__( 'Select icon from library.', 'alchemists' ),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'alchemists' ),
					'param_name' => 'i_icon_entypo',
					'value' => 'entypo-icon entypo-icon-note',
					// default value to backend editor admin_label
					'settings' => array(
						'emptyIcon' => false,
						// default true, display an "EMPTY" icon?
						'type' => 'entypo',
						'iconsPerPage' => 4000,
						// default 100, how many icons per/page to display
					),
					'dependency' => array(
						'element' => 'i_type',
						'value' => 'entypo',
					),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'alchemists' ),
					'param_name' => 'i_icon_linecons',
					'value' => 'vc_li vc_li-heart',
					// default value to backend editor admin_label
					'settings' => array(
						'emptyIcon' => false,
						// default true, display an "EMPTY" icon?
						'type' => 'linecons',
						'iconsPerPage' => 4000,
						// default 100, how many icons per/page to display
					),
					'dependency' => array(
						'element' => 'i_type',
						'value' => 'linecons',
					),
					'description' => esc_html__( 'Select icon from library.', 'alchemists' ),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'alchemists' ),
					'param_name' => 'i_icon_monosocial',
					'value' => 'vc-mono vc-mono-fivehundredpx',
					// default value to backend editor admin_label
					'settings' => array(
						'emptyIcon' => false,
						// default true, display an "EMPTY" icon?
						'type' => 'monosocial',
						'iconsPerPage' => 4000,
						// default 100, how many icons per/page to display
					),
					'dependency' => array(
						'element' => 'i_type',
						'value' => 'monosocial',
					),
					'description' => esc_html__( 'Select icon from library.', 'alchemists' ),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'alchemists' ),
					'param_name' => 'i_icon_material',
					'value' => 'vc-material vc-material-cake',
					// default value to backend editor admin_label
					'settings' => array(
						'emptyIcon' => false,
						// default true, display an "EMPTY" icon?
						'type' => 'material',
						'iconsPerPage' => 4000,
						// default 100, how many icons per/page to display
					),
					'dependency' => array(
						'element' => 'i_type',
						'value' => 'material',
					),
					'description' => esc_html__( 'Select icon from library.', 'alchemists' ),
				),
				array(
					'type' => 'iconpicker',
					'heading' => esc_html__( 'Icon', 'alchemists' ),
					'param_name' => 'i_icon_simpleline',
					'value' => 'icon-like',
					// default value to backend editor admin_label
					'settings' => array(
						'emptyIcon' => false,
						// default true, display an "EMPTY" icon?
						'type' => 'simpleline',
						'iconsPerPage' => 4000,
						// default 100, how many icons per/page to display
					),
					'dependency' => array(
						'element' => 'i_type',
						'value' => 'simpleline',
					),
					'description' => esc_html__( 'Select icon from library.', 'alchemists' ),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Icon Holder Color', 'alchemists' ),
					'param_name'  => 'style',
					'value'       => array(
						esc_html__( 'Default', 'alchemists' ) => 'border',
						esc_html__( 'Primary', 'alchemists' ) => 'filled',
						esc_html__( 'Custom', 'alchemists' )  => 'custom',
					),
					'description' => esc_html__( 'Select icon holder color.', 'alchemists' ),
				),
				array(
					'type'        => 'colorpicker',
					'heading'     => esc_html__( 'Custom Icon Holder Color', 'alchemists' ),
					'param_name'  => 'custom_color_holder',
					'description' => esc_html__( 'Select custom icon holder color.', 'alchemists' ),
					'dependency'  => array(
						'element' => 'style',
						'value'   => 'custom',
					),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Icon Color', 'alchemists' ),
					'param_name'  => 'i_color',
					'value'       => array(
						esc_html__( 'Default', 'alchemists' ) => 'border',
						esc_html__( 'Custom', 'alchemists' )  => 'custom',
					),
					'description' => esc_html__( 'Select icon color.', 'alchemists' ),
				),
				array(
					'type'        => 'colorpicker',
					'heading'     => esc_html__( 'Custom Icon Color', 'alchemists' ),
					'param_name'  => 'custom_color_icon',
					'description' => esc_html__( 'Select custom icon color.', 'alchemists' ),
					'dependency'  => array(
						'element' => 'i_color',
						'value'   => 'custom',
					),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Icon Holder Size', 'alchemists' ),
					'param_name'  => 'size',
					'value'       => array(
						esc_html__( 'Large', 'alchemists' )       => 'lg',
						esc_html__( 'Medium', 'alchemists' )      => 'medium',
					),
					'description' => esc_html__( 'Select box size.', 'alchemists' ),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Icon Holder Shape', 'alchemists' ),
					'param_name'  => 'shape',
					'value'       => array(
						esc_html__( 'Circle', 'alchemists' )      => 'circle',
						esc_html__( 'Rounded', 'alchemists' )     => 'rounded',
						esc_html__( 'Square', 'alchemists' )      => 'square',
					),
					'description' => esc_html__( 'Select box shape.', 'alchemists' ),
				),
				vc_map_add_css_animation(),
				array(
					'type'        => 'el_id',
					'heading'     => esc_html__( 'Element ID', 'alchemists' ),
					'param_name'  => 'el_id',
					'description' => esc_html__( 'Enter element ID (Note: make sure it is unique and valid.', 'alchemists' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Extra class name', 'alchemists' ),
					'param_name'  => 'el_class',
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'alchemists' ),
				),
				array(
					'type'        => 'css_editor',
					'heading'     => esc_html__( 'CSS box', 'alchemists' ),
					'param_name'  => 'css',
					'group'       => esc_html__( 'Design Options', 'alchemists' ),
				),
			)
		) );



		// ALC: Alert
		vc_map( array(
			'name'        => esc_html__( 'ALC: Alert', 'alchemists' ),
			'base'        => 'alc_alert',
			'icon'        => get_template_directory_uri() . '/admin/images/js_composer/alc_alert.png',
			'category'    => esc_html__( 'ALC', 'alchemists' ),
			'description' => esc_html__( 'Simple Alert block.', 'alchemists' ),
			'params'      => array(
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Style', 'alchemists' ),
					'param_name'  => 'style',
					'value'       => array(
						esc_html__( 'Success', 'alchemists' )  => 'success',
						esc_html__( 'Info', 'alchemists' )     => 'info',
						esc_html__( 'Warning', 'alchemists' )  => 'warning',
						esc_html__( 'Danger', 'alchemists' )   => 'danger',
					),
					'description' => esc_html__( 'Select style type.', 'alchemists' ),
				),
				array(
					'type'        => 'textarea_html',
					'heading'     => esc_html__( 'Message text', 'alchemists' ),
					'param_name'  => 'content',
					'value'       => esc_html__( 'I am message box. Click edit button to change this text.', 'alchemists' ),
					'admin_label' => true,
				),
				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__( 'Dismissible?', 'alchemists' ),
					'param_name'  => 'dismissible',
				),
				vc_map_add_css_animation(),
				array(
					'type'        => 'el_id',
					'heading'     => esc_html__( 'Element ID', 'alchemists' ),
					'param_name'  => 'el_id',
					'description' => esc_html__( 'Enter element ID (Note: make sure it is unique and valid.', 'alchemists' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Extra class name', 'alchemists' ),
					'param_name'  => 'el_class',
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'alchemists' ),
				),
				array(
					'type'        => 'css_editor',
					'heading'     => esc_html__( 'CSS box', 'alchemists' ),
					'param_name'  => 'css',
					'group'       => esc_html__( 'Design Options', 'alchemists' ),
				),
			)
		) );



		// ALC: Box
		vc_map( array(
			'name'        => esc_html__( 'ALC: Box', 'alchemists' ),
			'base'        => 'alc_box',
			'icon'        => get_template_directory_uri() . '/admin/images/js_composer/alc_box.png',
			'category'    => esc_html__( 'ALC', 'alchemists' ),
			'description' => esc_html__( 'A simple box.', 'alchemists' ),
			'js_view'     => 'VcColumnView',
			'as_parent'   => array(
				'except' => 'alc_event_blocks_sm, alc_event_scoreboard, alc_images_carousel, alc_games_history, alc_team_stats, alc_team_points_history, alc_newslog_item, alc_team_leaders, alc_staff_bio_card, alc_post_loop, alc_post_slider, alc_post_carousel, alc_player_stats, alc_player_gbg_stats, alc_newslog',
			),
			'params'      => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Widget title', 'alchemists' ),
					'param_name'  => 'title',
					'description' => esc_html__( 'Enter text used as widget title (Note: located above content element).', 'alchemists' ),
					'admin_label' => true,
				),
				vc_map_add_css_animation(),
				array(
					'type'        => 'el_id',
					'heading'     => esc_html__( 'Element ID', 'alchemists' ),
					'param_name'  => 'el_id',
					'description' => esc_html__( 'Enter element ID (Note: make sure it is unique and valid.', 'alchemists' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Extra class name', 'alchemists' ),
					'param_name'  => 'el_class',
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'alchemists' ),
				),
				array(
					'type'        => 'css_editor',
					'heading'     => esc_html__( 'CSS box', 'alchemists' ),
					'param_name'  => 'css',
					'group'       => esc_html__( 'Design Options', 'alchemists' ),
				),
			)
		) );



		// ALC: Woo Banner
		vc_map( array(
			'name'        => esc_html__( 'ALC: Woo Banner', 'alchemists' ),
			'base'        => 'alc_woo_banner',
			'icon'        => get_template_directory_uri() . '/admin/images/js_composer/alc_woo_banner.png',
			'category'    => esc_html__( 'ALC', 'alchemists' ),
			'description' => esc_html__( 'A simple banner.', 'alchemists' ),
			'params'      => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Title', 'alchemists' ),
					'param_name'  => 'title',
					'description' => esc_html__( 'Enter a short title.', 'alchemists' ),
					'admin_label' => true,
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Subtitle', 'alchemists' ),
					'param_name'  => 'subtitle',
					'description' => esc_html__( 'Enter a short subtitle.', 'alchemists' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Subtitle - Secondary', 'alchemists' ),
					'param_name'  => 'subtitle_2',
					'description' => esc_html__( 'Enter a short subtitle.', 'alchemists' ),
				),
				array(
					'type'        => 'vc_link',
					'heading'     => esc_html__( 'Button', 'alchemists' ),
					'param_name'  => 'link',
					'description' => esc_html__( 'Add link to the button.', 'alchemists' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Discount Text', 'alchemists' ),
					'param_name'  => 'discount_txt',
					'description' => esc_html__( 'Enter a short text.', 'alchemists' ),
					'value'       => esc_html__( 'Only', 'alchemists' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Discount Price', 'alchemists' ),
					'param_name'  => 'discount_price',
					'description' => esc_html__( 'Enter your price.', 'alchemists' ),
					'value'       => '$50',
				),
				array(
					'type'        => 'attach_image',
					'heading'     => esc_html__( 'Image', 'alchemists' ),
					'param_name'  => 'image',
					'value'       => '',
					'description' => esc_html__( 'Select image from media library.', 'alchemists' ),
				),
				vc_map_add_css_animation(),
				array(
					'type'        => 'el_id',
					'heading'     => esc_html__( 'Element ID', 'alchemists' ),
					'param_name'  => 'el_id',
					'description' => esc_html__( 'Enter element ID (Note: make sure it is unique and valid.', 'alchemists' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Extra class name', 'alchemists' ),
					'param_name'  => 'el_class',
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'alchemists' ),
				),
				array(
					'type'        => 'css_editor',
					'heading'     => esc_html__( 'CSS box', 'alchemists' ),
					'param_name'  => 'css',
					'group'       => esc_html__( 'Design Options', 'alchemists' ),
				),
			)
		) );


		// ALC: Albums
		vc_map( array(
			'name'        => esc_html__( 'ALC: Albums', 'alchemists' ),
			'base'        => 'alc_albums',
			'icon'        => get_template_directory_uri() . '/admin/images/js_composer/alc_albums.png',
			'category'    => esc_html__( 'ALC', 'alchemists' ),
			'description' => esc_html__( 'Albums element.', 'alchemists' ),
			'params'      => array(
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Layout', 'alchemists'),
					'param_name'  => 'posts_layout',
					'value'       => array(
						esc_html__( 'Grid 2 cols', 'alchemists' ) => 'grid_2cols',
						esc_html__( 'Grid 3 cols', 'alchemists' ) => 'grid_3cols',
						esc_html__( 'Grid 4 cols', 'alchemists' ) => 'grid_4cols',
					),
					'description' => esc_html__( 'Select Albums Layout', 'alchemists' ),
					'admin_label' => true,
				),
				array(
					'type' => 'autocomplete',
					'heading' => esc_html__( 'Categories', 'alchemists' ),
					'param_name' => 'album_categories',
					'settings' => array(
						'multiple' => true,
						'min_length' => 1,
						'groups' => true,
						// In UI show results grouped by groups, default false
						'unique_values' => true,
						// In UI show results except selected. NB! You should manually check values in backend, default false
						'display_inline' => true,
						// In UI show results inline view, default false (each value in own line)
						'delay' => 500,
						// delay for search. default 500
						'auto_focus' => true,
						// auto focus input, default true
						'sortable' => true,
						'no_hide' => true,
						'values' => $album_categories_array
					),
					'param_holder_class' => 'vc_not-for-custom',
					'description' => esc_html__( 'Filter posts by categories.', 'alchemists' ),
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Display Style', 'alchemists' ),
					'param_name' => 'display_style',
					'value' => array(
						esc_html__( 'Show all', 'alchemists' ) => 'all',
						esc_html__( 'Pagination', 'alchemists' ) => 'pagination',
					),
					'edit_field_class' => 'vc_col-sm-6',
					'description' => esc_html__( 'Select display style for albums.', 'alchemists' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Items per page', 'alchemists' ),
					'param_name' => 'items_per_page',
					'value' => '10',
					'edit_field_class' => 'vc_col-sm-6',
					'description' => esc_html__( 'Number of items to show per page.', 'alchemists' ),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Offset', 'alchemists' ),
					'param_name' => 'offset',
					'description' => esc_html__( 'Number of post to displace or pass over.', 'alchemists' ),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Order', 'alchemists'),
					'param_name'  => 'order',
					'value'       => $order_array,
					'description' => esc_html__( 'Sort retrieved posts.', 'alchemists' ),
					'edit_field_class' => 'vc_col-sm-6',
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Order By', 'alchemists'),
					'param_name'  => 'order_by',
					'value'       => $order_by_array,
					'description' => esc_html__( 'Sort retrieved posts.', 'alchemists' ),
					'edit_field_class' => 'vc_col-sm-6',
				),
				vc_map_add_css_animation(),
				array(
					'type'        => 'el_id',
					'heading'     => esc_html__( 'Element ID', 'alchemists' ),
					'param_name'  => 'el_id',
					'description' => esc_html__( 'Enter element ID (Note: make sure it is unique and valid.', 'alchemists' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Extra class name', 'alchemists' ),
					'param_name'  => 'el_class',
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'alchemists' ),
				),
				array(
					'type'        => 'css_editor',
					'heading'     => esc_html__( 'CSS box', 'alchemists' ),
					'param_name'  => 'css',
					'group'       => esc_html__( 'Design Options', 'alchemists' ),
				),
			)
		) );


		// ALC: Content Filter
		vc_map( array(
			'name'        => esc_html__( 'ALC: Content Nav', 'alchemists' ),
			'base'        => 'alc_content_filter',
			'icon'        => get_template_directory_uri() . '/admin/images/js_composer/alc_content_filter.png',
			'category'    => esc_html__( 'ALC', 'alchemists' ),
			'description' => esc_html__( 'A custom content filter.', 'alchemists' ),
			'params'      => array(
				array(
					'type'        => 'param_group',
					'heading'     => esc_html__( 'Items', 'alchemists' ),
					'param_name'  => 'values',
					'value' => urlencode( json_encode( array(
						array(
							'label' => esc_html__( 'Select Item', 'alchemists' ),
							'value' => '',
						),
						array(
							'label' => esc_html__( 'Select Item', 'alchemists' ),
							'value' => '',
						),
					) ) ),
					'params' => array(
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Title', 'alchemists' ),
							'param_name'  => 'item_label',
							'holder'      => 'div',
							'value'       => esc_html__( 'Title goes here', 'alchemists' ),
							'description' => esc_html__( 'Enter short title.', 'alchemists'),
							'admin_label' => true,
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Subtitle', 'alchemists' ),
							'param_name'  => 'item_label_2',
							'holder'      => 'div',
							'value'       => esc_html__( 'Subtitle', 'alchemists' ),
							'description' => esc_html__( 'Enter short subtitle.', 'alchemists'),
							'admin_label' => true,
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'URL', 'alchemists'),
							'param_name'  => 'item_link',
							'holder'      => 'div',
							'value'       => '#',
							'description' => esc_html__( 'Enter URL to a page.', 'alchemists' ),
						),
						array(
							'heading'       => esc_html__( 'Active?', 'alchemists' ),
							'type'          => 'checkbox',
							'param_name'    => 'item_is_active',
							'value'         => array(
								esc_html__( 'Yes', 'alchemists' ) => '1'
							),
							'description' => esc_html__( 'Select currently active item.', 'alchemists' ),
						),
					),
				),
				vc_map_add_css_animation(),
				array(
					'type'        => 'el_id',
					'heading'     => esc_html__( 'Element ID', 'alchemists' ),
					'param_name'  => 'el_id',
					'description' => esc_html__( 'Enter element ID (Note: make sure it is unique and valid.', 'alchemists' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Extra class name', 'alchemists' ),
					'param_name'  => 'el_class',
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'alchemists' ),
				),
				array(
					'type'        => 'css_editor',
					'heading'     => esc_html__( 'CSS box', 'alchemists' ),
					'param_name'  => 'css',
					'group'       => esc_html__( 'Design Options', 'alchemists' ),
				),
			)
		) );

	}
}

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_Alc_Newslog extends WPBakeryShortCodesContainer {
	}

	class WPBakeryShortCode_Alc_Box extends WPBakeryShortCodesContainer {
	}
}

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_Alc_Alert extends WPBakeryShortCode {
	}

	class WPBakeryShortCode_Alc_Images_Carousel extends WPBakeryShortCode {
	}

	class WPBakeryShortCode_Alc_Newslog_Item extends WPBakeryShortCode {
	}

	class WPBakeryShortCode_Alc_Social_Buttons extends WPBakeryShortCode {
	}

	class WPBakeryShortCode_Alc_Post_Loop extends WPBakeryShortCode {
	}

	class WPBakeryShortCode_Alc_Post_Slider extends WPBakeryShortCode {
	}

	class WPBakeryShortCode_Alc_Post_Carousel extends WPBakeryShortCode {
	}

	class WPBakeryShortCode_Alc_Featured_Post extends WPBakeryShortCode {
	}

	class WPBakeryShortCode_Alc_Btn extends WPBakeryShortCode {
	}

	class WPBakeryShortCode_Alc_Icobox extends WPBakeryShortCode {
	}

	class WPBakeryShortCode_Alc_Woo_Banner extends WPBakeryShortCode {
	}

	class WPBakeryShortCode_Alc_Albums extends WPBakeryShortCode {
	}

	class WPBakeryShortCode_Alc_Content_Filter extends WPBakeryShortCode {
	}

}



/**
 * SportsPress Elements
 */

if ( class_exists( 'SportsPress' ) ) {

	if ( function_exists( 'vc_map' ) ) {
		add_action( 'init', 'alchemists_vc_elements_sp' );
	}

	if ( ! function_exists( 'alchemists_vc_elements_sp' ) ) {
		function alchemists_vc_elements_sp() {

			// Events All
			$events = get_posts(array(
				'post_type' => 'sp_event',
				'posts_per_page' => 9999,
			));
			$events_array = array();

			if( $events ){
				foreach($events as $event){
					$events_array[$event->post_title] = $event->ID;
				}
			}

			// Events Published
			$events_publish = get_posts(array(
				'post_type' => 'sp_event',
				'posts_per_page' => 9999,
				'post_status' => 'publish'
			));
			$events_publish_array = array();

			if( $events_publish ){
				foreach($events_publish as $event_publish){
					$events_publish_array[$event_publish->post_title] = $event_publish->ID;
				}
			}


			// Players List
			$player_lists = get_posts( array(
				'post_type' => 'sp_list',
				'posts_per_page' => 9999
			));

			$player_lists_array = array();
			if( $player_lists ){
				foreach( $player_lists as $list ){
					$player_lists_array[$list->post_title] = $list->ID;
				}
			}


			// Players
			$players = get_posts(array(
				'post_type' => 'sp_player',
				'posts_per_page' => 9999
			));

			$players_array = array();
			if( $players ){
				foreach( $players as $player ){
					$players_array[] = array(
						'label' => $player->post_title,
						'value' => $player->ID
					);
				}
			}


			// Player Stats
			$statistics = get_posts(array(
				'post_type' => 'sp_statistic',
				'posts_per_page' => 9999
			));

			$statistics_array = array();
			if($statistics){
				foreach($statistics as $statistic){
					$statistics_array[] = array(
						'label' => $statistic->post_title . ' (' . $statistic->post_excerpt . ')',
						'value' => $statistic->ID
					);
				}
			}


			// Player Performance
			$performances = get_posts(array(
				'post_type' => 'sp_performance',
				'posts_per_page' => 9999
			));

			$performances_array = array();
			if($performances){
				foreach($performances as $performance){
					$performances_array[] = array(
						'label' => $performance->post_title . ' (' . $performance->post_excerpt . ')',
						'value' => $performance->ID
					);
				}
			}


			// Player Performance Numbers (not equation)
			$performances_numbers = get_posts(array(
				'post_type' => 'sp_performance',
				'posts_per_page' => 9999,
				'meta_query' => array(
					array(
						'key' => 'sp_format',
						'value' => 'number',
						'compare' => '=',
					)
				)
			));

			$performances_numbers_array = array();
			if($performances_numbers){
				foreach($performances_numbers as $performance){
					$performances_numbers_array[] = array(
						'label' => $performance->post_title . ' (' . $performance->post_excerpt . ')',
						'value' => $performance->ID
					);
				}
			}


			// Player Performance Equation (not numbers)
			$performances_equation = get_posts(array(
				'post_type' => 'sp_performance',
				'posts_per_page' => 9999,
				'meta_query' => array(
					array(
						'key' => 'sp_format',
						'value' => 'equation',
						'compare' => '=',
					)
				)
			));

			$performances_equation_array = array();
			if($performances_equation){
				foreach($performances_equation as $performance){
					$performances_equation_array[] = array(
						'label' => $performance->post_title . ' (' . $performance->post_excerpt . ')',
						'value' => $performance->ID
					);
				}
			}


			// Teams List
			$teams = get_posts( array(
				'post_type' => 'sp_team',
				'orderby' => 'title',
				'order' => 'ASC',
				'posts_per_page' => 9999
			));

			$teams_array = array();
			if( $teams ){
				foreach( $teams as $team ){
					$teams_array[$team->post_title] = $team->ID;
				}
			}


			// Staff
			$staffs = get_posts(array(
				'post_type' => 'sp_staff',
				'posts_per_page' => 9999
			));

			$staffs_array = array();
			if( $staffs ){
				foreach( $staffs as $staff ){
					$staffs_array[] = array(
						'label' => $staff->post_title,
						'value' => $staff->ID
					);
				}
			}


			// Calendar
			$calendars = get_posts(array(
				'post_type' => 'sp_calendar',
				'posts_per_page' => 9999,
			));

			$calendars_array = array();
			if( $calendars ){
				foreach($calendars as $calendar){
					$calendars_array[$calendar->post_title] = $calendar->ID;
				}
			}


			// League Tables
			$tables = get_posts(array(
				'posts_per_page' => 9999,
				'post_type' => 'sp_table'
			));
			$tables_array = array(
				'0' => esc_html__('Empty', 'alchemists')
			);
			if( $tables ){
				$tables_array = array();
				foreach($tables as $table){
					$tables_array[$table->post_title] = $table->ID;
				}
			}


			// League Tables Stats
			$league_tables = get_posts(array(
				'post_type' => 'sp_column',
				'posts_per_page' => 9999,
			));

			$league_tables_array = array();
			if($league_tables){
				foreach($league_tables as $league_table){
					$league_tables_array[] = array(
						'label' => $league_table->post_title,
						'value' => $league_table->ID
					);
				}
			}

			// Seasons
			$seasons = get_terms( 'sp_season' );
			$seasons_array = array();

			if(!empty($seasons) and !is_wp_error($seasons)) {
				foreach ( $seasons as $season ) {
					$seasons_array[] = array(
						'label' => $season->name,
						'value' => $season->term_id
					);
				}
			}


			// ALC: Event Block - Simple
			vc_map( array(
				'name'        => esc_html__( 'ALC: Event Blocks - Simple', 'alchemists' ),
				'base'        => 'alc_event_blocks_sm',
				'icon'        => get_template_directory_uri() . '/admin/images/js_composer/alc_event_block_sm.png',
				'category'    => esc_html__( 'ALC', 'alchemists' ),
				'description' => esc_html__( 'A list of events.', 'alchemists' ),
				'params'      => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Heading', 'alchemists' ),
						'param_name'  => 'caption',
						'value'       => esc_html__( 'Events', 'alchemists' ),
						'description' => esc_html__( 'Add heading text here.', 'alchemists' ),
						'admin_label' => true,
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Number of events to show', 'alchemists' ),
						'param_name'  => 'number',
						'value'       => '5',
						'description' => esc_html__( 'Enter a number of events to show.', 'alchemists' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Status', 'alchemists' ),
						'param_name'  => 'status',
						'value'       => array(
							esc_html__( 'All', 'alchemists' )       => 'any',
							esc_html__( 'Published', 'alchemists' ) => 'publish',
							esc_html__( 'Scheduled', 'alchemists' ) => 'future',
						),
						'description' => esc_html__( 'Select events status to display.', 'alchemists' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Select Calendar:', 'alchemists' ),
						'param_name'  => 'calendar',
						'value'       => array(
							esc_html__( 'All', 'alchemists' ) => 'all',
						) + $calendars_array,
						'description' => esc_html__( 'Pick a calendar to display.', 'alchemists' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Sort Order:', 'alchemists' ),
						'param_name'  => 'order',
						'value'       => array(
							esc_html__( 'Default', 'alchemists' ) => 'default',
							esc_html__( 'ASC', 'alchemists' )     => 'asc',
							esc_html__( 'DESC', 'alchemists' )    => 'desc',
						),
						'description' => esc_html__( 'Select events sorting order.', 'alchemists' ),
					),
					array(
						'heading'       => esc_html__( 'Display link to view all events', 'alchemists' ),
						'type'          => 'checkbox',
						'param_name'    => 'show_all_events_link',
						'value'         => array(
							esc_html__( 'Yes', 'alchemists' ) => '1'
						),
						'description' => esc_html__( 'Adds a button to the header (Note: make sure you selected a calendar to get it working).', 'alchemists' ),
					),
				)
			) );



			// ALC: Event Scoreboard
			vc_map( array(
				'name'        => esc_html__( 'ALC: Event Scoreboard', 'alchemists' ),
				'base'        => 'alc_event_scoreboard',
				'icon'        => get_template_directory_uri() . '/admin/images/js_composer/alc_event_scoreboard.png',
				'category'    => esc_html__( 'ALC', 'alchemists' ),
				'description' => esc_html__( 'A list of events.', 'alchemists' ),
				'params'      => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Widget title', 'alchemists' ),
						'param_name'  => 'title',
						'description' => esc_html__( 'Enter text used as widget title (Note: located above content element).', 'alchemists' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Select Event', 'alchemists' ),
						'param_name'  => 'event',
						'value'       => $events_publish_array,
						'description' => esc_html__( 'Pick event to display.', 'alchemists' ),
						'admin_label' => true,
					),
					array(
						'heading'       => esc_html__( 'Details', 'alchemists' ),
						'type'          => 'checkbox',
						'param_name'    => 'display_details',
						'std'           => '1',
						'value'         => array(
							esc_html__( 'Yes', 'alchemists' ) => '1'
						),
						'description' => esc_html__( 'Detailed statistics will be shown if enabled.', 'alchemists' ),
					),
					array(
						'heading'       => esc_html__( 'Advanced Details', 'alchemists' ),
						'type'          => 'checkbox',
						'param_name'    => 'display_percentage',
						'std'           => '1',
						'value'         => array(
							esc_html__( 'Yes', 'alchemists' ) => '1'
						),
						'description' => esc_html__( 'Additional statistics will be shown if enabled.', 'alchemists' ),
					),
					array(
						'type'        => 'vc_link',
						'heading'     => esc_html__( 'Button URL (Link)', 'alchemists' ),
						'param_name'  => 'link',
						'description' => esc_html__( 'Add link to header.', 'alchemists' ),
					),
					array(
						'group'       => esc_html__( 'Styling', 'alchemists'),
						'type'        => 'colorpicker',
						'heading'     => esc_html__( '1st Team Color', 'alchemists' ),
						'param_name'  => 'color_team_1',
						'description' => esc_html__( 'Color for progress and circular bars of the 1st Team.', 'alchemists' ),
					),
					array(
						'group'       => esc_html__( 'Styling', 'alchemists'),
						'type'        => 'colorpicker',
						'heading'     => esc_html__( '2nd Team Color', 'alchemists' ),
						'param_name'  => 'color_team_2',
						'description' => esc_html__( 'Color for progress and circular bars of the 2nd Team.', 'alchemists' ),
					),
					vc_map_add_css_animation(),
					array(
						'type'        => 'el_id',
						'heading'     => esc_html__( 'Element ID', 'alchemists' ),
						'param_name'  => 'el_id',
						'description' => esc_html__( 'Enter element ID (Note: make sure it is unique and valid.', 'alchemists' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'alchemists' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'alchemists' ),
					),
					array(
						'type'        => 'css_editor',
						'heading'     => esc_html__( 'CSS box', 'alchemists' ),
						'param_name'  => 'css',
						'group'       => esc_html__( 'Design Options', 'alchemists' ),
					),
				)
			) );



			// ALC: Games History
			vc_map( array(
				'name'        => esc_html__( 'ALC: Games History', 'alchemists' ),
				'base'        => 'alc_games_history',
				'icon'        => get_template_directory_uri() . '/admin/images/js_composer/alc_games_history.png',
				'category'    => esc_html__( 'ALC', 'alchemists' ),
				'description' => esc_html__( 'A chart with games history.', 'alchemists' ),
				'params'      => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Widget title', 'alchemists' ),
						'param_name'  => 'title',
						'description' => esc_html__( 'Enter text used as widget title (Note: located above content element).', 'alchemists' ),
						'admin_label' => true,
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Select Team:', 'alchemists' ),
						'param_name'  => 'team_id',
						'value'       => array(
							esc_html__( 'Default', 'alchemists' ) => 'default',
						) + $teams_array,
						'description' => esc_html__( 'Select team to display games history. Can be set Default if you\'re on Team Page.', 'alchemists' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'WON Label', 'alchemists' ),
						'param_name'  => 'label_won',
						'value'       => esc_html__( 'Won', 'alchemists' ),
						'description' => esc_html__( 'Enter text for WON label.', 'alchemists' ),
						'param_holder_class' => 'vc_col-xs-6',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'LOST Label', 'alchemists' ),
						'param_name'  => 'label_lost',
						'value'       => esc_html__( 'Lost', 'alchemists' ),
						'description' => esc_html__( 'Enter text for LOST label.', 'alchemists' ),
						'param_holder_class' => 'vc_col-xs-6',
					),
					array(
						'group'       => esc_html__( 'Styling', 'alchemists'),
						'type'        => 'colorpicker',
						'heading'     => esc_html__( 'WON Bars Color', 'alchemists' ),
						'param_name'  => 'color_won',
						'description' => esc_html__( 'Select a custom color for WON bars.', 'alchemists' ),
					),
					array(
						'type'        => 'colorpicker',
						'group'       => esc_html__( 'Styling', 'alchemists'),
						'heading'     => esc_html__( 'LOST Bars Color', 'alchemists' ),
						'param_name'  => 'color_lost',
						'description' => esc_html__( 'Select a custom color for LOST bars.', 'alchemists' ),
					),
					vc_map_add_css_animation(),
					array(
						'type'        => 'el_id',
						'heading'     => esc_html__( 'Element ID', 'alchemists' ),
						'param_name'  => 'el_id',
						'description' => esc_html__( 'Enter element ID (Note: make sure it is unique and valid.', 'alchemists' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'alchemists' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'alchemists' ),
					),
					array(
						'type'        => 'css_editor',
						'heading'     => esc_html__( 'CSS box', 'alchemists' ),
						'param_name'  => 'css',
						'group'       => esc_html__( 'Design Options', 'alchemists' ),
					),
				)
			) );



			// ALC: Team Stats
			vc_map( array(
				'name'        => esc_html__( 'ALC: Team Stats', 'alchemists' ),
				'base'        => 'alc_team_stats',
				'icon'        => get_template_directory_uri() . '/admin/images/js_composer/alc_team_stats.png',
				'category'    => esc_html__( 'ALC', 'alchemists' ),
				'description' => esc_html__( 'A block with team stats.', 'alchemists' ),
				'params'      => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Widget title', 'alchemists' ),
						'param_name'  => 'title',
						'description' => esc_html__( 'Enter text used as widget title (Note: located above content element).', 'alchemists' ),
						'admin_label' => true,
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Select Team:', 'alchemists' ),
						'param_name'  => 'team_id',
						'value'       => array(
							esc_html__( 'Default', 'alchemists' ) => 'default',
						) + $teams_array,
						'description' => esc_html__( 'Select team to display games history. Can be set Default if you\'re on Team Page.', 'alchemists' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Select League Table:', 'alchemists' ),
						'param_name'  => 'league_table_id',
						'value'       => $tables_array ,
						'description' => esc_html__( 'Select league table.', 'alchemists' ),
					),

					array(
						'type'        => 'param_group',
						'heading'     => esc_html__( 'Team Stats', 'alchemists' ),
						'param_name'  => 'values',
						'value' => urlencode( json_encode( array(
							array(
								'label' => esc_html__( 'Select Statistic', 'alchemists' ),
								'value' => '',
							),
							array(
								'label' => esc_html__( 'Select Statistic', 'alchemists' ),
								'value' => '',
							),
							array(
								'label' => esc_html__( 'Select Statistic', 'alchemists' ),
								'value' => '',
							),
							array(
								'label' => esc_html__( 'Select Statistic', 'alchemists' ),
								'value' => '',
							),
						) ) ),
						'params' => array(
							array(
								'type'        => 'textfield',
								'heading'     => esc_html__( 'Label', 'alchemists' ),
								'param_name'  => 'stat_heading',
								'holder'      => 'div',
								'description' => esc_html__( 'Enter label for statistic', 'alchemists'),
								'admin_label' => true,
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__( 'Statistic', 'alchemists'),
								'param_name'  => 'stat_value',
								'value'       => $league_tables_array,
								'holder'      => 'div',
								'description' => esc_html__( 'Select a statistic', 'alchemists' ),
								'admin_label' => true,
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__( 'Icon', 'alchemists'),
								'param_name'  => 'stat_icon',
								'value'       => array(
									esc_html__( 'Icon 1', 'alchemists' ) => 'icon_1',
									esc_html__( 'Icon 2', 'alchemists' ) => 'icon_2',
									esc_html__( 'Icon 3', 'alchemists' ) => 'icon_3',
									esc_html__( 'Icon Custom', 'alchemists' ) => 'icon_custom',
								),
								'holder'      => 'div',
								'description' => esc_html__( 'Select an icon', 'alchemists' ),
							),
							array(
								'type'        => 'textfield',
								'heading'     => esc_html__( 'Icon Symbol', 'alchemists' ),
								'param_name'  => 'stat_icon_symbol',
								'holder'      => 'div',
								'value'       => '3',
								'description' => esc_html__( 'Enter icon symbol, e.g. W, L, % etc.', 'alchemists'),
								'dependency'  => array(
									'element' => 'stat_icon',
									'value'   => array( 'icon_custom' )
								)
							),
						),
					),

					vc_map_add_css_animation(),
					array(
						'type'        => 'el_id',
						'heading'     => esc_html__( 'Element ID', 'alchemists' ),
						'param_name'  => 'el_id',
						'description' => esc_html__( 'Enter element ID (Note: make sure it is unique and valid.', 'alchemists' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'alchemists' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'alchemists' ),
					),
					array(
						'type'        => 'css_editor',
						'heading'     => esc_html__( 'CSS box', 'alchemists' ),
						'param_name'  => 'css',
						'group'       => esc_html__( 'Design Options', 'alchemists' ),
					),
				)
			) );


			// ALC: Team Points History
			vc_map( array(
				'name'        => esc_html__( 'ALC: Team Points History', 'alchemists' ),
				'base'        => 'alc_team_points_history',
				'icon'        => get_template_directory_uri() . '/admin/images/js_composer/alc_team_points_history.png',
				'category'    => esc_html__( 'ALC', 'alchemists' ),
				'description' => esc_html__( 'A chart displayed team points.', 'alchemists' ),
				'params'      => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Widget title', 'alchemists' ),
						'param_name'  => 'title',
						'description' => esc_html__( 'Enter text used as widget title (Note: located above content element).', 'alchemists' ),
						'admin_label' => true,
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Select Team:', 'alchemists' ),
						'param_name'  => 'team_id',
						'value'       => array(
							esc_html__( 'Default', 'alchemists' ) => 'default',
						) + $teams_array,
						'description' => esc_html__( 'Select team to display games history. Can be set Default if you\'re on Team Page.', 'alchemists' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Select Calendar:', 'alchemists' ),
						'param_name'  => 'calendar_id',
						'value'       => array(
							esc_html__( 'All', 'alchemists' ) => 'all',
						) + $calendars_array,
						'description' => esc_html__( 'Pick a calendar to display.', 'alchemists' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Date:', 'alchemists' ),
						'param_name'  => 'date',
						'value'       => array(
							esc_html__( 'Default', 'alchemists' ) => 'default',
							esc_html__( 'All', 'alchemists' ) => '0',
							esc_html__( 'This Week', 'alchemists' ) => 'w',
							esc_html__( 'Date Range', 'alchemists' ) => 'range',
						),
						'description' => esc_html__( 'Select a date to display.', 'alchemists' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Date From:', 'alchemists' ),
						'param_name'  => 'date_from',
						'description' => esc_html__( 'Date Format yyyy-mm-dd, e.g. 2017-01-30', 'alchemists' ),
						'dependency' => array(
							'element' => 'date',
							'value'   => array( 'range' ),
						),
						'param_holder_class' => 'vc_col-xs-6',
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Date To:', 'alchemists' ),
						'param_name'  => 'date_to',
						'description' => esc_html__( 'Date Format yyyy-mm-dd, e.g. 2017-03-31', 'alchemists' ),
						'dependency' => array(
							'element' => 'date',
							'value'   => array( 'range' ),
						),
						'param_holder_class' => 'vc_col-xs-6',
					),
					array(
						'group'       => esc_html__( 'Styling', 'alchemists'),
						'type'        => 'colorpicker',
						'heading'     => esc_html__( 'Chart Line Color', 'alchemists' ),
						'param_name'  => 'color_line',
						'description' => esc_html__( 'Select a custom color for chart line.', 'alchemists' ),
					),
					array(
						'group'       => esc_html__( 'Styling', 'alchemists'),
						'type'        => 'colorpicker',
						'heading'     => esc_html__( 'Chart Point Color', 'alchemists' ),
						'param_name'  => 'color_point',
						'description' => esc_html__( 'Select a custom color for chart point.', 'alchemists' ),
					),
					vc_map_add_css_animation(),
					array(
						'type'        => 'el_id',
						'heading'     => esc_html__( 'Element ID', 'alchemists' ),
						'param_name'  => 'el_id',
						'description' => esc_html__( 'Enter element ID (Note: make sure it is unique and valid.', 'alchemists' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'alchemists' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'alchemists' ),
					),
					array(
						'type'        => 'css_editor',
						'heading'     => esc_html__( 'CSS box', 'alchemists' ),
						'param_name'  => 'css',
						'group'       => esc_html__( 'Design Options', 'alchemists' ),
					),
				)
			) );



			// ALC: Team Leaders
			vc_map( array(
				'name'        => esc_html__( 'ALC: Team Leaders', 'alchemists' ),
				'base'        => 'alc_team_leaders',
				'icon'        => get_template_directory_uri() . '/admin/images/js_composer/alc_team_leaders.png',
				'category'    => esc_html__( 'ALC', 'alchemists' ),
				'description' => esc_html__( 'A block for displaying team leaders.', 'alchemists' ),
				'params'      => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Widget title', 'alchemists' ),
						'param_name'  => 'title',
						'description' => esc_html__( 'Enter text used as widget title (Note: located above content element).', 'alchemists' ),
						'admin_label' => true,
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Select Player List:', 'alchemists' ),
						'param_name'  => 'player_lists_id',
						'value'       => $player_lists_array,
						'description' => esc_html__( 'Select player list.', 'alchemists' ),
					),
					array(
						'type'        => 'param_group',
						'heading'     => esc_html__( 'Players Stats', 'alchemists' ),
						'param_name'  => 'values',
						'value' => urlencode( json_encode( array(
							array(
								'label' => esc_html__( 'Select Statistic', 'alchemists' ),
								'value' => '',
							),
							array(
								'label' => esc_html__( 'Select Statistic', 'alchemists' ),
								'value' => '',
							),
						) ) ),
						'params' => array(
							array(
								'type'        => 'textfield',
								'heading'     => esc_html__( 'Label', 'alchemists' ),
								'param_name'  => 'stat_heading',
								'holder'      => 'div',
								'description' => esc_html__( 'Enter Heading for Statistic', 'alchemists'),
								'admin_label' => true,
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__( 'Statistic', 'alchemists'),
								'param_name'  => 'stat_value',
								'value'       => $performances_array,
								'holder'      => 'div',
								'description' => esc_html__( 'Select a statistic', 'alchemists' ),
								'admin_label' => true,
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__( 'AVG Statistic', 'alchemists'),
								'param_name'  => 'stat_avg',
								'value'       => $statistics_array,
								'holder'      => 'div',
								'description' => esc_html__( 'Select an AVG statistic', 'alchemists' ),
								'admin_label' => true,
							),
							array(
								'type'        => 'textfield',
								'heading'     => esc_html__( 'Number of Players', 'alchemists'),
								'param_name'  => 'stat_number',
								'value'       => '1',
								'holder'      => 'div',
								'description' => esc_html__( 'Enter number of players to display', 'alchemists' ),
								'admin_label' => true,
							),
						),
					),
					vc_map_add_css_animation(),
					array(
						'type'        => 'el_id',
						'heading'     => esc_html__( 'Element ID', 'alchemists' ),
						'param_name'  => 'el_id',
						'description' => esc_html__( 'Enter element ID (Note: make sure it is unique and valid.', 'alchemists' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'alchemists' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'alchemists' ),
					),
					array(
						'type'        => 'css_editor',
						'heading'     => esc_html__( 'CSS box', 'alchemists' ),
						'param_name'  => 'css',
						'group'       => esc_html__( 'Design Options', 'alchemists' ),
					),
				)
			) );



			// ALC: Staff Bio Card
			vc_map( array(
				'name'        => esc_html__( 'ALC: Staff Bio Card', 'alchemists' ),
				'base'        => 'alc_staff_bio_card',
				'icon'        => get_template_directory_uri() . '/admin/images/js_composer/alc_staff_bio_card.png',
				'category'    => esc_html__( 'ALC', 'alchemists' ),
				'description' => esc_html__( 'A staff info card.', 'alchemists' ),
				'params'      => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Widget title', 'alchemists' ),
						'param_name'  => 'title',
						'description' => esc_html__( 'Enter text used as widget title (Note: located above content element).', 'alchemists' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Staff Member', 'alchemists' ),
						'param_name'  => 'staff_id',
						'value'       => array(
							esc_html__( 'Default', 'alchemists' ) => 'default',
						) + $staffs_array,
						'description' => esc_html__( 'Select staff member you want to display.', 'alchemists' ),
						'admin_label' => true,
					),
					array(
						'type'        => 'vc_link',
						'heading'     => esc_html__( 'Button URL (Link)', 'alchemists' ),
						'param_name'  => 'link',
						'description' => esc_html__( 'Add link to header.', 'alchemists' ),
					),
					vc_map_add_css_animation(),
					array(
						'type'        => 'el_id',
						'heading'     => esc_html__( 'Element ID', 'alchemists' ),
						'param_name'  => 'el_id',
						'description' => esc_html__( 'Enter element ID (Note: make sure it is unique and valid.', 'alchemists' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'alchemists' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'alchemists' ),
					),
					array(
						'type'        => 'css_editor',
						'heading'     => esc_html__( 'CSS box', 'alchemists' ),
						'param_name'  => 'css',
						'group'       => esc_html__( 'Design Options', 'alchemists' ),
					),
				)
			) );





			// ALC: Player Stats
			vc_map( array(
				'name'        => esc_html__( 'ALC: Player Stats', 'alchemists' ),
				'base'        => 'alc_player_stats',
				'icon'        => get_template_directory_uri() . '/admin/images/js_composer/alc_player_stats.png',
				'category'    => esc_html__( 'ALC', 'alchemists' ),
				'description' => esc_html__( 'A block shows player stats.', 'alchemists' ),
				'params'      => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Widget title', 'alchemists' ),
						'param_name'  => 'title',
						'description' => esc_html__( 'Enter text used as widget title (Note: located above content element).', 'alchemists' ),
						'admin_label' => true,
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Select Player', 'alchemists' ),
						'param_name'  => 'player_id',
						'value'       => array(
							esc_html__( 'Default', 'alchemists' ) => 'default',
						) + $players_array,
						'description' => esc_html__( 'Select player. (Note: Leave it empty if you place this element on Single Player page).', 'alchemists' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Style', 'alchemists'),
						'param_name'  => 'style_type',
						'value'       => array(
							esc_html__( 'Banner - Style 1', 'alchemists' ) => 'style_1',
							esc_html__( 'Banner - Style 2', 'alchemists' ) => 'style_2',
							esc_html__( 'Hide Banner', 'alchemists' ) => 'style_hide_banner',
						),
						'description' => esc_html__( 'Select style or hide player banner.', 'alchemists' ),
					),
					array(
						'heading'       => esc_html__( 'Customize Primary Stats?', 'alchemists' ),
						'type'          => 'checkbox',
						'param_name'    => 'customize_primary_stats',
						'value'         => array(
							esc_html__( 'Yes', 'alchemists' ) => '1'
						),
						'description' => esc_html__( 'Enable to customize primary statistics.', 'alchemists' ),
						'dependency' => array(
							'element'   => 'style_type',
							'value_not_equal_to' => array( 'style_hide_banner' ),
						),
					),
					array(
						'type'        => 'param_group',
						'heading'     => esc_html__( 'Primary Stats', 'alchemists' ),
						'param_name'  => 'values_primary',
						'value' => urlencode( json_encode( array(
							array(
								'label' => esc_html__( 'Select Statistic', 'alchemists' ),
								'value' => '',
							),
							array(
								'label' => esc_html__( 'Select Statistic', 'alchemists' ),
								'value' => '',
							),
							array(
								'label' => esc_html__( 'Select Statistic', 'alchemists' ),
								'value' => '',
							),
						) ) ),
						'params' => array(
							array(
								'type'        => 'textfield',
								'heading'     => esc_html__( 'Heading', 'alchemists' ),
								'value'       => esc_html__( 'Label', 'alchemists' ),
								'param_name'  => 'stat_heading',
								'holder'      => 'div',
								'description' => esc_html__( 'Enter Heading for Statistic', 'alchemists'),
								'admin_label' => true,
							),
							array(
								'type'        => 'textfield',
								'heading'     => esc_html__( 'Subheading', 'alchemists' ),
								'value'       => esc_html__( 'avg', 'alchemists' ),
								'param_name'  => 'stat_subheading',
								'holder'      => 'div',
								'description' => esc_html__( 'Enter Subheading for Statistic', 'alchemists'),
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__( 'Statistic', 'alchemists'),
								'param_name'  => 'stat_value',
								'value'       => array_merge( $statistics_array, $performances_numbers_array ),
								'holder'      => 'div',
								'description' => esc_html__( 'Select a statistic', 'alchemists' ),
								'admin_label' => true,
							),
						),
						'dependency' => array(
							'element'   => 'customize_primary_stats',
							'not_empty' => true,
						),
					),
					array(
						'group'         => esc_html__( 'Performances', 'alchemists' ),
						'heading'       => esc_html__( 'Display Performances?', 'alchemists' ),
						'type'          => 'checkbox',
						'param_name'    => 'display_detailed_stats',
						'value'         => array(
							esc_html__( 'Yes', 'alchemists' ) => '1'
						),
						'description' => esc_html__( 'Detailed statistics will be shown if enabled.', 'alchemists' ),
					),
					array(
						'group'         => esc_html__( 'Performances', 'alchemists' ),
						'heading'       => esc_html__( 'Customize Performances?', 'alchemists' ),
						'type'          => 'checkbox',
						'param_name'    => 'customize_detailed_stats',
						'value'         => array(
							esc_html__( 'Yes', 'alchemists' ) => '1'
						),
						'description' => esc_html__( 'Enable to customize detailed statistics.', 'alchemists' ),
						'dependency' => array(
							'element'   => 'display_detailed_stats',
							'not_empty' => true,
						),
					),
					array(
						'group'       => esc_html__( 'Performances', 'alchemists' ),
						'type'        => 'param_group',
						'heading'     => esc_html__( 'Performance - Number', 'alchemists' ),
						'param_name'  => 'values',
						'value' => urlencode( json_encode( array(
							array(
								'label' => esc_html__( 'Select Statistic', 'alchemists' ),
								'value' => '',
							),
							array(
								'label' => esc_html__( 'Select Statistic', 'alchemists' ),
								'value' => '',
							),
						) ) ),
						'params' => array(
							array(
								'type'        => 'textfield',
								'heading'     => esc_html__( 'Heading', 'alchemists' ),
								'value'       => esc_html__( 'Label', 'alchemists' ),
								'param_name'  => 'stat_heading',
								'holder'      => 'div',
								'description' => esc_html__( 'Enter Heading for Statistic', 'alchemists'),
								'admin_label' => true,
							),
							array(
								'type'        => 'textfield',
								'heading'     => esc_html__( 'Subheading', 'alchemists' ),
								'value'       => esc_html__( 'In his career', 'alchemists' ),
								'param_name'  => 'stat_subheading',
								'holder'      => 'div',
								'description' => esc_html__( 'Enter Subheading for Statistic', 'alchemists'),
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__( 'Statistic', 'alchemists'),
								'param_name'  => 'stat_value',
								'value'       => array_merge( array( esc_html__( '- Select -', 'alchemists' ) => '' ), $performances_numbers_array ),
								'holder'      => 'div',
								'description' => esc_html__( 'Select a statistic', 'alchemists' ),
								'admin_label' => true,
							),
						),
						'dependency' => array(
							'element'   => 'customize_detailed_stats',
							'not_empty' => true,
						),
					),
					array(
						'group'         => esc_html__( 'Performances', 'alchemists' ),
						'heading'       => esc_html__( 'Display Secondary Performances?', 'alchemists' ),
						'type'          => 'checkbox',
						'param_name'    => 'display_detailed_stats_secondary',
						'value'         => array(
							esc_html__( 'Yes', 'alchemists' ) => '1'
						),
						'description' => esc_html__( 'Detailed statistics will be shown if enabled.', 'alchemists' ),
					),
					array(
						'group'         => esc_html__( 'Performances', 'alchemists' ),
						'heading'       => esc_html__( 'Customize Secondary Performances?', 'alchemists' ),
						'type'          => 'checkbox',
						'param_name'    => 'customize_detailed_stats_secondary',
						'value'         => array(
							esc_html__( 'Yes', 'alchemists' ) => '1'
						),
						'description' => esc_html__( 'Enable to customize detailed statistics.', 'alchemists' ),
						'dependency' => array(
							'element'   => 'display_detailed_stats_secondary',
							'not_empty' => true,
						),
					),

					array(
						'group'       => esc_html__( 'Performances', 'alchemists' ),
						'type'        => 'param_group',
						'heading'     => esc_html__( 'Performance - Equation', 'alchemists' ),
						'param_name'  => 'values_equation',
						'value' => urlencode( json_encode( array(
							array(
								'label' => esc_html__( 'Select Statistic', 'alchemists' ),
								'value' => '',
							),
							array(
								'label' => esc_html__( 'Select Statistic', 'alchemists' ),
								'value' => '',
							),
							array(
								'label' => esc_html__( 'Select Statistic', 'alchemists' ),
								'value' => '',
							),
						) ) ),
						'params' => array(
							array(
								'type'        => 'textfield',
								'heading'     => esc_html__( 'Heading', 'alchemists' ),
								'value'       => esc_html__( 'Label', 'alchemists' ),
								'param_name'  => 'stat_heading',
								'holder'      => 'div',
								'description' => esc_html__( 'Enter Heading for Statistic', 'alchemists'),
								'admin_label' => true,
							),
							array(
								'type'        => 'dropdown',
								'heading'     => esc_html__( 'Statistic', 'alchemists'),
								'param_name'  => 'stat_value',
								'value'       => array_merge( array( esc_html__( '- Select -', 'alchemists' ) => '' ), $performances_equation_array ),
								'holder'      => 'div',
								'description' => esc_html__( 'Select a statistic', 'alchemists' ),
								'admin_label' => true,
							),
						),
						'dependency' => array(
							'element'   => 'customize_detailed_stats_secondary',
							'not_empty' => true,
						),
					),
					vc_map_add_css_animation(),
					array(
						'type'        => 'el_id',
						'heading'     => esc_html__( 'Element ID', 'alchemists' ),
						'param_name'  => 'el_id',
						'description' => esc_html__( 'Enter element ID (Note: make sure it is unique and valid.', 'alchemists' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'alchemists' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'alchemists' ),
					),
					array(
						'type'        => 'css_editor',
						'heading'     => esc_html__( 'CSS box', 'alchemists' ),
						'param_name'  => 'css',
						'group'       => esc_html__( 'Design Options', 'alchemists' ),
					),
				)
			) );


			// ALC: Player Game-by-Game Stats
			vc_map( array(
				'name'        => esc_html__( 'ALC: Player Game-by-Game Stats', 'alchemists' ),
				'base'        => 'alc_player_gbg_stats',
				'icon'        => get_template_directory_uri() . '/admin/images/js_composer/alc_player_gbg_stats.png',
				'category'    => esc_html__( 'ALC', 'alchemists' ),
				'description' => esc_html__( 'Game-by-game stat for player.', 'alchemists' ),
				'params'      => array(
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Widget title', 'alchemists' ),
						'param_name'  => 'title',
						'description' => esc_html__( 'Enter text used as widget title (Note: located above content element).', 'alchemists' ),
						'admin_label' => true,
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Select Calendar', 'alchemists' ),
						'param_name'  => 'calendar',
						'value'       => array(
							esc_html__( 'All', 'alchemists' ) => 'all',
						) + $calendars_array,
						'description' => esc_html__( 'Pick a calendar to display.', 'alchemists' ),
					),
					array(
						'heading'       => esc_html__( 'Display link to view all events', 'alchemists' ),
						'type'          => 'checkbox',
						'param_name'    => 'show_all_events_link',
						'value'         => array(
							esc_html__( 'Yes', 'alchemists' ) => '1'
						),
						'description' => esc_html__( 'Adds a button to all events the widget header.', 'alchemists' ),
						'dependency' => array(
							'element' => 'calendar',
							'value_not_equal_to' => array( 'all' ),
						),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Sort Order', 'alchemists' ),
						'param_name'  => 'order',
						'value'       => array(
							esc_html__( 'DESC', 'alchemists' )    => 'desc',
							esc_html__( 'ASC', 'alchemists' )     => 'asc',
						),
						'description' => esc_html__( 'Select events sorting order.', 'alchemists' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Select Player', 'alchemists' ),
						'param_name'  => 'player_id',
						'value'       => array(
							esc_html__( 'Default', 'alchemists' ) => 'default',
						) + $players_array,
						'description' => esc_html__( 'Select player. (Note: Leave it empty if you place this element on Single Player page).', 'alchemists' ),
					),
					array(
						'type' => 'autocomplete',
						'heading' => esc_html__( 'Player Statistic', 'alchemists' ),
						'param_name' => 'player_stats',
						'settings' => array(
							'multiple' => true,
							'min_length' => 1,
							'groups' => true,
							// In UI show results grouped by groups, default false
							'unique_values' => true,
							// In UI show results except selected. NB! You should manually check values in backend, default false
							'sortable' => true,
							'no_hide' => true,
							'values' => $performances_array
						),
						'param_holder_class' => 'vc_not-for-custom',
						'description' => esc_html__( 'Type player statistic label. (Note: Order can be changed with drag & drop).', 'alchemists' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Number of events to show', 'alchemists' ),
						'param_name'  => 'number',
						'value'       => '5',
						'description' => esc_html__( 'Enter a number of events to show.', 'alchemists' ),
					),
					vc_map_add_css_animation(),
					array(
						'type'        => 'el_id',
						'heading'     => esc_html__( 'Element ID', 'alchemists' ),
						'param_name'  => 'el_id',
						'description' => esc_html__( 'Enter element ID (Note: make sure it is unique and valid.', 'alchemists' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'alchemists' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'alchemists' ),
					),
					array(
						'type'        => 'css_editor',
						'heading'     => esc_html__( 'CSS box', 'alchemists' ),
						'param_name'  => 'css',
						'group'       => esc_html__( 'Design Options', 'alchemists' ),
					),
				)
			) );


			// ALC: Roster Slider
			vc_map( array(
				'name'        => esc_html__( 'ALC: Roster Slider', 'alchemists' ),
				'base'        => 'alc_roster_slider',
				'icon'        => get_template_directory_uri() . '/admin/images/js_composer/alc_roster_slider.png',
				'category'    => esc_html__( 'ALC', 'alchemists' ),
				'description' => esc_html__( 'A slider for team players.', 'alchemists' ),
				'params'      => array(
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Select Player List:', 'alchemists' ),
						'param_name'  => 'player_lists_id',
						'value'       => $player_lists_array,
						'description' => esc_html__( 'Select player list.', 'alchemists' ),
					),
					vc_map_add_css_animation(),
					array(
						'type'        => 'el_id',
						'heading'     => esc_html__( 'Element ID', 'alchemists' ),
						'param_name'  => 'el_id',
						'description' => esc_html__( 'Enter element ID (Note: make sure it is unique and valid.', 'alchemists' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'alchemists' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'alchemists' ),
					),
					array(
						'type'        => 'css_editor',
						'heading'     => esc_html__( 'CSS box', 'alchemists' ),
						'param_name'  => 'css',
						'group'       => esc_html__( 'Design Options', 'alchemists' ),
					),
				)
			) );


			// ALC: Roster Blocks
			vc_map( array(
				'name'        => esc_html__( 'ALC: Roster Blocks', 'alchemists' ),
				'base'        => 'alc_roster_blocks',
				'icon'        => get_template_directory_uri() . '/admin/images/js_composer/alc_roster_blocks.png',
				'category'    => esc_html__( 'ALC', 'alchemists' ),
				'description' => esc_html__( 'Team players blocks.', 'alchemists' ),
				'params'      => array(
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Select Player List:', 'alchemists' ),
						'param_name'  => 'player_lists_id',
						'value'       => $player_lists_array,
						'description' => esc_html__( 'Select player list.', 'alchemists' ),
					),
					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Number of Columns', 'alchemists' ),
						'param_name'  => 'columns',
						'value'       => array(
							esc_html__( '3 columns', 'alchemists' ) => '3',
							esc_html__( '2 columns', 'alchemists' ) => '2',
						),
						'description' => esc_html__( 'Select a number of columns.', 'alchemists' ),
						'admin_label' => true,
					),
					vc_map_add_css_animation(),
					array(
						'type'        => 'el_id',
						'heading'     => esc_html__( 'Element ID', 'alchemists' ),
						'param_name'  => 'el_id',
						'description' => esc_html__( 'Enter element ID (Note: make sure it is unique and valid.', 'alchemists' ),
					),
					array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'alchemists' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'alchemists' ),
					),
					array(
						'type'        => 'css_editor',
						'heading'     => esc_html__( 'CSS box', 'alchemists' ),
						'param_name'  => 'css',
						'group'       => esc_html__( 'Design Options', 'alchemists' ),
					),
				)
			) );


			if ( alchemists_sp_preset('soccer') ) {
				// ALC: Roster Cards
				vc_map( array(
					'name'        => esc_html__( 'ALC: Roster Cards', 'alchemists' ),
					'base'        => 'alc_roster_cards',
					'icon'        => get_template_directory_uri() . '/admin/images/js_composer/alc_roster_cards.png',
					'category'    => esc_html__( 'ALC', 'alchemists' ),
					'description' => esc_html__( 'Team players cards.', 'alchemists' ),
					'params'      => array(
						array(
							'type'        => 'dropdown',
							'heading'     => esc_html__( 'Select Player List:', 'alchemists' ),
							'param_name'  => 'player_lists_id',
							'value'       => $player_lists_array,
							'description' => esc_html__( 'Select player list.', 'alchemists' ),
							'admin_label' => true,
						),
						vc_map_add_css_animation(),
						array(
							'type'        => 'el_id',
							'heading'     => esc_html__( 'Element ID', 'alchemists' ),
							'param_name'  => 'el_id',
							'description' => esc_html__( 'Enter element ID (Note: make sure it is unique and valid.', 'alchemists' ),
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Extra class name', 'alchemists' ),
							'param_name'  => 'el_class',
							'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'alchemists' ),
						),
						array(
							'type'        => 'css_editor',
							'heading'     => esc_html__( 'CSS box', 'alchemists' ),
							'param_name'  => 'css',
							'group'       => esc_html__( 'Design Options', 'alchemists' ),
						),
					)
				) );
			}


		}
	}


	if ( class_exists( 'WPBakeryShortCode' ) ) {

		class WPBakeryShortCode_Alc_Event_Blocks_Sm extends WPBakeryShortCode {
		}

		class WPBakeryShortCode_Alc_Event_Scoreboard extends WPBakeryShortCode {
		}

		class WPBakeryShortCode_Alc_Games_History extends WPBakeryShortCode {
		}

		class WPBakeryShortCode_Alc_Team_Stats extends WPBakeryShortCode {
		}

		class WPBakeryShortCode_Alc_Team_Points_History extends WPBakeryShortCode {
		}

		class WPBakeryShortCode_Alc_Team_Leaders extends WPBakeryShortCode {
		}

		class WPBakeryShortCode_Alc_Staff_Bio_Card extends WPBakeryShortCode {
		}

		class WPBakeryShortCode_Alc_Player_Stats extends WPBakeryShortCode {
		}

		class WPBakeryShortCode_Alc_Player_Gbg_Stats extends WPBakeryShortCode {
		}

		class WPBakeryShortCode_Alc_Roster_Slider extends WPBakeryShortCode {
		}

		class WPBakeryShortCode_Alc_Roster_Blocks extends WPBakeryShortCode {
		}

		if ( alchemists_sp_preset( 'soccer' ) ) {
			class WPBakeryShortCode_Alc_Roster_Cards extends WPBakeryShortCode {
			}
		}

	}

}
