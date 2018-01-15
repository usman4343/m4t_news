<?php
/**
 * Visual Composer Templates
 *
 * @author    Dan Fisher
 * @package   Alchemists
 * @version   2.0.3
 */


/**
 * Check Visual Composer templates in folder and load as default templates
 */

 add_filter( 'vc_load_default_templates', 'alchemists_load_custom_vc_templates' );
 function alchemists_load_custom_vc_templates( $vc_data ) {
   global $wp_filesystem;

   if ( empty( $wp_filesystem ) ) {
     require_once( ABSPATH . '/wp-admin/includes/file.php' );
     WP_Filesystem();
   }

   $vc_data           = array();
   $tpl_files_pattern = get_template_directory() . '/inc/vc_templates/*.tpl';
   $tpl_files         = glob( $tpl_files_pattern );
   array_multisort( array_map( 'filemtime', $tpl_files ), SORT_NUMERIC, SORT_DESC, $tpl_files );

   foreach ( $tpl_files as $file ) {

     $filename_pre = explode( '.', basename( $file ) );
     $filename     = reset( $filename_pre );

     $data                 = array();
     $data['category']     = esc_html__( 'Alchemists Theme', 'alchemists' );
     $data['name']         = '[ALC] ' . ucfirst( str_replace( array( '-', '_' ), ' ', $filename ) );
     $data['custom_class'] = 'alc_tpl_' . str_replace( array( '-', '_' ), '_', $filename );
     $data['content']      = $wp_filesystem->get_contents( $file );

     array_unshift( $vc_data, $data );
   }

   return $vc_data;
 }
