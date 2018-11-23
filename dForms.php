<?php
/*
  Plugin Name: dForms
  Plugin URI: http://i-devso.com
  Description: Form builder helps you create and publish web forms.
  Author: Duy.nv
  Version: 1.1
  Author URI: http://facebook.com/duynv2
 */

/*
 * Define common variables
 * */
define('dForms__PLUGIN_DIR', plugin_dir_path(__FILE__));
define('dForms__PLUGIN_URL', plugin_dir_url(__FILE__));

/*
 * Include file
 * */
require_once 'inc/dForms_class.php';

/*
 * Hook plugin to Wordpress admin
 * */
add_action('init', array('dForms', 'getInstance'));
//hook admin assets
add_action('admin_enqueue_scripts', array('dForms', 'add_assets'));
//hook front css
add_action('wp_enqueue_scripts', array('dForms', 'add_front_assets'));
//hook ajax admin process
add_action('wp_ajax_save_form', array('dForms', 'save_form_call_back'));
add_action("wp_ajax_nopriv_save_form", array('dForms', 'save_form_call_back'));
//filter template
add_filter("single_template", array('dForms', 'get_dForm_template'));
//Register short-code
add_shortcode('dForm', array('dForms', 'dform_view'));

//hook admin menu
add_action('admin_menu', 'admin_menu');

/*
* Define admin menu
*
* */
function admin_menu()
{
    //Check permission of user
    if (!current_user_can('manage_options')) {
        return;
    }
    //Add admin menu
    add_menu_page('dForm Plugin', 'dForm Manager', 'manage_options', 'dForm-x', 'dForm_manage', '', 4);
    add_submenu_page('dForm-x', 'Add new Form', 'Add new', 'manage_options', 'add-new-dForm', 'dForm_add');
    add_submenu_page(null, 'Submissions', 'Submissions', 'manage_options', 'submissions', 'dForm_submissions');
}

/*
 * Manage form menu content
 *
 * */
function dForm_manage()
{
    require_once 'inc/dForm_manage.php';
}

/*
 * Submission result menu content
 *
 * */
function dForm_submissions()
{
    require_once 'inc/dForm_submissions.php';
}

/*
 * Add new form menu content
 *
 * */
function dForm_add()
{
    require_once 'inc/dForm_add.php';
}

?>
