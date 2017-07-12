<?php require_once "inc/functions.php"; ?>
<?php  require "inc/header.php"; ?>
<?php  require "side-bar-right.php"; ?>
<?php  require "side-bar.php"; ?>
<?php
$post_type = "messages";
$now = date("Y-m-d H:i:s");


if(isset($_POST['submit_message'])){
  if(!empty($_POST)){
      $titre = strip_tags(trim($_POST['titre_message']));
      $content = strip_tags(trim($_POST['contenu']));
      $req = $pdo->prepare("INSERT INTO wp_cendrillon_6239_posts SET post_author = ?, post_title = ?, post_content = ?, post_type = ?, post_date = ?, categorie=?");
      $req->execute([$my_id, $titre, $content, $post_type, $now ,$_POST['categorie']]); 
  }
}


?>


<div class="container-messages">

    <div class="register-form blanc">


    <form id="contact" method="post" action="">

    <fieldset><legend style="color: #0a68b4"><b>Message posté</b></legend>
         <div class="presentation-site">Ton message a bien été publié </br></br></div>
         <a href="index.php" class="btn btn-primary">Retour aux messages </a>
       

 

    </form>





    </div>




</div>





<?php  require "inc/footer.php"; ?>