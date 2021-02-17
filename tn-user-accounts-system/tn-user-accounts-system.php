<?php

/*
 * Plugin Name: ThirteeNov User Accounts System
 * Description: Just a cool plugin to manage custom user accounts of your website.
 * Version: 1.0.0
 * Author: Habibie
 * Author URI: https://webappdev.my.id/
 * License: GPL2
 * Requires at least: 2.9
 * Requires PHP: 5.2
 * Text Domain: tn-uas
 * Domain Path: /languages
 */
 
//Applying Styles by injecting Admin Header
function tn_uas_adminstyle() {
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url( __FILE__ ) ?>includes/style.css">
    <?php
}
add_action( 'admin_head', 'tn_uas_adminstyle' );

//Applying Frontend Styles
function tn_uas_frontendstyle() {
    ?>
    <link rel="stylesheet" type="text/css" href="<?php echo plugin_dir_url( __FILE__ ) ?>includes/frontendstyle.css">
    <?php
}
add_action( 'wp_head', 'tn_uas_frontendstyle' );
 
//Settings Page
function tn_uas_settings_page(){
	include("includes/generalsettings.php");
}

function tn_uas_settings(){
	add_menu_page('User Accounts System', 'User Accounts System', 'manage_options', 'tn-uas-settings', 'tn_uas_settings_page', 'dashicons-businessman', 99);
}
add_action('admin_menu', 'tn_uas_settings');


//Form Management settings page
function tn_uas_formsettings_page(){
    include("includes/formmanagement.php");
}

function tn_uas_formmanagement_settings() {
  add_submenu_page(
        'tn-uas-settings',
        'Form Management',
        'Form Management',
        'manage_options',
        'tn-uas-formsettings',
        'tn_uas_formsettings_page' );
}
add_action("admin_menu", "tn_uas_formmanagement_settings");

//Shortcodes//

//User Login and Register
function tn_uas_loginregister($atts){
	ob_start();
	include('includes/loginregister.php');
	$content = ob_get_clean();
	return $content;
}
add_shortcode('tn_uas_loginregister' , 'tn_uas_loginregister');

//User Dashboard
function tn_uas_userdashboard($atts){
	ob_start();
	include('includes/userdashboard.php');
	$content = ob_get_clean();
	return $content;
}
add_shortcode('tn_uas_userdashboard' , 'tn_uas_userdashboard');

//PHP SESSION
function tn_uas_sess_start() {
	if (!session_id()){
		session_start();
	}
}
add_action('init','tn_uas_sess_start');