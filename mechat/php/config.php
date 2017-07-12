<?php

/*
    SHOW ALL ERROR MESSAGES BY DEFAULT
*/
ini_set('error_reporting', E_ALL);
error_reporting(E_ALL);



/*
    LOAD CONFIGURATION FILE
*/
$me_chat_config = json_decode(file_get_contents(implode('/',array_slice(explode('/', dirname(str_replace('\\', '/', __FILE__))),0,count(explode('/',dirname(str_replace('\\', '/', __FILE__))))-1)).'/config.json'), true);

?>