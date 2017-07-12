<?php require_once "inc/functions.php"; ?>
<?php logged_only(); ?>
<?php  require "inc/header.php"; ?>
<?php  require "side-bar-right.php"; ?>
<?php  require "side-bar.php"; ?>

<div class="container-messages">

<?php

	
/* on cherche les conseillères dans la table*/
$conseillere = $pdo->query('SELECT * FROM wp_cendrillon_6239_conseillere ORDER BY indice_confiance DESC');
 ?>

<?php
if(!isset($_SESSION['auth'])): ?>
    <div class="connexion-obligatoire">
     <legend>Classement des meilleurs conseillers</legend>
        Oups...vous n'êtes pas connecté ! <a href="register-login.php" class="inscription btn btn-success role="button" >Connexion</a>
    </div>

<?php else: ?>


<legend class="legend_classement">Classement des meilleurs conseillers</legend>




<?php 
$classement = 1;
while ($affiche_conseillere = $conseillere->fetch()){
	    $confiance = $affiche_conseillere->indice_confiance;
		$author_id = $affiche_conseillere->user_id;
		$name_author = $affiche_conseillere->displayname;
	    /* On recherhce le sexe de l'auteur */
		$user_Sexe = User::user_sexe($db, $author_id);
	    $user_name = User::user_name($db, $author_id);
		/* on cherche si l'auteur est connecté*/
		$user_online = User::user_online($db, $author_id);

		$last_connexion = $affiche_conseillere->last_connexion;
                $date_c = strtotime($last_connexion);
                $now   = time();
                $diff  = abs($now - $date_c);
                $jour = 7000*24*3600;

			
		$insert_user_id = User::update_user_name($db,$name_author);
		$insert_user_sexe = User::update_user_sexe($db,$author_id);
		$nbr_aide = USer::nbr_personne_aide($db, $author_id);
		$friends = Friends::is_friends($db,$my_id, $author_id);
		$request = Friends::count_friends_request($db,$my_id, $author_id);

		if ($diff<$jour) {
		?>


		<div class="message-gauche">

		    <div class="container-messages-gauche">
			      <div class="titre_message_container">

			         <div class="titre_message"> 
						<?php if ($user_Sexe == "fille"){?>
			            <div class="nom-conseillere-fille" ><?php echo "<a href=\"profile.php?user=$author_id\">$name_author</a>" ?></div>
			            <?php }else {?>
			            <div class="nom-conseillere-garcon" ><?php echo "<a href=\"profile.php?user=$author_id\">$name_author</a>" ?></div>
			            <?php }
			            ?> <div class="classement_statut"><?php
		                    if ($user_Sexe=="fille") {
		                        
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

		                    } ?>
		                </div>

		               
			         </div>

			         <div class="classement_conseillere"><?php echo 'n°'.$classement; ?></div> 
			         <?php if($user_online == true){
		         		echo "<img class=\"user_online\" src=\"img/Point_vert.png\">"; } ?>
			    </div>
			     
			      <div class="content-message-gauche"> <?php echo Emojione\Emojione::shortnameToImage(str_replace("\\", " ", "$affiche_conseillere->presentation"));?></div>
			        
			      <div class="footer-message">

			             <div class="user-profil-conseillere"><img style="padding-bottom: 1px" src="img/user.png"><?php echo "<a href=\"profile.php?user=$author_id\"> Profil</a>"?></div>

			            <div class="indice-confiance-conseillere"><img src="img/confiance.png"> Confiance : <strong><?php echo $confiance.'%' ?></strong></div>

			            <div class="personne-aide-conseillere"><img src="img/aide.png"> Personne aidées : <strong><?php echo$nbr_aide?></strong></div>

			             <div class="private_message"><?php echo "<a href=\"chat.php?id_send=$author_id\" title=\"message privé\"> <img style=\"padding-bottom: 1px\" src=\"img/comment.png\"></a>"?> </div>

			       </div>
		       </div>
		    
		</div>


		<?php  $classement =  $classement +1;  ?>


			<?php
		 } }
			
			?>
<?php endif; ?>

<script type="text/javascript">
$(document).ready(function(){
	$("#demande_ami").submit(function(){
		$.post('demande_ami.php',{author_id : $('#author_id').attr('name')});
		return false;

	}); 
});

</script>
<?php  require "inc/footer.php"; ?>