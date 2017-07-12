<?php

include('../config.php'); // Load meChat PHP Configurations
include("../functions.php");

# Check if the key "id" was passed via POST
if(isset($_POST['id']))
{
    # Call the function to close the chatbox
    echo json_encode(meChatLogged_closeChat($_POST['id'])); // Returns in JSON
}
else
{
    echo json_encode(array()); // Returns empty array in JSON
}

?>