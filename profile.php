<?php require_once "inc/functions.php"; ?>
<?php  require "inc/header.php"; ?>
<?php  require "side-bar-right.php"; ?>
<?php  require "side-bar.php"; ?>
<?php 


if(!isset($_SESSION['auth'])){
  header("location:register.php");
}



if(!isset($_GET['user']) && isset($my_id)){

$affiche_visite = User::nbr_visite($db, $my_id);
$confiance = User::indice_confiance($db,$my_id);
$nbr_aide = User::nbr_personne_aide($db, $my_id);
$nbr_message_poste = User::nbr_message_poste($db, $my_id);
$nbr_commentaires = User::nbr_commentaires($db, $my_id);
$nbr_message_signale = Messages::count_signaler_msg($db,$my_id);
$nbr_avertissement = Messages::count_avertissement($db,$my_id);
$nbr_personne_qui_mon_aide = User::nbr_personne_qui_mon_aide($db, $my_id);
$nbr_conseils = Messages::nbr_aide_poste($db, $my_id);
$nbr_friends = Friends::count_friends($db,$my_id);
$ange_id = Anges::my_angel($db,$my_id);
$ange_name = User::user_name($db, $ange_id);
$kurbys_id = Anges::my_kurbys($db,$my_id);
$kurbys_name = User::user_name($db, $kurbys_id);
$conseillere = User::conseillere($db,$my_id);
$sexe = User::user_sexe($db, $my_id);


$req = $pdo->prepare('SELECT ID, presentation FROM wp_cendrillon_6239_users WHERE ID=?');
$req->execute([$my_id]);
$req1 = $req->fetch();
	 if($req1){
         $presentation = $req1->presentation;
		     if(!$presentation){ 
		        $name = User::user_name($db, $my_id);
		     	$presentation = $name." n'a pas encore de présentation ! ";}}
}

$req2 = $pdo->prepare('SELECT user_id, presentation FROM wp_cendrillon_6239_conseillere WHERE user_id=?');
$req2->execute([$my_id]);
$req3 = $req2->fetch();
     if($req3){
         $presentation_conseillere = $req3->presentation;
             if(!$presentation){ 
                $name = User::user_name($db, $my_id);
                $presentation_conseillere = $name." n'a pas encore de présentation ! ";}
}


if(isset($_POST['delete_ange'])){
Anges::delete_ange($db,$my_id);
header("location:profile.php");
}
if(isset($_POST['delete_kurbys'])){
Anges::delete_kurbys($db,$my_id);
header("location:profile.php");
}

if(!isset($_GET['user'])){
 ?>
<div class="container-messages">
    <?php if(isset($_SESSION['auth'])): ?>
        <div class="blanc register-form">
            <legend style="color: #0a68b4; margin-bottom: 10px;"><b>Mon Profil</b></legend>
          
                <div class="presentation-user">
                    <div class="titre-presentation-user">
                        <strong>Ma Présentation</strong> (visible par tous les utilisateurs)
                    </div>
                    <div class="content-presentation-user">
                        <?php echo Emojione\Emojione::shortnameToImage($presentation); ?>
                    </div>
                    
                </div>
                <?php echo "<a href=\"presentation_profile.php?id=$my_id\" class=\"profil btn-sm btn btn-success\" role=\"button\" >Modifier présentation</a>"; ?></br></br></br>
				<?php echo "<a href=\"ancien_contact.php\" class=\"profil btn-sm btn btn-primary\" role=\"button\" >Anciens contacts</a>"; ?></br></br>
				</br>

                <div class="profil_conseiller">
                <?php if($conseillère==true){
                    if ($sexe=="fille") {
                        echo "Statut conseillère : ";
                        if ($confiance<30) {
                            echo "<strong>Novice</strong>";
                        }
                        if (30 <=$confiance && $confiance <50) {
                            echo "<strong>Confirmé</strong>";
                        }
                        if (50 <=$confiance && $confiance <70) {
                            echo "<strong>Princesse</strong>";
                        }
                        if (70 <=$confiance && $confiance <90) {
                            echo "<strong>Impératrice<strong>";
                        }
                        if ($confiance >=90) {
                            echo "<strong>Ange Gardien</strong>";
                        }

                    } else {
                        echo "Statut conseiller : ";
                        if ($confiance<30) {
                            echo "<strong>Novice</strong>";
                        }
                        if (30 <=$confiance && $confiance <50) {
                            echo "<strong>Confirmé</strong>";
                        }
                        if (50 <=$confiance && $confiance <70) {
                            echo "<strong>Prince</strong>";
                        }
                        if (70 <=$confiance && $confiance <90) {
                            echo "<strong>Empereur</strong>";
                        }
                        if ($confiance >=90) {
                            echo "<strong>Ange Gardien</strong>";
                        }

                    } echo "</br></br>";

                echo "<div class=\"presentation-user\">
                    <div class=\"titre-presentation-user\">
                        <strong>Ma Présentation de conseiller</strong> (visible par tous les utilisateurs)
                    </div>
                    <div class=\"content-presentation-user\">";
                      echo Emojione\Emojione::shortnameToImage($presentation_conseillere);
                    echo "</div>
                    
                </div>
                  <a href=\"presentation_conseillere.php?id=$my_id\" class=\"profil_conseillere btn btn-primary btn-sm\" role=\"button\" >Modifier</a>
                 </br></br>";

                }

                else {echo 'Statut conseiller :<strong> Tu n\'es pas conseiller</strong>';}
                 ?></div> </br>

                

                <?php if($conseillère==true):?>
                        <table class="table_conseiller">
                          <tr>
                              <td >
                                <div class="statut_conseiller"></div>
                                <?php if($confiance<30){
                                echo "<div class=\"triangle-vert\"></div>";
                                  } else{
                                echo "<div class=\"triangle-vert\" style=\"visibility: hidden;\"></div>";
                                    } ?>
                                <img src="img/novice_big.png" ></br><div>Novice</div>

                              </td>

                              <td>
                                <div class="statut_conseiller"></div>
                                <?php if(30 <=$confiance && $confiance <50){
                                echo "<div class=\"triangle-vert\"></div>";
                                  } else{
                                echo "<div class=\"triangle-vert\" style=\"visibility: hidden;\"></div>";
                                    } ?>  
                                <img src="img/confirm_big.png" ><div>Confirmé</div>

                              </td>

                              <td>
                                <div class="statut_conseiller"></div>
                                <?php if(50 <=$confiance && $confiance <70){
                                echo "<div class=\"triangle-vert\"></div>";
                                  } else{
                                echo "<div class=\"triangle-vert\" style=\"visibility: hidden;\"></div>";
                                    } ?>    
                                <img src="img/prince_big.png" >
                                <?php if($sexe=="fille"){
                                echo"<div>Princesse</div>";
                                }else{echo"<div>Prince</div>"; } ?>

                              </td>

                              <td>
                                <div class="statut_conseiller"></div>
                                <?php if(70 <=$confiance && $confiance <90){
                                echo "<div class=\"triangle-vert\"></div>";
                                  } else{
                                echo "<div class=\"triangle-vert\" style=\"visibility: hidden;\"></div>";
                                    } ?>    
                                <img src="img/empereur_big.png" >
                                 <?php if($sexe=="fille"){
                                echo"<div>Impératrice</div>";
                                }else{echo"<div>Empereur</div>"; } ?>

                              </td>

                              <td>
                                <div class="statut_conseiller"></div>
                                <?php if( $confiance >=90){
                                echo "<div class=\"triangle-vert\"></div>";
                                  } else{
                                echo "<div class=\"triangle-vert\" style=\"visibility: hidden;\"></div>";
                                    } ?>    
                                <img src="img/ange_gardien.png" width="32" height="32"><div style="height: 19px;">Ange Gardien</div>

                              </td>

                              
                            
                          </tr>

                     </table></br></br></br></br>  
                <?php endif; ?>


                <div class="confiance-user">
                    <div class="titre-confiance-user">
                        Indice confiance
                    </div>
                    <div class="content-confiance-user">
                       <?php echo round($confiance).'%' ;?>
                    </div>
               </div>
                                       
                <a href="liste_amis.php"><div class="confiance-user">
                    <div class="titre-ami-user">
                        Mes Amis
                    </div>
                    <div class="content-ami-user">
                        <?php echo  $nbr_friends ;?>
                    </div>
                </div></a>

                <a href="visite_profile.php"><div class="confiance-user">
                    <div class="titre-nbr-visites-user">
                        Visite sur mon profil
                    </div>
                    <div class="content-nbr-visites-user">
                        <?php echo $affiche_visite; ?>
                    </div>
                </div></a>

                <a href="personnes_aide.php"><div class="confiance-user">
                    <div class="titre-nbr-aide-user">
                        Personnes aidées
                    </div>
                    <div class="content-nbr-aide-user">
                        <?php echo $nbr_aide; ?>
                    </div>
                </div></a>

                <a href="mes_conseils.php"><div class="confiance-user">
                    <div class="titre-nbr-aide-user">
                        Mes conseils
                    </div>
                    <div class="content-nbr-aide-user">
                         <?php echo $nbr_conseils; ?>
                    </div>
                </div></a>

                <a href="ils_mont_aide.php"><div class="confiance-user">
                    <div class="titre-nbr-aide-user">
                        Ils m'ont aidé
                    </div>
                    <div class="content-nbr-aide-user">
                        <?php echo $nbr_personne_qui_mon_aide; ?>
                    </div>
                </div></a>

                <a href="mes_messages.php"><div class="confiance-user">
                    <div class="titre-poster-message-user">
                        Messages postés
                    </div>
                    <div class="content-poster-message-user">
                        <?php echo $nbr_message_poste; ?> 
                    </div>
                </div></a>

                <a href="mes_comentaires.php"><div class="confiance-user">
                    <div class="titre-poster-message-user">
                        Commentaires
                    </div>
                    <div class="content-poster-message-user">
                        <?php echo $nbr_commentaires; ?> 
                    </div>
                </div></a>

                <div class="confiance-user">
                    <div class="titre-message-signale-user">
                        Messages signalés
                    </div>
                    <div class="content-message-signale-user">
                        <?php echo $nbr_message_signale; ?>
                    </div>
                </div>

               <a href="avertissement.php"><div class="confiance-user">
                    <div class="titre-gain-user">
                        Avertissement
                    </div>
                    <div class="content-gain-user">
                        <?php echo $nbr_avertissement; ?>
                    </div>
                </div></a>

                <a href="Extrait - Le Secret de Cendrillon.pdf"><div class="confiance-user1">
                    <div class="content-gain-user1">
                        <img src="img/logo_cendrillon.png" class="logo_cendrillon">
                    </div>
                </div></a>


                </br></br>
                <p><strong> Lien si tu souhaites partager ton profil sur les réseaux sociaux : </strong></p>
                        <?php $adresse_url =  'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'?user='.$my_id;

                        echo "<input type=\"text\" value=\"$adresse_url\" class=\"adresse_url\">"; ?></br></br>


            </div>
   

            
        </div>


            

    <?php else: ?>
       

    <?php endif; ?>
</div><!-- container message-->


<!-- ///////////////////////////////////////  visiteur profile       //////////////////////////////////////////////////////////////////////////////////////////// -->
<?php }else{ 
$user_id= $_GET['user']; 
User::ajout_visite_profile($db, $my_id ,$user_id); 
$affiche_visite = User::nbr_visite($db, $user_id);
$confiance = User::indice_confiance($db,$user_id);
$nbr_aide = User::nbr_personne_aide($db, $user_id);
$nbr_message_poste = User::nbr_message_poste($db, $user_id);
$nbr_commentaires = User::nbr_commentaires($db, $user_id);
$nbr_message_signale = Messages::count_signaler_msg($db,$user_id);
$nbr_avertissement = Messages::count_avertissement($db,$user_id);
$name_author = User::user_name($db, $user_id);
$user_Sexe = User::user_sexe($db, $user_id);
$my_name = User::user_name($db, $my_id);
$nbr_personne_qui_mon_aide = User::nbr_personne_qui_mon_aide($db, $user_id);
$nbr_friends = Friends::count_friends($db,$user_id);
$friends = Friends::is_friends($db,$my_id, $user_id);
$request = Friends::count_friends_request($db,$my_id, $user_id);
$conseillère = User::conseillere($db, $user_id);
$je_suis_anges = Anges::is_anges($db,$my_id);
$user_is_anges = Anges::is_anges($db,$user_id);
$anges_request = Anges::count_anges_request($db,$my_id, $user_id);
$post_ange = $user_id * 2; //variable aléatoire pour valider formulaire ange
$possede_ange = Anges::possede_anges($db,$user_id);
$ange_id = Anges::my_angel($db,$user_id);
$ange_name = User::user_name($db, $ange_id);
$kurbys_id = Anges::my_kurbys($db,$user_id);
$kurbys_name = User::user_name($db, $kurbys_id);
$mail_user = User::user_mail($db,$user_id);
$nbr_conseils = Messages::nbr_aide_poste($db, $user_id);
$naissance = User::user_naissance($db,$user_id);

$date = explode("-", $naissance);
$annee = $date[0];
$mois= $date[1];
$jour = $date[2];

$today = explode('/',date('d/m/y'));
$annee_today = $today[2];
$mois_today= $today[1];
$jour_today = $today[0];

if(($mois < $mois_today) || (($mois == $mois_today && $jour<=$jour_today))){
        $age = $annee_today+2000-$annee;
        }else{
            $age = $annee_today+2000-$annee-1;
          };



$req = $pdo->prepare('SELECT ID, presentation FROM wp_cendrillon_6239_users WHERE ID=?');
$req->execute([$user_id]);
$req1 = $req->fetch();
	 if($req1){
         $presentation = $req1->presentation;
		     if(!$presentation){ 
		        $name = User::user_name($db, $user_id);
		     	$presentation = $name." n'a pas encore de présentation ! ";}}
?>



<div class="container-messages">
    <?php if(isset($_SESSION['auth'])): ?>
        <div class="blanc">
            <legend style="color: #0a68b4; margin-bottom: 10px;"><b>Profil de <em><?php echo $name_author;?> </em>
            <?php if ($user_Sexe == "fille"){
                      echo "<img src=\"img/fille.png\" width=\"16px\" height=\"16px\">";
                        } else{
                         echo "<img src=\"img/garcon.png\" width=\"16px\" height=\"16px\">";
                        }?>

            <?php if ($conseillère == true){
	                   echo "<a title=\"conseiller\" ><img class=\" option_profil_conseillere \" src=\"img/conseillere.png\"></a>";
	                    }
					echo "<a href=\"poster_commentaire.php?user=$user_id\" class=\" commentaire btn btn-sm btn-warning\" title=\"\"><img src=\"book.png\"> Laisser un commentaire</a>";
                    ?>
            </b>
            </legend>

            <?php 
              /*    Demande en ami */
                      if($friends == false && $request==false ){ ?>  
                      
                      <form class="" id="demande_ami"  name="form2" method="POST" >
                            <?php echo "<input type=\"submit\" name=\"$user_id\" value='+1 ami' id=\"author_id\" class=\" option_profil btn btn-sm btn-success\" onClick=\"this.value='En attente'\">";?>
                      </form> 
                           <?php }

                      if($friends == false && $request==true ){ ?>  
                             <?php 
                            
                              echo "<input type=\"submit\" name=\"\" value='En attente' class=\" option_profil btn btn-sm btn-success\" >";
                               
                          }
                      if($friends == true){
                      echo "<a href=\"\"  title=\"c'est un ami\"><input type=\"submit\" name=\"delete_friend\"  value='Ami' class=\" option_profil btn btn-sm btn-success\" ></a>";
                        } 
                ?>  

            <?php echo "<button class=\" option_profil btn btn-sm btn-primary\" type=\"\"><a href=\"chat.php?user=$user_id\"><img src=\"img/chat.png\">  Message privé</button></a>";?>

          

            <?php 

                ?>  
                    <form method="POST">
                        <?php $aleatoire = $user_id+2;//on creer une variable aleatoire pour avoir un 'name' unique
                         
                        $is_signaler = User::is_signaler_user($db,$my_id, $user_id);
                        if($is_signaler==true){
                         echo "<input type=\"submit\" disabled name=\"$aleatoire\" value='Signalé !' id=\"$aleatoire\" class=\" option_profil btn btn-sm btn-danger\">";
                         }else{
                            echo "<input type=\"submit\"  name=\"$aleatoire\" value='signaler' id=\"$aleatoire\" class=\" option_profil btn btn-sm btn-danger\">";
                         } ?>

                    </form>

            <div class="presentation-user">
                    <div class="titre-presentation-user">
                        <strong>Présentation</strong> 
                    </div>
                    <div class="content-presentation-user">
                        <?php echo Emojione\Emojione::shortnameToImage($presentation); ?>
                    </div>
                    
                </div>

                 </br></br>
                
                <div class="profil_conseiller">
                <?php if($conseillère==true){
                    if ($user_Sexe=="fille") {
                        echo "Statut conseillère : ";
                        if ($confiance<30) {
                            echo "<strong>Novice</strong>";
                        }
                        if (30 <=$confiance && $confiance <50) {
                            echo "<strong>Confirmé</strong>";
                        }
                        if (50 <=$confiance && $confiance <70) {
                            echo "<strong>Princesse</strong>";
                        }
                        if (70 <=$confiance && $confiance <90) {
                            echo "<strong>Impératrice<strong>";
                        }
                        if ($confiance >=90) {
                            echo "<strong>Ange Gardien</strong>";
                        }

                    } else {
                        echo "Statut conseiller : ";
                        if ($confiance<30) {
                            echo "<strong>Novice</strong>";
                        }
                        if (30 <=$confiance && $confiance <50) {
                            echo "<strong>Confirmé</strong>";
                        }
                        if (50 <=$confiance && $confiance <70) {
                            echo "<strong>Prince</strong>";
                        }
                        if (70 <=$confiance && $confiance <90) {
                            echo "<strong>Empereur</strong>";
                        }
                        if ($confiance >=90) {
                            echo "<strong>Ange Gardien</strong>";
                        }

                    }
                } ?> </div></br></br>

         <?php if($conseillère==true):?>
                <table class="table_conseiller">

                          <tr>
                              <td >
                                <div class="statut_conseiller"></div>
                                <?php if($confiance<30){
                                echo "<div class=\"triangle-vert\"></div>";
                                  } else{
                                echo "<div class=\"triangle-vert\" style=\"visibility: hidden;\"></div>";
                                    } ?>
                                <img src="img/novice_big.png" ></br><div>Novice</div>

                              </td>

                              <td>
                                <div class="statut_conseiller"></div>
                                <?php if(30 <=$confiance && $confiance <50){
                                echo "<div class=\"triangle-vert\"></div>";
                                  } else{
                                echo "<div class=\"triangle-vert\" style=\"visibility: hidden;\"></div>";
                                    } ?>  
                                <img src="img/confirm_big.png" ><div>Confirmé</div>

                              </td>

                              <td>
                                <div class="statut_conseiller"></div>
                                <?php if(50 <=$confiance && $confiance <70){
                                echo "<div class=\"triangle-vert\"></div>";
                                  } else{
                                echo "<div class=\"triangle-vert\" style=\"visibility: hidden;\"></div>";
                                    } ?>    
                                <img src="img/prince_big.png" >
                                <?php if($user_Sexe=="fille"){
                                echo"<div>Princesse</div>";
                                }else{echo"<div>Prince</div>"; } ?>

                              </td>

                              <td>
                                <div class="statut_conseiller"></div>
                                <?php if(70 <=$confiance && $confiance <90){
                                echo "<div class=\"triangle-vert\"></div>";
                                  } else{
                                echo "<div class=\"triangle-vert\" style=\"visibility: hidden;\"></div>";
                                    } ?>    
                                <img src="img/empereur_big.png" >
                                 <?php if($user_Sexe=="fille"){
                                echo"<div>Impératrice</div>";
                                }else{echo"<div>Empereur</div>"; } ?>

                              </td>

                              <td>
                                <div class="statut_conseiller"></div>
                                <?php if( $confiance >=90){
                                echo "<div class=\"triangle-vert\"></div>";
                                  } else{
                                echo "<div class=\"triangle-vert\" style=\"visibility: hidden;\"></div>";
                                    } ?>    
                                <img src="img/ange_gardien.png" width="32" height="32"><div style="height: 19px;">Ange Gardien</div>

                              </td>


                           
                          </tr>

                     </table></br></br></br></br>
                  <?php endif; ?>
                  
                 <?php if($age < 2000):{ ?>  
                <div class="confiance-user">
                    <div class="titre-confiance-user">
                        Age
                    </div>
                    <div class="content-confiance-user">
                       <?php echo $age;?>
                    </div>
               </div> <?php } endif;?>

                <div class="confiance-user">
                    <div class="titre-confiance-user">
                        Indice confiance
                    </div>
                    <div class="content-confiance-user">
                       <?php echo round($confiance).'%' ;?>
                    </div>
               </div>

                 <?php echo "<a href=\"conseils_user.php?user=$user_id\">" ?> <div class="confiance-user">
                    <div class="titre-nbr-aide-user">
                        Ses conseils
                    </div>
                    <div class="content-nbr-aide-user">
                         <?php echo $nbr_conseils; ?>
                    </div>
                </div></a>
                                       
                 <?php echo "<a href=\"liste_amis_user.php?user=$user_id\">" ?> <div class="confiance-user">
                    <div class="titre-ami-user">
                       Ses Amis
                    </div>
                    <div class="content-ami-user">
                        <?php echo  $nbr_friends ;?>
                    </div>
                </div></a> 

                <?php echo "<a href=\"personnes_aide_user.php?user=$user_id\">" ?> <div class="confiance-user">
                    <div class="titre-nbr-aide-user">
                        Personnes aidées
                    </div>
                    <div class="content-nbr-aide-user">
                        <?php echo $nbr_aide; ?>
                    </div>
                </div></a>

                <?php echo "<a href=\"messages_user.php?user=$user_id\">" ?> <div class="confiance-user">
                    <div class="titre-poster-message-user">
                        Messages postés
                    </div>
                    <div class="content-poster-message-user">
                        <?php echo $nbr_message_poste; ?> 
                    </div>
                </div></a>

                 <?php echo "<a href=\"comentaires_user.php?user=$user_id\">" ?> <div class="confiance-user">
                    <div class="titre-poster-message-user">
                        Commentaires
                    </div>
                    <div class="content-poster-message-user">
                        <?php echo $nbr_commentaires; ?> 
                    </div>
                </div></a>

               <div class="confiance-user">
                    <div class="titre-gain-user">
                        Avertissement
                    </div>
                    <div class="content-gain-user">
                        <?php echo $nbr_avertissement; ?>
                    </div>
                </div>

                
                <a href="Extrait - Le Secret de Cendrillon.pdf"><div class="confiance-user1">
                    <div class="content-gain-user1">
                        <img src="img/logo_cendrillon.png" class="logo_cendrillon">
                    </div>
                </div></a>


                </br></br>
                
            </div>


        </div>
<?php 

$confiance1 = User::indice_confiance($db,$my_id);
$nbr_aide1 = User::nbr_personne_aide($db, $my_id);
$nbr_message_poste1 = User::nbr_message_poste($db, $my_id);
$name = User::user_name($db, $my_id);

if (isset($_POST[$aleatoire])){
    User::user_signale($db,$my_id, $user_id);
    header("location:profile.php?user=".$user_id);
    }
 
if (isset($_POST[$user_id])){
    Friends::friends_request($db,$my_id, $user_id);
    /*Mail::mail_friends($mail_user,$confiance1,$nbr_aide1, $nbr_message_poste1,$name);*/

 
/*date_default_timezone_set("Europe/Paris"); 
  $mail             = new PHPMailer(); 
  $body             = "Test de PHPMailer."; 
  //$mail->IsSMTP();
  $mail->SMTPAuth   = true;
  $mail->SMTPOptions = array('ssl' => array('verify_peer' => false,'verify_peer_name' => false,'allow_self_signed' => true)); // ignorer l'erreur de certificat.
  $mail->Host       = "mail.kurbys.com";  
  $mail->Port       = 587;
  $mail->Username   = "contact@kurbys.com";
  $mail->Password   = "*/      /*Kurbys87./*";        
  $mail->From       = "contact@kurbys.com"; //adresse d’envoi correspondant au login entré précédemment
  $mail->FromName   = "Kurbys"; // nom qui sera affiché
  $mail->Subject    = "message test"; // sujet
  $mail->AltBody    = "corps du message au format texte"; //Body au format texte
  $mail->WordWrap   = 50; // nombre de caractères pour le retour à la ligne automatique
  $mail->MsgHTML($body); 
  $mail->AddReplyTo("contact@kurbys.com","Kurbys");
  /*$mail->AddAttachment("./examples/images/phpmailer.gif");// pièce jointe si besoin
  $mail->AddAddress($mail_user);
  $mail->IsHTML(true); // envoyer au format html, passer a false si en mode texte 
  if(!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
  } else {
    echo "Le message à bien été envoyé";
  } */
   /* header("location:profile.php?user=".$user_id);*/
}
if (isset($_POST[$post_ange])){
    Mail::mail_ange($mail, $confiance1,$nbr_aide1, $nbr_message_poste1,$name);
    Anges::anges_request($db,$my_id, $user_id);
    header("location:profile.php?user=".$user_id);
    }

?>
    <?php else: ?>
        
         <div class="connexion-obligatoire-repondre">
             <legend class="donner-conseil">Profil</legend> 
            Vous devez être inscrit et connecté     <a href="register.php" class="inscription btn btn-primary" role="button" >S'inscrire</a></br>
        </div>


    <?php endif; ?>
</div><!-- container message-->





<?php }?>
<?php  require "inc/footer.php"; ?>

 