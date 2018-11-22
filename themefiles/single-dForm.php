<?php
$err_require = FALSE;
the_post();
require_once 'save_submit_view_thankyou.php';
$content = get_the_content();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <title><?php wp_title('|', true, 'right'); ?> dForm</title>
		<?php wp_head(); ?>
		<style>
			h1{ font-weight: bold !important;font-size: 20px  !important}
			#page_content{
				width: 800px;
				margin: 0 auto;
			}
			#page_content .option_element,
			#page_content .remove_element{

				display: none !important;
			}
			#page_content .dFormElement {
				border: none
			}
			.err {
				color: red;
			}
			body{
				font-family: sans-serif;
				font-size: 12px;
				background: #e2e2e2;
			}
			select {
				width: 150px !important;
			}
			textarea {
				width: 300px !important;
				height: 100px;
			}
			table {
				color: #6E5757 !important;
				font-family: 'Verdana';
				padding-top: 10px;
				width: 100% !important;
			}
			table th{
				background: none repeat scroll 0 0 #DDDDDD;
				border: 1px solid #CCCCCC;
				padding: 5px !important;
			}
			table td{
				background: none repeat scroll 0 0 #F5F5F5;
				border: 1px solid #CCCCCC;
			}
			ul{
				list-style: none;
				padding: 0;
				margin: 0;
			}
			ul li{

			}
		</style>

  </head>
  <body>


		<div id="page_content">
			<?php
			if ($err_require) {
				echo '<div class="err">Please enter all require field !</div>';
			}

			echo urldecode($content);
			?>
		</div><!--End page_content-->

		<?php wp_footer(); ?>
	</body>
</html>
