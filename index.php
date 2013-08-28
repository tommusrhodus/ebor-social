<?php 

/*
Plugin Name: Ebor Social
Plugin URI: http://www.madeinebor.com
Description: Super Simple, Retina Ready Social Icons For Your Theme
Version: 1.0
Author: TommusRhodus
Author URI: http://www.madeinebor.com
*/	

//CUSTOM STARTSWITH FUNCTION
function startsWith($haystack, $needle)
{
    return !strncmp($haystack, $needle, strlen($needle));
}

switch( wp_get_theme() ) {

	case('Anchor') :
		require_once( plugin_dir_path( __FILE__ ) .'/themes/anchor.php' );
	break;
		
	default :
		require_once( plugin_dir_path( __FILE__ ) .'/themes/default.php' );
}

//enqueue admin styles
function ebor_social_admin_style() {
	wp_enqueue_style( 'ebor-admin-styles', plugins_url( '/ebor-admin-styles.css' , __FILE__ ) );
}
add_action('admin_print_styles', 'ebor_social_admin_style', 90);

//enqueue standard styles
function ebor_social_style() {
	wp_enqueue_style( 'ebor-styles', plugins_url( '/ebor-styles.css' , __FILE__ ) );
}
add_action('wp_enqueue_scripts', 'ebor_social_style');

// Set-up Action and Filter Hooks
register_uninstall_hook(__FILE__, 'ebor_social_delete_plugin_options');
add_action('admin_init', 'ebor_social_init' );
add_action('admin_menu', 'ebor_social_add_options_page');

// Delete options table entries ONLY when plugin deactivated AND deleted
function ebor_social_delete_plugin_options() {
	delete_option('ebor_social_options');
	delete_option('ebor_social_display_options');
}

// Init plugin options to white list our options
function ebor_social_init(){
	register_setting( 'ebor_social_plugin_options', 'ebor_social_options', 'ebor_social_validate_options' );
	register_setting( 'ebor_social_plugin_display_options', 'ebor_social_display_options', 'ebor_social_validate_display_options' );
}

// Add menu page
function ebor_social_add_options_page() {
	add_utility_page('Ebor Social Options Page', 'Ebor Social', 'manage_options', __FILE__, 'ebor_social_render_form');
}


function ebor_social_validate_options($input) {
	if( get_option('ebor_social_options') ){
		$icons = get_option('ebor_social_options');
		foreach ($icons as $key => $value) {
			$input[$key] = esc_url($input[$key]);
		}
	}
		return $input;
}

function ebor_social_validate_display_options($input) {
	if( get_option('ebor_social_display_options') ){
		$displays = get_option('ebor_social_display_options');
		foreach ($displays as $key => $value) {
			$input[$key] = wp_filter_nohtml_kses($input[$key]);
		}
	}
	return $input;
}