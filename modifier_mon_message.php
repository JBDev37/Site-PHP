<?php require_once "inc/functions.php"; ?>
<?php  require "inc/header.php"; ?>
<?php  require "side-bar.php"; ?>
<?php  require "side-bar-right.php"; ?>

<div class="container-messages">

<legend class="legend-visite"><b>Modifier un message</b></legend>
<?php

$recherche_messages = $pdo->prepare('SELECT ID, post_author, post_title, post_content, post_type, post_date, categorie FROM wp_cendrillon_6239_posts WHERE ID= ? ');
$recherche_messages->execute([$_GET['id']]);

$affiche_messages = $recherche_messages->fetch();

$message_id = $affiche_messages->ID;
$author_id = $affiche_messages->post_author;
$categorie_msg = $affiche_messages->categorie;
$msg_content = $affiche_messages->post_content;
$titre_message = $affiche_messages->post_title;
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
        


<div class="container-messages-gauche">
    <div class="blanc">
        <form enctype="multipart/form-data" action="" method="post">
            <fieldset>
     
                <label><strong>Titre</strong></label>
                <?php echo "<input type=\"text\" id=\"\" name=\"titre\" class=\"titre_modifier form-control\" value=\"$titre_message\" required/>"; ?> <br/>
                
                <label><strong>Message</strong></label>
                <?php echo "<textarea id=\"m\" name=\"message\" onclick=\"outEmo()\"; class=\"modifier_area\" required/> $msg_content </textarea>";?><br/>
                
                <br/>
                <div class="input-conseillere">
                <input type="submit" name="submit" value="Modifier" class="btn btn-primary"/>
               </div>
            </fieldset>
                 <img class="emoticones-modifier"  src="emoticones/1f642.png" width="25px" height="25px" onclick="Show_emoticones();">   
            
             <div class="bloc-emoticones-poster-message"></div><?php require_once "emoticones.php"; ?>
        </form>
    </div>
</div>


     <?php
if (isset($_POST['submit'])){
    $titre = strip_tags(trim($_POST['titre']));
    $message = strip_tags(trim($_POST['message']));
    $req = $pdo->prepare("UPDATE wp_cendrillon_6239_posts SET post_content =?, post_title =? WHERE ID=? ");
    $req->execute([$message,$titre, $message_id]);
    App::redirect('mes_messages.php');};
?>



<?php



require "inc/footer.php"; ?>











    


 