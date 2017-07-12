<?php

include('../config.php'); // Load meChat PHP Configurations
include("../functions.php");

# Returns the recent messages with five minutes ago
echo json_encode(meChatLogged_recentlyMessages(5)); // Returns in JSON

?>