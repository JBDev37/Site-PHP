<?php

class Friends {

	static function friends_request($db,$id_from, $id_to){
		$date = date("Y-m-d H:i:s"); 
		$db->query('INSERT INTO friends_request SET from_ = ?, to_ = ?, date_ = ?', [$id_from, $id_to, $date])->execute();
		$id = $db->lastInsertId();
    	$req = $db->query('DELETE FROM friends_request WHERE id=?', [$id])->execute(); 

	}

	static function count_friends_request($db,$id_from, $id_to){//l'utilisateur envoi une demand en ami
		$req = $db->query('SELECT COUNT(ID) FROM friends_request WHERE  (from_ = ? AND to_ = ?) OR (from_ = ? AND to_ = ?)', [$id_to, $id_from, $id_from, $id_to])->fetchColumn();

 		if ($req > 0){
 			return true;

 		} else {
 			return false;
 		}

	}


	static function is_friends($db,$id_from, $id_to){
		$req = $db->query('SELECT COUNT(ID) FROM friends_list WHERE  (user_one = ? AND user_two = ?) OR (user_one = ? AND user_two = ?)', [$id_to, $id_from, $id_from, $id_to])->fetchColumn();

 		if ($req > 0){
 			return true;

 		} else {
 			return false;
 		}
		
	}

	static function count_friends($db,$user_id){
		$nbr_friends = $db->query('SELECT COUNT(ID) FROM friends_list WHERE user_one = ? OR user_two = ?', [$user_id, $user_id])->fetchColumn();

 		return $nbr_friends;
 		
	}


	static function refuse($db,$id_from, $id_to){
		$req = $db->query('DELETE FROM friends_request WHERE from_ = ? AND to_ = ?', [$id_from, $id_to])->execute(); 
		
	}

	static function accept($db,$id_from, $id_to){
		$db->query('DELETE FROM friends_request WHERE from_ = ? AND to_ = ?', [$id_from, $id_to])->execute(); 
		$date = date("Y-m-d H:i:s"); 
		
		$db->query('INSERT INTO friends_list SET user_one = ?, user_two = ?, date_ = ?', [$id_from, $id_to, $date])->execute();
		$id = $db->lastInsertId();
    	$req = $db->query('DELETE FROM friends_list WHERE id=?', [$id])->execute(); 
		
	}

	static function supprimer_ami($db,$id_from, $id_to){
		$db->query('DELETE FROM friends_list WHERE user_one = ? AND user_two = ?', [$id_from, $id_to])->execute(); 
		$db->query('DELETE FROM friends_list WHERE user_one = ? AND user_two = ?', [$id_to, $id_from])->execute(); 
	}



}
	