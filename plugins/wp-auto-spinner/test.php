<?php

echo ' inserting ...';

//wp-load
require_once('../../../wp-load.php');

// Create post object
$my_post = array(
		'post_title'    => 'test title goes here',
		'post_content'  => 'test content goes here',
		'post_status'   => 'publish',
		'post_author'   => 1
		 
);

// Insert the post into the database
$pid = wp_insert_post( $my_post );

var_dump($pid);


?>