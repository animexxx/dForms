<?php

add_action('wp_ajax_save_form', 'save_form_call_back');
add_action("wp_ajax_nopriv_save_form", "save_form_call_back");

if (!function_exists('save_form_call_back')) :

	function save_form_call_back() {
//		var_dump(urldecode($_POST['html']));
		$current_user = wp_get_current_user();
		$my_post = array(
			'post_title' => trim($_POST['formTitle']) == FALSE ? 'No title' : wp_strip_all_tags($_POST['formTitle']),
			'post_content' => $_POST['html'],
			'post_status' => 'publish',
			'post_author' => $current_user->ID,
			'post_type' => 'dForm'
		);
		if ($_POST['update'] != 0) {
			$my_post['ID'] = $_POST['update'];
			wp_update_post($my_post);
			update_post_meta($_POST['update'], 'formElement', serialize($_POST['formElement']));
		}
		else {
			$post_id = wp_insert_post($my_post);
			add_post_meta($post_id, 'formElement', serialize($_POST['formElement']));
		}

		echo 'ok';
		die();
	}

endif;
?>