<?php

class dForms
{
    /*
     * Instance
     *
     * @var object
     * */
    private static $instance;

    /*
     * Create instance
     *
     * */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /*
     * CONSTRUCT
     *
     * Create custom post type
     *
     * */

    public function __construct()
    {
        $this->add_post_type();
    }

    /*
     * Add custom post type support for plugins
     *
     * */
    public function add_post_type()
    {
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


    /*
     * Add assets to admin
     *
     * */
    public static function add_assets()
    {
        //js file
        wp_register_script(
            'dForm-js', dForms__PLUGIN_URL . '/js/dForm.js', array('jquery')
        );
        wp_localize_script('dForm-js', 'myAjax', array('ajaxurl' => get_bloginfo('url')));
        wp_enqueue_script('dForm-js');

        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('jquery-ui-draggable');
        wp_enqueue_script('jquery-ui-droppable');

        //css file
        wp_register_style('dForm-style', dForms__PLUGIN_URL . 'css/dForm.css');
        wp_enqueue_style('dForm-style');
    }

    /*
     * Add assets to front
     *
     * */
    public static function add_front_assets()
    {
        //css file
        wp_register_style('dForm-front-style', dForms__PLUGIN_URL . 'css/dForm_front.css');
        wp_enqueue_style('dForm-front-style');
    }

    /*
     * AJAX Save Form
     *
     * */
    public static function save_form_call_back()
    {
        //Get current user information
        $current_user = wp_get_current_user();

        //Prepare post to save
        $my_post = array(
            'post_title' => trim($_POST['formTitle']) == FALSE ? 'No title' : wp_strip_all_tags($_POST['formTitle']),
            'post_content' => $_POST['html'],
            'post_status' => 'publish',
            'post_author' => $current_user->ID,
            'post_type' => 'dForm'
        );

        if ($_POST['update'] != 0) {
            //UPDATE
            $my_post['ID'] = $_POST['update'];
            wp_update_post($my_post);
            update_post_meta($_POST['update'], 'formElement', serialize($_POST['formElement']));
        } else {
            //ADD NEW
            $post_id = wp_insert_post($my_post);
            add_post_meta($post_id, 'formElement', serialize($_POST['formElement']));
        }

        echo 'ok';
        die();
        //End
    }

    /*
     * Filter template for dForm post type
     *
     * @param string $single_template template path
     * */
    public static function get_dForm_template($single_template)
    {
        global $post;
        //edit template only for dForm post type
        if ($post->post_type == 'dform') {
            $single_template = dForms__PLUGIN_DIR . '/themefiles/single-dForm.php';
        }
        return $single_template;
    }

    /*
     * Short-code for front-end
     *
     * @param int $fid form id
     * */
    public static function dform_view($fid)
    {
        extract(shortcode_atts(array(
            'fid' => 'fid'
        ), $fid));
        $objectPost = get_post($fid);
        $content = $objectPost->post_content;
        return str_replace('action="', 'action="' . get_permalink($objectPost->ID), urldecode($content));
    }
}