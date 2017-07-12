<?php
/*if(session_status() == PHP_SESSION_NONE){
  session_start();
}*/


require_once "inc/db.php";
include 'thumbsup/init.php';
require_once "inc/bootstrap.php";
require('Emojione/autoload.php');
require_once "inc/functions.php";
require('PHPMailer/PHPMailerAutoload.php');
require('PHPMailer/class.phpmailer.php');
require("PHPMailer/class.smtp.php");



$auth = App::getAuth();
$db = App::getDatabase();


/* Cookie se souvenir de moi */

if(session_status() == PHP_SESSION_NONE){
    session_start();
     }
     
  if(isset($_COOKIE['remember']) && ($_COOKIE['remember'] != NUL) && !isset($_SESSION['auth'])){
    require_once 'db.php';
    if (isset($pdo)) {
      global $pdo;
    }
      $remember_token = $_COOKIE['remember'];
      $parts = explode('==', $remember_token);
      $user_id = $parts[0];
      

      $req = $pdo->prepare('SELECT * FROM wp_cendrillon_6239_users WHERE ID = ?');
      $req->execute([$user_id]);
      $user = $req->fetch();
      if ($user) {
          $expected = $user_id.'=='. $user->remember_token.sha1($user_id.'ratonlaveur');
          if($expected == $remember_token){
              session_start();
                $_SESSION['auth'] = $user;
                setcookie('remember', $remember_token,60*60*24*30);
                App::redirect('account.php');
          }
          else{
             setcookie('remember', NUL, -1);
          }
          
      }else{
          setcookie('remember', NUL, -1);
           }
    }




/*$auth->connectFromCookie($db);*/
/*if($auth->user()){
  App::redirect('account.php');
}*/
/*
include('./mechat/php/config.php'); // Load meChat PHP Configurations
include('./mechat/php/functions.php');*/?>
<?php
ob_start();
ini_set('display_errors','on');
error_reporting(E_ALL);

if(isset($_SESSION['auth'])){
$my_id = $_SESSION['auth']->ID;
$name = User::user_name($db, $my_id);
$bloque = User::is_user_bloque($db, $name);
      if($bloque==true){
      echo "Ton compte a été bloqué";
      echo "</br>";
      echo "<a href=\"contact_bloque.php\">Nous contacter </a>";
      die();
      }

require_once "user_online.php";
User::last_connexion($db, $my_id);
/*meChat_Login($my_id);
echo '<script src="mechat/php/js.php" type="text/javascript"></script>';
};*/

$demande_amis = $pdo->prepare('SELECT * FROM friends_request WHERE to_ = ?');
$demande_amis->execute([$my_id]);

$demande_ange = $pdo->prepare('SELECT * FROM anges_request WHERE to_ = ?');
$demande_ange->execute([$my_id]);




/*$confiance = User::indice_confiance($db,$my_id);*/
$conseillère = User::conseillere($db, $my_id);
$userSexe = User::user_sexe($db, $my_id);
$user_name = User::user_name($db, $my_id);
$user_naissance = User::user_naissance($db, $my_id);
$friends_request = Notifications::count_friends_request($db, $my_id);
$message_non_lu = Notifications::count_message_non_lu($db, $my_id);
$ange_request = Notifications::count_anges_request($db, $my_id);
$commentaire_non_lu = Notifications::count_commentaires_non_lu($db, $my_id); // commentaire sur le profil
$reponse_non_lu = Notifications::count_reponse_non_lu($db, $my_id);
$id_non_lu = Notifications::id_reponse_non_lu($db, $my_id);
$comment_non_lu = Notifications::count_comment_non_lu($db, $my_id);
$id_comment_non_lu = Notifications::id_comment_non_lu($db, $my_id);

$title_message_req = $pdo->prepare('SELECT post_title FROM wp_cendrillon_6239_posts WHERE ID = ? ');
$title_message_req->execute([$id_non_lu]);
if($title_message1 = $title_message_req->fetch()){
$title_message = $title_message1->post_title;
}

$title_message_req1 = $pdo->prepare('SELECT post_title FROM wp_cendrillon_6239_posts WHERE ID = ? ');
$title_message_req1->execute([$id_comment_non_lu]);
if($title_message2 = $title_message_req1->fetch()){
$title_message1 = $title_message2->post_title;
}


$nbr_notifications = $friends_request + $ange_request + $commentaire_non_lu + $reponse_non_lu + $comment_non_lu;
}

if(!isset($_SESSION['auth'])){
$conseillère = false;
}


?>

<!DOCTYPE html>
<html lang="fr">
  <head>
  <title> <?php if (isset($_SESSION['auth']) && $nbr_notifications>0){ echo "(".$nbr_notifications.")";} ?> Kurbys</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge">-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../../favicon.ico">
    <Link  rel = "icône de  raccourci " href = "favicon.ico"  type = "image / x-icon" > 
    
    <!--  Favicon-->
    <link rel="apple-touch-icon" sizes="57x57" href="favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <link rel="manifest" href="favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
     
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="js/infobulle.js"></script>
    <script src="js/tabs.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css?t=<?php echo time(); ?>"media="all">
    <link rel="stylesheet" href="chat/style.css?t=<? echo time(); ?>"media="all">
    <link rel="stylesheet" type="text/css" href="css/style.css?t=<?php echo time(); ?>"media="all">
    <link rel="stylesheet" type="text/css" href="css/responsive.css?t=<?php echo time(); ?>"media="all">

<?php mb_internal_encoding('UTF-8'); ?>
        <?php echo ThumbsUp::css() ?>
        <?php echo ThumbsUp::javascript() ?>

      <!--  EMOTICONE -->
      <script src="https://cdn.jsdelivr.net/emojione/2.2.7/lib/js/emojione.min.js"></script>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/emojione/2.2.7/assets/css/emojione.min.css"/>
      
      <!--  BOOTSTRAP-->
      <script src="https://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
     

      <script type="text/javascript">
          function updateScroll(){
              var d = document.getElementById("box");
              d.scrollTop = d.scrollHeight;
          }

          function triangle1(){
              document.getElementById('menu-secondaire').style.display="block";



          }
          function out(){
              document.getElementById('menu-secondaire').style.display="none";
          }


      </script>
  </head>

  <body >
  <div class="site-container" >
      <div class="site-pusher">
          <header class="header"><div class="logo-kurbys-small"><a href="index.php"><img src="img/logo.png"> </a></div>
              <?php if(isset($_SESSION['auth'])){ ?>
              <div class="login" ><?php echo $user_name  ?> </div> 
              <a href="" class="icon" id="icon"></a><!-- icone hamburger -->
              
              <div class="logo-kurbys"><a href="index.php"><img src="img/logo.png" width="150px" height="30px;"></a></div>
              <?php } else {?>
             
              <div class="logo-kurbys-disconnect"><a href="index.php"><img src="img/logo.png" width="150px" height="30px;"></a></div><div class="slogan"> Des conseils, des solutions !</div> <?php } ?>  

              <nav class="menu">
                  <?php if(isset($_SESSION['auth'])): ?>
                     
                      
                      <div class="menu-login">
                      
                      
                      
                      
                      
                      
   
<div class="container" style="display: inline-block;">
	<div class="row">
		<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header none">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
     <?php $last_user=Chat::last_id_contact($db, $my_id ,$my_id); ?>
      <ul class="nav navbar-nav">
        <li><div class="search"><a href="recherche_pseudo.php"><img src="img/search.png"></a></div></li>
        <li><?php echo"<a style=\"display:inline-block\" href=\"chat.php\">Messagerie</a>";?>
          <?php if($message_non_lu>0){ echo "<div class=\"circle-notification_message\"> $message_non_lu </div>"; }?><div id="notification1"> </div>
        </li>
        <li><a href="profile.php">Profil</a></li>
        <li class="dropdown">
          <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Menu <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="changer_password.php">Mot de passe</a></li>
            <li><a href="signaler_bug.php">Signaler un bug</a></li>
            <li><a href="ameliorer_site.php">Améliorer le site</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="le-secret-de-cendrillon.php">Le secret de Cendrillon</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="supprimer-compte.php">Supprimer mon compte</a></li>
          </ul>
        </li>
      </ul>
      
      <ul class="nav navbar-nav">
        <li class="dropdown">
          <a  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Notification
            <?php if($nbr_notifications>0){ echo "<div class=\"circle-notification\"> $nbr_notifications </div>"; }?>
          </a> 
          <ul class="dropdown-menu notify-drop">
            
            

            <div class="notify-drop-title">
            <!-- 	<div class="row">
            		<div class="col-md-6 col-sm-6 col-xs-6">Bildirimler (<b>2</b>)</div>
            		<div class="col-md-6 col-sm-6 col-xs-6 text-right"><a href="#" class="rIcon allRead" data-tooltip="tooltip" data-placement="bottom" title="tümü okundu."><i class="fa fa-dot-circle-o"></i></a></div>
            	</div>
            </div>-->
            <!-- end notify title -->
            <!-- notify content -->
            <div class="drop-content">

                <?php while($affiche_amis = $demande_amis->fetch()){ 
                $id_from = $affiche_amis->from_;
                $name_friends_request = User::user_name($db, $id_from);?>

                	<li>
                		<div class="col-md-9 col-sm-9 col-xs-9 pd-l0"><a href="notifications.php"><img src="img/friends.png" style="margin-right: 6px;"> Demande en ami de  <?php echo $name_friends_request ?> </a> 
                		
                		</div>
                	</li>
                	 <?php } ?>

                <?php while($affiche_anges = $demande_ange->fetch()){ 
                $id_from = $affiche_anges->from_;
                $name_friends_request = User::user_name($db, $id_from);?>

                  <li>
                    <div class="col-md-9 col-sm-9 col-xs-9 pd-l0"><a href="notifications.php"><img src="img/angels.png" style="margin-right: 6px;"><?php echo $name_friends_request ?> veut devenir ton Ange Gardien ! </a> 
                    
                    </div>
                  </li>
                   <?php } ?>

                   <?php if($commentaire_non_lu ==1){?>
                    <li>
                    <div class="col-md-9 col-sm-9 col-xs-9 pd-l0"><a href="mes_comentaires.php"><img src="img/comments.png" style="margin-right: 6px;">  Nouveaux commentaires </a> 
                    
                    </div>
                  </li>
                    <?php } 


                     if($nbr_notifications==0){?>
                    <li>
                    <div class="col-md-9 col-sm-9 col-xs-9 pd-l0">Pas de notification  </div>
                  </li>
                    <?php } 

                     if($comment_non_lu ==1){?>
                    <li>
                    <div class="col-md-9 col-sm-9 col-xs-9 pd-l0"><?php echo "<a href=\"lire-message.php?id=$id_comment_non_lu\"><img src=\"img/comments.png\" style=\"margin-right: 6px;\">  Nouvelle réponse au message $title_message1  </a> ";?>
                    
                    </div>
                  </li>
                    <?php } 

                    if($reponse_non_lu ==1){?>
                    <li>
                    <div class="col-md-9 col-sm-9 col-xs-9 pd-l0"><?php echo "<a href=\"lire-message.php?id=$id_non_lu\"><img src=\"img/comments.png\" style=\"margin-right: 6px;\">  Nouvelle réponse au message $title_message  </a> ";?>
                    
                    </div>
                  </li>
                    <?php } ?>

            </div>

            <div class="notify-drop-footer text-center">
            	<a href="notifications.php"><i class="fa fa-eye"></i> Voir tout</a>
            </div>

           





          </ul>
        </li>
       <li> <a class="logout" href="logout.php">Se déconnecter</a></li>
      </ul>

    
    
  </div><!-- /.container-fluid -->
</nav>
	</div>
</div>
<script>
$(document).on('load',function($){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script src="http://localhost:3000/socket.io/socket.io.js"></script>
<!--<script src="chat/node_modules/socket.io-client/dist/socket.io.js"></script>-->

<!--<script src="socket.io/socket.io.js"></script>-->

<script>
var my_id =  <?=$my_id?>;

  /*var socket = io.connect("https://kurbys.com:3001");*/
  var socket = io.connect('http://localhost:3000');
/*WEB_SOCKET_SWF_LOCATION = "/var/www/html/node_modules/socket.io/WebSocketMain.swf";*/

socket.on(my_id, function (data) {// connexion à la socket io.emit(user_send, data);
            var msg = data.msg;
            var user1 = data.user_id;
            var user_send1 = data.user_send;
            var user=data.id1;




$('#notification1').append("1").css("background-color","red");

    });


</script> 

                     </div>










                  <?php else: ?>
                    </nav> <!-- menu -->
                    

                    <div class="menu-page-login">
                      <a href="contact.php" class="contact_login" class="contact_acceuil">Contact</a>
                      <a href="register.php" class="inscription btn btn-sm btn-primary" role="button" >S'inscrire</a>
                      <a href="register-login.php" class="inscription btn btn-sm btn-success" role="button" >connexion</a>

                       <a href="register.php" class="inscription-small btn btn-xs btn-primary" role="button" >S'inscrire</a>
                      <a href="register-login.php" class="inscription-small btn btn-xs btn-success" role="button" >Connexion</a>
                      
                      </div>
                  <?php endif; ?>


          </header>



    <div class="site-content" onclick="out()" >




