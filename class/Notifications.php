<?php

class Notifications {


	static function count_friends_request($db, $id_to){//on compte le nombre de demande en ami
		$req = $db->query('SELECT COUNT(ID) FROM friends_request WHERE  to_ = ?', [$id_to])->fetchColumn();
 		
 		 return $req;
 		}

 	static function name_friends_request($db, $id_to){//nom de celui qui demande en ami
		$req = $db->query('SELECT from_ FROM friends_request WHERE  to_ = ?', [$id_to])->fetch();
        if($req){
        $id = $req->from_; 
        
        $req1 = $db->query('SELECT user_login FROM wp_cendrillon_6239_users WHERE ID = ?', [$id])->fetch();
		
		if($req1){
		$user_name = $req1->user_login; 

 		
 		 return $user_name;
 		}
 	  }
 	}

	static function count_message_non_lu($db, $to){//on compte le nombre de message non lu
		$false = 0;
		$count= $db->query('SELECT COUNT(id) FROM message_chat WHERE user_send = ? AND message_lu=?', [$to,$false])->fetchColumn();
 		
 		return $count;
 		}


	static function count_anges_request($db, $id_to){//on compte le nombre de demande en ami
		$req = $db->query('SELECT COUNT(id) FROM anges_request WHERE  to_ = ?', [$id_to])->fetchColumn();
 		
 		 return $req;
 		}

 	static function name_anges_request($db, $id_to){//nom de celui qui demande en ami
		$req = $db->query('SELECT from_ FROM anges_request WHERE  to_ = ?', [$id_to])->fetch();
        if($req){
        $id = $req->from_; 
        
        $req1 = $db->query('SELECT user_login FROM wp_cendrillon_6239_users WHERE ID = ?', [$id])->fetch();
		
		if($req1){
		$user_name = $req1->user_login; 

 		
 		 return $user_name;
 		}
 	  }
 	}

	static function count_commentaires_non_lu($db, $to){//on compte le nombre de message non lu
		$false = 0;
		$count= $db->query('SELECT COUNT(id) FROM commentaires WHERE to_ = ? AND lu =?', [$to,$false])->fetchColumn();
		$no_lu = 0;
		if($count>0){$no_lu = 1;}

		return $no_lu;
 		}

 	static function commentaire_lu($db, $user_id){
 		$lu = 1;
	    $req1 = $db->query('UPDATE commentaires SET lu = ? WHERE to_ = ?', [$lu, $user_id])->execute();
	 
	
   }

	static function count_reponse_non_lu($db, $my_id){//on compte le nombre de reponse non lu à un message 
		$true = 1;
		$count= $db->query('SELECT COUNT(id) FROM wp_cendrillon_6239_posts WHERE post_author = ? AND read_ = ?', [$my_id,$true])->fetchColumn();
		$no_lu = 0;
		if($count>0){$no_lu = 1;}

		return $no_lu;
 		
 		}

 	static function id_reponse_non_lu($db, $my_id){//on compte le nombre de reponse non lu à un message 
		$true = 1;
		$req= $db->query('SELECT * FROM wp_cendrillon_6239_posts WHERE post_author = ? AND read_ = ?', [$my_id,$true])->fetch();
		if($req){
		$id_message = $req->ID;		
		return $id_message;
		 }
 		 
 		}


 	static function count_comment_non_lu($db, $my_id){//on compte le nombre de reponse non lu à un message dont l'utilisateur y a répondu
		$true = 1;
		$count= $db->query('SELECT COUNT(comment_ID) FROM wp_cendrillon_6239_comments WHERE comment_author_id = ? AND read_ = ?', [$my_id,$true])->fetchColumn();
		$no_lu = 0;
		if($count>0){$no_lu = 1;}

		return $no_lu;
 		
 		}

 	 	static function id_comment_non_lu($db, $my_id){//on compte le nombre de reponse non lu à un message 
		$true = 1;
		$req= $db->query('SELECT * FROM wp_cendrillon_6239_comments WHERE comment_author_id = ? AND read_ = ?', [$my_id,$true])->fetch();
		if($req){
		$id_message = $req->comment_post_ID;		
		return $id_message;
		 }
 		 
 		}





}



	