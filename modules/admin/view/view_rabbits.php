<?php
    require_once("global/menu_admin.php");
	
    $menu = display_menu_admin();
    echo $menu;
    
?>
<h2>Gestion des lapins</h2>
<?php
	//Display Errors
     if (!empty($error_admin_nabz)) {
    
            echo '<ul id = "ul_error">'."\n";
    
            foreach($error_admin_nabz as $e) {
    
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

<table id='table_rabbits'><tbody>
	<tr id='table_rabbits_title'>
		<td>ID</td>
		<td>Nom</td>
		<td>faim</td>
		<td>soif</td>
		<td>santé</td>
		<td>action</td>
	</tr>
	<?php	
		foreach($tbx as $key => $value)
		{
			if($key%2!=0){echo '<tr id=\'tbl_rabbits_row1\'>';}else{echo '<tr>';} //Altern color for each line
			echo '<td>'.$tbx[$key]['rabbit_id'].'</td>';
                        echo '<td>'.$tbx[$key]['rabbit_name'].'</td>';
                        
                        //Angry test
                        if($tbx[$key]['skill_angry']<50){
                            echo '<td id = "td_error">';
                        } else
                        {
                            echo '<td id = "td_valid">';
                        }
			echo $tbx[$key]['skill_angry'].'</td>';
                        
                        //Thirst test
                        if($tbx[$key]['skill_thirst']<50){
                            echo '<td id = "td_error">';
                        } else
                        {
                            echo '<td id = "td_valid">';
                        }
			echo $tbx[$key]['skill_thirst'].'</td>';
                        
                        //Health test
			if($tbx[$key]['skill_health']<50){
                            echo '<td id = "td_error">';
                        } else
                        {
                            echo '<td id = "td_valid">';
                        }
			echo $tbx[$key]['skill_health'].'</td>';
			
			
			echo '<td>';
			echo "<a href=\"index.php?module=admin&amp;action=delete_nabz&amp;nabz_id=".$tbx[$key]['rabbit_id']."\""."><img src=\"".PATH_IMAGE_RESSOURCE."delete.png"."\"></a>&nbsp;";
			//echo "<a href=\"index.php?module=admin&amp;action=valid_user&amp;hash_validation=".$tbx[$key]['hash_validation']."\""."><img src=\"".PATH_IMAGE_RESSOURCE."valid.png"."\"></a>&nbsp;";
			echo "<a href=\"index.php?module=admin&action=treat_nabz&nabz_id=".$tbx[$key]['rabbit_id']."\""."><img src=\"".PATH_IMAGE_RESSOURCE."health_admin.png"."\"></a>&nbsp;";
                        echo "<a href=\"index.php?module=admin&action=edit_nabz&nabz_id=".$tbx[$key]['rabbit_id']."&uid=".$tbx[$key]['rabbit_usr_id']."\""."><img src=\"".PATH_IMAGE_RESSOURCE."edit.png"."\"></a>&nbsp;";
			echo "<a href=\"index.php?module=admin&action=mail_nabz&nabz_id=".$tbx[$key]['rabbit_id']."&uid=".$tbx[$key]['rabbit_usr_id']."\""."><img src=\"".PATH_IMAGE_RESSOURCE."mail.png"."\"></a>&nbsp;";
                        
			echo '</td>';
			?>
			</td></tr>
		<?php }
	

		?>
</tbody></table>
<a href="<?php echo 'index.php?module=admin&action=mail_all_nabz&id='.$_SESSION['id'];?>"><img src="<?php echo PATH_IMAGE_RESSOURCE."mail.png"?>">&nbsp;Mail à tout les lapins</a>