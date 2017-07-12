<?php

class Anges {

	static function anges_request($db,$id_from, $id_to){
		$date = date("Y-m-d H:i:s"); 
		$db->query('INSERT INTO anges_request SET from_ = ?, to_ = ?, date_ = ?', [$id_from, $id_to, $date])->execute();
		$id = $db->lastInsertId();
    	$req = $db->query('DELETE FROM anges_request WHERE id=?', [$id])->execute(); 

	}

	static function count_anges_request($db,$id_from, $id_to){//l'utilisateur envoi une ange gardian
		$req = $db->query('SELECT COUNT(id) FROM anges_request WHERE  (from_ = ? AND to_ = ?) OR (from_ = ? AND to_ = ?)', [$id_to, $id_from, $id_from, $id_to])->fetchColumn();

 		if ($req > 0){
 			return true;

 		} else {
 			return false;
 		}

	}


	static function is_anges($db,$user_id){
		$req = $db->query('SELECT COUNT(id) FROM ange_list WHERE  user_one = ? ', [$user_id])->fetchColumn();

 		if ($req > 0){
 			return true;

 		} else {
 			return false;
 		}
		
	}

		static function possede_anges($db,$user_id){
		$req = $db->query('SELECT COUNT(id) FROM ange_list WHERE  user_two = ?', [$user_id])->fetchColumn();

 		if ($req > 0){
 			return true;

 		} else {
 			return false;
 		}
		
	}

	static function count_anges($db,$user_id){
		$nbr_friends = $db->query('SELECT COUNT(id) FROM ange_list WHERE user_one = ? OR user_two = ?', [$user_id, $user_id])->fetchColumn();

 		return $nbr_friends;
 		
	}


	static function refuse_ange($db,$id_from, $id_to){
		$req = $db->query('DELETE FROM anges_request WHERE from_ = ? AND to_ = ?', [$id_from, $id_to])->execute(); 
		
	}

	static function accept_ange($db,$id_from, $id_to){
		$db->query('DELETE FROM anges_request WHERE from_ = ?', [$id_from])->execute(); 
		$date = date("Y-m-d H:i:s"); 
		
		$db->query('INSERT INTO ange_list SET user_one = ?, user_two = ?, date_ = ?', [$id_from, $id_to, $date])->execute();
		$id = $db->lastInsertId();
    	$req = $db->query('DELETE FROM ange_list WHERE id=?', [$id])->execute(); 
		
	}

	static function supprimer_ange($db,$id_from, $id_to){
		$db->query('DELETE FROM ange_list WHERE user_one = ? AND user_two = ?', [$id_from, $id_to])->execute(); 
		$db->query('DELETE FROM ange_list WHERE user_one = ? AND user_two = ?', [$id_to, $id_from])->execute(); 
	}

	static function my_angel($db,$user_id){ // on recherche l'ange gardien de l'utilisateur
		
		$req = $db->query('SELECT user_one, user_two FROM ange_list WHERE user_two = ?', [$user_id])->fetch();
		if($req){
		$ange_id = $req->user_one;

        return $ange_id;
    
    }
	}

	static function my_kurbys($db,$user_id){ // on recherche le kurbys de l'utilisateur
		
		$req = $db->query('SELECT user_one, user_two FROM ange_list WHERE user_one = ?', [$user_id])->fetch();
		if($req){
		$kurbys_id = $req->user_two;

        return $kurbys_id;
    
    }
	}

	static function delete_ange($db,$user_id){
		$db->query('DELETE FROM ange_list WHERE user_two = ?', [$user_id])->execute(); 
		
	}

	static function delete_kurbys($db,$user_id){
		$db->query('DELETE FROM ange_list WHERE user_one = ?', [$user_id])->execute(); 
		
	}



}
	