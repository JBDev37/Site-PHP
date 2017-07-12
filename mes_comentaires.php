<?php  require "inc/header.php"; ?>

<?php  require "side-bar.php"; ?>
<?php  require "side-bar-right.php"; ?>

<div class="container-messages">
	
			<?php
			Notifications::commentaire_lu($db, $my_id);

			$recherche_messages = $pdo->prepare('SELECT id, from_, to_, commentaire, date_ FROM commentaires WHERE to_ = ?  ORDER BY date_ DESC');
			$recherche_messages->execute([$my_id]);
			

			?><legend class="legend-visite"><b>Mes commentaires</b></legend><?php
			

			while($affiche_messages = $recherche_messages->fetch()){

			$message_id = $affiche_messages->id;
			$author_id = $affiche_messages->from_;

			/* on recherche le nom de l'auteur */
			$name_author = User::user_name($db, $author_id);
			$confiance = User::indice_confiance($db,$author_id);

			/* on cherche si l'auteur est connecté*/
			$req_online = $pdo->prepare('SELECT COUNT(ID_user) FROM users_online WHERE ID_user = :ID_user ');
			$req_online->bindParam(':ID_user', $author_id, PDO::PARAM_STR);
			$req_online->execute();
			$author_online = $req_online->fetchColumn();

			/* On recherhce le sexe de l'auteur */
			$sexe_author = User::user_sexe($db, $author_id);

			           
			$date_message = $affiche_messages->date_;
			$date_c = strtotime($date_message);
			$now   = time();
			$diff  = abs($now - $date_c);
			$jour = 1400*24*3600;

			/*on affiche le mois en francais*/
			$mois = array(1 =>" janvier " , " février ", " mars ", " avril ", " mai ", " juin ", " juillet ", " août "," septembre "," octobre "," novembre "," decembre ");
			$mois[date('n',$date_c)];
			$num_mois = date('n',$date_c);
			$name_mois = $mois[$num_mois];

			$user_Sexe = User::user_sexe($db, $author_id);

			            ?>

        <div class="message-gauche">

            <div class="container-messages-gauche">
			      <div class="titre_message_container">
			         <div class="titre_message"> <?php echo $name_author ?></div>
			         <?php if($user_online == true){
			         echo "<img class=\"user_online\" src=\"img/Point_vert.gif\">"; } ?>

			      </div>
			     
			      <div class="content-message-gauche"> <?php echo Emojione\Emojione::shortnameToImage($affiche_messages->commentaire);?></div>
			        
			      <div class="footer-message">
			            
			            <div class="date-message"> <p><?php echo date("d", $date_c); echo $name_mois ; echo date("Y", $date_c); ?> </div>

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
			                      
			                    }*/
			                    echo "<a href=\"chat.php?user=$author_id\" title=\"message privé\" class=\"private_message\"><img  src=\"img/comment.png\"></a>";
			                ?>  
					                    
				            	                
				            <div class="user-profil-conseillere"><img style="padding-bottom: 1px" src="/img/user.png"><?php echo "<a href=\"profile.php?user=$author_id\"> Profil</a>"?></div>

				            <div class="indice-confiance-conseillere"><img src="img/confiance.png"> Confiance : <strong><?php echo round($confiance).'%' ?></strong></div>

				            <div class="personne-aide-conseillere"><img src="img/aide.png"> Personne aidées : <strong><?php echo $nbr_aide?></strong></div>

			      
			           
			            
			        </div>
			           
             </div>

		</div>	      




<?php
if (isset($_POST[$author_id])){
    Friends::friends_request($db,$my_id, $author_id);
    header("location:mes_comentaires.php");
    }

}
  
?>
</div>

<?php  require "inc/footer.php"; ?>