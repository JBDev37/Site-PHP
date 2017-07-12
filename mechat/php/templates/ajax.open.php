<?php

include('../config.php'); // Load meChat PHP Configurations
include("../functions.php");

# Check if the key "id" was passed via POST
if(isset($_POST['id']))
{
    # Call the function to open a chatbox
    echo json_encode(meChatLogged_openChat($_POST['id']));  // Returns in JSON
}

?>