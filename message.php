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
                <div class="user-presentation-gauche">
                    <div class="pseudo-user">

                     <?php if ($user_Sexe == "fille"){

                      echo "<img src=\"img/fille.png\" width=\"16px\" height=\"16px\">";
                        } else{
                         echo "<img src=\"img/garcon.png\" width=\"16px\" height=\"16px\">";
                        }

                      echo "<a href=\"profile.php?user=$author_id\">$name_author</a>"?>

                      </div>
                   
                    <div class="demande-ami"><img style="padding-bottom: 1px" src="img/ami.png"> Ami</div>
                    
                    <div class="send-private-message"><img style="padding-bottom: 1px" src="img/message.png"><?php echo "<a href=\"chat.php?id_send=$author_id\"> Message</a>"?> </div>
                    
                    
                    <div class="user-profil"><img style="padding-bottom: 1px" src="img/user.png"><?php echo "<a href=\"profile.php?user=$author_id\"> Profil</a>"?></div>
                 </div>

                <div class="titre-message-gauche"><?php echo "<a href=\"lire-message.php?id={$affiche_messages->ID}\">$affiche_messages->post_title</a>" ?></div>
                <!--<img class="user_online" src="/img/Point_vert.gif">-->
                <div class="content-message-gauche">  <?php echo Emojione\Emojione::shortnameToImage($affiche_messages->post_content);?> </div>
               
                <div class="footer-message">
                
                </div>
                    <div class="categorie_msg" ><?php echo $categorie_msg?></div> 
                    <div class="date-message"> <p>Posté le <?php echo date("d", $date_c); echo $name_mois ; echo date("Y", $date_c); ?></div>
                    <div class="nbr-reponse"><?php if ($nb_com < 2) {
                                        echo $nb_com.' réponse';   
                                        } else{
                                         echo $nb_com.' réponses'; 
                                         } ; ?> </p></div>
                <?php if(isset($_SESSION['auth'])){ ?>
                <form class="signaler" enctype="multipart/form-data" action="" method="post">      <?php echo "<input type=\"submit\" name=\"$message_id\" value=\"Signaler\" id=\"$message_id\" class=\"signaler\" onclick=\"effacer()\"/>"; ?> </form> <?php } ?>
     </div>

</div>


<?php


/*-------------COMMENTAIRES------------------------------------------*/




if (isset($_POST['contenu'])) {
    $content = strip_tags(trim($_POST['contenu']));
    $poster_commentaire = $pdo->prepare("INSERT INTO wp_cendrillon_6239_comments SET comment_post_ID = ?, comment_author = ?, comment_date = ?, comment_content = ?, comment_author_id = ?");
    $comment_author = $_SESSION['auth']->user_login;
    $comment_date = date("Y-m-d H:i:s");     
    $poster_commentaire->execute([$_GET['id'], $comment_author, $comment_date, $content, $my_id]);


    }
?>

 <?php if(isset($_SESSION['auth'])){ ?>

 <div class="register-form blanc ">
 <form action=""  method="POST" >
 <legend style="color: #0a68b4; font-weight: bold">Donner un conseil</legend> 
 
 <img class="emoticones emoticones-repondre"  src="emoticones/1f642.png" width="25px" height="25px" onclick="Show_emoticones();">
 <div class="bloc-emoticones-poster-message"><?php require_once "emoticones.php"; ?></div> 
 
 <textarea id="m"  name="contenu" class="area-poster-message" onclick="outEmo()" required ></textarea><br>
 
 <input type="submit" name="submit" value="valider" class="btn btn-primary" style="margin-top: -350px; "> 
</form>
</div>
<?php } else {?>
    <legend style="color: #0a68b4; font-weight: bold">Donner un conseil</legend> 
         <div class="connexion-obligatoire">
            Vous devez être inscrit et connecté pour donner des conseils     <a href="register.php" class="inscription btn btn-primary" role="button" >S'inscrire</a></br>
        </div>

   <?php }?>



<?php

$affiche_commentaire = $pdo->prepare('SELECT comment_ID, comment_post_ID, comment_author, comment_date, comment_content, comment_author_id FROM wp_cendrillon_6239_comments WHERE comment_post_ID= ? ORDER BY comment_date DESC');
$affiche_commentaire->execute([$_GET['id']]);


?></br></br>
 <legend style="color: #0a68b4; font-weight: bold">Les réponses</legend> 
 <?php
while($affiche_les_commentaires = $affiche_commentaire->fetch()){

$author_comment_id = $affiche_les_commentaires->comment_author_id;
$author_login = $affiche_les_commentaires->comment_author;
$ID_commentaire = $affiche_les_commentaires->comment_ID;
/* on recherche l'ID de l'auteur */
$recherche_author = $pdo->prepare('SELECT ID, user_login FROM wp_cendrillon_6239_users WHERE user_login= ? ');
$recherche_author->execute([$author_login]);



           /* on cherche si l'auteur est connecté*/
            $req_online = $pdo->prepare('SELECT COUNT(ID_user) FROM users_online WHERE ID_user = :ID_user ');
            $req_online->bindParam(':ID_user', $author_id, PDO::PARAM_STR);
            $req_online->execute();
            $author_online = $req_online->fetchColumn();

        
            
            $date_message = $affiche_les_commentaires->comment_date;
            $date_c = strtotime($date_message);



            /*on affiche le mois en francais*/
            $mois = array(1 =>" janvier " , " février ", " mars ", " avril ", " mai ", " juin ", " juillet ", " août "," septembre "," octobre "," novembre "," decembre ");
            $mois[date('n',$date_c)];
            $num_mois = date('n',$date_c);
            $name_mois = $mois[$num_mois];

            $vote = $author_id + time();

$conseillère = User::conseillere($db, $author_comment_id );
$user_Sexe = User::user_sexe($db, $author_comment_id);         
                ?>

<div class="message-gauche" >
            <div class="container-messages-gauche">
                <div class="user-presentation-gauche">
                     <div class="pseudo-user">

                     <?php if ($user_Sexe == "fille"){

                      echo "<img src=\"img/fille.png\" width=\"16px\" height=\"16px\">";
                        } else{
                         echo "<img src=\"img/garcon.png\" width=\"16px\" height=\"16px\">";
                        }

                      echo "<a href=\"profile.php?user=$author_comment_id\">$author_login</a>"?>

                      </div>

                   
                    <div class="demande-ami"><img style="padding-bottom: 1px" src="img/ami.png"> Ami</div>
                    
                    <div class="send-private-message"><img style="padding-bottom: 1px" src="img/message.png"><?php echo "<a href=\"chat.php?id_send=$author_comment_id\"> Message</a>"?> </div>
                    
                    <div class="user-profil"><img style="padding-bottom: 1px" src="img/user.png"><?php echo "<a href=\"profile.php?user=$author_comment_id\"> Profil</a>"?></div>
                 </div>

                 <?php if ($conseillère == true){
                   echo "<img style=\"padding-bottom: 1px\" src=\"img/conseillere.png\">";
                    }?>

               
                <!--<img class="user_online" src="/img/Point_vert.gif">-->

                <div class="content-message-gauche"> <?php echo Emojione\Emojione::shortnameToImage($affiche_les_commentaires ->comment_content); ?></div>
               
                <div class="footer-message">
                
                </div>
                    
                    
                    <div class="date-message"> <p>Posté le <?php echo date("d", $date_c); echo $name_mois ; echo date("Y", $date_c); ?></div>
                   
                   <?php if(!isset($_SESSION['auth'])){ $my_id=0;
                        echo "<div class=\"cache_vote\"></div>";
                      } ?>
                     <div class="vote">   <?php echo ThumbsUp::item($ID_commentaire, $author_comment_id)->options('align=right')?></div>
                    


                 <?php if(isset($_SESSION['auth'])){ ?>
                <form class="signaler" enctype="multipart/form-data" action="" method="post">      <?php echo "<input type=\"submit\" name=\"$message_id\" value=\"Signaler\" id=\"$message_id\" class=\"signaler\" onclick=\"effacer()\"/>"; ?> </form> <?php } ?>
     </div>

</div>


<?php


}


?>











    


 