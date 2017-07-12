<?php
/*try
{
       $pdo = new PDO('mysql:dbname:lesecretkpmp;host=localhost' , 'root' , 'root');
}
catch (Exception $e)
{
       die('Erreur : ' . $e->getMessage());
}*/

/*$pdo = new PDO('mysql:dbname=kurbys;host=127.0.0.1' , 'root' , '*Kurbys7*', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));*/

$pdo = new PDO('mysql:dbname=teenadviissecret;host=localhost' , 'root' , 'root', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

/*$pdo = new PDO('mysql:dbname=teenadviissecret;host=teenadviissecret.mysql.db' , 'teenadviissecret' , 'TeenAdvices7', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
/*var_dump($pdo);*/

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); /* on affiche les erreurs */

$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); /* recupere sous forme d'objet*/ 

?>