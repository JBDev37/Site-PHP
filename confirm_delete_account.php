<?php

//fonction test
/*$db = App::getDatabase();
$user = $db->query('SELECT * FROM wp_cendrillon_6239_users WHERE ID=?', [4])->fetch();
var_dump($user);
die();*/
require_once "inc/bootstrap.php";

require "inc/header.php";
require "side-bar.php"; 
require "side-bar-right.php"; 


if (isset($_POST['delete_account'])) {
$req = $pdo->prepare("DELETE FROM wp_cendrillon_6239_users WHERE ID=?");
$req->execute([$my_id]);

$req1 = $pdo->prepare("DELETE FROM wp_cendrillon_6239_conseillere WHERE user_id=?");
$req1->execute([$my_id]);

$req2 = $pdo->prepare("DELETE FROM commentaires WHERE from_=? OR to_ =?");
$req2->execute([$my_id,$my_id]);

$req3 = $pdo->prepare("DELETE FROM contact_chat WHERE from_id=? OR to_id =?");
$req3->execute([$my_id,$my_id]);

$req4 = $pdo->prepare("DELETE FROM friends_list WHERE user_one=? OR user_two =?");
$req4->execute([$my_id,$my_id]);

$req5 = $pdo->prepare("DELETE FROM friends_request WHERE from_=? OR to_ =?");
$req5->execute([$my_id,$my_id]);

$req6 = $pdo->prepare("DELETE FROM message_chat WHERE user_send=? OR created_at =?");
$req6->execute([$my_id,$my_id]);

$req7 = $pdo->prepare("DELETE FROM visite_profile WHERE from_id=? OR to_id =?");
$req7->execute([$my_id,$my_id]);

$req7 = $pdo->prepare("DELETE FROM wp_cendrillon_6239_comments WHERE comment_author_id =?");
$req7->execute([$my_id]);

$req8 = $pdo->prepare("DELETE FROM wp_cendrillon_6239_posts WHERE post_author=?");
$req8->execute([$my_id]);

session_start();
setcookie('remember', NUL, time() - (3600 * 24 * 30), '/' ,'kurbys.com', true, true);
unset($_SESSION['auth']);
$_SESSION['flash']['success'] = 'Vous êtes bien déconnecté';
header('Location: index.php');

}

?>
<div class="container-messages">

    <div class="register-form blanc">


    <form id="contact" method="post" action="">

    <fieldset><legend style="color: #0a68b4"><b>Suppression du compte</b></legend>
         <div class="presentation-site">Ton compte à bien été supprimé.
            
 

            </div>
       
    </fieldset>




    </div>



</div>


<?php require "inc/footer.php"; ?>