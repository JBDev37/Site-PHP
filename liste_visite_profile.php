<div class="container-messages">
<?php


$recherche_visites = $pdo->prepare('SELECT from_id, to_id, date_visite FROM visite_profile WHERE to_id = ? ORDER BY date_visite
 DESC');
$recherche_visites->execute([$my_id]);
?><legend class="legend-visite"><b>Les visites sur mon profil</b></legend><?php
while($affiche_visites = $recherche_visites->fetch()){

$from_id = $affiche_visites->from_id;
$date_visite = $affiche_visites->date_visite;

/* on recherche le nom de l'auteur */
$name_author = User::user_name($db, $from_id);


/* on cherche si l'auteur est connecté*/
$user_online = User::user_online($db, $from_id);

/* On recherhce le sexe de l'auteur */
$sexe_author = User::user_sexe($db, $from_id);
$user_Sexe = User::user_sexe($db, $from_id);
$confiance = User::indice_confiance($db,$from_id);
$nbr_aide = User::nbr_personne_aide($db, $from_id);
$conseillère = User::conseillere($db, $from_id );
$date_c = strtotime($date_visite);
$now   = time();
$diff  = abs($now - $date_c);
$jour = 1400*24*3600;

$req = $pdo->prepare('SELECT ID, presentation FROM wp_cendrillon_6239_users WHERE ID=?');
$req->execute([$from_id]);
$req1 = $req->fetch();
	 if($req1){
         $presentation = $req1->presentation;
		     if(!$presentation){ 
		        $name = User::user_name($db, $from_id);
		     	$presentation = $name." n'a pas encore de présentation ! ";
		     }}

/*on affiche le mois en francais*/
$mois = array(1 =>" janvier " , " février ", " mars ", " avril ", " mai ", " juin ", " juillet ", " août "," septembre "," octobre "," novembre "," decembre ");
$mois[date('n',$date_c)];
$num_mois = date('n',$date_c);
$name_mois = $mois[$num_mois];
?>

<div class="message-gauche">

    <div class="container-messages-gauche">
	      <div class="titre_message_container">

	         <div class="titre_message"> 
				<?php if ($user_Sexe == "fille"){?>
	            <div class="nom-conseillere-fille" ><img src="img/fille.png"><?php echo "<a href=\"profile.php?user=$from_id\">$name_author</a>" ?></div>
	            <?php }else {?>
	            <div class="nom-conseillere-garcon" ><img src="img/garcon.png"><?php echo "<a href=\"profile.php?user=$from_id\">$name_author</a>" ?></div>
	            <?php }?> 
	            <?php if ($conseillère == true){
                   echo "<a title=\"conseiller\" ><img style=\"padding-bottom: 1px; margin-left: 10px;\" src=\"img/conseillere.png\"></a>";
                    }?>
	         </div>

	         <?php if($user_online == true){
         		echo "<img class=\"user_online\" src=\"img/Point_vert.gif\">"; } ?>
              
	         <div class="date_visite"><?php echo 'Visite le '.date("d", $date_c); echo $name_mois ; echo date("Y", $date_c); ?></div> 
	    </div>
	     
	      <div class="content-message-gauche"> <?php echo Emojione\Emojione::shortnameToImage($presentation);?></div>
	        
	      <div class="footer-message">
	            
	                       	<?php 
				/*if(isset($_SESSION['auth']) && $my_id!=$from_id){  
					$friends = Friends::is_friends($db,$my_id, $from_id);
					$request = Friends::count_friends_request($db,$my_id, $from_id);
					
	                   /*    Demande en ami 
	                  if($friends == false && $request==false ){ ?>  
	                  
	                  <form class="demande_ami" id="demande_ami"  name="form2" method="POST" >
	                        <?php echo "<input type=\"submit\" name=\"$from_id\" value='+1 ami' id=\"author_id\" class=\" demande_ami btn btn-xs btn-success\" onClick=\"this.value='En attente'\">";?>
	                  </form> 
	                       <?php }

	                  if($friends == false && $request==true ){ ?>  
	                         <?php 

	                        
	                          echo "<input type=\"submit\" name=\"\" value='En attente' class=\" demande_ami btn btn-xs btn-success\" >";
	                           
	                      }
	                  if($friends == true){
	                  echo "<a href=\"\"  title=\"c'est un ami\"><input type=\"submit\" name=\"delete_friend\"  value='Ami' class=\" demande_ami btn btn-xs btn-primary\" ></a>";
	                    } 
						
                    }*/
                    echo "<a href=\"chat.php?user=$from_id\" title=\"message privé\" class=\"private_message\"><img  src=\"img/comment.png\"></a>";
                ?>  
		                    
	               
	                
	             <div class="user-profil-conseillere"><img style="padding-bottom: 1px" src="/img/user.png"><?php echo "<a href=\"profile.php?user=$from_id\"> Profil</a>"?></div>

	            <div class="indice-confiance-conseillere"><img src="img/confiance.png"> Confiance : <strong><?php echo round($confiance).'%' ?></strong></div>

	            <div class="personne-aide-conseillere"><img src="img/aide.png"> Personne aidées : <strong><?php echo$nbr_aide?></strong></div>

	       </div>
       </div>
    
</div>











<?php
if (isset($_POST[$from_id])){
    Friends::friends_request($db,$my_id, $from_id);
    
    }
}

?>

    


 