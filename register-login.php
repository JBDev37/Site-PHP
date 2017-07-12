<?php

//fonction test
/*$db = App::getDatabase();
$user = $db->query('SELECT * FROM wp_cendrillon_6239_users WHERE ID=?', [4])->fetch();
var_dump($user);
die();*/
require "inc/header.php"; 
require "side-bar.php";
require "side-bar-right.php";
require_once "inc/bootstrap.php";
require_once "inc/functions.php";



if (isset($_POST['submit_login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
    $user = $auth->login($db, $_POST['username'], $_POST['password']);
    /*$session = session::getInstance();*/
    if($user){
      /*$session->setFlash('sucess', 'vous êtes connecté');*/
      $bloque=User::is_user_bloque($db, $_POST['username']);
      if($bloque==true){
        header('Location: user_bloque.php');
      }else{
            if(isset($_POST['remember'])){
            $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
            $length = 250;
            $remember_token = substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length); 
            $pdo->prepare('UPDATE wp_cendrillon_6239_users SET remember_token = ? WHERE ID = ?')->execute([$remember_token,$user->ID]);
            setcookie('remember',$user->ID. '=='. $remember_token. sha1($user->ID . 'ratonlaveur'), time() + (3600 * 24 * 30), '/' ,'kurbys.com', true, true);
        }
            



      }
    } /*else{
       $session->setFlash('danger', 'vous êtes connecté');
    }*/
}




?>


<div class="container-messages">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
            <p>Vous n'avez pas rempli correctement le formulaire</p>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= $error; ?></li>

                <?php endforeach; ?>
            </ul>

            </div>
        <?php endif; ?>


        <form action="account.php" method="POST" class="register-form blanc">
            <legend >Connexion</legend>
        
                <label>Pseudo ou Email</label></br>
                <div class="form-group ">
                    <input type="text" name="username" class="form-control" placeholder="Pseudo ou email" >
                </div></br>
                
                <label>Mot de passe</label></br>
                <div class="form-group forget-password">
                <input type="password" name="password" class="form-control" placeholder="Mot de passe"></br>
                <a href="forget.php" class="forget-password">Mot de passe oublié</a></br></br>
                <input type="checkbox" name="remember" value="1" checked> Se souvenir de moi</br>
                
                </div></br>

                <span>ATTENTION : Ceux qui ont un compte sur <strong>"le secret de cendrillon" </strong>doivent <a href="forget.php" class="forget-password"><strong>changer leur mot de passe</strong></a></span></br></br>
                
                <button type="submit" name="submit_login" class="btn btn-sm btn-primary">se connecter</button>

        </form>
                        
      
</div>



<?php require "inc/footer.php"; ?>