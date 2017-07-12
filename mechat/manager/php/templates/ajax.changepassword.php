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
if (!(isset($_POST['me_chat_manager_config:password']) && isset($_POST['me_chat_manager_config:newpassword']) && isset($_POST['me_chat_manager_config:confirmpassword'])))
{
    exit();
}



# Load configuration file
$me_chat_manager_config = file_get_contents(implode('\\',array_slice(explode('\\', dirname(__FILE__)),0,count(explode('\\',dirname(__FILE__)))-2)).'\config.json');
if($me_chat_manager_config == false)
{
    echo json_encode(array('return' => 'Could not find the configuration file "mechat/manager/config.json".', 'success' => false));
    exit();
}
else
{
    $me_chat_manager_config = json_decode($me_chat_manager_config, true);
}



# Change configs
if($me_chat_manager_config['password'] === md5($_POST['me_chat_manager_config:password']))
{
    if(!empty($_POST['me_chat_manager_config:newpassword']))
    {
        if($_POST['me_chat_manager_config:newpassword'] === $_POST['me_chat_manager_config:confirmpassword'])
        {
            $me_chat_manager_config['password'] = md5($_POST['me_chat_manager_config:newpassword']);
            
            echo json_encode(array('return' => 'Password changed successfully!', 'success' => true)); 
        }
        else
        {
            echo json_encode(array('return' => 'The passwords not match.', 'success' => false)); 
            exit();
        }
    }
    else
    {
        echo json_encode(array('return' => 'Enter a new password.', 'success' => false));   
        exit();
    }
}
else
{
    echo json_encode(array('return' => 'The current password is invalid.', 'success' => false));
    exit();
}



# Save configs
if((file_put_contents(implode('\\',array_slice(explode('\\', dirname(__FILE__)),0,count(explode('\\',dirname(__FILE__)))-2)).'\config.json', json_encode($me_chat_manager_config))) == false)
{
    echo json_encode(array('return' => 'Could not overwrite the configuration file "mechat/manager/config.json".', 'success' => false));
}

?>