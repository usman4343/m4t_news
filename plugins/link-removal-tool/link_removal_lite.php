<?php

    /*
    Plugin Name: Link Remover Lite
    Plugin URI:
    Description: Remove or replace any word/phrase or URL quickly and easily throughout your entire site.
    Version: 1.6.3
    Author: Outsourcing Exposed
    Author URI: http://www.outsourcingexposed.com
    */

    /*  Copyright 2010  Outsourcing Exposed
    */
    // The text domain for strings localization
    define( 'LINKREM_TEXT_DOMAIN', 'link-removal-tool-lite' );

    /**
    * Load translate textdomain file.
    */
    function pclaen_load_textdomain() {
        load_plugin_textdomain( LINKREM_TEXT_DOMAIN, false, dirname( __FILE__ ) . '/languages/' );
    }

    add_action( 'plugins_loaded', 'pclaen_load_textdomain' );

    // Hook for adding admin menus
    add_action('admin_menu', 'pclaen_add_pages');

    // action function for above hook
    function pclaen_add_pages() {
        // Add a new top-level menu:
        $pclaen_page = add_menu_page( 'Link Remover Lite', 'Link Remover Lite', 'administrator', 'link-removal-lite', 'pclaen_page', plugins_url( 'link_removal_lite_brush.png' , 'link-removal-tool-lite/link_removal_lite.php' ) );

        wp_register_style( 'pclaen_Stylesheet', plugins_url( 'link_removal_lite_style.css' , 'link-removal-tool-lite/link_removal_lite.php' ) );
        wp_enqueue_style( 'pclaen_Stylesheet' );

    }


    function pclaen_page() {
        include( 'link_removal_lite_page.php' );
    }


    function pclaen_all_posts_check() {
      // do something with the post data
        global $wpdb;

        $sql = "SELECT * FROM $wpdb->posts WHERE post_parent=0";
        $wpdb->query( $sql );
        $posts = $wpdb->last_result;

        $posts = ( array ) $posts;;

        $searchText = $_POST['pclaen_searchText'];

        $urlsdel = 0;
        $postIsChange = 0;

        foreach( $posts as $post ) {

            $stroke = preg_quote( $searchText, "/" );

            if( ( preg_match( '/<a.*?href=[\'"](.*?)' . $stroke . '(.*?)["\'][^>]*?>.*?<\/a>/im',  $post->post_content ) ) ) {
                $post->post_content = preg_replace( '/(<a.*?href=[\'"])(.*?)' . $stroke . '(.*?)(["\'][^>]*?>(.*?)<\/a>)/im', "$5", $post->post_content );
                $postIsChange = 1;
                $urlsdel++;
            }
            if( ( get_post( $post->ID ) != NULL ) AND $postIsChange == 1 ) {

                $wpdb->query( "UPDATE ". $wpdb->posts . " SET post_content = '". mysql_escape_string($post->post_content) . "' WHERE ID = " . $post->ID . "" );

            }

            $postIsChange = 0;

        }
        $answer = "<br /> Deleted URLs: "  . $urlsdel . "<br />";
        return $answer;
    }

?>