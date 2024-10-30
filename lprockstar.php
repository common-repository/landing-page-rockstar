<?php
/*
Plugin Name: Landing Page Rockstar
Plugin URI: http://www.lprockstar.com
Description: Easily create Wordpress landing pages and optin pages for your website.
Version: 0.6
Author: Eric Sloan
Author URI: http://www.ericsestimate.com
License: GPL2

    Copyright 2013  Eric Sloan  (email : eric@ericsestimate.com)

    This software is released under GPL. Once purchased feel free to modify it as you see fit.
    If you end up using some of my code a quick mention of me is very appreciated :)
    
    Special thanks to:
    
    Wordpress.org
    The fine folks who wrote the meta box script:
    Andrew Norcross (@norcross / andrewnorcross.com)
    Jared Atchison (@jaredatch / jaredatchison.com)
    Bill Erickson (@billerickson / billerickson.net)
    Justin Sternberg (@jtsternberg / dsgnwrks.pro)

*/

// add_theme_support( 'post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'audio', 'chat', 'video')); // Add 3.1 post format theme support.

define('LPRS_DIR',plugin_dir_url( __FILE__ ));

require_once("includes/metaboxes.php");

require_once("metabox/init.php");

require_once("class/admin.php");
require_once("class/form-parser.php");


$lprs_plugin = new lprs_init();

// flush the permalinks on activation of the plugin
    
register_activation_hook( __FILE__, array($lprs_plugin,'lprs_activated') );


// Change landing page title text


function dashboard_widget_function() {
	//echo file_get_contents('http://www.lprockstar.com/includefiles/generalad.php');
}

function add_dashboard_widgets() {
	//wp_add_dashboard_widget('dashboard_widget', 'Landing Page Rockstar', 'dashboard_widget_function');
}
add_action('wp_dashboard_setup', 'add_dashboard_widgets' );