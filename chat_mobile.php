<?php require_once "inc/functions.php"; ?>
<?php  require "inc/header.php";


if(!isset($_SESSION['auth'])): ?>

        <?php  require "side-bar.php"; ?>
        <?php  require "side-bar-right.php"; ?>
    <div class="container-messages" >
        <div class="connexion-obligatoire">
        <legend >Messagerie</legend> 
            Vous devez être inscrit et connecté <a href="register.php" class="inscription btn btn-primary" role="button" >S'inscrire</a>
        </div>
    </div>
    <?php else:




if(isset($_GET['id_send'])){
    $user_send = $_GET['id_send'];
    $name_user_chat = User::user_name($db, $user_send);
    $bloquer = User::is_user_bloque_chat($db, $my_id ,$user_send);
        if($bloquer == false){
        /*Chat::update_contact_chat($db, $my_id); */  
        Chat::add_contact($db, $my_id, $user_send);
        Chat::message_lu($db, $my_id, $user_send);
        }
        else{

            $last_user=Chat::last_id_contact($db, $my_id ,$my_id);
            header('Location: chat.php?user=$last_user');}

    }else if(isset($_GET['user'])){
        $user_send = $_GET['user'];
        $name_user_chat = User::user_name($db, $user_send);
        $bloquer = User::is_user_bloque_chat($db, $my_id ,$user_send);
            if($bloquer == false){
            /*Chat::update_contact_chat($db, $my_id);*/    
            Chat::add_contact($db, $my_id, $user_send);
            Chat::message_lu($db, $my_id, $user_send);
            }else{
              $last_user=Chat::last_id_contact($db, $my_id ,$my_id);
              header('Location: chat.php?user=$last_user');}

    }else {
        /*Chat::update_contact_chat($db, $my_id);*/
        $last_user=Chat::last_id_contact($db, $my_id ,$my_id);
        header('Location: chat.php?user='.$last_user);
        }
    ?>



<?php $my_id = $_SESSION['auth']->ID;




$recherche_contact = $pdo->prepare('SELECT id, from_id, to_id, last_message, date_ FROM contact_chat WHERE from_id = ? OR to_id = ? ORDER BY date_
DESC');
$recherche_contact->execute([$my_id, $my_id]);


?>
    
    <script src="https://use.fontawesome.com/45e03a14ce.js"></script>


<div class="container_chat">
    <div class="col-sm-3 chat_sidebar_mobile">
        <div class="row1">
            <!--<div id="custom-search-input">
                <div class="input-group col-md-12">
                    <input type="text" class="  search-query form-control" placeholder="Conversation" />
                    <button class="btn btn-danger" type="button">
                        <span class=" glyphicon glyphicon-search"></span>
                    </button>
                </div>
            </div>-->
            <div class="dropdown_mobile all_conversation">
                <div class="conversation" onclick="conversation();" >
                     Conversations
                </div>
                <div class="user_bloque" onclick="bloque();" >
                     Bloquer
                </div>
                <!--<ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                    <li><a href="#"> Toutes les conversations </a>  <ul class="sub_menu_ list-unstyled">
                            <li><a href="#"> All Conversation </a> </li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li><a href="#">Separated link</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li><a href="#">Separated link</a></li>
                </ul>-->
            </div>




            <div class="member_list_mobile ">
                <ul class="list-unstyled">

                 
                      
                <div id="conversation" >
                    <?php $test=0;
                    while($affiche_contact = $recherche_contact->fetch()):
                    $date = $affiche_contact->date_;
                    $parse = date_parse($date);
                    $annee = $parse["year"];
                    $mois = $parse["month"];
                    $jour = $parse["day"];
                    $heure = $parse["hour"];
                    $minute = $parse["minute"];
                    $user_id = $affiche_contact->to_id;
                    $from_id = $affiche_contact->from_id;
                    if($user_id==$my_id){$user_id = $affiche_contact->from_id;}
                    $name_user = User::user_name($db, $user_id);
                    $last_message = $affiche_contact->last_message;
                    if($mois <10){$mois = "0".$mois;}
                    if($minute <10){$minute = "0".$minute;}
                    if($jour <10){$jour = "0".$jour;} 
                    ?>
                    <?php $test=$test + 1; if($test==1){ $user_first = $user_id;  }; ?>
                    <?php
                    $user_online = User::user_online($db, $user_id);
                    $non_lu = Chat::message_non_lu($db,$user_id,$my_id); // si message non lu alors background orange
                    if($non_lu == true){?>

                         <?php echo "<a href=\"chat.php?user=$user_id\">" ?>
                         <li class="left clearfix not_read">
                         <span class="">
                              <?php if($user_online == true){
                                echo "<img class=\"online_chat\" src=\"img/Point_vert.gif\">"; } ?>
                         </span>
                            <div class="chat-body clearfix">
                                <div class="header_sec">
                                    <strong class="primary-font"><?php echo $name_user;?></strong> <div class="pull-right">
                                        <?php echo $jour.'/'.$mois.'/'.$annee.' '.$heure.':'.$minute; ?></div>
                                </div>
                                <div class="contact_sec">
                                    <div class="primary-font"><?php echo substr($last_message, 0,60); ?></div> <!--<span class="badge pull-right">3</span>-->
                                </div>
                            </div>
                        </li><?php echo "</a>"; ?>

                    <?php } else { 

                        if($user_id==$user_send){// message actif
                              echo "<a href=\"chat.php?user=$user_id\">" ?>
                                    <li class="left clearfix actif">
                                      <span class="">
                                          
                                     </span>
                                        <div class="chat-body clearfix">
                                            <div class="header_sec">
                                                <strong class="primary-font"><?php echo $name_user;?></strong> <div class="pull-right actif">
                                                    <?php echo $jour.'/'.$mois.'/'.$annee.' '.$heure.':'.$minute; ?></div>
                                            </div>
                                            <div class="contact_sec">
                                                <div class="primary-font"><?php echo substr($last_message, 0,60); ?></div> <!--<span class="badge pull-right">3</span>-->
                                            </div>
                                        </div>
                                    </li><?php echo "</a>"; 
                             }else{
                                    echo "<a href=\"chat.php?user=$user_id\">" ?>
                                    <li class="left clearfix ">
                                     <span class="">
                                          <?php if($user_online == true){
                                            echo "<img class=\"online_chat\" src=\"img/Point_vert.gif\">"; } ?>
                                     </span>
                                        <div class="chat-body clearfix">
                                            <div class="header_sec">
                                                <strong class="primary-font"><?php echo $name_user;?></strong> <div class="pull-right">
                                                    <?php echo $jour.'/'.$mois.'/'.$annee.' '.$heure.':'.$minute; ?></div>
                                            </div>
                                            <div class="contact_sec">
                                                <div class="primary-font"><?php echo substr($last_message, 0,60); ?></div> <!--<span class="badge pull-right">3</span>-->
                                            </div>
                                        </div>
                                    </li><?php echo "</a>"; ?>

                                   <?php }
                               }

                     endwhile; ?>
                </div>
     
     <div id="contact_bloquer">
        <?php
        $recherche_contact_bloque = $pdo->prepare('SELECT * FROM bloquer_contact_chat WHERE from_ = ? ORDER BY date_ DESC');
        $recherche_contact_bloque->execute([$my_id]);
        $recherche_contact_bloque1 = $pdo->prepare('SELECT * FROM bloquer_contact_chat WHERE from_ = ? ORDER BY date_ DESC');
        $recherche_contact_bloque1->execute([$my_id]);
        $affiche_contact_bloque = $recherche_contact_bloque->fetch();

         if($affiche_contact_bloque == false) { ?>
            <li class="left clearfix none">
                            <div class="chat-body clearfix">
                                <div class="header_sec">
                                    <?php echo  " Pas de contact bloqué"; ?>
        
                                </div>
                                <div class="contact_sec">
                                </div>
                               </div>
                        </li>
               <?php } 

        while($affiche_contact_bloque1 = $recherche_contact_bloque1->fetch()):
                        $user_id = $affiche_contact_bloque1->to_;
                        $name_user = User::user_name($db, $user_id);
                        $date = $affiche_contact_bloque1->date_;
                        $parse = date_parse($date);
                        $annee = $parse["year"];
                        $mois = $parse["month"];
                        $jour = $parse["day"];
                        $heure = $parse["hour"];
                        $minute = $parse["minute"];
                        if($mois <10){$mois = "0".$mois;}
                        if($minute <10){$minute = "0".$minute;}
                        if($jour <10){$jour = "0".$jour;} 

                       

                         
                         ?><li class="left clearfix none">
                         <span class="">
                              <?php if($user_online == true){
                                echo "<img class=\"online_chat\" src=\"img/Point_vert.gif\">"; } ?>
                         </span>
                            <div class="chat-body clearfix">
                                <div class="header_sec">
                                    <strong class="primary-font"><?php echo $name_user;?></strong> <div class="pull-right">
                                     
                                    <?php echo  "<form class=\"debloqu\" id=\"debloc\" enctype=\"multipart/form-data\"  method=\"POST\" >"; ?>
                                     <?php echo "<input type=\"submit\" name=\"$user_id\" value=\"Débloquer\" id=\"author_id\" class=\" btn btn-primary  btn-xs debloquer\"> ";?>
                                     <?php echo "</form> ";?>

                                        
                                </div>
                                <div class="contact_sec">
                                    <?php echo "Bloqué le " .$jour.'/'.$mois.'/'.$annee ?></div>
                                </div>
   
                            </div>
                        </li>

                    <?php
                    if (isset($_POST[$user_id])){
                        User::debloque_chat($db, $my_id ,$user_id);
                        header('Location: chat.php');
                        }


                    ?>

        <?php  endwhile; ?>
    </div>


     </ul>



            </div>
        </div>
    </div>
    <!--chat_sidebar-->


    <div class="col-sm-9 message_section">
        <div class="row">
            <div class="new_message_head">
                <div class="pull-left">
                <?php $user_connect = User::user_online($db, $user_send); ?>
                <?php if(isset($name_user_chat)){echo "Conversation avec ";} if(isset($name_user_chat)) {echo $name_user_chat;} ?>
                <?php if($user_connect == true && $user_send != $my_id){
                        echo "<span class=\"connect\">connecté</span>";
                     }else if($user_connect == false && $user_send != $my_id){
                        echo "<span class=\"disconnect\">hors connexion</span>";
                        } ?> 
                </div>
                <div class="pull-right">
                    <!--<div class="dropdown">
                        <button class="dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-cogs" aria-hidden="true"></i>  Action
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
                            <li><a href="#">Signaler</a></li>
                            <li><a href="#">Bloquer</a></li>
                            
                        </ul>
                    </div>-->
                    <form method="POST">
                        <?php $aleatoire = $user_id+2;
                               echo "<input type=\"submit\"  name=\"$aleatoire\" value='Bloquer' id=\"aleatoire\" class=\" bloquer_chat btn btn-sm btn-danger\">";
                         ?>

                    </form>
                </div>
 
<?php if(isset($_POST[$aleatoire])){ // on bloque un utilisateur
    User::bloquer_contact_chat($db, $my_id ,$user_send);
    header('Location: chat.php');
    }                
 ?>           </div><!--new_message_head-->

    <section id="chat">

            <div class="chat_area" id="msgbox">

                    <div id="messages"></div>


            </div><!--chat_area--></div>
            <div class="message_write_mobile">
                <form class="send_message_mobile" action="" id="send_message">

                <textarea id="m" class=" valider_chat_mobile" required autocomplete="on" onclick="out()"/></textarea>
                
               

                    
                <button class="btn btn-primary btn-success button_chat_mobile" ><img src="img/send.png"></button>
                </form>


            
        </div>
    </div> <!--message_section-->
    </section>

</div>

<!--     ------------------------------------------------------------ -->

<script> var my_id =  <?=$my_id?>;
         var user_send =  <?=$user_send?>;
    var id1 =  my_id+user_send+1;
</script>


<?php require_once "emoticones.php"; ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!--<script src="http://localhost:3000/socket.io/socket.io.js"></script>-->
<!--<script src="socket.io/socket.io.js"></script>-->
<script src="chat/node_modules/socket.io-client/dist/socket.io.js"></script>
<script>
    var socket = io.connect("https://kurbys.com:3001");
   /*var socket = io.connect('http://localhost:3000');*/
/*WEB_SOCKET_SWF_LOCATION = "/var/www/html/node_modules/socket.io/WebSocketMain.swf";*/

    function scrollToBottom() {
    $('#msgbox').animate({ scrollTop: $('#msgbox').prop('scrollHeight') },0);
    }
//$('#msgbox').animate({ scrollTop: $(document).height() }, 0);

    function startTchat(user_id, user_send){

        socket.emit('login', {
            user_id: user_id,
            user_send: user_send,


        });

    }
    startTchat(my_id,user_send );

    socket.on('error', function(err){
        alert(err);

    })



    function sendMessage(user_id, user_send) {
 
            $('#send_message').submit(function(e) {
                        e.preventDefault();
                        var msg = $('#m').val();

                        socket.emit('join', {
                        msg: msg,
                        user_id: user_id,
                        user_send: user_send



                        });
                        $('#m').val('');
                        $('#chat input').focus();
           });
   

    }
   sendMessage(my_id,user_send);



//on affiche les messages
    socket.on('chat-message', function (data) {
        var msg = data.msg;
        var user1 = data.user;
        var user_send1 = data.user_send;
        var date = data.date;
        
        /* on affiche la date en francais*/
         var jours = new Array("dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi");
         var mois = new Array("janvier", "fevrier", "mars", "avril", "mai", "juin", "juillet", "aout", "septembre", "octobre", "novembre", "decembre");
         // on recupere la date
         var date = new Date(date);
         // on construit le message
         /*affiche_date = jours[date.getDay()] + " ";   // nom du jour*/
         var affiche_date = date.getDate(date) + " ";   // numero du jour
         affiche_date += mois[date.getMonth()] + " ";   // mois
         affiche_date += date.getFullYear();

         var heure = date.getHours();
         var minutes = date.getMinutes();
         if(minutes < 10){
              minutes = "0" + minutes;
         }
 

        var emoji = emojione.shortnameToImage(msg);// on affiche les emoticones
        var message = emoji.replace(/\\/g, " ");

      if ( my_id == user1 && user_send == user_send1)    {
            $('#messages').append('</br><div class="message_droite_date">' + '<strong>' + affiche_date + '</strong>' +" " +heure + "h" + minutes+ '</div>');
            $('#messages').append('</br><div class="message_droite">' + message +'</div></br></br></br>');
            
        scrollToBottom();
                       }

    if (my_id == user_send1 && user_send == user1 )    {
        $('#messages').append('</br><div class="message_gauche_date">' + '<strong>' + affiche_date + '</strong>' +" " +heure + "h" + minutes+ '</div>');
        $('#messages').append('</br><div class="message_gauche" style="display: block; ">' + message+'</div></br></br></br>');
        scrollToBottom();
    }
    });

socket.on(id1, function (data) {
            var msg = data.msg;
            var user1 = data.user_id;
            var user_send1 = data.user_send;
            var user=data.id1;
            var emoji = emojione.shortnameToImage(msg);// on affiche les emoticones
            var message = emoji.replace(/\\/g, " ");

if(user1==my_id){

    $('#messages').append('<div class="message_droite" >'+ message+'</div></br></br></br>');
    scrollToBottom();
}else{
    $('#messages').append('<div class="message_gauche" >' + message +'</div></br></br></br>');
    scrollToBottom();
}


    });



</script>

<script type="text/javascript">
    function bloque(){
        document.getElementById('contact_bloquer').style.display="block";
        document.getElementById('conversation').style.display="none";
    }

    function conversation(){
        document.getElementById('conversation').style.display="block";
        document.getElementById('contact_bloquer').style.display="none";
    }

</script>



<?php endif; ?>
<?php require "inc/footer.php";  ?>