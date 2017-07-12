<?php require_once "inc/functions.php"; ?>
<?php  require "inc/header.php"; ?>
<?php  require "side-bar-right.php"; ?>
<?php  require "side-bar.php"; ?>
<?php

if(isset($_SESSION['auth'])):


?>


<div class="container-messages">

    <div class="register-form blanc">



    <fieldset><legend style="color: #0a68b4"><b>Message envoyé</b></legend>
         <div class="presentation-site">Ton message à bien été envoyé !</br></br></div>
       
    </fieldset>
 
  





    </div>

<?php else: ?>
    Vous devez être connecté

<?php endif; ?>

</div>
<?php  require "inc/footer.php"; ?>