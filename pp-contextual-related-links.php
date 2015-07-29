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

register_uninstall_hook(__FILE__, 'pp_contextual_related_links_uninstall');

// if uninstalling - remove options
function pp_contextual_related_links_uninstall() {
	delete_option('contextual_related_links_banned_tags');
	delete_option('contextual_related_links_include_tags');
	delete_option('contextual_related_links_links_type');
	delete_option('contextual_related_links_links_where');
}

add_action('admin_menu', 'pp_contextual_related_links_setup_menu');
add_action('admin_enqueue_scripts', 'pp_css_contextual_related_links');
if(get_option('contextual_related_links_links_type')==1){
	add_filter('the_content', 'pp_contextual_related_links_tags');
}elseif(get_option('contextual_related_links_links_type')==2){
	add_filter('the_content', 'pp_contextual_related_links_related_tags');
}else{
	add_filter('the_content', 'pp_contextual_related_links_related_posts_with_tags');
}

function pp_css_contextual_related_links(){
	wp_enqueue_style('contextual-related-links-style', plugins_url('style.css', __FILE__));
}

function pp_contextual_related_links_setup_menu(){
	include 'pp-options.php';
	add_menu_page('Contextual Related Links', 'Contextual Related Links', 'administrator', 'crlset', 'contextual_related_links_settings');
	add_action( 'admin_init', 'register_contextual_related_links_settings' );
}

function register_contextual_related_links_settings() {
	register_setting( 'contextual-related-links-settings-group', 'contextual_related_links_banned_tags');
	register_setting( 'contextual-related-links-settings-group', 'contextual_related_links_include_tags');
	register_setting( 'contextual-related-links-settings-group', 'contextual_related_links_links_type');
	register_setting( 'contextual-related-links-settings-group', 'contextual_related_links_links_where');
	register_setting( 'contextual-related-links-settings-group', 'contextual_related_links_links_how_many');
}

?>