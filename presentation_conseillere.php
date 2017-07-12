<?php  require "inc/header.php"; ?>
<?php  require "side-bar.php"; ?>
<?php  require "side-bar-right.php"; ?>

<?php
$id=$_GET['id'];

$req = $pdo->prepare('SELECT user_id, presentation FROM wp_cendrillon_6239_conseillere WHERE user_id=?');

$req->execute([$id]);
$result = $req->fetch();

$presentation = $result->presentation;
if(!$presentation){
    $presentation = " ";
}



if (isset($_POST['submit'])){
    $ma_presentation = $_POST['presentation'];
    $req = $pdo->prepare("UPDATE wp_cendrillon_6239_conseillere SET presentation =? WHERE user_id=? ");
    $req->execute([$ma_presentation, $my_id]);
    App::redirect('profile.php');};

?>


<div class="container-messages">
    <?php if(!isset($_SESSION['auth'])): ?>
        <div class="connexion-obligatoire">
            Vous devez être inscrit et connecté <a href="register.php" class="inscription btn btn-primary" role="button" >S'inscrire</a>
        </div>
    <?php else: ?>
    <div class="register-form blanc">

        <form enctype="multipart/form-data" action="" method="post">

            <fieldset>
                <legend style="color: #0a68b4"><b>Ma présentation conseiller </b></legend>

                <?php echo "<textarea type=\"text\" id=\"m\" name=\"presentation\" onclick=\"out()\" class=\"area-conseillere\" required/>$presentation </textarea>";?><br/>
                <br/>
                <div class="input-conseillere">
                <input type="submit" name="submit" value="Valider" class="btn btn-primary"/>
               </div>
            </fieldset>
        </form>
        <img class="emoticones-profil"  src="emoticones/1f642.png" width="25px" height="25px" onclick="Show_emoticones();">
        <div class="bloc-emoticones-profil"><?php require_once "emoticones.php"; ?></div>
    </div>


</div>
<?php endif; ?>

<?php  require "inc/footer.php"; ?>

 