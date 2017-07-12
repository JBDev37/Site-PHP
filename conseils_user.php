<?php  require "inc/header.php"; ?>
<?php  require "side-bar.php"; ?>
<?php  require "side-bar-right.php"; ?>


<div class="container-messages">
<?php
$user_id= $_GET['user'];
$name_user = User::user_name($db, $user_id);

$recherche_conseils = $pdo->prepare('SELECT * FROM wp_cendrillon_6239_comments WHERE comment_author_id = ? ORDER BY comment_date DESC');
$recherche_conseils->execute([$user_id]);



?><legend class="legend-visite"><b><?php echo "Les conseils de " .$name_user ?></b></legend><?php
while($affiche_messages = $recherche_conseils->fetch()){

$author_id = $my_id;
$comment_ID = $affiche_messages->comment_ID;

/* on recherche le nom de l'auteur */
$post_author_id = $affiche_messages->post_author_id;
$name_author = User::user_name($db, $post_author_id);
$user_Sexe = User::user_sexe($db, $post_author_id);

if(!isset($name_author)){
$post_author_id = User::comment_author_id($db, $comment_ID);
$name_author = User::user_name($db,$post_author_id);
$user_Sexe = User::user_sexe($db, $post_author_id);
}

/* on cherche si l'auteur est connecté*/
$req_online = $pdo->prepare('SELECT COUNT(ID_user) FROM users_online WHERE ID_user = :ID_user ');
$req_online->bindParam(':ID_user', $author_id, PDO::PARAM_STR);
$req_online->execute();
$author_online = $req_online->fetchColumn();

/* On recherhce le sexe de l'auteur */
$sexe_author = User::user_sexe($db, $author_id);

           
$date_message = $affiche_messages->comment_date;
$date_c = strtotime($date_message);
$now   = time();
$diff  = abs($now - $date_c);
$jour = 1400*24*3600;

/*on affiche le mois en francais*/
$mois = array(1 =>" janvier " , " février ", " mars ", " avril ", " mai ", " juin ", " juillet ", " août "," septembre "," octobre "," novembre "," decembre ");
$mois[date('n',$date_c)];
$num_mois = date('n',$date_c);
$name_mois = $mois[$num_mois];




            ?>

<div class="message-gauche">

    <div class="container-messages-gauche">
      <div class="titre_message_container">
        
        <?php if ($user_Sexe == "garcon"){
         echo "<div class=\"titre_message\"><a href=\"profile.php?user=$post_author_id\">Conseil pour ".$name_author. "</a> </div>";
         } else {
         echo "<div class=\"titre_message_fille\" ><a href=\"profile.php?user=$post_author_id\">Conseil pour ".$name_author. "</a> </div>";
         }?>
         
      </div>
     
      <div class="content-message-gauche"> <?php echo Emojione\Emojione::shortnameToImage($affiche_messages->comment_content);?></div>
        
      <div class="footer-message">
            
            <div class="date-message"> <p><?php echo date("d", $date_c); echo $name_mois ; echo date("Y", $date_c); ?> 

             </div>
            <div class="repondres btn btn-xs btn-success"><?php echo "<a href=\"lire-message.php?id={$affiche_messages->comment_post_ID}\">Voir le message</a>" ?></div>
           
        </div>
           
       </div>

</div>


<?php

}

?>



    


 





<?php  require "inc/footer.php"; ?>