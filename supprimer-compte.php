<?php require_once "inc/functions.php"; ?>
<?php logged_only(); ?>
<?php  require "inc/header.php"; ?>
<?php  require "side-bar.php"; ?>
<?php  require "side-bar-right.php"; ?>

<?php
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

$req7 = $pdo->prepare("DELETE FROM comment_author_id WHERE from_id=? OR to_id =?");
$req7->execute([$my_id,$my_id]);

$req8 = $pdo->prepare("DELETE FROM wp_cendrillon_6239_posts WHERE post_author=?");
$req8->execute([$my_id]);

}

?>

<div class="container-messages">

    <div class="register-form blanc">
        <form action="confirm_delete_account.php"  method="POST"  >
            <legend style="color: #0a68b4"><b>Supprimer mon compte</b></legend>
            <input type="submit" name="delete_account" value="suppimer mon compte" class="btn btn-danger" onclick="supprimer()";/> </br></br></br>
            </div>
        </form>
    </div>

</div>


<script type="text/javascript">
    function supprimer(){
        confirm("supprimer mon compte ?");
    }

</script>





<?php  require "inc/footer.php"; ?>
