<?php  require "inc/header.php"; ?>
<?php  require "side-bar.php"; ?>
<?php  require "side-bar-right.php"; ?>


<div class="container-messages">
<?php

$recherche_conseils = $pdo->prepare('SELECT * FROM wp_cendrillon_6239_fep_messages WHERE to_user = ?');
$recherche_conseils->execute([$my_id]);


?><legend class="legend-visite"><b>Anciens contacts</b></legend><?php

while($affiche_messages = $recherche_conseils->fetch()){

$contact_id = $affiche_messages->from_user;

/* on recherche le nom de l'auteur */
$name_author = User::user_name($db, $contact_id);


            ?>

<div class="message-gauche">

    <div class="container-messages-gauche">
      <div class="titre_message_container" style="color: red;">
         <div class="titre_message" style="color: red;"> <?php echo "<a style=\"color: red\" href=\"profile.php?user=$contact_id\">$name_author</a>";?></div>
         <div class="repondres btn btn-xs btn-primary" style="margin-top: 5px;"><?php echo "<a href=\"chat.php?user=$contact_id\">Contacter</a>" ?></div>
      </div>
          
       </div>

</div>


<?php

}

?>



    


 





<?php  require "inc/footer.php"; ?>