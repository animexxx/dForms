<?php if (isset($_GET['submit'])): ?>
    <center>
        <h1>Thank You !</h1><br/>
    </center>
    <?php

    exit();
endif;

if (isset($_POST) && $_POST) :
    $metaE = unserialize(get_post_meta(get_the_ID(), 'formElement', true));


    $element = array();
    foreach ($metaE as $formElement):

        if (is_array($formElement)) {
            $data_matrix = array();
            foreach ($formElement[0] as $name_) {

                $elementValue = $_POST[str_replace('[]', '', $name_)];
                $data_matrix[] = array($name_, $elementValue);
            }
            $element[$formElement[3]] = $data_matrix;

        } else {

            $title_f = explode('|', $formElement);
            $elementValue = $_POST[str_replace('[]', '', $title_f[1])];

            if ($title_f[2] == 'require' && !$elementValue) {
                $err_require = TRUE;
                goto nosave_err;
            }

            //If value equal other_textbox then get other textbox value
            if ($elementValue == 'other_textbox') {
                $elementValue = $_POST[$title_f[1] . '_other'];
            }

            $element[$title_f[1]] = $elementValue;


        }
    endforeach;


    $time = current_time('mysql');

    $data = array(
        'comment_post_ID' => get_the_ID(),
        'comment_content' => serialize($element),
        'comment_parent' => 0,
        'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
        'comment_date' => $time,
        'comment_approved' => 1,
    );
    wp_insert_comment($data);
    wp_redirect(add_query_arg('submit', 'success', get_permalink()), 301);
    exit();
endif;
nosave_err:
?>