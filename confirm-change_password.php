<?php

//fonction test
/*$db = App::getDatabase();
$user = $db->query('SELECT * FROM wp_cendrillon_6239_users WHERE ID=?', [4])->fetch();
var_dump($user);
die();*/
require_once "inc/bootstrap.php";




?>
<?php require "inc/header.php"; ?>
<?php  require "side-bar.php"; ?>
<div class="container-messages">
          
            <legend style="color: #0a68b4"><b>Mot de passe changé</b></legend>

            Ton mot de passe à bien été changé !
            

</div>

<?php require "inc/footer.php"; ?>