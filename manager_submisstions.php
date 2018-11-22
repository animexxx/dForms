<style>
	#submisstion_d{
		height: 200px;
		overflow: auto;
		width: 100%
	}
	#submisstion_t tr.active td{
		background: #ccc;
	}
	#submisstion_t{
		margin-top: 10px;
	}
	#submisstion_t thead tr{

	}
	#submisstion_t_detail{
		margin-top: 20px;
	}
	#submisstion_t_detail td.data_s {
		width: 70%;
		background: #eee;

	}
	b {
		color:#21759B
	}
	#submisstion_t td,
	#submisstion_t table td,
	#submisstion_t table th{
		font-size: 10px
	}
	#submisstion_t table th{
		padding: 0;
	}
	#submisstion_t .widefat th{
		text-align: center
	}
</style>
<?php
if (isset($_GET['form_id'])):
	$comments = get_comments('post_id=' . $_GET['form_id']);
	$metaE = unserialize(get_post_meta($_GET['form_id'], 'formElement', true));
	?>
	<div id="submisstion_d">
		<table  id="submisstion_t" class="widefat">
			<thead>
				<tr>
					<th>Date time</th>
					<th>Author IP</th>
					<?php foreach ($metaE as $formElement): ?>
						<th>
							<?php
							if (is_array($formElement)) {
								echo $formElement[2];
							}
							else {
								$title_f = explode('|', $formElement);
								echo $title_f[0];
							}
							?>
						</th>

					<?php endforeach; ?>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($comments as $comment) :
					$content_submiss = unserialize($comment->comment_content);
					?>
					<tr>
						<td><?php echo  $comment->comment_date ?></td>
						<td><?php echo  $comment-> comment_author_IP  ?></td>
						<?php
						$i = -1;
						foreach ($content_submiss as $key => $value): $i++;
							?>
							<td><?php
				if ($key == 'matrix') {
					//Matrix
					if (is_array($metaE[$i])) {
						$dataRows = $metaE[$i][1][0];
						$dataColumns = $metaE[$i][1][1];
						echo gen_table_html($dataRows, $dataColumns, $value);
					}
				}
				else {

					$data_vl = explode('|', $metaE[$i]);
					//Checkbox
					if (is_array($value)) {
						$value_r = array();
						foreach ($value as $vl) {
							$value_r[] = '<b>' . $vl . ' - Yes</b>';
						}
						echo str_replace($value, $value_r, nl2br($data_vl[3]));
					}
					else {
						if (trim($data_vl[3])) {
							if (!in_array($value, explode("\n", $data_vl[3]))) {
								echo nl2br($data_vl[3]);
								echo '<br/><b>' . $value . ' - Other value</b>';
							}
							else {
								echo str_replace($value, '<b>' . $value . ' - Yes</b>', nl2br($data_vl[3]));
							}
						}
						else {
							echo nl2br($value);
						}
					}
				}
							?></td>
						<?php endforeach; ?>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table></div>

	<table id="submisstion_t_detail" class="widefat">
		<tr>
			<th>Date Time</th>
			<td class="data_s"></td>
		</tr>
		<tr>
			<th>Author IP</th>
			<td class="data_s"></td>
		</tr>
		<?php foreach ($metaE as $formElement): ?>
			<tr>
				<th>
					<?php
					if (is_array($formElement)) {
						echo $formElement[2];
					}
					else {
						$title_f = explode('|', $formElement);
						echo $title_f[0];
					}
					?>
				</th>
				<td class="data_s"></td>
			</tr>
		<?php endforeach; ?>
	</table>
	<?php
endif;

function gen_table_html($dataRows, $dataColumns, $value) {
	$dataRows = explode("\n", $dataRows);
	$dataColumns = explode("\n", $dataColumns);

	$html_ = '';
	$html_ .= '<table cellspacing="0" cellpadding="4"><tr><th style="border:none">&nbsp;</th>';
	$width_percent = 100 / (count($dataRows) + 1);
	foreach ($dataRows as $dtrow) {
		$html_ .= '<th style="width:' . $width_percent . '%">' . $dtrow . '</th>';
	}
	$html_ .= '</tr><tr>';


	$temp = array();
	foreach ($value as $vl) {
		if (is_array($vl[1])) {
			//Checkbox
			$temp[] = $vl[1];
		}
		else {
			//Radio
			$temp[] = $vl[1];
		}
	}

	$i = 0;
	foreach ($dataColumns as $dtcolumns) {
		$html_ .= '<th align="left">' . $dtcolumns . '</th>';


		foreach ($dataRows as $dtrow) {

			if (is_array($temp[$i]) && in_array($dtrow, $temp[$i])) {
				$html_ .= '<td align="center"><b>Yes</b></td>';
			}
			else if ($temp[$i] == $dtrow) {
				$html_ .= '<td align="center"><b>Yes</b></td>';
			}
			else {
				$html_ .= '<td align="center">-</td>';
			}
		}
		$i++;
		$html_ .= '</tr><tr>';
	}

	$html_ .= '</table>';
	return $html_;
}
?>