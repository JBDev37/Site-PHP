<?php  require "inc/header.php"; ?>

<?php  require "side-bar.php"; ?>
<?php  require "side-bar-right.php"; ?>

<?php
$now = date("Y-m-d H:i:s");
if(isset($_SESSION['auth'])){
    
/* on cherche le nom de la conseillère*/
$recherche_name = $pdo->prepare('SELECT ID, user_login FROM wp_cendrillon_6239_users WHERE ID= ? ');
$recherche_name->execute([$my_id]);
$name_author = $recherche_name->fetch();
$name = $name_author->user_login;
$user_sexe = User::user_sexe($db, $my_id);
}

if(isset($_POST['submit'])){
    $presentation = $titre = strip_tags(trim($_POST['presentation']));
    if(isset($_POST['genre'][0])){$garcon = $_POST['genre'][0];}else{$garcon=0;}
    if(isset($_POST['genre'][1])){$fille = $_POST['genre'][1];}else{$fille=0;}
    if(isset($_POST['age'][0])){$college = $_POST['age'][0];}else{$college=0;}
    if(isset($_POST['age'][1])){$lycee = $_POST['age'][1];}else{$lycee=0;}
    if(isset($_POST['age'][2])){$adulte = $_POST['age'][2];}else{$adulte=0;}    
    if(isset($_POST['domaine'][0])){$amour = $_POST['domaine'][0];}else{$amour=0;}
    if(isset($_POST['domaine'][1])){$amitie = $_POST['domaine'][1];}else{$amitie=0;}
    if(isset($_POST['domaine'][2])){$confiance = $_POST['domaine'][2];}else{$confiance=0;}
    if(isset($_POST['domaine'][3])){$sexo = $_POST['domaine'][3];}else{$sexo=0;}

    $req = $pdo->prepare("INSERT INTO wp_cendrillon_6239_conseillere SET user_id = ?, displayname = ?, garcon = ?, fille = ?, college = ?, lycee = ?, adulte = ?, amour = ?, amitie = ?, confiance = ?, sexo = ?, presentation = ?, last_connexion = ? , user_sexe = ?, date_register = ?");
    $req->execute([$my_id, $name, $garcon, $fille, $college, $lycee, $adulte, $amour,$amitie,$confiance,$sexo,$presentation, $now, $user_sexe, $now]);
    header('Location: confirm-conseillere.php');

}

?>

<div class="container-messages">
    <?php if(!isset($_SESSION['auth'])): ?>
        <div class="connexion-obligatoire">
        <legend >Devenir conseiller</legend> 
             Oups...vous n'êtes pas connecté ! <a href="register-login.php" class="inscription btn btn-success role="button" >Connexion</a>
        </div>
    <?php else: ?>
    <div class="register-form-devenir blanc">

        <form enctype="multipart/form-data" action="" method="post">

            <fieldset>
                <legend >Tu souhaites donner des conseils :</legend>
                <strong>Pour qui :</strong>
                <br/>
                <label class="btn btn-primary btn-circle choix"><input type="checkbox" name="genre[0]" value="1" />  Les gar&ccedil;ons</label>
                <label class="btn btn-primary btn-circle choix"><input type="checkbox" name="genre[1]" value="1" />  Les filles</label><br/>
                <br/>
                <strong>Pour quelle tranche d'&acirc;ge :</strong><br/>
                <label class="btn btn-primary btn-circle choix"><INPUT type="checkbox" name="age[0]" value="1" />  Coll&egrave;ge<br/></label>
                <label class="btn btn-primary btn-circle choix"><INPUT type="checkbox" name="age[1]" value="1" />  Lyc&eacute;e<br/></label>
                <label class="btn btn-primary btn-circle choix"><INPUT type="checkbox" name="age[2]" value="1" />  +18 ans<br/></label><br/>
                <br/>
                <strong>Dans quel domaine :</strong><br/>
                <label class="btn btn-primary btn-circle choix"><INPUT type="checkbox" name="domaine[0]" value="1" />  Amour<br/></label>
                <label class="btn btn-primary btn-circle choix"><INPUT type="checkbox" name="domaine[1]" value="1" />  Amiti&eacute;<br/></label>
               <label class="btn btn-primary btn-circle choix"> <INPUT type="checkbox" name="domaine[2]" value="1" />  Confiance en soi<br/></label>
                <label class="btn btn-primary btn-circle choix"><INPUT type="checkbox" name="domaine[3]" value="1" />  Sexo<br/></label><br/>

                <br/>
                <strong>Un petit mot pour te pr&eacute;senter et expliquer les conseils que tu pourras apporter:</strong><br/><br/>
               
                <textarea type="text" id="m" name="presentation" onclick="out()" class="area-conseillere" required/></textarea><br/>
                <br/>
                <div class="input-conseillere">
                <input type="submit" name="submit" value="valider" class="btn btn-primary"/>
               </div>
               <img class="emoticones-repondre-message img-conseillere"  src="emoticones/1f642.png" width="25px" height="25px" onclick="Show_emoticones();">
               <div class="bloc-emoticones-poster-message bloc-conseillere"></div><?php require_once "emoticones.php"; ?>
            </fieldset>
        </form>
    </div>

</div>
<?php endif; ?>

<?php  require "inc/footer.php"; ?>

 