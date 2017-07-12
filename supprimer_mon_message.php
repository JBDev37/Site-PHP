<div class="container-messages">

<?php

$recherche_messages = $pdo->prepare('SELECT ID, post_author, post_title, post_content, post_type, post_date, categorie FROM wp_cendrillon_6239_posts WHERE ID= ? ');
$recherche_messages->execute([$_GET['id']]);

$affiche_messages = $recherche_messages->fetch();

$message_id = $affiche_messages->ID;
$author_id = $affiche_messages->post_author;
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
         <div class="titre_message"> <?php echo "<a href=\"lire-message.php?id={$affiche_messages->ID}\">$affiche_messages->post_title</a>" ?></div>
         
         
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
                        
            
        </div>
           
       </div>

</div>


     <?php
if (isset($_POST['submit_message'])) {
$req = $pdo->prepare("DELETE FROM wp_cendrillon_6239_posts WHERE ID=?");
$req->execute([$_GET['id']]);
App::redirect('mes_messages.php');
}
?>




    <div class="supprimer">
        <form action=""  method="POST"  >
            <input type="submit" name="submit_message" value="suppimer ce message" class="btn btn-danger" /> </br></br></br>
            </div>
        </form>
    </div>


<?php














    


 