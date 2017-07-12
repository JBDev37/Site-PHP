<?php

/*
    HIDE ALL ERROR MESSAGES BY DEFAULT, FOR JSON RESPONSE (THIS CODE WORKS PROPERLY)
*/
ini_set('error_reporting', 0);
error_reporting(0);



# Check if are logged in
if(!isset($_SESSION)) {
     session_start();
}
if(!isset($_SESSION['logged']))
{
    header('Location: login.php');
}



# Check that the keys were passed via POST
if (!isset($_POST))
{
    exit();
}



# Load configuration file
$me_chat_config = file_get_contents(implode('\\',array_slice(explode('\\', dirname(__FILE__)),0,count(explode('\\',dirname(__FILE__)))-3)).'\config.json');
if($me_chat_config == false)
{
    echo json_encode(array('return' => 'Could not find the configuration file "mechat/config.json".', 'success' => false));
    exit();
}
else
{
    $me_chat_config = json_decode($me_chat_config, true);
}



# Returns the variable with real type.
function realval($variable)
{
    # bool true
    if($variable == "true")
    {
        return true;
    }
    
    # bool false
    if($variable == "false")
    {
        return false;
    }  
    
    # int
    if(is_numeric($variable))
    {
        settype($variable, 'integer');
        return $variable;       
    }
    return $variable;
}



# Change configs
foreach($_POST as $key => $value)
{
    if(strpos($key, 'me_chat_settings') > -1)
    {
        $me_chat_config['me_chat_settings'][explode(':', $key)[1]] = realval($value);
    }
    
    if(strpos($key, 'me_chat_strings') > -1)
    {
        $me_chat_config['me_chat_strings'][explode(':', $key)[1]] = realval($value);
    }    
    
    if(strpos($key, 'me_chat_imageupload') > -1)
    {
        $me_chat_config['me_chat_imageupload'][explode(':', $key)[1]] = realval($value);
    }    
}



# Save configs
if(file_put_contents(implode('\\',array_slice(explode('\\', dirname(__FILE__)),0,count(explode('\\',dirname(__FILE__)))-3)).'\config.json', json_encode($me_chat_config)) !== false)
{
    echo json_encode(array('return' => 'Successfully saved configs!', 'success' => true));   
}
else
{
    echo json_encode(array('return' => 'Could not overwrite the configuration file "mechat/config.json".', 'success' => false));
}

?>