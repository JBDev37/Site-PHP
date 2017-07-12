<?php

include('../config.php'); // Load meChat PHP Configurations
include("../functions.php");

# Returns the friend list of the user
if(($array = meChatLogged_Friends()) != false)
{
    echo json_encode($array); // Returns in JSON
}
else
{
    echo json_encode(array()); // Returns empty array in JSON
}

?>