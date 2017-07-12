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
<?php  require "side-bar-right.php"; 
$user_Sexe = User::user_sexe($db, $my_id);
?>
<div class="container-messages blanc">

      
            <legend style="color: #0a68b4"><b>Tu es maintenant 
                      <?php if ($user_Sexe == "fille"){ ?>

                      conseillère !
                        <?php } else{?>
                         conseiller !
                       <?php } ?>

                        </b></legend>

            <span style="font-size: 14px">Félicitation ! Tu va pouvoir aider ceux et celles qui en ont besoin.</span>
            

</div>

<?php require "inc/footer.php"; ?>