<?php

/*
    HIDE ALL ERROR MESSAGES BY DEFAULT, FOR JSON RESPONSE (THIS CODE WORKS PROPERLY)
*/
ini_set('error_reporting', 0);
error_reporting(0);



# Include meChat functions and settings
include('../config.php');
include('../functions.php');



# Check if are logged in
if(!isset($_SESSION)) {
     session_start();
}
if(!isset($_SESSION['logged']))
{
    header('Location: login.php');
}



# Check that the keys were passed via POST
if (!(isset($_POST['table']) && isset($_POST['page']) && isset($_POST['max_results']) && isset($_POST['search'])))
{
    exit();
}



# Store variables
$table = $_POST['table']; // Store table
$page = $_POST['page']; // Page
$max_results = $_POST['max_results']; // Maximum results
$search = $_POST['search']; // Search



# Get table       
if($table == 'users')
{
    $table = meChat_ListUsers(array(
        "id" => "LIKE '" . $search . "%'",
        "identifier" => "LIKE '" . $search . "%'",
        "name" => "LIKE '" . $search . "%'",
        "picture" => "LIKE '" . $search . "%'",
        "lastupdate" => "LIKE '" . $search . "%'",
        "_separator" => "OR"
    ), $order = null, $page, $max_results);
}

if($table == 'usersconnected')
{
    $table = meChat_ListRecentUsers(5, array( // 5 minutes ago
        "id" => "LIKE '" . $search . "%'",
        "identifier" => "LIKE '" . $search . "%'",
        "name" => "LIKE '" . $search . "%'",
        "picture" => "LIKE '" . $search . "%'",
        "_separator" => "OR"
    ), $order = null, $page, $max_results);
}

if($table == 'messages')
{
    $table = meChat_ListMessages(array(
        "id" => "LIKE '" . $search . "%'",
        "from_user_id" => "LIKE '" . $search . "%'",
        "to_user_id" => "LIKE '" . $search . "%'",
        "message" => "LIKE '" . $search . "%'",
        "date_timestamp" => "LIKE '" . $search . "%'",
        "read" => "LIKE '" . $search . "%'",
        "read_timestamp" => "LIKE '" . $search . "%'",
        "_separator" => "OR"
    ), $order = null, $page, $max_results);
}    

if($table == 'conversations')
{
    $table = meChat_ListConversations(array(
        "id" => "LIKE '" . $search . "%'",
        "from_user_id" => "LIKE '" . $search . "%'",
        "to_user_id" => "LIKE '" . $search . "%'",
        "message" => "LIKE '" . $search . "%'",
        "date_timestamp" => "LIKE '" . $search . "%'",
        "read" => "LIKE '" . $search . "%'",
        "read_timestamp" => "LIKE '" . $search . "%'",
        "_separator" => "OR"
    ), $order = null, $page, $max_results);
} 

if($table == 'friendships')
{
    $table = meChat_ListFriendships(array(
        "id" => "LIKE '" . $search . "%'",
        "id_user_1" => "LIKE '" . $search . "%'",
        "id_user_2" => "LIKE '" . $search . "%'",
        "_separator" => "OR"
    ), $order = null, $page, $max_results);
}      

    

# Get table columns
$table_columns = array();
foreach($table as $key => $value)
{
    foreach($value as $key => $value)
    {
        if(array_search($key, $table_columns) === false)
        {            
            $table_columns[] = $key;
            
            if($key == 'from_user_id' || $key == 'to_user_id' || $key == 'id_user_1' || $key == 'id_user_2')
            {
                $table_columns[] = 'identifier';
            }                
        }
    }
}



# Get table rows
$table_rows = array();
foreach($table as $key => $value)
{
    $values = array();
    foreach($value as $key => $value)
    {
        if($key == 'picture')
        {
            $values[] = '<img src="' . $value . '"/>'; 
            continue;
        }
        if($key == 'from_user_id' || $key == 'to_user_id' || $key == 'id_user_1' || $key == 'id_user_2')
        {
            $values[] = $value;
            
            $identifier = meChat_Exists($value)['identifier'];
            $values[] = $identifier != false ? $identifier : 'Not found'; 
            continue;
        }        
        
        $values[] = $value;
    }
    $table_rows[] = $values;
}



# Return JSON
echo json_encode(array('columns' => $table_columns, 'rows' => $table_rows));

?>