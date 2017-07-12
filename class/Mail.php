<?php

class Mail{


	static function mail_friends($mail,$confiance,$nbr_aide, $nbr_message_poste,$name){

		if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui présentent des bogues.
		{
			$passage_ligne = "\r\n";
		}
		else
		{
			$passage_ligne = "\n";
		}
		//=====Déclaration des messages au format texte et au format HTML.
		$message_txt = "Tu as recu une demande en ami";
		
		$message_html = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"
	                    \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
						<html xmlns:v=\"urn:schemas-microsoft-com:vml\">
							<head>

							<meta http-equiv=\"content-type\" content=\"text/html\"; charset=\"utf-8\">
							<meta name=\"viewport\" content=\"width-device-width; initial-scale=1.0; maximum-scale=1.0;\">



							
							 
							</head>
							<body>

							<table>
							<tr>
								<td> message1</td>
							</tr>
								
							</table>




    						
							 



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
		$sujet = "$name veut devenir ton ami";
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

		
		mail($mail, $sujet,$message,$header);
	}





















 	static function mail_ange($mail,$confiance,$nbr_aide, $nbr_message_poste,$name){

		if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui présentent des bogues.
		{
			$passage_ligne = "\r\n";
		}
		else
		{
			$passage_ligne = "\n";
		}
		//=====Déclaration des messages au format texte et au format HTML.
		$message_txt = "Tu as recu une demande d'ange gardien";
		
				$message_html = "<!DOCTYPE html>
						<html>
							<head>
							<title>Tu as recu une demande d'ange gardien </title>
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
									      <div class=\"titre_message\">$name veut devenir ton ange gardien</div>
									  </div>
									      <div class=\"content-message-gauche\">
											      <div class=\"confiance-user\">
													      <div class=\"titre-nbr-aide-user\">
													       Indice confiance
													      </div>
													      <div class=\"content-nbr-aide-user\">
													           $confiance%
													      </div>
													</div>
													<div class=\"confiance-user\">
													      <div class=\"titre-nbr-aide-user\">
													       Personnes aidées
													      </div>
													      <div class=\"content-nbr-aide-user\">
													          $nbr_aide
													      </div>
													</div>
													<div class=\"confiance-user\">
													      <div class=\"titre-nbr-aide-user\">
													       Messages postés
													      </div>
													      <div class=\"content-nbr-aide-user\">
													           $nbr_message_poste
													      </div>
													</div>
									      </div>
									        
									      <div class=\"footer-message\">
							  					<a href=\"http://www.kurbys.com/notifications.php \" class=\"button blue\" >Accepter</a>
							  					<a href=\"http://www.kurbys.com/notifications.php \" class=\"button red\" >Refuser</a>
							  					<a href=\"http://www.kurbys.com/notifications.php \" class=\"button vert\" >Profil</a>
							  					Pour toute demande, contactez editions@seconde-vie.fr
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
		$sujet = "$name veut devenir ton ange gardien";
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

		
		mail($mail, $sujet,$message,$header);
	}  



	static function changer_mdp($mail, $user_id, $token, $login){

		if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui présentent des bogues.
		{
			$passage_ligne = "\r\n";
		}
		else
		{
			$passage_ligne = "\n";
		}
		//=====Déclaration des messages au format texte et au format HTML.
		$message_txt = "Changer de mot de passe";
		
		$message_html = "<!DOCTYPE html>
						<html>
							<head>
							<title>Changer de mot de passe </title>
							 <style>


							</style>

							</head>
							<body>

							<strong>Pseudo : $login </strong></br></br>

                           Afin de changer votre mot de passe merci de cliquer sur ce lien :\n\nhttp://www.kurbys.com/reset.php?ID={$user_id}&token=$token

                           </br></br>

                           Pour toute demande, contactez editions@seconde-vie.fr


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
		$sujet = "Changer de mot de passe";
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

		
		mail($mail, $sujet,$message,$header);
	}

   











	




















}