
<?php

//fonction test
/*$db = App::getDatabase();
$user = $db->query('SELECT * FROM wp_cendrillon_6239_users WHERE ID=?', [4])->fetch();
var_dump($user);
die();*/

require_once "inc/db.php";
require_once "inc/bootstrap.php";
require_once "inc/functions.php";

$auth = App::getAuth();
$db = App::getDatabase();

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


require "inc/header.php"; 
require "side-bar.php";
require "side-bar-right.php";
require_once "inc/bootstrap.php";
require_once "inc/functions.php";


?>






<?php  require "messages.php"; ?>







<?php require "inc/footer.php"; ?>