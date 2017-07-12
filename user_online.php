<?php 
/*session_start();*/
?> <div style=" top: 90px;"> <?php
ob_start();
ini_set('display_errors','on');
error_reporting(E_ALL); ?>
</div> <?php

$session=session_id();

$today = date("Y-m-d H:i:s"); 
$time=time();
$time_check=$time-300; //connection 5 Minutes (300 secondes)
$my_id = $_SESSION['auth']->ID;

/* on recherche le nom de l'auteur */
$recherche_author = $pdo->prepare('SELECT ID, user_login FROM wp_cendrillon_6239_users WHERE ID= ? ');
$recherche_author->execute([$my_id]);
$affiche_author = $recherche_author->fetch();
$name_author = $affiche_author->user_login;

/* on recherche si l'utilisateur est connecté*/
$req_session = $pdo->prepare('SELECT COUNT(ID_user) FROM users_online WHERE ID_user = :ID_user ');
$req_session->bindParam(':ID_user', $my_id, PDO::PARAM_STR);
$req_session->execute();
$nb_session = $req_session->fetchColumn();

   

if($nb_session==0){
	$req_1 = $pdo->prepare('INSERT INTO users_online SET ID_user = ? , session = ?, time_ = ?');
	$req_1->execute([$my_id,$session, $time]);

	 /* on met à jour la table des conseillère*/
	$req_3 = $pdo->prepare('UPDATE wp_cendrillon_6239_conseillere SET last_connexion = :last_connexion WHERE displayname = :name');
	$req_3->bindParam(':last_connexion', $today, PDO::PARAM_STR);
	$req_3->bindParam(':name', $name_author , PDO::PARAM_STR);
	$req_3->execute();
	
    

   }else {

	$req_2 = $pdo->prepare('UPDATE users_online SET time_ = :time_ WHERE ID_user = :ID_user');
	$req_2->bindParam(':time_', $time, PDO::PARAM_INT);
	$req_2->bindParam(':ID_user', $my_id, PDO::PARAM_STR);
	$req_2->execute();
	}


	 /* on met à jour la table des conseillère*/
	$req_3 = $pdo->prepare('UPDATE wp_cendrillon_6239_conseillere SET last_connexion = :last_connexion WHERE displayname = :name');
	$req_3->bindParam(':last_connexion', $today, PDO::PARAM_STR);
	$req_3->bindParam(':name', $name_author , PDO::PARAM_STR);
	$req_3->execute();
	
	

	// if over 5 minute, delete session
$req_4 = $pdo->prepare('DELETE FROM users_online WHERE time_ < :time_');
$req_4->bindParam(':time_', $time_check, PDO::PARAM_INT);
$req_4->execute();

/*  on compte le nombre d'utilisateur en ligne
$req_3 = $pdo->query('SELECT COUNT(session)  FROM users_online ');
$nb_req_3 = $req_3->fetchColumn();
echo "$nb_req_3";*/

/* on affiche si le membre est connecté*/
$req_conect = $pdo->prepare('SELECT session FROM users_online WHERE session = :session ');
$req_conect->bindParam(':session', $session, PDO::PARAM_STR);
$req_conect->execute();

/*
if (isset($req_conect)) {
	echo "CONNECTE";
}*/
	


?>

