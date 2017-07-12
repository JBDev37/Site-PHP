<?php

include('../config.php'); // Load meChat PHP Configurations
include("../functions.php");

# Check if the keys "id" and "starting" were passed via POST
if(isset($_POST['id']) && isset($_POST['starting']))
{
    # Call the function to get incoming messages
    # IMPORTANT: meChat_receiveMessage returns user information and messages. See the documentation.
    
    $lastmessage = array();
    if(count($lastmessage = meChatLogged_receiveMessage($_POST['id'], 0, true, false, 1)) != 0)
    {
        if(isset($lastmessage['messages']) && count($lastmessage['messages']) != 0)
        {
            $lastmessage = $lastmessage['messages'][0]['message'];
        }
    }
    
    echo json_encode(array(      
        'user_messages' => meChatLogged_receiveMessage($_POST['id'], $_POST['starting']), // Get incoming messages from a reference 
        'lastmessage' => $lastmessage // Get the latest message 
        )
    ); // Returns in JSON
}
else
{
    echo json_encode(array()); // Returns empty array in JSON
}

?>