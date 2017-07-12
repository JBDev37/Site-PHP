<?php require_once "inc/functions.php"; ?>
<?php  require "inc/header.php"; ?>
<?php  require "side-bar.php"; ?>
<?php  require "side-bar-right.php"; ?>
<?php 
  require 'inc/db.php';
  $req = $pdo->prepare('SELECT * FROM wp_cendrillon_6239_users WHERE ID = ?');
  $req->execute([$my_id]);
  $user = $req->fetch();
  if($user){

  	   if(!empty($_POST['password']) && $_POST['password'] == $_POST['password_confirm']){
  	    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
  	   	$pdo->prepare('UPDATE wp_cendrillon_6239_users SET user_pass = ? WHERE ID = ?')->execute([$password, $my_id]);
  	   	$_SESSION['flash']['success'] = "votre mot de passe à bien été modifié";
  	   	$_SESSION['auth'] = $user;
  	   	header('Location: confirm-change_password.php');
  	   	  exit();
  	   }
  	   
       }

?>
<div class="container-messages">
<div class="register-form blanc">
<legend style="color: #0a68b4"><b>Changer de mot de passe</b></legend>

<form action=" "  method="POST">  

<div class="form-group">

   	<label for="">Nouveau mot de passe </label>
   	<input type="password" name="password" class="form-control" />

   </div>

<div class="form-group">

    <label for="">Confirmation du mot de passe </label>
    <input type="password" name="password_confirm" class="form-control" />

   </div>

<button type="submit" class="btn btn-primary" >Changer mot de passe</button>

</form>
</div>
</div>
<?php require "inc/footer.php";    ?>