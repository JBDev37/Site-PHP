<?php

include('../config.php'); // Load meChat PHP Configurations
include("../functions.php");

# Check if the keys "id" and "file" were passed via POST
if(isset($_POST['to']) && isset($_FILES['file']))
{
    # Logged
    if(meChatLogged() != false)
    {        
        $imageName = md5(uniqid(rand(), true)).$me_chat_config['me_chat_imageupload']['extension']; // Generate a new name for the file
        $sourcePath = $_FILES['file']['tmp_name']; // Get the file in the temporary directory
        $targetPath = $_SERVER['DOCUMENT_ROOT'] . $me_chat_config['me_chat_imageupload']['path'] . $imageName; // Folder to which the file will be copied
        
        if((filesize($sourcePath) / 1048576) > $me_chat_config['me_chat_imageupload']['maxsize'] && $me_chat_config['me_chat_imageupload']['maxsize'] != 0)
        {
            echo json_encode(array('success' => false, 'message' => $me_chat_config['me_chat_imageupload']['message_maxsize'])); // Maximum image size
            unlink($sourcePath); // Delete file
        }
        else
        {
            if(strpos(mime_content_type($sourcePath), 'image') > -1) // Is a valid image
            {
                if(@move_uploaded_file($sourcePath, $targetPath) != false) // Move file
                {
                    # Call the function to send message
                    if(json_encode(meChat_sendMessage(meChatLogged(), $_POST['to'], '[img]' . $me_chat_config['me_chat_imageupload']['path'] . $imageName.'[/img]')) != false)
                    {
                        echo json_encode(array('success' => true, 'message' => $me_chat_config['me_chat_imageupload']['message_success'])); // Success
                    }
                    else // If the message is not sent
                    {
                        echo json_encode(array('success' => false, 'message' => $me_chat_config['me_chat_imageupload']['message_failed'])); // Failure
                    }
                }
                else // If unsuccessful to move
                {
                    echo json_encode(array('success' => false, 'message' => $me_chat_config['me_chat_imageupload']['message_failed'])); // Failure
                } 
            }
            else
            {
                echo json_encode(array('success' => false, 'message' => $me_chat_config['me_chat_imageupload']['message_invalid'])); // Invalid image
            }
        }
    }
    else
    {
        echo json_encode(array('success' => false, 'message' => $me_chat_config['me_chat_imageupload']['message_notlogged'])); // Not logged in
    }
}
else
{
   echo json_encode(array('success' => false, 'message' => $me_chat_config['me_chat_imageupload']['message_failed'])); // Failure
}



?>