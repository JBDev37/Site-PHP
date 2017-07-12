<div class="side-bar-right" >
<?php if(!isset($_SESSION['auth'])): ?>
     <div class="new-top-conseillere">
     <div class="new-conseillere"><img src="img/new-conseillere.png" > Derniers  conseillers inscrits</div>
       <div class="scroll-top-conseillere">                     
        <?php
       
        $recherche_conseilleres = $pdo->query('SELECT * FROM wp_cendrillon_6239_conseillere ORDER BY date_register DESC');
        while($affiche_conseilleres = $recherche_conseilleres->fetch()){
            $confiance = $affiche_conseilleres->indice_confiance;
            $presentation = $affiche_conseilleres->presentation;
            $name = $affiche_conseilleres->displayname;
            $author_id = $affiche_conseilleres->user_id;
            $user_Sexe = User::user_sexe($db, $author_id);
            $date = $affiche_conseilleres->date_register;

            $date_c = strtotime($date);

            /*on affiche le mois en francais*/
            $mois = array(1 =>" janvier " , " février ", " mars ", " avril ", " mai ", " juin ", " juillet ", " août "," septembre "," octobre "," novembre "," decembre ");
            $mois[date('n',$date_c)];
            $num_mois = date('n',$date_c);
            $name_mois = $mois[$num_mois];
            $year = date("Y", $date_c);

            if($year == "-0001"){ $year = "2017"; $name_mois = " mai ";}

        ?>
      <?php if ($user_Sexe == "fille"): ?>        
        <div class="new-conseillere-content-fille">
            <div class="new-conseillere-header">
                <div class="top-conseillere-number">
                </div>
              <div class="top-conseillere-pseudo-fille"><?php echo "<a href=\"profile.php?user=$author_id\">$name </a>"; ?></div> 
            </div>

            <div class="new-conseillere-presentation">
           
           <?php  $origin = array("à", "\\");  $replace = array("a", ""); echo Emojione\Emojione::shortnameToImage(substr(str_replace($origin, $replace, "$presentation"),0,190));?>

            </div> 
            <div class="new-conseillere-footer">
            <?php echo 'Le '.date("d", $date_c); echo $name_mois ; echo $year ; ?> 
                <?php echo "<a href=\"register.php\" title=\"message privé\" class=\"new-conseillere-comment\"><img  src=\"img/comment.png\"></a>"; ?>
                <div class="new-conseillere-profil"></div>
                <?php echo "<a href=\"register.php\" title=\"profil\" class=\"new-conseillere-profil\"><img src=\"img/profil.png\"></a>"; ?>
            </div>
        </div>

       <?php else : ?>

                <div class="new-conseillere-content-garcon">
            <div class="new-conseillere-header">
                <div class="top-conseillere-number">
                </div>
              <div class="top-conseillere-pseudo-garcon"><?php echo "<a href=\"profile.php?user=$author_id\">$name </a>"; ?></div>  
            </div>

            <div class="new-conseillere-presentation">
             <?php  $origin = array("à", "\\");  $replace = array("a", ""); echo Emojione\Emojione::shortnameToImage(substr(str_replace($origin, $replace, "$presentation"),0,190));?>
            </div> 
            <div class="new-conseillere-footer">
            <?php echo 'Le '.date("d", $date_c); echo $name_mois ; echo $year ; ?> 
                <?php echo "<a href=\"register.php\" title=\"message privé\" class=\"new-conseillere-comment\"><img  src=\"img/comment.png\"></a>"; ?>
                <div class="new-conseillere-profil"></div>
                <?php echo "<a href=\"register.php\" title=\"profil\" class=\"new-conseillere-profil\"><img src=\"img/profil.png\"></a>"; ?>
            </div>
        </div>

      <?php endif; ?>

         <?php  }   ?>
            
        
        </div>
    </div>

<?php else: 

$affiche_visite = User::nbr_visite($db, $my_id);
$confiance = User::indice_confiance($db,$my_id);
$nbr_aide = User::nbr_personne_aide($db, $my_id);
$nbr_message_poste = User::nbr_message_poste($db, $my_id);
$nbr_message_signale = Messages::count_signaler_msg($db,$my_id);
$nbr_conseils = Messages::nbr_aide_poste($db, $my_id);
$nbr_commentaires = User::nbr_commentaires($db, $my_id);
$nbr_avertissement = Messages::count_avertissement($db,$my_id);
$presentation = User::presentation_profile($db, $my_id);
$nbr_amis = Friends::count_friends($db,$my_id);
$ange_id = Anges::my_angel($db,$my_id);
$ange_name = User::user_name($db, $ange_id);
$kurbys_id = Anges::my_kurbys($db,$my_id);
$kurbys_name = User::user_name($db, $kurbys_id);
?>
    
<div class="indice-confiance-titre"><a href="profile.php">
        Profil
</a></div>

<div class="side-profile">
    <div class="side-profile-scroll">
                <div class="indice-confiance">
                      <div class="side-confiance-titre">
                          Mon indice de confiance
                      </div>
                      <div class="side-confiance-content">
                         <?php echo round($confiance).'%' ;?>
                      </div>
                </div>

                <div class="side-confiance"><a href="personnes_aide.php">
                      <div class="side-confiance-titre">
                          Personnes aidées
                      </div>
                      <div class="side-confiance-content">
                         <?php echo $nbr_aide ;?>
                      </div></a>
                </div>

                <div class="side-confiance"><a href="mes_messages.php">
                      <div class="side-confiance-titre">
                          Messages postés
                      </div>
                      <div class="side-confiance-content">
                         <?php echo $nbr_message_poste ;?>
                      </div></a>
                </div>

                <div class="side-confiance"><a href="mes_conseils.php">
                      <div class="side-confiance-titre">
                          Mes conseils
                      </div>
                      <div class="side-confiance-content">
                         <?php echo $nbr_conseils; ?>
                      </div></a>
                </div>

                <div class="side-confiance"><a href="liste_amis.php">
                      <div class="side-confiance-titre">
                          Amis
                      </div>
                      <div class="side-confiance-content">
                         <?php echo $nbr_amis ;?>
                      </div></a>
                </div>

                <div class="side-confiance"><a href="visite_profile.php">
                      <div class="side-confiance-titre">
                         Visites sur mon profil
                      </div>
                      <div class="side-confiance-content">
                         <?php echo $affiche_visite ;?>
                      </div></a>
                </div>

                <?php /*if($ange_id){ ?>
                <div class="side-confiance"> <?php echo "<a href=\"profile.php?user=$ange_id\">"; ?>
                      <div class="side-confiance-titre">
                         Ange gardien
                      </div>
                      <div class="side-ange-content">
                          <?php echo $ange_name;?>
                      </div></a>
                </div> <?php }

                if($kurbys_id){ ?>
                <div class="side-confiance"><?php echo "<a href=\"profile.php?user=$kurbys_id\">"; ?>
                      <div class="side-confiance-titre">
                         KURBYS
                      </div>
                      <div class="side-ange-content">
                          <?php echo $kurbys_name;?>
                      </div></a>
                </div> <?php } */?>

                <div class="side-confiance"><a href="mes_comentaires.php">
                      <div class="side-confiance-titre">
                         Commentaires
                      </div>
                      <div class="side-confiance-content">
                         <?php echo $nbr_commentaires ;?>
                      </div></a>
                </div>

                <div class="side-confiance"><a href="avertissement.php">
                      <div class="side-confiance-titre">
                         Avertissement
                      </div>
                      <div class="side-confiance-content">
                         <?php echo $nbr_avertissement ;?>
                      </div></a>
                </div>

                <div class="side-confiance">
                      <div class="side-confiance-titre">
                         Messages signalés
                      </div>
                      <div class="side-confiance-content">
                         <?php echo $nbr_message_signale ;?>
                      </div>
                </div>
        </div>

</div>










<?php endif; ?>



</div>

