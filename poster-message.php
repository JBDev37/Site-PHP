<?php require_once "inc/functions.php"; ?>
<?php logged_only(); ?>
<?php  require "inc/header.php"; ?>
<?php  require "side-bar.php"; ?>

<?php
$post_type = "messages";
$now = date("Y-m-d H:i:s");

if(isset($_POST['submit_message'])){
  if(!empty($_POST)){
      $req = $pdo->prepare("INSERT INTO wp_cendrillon_6239_posts SET post_author = ?, post_title = ?, post_content = ?, post_type = ?, post_date = ?, categorie=?");
      $req->execute([$my_id, $_POST['titre_message'], $_POST['contenu'], $post_type, $now ,$_POST['categorie']]);
header('Location: confirm-post-message.php');
}
}
?>

<div class="container-messages">
<?php if(!isset($_SESSION['auth'])): ?>
    <div class="connexion-obligatoire">
        Vous devez être inscrit et connecté <a href="register.php" class="inscription btn btn-primary" role="button" >S'inscrire</a>
    </div>
    <?php else: ?>
    <div class="register-form blanc">
        <form action=" "  method="POST" id="f3" >
            <legend style="color: #0a68b4; font-weight: bold">Demander un conseil</legend>

            <label ><strong>Titre </strong></label></br>
            <input type="text" name="titre_message" class="form-control titre-poster-message" required/></br></br>

            <label ><strong>Message</strong></label></br><img class="emoticones emoticones-poster-message"  src="emoticones/1f642.png" width="25px" height="25px" onclick="Show_emoticones();">
            <div class="bloc-emoticones-poster-message"><?php require_once "emoticones.php"; ?></div>
            <textarea id="m"  name="contenu" class="area-poster-message" onclick="outEmo()" required /></textarea></br></br>

            <div class="categorie-poster-message">
            <label ><strong>Catégorie :</strong></label></br>
            <input type="radio" name="categorie" value ="Amour" checked/>
            <label for="">Amour </label></br>
            <input type="radio" name="categorie" value ="Amitié"  />
            <label for="">Amitié </label></br>
            <input type="radio" name="categorie" value ="Confiance en soi"  />
            <label for="">Confiance en soi </label></br>
            <input type="radio" name="categorie" value ="Sexo"  />
            <label for="">Sexo </label></br></br>
            <input type="submit" name="submit_message" value="valider" class="btn btn-primary"/> </br></br></br>
            </div>



        </form>
    </div>
</div>

<?php endif; ?>
<?php  require "inc/footer.php"; ?>

 