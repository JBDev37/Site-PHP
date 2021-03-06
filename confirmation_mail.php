<?php require "inc/header.php"; ?>
<?php  require "side-bar.php"; ?>
<?php  require "side-bar-right.php"; ?>

<div class="container-messages">

<?php
if(!empty($_POST) && !empty($_POST['email'])){
  require_once 'inc/db.php';
  require_once 'inc/functions.php';
    $req = $pdo->prepare('SELECT * FROM wp_cendrillon_6239_users WHERE user_email = ? AND user_registered IS NOT NULL');
  $req->execute([$_POST['email']]);
  $user = $req->fetch();

  if($user){
    $reset_token = str_random(60);
    $pdo->prepare('UPDATE wp_cendrillon_6239_users SET reset_token = ?, reset = NOW() WHERE ID = ?')->execute([$reset_token, $user->ID]);
    $_SESSION['flash']['success'] = 'Un email pour changer votre mot de passe vous a été envoyé';
    $mail = $_POST['email'];
    $my_id = $user->ID;
    $login = $user->user_login;

   
    Mail::changer_mdp($mail, $my_id, $reset_token, $login);


  }else{
    $_SESSION['flash']['danger'] = "Aucun compte ne correspond à cet email ";
  }
}
?>


    <form action="confirmation_mail.php"  method="POST" class="register-form blanc">
        <legend style="color: #0a68b4"><b> Changer de mot de passe</b></legend>
       <div class="form-group">

        <label for="">Tu as reçu un email pour changer ton mot de passe</label>
   

       </div>


 

    </form>
</div>

<?php require "inc/footer.php"; ?>