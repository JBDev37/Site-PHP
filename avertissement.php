<?php require_once "inc/functions.php"; ?>
<?php  require "inc/header.php"; ?>
<?php  require "side-bar.php"; ?>
<?php  require "side-bar-right.php"; ?>
<div class="container-messages">

<?php
$nbr_avertissement = Messages::count_avertissement($db,$my_id);

?>
        


            <div class="container-messages-gauche">
                <div class="register-form blanc">
               
                      <legend style="color: #0a68b4"><b>Avertissements</b></legend>
                     
                     Nombre d'avertissements : <strong style="color: red;"><?php echo $nbr_avertissement;?></strong></br>
                     Au bout de <strong style="color: red;">3 </strong>avertissements ton compte sera definitivement supprimé.</br>
                     </br>
                     </br>

                     <table>

                          <tr>
                              <td>
                                <div class="avertissement"></div>
                                <?php if($nbr_avertissement==0){
                                echo "<div class=\"triangle-vert\"></div>";
                                  } else{
                                echo "<div class=\"triangle-vert\" style=\"visibility: hidden;\"></div>";
                                    } ?>
                                <img src="emoticones/1f600.png" width="40" height="40">

                              </td>

                              <td>
                                <div class="avertissement"></div>
                                <?php if($nbr_avertissement==1){
                                echo "<div class=\"triangle-vert\"></div>";
                                  } else{
                                echo "<div class=\"triangle-vert\" style=\"visibility: hidden;\"></div>";
                                    } ?>  
                                <img src="emoticones/1f61f.png" width="40" height="40">

                              </td>

                              <td>
                                <div class="avertissement"></div>
                                <?php if($nbr_avertissement==2){
                                echo "<div class=\"triangle-vert\"></div>";
                                  } else{
                                echo "<div class=\"triangle-vert\" style=\"visibility: hidden;\"></div>";
                                    } ?>    
                                <img src="emoticones/1f61e.png" width="40" height="40">

                              </td>

                              <td>
                                <div class="avertissement"></div>
                                <div class="triangle-vert" style="visibility: hidden;"></div>      
                                <img src="emoticones/1f621.png" width="40" height="40"></br>


                              </td>
                            
                          </tr>
                       





                     </table>
       </br> </br> Merci de signaler les utilisateurs qui ont un comportement indésirable sur le site.
     
               </div>


            </div>





<?php



require "inc/footer.php"; ?>











    


 