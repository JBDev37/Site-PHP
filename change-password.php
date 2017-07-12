<?php require_once "inc/functions.php";
require_once "inc/bootstrap.php"; ?>
<?php  require "side-bar.php"; ?>
<?php
App::getAuth()->restrict();


if(!empty($_POST)){

    if(empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){

        $_SESSION['flash']['danger'] = "Les mot de passe ne correspondent pas";
    }else{
        $user_id = $_SESSION['auth']->ID;
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        require_once 'inc/db.php';
        $pdo->prepare('UPDATE wp_cendrillon_6239_users SET user_pass = ? WHERE ID = ?')->execute([$password, $user_id]);
        $_SESSION['flash']['success'] = "Votre mot de passe a été changé";
    }
}







?>



<?php  require "inc/header.php"; ?>
<div class="container-messages">


    <form action="" method="POST">

        <div class="form-group">
            <input class="form-control" type="password" name="password" placeholder="changer votre mot de passe">
        </div>
        <div class="form-group">
            <input class="form-control" type="password" name="password_confirm" placeholder="confirmer votre mot de passe">
        </div>

        <button type="submit" class="btn btn-primary">changer mon mot de passe</button>

    </form>

</div>


<?php require "inc/footer.php"; ?>

 