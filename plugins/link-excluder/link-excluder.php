<?php

/*
Plugin Name: Link Excluder
Plugin URI:  http://localhost:8888/
Description: The Plugin that exclude the urls from the post links
Version:     1.0
Author:      Waqas Chughtai 
Author URI:  https://developer.wordpress.org/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: link-excluder
*/
/* !1. HOOKS */

// 1.1
// hint: registers all our custom shortcodes on init
// 1.2
// load external files to public website


add_action('init', 'mine_register_shortcodes');

function mine_register_shortcodes()
  {
  add_shortcode('showpost1','delete1');
 }
function delete1()
{
	  $posts_query = new WP_Query( array(
        'post_type' => 'post',
        'posts_per_page' => '5',
        'post_status' => 'published',
        'orderby' => 'title',
        'order'   => 'ASC'
    ) );
        $line_break = '<br />';
        while ( $posts_query->have_posts() ):

            $posts_query->the_post();
            $links  = get_permalink().$line_break;
//var_dump( get_the_ID()); die;
          //if(preg_match('~^http://localhost.*~', get_permalink()) > 1) {
  //        	var_dump( wp_delete_post(get_the_ID()) );
         // }
            $counter++;

        endwhile;
        return $links;

}


function excluder_urls_nav(){

    add_options_page( 'URLs Excluder', 'URLs Excluder', 'manage_options', 'external-links-settings', 'include_settings_page_excluder' );

}


add_action( 'admin_menu', 'excluder_urls_nav' );



function include_settings_page_excluder(){

    include(plugin_dir_path(__FILE__) . 'external-links-settings.php');

}

/* !4. EXTERNAL SCRIPTS */

// 4.1
// hint: loads external files into PUBLIC website

       