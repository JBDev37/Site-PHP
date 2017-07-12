<div class="container-messages">
<?php


$recherche_personnes = $pdo->prepare('SELECT comment_author_id, comment_post_ID, comment_author, comment_date FROM wp_cendrillon_6239_comments WHERE comment_author_id = ? ORDER BY comment_date DESC');

$recherche_personnes->execute([$my_id]);

?><legend class="legend-visite"><b>Personnes aidées</b></legend><?php
while($affiche_personnes = $recherche_personnes->fetch()){

$comment_post_id = $affiche_personnes->comment_post_ID;
$user_id = User::id_author_commentaire($db, $comment_post_id);
$date = $affiche_personnes->comment_date;

/* on recherche le nom de l'auteur */
$name_author = User::user_name($db, $user_id);


/* on cherche si l'auteur est connecté*/
$req_online = $pdo->prepare('SELECT COUNT(ID_user) FROM users_online WHERE ID_user = :ID_user ');
$req_online->bindParam(':ID_user', $from_id, PDO::PARAM_STR);
$req_online->execute();
$author_online = $req_online->fetchColumn();

/* On recherhce le sexe de l'auteur */
$user_Sexe = User::user_sexe($db, $user_id);
$confiance = User::indice_confiance($db,$user_id);

$req = $pdo->prepare('SELECT ID, presentation FROM wp_cendrillon_6239_users WHERE ID=?');
$req->execute([$user_id]);
$req1 = $req->fetch();
	 if($req1){
         $presentation = $req1->presentation;
		     if(!$presentation){ 
		        $name = User::user_name($db, $user_id);
		     	$presentation = $name." n'a pas encore de présentation ! ";}}




$date = $affiche_personnes->comment_date;
$date_c = strtotime($date);
$now   = time();
$diff  = abs($now - $date_c);
$jour = 1400*24*3600;

/*on affiche le mois en francais*/
$mois = array(1 =>" janvier " , " février ", " mars ", " avril ", " mai ", " juin ", " juillet ", " août "," septembre "," octobre "," novembre "," decembre ");
$mois[date('n',$date_c)];
$num_mois = date('n',$date_c);
$name_mois = $mois[$num_mois];
$user_online = User::user_online($db, $user_id);
$nbr_aide = User::nbr_personne_aide($db, $user_id);
?>


<div class="message-gauche">

    <div class="container-messages-gauche">
	      <div class="titre_message_container">

	         <div class="titre_message"> 
				<?php if ($user_Sexe == "fille"){?>
	            <div class="nom-conseillere-fille" ><img src="img/fille.png"><?php echo "<a href=\"profile.php?id=$author_id\">$name_author</a>" ?></div>
	            <?php }else {?>
	            <div class="nom-conseillere-garcon" ><img src="img/garcon.png"><?php echo "<a href=\"profile.php?id=$author_id\">$name_author</a>" ?></div>
	            <?php }?>
	         </div>
	        <?php if($user_online == true){
         		echo "<img class=\"user_online\" src=\"img/Point_vert.gif\">"; } ?>
              <div class="date_visite"><?php echo 'Aidé le '.date("d", $date_c); echo $name_mois ; echo date("Y", $date_c); ?></div> 
	          
              
	         
	    </div>
	     
	      <div class="content-message-gauche"> <?php echo Emojione\Emojione::shortnameToImage(str_replace("\\", " ", "$presentation"));?></div>
	        
	      <div class="footer-message">
	            
	           <?php 
				 /*if(isset($_SESSION['auth']) && $my_id!=$user_id){  
					$friends = Friends::is_friends($db,$my_id, $user_id);
					$request = Friends::count_friends_request($db,$my_id, $user_id);
					
	                   /*    Demande en ami 
	                  if($friends == false && $request==false ){ ?>  
	                  
	                  <form class="demande_ami" id="demande_ami"  name="form2" method="POST" >
	                        <?php echo "<input type=\"submit\" name=\"$user_id\" value='+1 ami' id=\"author_id\" class=\" demande_ami btn btn-xs btn-success\" onClick=\"this.value='En attente'\">";?>
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
                    echo "<a href=\"chat.php?user=$user_id\" title=\"message privé\" class=\"private_message\"><img  src=\"img/comment.png\"></a>"; 
                ?>  
		                    
	             
	                
	             <div class="user-profil-conseillere"><img style="padding-bottom: 1px" src="/img/user.png"><?php echo "<a href=\"profile.php?user=$author_id\"> Profil</a>"?></div>

	            <div class="indice-confiance-conseillere"><img src="img/confiance.png"> Confiance : <strong><?php echo round($confiance).'%' ?></strong></div>

	            <div class="personne-aide-conseillere"><img src="img/aide.png"> Personne aidées : <strong><?php echo $nbr_aide?></strong></div>

	       </div>
       </div>
    
</div>



<?php
if (isset($_POST[$user_id])){
    Friends::friends_request($db,$my_id, $user_id);
    
    }
}

?>



    


 