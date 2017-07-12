<?php
session_start();
setcookie('remember', NUL, time() - (3600 * 24 * 30), '/' ,'kurbys.com', true, true);
unset($_SESSION['auth']);
$_SESSION['flash']['success'] = 'Vous êtes bien déconnecté';
header('Location: index.php');

?>