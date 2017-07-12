<?php require_once "inc/functions.php"; ?>
<?php  require "inc/header.php"; ?>
<?php  require "side-bar-right.php"; ?>
<?php  require "side-bar.php"; ?>
<?php




    if(isset($_POST['envoi'])){
            $nom = User::user_name($db,$my_id);
            $message = $_POST['message'];
            $titre = $_POST['titre'];
            $mail = 'editions@seconde-vie.fr';
            $mail1 = User::user_mail($db,$my_id);

        if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui présentent des bogues.
                {
                    $passage_ligne = "\r\n";
                }
                else
                {
                    $passage_ligne = "\n";
                }
                //=====Déclaration des messages au format texte et au format HTML.
                $message_txt = "Tu as recu une demande en ami !.";
                
                $message_html = "<html>
                                    <head>
                                     

                                    </head>
                                    <body>

                                    <strong> message de : </strong> $nom </br>

                                    <strong> mail : </strong> $mail1  </br>

                                    <strong> titre : </strong> $titre  </br>

                                    <strong> idée :</strong> $message </br>


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
                $sujet = "Ameliorer le site";
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

?>


<div class="container-messages">

    <div class="register-form blanc">



    <fieldset><legend style="color: #0a68b4"><b>Message envoyé</b></legend>
         <div class="presentation-site">Ton message a bien été envoyé !</br></br></div>
       
    </fieldset>
 
  





    </div>


</div>
<?php  require "inc/footer.php"; ?>