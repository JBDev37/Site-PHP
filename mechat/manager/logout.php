<?php

include('php/config.php');

if(!isset($_SESSION))
{
     session_start();
}

if(isset($_SESSION['logged']))
{
    if($_SESSION['logged'] == true)
    {
        unset($_SESSION['logged']);
        session_destroy();
        header('Location: login.php');
    }
}

?>