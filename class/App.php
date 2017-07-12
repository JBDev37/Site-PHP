<?php

class App{

	static $db = null;

	static function getDatabase(){
		if(!self::$db){
		self::$db = new database('teenadviissecret','localhost','root', 'root' );	
		/*self::$db = new database('teenadviissecret','teenadviissecret.mysql.db','teenadviissecret', 'TeenAdvices7' );*/
        /*self::$db = new database('kurbys','127.0.0.1','root', '*Kurbys7*' );*/
	 }
	 return self::$db;
	}

	static function getAuth(){
		return new Auth(session::getInstance(), ['restriction_msg' => "Vous n'avez pas le droit d'accéder à cette page"]);
	}

	static function redirect($page){
		header("Location: $page");
            exit();
	}


}