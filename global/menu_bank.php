<?php
	function display_menu_bank(){
		// Arrays with links and text to be displayed
		$url='index.php?module=bank&amp;action=';
		$id = '&id='.$_SESSION['id'];
	$tab_menu_link = array( $url.'my_account'.$id, $url.'click'.$id, $url.'audiotel'.$id, $url.'bingo'.$id,$url.'transfer'.$id);
	$tab_menu_text = array( "Mon Compte", "Clic", "Audiotel", "Bingo","Transferts");
	
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
?>