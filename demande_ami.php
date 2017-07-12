<?php
//execute le script de ma page messages.php
require "inc/header.php";
extract($_POST);
Friends::friends_request($db,$my_id, $author_id);
?>