<?php

class User {

	static function user_sexe($db,$user_id){
		$req = $db->query('SELECT user_sexe FROM wp_cendrillon_6239_users WHERE ID = ?', [$user_id])->fetch();
		if($req){
		$user_sexe = $req->user_sexe;
		if($user_sexe == "fille" OR  $user_sexe == "garcon"){
		return $user_sexe;
		}else{
			
			$req = $db->query('SELECT USER_ID, FIELD_ID, VALUE FROM wp_cendrillon_6239_cimy_uef_data WHERE USER_ID= ? AND FIELD_ID = "1" ', [$user_id])->fetch();
			if($req){
				$user_sexe = $req->VALUE;

				

				if($user_sexe == " Une fille"){
					$user_sexe = "fille";
					
				   }else{
					   $user_sexe = "garcon";
					   
				      }
			}
     	}

        return $user_sexe;
       }
	}


	static function user_name($db,$user_id){
		
		$req = $db->query('SELECT user_login FROM wp_cendrillon_6239_users WHERE ID = ?', [$user_id])->fetch();
		if($req){
		$user_name = $req->user_login;

        return $user_name;
    
    }
	}


	static function user_ID($db,$user_name){
		
		$req = $db->query('SELECT ID FROM wp_cendrillon_6239_users WHERE user_login = ?', [$user_name])->fetch();
		if($req){
		$ID = $req->ID;

        return $ID;
    
    }
	}

	static function user_mail($db,$user_id){
		
		$req = $db->query('SELECT user_email FROM wp_cendrillon_6239_users WHERE ID = ?', [$user_id])->fetch();
		if($req){
		$user_mail = $req->user_email;

        return $user_mail;
    
    }
	}


    static function user_naissance($db,$user_id){
		$req = $db->query('SELECT naissance FROM wp_cendrillon_6239_users WHERE ID = ?', [$user_id])->fetch();
		$user_naissance = $req->naissance;

        return $user_naissance;
	}

 	static function conseillere($db,$user_id){
 		$req = $db->query('SELECT COUNT(id) FROM wp_cendrillon_6239_conseillere WHERE  user_id = ? ', [$user_id])->fetchColumn();

 		if ($req > 0){
 			$conseillere = true;

 		} else {
 			$conseillere=false;
 		}
		
		return $conseillere;

 	}

 	   static function presentation_conseillere($db, $user_id){
	 $req = $db->query('SELECT user_id, presentation FROM wp_cendrillon_6239_conseillere WHERE user_id=?',[$user_id])->fetch();
	 if($req){
         $presentation = $req->presentation;
   
    return $presentation;}
   }




	static function update_user_name($db,$diplayname){//on met le user_id dans la table conseillere -> utilisé dans la page "recherche conseillère"
		
		$req = $db->query('SELECT ID FROM wp_cendrillon_6239_users WHERE user_login = ?', [$diplayname])->fetch();
		if($req){
		$user_id = $req->ID;
        $req1 = $db->query('UPDATE wp_cendrillon_6239_conseillere SET user_id = ? WHERE displayname = ?', [$user_id, $diplayname])->execute();
		
        
    
}
	}


	static function update_user_sexe($db,$user_id){//on met le user_sexe dans la table conseillere -> utilisé dans la page "recherche conseillère"
		$req = $db->query('SELECT user_sexe FROM wp_cendrillon_6239_users WHERE ID = ?', [$user_id])->fetch();
		if($req){
		$user_sexe = $req->user_sexe;
		if($user_sexe == "fille" OR  $user_sexe == "garcon"){
			
		}else{
			
			$req = $db->query('SELECT USER_ID, FIELD_ID, VALUE FROM wp_cendrillon_6239_cimy_uef_data WHERE USER_ID= ? AND FIELD_ID = "1" ', [$user_id])->fetch();
			if(!isset($req)){$user_sexe="fille";}else{
			$user_sexe = $req->VALUE;}
			

			if($user_sexe == " Une fille"){
				$user_sexe = "fille";
				
			   }else{
				   $user_sexe = "garcon";
				   
			      }
			    $req1 = $db->query('UPDATE wp_cendrillon_6239_conseillere SET user_sexe = ? WHERE user_id = ?', [$user_sexe, $user_id])->execute();  
			  }
       }
	}


   static function indice_confiance($db,$user_id){

	$vote_up = $db->query('SELECT SUM(votes_up) FROM thumbsup_items WHERE ID_author = ? ',[$user_id])->fetchColumn();
	$vote_down = $db->query('SELECT SUM(votes_down) FROM thumbsup_items WHERE ID_author = ? ',[$user_id])->fetchColumn();
    $sum = $vote_up + $vote_down;
	if ($sum ==0){$indice_vote=50;

	    } else {
	$indice_vote = round(($vote_up / $sum) * 100);}
	
    //on compte calcul la derniere connexion
    $last_req = $db->query('SELECT last_connexion  FROM wp_cendrillon_6239_users WHERE ID = ?', [$user_id])->fetch();
    if(isset($last_req->last_connexion)){
    $last_connexion = $last_req->last_connexion;	
    $date_c = strtotime($last_connexion);
	$now   = time(); // en seconde
	$diff  = abs($now - $date_c); 

	if($diff< 1.5 * 24 * 3600){
		$coeff_connexion = 1;
	} 

	if(1.5 * 24 * 3600 <= $diff && $diff < 2.5 * 24 * 3600){
		$coeff_connexion = 0.9;
	}

	if(2.5 * 24 * 3600 <= $diff && $diff < 3.5 * 24 * 3600){
		$coeff_connexion = 0.8;
	}

	if(3.5 * 24 * 3600 <= $diff && $diff < 4.5 * 24 * 3600){
		$coeff_connexion = 0.7;
	}

	if(4.5 * 24 * 3600 <= $diff && $diff < 5.5 * 24 * 3600){
		$coeff_connexion = 0.6;
	}

	if( $diff >= 5.5 * 24 * 3600 ){
		$coeff_connexion = 0.4;
	}

	} else {$coeff_connexion = 0.4;}
	
	//on compte le nombre de personne aidé en message privé
	$count_from = $db->query('SELECT COUNT(from_id) FROM contact_chat WHERE from_id = ? ',[$user_id])->fetchColumn();
	$count_to = $db->query('SELECT COUNT(to_id) FROM contact_chat WHERE to_id = ? ',[$user_id])->fetchColumn();
	$nbr_aide = $count_to + $count_from;


	if($nbr_aide > 20 ){
		$coeff_aide = 1;
	}

	if(20 >= $nbr_aide && $nbr_aide > 15 ){
		$coeff_aide = 0.9;
	}

	if(15 >= $nbr_aide && $nbr_aide > 10 ){
		$coeff_aide = 0.8;
	}

	if(10 >= $nbr_aide && $nbr_aide > 5 ){
		$coeff_aide = 0.7;
	}

	if($nbr_aide <= 5 ){
		$coeff_aide = 0.5;
	}

	$indice_confiance = round($indice_vote * $coeff_connexion * $coeff_aide);

    $req2 = $db->query('UPDATE wp_cendrillon_6239_users SET indice_confiance = ? WHERE ID = ?', [$indice_confiance, $user_id])->execute();
	$req1 = $db->query('UPDATE wp_cendrillon_6239_conseillere SET indice_confiance = ? WHERE user_id = ?', [$indice_confiance, $user_id])->execute();

	return $indice_confiance;

   }


    static function ajout_visite_profile($db, $From_id ,$To_id) {
   	$date = date("Y-m-d H:i:s");  
   	$db->query('INSERT INTO visite_profile SET from_id = ?, to_id = ?, date_visite = ?', [$From_id, $To_id, $date])->execute();
    $id = $db->lastInsertId();
    $req = $db->query('DELETE FROM visite_profile WHERE id=?', [$id])->execute(); 
    
    }



    static function nbr_visite($db, $user_id) {
    $count_visit = $db->query('SELECT COUNT(to_id) FROM visite_profile WHERE to_id = ? ',[$user_id])->fetchColumn();

    return $count_visit;
   }


   static function nbr_personne_aide($db, $user_id){
 	$count_aide = $db->query('SELECT COUNT(comment_author_id) FROM wp_cendrillon_6239_comments WHERE comment_author_id = ? ',[$user_id])->fetchColumn();

    return $count_aide;
   }

   static function id_author_commentaire($db, $comment_post_id){
   	$req = $db->query('SELECT ID, post_author FROM wp_cendrillon_6239_posts WHERE ID= ?', [$comment_post_id])->fetch();
	if($req){$user_id = $req->post_author;
	return $user_id;}
   }

   static function nbr_message_poste($db, $user_id){
 	$count_message = $db->query('SELECT COUNT(post_author) FROM wp_cendrillon_6239_posts WHERE post_author = ? ',[$user_id])->fetchColumn();

    return $count_message;
   }

   static function presentation_profile($db, $user_id){
	 $req = $db->query('SELECT id, presentation FROM wp_cendrillon_6239_users WHERE ID=?',[$user_id])->fetch();
	 if($req){
         $presentation = $req->presentation;
     if(!$presentation){ 
        $name = SELF::user_name($db, $user_id);
     	$presentation = $name." n'a pas encore de présentation ! ";}
    
    return $presentation;}
   }

   static function last_connexion($db, $user_id){
   	 $date = date("Y-m-d H:i:s");  
	 $req1 = $db->query('UPDATE wp_cendrillon_6239_conseillere SET last_connexion = ? WHERE user_id = ?', [$date, $user_id])->execute();
	 $req2 = $db->query('UPDATE wp_cendrillon_6239_users SET last_connexion = ? WHERE ID = ?', [$date, $user_id])->execute();
	
   }

    static function user_online($db, $user_id){
	$nb_session = $db->query('SELECT COUNT(ID_user) FROM users_online WHERE ID_user = ?', [$user_id])->fetchColumn();
		if ($nb_session >0){
			return true;
		}else{
			return false;
		}

   }

   static function nbr_personne_qui_mon_aide($db, $user_id){

		$count_reponses = $db->query('SELECT COUNT(post_author_id) FROM wp_cendrillon_6239_comments WHERE post_author_id= ? ',[$user_id])->fetchColumn();
		
    return $count_reponses;
   }

   static function nbr_commentaires($db, $user_id){

		$count_comment = $db->query('SELECT COUNT(id) FROM commentaires WHERE to_= ? ',[$user_id])->fetchColumn();
		
    return $count_comment;
   }

   static function user_signale($db,$from_id, $to_id){
		$date = date("Y-m-d H:i:s"); 
        /* on verifie que l'utilisateur n'a pas déjà signalé cet utilisateur*/
        $req5 = $db->query('SELECT from_, to_ FROM user_signale WHERE from_ = ? AND to_ = ? ',[$from_id, $to_id])->fetch();
        
        if($req5){
        	 ?> <script type="text/javascript">
	         document.getElementById('<?php echo $aleatoire ?>').display="none";
	         document.getElementById('<?php echo $aleatoire ?>').style.fontWeight="bold";
	         </script><?php
        }else{


	        $db->query('INSERT INTO user_signale SET from_ = ?, to_ =? ,date_ = ?', [$from_id, $to_id, $date])->execute();
	        $id = $db->lastInsertId();
	        $req = $db->query('DELETE FROM user_signale WHERE id=?', [$id])->execute();

	        $count_user = $db->query('SELECT COUNT(id) FROM user_signale WHERE to_ = ? ',[$to_id])->fetchColumn();

	        if($count_user > 2){
	         $name = SELF::user_name($db, $to_id);
	         $db->query('INSERT INTO user_bloque SET  user_id = ? ,username = ?, date_ = ?', [$to_id, $name, $date])->execute();
	         $id = $db->lastInsertId();
			 $req = $db->query('DELETE FROM user_bloque WHERE id=?', [$id])->execute(); 
	        }
        }

	}

	static function is_signaler_user($db, $from_id, $to_id){//on cherche si l'utilisateur à déjà signalé cet utilisateur
        $req = $db->query('SELECT from_, to_ FROM user_signale WHERE from_ = ? AND to_ =? ',[$from_id, $to_id])->fetch();
        if($req){
        	return true;
        } else return false;

    }

    static function is_user_bloque($db, $username){//on cherche si l'utilisateur est bloqué
    	
        $req = $db->query('SELECT username FROM user_bloque WHERE username = ? ',[$username])->fetch();
        if($req){
        	return true;
        } else return false;

    }

    static function bloquer_contact_chat($db, $From_id ,$To_id) {
   	$date = date("Y-m-d H:i:s");  
   	$db->query('INSERT INTO bloquer_contact_chat SET from_ = ?, to_ = ?, date_ = ?', [$From_id, $To_id, $date])->execute();
    $id = $db->lastInsertId();
    $req = $db->query('DELETE FROM bloquer_contact_chat WHERE id=?', [$id])->execute();

    $req1 = $db->query('DELETE FROM contact_chat WHERE (from_id=? AND to_id = ?) OR (from_id=? AND to_id = ?)', [$From_id, $To_id,$To_id,$From_id])->execute();
    
    }

     static function is_user_bloque_chat($db, $my_id ,$User_id){//on cherche si l'utilisateur est bloqué
    	
        $req = $db->query('SELECT from_, to_ FROM bloquer_contact_chat WHERE from_ = ? AND to_ = ? ',[$User_id, $my_id])->fetch();
        if($req){
        	return true;
        } else return false;

    }

    static function debloque_chat($db, $my_id ,$User_id){//on débloque un utilisateur du chat
    	
        $req = $db->query('DELETE FROM bloquer_contact_chat WHERE from_=? AND to_ = ? ',[$my_id, $User_id])->execute();

        $date = date("Y-m-d H:i:s");  
	   	$db->query('INSERT INTO contact_chat SET from_id = ?, to_id = ?, date_ = ?', [$my_id, $user_id, $date])->execute();
	    $id = $db->lastInsertId();
	    $req1 = $db->query('DELETE FROM contact_chat WHERE id=?', [$id])->execute();
        

    }

        static function comment_author_id($db, $user_id){
    	
        $id_comment = $db->query('SELECT comment_post_ID FROM  wp_cendrillon_6239_comments WHERE comment_ID = ? ',[$user_id])->fetch();
        $id_comment1 = $id_comment->comment_post_ID;


        $user_id_author = $db->query('SELECT post_author FROM  wp_cendrillon_6239_posts WHERE ID = ? ',[$id_comment1 ])->fetch();
        $user_id_author1 = $user_id_author->post_author;



       return   $user_id_author1;

    }

        static function delete_contact_chat($db, $my_id ,$user_id){//on supprime une conversation avec un utilisateur
    	
        $req = $db->query('DELETE FROM contact_chat WHERE (from_id=? AND to_id = ?) OR (from_id=? AND to_id = ?) ',[$my_id, $user_id, $user_id,$my_id])->execute();

        /*$req1 = $db->query('DELETE FROM message_chat WHERE (user_id=? AND user_send = ?) OR (user_id=? AND user_send= ?) ',[$my_id, $user_id, $user_id,$my_id])->execute();*/

    }

















}