<?php

include('../config.php'); // Load meChat PHP Configurations
include("../functions.php");

# Check if the keys "id" and "starting" were passed via POST
if(isset($_POST['id']) && isset($_POST['starting']))
{
    # Call the function to get incoming old messages from a reference
    echo json_encode(meChatLogged_receiveMessage($_POST['id'], $_POST['starting'], false, false)); // Returns in JSON
}
else
{
    echo json_encode(array()); // Returns empty array in JSON
}

?>