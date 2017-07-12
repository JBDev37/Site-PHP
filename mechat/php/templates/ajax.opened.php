<?php

include('../config.php'); // Load meChat PHP Configurations
include("../functions.php");

# Return the opened chatboxes
echo json_encode(meChatLogged_openedChat()); // Returns in JSON

?>