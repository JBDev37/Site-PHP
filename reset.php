<?php 

require_once "inc/bootstrap.php";

require "inc/header.php";
require "side-bar.php"; 
require "side-bar-right.php"; 

if(isset($_GET['ID']) && isset($_GET['token'])){

  require 'inc/db.php';
  $req = $pdo->prepare('SELECT * FROM wp_cendrillon_6239_users WHERE ID = ? AND reset_token IS NOT NULL AND reset_token = ? AND reset > DATE_SUB(NOW(), INTERVAL 30 MINUTE)');
  $req->execute([$_GET['ID'], $_GET['token']]);
  $user = $req->fetch();
  if($user){

  	   if(!empty($_POST['password']) && $_POST['password'] == $_POST['password_confirm']){
  	    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
  	   	$pdo->prepare('UPDATE wp_cendrillon_6239_users SET user_pass = ? WHERE ID = ?')->execute([$password, $_GET['ID']]);
  	   	/*session_start();*/
  	   	$_SESSION['flash']['success'] = "votre mot de passe à bien été modifié";
  	   	$_SESSION['auth'] = $user;
  	   	echo "<div class=\"container-messages\"><div class=\"register-form blanc change_password\">Ton mot de passe a bien été changé</div></div>";
  	   }
  	   
       }else{
       	session_start();
  	    $_SESSION['flash']['error'] = "Ce token n'est pas valide";
  	    header('Location: index.php');
  	    exit();
       }
   }else{
	header('Location: index.php');
	exit();
}

?>


<div class="container-messages">

        <div class="register-form blanc">

                <fieldset><legend style="color: #0a68b4"><b>Réinitialisation du mot de passe</b></legend>


            <form action=" "  method="POST">  

            <div class="form-group">

                <label for="">Mot de passe </label>
                <input type="password" name="password" class="form-control" />

               </div>

            <div class="form-group">

                <label for="">Confirmation du Mot de passe </label>
                <input type="password" name="password_confirm" class="form-control" />

               </div>

            <button type="submit" class="btn btn-primary" >Changer mot de passe</button>

            </form>


              </div>

                </fieldset>




        </div>



</div>


<?php require "inc/footer.php"; ?>