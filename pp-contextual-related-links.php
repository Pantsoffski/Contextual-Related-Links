<?php
/*
Plugin Name: Contextual Related Links
Plugin URI: http://smartfan.pl/
Description: Plugin that put links in posts content to other related posts.
Author: Piotr Pesta
Version: 0.1
Author URI: http://smartfan.pl/
License: GPL12
*/

include "functions.php";

add_action('admin_menu', 'pp_contextual_related_links_setup_menu');
add_action('admin_enqueue_scripts', 'pp_css_contextual_related_links');
add_filter( 'the_content', 'pp_contextual_related_links_related_tags2' );

function pp_css_contextual_related_links(){
	wp_enqueue_style('contextual-related-links-style', plugins_url('style.css', __FILE__));
}

function pp_contextual_related_links_setup_menu(){
	include 'pp-options.php';
	add_menu_page('Contextual Related Links Options', 'Contextual Related Links Options', 'administrator', 'acset', 'contextual_related_links_settings');
	add_action( 'admin_init', 'register_contextual_related_links_settings' );
}

function register_contextual_related_links_settings() {
	register_setting( 'contextual_related_links_settings_group', 'contextual_related_links_settings');
}

?>