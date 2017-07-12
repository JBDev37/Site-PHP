<div class="container-messages">



<?php


$recherche_messages = $pdo->query('SELECT ID, post_author, post_title, post_content, post_type, post_date, categorie FROM wp_cendrillon_6239_posts WHERE post_type = "messages" ORDER BY post_date
 DESC');


$post_type = "messages";
$now = date("Y-m-d H:i:s");


if(isset($_POST['submit_message'])){
  if(!empty($_POST)){
      $titre = strip_tags(trim($_POST['titre_message']));
      $content = strip_tags(trim($_POST['contenu']));
      $req = $pdo->prepare("INSERT INTO wp_cendrillon_6239_posts SET post_author = ?, post_title = ?, post_content = ?, post_type = ?, post_date = ?, categorie=?");
      $req->execute([$my_id, $titre, $content, $post_type, $now ,$_POST['categorie']]);


}
}
?>

       <div class="devenir-conseillere-entete">    <?php
           echo "<a href=\"devenir-conseillere.php\" ><div class=\"devenir-conseillere\"><img src=\"img/heart.png\" style=\"position: relative; top: -3px\" > Devenir conseiller</div></a>";
            ?>
            <a href="recherche-conseillere.php" ><div class="recherche-conseillere"><img src="img/valentines.png" > Recherche conseiller</div></a>
            <a href="classement_complet.php"><div class="classement-entete" ><img src="img/cup.png" >Classement complet conseiller</div></a>
        </div>

<?php if(isset($_SESSION['auth'])): ?>
    <div class="poster_message">
        <form action="message_poster.php" class="form-horizontal" method="POST" id="" >
            <div class="titre_poster_mesage">
                <p>Demander un conseil</p>
            </div>
            <input type="text" name="titre_message" class="titre_message_acceuil" placeholder="Titre du message" maxlength="35" required onfocus="this.placeholder = ''" onblur="this.placeholder = ' Titre du message'"/>
            <textarea id="m"  name="contenu" class="textarea_poster_message" onclick="outEmo()" required  placeholder="Comment peut-on vous aider ?" onfocus="this.placeholder = ''" onblur="this.placeholder = ' Comment peut-on vous aider ?'"  /></textarea>
            
            <div class="form-group footer-poster-message"><img class="emoticones-poster-message"  src="emoticones/1f642.png" width="25px" height="25px" onclick="Show_emoticones();">
					  
            <div class="form-group choix-theme" >
					     
                 <div data-toggle="buttons">
  					      <label class="btn btn-primary btn-circle active"><input type="radio" name="categorie" value="Amour" checked>Amour</label>
  					      <label class="btn btn-primary  btn-xs btn-circle ">       <input type="radio" name="categorie" value="Amitié">Amitié</label>
  					      <label class="btn btn-primary btn-xs btn-circle ">       <input type="radio" name="categorie" value="Confiance en soi">Confiance en soi</label>
  					       <label class="btn btn-primary btn-xs btn-circle">       <input type="radio" name="categorie" value="Sexo">Sexo</label>
  					    </div>


					  </div>

          <div class="dropdown choix-deroulant form-group">
                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Catégories
                <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                  <div data-toggle="buttons">
                  <label class="btn btn-primary btn-circle active"><input type="radio" name="categorie" value="Amour">Amour</label></br>
                  <label class="btn btn-primary  btn-xs btn-circle ">       <input type="radio" name="categorie" value="Amitié">Amitié</label></br>
                 <label class="btn btn-primary btn-xs btn-circle ">       <input type="radio" name="categorie" value="Confiance en soi">Confiance en soi</label></br>
                  <label class="btn btn-primary btn-xs btn-circle"><input type="radio" name="categorie" value="Sexo">Sexo</label></br>
                </div>


                </ul>
          </div>



         
					<input type="submit" name="submit_message" value="valider" class="btn btn-sm btn-primary valider-message"/> 
              
            </div>
               
	            
	            <div class="bloc-emoticones-poster-message"></div><?php require_once "emoticones.php"; ?></br>

        </form>

    </div>

<?php endif; ?>

<?php
while($affiche_messages = $recherche_messages->fetch()){

$message_id = $affiche_messages->ID;
$author_id = $affiche_messages->post_author;
$categorie_msg = $affiche_messages->categorie;

/* on compte le nombre de commentaire pour chaque message*/
$nb_com = Messages::nbr_commentaire($db, $message_id);

/* on recherche le nom de l'auteur */
$name_author = User::user_name($db, $author_id);
$confiance = User::indice_confiance($db,$author_id);

/* On recherhce le sexe de l'auteur */
$sexe_author = User::user_sexe($db, $author_id);

$date_message = $affiche_messages->post_date;
$date_c = strtotime($date_message);
$now   = time();
$diff  = abs($now - $date_c);
$jour = 14*24*3600;

/*on affiche le mois en francais*/
$mois = array(1 =>" janvier " , " février ", " mars ", " avril ", " mai ", " juin ", " juillet ", " août "," septembre "," octobre "," novembre "," decembre ");
$mois[date('n',$date_c)];
$num_mois = date('n',$date_c);
$name_mois = $mois[$num_mois];

$user_online = User::user_online($db, $author_id);
$user_Sexe = User::user_sexe($db, $author_id);
$message_poste = $affiche_messages->post_content;

            if ($diff<$jour) {

            ?>


<div class="message-gauche">

    <div class="container-messages-gauche">
      
      <?php if ($user_Sexe == "garcon"){ ?>
      <div class="titre_message_container">
        
         <?php 
         echo "<div class=\"titre_message\"><a href=\"lire-message.php?id={$affiche_messages->ID}\">$affiche_messages->post_title</a> </div>";
         ?>

         <?php if($user_online == true){
         echo "<img class=\"user_online\" src=\"img/Point_vert.gif\">"; } ?>
         


          <div class="categorie_msg"  ><?php echo $categorie_msg?></div> 
         <?php if(isset($_SESSION['auth'])){ 
          
          $is_signaler = Messages::is_signaler_msg($db, $message_id, $my_id);
             if($is_signaler==true){
             echo "<form class=\"signaler \" enctype=\"multipart/form-data\"   method=\"post\">";?>      <?php echo "<input type=\"submit\" name=\"$message_id\" disabled id=\"$message_id\" value=\"Signalé !\" id=\"$message_id\" class=\"signaler\" style=\"font-weight:bold;\"/>";}
             else {
              echo "<form class=\"signaler \" enctype=\"multipart/form-data\"  method=\"post\">";?>      <?php echo "<input type=\"submit\" name=\"$message_id\"  id=\"$message_id\" value=\"Signaler\" id=\"$message_id\" class=\"signaler\" />";}
             

              ?> </form> <?php } ?>
      </div> <?php } ?>

      <?php if ($user_Sexe == "fille"){ ?>
       <div class="titre_message_container_fille">
        
         <?php 
         echo "<div class=\"titre_message_fille\"><a href=\"lire-message.php?id={$affiche_messages->ID}\">$affiche_messages->post_title</a> </div>";
        ?>

         <?php if($user_online == true){
         echo "<img class=\"user_online\" src=\"img/Point_vert.gif\">"; } ?>
         


          <div class="categorie_msg"  ><?php echo $categorie_msg?></div> 
         <?php if(isset($_SESSION['auth'])){ 
          
          $is_signaler = Messages::is_signaler_msg($db, $message_id, $my_id);
             if($is_signaler==true){
             echo "<form class=\"signaler \" enctype=\"multipart/form-data\"   method=\"post\">";?>      <?php echo "<input type=\"submit\" name=\"$message_id\" disabled id=\"$message_id\" value=\"Signalé !\" id=\"$message_id\" class=\"signaler\" style=\"font-weight:bold;\"/>";}
             else {
              echo "<form class=\"signaler \" enctype=\"multipart/form-data\"  method=\"post\">";?>      <?php echo "<input type=\"submit\" name=\"$message_id\"  id=\"$message_id\" value=\"Signaler\" id=\"$message_id\" class=\"signaler\" />";}
             

              ?> </form> <?php } ?>
      </div> <?php } ?>
     
      <div class="content-message-gauche"> <?php echo Emojione\Emojione::shortnameToImage(nl2br(substr($message_poste , 0,600)));?></div>
        
      <div class="footer-message_acceuil">
           
            <div class="repondre btn btn-sm btn-primary"><?php echo "<a href=\"lire-message.php?id={$affiche_messages->ID}\">Aider</a>" ?></div>
            <div class="date-message"> <p><?php echo date("d", $date_c); echo $name_mois ; echo date("Y", $date_c); ?> </div>  

                <?php if ($user_Sexe == "fille"){
                 echo " <div class=\"fille\" ><a href=\"profile.php?user=$author_id\" title=\"profil $name_author\" >$name_author  </a></div>";
                } else {
                  echo " <div class=\"garcon\" ><a href=\"profile.php?user=$author_id\" title=\"profil $name_author\" >$name_author  </a></div>";
                }

 ?>

             
           
            <div class="nbr-reponse"><?php if ($nb_com < 2) {
                                echo "<div style=\"color: red; display: inline-block;\"><a href=\"lire-message.php?id={$affiche_messages->ID}\" style=\"color:red;\">$nb_com</a></div> réponse";   
                                } else{
                                 echo "<div style=\"color: red; display: inline-block;\"><a href=\"lire-message.php?id={$affiche_messages->ID}\"style=\"color:red;\">$nb_com</a></div> réponses";   
                                 } ; ?> </p>
            </div>
             
             	<?php 
                    echo "<a href=\"chat.php?user=$author_id\" title=\"message privé\" class=\"private_message\"><img  src=\"img/comment.png\"></a>";
                ?>  

            
       </div>
           
       </div>

</div>


<?php
if (isset($_POST[$message_id])){
    $signaler = Messages::signaler_msg($db, $message_id, $my_id, $author_id);
    header('Location: index.php');
    }

if (isset($_POST[$author_id])){
    Friends::friends_request($db,$my_id, $author_id);
    header('Location: index.php');
    }


?>


<?php
}
}

?>

<script type="text/javascript">
/*$(document).ready(function(){
	$("#demande_ami").submit(function(){
		$.post('demande_ami.php',{author_id : $('#author_id').attr('name')});
		

	}); 
});*/

</script>

 