<?php

/**
 * @package dForms
 * @version 1.0
 */
/*
  Plugin Name: dForms
  Plugin URI: http://xemvamua.vn
  Description: Form builder helps you create and publish web forms.
  Author: Duy.nv
  Version: 1.0
  Author URI: http://facebook.com/duynv2
 */
if (!is_admin()) {
	wp_register_style('dForm-style', plugins_url('css/dForm.css', __FILE__));
	wp_enqueue_style('dForm-style');
}

require_once 'save_form.php';

add_action('admin_menu', 'dForm_menu');

function dForm_menu() {
	add_menu_page('dForm Plugin', 'dForm Manager', 'manage_options', 'dForm-x', 'dForm_manager', '', 4);
	add_submenu_page('dForm-x', 'Add new Form', 'Add new', 'manage_options', 'add-new-dForm', 'dForm_options');
	add_submenu_page(null, 'Submissions', 'Submissions', 'manage_options', 'submissions', 'submissions');

	wp_enqueue_script(
		'dForm-js', plugins_url('/js/dForm.js', __FILE__), array('jquery')
	);
	wp_localize_script('dForm-js', 'myAjax', array('ajaxurl' => get_bloginfo('url')));
	wp_enqueue_script('dForm-js');
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jquery-ui-draggable');
	wp_enqueue_script('jquery-ui-droppable');
}

function dForm_manager() {
	require_once 'manager_form.php';
}

function submissions() {
	require_once 'manager_submisstions.php';
}

function dForm_options() {
	if (!current_user_can('manage_options')) {
		wp_die(__('You do not have sufficient permissions to access this page.'));
	}
	wp_register_style('dForm-style', plugins_url('css/dForm.css', __FILE__));
	wp_enqueue_style('dForm-style');


	require_once 'view_form.php';
}

//Add new custom post type
add_action('init', 'create_dForm_type');
if (!function_exists('create_dForm_type')):
	/*
	 * create xemVaMua Post type
	 */

	function create_dForm_type() {
		register_post_type('dForm', array(
			'labels' => array(
				'name' => __('Your Form'),
				'singular_name' => __('dForm')
			),
			'public' => true,
			'show_ui' => false,
			'menu_position' => 4,
			'supports' => array('title', 'author', 'custom-fields', 'comments')
			)
		);
	}

endif;

//Custom post type template from plugin
function get_dForm_template($single_template) {
	global $post;
	if ($post->post_type == 'dform') {
		$single_template = dirname(__FILE__) . '/themefiles/single-dForm.php';
	}
	return $single_template;
}

add_filter("single_template", "get_dForm_template");

//Register shortcode
add_shortcode('dForm', 'dform_view');

function dform_view($fid) {
	extract(shortcode_atts(array(
			'fid' => 'fid'
			), $fid));
	$objectPost = get_post($fid);
	$content = $objectPost->post_content;
	return str_replace('action="','action="'.get_permalink($objectPost->ID),urldecode($content));
}

?>
