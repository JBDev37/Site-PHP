<?php

//fonction test
/*$db = App::getDatabase();
$user = $db->query('SELECT * FROM wp_cendrillon_6239_users WHERE ID=?', [4])->fetch();
var_dump($user);
die();*/
require_once "inc/bootstrap.php";

?>
<?php require "inc/header.php"; ?>
<?php  require "side-bar.php"; 
 require "side-bar-right.php"; 

if (isset($_POST['submit_register'])) {

    $errors = array();

        $db = App::getDatabase();

        $validator = new Validator($_POST);
        $validator->isAlpha('user_login', "Le Pseudo n'est pas valide");
        if($validator->isValid()){
            $validator->isUniq('user_login', $db,'wp_cendrillon_6239_users', "Ce pseudo est déjà pris");
        }
        $validator->isEmail('user_email', "Cet email n'est pas valide");
         if($validator->isValid()){
            $validator->isUniq('user_email', $db,'wp_cendrillon_6239_users', "cet email est déjà pris");
          }
         $validator->isConfirmed('user_pass', "Les mots de passe ne correspondent pas");
         
         // on verifie la date de naissance
         $date = explode("-", $_POST['date-naissance']);
         $annee = $date[0];
         $mois= $date[1];
         $jour = $date[2];

         $today = explode('/',date('d/m/y'));
         $annee_today = $today[2];
         $mois_today= $today[1];
         $jour_today = $today[0];

         if(($mois < $mois_today) || (($mois == $mois_today && $jour<=$jour_today))){
                    $age = $annee_today+2000-$annee;
                    }else{
                        $age = $annee_today+2000-$annee-1;
                      }
                   if ($age < 13) {
                        $validator->isAlpha('majeur', "Tu dois avoir +13ans");
                       }
                 


      

         if ($validator->isValid()) {
            $password = $_POST['user_pass'];
            App::getAuth()->register($db, $_POST['user_login'],$_POST['user_sexe'], $password, $_POST['user_email'], $_POST['date-naissance']);

            
           
            

        } else {
            $errors = $validator->getErrors();
        }
    
}
?>
<div class="container-messages">

    <div class="register-form blanc">


    <form id="contact" method="post" action="">

    <fieldset><legend style="color: #0a68b4"><b>Confirmez votre compte</b></legend>
         <div class="presentation-site">Un email de confirmation vous a été envoyé.
            Cliquez sur le lien pour valider votre compte. </br></br>
     <?php $alerte = "<strong>ATTENTION : </strong> Ce mail arrive parfois dans les SPAMS (courriers indésirables), pensez à vérifier vos SPAMS pour valider votre compte (nous sommes en train de régler ce soucis :relaxed:). Pour tous problèmes, n'hésitez pas à nous contacter." ?>
 
    <?php echo Emojione\Emojione::shortnameToImage($alerte);?>

            </div>
       
    </fieldset>




    </div>



</div>


<?php require "inc/footer.php"; ?>