<?php

/*

This page was created to show an example of how to use the meChat.

IMPORTANT: USE THE "sql_demo.sql" FOR THIS TEST

*/
include('mechat/php/config.php'); // Load meChat PHP Configurations
include('mechat/php/functions.php');

if(isset($_GET['uid']) && is_numeric($_GET['uid']))// If the GET attribute 'uid' is setted
{   
    if($_GET['uid'] == -1) // -1 to logout
    {
        meChatLogged_Logout();
    }
    else // Login with 'uid'
    {
        meChat_Login($_GET['uid']);
        header('Location: '.basename(__FILE__));
    }
}

?>
<!DOCTYPE html>
<html>
    <!-- Head tag -->
	<head>
        <!-- Prevent strange characters -->
		<meta charset="utf-8">
        <!-- The correct use of the viewport is explained in the documentation in the "Best practices" -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <!-- iOS webapp support -->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <!-- Page title -->
        <title>meChat 1.4</title>
<?php
    if(meChatLogged() !== false) // If successfully logged
    {      
        echo '<script src="mechat/php/js.php" type="text/javascript"></script>';
    }
?>
        <!-- Page style -->
		<style scoped>
			body
            {
                font-family: "Open Sans", Arial, sans-serif;               
                line-height: 1.428571429;
                color: #ffffff;
                background-color: #2c3e50;
                position: fixed;
			}
            body div.info
            {
                display: block;
                height: 2000px;
                width: 100%;
                font-weight: 500;
                font-size: 15px;  
            }
            .users
            {
                width: 310px;
                height: 240px;
                display: block;
                position: fixed;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                margin: auto;
                vertical-align: middle;
            }
            .user
            {
                height: 120px;
                width: 100px;
                display: inline-block;
                text-align: center;
                font-size: 12px;
                color: #ffffff;
            }
            .user .photo
            {
                background-size: cover;
                background-position: center;
                height: 100px;
                width: 100px;
                display: block;
            }
            .user a
            {
                color: #ffffff;
                text-decoration: none;
            }
		</style>
	</head>
    <!-- Body tag -->    
	<body>
        <!-- Basic informations of the meChat -->
        <div class="info">
            meChat 1.4 - Created by escarlate
            <br>
            Available exclusively at CodeCanyon.net
        </div>        
        
        <!-- Table with users for test -->
        <div class="users">
            <div style="text-align: center; font-size: 20px; margin-bottom: 20px;">Choose a user</div>
            <div class="user">
                <a href="<?php echo basename(__FILE__); ?>?uid=1">
                    <div class="photo" style="background-image: url(https://s3.amazonaws.com/uifaces/faces/twitter/sauro/128.jpg)"></div>
                    John C.
                </a>
            </div> 
            <div class="user">
                <a href="<?php echo basename(__FILE__); ?>?uid=2">
                    <div class="photo" style="background-image: url(https://s3.amazonaws.com/uifaces/faces/twitter/azielsilas/128.jpg)"></div>
                    Jason Darc
                </a>
            </div>
            <div class="user">
                <a href="<?php echo basename(__FILE__); ?>?uid=3">
                    <div class="photo" style="background-image: url(https://s3.amazonaws.com/uifaces/faces/twitter/ladylexy/128.jpg)"></div>
                    Joana Pereira
                </a>
            </div>
            <div class="user">
                <a href="<?php echo basename(__FILE__); ?>?uid=4">
                    <div class="photo" style="background-image: url(https://s3.amazonaws.com/uifaces/faces/twitter/spiltmilkstudio/128.jpg)"></div>
                    Lucas A.
                </a>
            </div>
            <div class="user">
                <a href="<?php echo basename(__FILE__); ?>?uid=5">
                    <div class="photo" style="background-image: url(https://s3.amazonaws.com/uifaces/faces/twitter/dannpetty/128.jpg)"></div>
                    Pablo Varas
                </a>
            </div>
            <div class="user">
                <a href="<?php echo basename(__FILE__); ?>?uid=6">
                    <div class="photo" style="background-image: url(https://s3.amazonaws.com/uifaces/faces/twitter/ok/128.jpg)"></div>
                    Lucas Oliver
                </a>
            </div>
            <div style="text-align: center; font-size: 10px; margin-top: 20px;">
                All avatars were obtained in uifaces.com/authorized
            </div>
        </div>          
	</body>
</html>