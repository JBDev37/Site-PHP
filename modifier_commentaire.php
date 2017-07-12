<?php require_once "inc/functions.php"; ?>
<?php  require "inc/header.php"; ?>
<?php  require "side-bar.php"; ?>
<?php  require "side-bar-right.php"; ?>

<div class="container-messages">

<legend class="legend-visite"><b>Modifier mon conseil</b></legend>
<?php

$recherche_conseils = $pdo->prepare('SELECT * FROM wp_cendrillon_6239_comments WHERE comment_ID = ?');
$recherche_conseils->execute([$_GET['id']]);

$affiche_messages = $recherche_conseils->fetch();

/* on recherche le nom de l'auteur */
$post_author_id = $affiche_messages->post_author_id;
$name_author = User::user_name($db, $post_author_id);

$message = $affiche_messages->comment_content;
$message_id = $affiche_messages->comment_ID; 

?>
        


<div class="container-messages-gauche">
    <div class="blanc">
        <form enctype="multipart/form-data" action="" method="post">
            <fieldset>
     
                <label><strong>Titre</strong></label>
                <?php echo "<input type=\"text\" id=\"\" name=\"titre\" class=\"titre_modifier form-control\" value=\"Conseil pour $name_author\" required/>"; ?> <br/>
                
                <label><strong>Message</strong></label>
                <?php echo "<textarea id=\"m\" name=\"message\" onclick=\"outEmo()\"; class=\"modifier_area\" required/> $affiche_messages->comment_content </textarea>";?><br/>
                
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
    $req = $pdo->prepare("UPDATE wp_cendrillon_6239_comments SET comment_content =? WHERE comment_ID=? ");
    $req->execute([$message, $message_id]);
    App::redirect('mes_conseils.php');};
?>



<?php



require "inc/footer.php"; ?>











    


 