<?php require_once "inc/functions.php"; ?>
<?php logged_only(); ?>
<?php  require "inc/header.php"; ?>
<?php  require "side-bar-right.php"; ?>
<?php  require "side-bar.php"; ?>

<div class="container-messages">


<div class="register-form-recherche blanc">

        <form enctype="multipart/form-data" action="recherche_pseudo.php" method="post">
            <fieldset>
            	
	                <legend>Rechercher un pseudo</legend>
	                 <div class="form-group">
				    <label for="">Pseudo recherché :</label>
				    <input type="text" class="form-control" name="pseudo" placeholder="Pseudo">
				  </div>

	            <input type="submit" name="submit" value="valider" class="btn btn-success"/>
	        </fieldset>
        </form>

    
</div>

<?php

if(isset($_POST['submit'])){
	echo "</br>";
$pseudo = htmlspecialchars($_POST['pseudo']);
/* on cherche les pseudo dans la table*/
$conseillere = $pdo->prepare('SELECT * FROM wp_cendrillon_6239_users WHERE user_login LIKE "%'.$pseudo.'%" ORDER BY last_connexion DESC');
$conseillere->execute([$pseudo]); 

if($conseillere->rowCount() > 0){

		while ($affiche_conseillere = $conseillere->fetch()){

			$author_id = $affiche_conseillere->ID;
			$name_author = $affiche_conseillere->user_login;
		/* On recherhce le sexe de l'auteur */
			$user_Sexe = User::user_sexe($db, $author_id);
		    $user_name = User::user_name($db, $author_id);

		/* on cherche si l'auteur est connecté*/
		$user_online = User::user_online($db, $author_id);

		$insert_user_id = User::update_user_name($db,$name_author);
		$insert_user_sexe = User::update_user_sexe($db,$author_id);
		$nbr_aide = USer::nbr_personne_aide($db, $author_id);
		$confiance = User::indice_confiance($db,$author_id);

		$req = $pdo->prepare('SELECT ID, presentation FROM wp_cendrillon_6239_users WHERE ID=?');
		$req->execute([$author_id]);
		$req1 = $req->fetch();
			 if($req1){
		         $presentation = $req1->presentation;
				     if(!$presentation){ 
				     	$presentation = $name_author." n'a pas encore de présentation ! ";}}

		 ?>

		<div class="message-gauche">

		    <div class="container-messages-gauche">
			      <div class="titre_message_container">

			         <div class="titre_message"> 
						<?php if ($user_Sexe == "fille"){?>
			            <div class="nom-conseillere-fille" ><?php echo "<a href=\"profile.php?user=$author_id\">$name_author</a>" ?></div>
			            <?php }else {?>
			            <div class="nom-conseillere-garcon" ><?php echo "<a href=\"profile.php?user=$author_id\">$name_author</a>" ?></div>
			            <?php }?>
			         </div>
		       			 <?php if($user_online == true){
		         		echo "<img class=\"user_online\" src=\"img/Point_vert.gif\">"; } ?>
			    </div>
			     
			      <div class="content-message-gauche"> <?php echo strip_tags(trim(Emojione\Emojione::shortnameToImage(str_replace("\\", " ", "$presentation"))));?></div>
			        
			      <div class="footer-message">
			            
		      
			            	                
			             <div class="user-profil-conseillere"><img style="padding-bottom: 1px" src="/img/user.png"><?php echo "<a href=\"profile.php?user=$author_id\"> Profil</a>"?></div>

			            <div class="indice-confiance-conseillere"><img src="img/confiance.png"> Confiance : <strong><?php echo round($confiance).'%' ?></strong></div>

			            <div class="personne-aide-conseillere"><img src="img/aide.png"> Personne aidées : <strong><?php echo $nbr_aide?></strong></div>

			            <?php echo "<a href=\"chat.php?id_send=$author_id\" class=\"btn btn-sm btn-primary private_message_search\">contacter</a>"; ?>  

			       </div>
		       </div>
		</div>




			<?php

			}
		} else { echo "Aucun resultat";}
	}
	?>

<?php  require "inc/footer.php"; ?>