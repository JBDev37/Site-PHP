<?php
class Auth {

	private $options = [
      'restriction_msg' => "Vous n'avez pas le droit d'accéder à cette page"

	];

	private $session;

	public function __construct($session, $options = []){
		$this->options = array_merge($this->options, $options);
		$this->session  = $session;
	}

	static function str_random($length){

	$alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
	return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);

	}
    


	
	public function register($db, $username, $sexe ,$password, $email, $naissance){
		    
	  		$password = password_hash($password, PASSWORD_BCRYPT);
	  		$token = self::str_random(60);
	 	  	$db->query('INSERT INTO wp_cendrillon_6239_users SET user_login = ?, user_sexe = ?, user_pass = ?, user_email = ?, naissance = ?,  user_activation_key = ? ', [$username , $sexe, $password, $email, $naissance , $token]);

	  		$user_id = $db->lastInsertId();

         if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $email)) // On filtre les serveurs qui présentent des bogues.
		{
			$passage_ligne = "\r\n";
		}
		else
		{
			$passage_ligne = "\n";
		}
		//=====Déclaration des messages au format texte et au format HTML.
		$message_txt = "Confirmez votre inscription";
		
		$message_html = "<!DOCTYPE html>
						<html>
							<head>
							<title>Confirmez votre inscription </title>
							 <style>
								   .button{
								   	    display: inline-block;
										margin-bottom: 0;
										font-weight: normal;
										text-align: center;
										vertical-align: middle;
										cursor: pointer;
										background-image: none;
										border: 1px solid transparent;
										white-space: nowrap;
										padding: 6px 16px;
										font-size: 13px;
										line-height: 1.846;
										border-radius: 3px;
										color: #ffffff;
										border-color: transparent;
										text-decoration:none;
										  }

								 	.blue{
								 		background-color: #2196f3;
								 		}

								 	.red{
								 		background-color: #e51c23;
								 		}

								 	.vert{
								 		background-color: #4caf50;
								 		}

									.message-gauche{
									    background-color: #ffffff;
									    border-radius: 2px;
									    margin-bottom: 15px;
									    box-shadow: 0px 0px 0.5px 0px rgba(0, 0, 0, 0.7); 
									}

									.container-messages-gauche{
									    color: #000000;
									}

									.titre_message_container{
									    width: 100%;
									    height: 30px;
									    background-color: rgba(10,104,180,0.1);
									    padding-left: 5px;
									    border-radius: 2px;
									}

									.content-message-gauche{
									    min-height: 80px;
									    color: #000000;
									    font-family: Lato, sans-serif;
									    font-size: 15px;
									    line-height: 20px;
									    padding: 8px;
									    overflow-y: hidden;
									    font-weight: normal;
									}

									.titre_message{
									    display: inline-block;
									    font-weight: bold;
									    font-size: 16px;
									    color: #2196f3;
									    padding-top: 5px;
									}

									.footer-message{
									    display: block;
									    background-color: rgba(10,104,180,0.1);
									    height: 40px;
									    border-radius: 2px;
									    padding-left: 5px;
									}

									.date-message{
									    margin-top: 10px;
									    display: inline-block;
									    color: #000000;
									    font-weight: normal;
									    float: right;
									}

									.confiance-user{
									    display: inline-block;
									    position: relative;
									    width: 160px;
									    height: 60px;
									    border-radius: 2px;
									    color: #9e2f2f;
									    font-size: 14px;
									    padding: 5px;
									    margin-right: 10px;
									    margin-bottom: 10px;
									    box-shadow: 0px 0px 1px 0px rgba(0, 0, 0, 0.7);
									}

									.titre-nbr-aide-user{
									    font-size: 14px;
									    color: #0a68b4;
									    text-align: center;
									    font-weight: bold;
									    margin-bottom:5px;
									}

									.content-nbr-aide-user{
									    font-size: 35px;
									    font-weight: bold;
									    text-align: center;

									}

							</style>

							</head>
							<body>

							<div class=\"message-gauche\">

							    <div class=\"container-messages-gauche\">
								      <div class=\"titre_message_container\">
									      <div class=\"titre_message\">Bienvenue sur Kurbys</div>
									  </div>
									      <div class=\"content-message-gauche\">
											      Afin de valider votre compte, merci de cliquer sur ce <a href=\"https://kurbys.com/confirm.php?ID=$user_id&token=$token\" >lien</a>
									      </div>
									        
									      <div class=\"footer-message\">
									      Pour toute demande, contactez editions@seconde-vie.fr
									       <div class=\"titre_message\">Des conseils, des solutions !</div>

							  			   </div>
							           
							    </div>

							</div>


							 </body>
					    </html>";
		//==========
		 
		//=====Lecture et mise en forme de la pièce jointe.
		/*$fichier   = fopen("image.jpg", "r");
		$attachement = fread($fichier, filesize("image.jpg"));
		$attachement = chunk_split(base64_encode($attachement));
		fclose($fichier);*/
		//==========
		 
		//=====Création de la boundary.
		$boundary = "-----=".md5(rand());
		$boundary_alt = "-----=".md5(rand());
		//==========
		 
		//=====Définition du sujet.
		$sujet = "Confirmation d'inscription";
		//=========
		 
		//=====Création du header de l'e-mail.
		$header = "From: \"Kurbys\"<contact@kurbys.com>".$passage_ligne;
		$header.= "Reply-to: \"Kurbys\" <contact@kurbys.com>".$passage_ligne;
		$header.= "MIME-Version: 1.0".$passage_ligne;
		$header.= "Content-Type: multipart/mixed;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
		//==========
		 
		//=====Création du message.
		$message = $passage_ligne."--".$boundary.$passage_ligne;
		$message.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary_alt\"".$passage_ligne;
		$message.= $passage_ligne."--".$boundary_alt.$passage_ligne;
		//=====Ajout du message au format texte.
		$message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
		$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
		$message.= $passage_ligne.$message_txt.$passage_ligne;
		//==========
		 
		$message.= $passage_ligne."--".$boundary_alt.$passage_ligne;
		 
		//=====Ajout du message au format HTML.
		$message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
		$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
		$message.= $passage_ligne.$message_html.$passage_ligne;
		//==========
		 
		//=====On ferme la boundary alternative.
		$message.= $passage_ligne."--".$boundary_alt."--".$passage_ligne;
		//==========
		 
		 
		 
		$message.= $passage_ligne."--".$boundary.$passage_ligne;
		 
		//=====Ajout de la pièce jointe.
		/*$message.= "Content-Type: image/jpeg; name=\"image.jpg\"".$passage_ligne;
		$message.= "Content-Transfer-Encoding: base64".$passage_ligne;
		$message.= "Content-Disposition: attachment; filename=\"image.jpg\"".$passage_ligne;
		$message.= $passage_ligne.$attachement.$passage_ligne.$passage_ligne;
		$message.= $passage_ligne."--".$boundary."--".$passage_ligne; */
		//========== 
		//=====Envoi de l'e-mail.

		
		mail($email, $sujet,$message,$header);



	  		
	  		
	}







	public function confirm($db, $user_id, $token){

		$user = $db->query('SELECT * FROM wp_cendrillon_6239_users WHERE ID = ?', [$user_id])->fetch();

		if($user && $user->user_activation_key == $token){
			$db->query('UPDATE wp_cendrillon_6239_users SET user_activation_key = NULL, user_registered = NOW() WHERE ID = ?', [$user_id]);
			$this->session->write('auth', $user);/* on stock l'utilisateur*/
			return true;
			
		}
		    return false;
		}

	public function restrict(){
		if(!$this->session->read('auth')){
		$this->session->setFlash('danger', $this->options['restriction_msg']);
		header('Location: login.php');
		exit();
	   }
    }
 
     public function user(){
     	if(!$this->session->read('auth')){
     		return false;
     	}

     	return $this->session->read('auth');
     }

     public function connect($user){
     	$this->session->write('auth', $user);

     }



    public function connectFromCookie($db){
  
	if(isset($_COOKIE['remember']) && !$this->user()){
		  $remember_token = $_COOKIE['remember'];
		  $parts = explode('==', $remember_token);
		  $user_id = $parts[0];
		  $user = $db->query('SELECT * FROM wp_cendrillon_6239_users WHERE ID = ?',[$user_id])->fetch();
		   if ($user) {
			    $expected = $user_id.'=='. $user->remember_token.sha1($user_id.'ratonlaveur');
			    if($expected == $remember_token){
			    	$this->connect($user);
				       setcookie('remember', $remember_token,60*60*24*7);
			    }
			    else{
			  	   setcookie('remember', NUL, -1);
			    }
			    
			}else{
			  	setcookie('remember', NUL, -1);
			     }
    }
    }

    public function login($db, $username, $password){

    $user = $db->query('SELECT * FROM wp_cendrillon_6239_users WHERE (user_login = :username OR user_email = :username) AND user_registered IS NOT NULL', ['username' =>$username])->fetch();
    if(password_verify($password, $user->user_pass)){
        $this->connect($user);
         
         return $user;

        header('Location: account.php');
        exit();
    }else{
        return true;
        }
    }


    public function remember($db, $user_id){
    	$remember_token = Str::random(250);
         $db->query('UPDATE wp_cendrillon_6239_users SET remember_token = ? WHERE ID = ?',[$remember_token, $user_id]);
         setcookie('remember', $user_id.'=='. $remember_token.sha1($user_id.'ratonlaveur'), time()*60*60*24*7);
    }



    
}
























