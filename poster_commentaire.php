<?php require_once "inc/functions.php"; ?>
<?php  require "inc/header.php"; ?>
<?php  require "side-bar-right.php"; ?>
<?php  require "side-bar.php"; ?>
<?php 

$user_id= $_GET['user']; 
User::ajout_visite_profile($db, $my_id ,$user_id); 
$affiche_visite = User::nbr_visite($db, $user_id);
$confiance = User::indice_confiance($db,$user_id);
$nbr_aide = User::nbr_personne_aide($db, $user_id);
$nbr_message_poste = User::nbr_message_poste($db, $user_id);
$nbr_message_signale = Messages::count_signaler_msg($db,$user_id);
$nbr_avertissement = Messages::count_avertissement($db,$user_id);
$name_author = User::user_name($db, $user_id);
$presentation = User::presentation_profile($db, $user_id);
$user_Sexe = User::user_sexe($db, $user_id);
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
?>


<div class="container-messages">
	<div class="blanc">
		<legend style="color: #0a68b4"><b>Laisser un commentaire sur le profil de  <em><?php echo $name_author;?> </em>
		            <?php if ($user_Sexe == "fille"){
		                      echo "<img src=\"img/fille.png\" width=\"16px\" height=\"16px\">";
		                        } else{
		                         echo "<img src=\"img/garcon.png\" width=\"16px\" height=\"16px\">";
		                        }?>
		            </b>
		            </legend>
		  
		<div class="container-messages-gauche">
		        <form enctype="multipart/form-data" action="" method="post">
		            <fieldset>
               		<label><strong>Commentaire :</strong></label>
		                <?php echo "<textarea id=\"m\" name=\"message\" onclick=\"outEmo()\"; class=\"modifier_area\" required/>  </textarea>";?><br/>
		                
		                <br/>
		                <div class="input-conseillere">
		                <input type="submit" name="submit" value="Valider" class="btn btn-primary"/>
		               </div>
		            </fieldset>
		                 <img class="emoticones-modifier"  src="emoticones/1f642.png" width="25px" height="25px" onclick="Show_emoticones();">   
		            
		             <div class="bloc-emoticones-poster-message"></div><?php require_once "emoticones.php"; ?>
		        </form>

	    </div>
</div>


     <?php
if (isset($_POST['submit'])){
    $message = strip_tags(trim($_POST['message']));
    $from_ = $my_id;
    $to_ = $user_id;
    $now = date("Y-m-d H:i:s");
    $req = $pdo->prepare("INSERT INTO commentaires SET from_ =?, to_ =?, commentaire = ?, date_ =? ");
    $req->execute([$from_, $to_, $message ,$now]);
    header("location:profile.php?user=".$user_id);
	};
?>



<?php



require "inc/footer.php"; ?>









