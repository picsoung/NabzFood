<?php
	require_once(PATH_MODEL.'nabz.php');
	function display_menu(){
		// Arrays with links and text to be displayed
		$url='index.php?module=nabz&amp;action=';
		$id = '&id='.$_SESSION['id'];
	$tab_menu_link = array( $url.'mynabz'.$id, $url.'feed'.$id, $url.'water'.$id, $url.'treat'.$id);
	$tab_menu_text = array( "État général", "Nourriture", "Boissons", "Médicaments/Compléments");
	
	//informations about the page
	$info = pathinfo($_SERVER['PHP_SELF']);

        $menu = "\n<div id=\"menu_nabz\">\n    <ul id=\"tabs\">\n";
        
        //Loop for the two arrays
		foreach($tab_menu_link as $cle=>$link)
		{
		    $menu .= "    <li";
			
			$new_link = str_replace($url,"",$link);
			$new_link = str_replace($id,"",$new_link);
			
		    //if the filename is the one pointed by the index we active it
		    if( $_GET['action'] == $new_link )
		        $menu .= " class=\"active\"";
			
		    $menu .= "><a href=\"" . $link . "\">" . $tab_menu_text[$cle] . "</a></li>\n";
		}

        $menu .= "</ul>\n    </div>";

        //return HTML code
        return $menu;
		
		}
		
	function display_bar($points, $skill)
	{
		$html_code = "";
		if($points < 50)
		{
			$html_code .= "<img id=\"img_skill\" src=\"".PATH_IMAGE_RESSOURCE."".$skill.".png\">";
			$html_code .="<div id=\"stat_bar\"><img src=\"".PATH_IMAGE_RESSOURCE."barre_red.png\" id=\"stat_bar_img\" height=20 width=".$points."></div>";
			//$html_code .= "</div>";
			$html_code .= "<img id=\"smile\" src=\"".PATH_IMAGE_RESSOURCE."unhappy.png\">";
		}else{
			$html_code .= "<img id=\"img_skill\" src=\"".PATH_IMAGE_RESSOURCE."".$skill.".png\">";
			$html_code .="<div id=\"stat_bar\"><img src=\"".PATH_IMAGE_RESSOURCE."barre_green.png\" id=\"stat_bar_img\" height=20 width=".$points."></div>";
			//$html_code .= "</div>";
			$html_code .= "<img id=\"smile\" src=\"".PATH_IMAGE_RESSOURCE."smile.png\">";
		}
		
		
		
		return $html_code;
	}
	
	function display_skill($id_nabz)
	{
		$skill_nabz = read_skill_nabz($id_nabz);
				
			$skill_angry = $skill_nabz['skill_angry'];
			$skill_thirst = $skill_nabz['skill_thirst'];
			$skill_health = $skill_nabz['skill_health'];
			
		echo '<div id="skill_bar" >';
		echo display_bar($skill_angry,'food');
		echo '<br /><br />';
		echo display_bar($skill_thirst,'drink');
		echo '<br /><br />';
		echo display_bar($skill_health,'health');
		echo '</div>';
	}

	function display_avatar_name()
	{
		echo "<img src=\"".PATH_IMAGE_RESSOURCE."nabz.png\">";
		echo "<h2 id=\"nabz_name\">".$_SESSION['nabzname']."</h2>";	
	}
?>
