<?php  require "inc/header.php"; ?>

<?php  require "side-bar.php"; ?>
<?php  require "side-bar-right.php"; ?>

<div class="container-messages">
<?php

$user_id= $_GET['user'];
$name_user = User::user_name($db, $user_id);

$recherche_messages = $pdo->prepare('SELECT ID, post_author, post_title, post_content, post_type, post_date, categorie FROM wp_cendrillon_6239_posts WHERE post_type = "messages" AND post_author = ? ORDER BY post_date DESC');
$recherche_messages->execute([$user_id]);

?><legend class="legend-visite"><b><?php echo "Les messages de " .$name_user ?></b></legend><?php
while($affiche_messages = $recherche_messages->fetch()){

$message_id = $affiche_messages->ID;
$author_id = $user_id;
$categorie_msg = $affiche_messages->categorie;

/* on compte le nombre de commentaire pour chaque message*/
$nb_com = Messages::nbr_commentaire($db, $message_id);

/* on recherche le nom de l'auteur */
$name_author = User::user_name($db, $author_id);


/* on cherche si l'auteur est connecté*/
$req_online = $pdo->prepare('SELECT COUNT(ID_user) FROM users_online WHERE ID_user = :ID_user ');
$req_online->bindParam(':ID_user', $author_id, PDO::PARAM_STR);
$req_online->execute();
$author_online = $req_online->fetchColumn();

/* On recherhce le sexe de l'auteur */
$sexe_author = User::user_sexe($db, $author_id);

           
$date_message = $affiche_messages->post_date;
$date_c = strtotime($date_message);
$now   = time();
$diff  = abs($now - $date_c);
$jour = 1400*24*3600;

/*on affiche le mois en francais*/
$mois = array(1 =>" janvier " , " février ", " mars ", " avril ", " mai ", " juin ", " juillet ", " août "," septembre "," octobre "," novembre "," decembre ");
$mois[date('n',$date_c)];
$num_mois = date('n',$date_c);
$name_mois = $mois[$num_mois];

$user_Sexe = User::user_sexe($db, $author_id);


            ?>

<div class="message-gauche">

    <div class="container-messages-gauche">
      <div class="titre_message_container">

         <?php if ($user_Sexe == "garcon"){
         echo "<div class=\"titre_message\"><a href=\"lire-message.php?id={$affiche_messages->ID}\">$affiche_messages->post_title</a> </div>";
         } else {
         echo "<div class=\"titre_message_fille\" ><a href=\"lire-message.php?id={$affiche_messages->ID}\">$affiche_messages->post_title</a> </div>"; 
         }?>


       
         
         
      </div>
     
      <div class="content-message-gauche"> <?php echo Emojione\Emojione::shortnameToImage($affiche_messages->post_content);?></div>
        
      <div class="footer-message">
            <div class="categorie_msg"  ><?php echo $categorie_msg?></div> 
            
            <div class="date-message"> <p><?php echo date("d", $date_c); echo $name_mois ; echo date("Y", $date_c); ?> 

             </div>
           
            <div class="nbr-reponse"><?php if ($nb_com < 2) {
                                echo "<div style=\"color: red; display: inline-block;\">$nb_com</div> réponse";   
                                } else{
                                 echo "<div style=\"color: red; display: inline-block;\">$nb_com</div> réponses";   
                                 } ; ?> </p></div>
                        
            <div class="repondres btn btn-xs btn-success"><?php echo "<a href=\"voir-reponses.php?id={$affiche_messages->ID}\">Voir les réponses</a>" ?></div>
           
        </div>
           
       </div>

</div>


<?php

}

?>



    


 

<?php  require "inc/footer.php"; ?>