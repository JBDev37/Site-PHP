<?php

class Messages {


	static function nbr_commentaire($db, $post_ID){
		$nb_commentaire = $db->query('SELECT COUNT(comment_ID) FROM wp_cendrillon_6239_comments WHERE comment_post_ID = ? ', [$post_ID])->fetchColumn();

        return $nb_commentaire ;
    

	}

	static function signaler_msg($db, $post_ID,$user_id, $author_id){
		$date = date("Y-m-d H:i:s"); 
        /* on verifie que l'utilisateur n'a pas déjà signalé ce message*/
        $req5 = $db->query('SELECT id_message, from_id FROM messages_signalés WHERE id_message = ? AND from_id =? ',[$post_ID, $user_id])->fetch();
        
        if($req5){
        	 ?> <script type="text/javascript">
	         document.getElementById('<?php echo $post_ID ?>').value="Signalé !";
	         document.getElementById('<?php echo $post_ID ?>').style.fontWeight="bold";
	         </script><?php
        }else{


	        $db->query('INSERT INTO messages_signalés SET id_message = ?, author_id =?, from_id =? ,date_signale = ?', [$post_ID, $author_id, $user_id, $date])->execute();
	        $id = $db->lastInsertId();
	        $req = $db->query('DELETE FROM messages_signalés WHERE id=?', [$id])->execute();

	        $req1 = $db->query('SELECT ID, message_signale FROM wp_cendrillon_6239_users WHERE ID = ? ',[$user_id])->fetch();
	        $nbr_message_signale = $req1->message_signale;
	        $nbr_message_signale1 = $nbr_message_signale + (int)1;

	        $req4 = $db->query('UPDATE wp_cendrillon_6239_users SET message_signale = ? WHERE ID = ?', [$nbr_message_signale1, $user_id])->execute();

	        $count_message = $db->query('SELECT COUNT(id_message) FROM messages_signalés WHERE id_message = ? ',[$post_ID])->fetchColumn();

	        if($count_message > 2){//on supprime le message
	         $req2 = $db->query('DELETE FROM messages_signalés WHERE id_message=?', [$post_ID])->execute(); 
	         $req3 = $db->query('DELETE FROM wp_cendrillon_6239_posts WHERE ID=?', [$post_ID])->execute();
	         $req6 = $db->query('SELECT ID, avertissement FROM wp_cendrillon_6239_users WHERE ID = ? ',[$author_id])->fetch();
	         $nbr_avertissement= $req6->avertissement;
	         $nbr_avertissement1 = $nbr_avertissement + (int)1;
	         $req7 = $db->query('UPDATE wp_cendrillon_6239_users SET avertissement = ? WHERE ID = ?', [$nbr_avertissement1, $author_id])->execute();
	        }

	        ?> <script type="text/javascript">
	         document.getElementById('<?php echo $post_ID ?>').value="Signalé !";
	         document.getElementById('<?php echo $post_ID ?>').style.fontWeight="bold";
	         </script><?php
        }

	}

	static function count_signaler_msg($db,$user_id){

        $req1 = $db->query('SELECT ID, message_signale FROM wp_cendrillon_6239_users WHERE ID = ? ',[$user_id])->fetch();
        $nbr_message_signale = $req1->message_signale;

        return $nbr_message_signale;

	}

	static function count_avertissement($db,$user_id){

        $req1 = $db->query('SELECT ID, avertissement FROM wp_cendrillon_6239_users WHERE ID = ? ',[$user_id])->fetch();
        $nbr_avertissement = $req1->avertissement;

        return $nbr_avertissement;

	}

	static function is_signaler_msg($db, $post_ID,$user_id){//on cherche si l'utilisateur à déjà signalé le message
        $req5 = $db->query('SELECT id_message, from_id FROM messages_signales WHERE id_message = ? AND from_id =? ',[$post_ID, $user_id])->fetch();
        if($req5){
        	return true;
        } else return false;

    }

    static function nbr_aide_poste($db, $user_id){
 	$count_aide = $db->query('SELECT COUNT(post_author_id) FROM wp_cendrillon_6239_comments WHERE comment_author_id = ? ',[$user_id])->fetchColumn();

    return $count_aide;
   }

    static function author_poste_id($db, $comment_id){// on recherche l'auteur du message poste
 	$author_id1 = $db->query('SELECT post_author_id FROM wp_cendrillon_6239_comments WHERE comment_ID = ? ',[$comment_id])->fetch();

    return $author_id1;
   }

    static function new_response($db, $post_id, $my_id){// notification qu'une réponse a un message a été posté
 	$read = 1;
 	$false = 0;
	$req = $db->query('UPDATE wp_cendrillon_6239_posts SET read_ = ? WHERE ID = ?', [$read, $post_id])->execute();
    $req1 = $db->query('UPDATE wp_cendrillon_6239_comments SET read_ = ? WHERE comment_post_ID = ?', [$read, $post_id])->execute();
    $req2 = $db->query('UPDATE wp_cendrillon_6239_comments SET read_ = ? WHERE comment_post_ID = ? AND comment_author_id =?', [$false, $post_id, $my_id])->execute();
   }

   static function title_message($db, $id_message){// on recherche le titre du message
 	$title_message = $db->query('SELECT post_title FROM wp_cendrillon_6239_posts WHERE ID = ? ',[$id_message])->fetch();
    return $title_message;
   }

    static function update_message_read($db, $id_message){// on met à jour la table posts si un message est lu
 	$read = 0;
	$req = $db->query('UPDATE wp_cendrillon_6239_posts SET read_ = ? WHERE ID = ?', [$read, $id_message])->execute();
   }


    static function update_comment_read($db, $id_message, $my_id){// on met à jour la table comments si un message est lu
 	$read = 0;
	$req = $db->query('UPDATE wp_cendrillon_6239_comments SET read_ = ? WHERE comment_post_ID = ? AND comment_author_id = ?', [$read, $id_message,$my_id])->execute();
   }
        




















}