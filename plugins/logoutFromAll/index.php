<?php
/*
Plugin Name: Logout from All
Description: Logs out users from //mining4truth.com & news.mining4truth.com
Version: 0.0.1
Author: Muhammad Adeel
Author URI: http://tech.digital
*/

add_action("wp_login", "td_custom_login");
function td_custom_login($user_login) {
	$url = "https://mining4truth.com/mirror_logins.php";
	wp_redirect($url . "?user=" . $user_login);
	exit;
}

add_action("wp_logout", "td_custom_logout");
function td_custom_logout() {
	$url = "http://mining4truth.com/mirror_logins.php?logout=1";
	//wp_redirect($url);
	//exit;
}	