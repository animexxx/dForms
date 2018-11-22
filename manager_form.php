<style>
	.right_align{
		float: right;
		margin-right: 20px;
		font-size: 12px;
	}
	.del {
		color: tomato
	}
	table th.action_t {
		text-align: right;
		padding-right: 20px;
		width: 30%
	}
	th.subm {
		width: 5%
	}
</style>
<?php
//Delete & clear rs
if ($_GET['del_id']) {
	$postid = $_GET['del_id'];
	wp_delete_post($postid);
}
if ($_GET['clone_id']) {
	$postid = $_GET['clone_id'];
	$postObject = get_post($postid);
	$metaE = get_post_meta($postid, 'formElement', true);
	$current_user = wp_get_current_user();
	$my_post = array(
		'post_title' => $postObject->post_title,
		'post_content' => $postObject->post_content,
		'post_status' => 'publish',
		'post_author' => $current_user->ID,
		'post_type' => 'dForm'
	);
	$post_id = wp_insert_post($my_post);
	add_post_meta($post_id, 'formElement', $metaE);
}

if ($_GET['clear_rs']) {
	$postid = $_GET['clear_rs'];
	$comments = get_comments('post_id=' . $postid);
	foreach ($comments as $comment) {
		wp_delete_comment($comment->comment_ID, TRUE);
	}
}
?>
<div class="wrap">
	<h2>List of forms <a class="add-new-h2" href="admin.php?page=add-new-dForm">Add New</a> </h2>
	<table cellspacing="0" class="wp-list-table widefat fixed posts">
		<thead>
			<tr>
				<th>Title Form</th>	
<!--				<th>ShortCode</th>	-->
				<th class="subm"><img src="<?php bloginfo('url') ?>/wp-admin/images/comment-grey-bubble.png" alt="Submissions"></th>
				<th class="action_t">Action</th>
			</tr>
		</thead>

		<tfoot>
			<tr>
				<th>Title Form</th>	
<!--				<th>ShortCode</th>	-->
				<th class="subm"><img src="<?php bloginfo('url') ?>/wp-admin/images/comment-grey-bubble.png" alt="Submissions"></th>
				<th class="action_t">Action</th>
			</tr>
		</tfoot>

		<tbody id="the-list">
			<?php
			$args = array('numberposts' => 100, 'post_type' => 'dForm');
			$lastposts = get_posts($args);
			foreach ($lastposts as $post) : setup_postdata($post);
//		echo '<pre>';
//		var_dump($post);
				?>

				<tr>
					<td><a href="<?php echo get_permalink($post->ID); ?>" class="row-title" target="_blank"><?php echo $post->post_title; ?></a></td>
<!--					<td>[dForm fid=""]</td>-->
					<td class="comments column-comments">
						<div class="post-com-count-wrapper">
							<a class="post-com-count" title="Go to submisstion of this form" href="admin.php?page=submissions&form_id=<?php echo $post->ID; ?>">
								<span><?php echo $post->comment_count ?></span>
							</a>
						</div>
					</td>
					
					<td>
						<a href="?page=dForm-x&del_id=<?php echo $post->ID; ?>" class="right_align del" onclick="return confirm('Delete this form?')">Delete</a>
						<a href="?page=dForm-x&clear_rs=<?php echo $post->ID; ?>" class="right_align cl_rs" onclick="return confirm('Are you sure?')">Clear Submissions</a>
						<a href="?page=dForm-x&clone_id=<?php echo $post->ID; ?>" class="right_align clo">Clone</a>
						<a href="?page=add-new-dForm&formId=<?php echo $post->ID; ?>" class="right_align rs">Edit</a>
					</td>
				</tr>

				<?php
			endforeach;
			wp_reset_postdata();
			?>
		</tbody>
	</table>
</div>