<?php

include('../config.php'); // Load meChat PHP Configurations
include("../functions.php");

# Check if the keys "to" and "message" were passed via POST
if(isset($_POST['to']) && isset($_POST['message']))
{
    # Call the function to send message
    echo json_encode(meChat_sendMessage(meChatLogged(), $_POST['to'], $_POST['message'])); // Returns in JSON
}
else
{
    echo json_encode(array()); // Returns empty array in JSON
}

?>