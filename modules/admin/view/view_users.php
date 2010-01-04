<h2>Gestion des utilisateurs</h2>
<?php
	//Display Errors
     if (!empty($error_admin_user)) {
    
            echo '<ul id = "ul_error">'."\n";
    
            foreach($error_admin_user as $e) {
    
                    echo '	<li>'.$e.'</li>'."\n";
            }
    
            echo '</ul>';
    } 
    //Display Messages of confirmation
    if (!empty($msg_confirm)) {
    
            echo '<ul id = "ul_msg_confirm">'."\n";
    
            foreach($msg_confirm as $msg) {
    
                    echo '	<li>'.$msg.'</li>'."\n";
            }
    
            echo '</ul>';
    }

?>


<table id='table_users'><tbody>
	<tr id='table_users_title'>
		<td>ID</td>
		<td>pseudo</td>
		<td>mail</td>
		<td>balance</td>
		<td>validé</td>
		<td>action</td>
	</tr>
	<?php	
		foreach($tbx as $key => $value)
		{
			if($key%2!=0){echo '<tr id=\'tbl_users_row1\'>';}else{echo '<tr>';} //Altern color for each line
			echo '<td>'.$tbx[$key]['user_id'].'</td>';
			echo '<td>'.$tbx[$key]['user_pseudo'].'</td>';
			echo '<td>'.$tbx[$key]['user_mail'].'</td>';
			echo '<td>'.$tbx[$key]['user_balance'].'</td>';
			if(!empty($tbx[$key]['hash_validation'])) //if user has not validate his account
			{
				echo '<td id = "id_error">'.'Non validé'.'</td>';
			}else
			{
				echo '<td id = "id_valid">'.'Validé'.'</td>';
				}
			
			echo '<td>';
			echo "<a href=\"index.php?module=admin&amp;action=delete_user&amp;uid=".$tbx[$key]['user_id']."\""."><img src=\"".PATH_IMAGE_RESSOURCE."delete.png"."\"></a>&nbsp;";
			echo "<a href=\"index.php?module=admin&amp;action=valid_user&amp;hash_validation=".$tbx[$key]['hash_validation']."\""."><img src=\"".PATH_IMAGE_RESSOURCE."valid.png"."\"></a>&nbsp;";
			echo "<a href=\"index.php?module=admin&action=edit_user&uid=".$tbx[$key]['user_id']."\""."><img src=\"".PATH_IMAGE_RESSOURCE."edit.png"."\"></a>&nbsp;";
			echo '</td>';
			?>
			</td></tr>
		<?php }
	

		?>
</tbody></table>
