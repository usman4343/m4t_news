<?php
/**
 * Install demos page
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
class ODI_Install_Demos {

	/**
	 * Start things up
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_page' ), 11 );
	}

	/**
	 * Add sub menu page for the custom CSS input
	 *
	 * @since 1.0.0
	 */
	public function add_page() {
		add_submenu_page(
			'oceanwp-panel',
			esc_html__( 'Install Demos', 'ocean-demo-import' ),
			esc_html__( 'Install Demos', 'ocean-demo-import' ),
			'manage_options',
			'oceanwp-panel-install-demos',
			array( $this, 'create_admin_page' )
		);
	}

	/**
	 * Settings page output
	 *
	 * @since 1.0.0
	 */
	public function create_admin_page() {

		// Vars
		$ocean_url 	= 'https://oceanwp.org/';
		$demos 		= ODI_Importer::get_data();
		$brand 		= oceanwp_theme_branding(); ?>

		<div id="odi-demo-wrap" class="wrap">

			<h2><?php echo esc_attr( $brand ); ?> - <?php esc_attr_e( 'Install Demos', 'ocean-demo-import' ); ?></h2>

			<div class="updated error importer-notice importer-notice-1" style="display: none;">

				<p><?php esc_attr_e( 'We&rsquo;re sorry but the demo data could not be imported. It is most likely due to low PHP configurations on your server. You need to import the demo manually, look the second method from this article of the documentation:', 'ocean-demo-import' ); ?> <a href="http://docs.oceanwp.org/article/52-importing-the-sample-data/#manual-installation" target="_blank"><?php esc_attr_e( 'Importing the sample data', 'ocean-demo-import' ); ?></a></p>

			</div>

			<div class="updated importer-notice importer-notice-2" style="display: none;">

				<p><?php echo sprintf( esc_html__( 'Demo data successfully imported. Please check your page and make sure that everything has imported correctly. If it did, you can deactivate the %1$sOcean Demo Import%2$s plugin, because it has done its job.', 'ocean-demo-import' ), '<strong>', '</strong>' ); ?></p>

			</div>

			<div class="updated error importer-notice importer-notice-3" style="display: none;">

				<p><?php esc_attr_e( 'We&rsquo;re sorry but the demo data could not be imported. It is most likely due to low PHP configurations on your server. You need to import the demo manually, look the second method from this article of the documentation:', 'ocean-demo-import' ); ?> <a href="http://docs.oceanwp.org/article/52-importing-the-sample-data/#manual-installation" target="_blank"><?php esc_attr_e( 'Importing the sample data', 'ocean-demo-import' ); ?></a></p>

			</div>

			<div class="odi-important-notice notice notice-warning">

				<p><?php echo sprintf( esc_html__( 'Before you begin, make sure all the required plugins are activated. %1$sSee this article%2$s.', 'ocean-demo-import' ), '<a href="http://docs.oceanwp.org/article/52-importing-the-sample-data#plugins" target="_blank">', '</a>' ); ?></p>

			</div>

			<div class="odi-about-description">

				<?php
				if ( is_plugin_active( 'wordpress-database-reset/wp-reset.php' ) ) {
					$plugin_link 	= admin_url( 'tools.php?page=database-reset' );
				} else {
					$plugin_link 	= admin_url( 'plugin-install.php?s=Wordpress+Database+Reset&tab=search' );
				} ?>

				<p><?php echo sprintf( esc_html__( 'Importing demo data ( post, pages, images, customizer settings, ... ) is the easiest way to setup your theme. It will allow you to quickly edit everything instead of creating content from scratch. We recommend uploading sample data on a clean installation to prevent conflicts with your current content. You can use this plugin to reset your site if needed: %1$sWordpress Database Reset%2$s.', 'ocean-demo-import' ), '<a href="'. $plugin_link .'" target="_blank">', '</a>' ); ?></p>

			</div>

			<hr>

			<div class="theme-browser rendered">

				<?php
				// Categories
				$categories = ODI_Importer::get_all_categories( $demos ); ?>

				<?php if ( ! empty( $categories ) ) : ?>
					<div class="odi-header-bar">
						<nav class="odi-navigation">
							<ul>
								<li class="active"><a href="#all" class="odi-navigation-link"><?php esc_html_e( 'All', 'ocean-demo-import' ); ?></a></li>
								<?php foreach ( $categories as $key => $name ) : ?>
									<li><a href="#<?php echo esc_attr( $key ); ?>" class="odi-navigation-link"><?php echo esc_html( $name ); ?></a></li>
								<?php endforeach; ?>
							</ul>
						</nav>
						<div clas="odi-search">
							<input type="text" class="odi-search-input" name="odi-search" value="" placeholder="<?php esc_html_e( 'Search demos...', 'ocean-demo-import' ); ?>">
						</div>
					</div>
				<?php endif; ?>

				<div class="themes wp-clearfix">

					<?php
					// Loop through all demos
					foreach ( $demos as $demo => $key ) { ?>

						<div class="theme-wrap" data-categories="<?php echo esc_attr( ODI_Importer::get_item_categories( $key ) ); ?>" data-name="<?php echo esc_attr( strtolower( $demo ) ); ?>">

							<div class="theme">

								<div class="theme-screenshot odi-install" data-demo-id="<?php echo esc_attr( $demo ); ?>">
									<img src="https://raw.githubusercontent.com/oceanwp/oceanwp-sample-data/master/<?php echo esc_attr( $demo ); ?>/preview.jpg" />

									<div class="demo-import-loader preview-all preview-all-<?php echo esc_attr( $demo ); ?>"></div>

									<div class="demo-import-loader preview-icon preview-<?php echo esc_attr( $demo ); ?>"><i class="dashicons dashicons-update"></i></div>

									<div class="demo-import-loader success-icon success-<?php echo esc_attr( $demo ); ?>"><i class="dashicons dashicons-yes"></i></div>

									<div class="demo-import-loader warning-icon warning-<?php echo esc_attr( $demo ); ?>"><i class="dashicons dashicons-warning"></i></div>
								</div>

								<div class="theme-id-container">
		
									<h2 class="theme-name" id="<?php echo esc_attr( $demo ); ?>"><span><?php echo ucwords( $demo ); ?></span></h2>

									<div class="theme-actions">
										<a class="button button-secondary odi-install" data-demo-id="<?php echo esc_attr( $demo ); ?>" href="#"><?php _e( 'Install', 'ocean-demo-import' ); ?></a>
										<a class="button button-primary" href="https://<?php echo esc_attr( $demo ); ?>.oceanwp.org/" target="_blank"><?php _e( 'Preview', 'ocean-demo-import' ); ?></a>
									</div>
								</div>

							</div>

						</div>

					<?php } ?>

				</div>

			</div>

		</div>

	<?php }
}
new ODI_Install_Demos();