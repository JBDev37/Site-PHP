<?php

/*
    LOAD MANAGER CONFIGURATION FILE "mechat/manager/config.json"
*/
$me_chat_manager_config = json_decode(file_get_contents(implode('/',array_slice(explode('/', dirname(str_replace('\\', '/', __FILE__))),0,count(explode('/',dirname(str_replace('\\', '/', __FILE__))))-1)).'/config.json'), true);

/*
    LOAD CONFIGURATION FILE "mechat/config.json"
*/
$me_chat_config = json_decode(file_get_contents(implode('/',array_slice(explode('/', dirname(str_replace('\\', '/', __FILE__))),0,count(explode('/',dirname(str_replace('\\', '/', __FILE__))))-2)).'/config.json'), true);

?>