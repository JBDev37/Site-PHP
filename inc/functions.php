<?php

/*function debug($variable){
	echo '<pre>' . print_r($variable, true).'</pre>';
}*/

function str_random($length){

	$alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
	return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);

}

function logged_only(){

	if(session_status() == PHP_SESSION_NONE){
    session_start();
   }

	/*if(!isset($_SESSION['auth'])){
	$_SESSION['flash']['danger'] = " Vous n'avez pas le droit d'accéder à cette page";
	header('Location: login.php');
	exit();
}*/
}

/*function reconnect_from_cookie(){
	if(session_status() == PHP_SESSION_NONE){
    session_start();
     }
     
	if(isset($_COOKIE['remember']) && $_COOKIE['remember'] != NUL && !isset($_SESSION['auth'])){
		require_once 'db.php';
		if (isset($pdo)) {
			global $pdo;
		}
		  $remember_token = $_COOKIE['remember'];
		  $parts = explode('==', $remember_token);
		  $user_id = $parts[0];
		  

		  $req = $pdo->prepare('SELECT * FROM wp_cendrillon_6239_users WHERE ID = ?');
		  $req->execute([$user_id]);
		  $user = $req->fetch();
		  if ($user) {
			    $expected = $user_id.'=='. $user->remember_token.sha1($user_id.'ratonlaveur');
			    if($expected == $remember_token){
				      session_start();
				        $_SESSION['auth'] = $user;
				        setcookie('remember', $remember_token,60*60*24*7);
				        App::redirect('account.php');
			    }
			    else{
			  	   setcookie('remember', NUL, -1);
			    }
			    
			}else{
			  	setcookie('remember', NUL, -1);
			     }
    }
}*/

// on ne ferme pas la balise php pour éviter les erreurs d'entete