<?php require_once "inc/functions.php"; ?>
<?php  require "inc/header.php"; ?>
<?php  require "side-bar.php"; ?>
<?php  require "side-bar-right.php"; ?>

<div class="container-messages">

<?php
$recherche_conseils = $pdo->prepare('SELECT * FROM wp_cendrillon_6239_comments WHERE comment_ID = ?');
$recherche_conseils->execute([$_GET['id']]);

$affiche_messages = $recherche_conseils->fetch();

/* on recherche le nom de l'auteur */
$post_author_id = $affiche_messages->post_author_id;
$name_author = User::user_name($db, $post_author_id);


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
         <div class="titre_message"> <?php echo "Conseil pour ".$name_author ?></div>
         
         
      </div>
     
      <div class="content-message-gauche"> <?php echo Emojione\Emojione::shortnameToImage($affiche_messages->comment_content);?></div>
        
      <div class="footer-message">
            
            <div class="date-message"> <p><?php echo date("d", $date_c); echo $name_mois ; echo date("Y", $date_c); ?> 

             </div>
           
           
        </div>
           
       </div>

</div>


     <?php
if (isset($_POST['submit_message'])) {
$req = $pdo->prepare("DELETE FROM wp_cendrillon_6239_comments WHERE comment_ID=?");
$req->execute([$_GET['id']]);
App::redirect('mes_conseils.php');
}
?>




    <div class="supprimer">
        <form action=""  method="POST"  >
            <input type="submit" name="submit_message" value="suppimer ce message" class="btn btn-danger" /> </br></br></br>
            </div>
        </form>
    </div>















    


 






<?php require "inc/footer.php"; ?>