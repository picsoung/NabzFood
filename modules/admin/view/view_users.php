<table id='table_users'><tbody>
	<tr id='table_users_title'>
		<td>ID</td>
		<td>pseudo</td>
		<td>mail</td>
		<td>balance</td>
	</tr>
	<?php	
		foreach($tbx as $key => $value)
		{
			if($key%2!=0){echo '<tr id=\'tbl_users_row1\'>';}else{echo '<tr>';} //Altern color for each line
			echo '<td>'.$tbx[$key]['user_id'].'</td>';
			echo '<td>'.$tbx[$key]['user_pseudo'].'</td>';
			echo '<td>'.$tbx[$key]['user_mail'].'</td>';
			echo '<td>'.$tbx[$key]['user_balance'].'</td>';
			echo '<td>'.$form_user.'</td>';
			?>
			</td></tr>
		<?php }
	
	$form_user->add('Submit','submit');
	echo $form_user;

		?>
</tbody></table>
