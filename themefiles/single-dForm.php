<?php

//Form validate variable
$err_require = FALSE;
the_post();
//submit process
require_once 'save_submit_view_thankyou.php';

$content = get_the_content();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <title><?php wp_title('|', true, 'right'); ?> dForm</title>
    <?php wp_head(); ?>
</head>

<body>

<div id="dform_page_content">
    <?php
    //Check form validate
    if ($err_require) {
        echo '<div class="err">Please enter all require field !</div>';
    }

    echo urldecode($content);
    ?>
</div><!--End page_content-->

<?php wp_footer(); ?>
</body>
</html>
