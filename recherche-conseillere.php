<?php require_once "inc/functions.php"; ?>
<?php logged_only(); ?>
<?php  require "inc/header.php"; ?>
<?php  require "side-bar-right.php"; ?>
<?php  require "side-bar.php"; ?>

<div class="container-messages">

<?php
if(!isset($_SESSION['auth'])): ?>
    <div class="connexion-obligatoire">
    <legend>Contacter un conseiller</legend>
         Oups...vous n'êtes pas connecté ! <a href="register-login.php" class="inscription btn btn-success role="button" >Connexion</a>
    </div>

<?php else:

?>
<div class="register-form-recherche blanc1">

        <form enctype="multipart/form-data" action="recherche-conseillere.php" method="post">
            <fieldset>
            	
	                <legend>Contacter un conseiller</legend>
	                <strong>Ta tranche d'&acirc;ge :</strong><br/>
	                 <div data-toggle="buttons">
	                <label class="btn btn-primary btn-circle choix"><INPUT type="radio" name="age[0]" value="1" >  Coll&egrave;ge</label>
	                <label class="btn btn-primary btn-circle choix"><INPUT type="radio" name="age[1]" value="1">  Lyc&eacute;e</label>
	                <label class="btn btn-primary btn-circle choix"><INPUT type="radio" name="age[2]" value="1">  +18 ans</label>
	                </div>
	                <br/>

	                <strong>Dans quel domaine souhaites-tu obtenir un conseil :</strong><br/>
	                <div data-toggle="buttons">
	                <label class="btn btn-primary btn-circle choix"><INPUT type="checkbox" name="domaine[0]" value="1" >  Amour  <div style="display: inline-block; margin-left: 5px"></div></label>	                <label class="btn btn-primary btn-circle choix"><INPUT type="checkbox" name="domaine[1]" value="1">  Amiti&eacute;  <div style="display: inline-block; margin-left: 5px"></div></label>
	                <label class="btn btn-primary btn-circle choix"><INPUT type="checkbox" name="domaine[2]" value="1">  Confiance en soi  <div style="display: inline-block; margin-left: 5px"></div></label>
	                <label class="btn btn-primary btn-circle choix"><INPUT type="checkbox" name="domaine[3]" value="1">  Sexo  <div style="display: inline-block; margin-left: 5px"></div></label>
	                </div>
	                <br/> 
	            <div data-toggle="buttons">
	                <strong>Je veux un conseil des : </strong><br/>
	                <label class="btn btn-primary btn-circle choix"><INPUT type="radio" name="filtre[0]" value="garcon" >  Garçons  <div style="display: inline-block; margin-left: 5px"></div></label>
	                <label class="btn btn-primary btn-circle choix"><INPUT type="radio" name="filtre[1]" value="fille">  Filles  <div style="display: inline-block; margin-left: 5px"></div></label>
	                <label class="btn btn-primary btn-circle choix"><INPUT type="radio" name="filtre[2]" value="">  Les deux  <div style="display: inline-block; margin-left: 5px"></div></label>
	                <br/> <br/>
                </div>
	            <input type="submit" name="submit" value="valider" class="btn btn-success"/>
	        </fieldset>
        </form>

    
</div>

<?php

if(isset($_POST['submit'])){
	echo "</br>";
	echo "<legend class=\"legend-disponible\"><b style=\"color: #0a68b4\">Conseillers disponibles :</b></legend>";
    if(isset($_POST['filtre'][2])){$garcon = "garcon"; $fille="fille";}
    if(isset($_POST['filtre'][0])){$garcon = $_POST['filtre'][0];}else{$garcon="fille";}
    if(isset($_POST['filtre'][1])){$fille = $_POST['filtre'][1];}else{$fille="garcon";}
	if(isset($_POST['age'][0])){$college = $_POST['age'][0];}else{$college=2;}
	if(isset($_POST['age'][1])){$lycee = $_POST['age'][1];}else{$lycee=2;}
	if(isset($_POST['age'][2])){$adulte = $_POST['age'][2];}else{$adulte=2;}	
	if(isset($_POST['domaine'][0])){$amour = $_POST['domaine'][0];}else{$amour=2;}
	if(isset($_POST['domaine'][1])){$amitie = $_POST['domaine'][1];}else{$amitie=2;}
	if(isset($_POST['domaine'][2])){$confiance = $_POST['domaine'][2];}else{$confiance=0;}
	if(isset($_POST['domaine'][3])){$sexo = $_POST['domaine'][3];}else{$sexo=2;}
	
/* on cherche les conseillères dans la table*/
$conseillere = $pdo->prepare('SELECT user_sexe, user_id, displayname, college, lycee, adulte, amour, amitie, confiance, sexo, presentation, last_connexion FROM wp_cendrillon_6239_conseillere WHERE user_sexe = ? OR user_sexe = ? AND (college = ? OR lycee = ? OR adulte = ?) AND (amour = ? OR amitie = ? OR confiance = ? OR sexo = ?) ORDER BY last_connexion DESC');
$conseillere->execute([$garcon, $fille, $college, $lycee, $adulte, $amour, $amitie, $confiance, $sexo]); 



while ($affiche_conseillere = $conseillere->fetch()){

	$author_id = $affiche_conseillere->user_id;
	$name_author = $affiche_conseillere->displayname;
/* On recherhce le sexe de l'auteur */
	$user_Sexe = User::user_sexe($db, $author_id);
    $user_name = User::user_name($db, $author_id);

/* on cherche si l'auteur est connecté*/
$user_online = User::user_online($db, $author_id);

$insert_user_id = User::update_user_name($db,$name_author);
$insert_user_sexe = User::update_user_sexe($db,$author_id);
$nbr_aide = USer::nbr_personne_aide($db, $author_id);
$confiance = User::indice_confiance($db,$author_id);
 ?>

<div class="message-gauche">

    <div class="container-messages-gauche">
	      <div class="titre_message_container">

	         <div class="titre_message"> 
				<?php if ($user_Sexe == "fille"){?>
	            <div class="nom-conseillere-fille" ><?php echo "<a href=\"profile.php?user=$author_id\">$name_author</a>" ?></div>
	            <?php }else {?>
	            <div class="nom-conseillere-garcon" ><?php echo "<a href=\"profile.php?user=$author_id\">$name_author</a>" ?></div>
	            <?php }?>
	         </div>
       			 <?php if($user_online == true){
         		echo "<img class=\"user_online\" src=\"img/Point_vert.gif\">"; } ?>
	    </div>
	     
	      <div class="content-message-gauche"> <?php echo strip_tags(trim(Emojione\Emojione::shortnameToImage(str_replace("\\", " ", "$affiche_conseillere->presentation"))));?></div>
	        
	      <div class="footer-message">
	            
	         <?php 
      				 /*if(isset($_SESSION['auth']) && $my_id!=$author_id){ 
      					$friends = Friends::is_friends($db,$my_id, $author_id);
      					$request = Friends::count_friends_request($db,$my_id, $author_id);
					
	                   /*    Demande en ami
	                  if($friends == false && $request==false ){ ?>  
	                  
	                  <form class="demande_ami" id="demande_ami"  name="form2" method="POST" >
	                        <?php echo "<input type=\"submit\" name=\"$author_id\" value='+1 ami' id=\"author_id\" class=\" demande_ami btn btn-xs btn-success\" onClick=\"this.value='En attente'\">";?>
	                  </form> 
	                       <?php }

	                  if($friends == false && $request==true ){ ?>  
	                         <?php 

	                        
	                          echo "<input type=\"submit\" name=\"\" value='En attente' class=\" demande_ami btn btn-xs btn-success\" >";
	                           
	                      }
	                  if($friends == true){
	                  echo "<a href=\"\"  title=\"c'est un ami\"><input type=\"submit\" name=\"delete_friend\"  value='Ami' class=\" demande_ami btn btn-xs btn-primary\" ></a>";
	                    } 
                      echo "<a href=\"chat.php?user=$author_id\" title=\"message privé\" class=\"private_message\"><img  src=\"img/comment.png\"></a>";
                    }*/
                ?>  
		                    
	            	                
	             <div class="user-profil-conseillere"><img style="padding-bottom: 1px" src="/img/user.png"><?php echo "<a href=\"profile.php?user=$author_id\"> Profil</a>"?></div>

	            <div class="indice-confiance-conseillere"><img src="img/confiance.png"> Confiance : <strong><?php echo round($confiance).'%' ?></strong></div>

	            <div class="personne-aide-conseillere"><img src="img/aide.png"> Personne aidées : <strong><?php echo $nbr_aide?></strong></div>

	            <?php echo "<a href=\"chat.php?id_send=$author_id\" class=\"btn btn-sm btn-primary private_message_search\">contacter</a>"; ?>  

	       </div>
       </div>
</div>




	<?php

if (isset($_POST[$author_id])){
    Friends::friends_request($db,$my_id, $author_id);
   
    }
}
	}
	?>
<?php endif; ?>

<?php  require "inc/footer.php"; ?>