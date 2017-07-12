<?php

//fonction test
/*$db = App::getDatabase();
$user = $db->query('SELECT * FROM wp_cendrillon_6239_users WHERE ID=?', [4])->fetch();
var_dump($user);
die();*/
require_once "inc/bootstrap.php";
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

            
	  		header('Location: confirm-message.php');
	  		

	  	} else {
            $errors = $validator->getErrors();
        }
	
}



?>
<?php require "inc/header.php"; ?>
<?php  require "side-bar.php"; ?>
<?php  require "side-bar-right.php"; ?>

<div class="container-messages">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
            <p>Vous n'avez pas rempli correctement le formulaire</p>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= $error; ?></li>

                <?php endforeach; ?>
            </ul>

            </div>
        <?php endif; ?>


        <form action="confirm-message.php" method="POST" class="blanc">
            <legend >Inscription</legend>
            <div class="presentation-site">Tu as besoin d'un conseil ? Tu souhaites apporter ton aide ? </br></br>
            </div>

            <label for=""><strong>Pseudo </strong></br></label>
            
             <input type="text" name="user_login" class="form-control" placeholder="Pseudo"  required="">
            </br>

            <label for=""><strong>Email</strong></br></label>
            
                  <input type="email" name="user_email" class="form-control" placeholder="Email" required="">
            </br>

             <label for=""><strong>Mot de passe </strong></br></label>
           
               <input type="password" name="user_pass" class="form-control" placeholder="Mot de passe" required="">
            </br>

             <label for=""><strong>Confirmer le mot de passe</strong> :</br></label>
            
                <input type="password" name="user_pass_confirm" class="form-control" placeholder="Confirmer mot de passe" required="">
            </br>
            

            <label for="">Date de naisance <strong>(+13ans)</strong></br></label>
            <input type="date" name="date-naissance" required placeholder="Date de naissance" /></br></br>

                <div class="titre" ><strong> Je suis : </strong></div>
                <input type="radio" name="user_sexe" value ="fille" >
                <label for="">Une fille </label></br>
                <input type="radio" name="user_sexe" value ="garcon"  />
                <label for="">Un garçon </label></br>

            </br>



                <input type="checkbox" name="cgu" value ="cgu"  required /> J'accepte les <a href ="cgu.php">CGU</a> (Conditions Générales d'Utilisation)

           </br>  </br> 

           <span style="color: red;">ATTENTION : </span>Ceux qui ont un compte sur <strong>"le secret de cendrillon" </strong>peuvent se connecter <a href="register-login.php" class="forget-password"><strong>ici</strong></a>
            </br>  </br>   </br>

            <span style="color: red;">Un problème pour vous inscrire ? </span> <a href="contact.php" class="forget-password"> <strong>Contactez-nous en urgence !</strong></a>
            </br>  </br>   </br>





            <button type="submit" name="submit_register" class="btn btn-primary">S'inscrire</button>
            </form>
      
</div>



<?php require "inc/footer.php"; ?>