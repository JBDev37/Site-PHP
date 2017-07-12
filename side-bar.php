<div class="container-liste-conseillere" >


       <!--<p href="" class="sous-titre" >Des conseils! Des solutions!</p>-->
       <?php if ($conseillère == false){
       echo "<a href=\"devenir-conseillere.php\" ><div class=\"devenir-conseillere\"><img src=\"img/heart.png\" style=\"position: relative; top: -3px\" > Devenir conseiller</div></a>";
        }?>
        <a href="recherche-conseillere.php" ><div class="recherche-conseillere"><img src="img/valentines.png" > Recherche conseillers</div></a>
        <!--<a href="poster-message.php" ><div class="poster-message"><img src="/img/poster-message.png" > Demander un conseil</div></a>-->


     <div class="top-conseillere">
        <div class="top-conseillere-header"><img src="img/chevron.png" ><strong> Top conseillers</strong></div>
        <a href="classement_complet.php"><div class="classement" ><img src="img/cup.png" >Classement complet</div></a>
     <div class="top-conseillere-scroll">
   
            <?php
           

            $classement = 1;
            $recherche_conseilleres = $pdo->query('SELECT * FROM wp_cendrillon_6239_conseillere ORDER BY indice_confiance DESC LIMIT 12');
            
            while($affiche_conseilleres = $recherche_conseilleres->fetch()){
               
                $name = $affiche_conseilleres->displayname;
                $author_id = $affiche_conseilleres->user_id;
                $confiance = User::indice_confiance($db,$author_id);
                $user_Sexe = User::user_sexe($db, $author_id);
                $user_online = User::user_online($db, $author_id);
                $last_connexion = $affiche_conseilleres->last_connexion;
                $date_c = strtotime($last_connexion);
                $now   = time();
                $diff  = abs($now - $date_c);
                $jour = 7*24*3600;

               
            ?>
                    <?php if ($user_Sexe == "fille"): ?>
                    <div class="top-conseillere-content-fille">
                        <div class="top-conseillere-number">
                       <?php 

                        echo ' n°'.$classement; ?></div>

                                     
                        <div class="top-conseillere-pseudo-fille"><?php echo "<a href=\"profile.php?user=$author_id\">$name </a>"; ?></div> 

                        <?php if($classement == 1){ echo "<img src=\"img/gold.png\">";}?>
                        <?php if($classement == 2){ echo "<img src=\"img/silver.png\">";}?>
                        <?php if($classement == 3){ echo "<img src=\"img/bronze.png\">";}?>

                        <div class="top-conseillere-confiance">

                        <?php
                        if ($confiance<30) {
                            echo "Novice";
                        }
                        if (30 <=$confiance && $confiance <50) {
                            echo "Confirmé";
                        }
                        if (50 <=$confiance && $confiance <70) {
                            echo "Princesse";
                        }
                        if (70 <=$confiance && $confiance <90) {
                            echo "Impératrice";
                        }
                        if ($confiance >=90) {
                            echo "Ange Gardien";
                        } ?>


                        </div>

                    </div>

                      <?php else : ?>

                        <div class="top-conseillere-content-garcon">
                        <div class="top-conseillere-number">
                       <?php 

                        echo ' n°'.$classement; ?></div>

                                     
                        <div class="top-conseillere-pseudo-garcon"><?php echo "<a href=\"profile.php?user=$author_id\">$name </a>"; ?></div> 

                        <?php if($classement == 1){ echo "<img src=\"img/gold.png\">";}?>
                        <?php if($classement == 2){ echo "<img src=\"img/silver.png\">";}?>
                        <?php if($classement == 3){ echo "<img src=\"img/bronze.png\">";}?>

                         <div class="top-conseillere-confiance">

                        <?php
                        if ($confiance<30) {
                            echo "Novice";
                        }
                        if (30 <=$confiance && $confiance <50) {
                            echo "Confirmé";
                        }
                        if (50 <=$confiance && $confiance <70) {
                            echo "Prince";
                        }
                        if (70 <=$confiance && $confiance <90) {
                            echo "Empereur";
                        }
                        if ($confiance >=90) {
                            echo "Ange Gardien";
                        } ?>


                        </div>
 
                    </div>

                        <?php endif; ?>





                     <?php  $classement =  $classement +1; } 

                ?>
                
    </div>
 </div>

</div>

