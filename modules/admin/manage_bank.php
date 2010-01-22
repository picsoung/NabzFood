<?php
	if(!user_admin()) {
	    include PATH_GLOBAL_VIEW.'error_not_admin.php';
	}else {
		include PATH_LIB.'form.php';
		include PATH_MODEL.'admin.php';
		
		
		//read info about the bingo
		$bingo_info = fopen('global/bingo.txt','r+');
		//price of a ticket is on the first line
		$price = fgets($bingo_info);
		$price = (int)str_replace("price:","",$price);
		//total jackpot is on the second
		$jackpot = fgets($bingo_info);

		$jackpot = (int)str_replace("jackpot:","",$jackpot);
		fclose($bingo_info);
		
		$number_ticket_sold = num_ticket_sold();
		
		/*Form to modify jackpot and ticket price */
		$form_bingo = new Form("form_bingo");
		$form_bingo->method('POST');
		
		$form_bingo->add('Text','bingo_ticket_price')
			    ->label("Prix d'un ticket")
			    ->value($price);
		$form_bingo->add('Text','bingo_jackpot')
			    ->label("Gros lot")
			    ->value($jackpot);
		$form_bingo->add('Submit','submit')
			    ->value('Modifier');
		
		if($form_bingo->is_valid($_POST))
		{
			list($new_price,$new_jackpot) = $form_bingo->get_cleaned_data('bingo_ticket_price','bingo_jackpot');
			
			if($new_price < 0)
			{
				$new_price = 0;
			}
			if($new_jackpot < 0)
			{
				$new_jackpot = 0;
			}
			if($price != $new_price)
			{
				update_bingo_price($new_price);
			}
			if($jackpot != $new_jackpot)
			{
				update_bingo_jackpot($new_jackpot);
			}
			
		}//end if valid form_bingo
		
		/*Form to distribute the jackpot */
		$form_distrib = new Form("form_distrib");
		$form_distrib->method('POST');
		
		$form_distrib->add('Text','bingo_real_jackpot')
			->label("Jackpot à distribuer")
			->value($jackpot);
		$form_distrib->add('Submit','submit')
			->value("Trouver un gagnant");
		
		if($form_distrib->is_valid($_POST))
		{
			$real_jackpot = $form_distrib->get_cleaned_data('bingo_real_jackpot');
			
			$id_winner = bingo_find_winner($jackpot,$number_ticket_sold);
			
			update_winners($id_winner);
			init_bingo();
		}//end if valid form_distrib
		
		include PATH_VIEW.'view_bank.php';
        }
?>