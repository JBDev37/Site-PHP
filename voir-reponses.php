<?php require_once "inc/functions.php"; ?>
<?php  require "inc/header.php"; ?>
<?php  require "side-bar.php"; ?>
<?php  require "side-bar-right.php"; ?>
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
         <?php if ($user_Sexe == "garcon"){
         echo "<div class=\"titre_message\"><a href=\"lire-message.php?id={$affiche_messages->ID}\">$affiche_messages->post_title</a> </div>";
         } else {
         echo "<div class=\"titre_message_fille\" ><a href=\"lire-message.php?id={$affiche_messages->ID}\">$affiche_messages->post_title</a> </div>"; 
         }?>
         
         
      </div>
     
      <div class="content-message-gauche"> <?php echo Emojione\Emojione::shortnameToImage($affiche_messages->post_content);?></div>
        
      <div class="footer-message">
            <div class="categorie_msg"  ><?php echo $categorie_msg?></div> 
            <div class="date-message"><?php echo date("d", $date_c); echo $name_mois ; echo date("Y", $date_c); ?> par 


           
               <?php if ($user_Sexe == "fille"){
                 echo " <div class=\"fille\" ><a href=\"profile.php?user=$author_id\" title=\"profil $name_author\" >$name_author  </a></div>";
                } else {
                  echo " <div class=\"garcon\" ><a href=\"profile.php?user=$author_id\" title=\"profil $name_author\" >$name_author  </a></div>";
                }


               ?>

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


/*-------------COMMENTAIRES------------------------------------------*/

?>





<?php
$affiche_commentaire = $pdo->prepare('SELECT comment_ID, comment_post_ID, comment_author, comment_date, comment_content, comment_author_id FROM wp_cendrillon_6239_comments WHERE comment_post_ID= ? ORDER BY comment_date DESC');
$affiche_commentaire->execute([$_GET['id']]);


?></br>
 <legend class="reponses-conseils">Les conseils</legend> 
 <?php
while($affiche_les_commentaires = $affiche_commentaire->fetch()){

$author_login = $affiche_les_commentaires->comment_author;
$author_comment_id = User::user_ID($db,$author_login);
$ID_commentaire = $affiche_les_commentaires->comment_ID;
/* on recherche l'ID de l'auteur */
$recherche_author = $pdo->prepare('SELECT ID, user_login FROM wp_cendrillon_6239_users WHERE user_login= ? ');
$recherche_author->execute([$author_login]);



/* on cherche si l'auteur est connecté*/
$user_online = User::user_online($db, $author_comment_id);

        
            
            $date_message = $affiche_les_commentaires->comment_date;
            $date_c = strtotime($date_message);



            /*on affiche le mois en francais*/
            $mois = array(1 =>" janvier " , " février ", " mars ", " avril ", " mai ", " juin ", " juillet ", " août "," septembre "," octobre "," novembre "," decembre ");
            $mois[date('n',$date_c)];
            $num_mois = date('n',$date_c);
            $name_mois = $mois[$num_mois];

            $vote = $author_id + time();

$conseillère = User::conseillere($db, $author_comment_id );
$user_Sexe1 = User::user_sexe($db, $author_comment_id);         
                ?>

<div class="message-gauche">

    <div class="container-messages-gauche">
      <div class="titre_message_container">

         <div class="titre_message"> 
                             <?php if ($user_Sexe1 == "fille"){
                 echo " <div class=\"titre_message_fille\" ><a href=\"profile.php?user=$author_comment_id\" title=\"profil $author_login\" >$author_login  </a></div>"; 
                } else {
                  echo " <div class=\"titre_message\" ><a href=\"profile.php?user=$author_comment_id\" title=\"profil $author_login\" >$author_login </a></div>";
                }
               

                  if ($conseillère == true){
                   echo "<a href=\"\" title=\"conseiller\"><img style=\"padding-bottom: 1px\" src=\"img/conseillere.png\"></a>";
                    }?>
         </div>



         <?php if($user_online == true){
            echo "<img class=\"user_online\" src=\"img/Point_vert.gif\">"; } ?>
         
         <?php if(isset($_SESSION['auth'])){ ?>
          <form class="signaler" enctype="multipart/form-data" action="" method="post"> <?php echo "<input type=\"submit\" name=\"$ID_commentaire\" value=\"Signaler\" id=\"$ID_commentaire\" class=\"signaler\" onclick=\"effacer()\"/>"; ?> </form> <?php } ?>
      </div>
     
      <div class="content-message-gauche"> <?php echo Emojione\Emojione::shortnameToImage($affiche_les_commentaires ->comment_content); ?></div>
        
      <div class="footer-message">
         <?php 
        /*if(isset($_SESSION['auth']) && $my_id!=$author_comment_id){  
          $friends = Friends::is_friends($db,$my_id, $author_comment_id);
          $request = Friends::count_friends_request($db,$my_id, $author_comment_id);
          
                     /*    Demande en ami 
                    if($friends == false && $request==false ){ ?>  
                    
                    <form class="demande_ami" id="demande_ami"  name="form2" method="POST" >
                          <?php echo "<input type=\"submit\" name=\"$author_comment_id\" value='+1 ami' id=\"author_id\" class=\" demande_ami btn btn-xs btn-success\" onClick=\"this.value='En attente'\">";?>
                    </form> 
                         <?php }

                    if($friends == false && $request==true ){ ?>  
                           <?php 

                          
                            echo "<input type=\"submit\" name=\"\" value='En attente' class=\" demande_ami btn btn-xs btn-success\" >";
                             
                        }
                    if($friends == true){
                    echo "<a href=\"\"  title=\"c'est un ami\"><input type=\"submit\" name=\"delete_friend\"  value='Ami' class=\" demande_ami btn btn-xs btn-primary\" ></a>";
                      } 
           
                    }*/
                     echo "<a href=\"chat.php?user=$author_comment_id\" title=\"message privé\" class=\"private_message\"><img  src=\"img/comment.png\"></a>";
                ?>  

            <div class="date-message-commentaire"> <p><?php echo date("d", $date_c); echo $name_mois ; echo date("Y", $date_c); ?> 

             </div>
            <div class="vote"> <?php echo ThumbsUp::item($ID_commentaire, $author_comment_id)->options('align=right')?></div>
          
           </div>
           
       </div>

</div>



<?php
if (isset($_POST[$author_comment_id])){
    Friends::friends_request($db,$my_id, $author_comment_id);
    
    }

}


?>





<?php
if (isset($_POST[$message_id])){
    $signaler = Messages::signaler_msg($db, $message_id, $my_id, $author_id);
    }
?>





    


 







<?php require "inc/footer.php"; ?>