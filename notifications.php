<?php require_once "inc/functions.php"; ?>
<?php  require "inc/header.php"; ?>
<?php  require "side-bar-right.php"; ?>
<?php  require "side-bar.php"; ?>
<div class="container-messages">

<?php
if(!isset($_SESSION['auth'])): ?>
    <div class="connexion-obligatoire">
     <legend>Notifications</legend>
        Vous devez être inscrit et connecté <a href="register.php" class="inscription btn btn-primary" role="button" >S'inscrire</a>
    </div>

<?php else: 

$demande_amis = $pdo->prepare('SELECT * FROM friends_request WHERE to_ = ?');
$demande_amis->execute([$my_id]);


?><legend class="legend-visite" onclick="refuse();"><b>Notifications</b></legend><?php


while($affiche_amis = $demande_amis->fetch()){

$date_visite = $affiche_amis->date_;
$from_id = $affiche_amis->from_;
$name_friends_request = User::user_name($db, $id_from);

/* traitement formulaire*/
if(isset($_POST['refuse'])){
    Friends::refuse($db,$from_id, $my_id);
header('Location: notifications.php');
}

if(isset($_POST['accept'])){
    Friends::accept($db,$from_id, $my_id);
header('Location: notifications.php');
}

/* on cherche si l'auteur est connecté*/
$user_online = User::user_online($db, $from_id);

/* On recherhce le sexe de l'auteur */
$sexe_author = User::user_sexe($db, $from_id);
$user_Sexe = User::user_sexe($db, $from_id);
$confiance = User::indice_confiance($db,$from_id);
$presentation = User::presentation_profile($db, $from_id);
$nbr_aide = User::nbr_personne_aide($db, $from_id);

$req = $pdo->prepare('SELECT ID, presentation FROM wp_cendrillon_6239_users WHERE ID=?');
$req->execute([$from_id]);
$req1 = $req->fetch();
   if($req1){
         $presentation = $req1->presentation;
         if(!$presentation){ 
            $name = User::user_name($db, $from_id);
          $presentation = $name." n'a pas encore de présentation ! ";
        }
    }






$date_c = strtotime($date_visite);
$now   = time();
$diff  = abs($now - $date_c);
$jour = 1400*24*3600;

/*on affiche le mois en francais*/
$mois = array(1 =>" janvier " , " février ", " mars ", " avril ", " mai ", " juin ", " juillet ", " août "," septembre "," octobre "," novembre "," decembre ");
$mois[date('n',$date_c)];
$num_mois = date('n',$date_c);
$name_mois = $mois[$num_mois];


?>

<div class="message-gauche" id="notification">

    <div class="container-messages-gauche">
          <div class="titre_message_container">

             <div class="titre_message"> 
                <?php if ($user_Sexe == "fille"){?>
                <div class="nom-conseillere-fille" ><img src="img/fille.png"><?php echo "<a href=\"profile.php?id=$from_id\">$name_friends_request</a>" ?></div>
                <?php }else {?>
                <div class="nom-conseillere-garcon" ><img src="img/garcon.png"><?php echo "<a href=\"profile.php?id=$from_id\">$name_friends_request</a>" ?></div>
                <?php }?> 
                <?php if ($conseillère == true){
                   echo "<a title=\"conseillèr(e)\" ><img style=\"padding-bottom: 1px; margin-left: 10px;\" src=\"img/conseillere.png\"></a>";
                    }?>
             </div>
             <?php if($user_online == true){
                echo "<img class=\"user_online\" src=\"img/Point_vert.gif\">"; } ?>
              
             <div class="date_visite"><?php echo 'Demande en ami le '.date("d", $date_c); echo $name_mois ; echo date("Y", $date_c); ?></div> 
        </div>
         
          <div class="content-message-gauche"> <?php echo Emojione\Emojione::shortnameToImage($presentation);?></div>
            
          <div class="footer-message">
                
                 <form method="POST">
                    <input type="submit" value="Refuser" name="refuse" class="btn btn-xs btn-danger demande_amis" >
                    <input type="submit" value="Accepter" name="accept" class="btn btn-xs btn-success demande_amis">
                 </form>

                   
                 <div class="user-profil-conseillere"><img style="padding-bottom: 1px" src="/img/user.png"><?php echo "<a href=\"profile.php?user=$from_id\"> Profil</a>"?></div>

                <div class="indice-confiance-conseillere"><img src="img/confiance.png"> Confiance : <strong><?php echo round($confiance).'%' ?></strong></div>

                <div class="personne-aide-conseillere"><img src="img/aide.png"> Personne aidées : <strong><?php echo$nbr_aide?></strong></div>

           </div>
       </div>
    
</div>


<?php
/* - -- - - - - - -  - - - - - - -     Ange gardien           - - - - - - - - - - - - - -  - - - - - - -  - - - - - - - - --   */
}

?>


<?php


$demande_ange = $pdo->prepare('SELECT * FROM anges_request WHERE to_ = ?');
$demande_ange->execute([$my_id]);



while($affiche_ange= $demande_ange->fetch()){

$date_visite = $affiche_ange->date_;
$from_id = $affiche_ange->from_;
$name_friends_request = User::user_name($db, $from_id);

/* traitement formulaire*/
if(isset($_POST['refuse_ange'])){
    Anges::refuse_ange($db,$from_id, $my_id);
header('Location: notifications.php');
}

if(isset($_POST['accept_ange'])){
    Anges::accept_ange($db,$from_id, $my_id);
header('Location: notifications.php');
}

/* on cherche si l'auteur est connecté*/
$user_online = User::user_online($db, $from_id);


$req = $pdo->prepare('SELECT ID, presentation FROM wp_cendrillon_6239_users WHERE ID=?');
$req->execute([$from_id]);
$req1 = $req->fetch();
   if($req1){
         $presentation = $req1->presentation;
         if(!$presentation){ 
            $name = User::user_name($db, $from_id);
          $presentation = $name." n'a pas encore de présentation ! ";
        }
    }


/* On recherhce le sexe de l'auteur */
$sexe_author = User::user_sexe($db, $from_id);
$user_Sexe = User::user_sexe($db, $from_id);
$confiance = User::indice_confiance($db,$from_id);
$nbr_aide = User::nbr_personne_aide($db, $from_id);
    
$date_c = strtotime($date_visite);
$now   = time();
$diff  = abs($now - $date_c);
$jour = 1400*24*3600;

/*on affiche le mois en francais*/
$mois = array(1 =>" janvier " , " février ", " mars ", " avril ", " mai ", " juin ", " juillet ", " août "," septembre "," octobre "," novembre "," decembre ");
$mois[date('n',$date_c)];
$num_mois = date('n',$date_c);
$name_mois = $mois[$num_mois];


?>

<div class="message-gauche" id="notification">

    <div class="container-messages-gauche">
          <div class="titre_message_container">

             <div class="titre_message"> 
                <?php if ($user_Sexe == "fille"){?>
                <div class="nom-conseillere-fille" ><img src="img/fille.png"><?php echo "<a href=\"profile.php?id=$from_id\">$name_friends_request</a>" ?></div><span class="demande_ange"> veut devenir ton Ange Gardien !</span>
                <?php }else {?>
                <div class="nom-conseillere-garcon" ><img src="img/garcon.png"><?php echo "<a href=\"profile.php?id=$from_id\">$name_friends_request</a>" ?></div><span class="demande_ange"> veut devenir ton Ange Gardien !</span>
                <?php }?> 
                <?php if ($conseillère == true){
                   echo "<a title=\"conseillèr(e)\" ><img style=\"padding-bottom: 1px; margin-left: 10px;\" src=\"img/conseillere.png\"></a>";
                    }?>
             </div>
             <?php if($user_online == true){
                echo "<img class=\"user_online\" src=\"img/Point_vert.gif\">"; } ?>
              
             <div class="date_visite"><?php echo ' '.date("d", $date_c); echo $name_mois ; echo date("Y", $date_c); ?></div> 
        </div>
         
          <div class="content-message-gauche"> <?php echo Emojione\Emojione::shortnameToImage($presentation);?></div>
            
          <div class="footer-message">
                
                 <form method="POST">
                    <input type="submit" value="Refuser" name="refuse_ange" class="btn btn-xs btn-danger demande_amis" >
                    <input type="submit" value="Accepter" name="accept_ange" class="btn btn-xs btn-success demande_amis">
                 </form>

                    
                 <div class="user-profil-conseillere"><img style="padding-bottom: 1px" src="/img/user.png"><?php echo "<a href=\"profile.php?user=$from_id\"> Profil</a>"?></div>

                <div class="indice-confiance-conseillere"><img src="img/confiance.png"> Confiance : <strong><?php echo round($confiance).'%' ?></strong></div>

                <div class="personne-aide-conseillere"><img src="img/aide.png"> Personne aidées : <strong><?php echo$nbr_aide?></strong></div>

           </div>
       </div>
    
</div>


<?php

}

?>




</div>
    

<?php endif; ?>



<?php  require "inc/footer.php"; ?>

 