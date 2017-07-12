<?php require_once "inc/functions.php"; ?>
<?php  require "inc/header.php"; ?>
<?php  require "side-bar-right.php"; ?>
<?php  require "side-bar.php"; ?>
<?php
$confiance = User::indice_confiance($db,$my_id);
$conseillère = User::conseillere($db, $my_id);
?>

<div class="container-messages">

    <div class="register-form blanc">

      
                <legend style="color: #0a68b4; text-align: center;"><b>Le Secret de Cendrillon</b></legend>
                <img src="img/livre.png" height="300" width="195" style="margin-left: 0px; display: inline-block;" > 


                    <div style="display: block;" > Notre livre est disponible sur <a href="http://www.amazon.fr/Le-Secret-Cendrillon-A-Roux/dp/B00A9QO52O/ref=sr_1_2?ie=UTF8&qid=1354734662&sr=8-2"> <img src="img/amazon.gif" width="150" height="40"> </a> et sur <a href="http://livre.fnac.com/a5195734/Jean-Benoit-Roussat-Le-secret-de-Cendrillon"> <img src="img/Fnac.gif" width="60" height="60"> </a>  </div>


                    <?php if($conseillère == true && $confiance>=55):?>
                    <div class="telecharger" style="display: block;">
                      <button class=" btn btn-sm btn-primary"  ><a href="Extrait - Le Secret de Cendrillon.pdf"> Télecharger un extrait</a></button><br>
                      Les conseillers qui ont un indice de confiance supérieur à <strong>55%</strong> peuvent télécharger un extrait.
                    </div>
                    <?php else: ?>
                    <div style="display: block;">
                      <button class=" btn btn-sm btn-primary" disabled >Télecharger un extrait</button><br>
                      Les conseillers qui ont un indice de confiance supérieur à <strong>55%</strong> peuvent télécharger un extrait.
                    </div><br>

                    <?php endif;  ?><br>

                    <div> Si vous avez des questions sur le livre, vous pouvez nous joindre à : <a href="mailto: cendrillon@le-secret-de-cendrillon.fr">cendrillon@le-secret-de-cendrillon.fr</a> </div><br>

                    <div style="display: inline-block; text-align: center; font-weight: bold; margin-left: 30%; margin-right: 30px;"> <img src="img/Ambre.png" width="120px" height="120px;"></br>Ambre </div>

                    <div style="display: inline-block; text-align: center;font-weight: bold; " > <img src="img/JB.png" width="120px" height="120px;"></br>Jean-Benoit </div>

    </div>



</div>
<?php  require "inc/footer.php"; ?>

 