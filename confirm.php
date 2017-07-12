<?php

require_once "inc/bootstrap.php";
$db = App::getDatabase();


if(App::getAuth()->confirm($db, $_GET['ID'], $_GET['token'], session::getInstance())){
	session::getInstance()->setFlash('success', "votre compte à été validé");
	App::redirect('welcome.php');
}else{
	session::getInstance()->setFlash('danger', "Ce token n'est plus valide");
	App::redirect('index.php');
}

