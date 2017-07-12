<?php require_once "inc/functions.php"; ?>
<?php  require "inc/header.php"; ?>
<?php  require "side-bar-right.php"; ?>
<?php  require "side-bar.php"; ?>

<div class="container-messages">

<?php
$user_id= $_GET['user'];
$name_user = User::user_name($db, $user_id);
	
/* on cherche les amis*/
$amis = $pdo->prepare('SELECT user_one, user_two FROM friends_list WHERE user_one = ? OR user_two = ? ORDER BY date_ DESC');
$amis->execute([$user_id, $user_id]);


if(!isset($_SESSION['auth'])): ?>
    <div class="connexion-obligatoire">
     <legend>Mes amis</legend>
        Vous devez être inscrit et connecté <a href="register.php" class="inscription btn btn-primary" role="button" >S'inscrire</a>
    </div>

<?php else: ?>


<legend class="legend_classement"><?php echo "Les amis de " .$name_user ?></legend>


<?php 

while ($affiche_amis = $amis->fetch()){
$user_one = $affiche_amis->user_one;
$user_two = $affiche_amis->user_two;

  if($user_one == $user_id){
	$author_id = $user_two;
	} else {
	$author_id = $user_one;
	}


/* On recherhce le sexe de l'auteur */
	$user_Sexe = User::user_sexe($db, $author_id);
    $user_name = User::user_name($db, $author_id);

/* on cherche si l'auteur est connecté*/
$user_online = User::user_online($db, $author_id);



$insert_user_id = User::update_user_name($db,$user_name);
$insert_user_sexe = User::update_user_sexe($db,$author_id);
$nbr_aide = User::nbr_personne_aide($db, $author_id);
$confiance = round(User::indice_confiance($db,$author_id));

$conseillère = User::conseillere($db, $author_id);

$req = $pdo->prepare('SELECT ID, presentation FROM wp_cendrillon_6239_users WHERE ID=?');
$req->execute([$author_id]);
$req1 = $req->fetch();
	 if($req1){
         $presentation = $req1->presentation;
		     if(!$presentation){ 
		        $name = User::user_name($db, $author_id);
		     	$presentation = $name." n'a pas encore de présentation ! ";}}

 ?>


<div class="message-gauche">

    <div class="container-messages-gauche">
	      <div class="titre_message_container">

	         <div class="titre_message"> 
				<?php if ($user_Sexe == "fille"){?>
	            <div class="nom-conseillere-fille" ><img src="img/fille.png"><?php echo "<a href=\"profile.php?user=$author_id\">$user_name</a>" ?></div>
	            <?php }else {?>
	            <div class="nom-conseillere-garcon" ><img src="img/garcon.png"><?php echo "<a href=\"profile.php?user=$author_id\">$user_name</a>" ?></div>
	            <?php }?>
	         </div>
				<?php if ($conseillère == true){
               echo "<a href=\"\" title=\"conseillèr(e)\"><img style=\"padding-bottom: 1px\" src=\"img/conseillere.png\"></a>";
                }?>

	         
	         <?php if($user_online == true){
         		echo "<img class=\"user_online\" src=\"img/Point_vert.gif\">"; } ?>
	    </div>
	     
	      <div class="content-message-gauche"> <?php echo Emojione\Emojione::shortnameToImage($presentation);?></div>
       
	      <div class="footer-message">

				<form method="POST">
                    
                 </form>
   
	                
	             <div class="user-profil-conseillere"><img style="padding-bottom: 1px" src="img/user.png"><?php echo "<a href=\"profile.php?user=$author_id\"> Profil</a>"?></div>

	            <div class="indice-confiance-conseillere"><img src="img/confiance.png"> Confiance : <strong><?php echo $confiance.'%' ?></strong></div>

	            <div class="personne-aide-conseillere"><img src="img/aide.png"> Personne aidées : <strong><?php echo$nbr_aide?></strong></div>
	            
	             <div class="private_message"><?php echo "<a href=\"chat.php?id_send=$author_id\" title=\"message privé\"> <img style=\"padding-bottom: 1px\" src=\"/img/comment.png\"></a>"?> </div>

	       </div>
       </div>
    
</div>




	<?php
 }
if(isset($_POST['supprimer'])){
   Friends::supprimer_ami($db,$author_id, $my_id);
header('Location: liste_amis.php'); 
}
	?>
<?php endif; ?>


<?php  require "inc/footer.php"; ?>