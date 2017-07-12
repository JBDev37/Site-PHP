<?php

class Chat {


	static function add_contact($db, $from, $to){
		$date = date("Y-m-d H:i:s"); 
		// on cherche si le contact existe déjà
		$search = $db->query('SELECT COUNT(id) FROM contact_chat WHERE (from_id = ? AND to_id =?) OR (from_id = ? AND to_id =?) ',[$from, $to, $to, $from])->fetchColumn();
        // on ajoute le contact s'il n'existe pas
		if ($search == 0) {
			if($from != $to){
		 	$db->query('INSERT INTO contact_chat SET from_id = ?, to_id = ?, date_ = ?', [$from, $to, $date])->execute();
		    $id = $db->lastInsertId();
		    $req = $db->query('DELETE FROM contact_chat WHERE id=?', [$id])->execute(); 
		    }
		 }
		} 

	static function message_lu($db, $from, $to){//met à jour la table des messages pour indiquer qu'ils sont lu
	        $lu = true;
			$db->query('UPDATE message_chat SET message_lu = ? WHERE (user_id = ? AND user_send =?) OR (user_id = ? AND user_send =?)', [$lu,$from, $to, $to, $from])->execute();
           
		 }

	static function message_non_lu($db,$from, $to){// on recherche les messages non lu pour ensuite les afficher avec un fond orange
		$lu = 0;
		$req = $db->query('SELECT user_id, user_send FROM message_chat WHERE user_id = ? AND user_send = ? AND message_lu =?', [$from, $to,$lu])->fetch();
		if($req){

        return true; } 
	}


	static function last_id_contact($db, $my_id ,$my_id1){
      
        $recherche_contact = $db->query('SELECT id, from_id, to_id, last_message, date_ FROM contact_chat WHERE from_id = ? OR to_id = ? ORDER BY date_
		DESC',[$my_id, $my_id1])->fetch();

		if($recherche_contact){
		$user_id = $recherche_contact->to_id;
		$from_id = $recherche_contact->from_id;
		if($user_id==$my_id){$user_id = $recherche_contact->from_id;}

		return $user_id;}


    }

    	static function update_contact_chat($db, $my_id){ // on met à jour les contacts dans le chat pour les anciens abonnés
        $date = date("Y-m-d H:i:s"); 
        $recherche_contact = $db->query('SELECT user_id, user_send FROM message_chat WHERE user_send = ?',[$my_id]);

		if($recherche_contact){
		$is_contact = $db->query('SELECT id, from_id, to_id, last_message, date_ FROM contact_chat WHERE to_id = ? ',[$my_id])->fetch();
        if (!$is_contact){
        while($affiche_contact = $recherche_contact->fetch()){

		$user_id = $affiche_contact->user_id;

		
		$db->query('INSERT INTO contact_chat SET from_id = ?, to_id = ?, date_ = ?', [$user_id, $my_id, $date])->execute();
		    $id = $db->lastInsertId();
		    $req = $db->query('DELETE FROM contact_chat WHERE id=?', [$id])->execute();
          }
		}
		 }
		}


		static function delete_msg_nul($db, $From_id) {
			$To_id = 0;
			$null = "";
		    $req = $db->query('DELETE FROM contact_chat WHERE from_id=? AND to_id=?', [$From_id, $To_id])->execute(); 
		    $req = $db->query('DELETE FROM contact_chat WHERE (from_id=? OR to_id=?) AND last_message =?', [$From_id, $To_id, $null])->execute(); 
		 }













   
















	




















}