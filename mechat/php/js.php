<?php

include('config.php'); // Load meChat PHP Configurations
include('functions.php');
header('Content-Type: application/javascript');



// Use the version of jQuery (this option is found in "mechat/config.ini")
if($me_chat_config['me_chat_settings']['load_jquery'] == true)
{
    echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . $me_chat_config['me_chat_settings']['path'] . 'js/jquery.js');
}

// Load mechat.js (found in "mechat/js/")
echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . $me_chat_config['me_chat_settings']['path'] . 'js/mechat.js');

// Use the javascript developed (found in "mechat/js/templates/")
if($me_chat_config['me_chat_settings']['load_developed'] == true)
{
    echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . $me_chat_config['me_chat_settings']['path'] . 'js/templates/developed.js');
}

// Load stylesheets
echo "
$(document).ready(function()
{";

if($me_chat_config['me_chat_settings']['load_css'] == true) // Load the stylesheets of the mechat (Asynchronous)
{
    echo "
    $('head').append( $('<link rel=\"stylesheet\" type=\"text/css\" />').attr('href', '".$me_chat_config['me_chat_settings']['path']."css/mechat.css') );";
}

if($me_chat_config['me_chat_settings']['load_developed'] == true) // Use the stylesheet developed 
{
    echo "
    $('head').append( $('<link rel=\"stylesheet\" type=\"text/css\" />').attr('href', '".$me_chat_config['me_chat_settings']['path']."css/templates/developed.css') );";
}

echo "
});
";

// Load settings
echo "
var me_chat_settingsOBJ = JSON.parse('".addslashes(json_encode($me_chat_config['me_chat_settings'], JSON_FORCE_OBJECT))."');
for (var attr in me_chat_settingsOBJ) { me_chat_settings[attr] = me_chat_settingsOBJ[attr]; }";

// Load strings
echo "
var me_chat_stringsOBJ = JSON.parse('".addslashes(json_encode($me_chat_config['me_chat_strings'], JSON_FORCE_OBJECT))."');
for (var attr in me_chat_stringsOBJ) { me_chat_strings[attr] = me_chat_stringsOBJ[attr]; }
";

?>
