<?php
/*

    meChat 1.4 (08/09/2016)
    Created by Jhonatan Henrique (escarlate)
    Available exclusively at CodeCanyon.net

*/

if (session_id() == '')
{
    session_start();
}

/* 

DATABASE CONNECTION

*/
$mechat_db = new PDO('mysql:dbname=teenadviissecret;host=teenadviissecret.mysql.db' , 'teenadviissecret' , 'TeenAdvices7', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
/*$mechat_db = new PDO('mysql:dbname=teenadviissecret;host=localhost' , 'root' , 'root', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));*/

/*$mechat_db = new PDO("mysql:host=" . $me_chat_config['me_chat_database']['host'] . "; dbname=" . $me_chat_config['me_chat_database']['database'] . "",$me_chat_config['me_chat_database']['user'], $me_chat_config['me_chat_database']['password']);*/
$mechat_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);



/*

FUNCTION: meChat_Add($identifier, $name, $picture)
DESCRIPTION: Add a user to the database
ARGUMENTS:
    $identifier - user identifier
    $name - user name
    $picture - user photo
    
*/
function meChat_Add($identifier, $name, $picture)
{
    global $mechat_db; // Call global variable
    
    # Query to check that the user with the $identifier exists
    $query = "SELECT * FROM `users` WHERE `identifier` = :identifier;";
    $stmt  = $mechat_db->prepare($query);
    
    # Bind parameters
    $stmt->bindParam(':identifier', $identifier, PDO::PARAM_STR);
    
    # Check there has been success in the execution of the query
    if ($stmt->execute())
    {
        if (count($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) > 0)
        {
            return $result[0]['id']; //Returns the user ID with the same $identifier
        }
        
        # Query to add the user
        $query = "INSERT INTO `users` (`id`, `identifier`, `name`, `picture`) VALUES (NULL, :identifier, :name, :picture);";
        $stmt  = $mechat_db->prepare($query);
        
        # Bind parameters
        $stmt->bindParam(':identifier', $identifier, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':picture', $picture, PDO::PARAM_STR);

        if (!$stmt->execute())
        {
            return false; // Returns false if the query is not executed successfully 
        }
        return $mechat_db->lastInsertId('id'); // Returns the user id if the query is successful
    }
    return false; // Returns false if the query is not executed successfully
}



/*

FUNCTION: meChat_Remove($chatID)
DESCRIPTION: Remove user of the database
ARGUMENTS:
    $chatID - user id
    
*/
function meChat_Remove($chatID)
{
    global $mechat_db; // Call global variable
    
    # Query to remove user
    $query = "DELETE FROM `users` WHERE `id` = :id;";
    $stmt  = $mechat_db->prepare($query);
        
    # Bind parameters
    $stmt->bindParam(':id', $chatID, PDO::PARAM_INT);
        
    if (!$stmt->execute())
    {
        return false; // Returns false if the query is not executed successfully 
    }
    return true;
}



/*

FUNCTION: meChat_Exists($chatID)
DESCRIPTION: Checks if the user is registered in the database
ARGUMENTS:
    $chatID - user id
    
*/
function meChat_Exists($chatID)
{
    global $mechat_db; // Call global variable
    
    # Query to check that the user with the $chatID exists
    $query = "SELECT * FROM `wp_cendrillon_6239_users` WHERE `ID` = :id;";
    $stmt  = $mechat_db->prepare($query);
    
    # Bind parameters
    $stmt->bindParam(':id', $chatID, PDO::PARAM_INT);
    
    # Check if the query was executed successfully and the number of results is greater than zero
    if ($stmt->execute() && count($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) > 0)
    {
        return $result[0]; // Returns the user data array
    }
    return false; // Returns false if the user does not exist   
}



/*

FUNCTION: meChat_AddFriend($chatID, $chatID2)
DESCRIPTION: Add friend to the user
ARGUMENTS:
    $chatID - user id
    $chatID2 - friend id
    
*/
function meChat_AddFriend($chatID, $chatID2)
{
    global $mechat_db; // Call global variable
    
    # Query to check that the users with the $chatID and $chatID2 exist
    $query = "SELECT * FROM `users` WHERE (`id` = :id) OR (`id` = :id2);";
    $stmt  = $mechat_db->prepare($query);
    
    # Bind parameters
    $stmt->bindParam(':id', $chatID, PDO::PARAM_INT);
    $stmt->bindParam(':id2', $chatID2, PDO::PARAM_INT);
    
    # Insert user friend if the query is executed successfully and the number of results is equal to two
    if ($stmt->execute() && count($stmt->fetchAll(PDO::FETCH_ASSOC)) == 2) {
        # Query to check if there is already friendship
        $query = "SELECT * FROM `friendships` WHERE (`id_user_1` = :id AND `id_user_2` = :id2) OR (`id_user_1` = :id2 AND `id_user_2` = :id);";
        $stmt  = $mechat_db->prepare($query);
        
        # Bind parameters
        $stmt->bindParam(':id', $chatID, PDO::PARAM_INT);
        $stmt->bindParam(':id2', $chatID2, PDO::PARAM_INT);
        
        if (!$stmt->execute())
        {
            return false; // Returns false if the query is not executed successfully
        }
        
        if (count($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) > 0)
        {
            return true; // Returns true if they are friends
        } else {
            
            # Are not friends
            # Query to add friend
            $query = "INSERT INTO `friendships` (`id`, `id_user_1`, `id_user_2`) VALUES (NULL, :id, :id2);";
            
            $stmt = $mechat_db->prepare($query);
            
            $stmt->bindParam(':id', $chatID, PDO::PARAM_INT);
            $stmt->bindParam(':id2', $chatID2, PDO::PARAM_INT);

            if (!$stmt->execute())
                return false; // Returns false if the query is not executed successfully
            return true; // Returns true if the query is executed successfully            
        }
    }
    return false; // Returns false if the query is not executed successfully 
}



/*

FUNCTION: meChat_RemoveFriend($chatID, $chatID2)
DESCRIPTION: Remove friend from the user
ARGUMENTS:
    $chatID - user id
    $chatID2 - friend id
    
*/
function meChat_RemoveFriend($chatID, $chatID2)
{
    global $mechat_db; // Call global variable
    
    # Query to delete the friendship
    $query = "DELETE FROM `friendships` WHERE (`id_user_1` = :id AND `id_user_2` = :id2) OR (`id_user_1` = :id2 AND `id_user_2` = :id);";
        
    $stmt = $mechat_db->prepare($query);
        
    $stmt->bindParam(':id', $chatID, PDO::PARAM_INT);
    $stmt->bindParam(':id2', $chatID2, PDO::PARAM_INT);
        
    if (!$stmt->execute())
         return false; // Returns false if the query is not executed successfully
    return true; // Returns true if the query is executed successfully  
}



/*

FUNCTION: meChat_Friendship($chatID, $chatID2)
DESCRIPTION: Check friendship
ARGUMENTS:
    $chatID - user id
    $chatID2 - friend id
    
*/
function meChat_Friendship($chatID, $chatID2)
{
    global $mechat_db; // Call global variable
    
    # Query to check friendship
    $query = "SELECT * FROM `friendships` WHERE (`id_user_1` = :id AND `id_user_2` = :id2) OR (`id_user_1` = :id2 AND `id_user_2` = :id);";
    $stmt  = $mechat_db->prepare($query);
    
    # Bind parameters
    $stmt->bindParam(':id', $chatID, PDO::PARAM_INT);
    $stmt->bindParam(':id2', $chatID2, PDO::PARAM_INT);
    
    if ($stmt->execute())
    {
        if (count($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) == 0)
        {
            return false; // Returns false if they are not friends
        }
        else 
        {
            return true; // Returns true if they are friends 
        }
    }
    return false; // Returns false if the query is not executed successfully
}



/*

FUNCTION: meChat_Identifier($identifier)
DESCRIPTION: Get user id
ARGUMENTS:
    $identifier
    
*/
function meChat_Identifier($identifier)
{
    global $mechat_db; // Call global variable
    
    # Query to check that the user with the $chatID exists
    $query = "SELECT * FROM `users` WHERE `identifier` = :identifier;";
    $stmt  = $mechat_db->prepare($query);
    
    # Bind parameters
    $stmt->bindParam(':identifier', $identifier, PDO::PARAM_STR);
    
    # Check if the query was executed successfully and the number of results is greater than zero
    if ($stmt->execute() && count($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) > 0)
    {
        return $result[0]['id']; // Returns the user id 
    }
    return false; // Returns false if the user does not exist   
}



/*

FUNCTION: meChat_Login($chatID)
DESCRIPTION: Login
ARGUMENTS:
    $chatID - user id
    
*/
function meChat_Login($chatID)
{
    global $mechat_db; // Call global variable
    
    # Query to check that the user with the $chatID exists
    $query = "SELECT * FROM `wp_cendrillon_6239_users` WHERE `ID` = :id;";
    $stmt  = $mechat_db->prepare($query);
    
    # Bind parameters
    $stmt->bindParam(':id', $chatID, PDO::PARAM_INT);
    
    # Check if the query was executed successfully and the number of results is greater than zero
    if ($stmt->execute() && count($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) > 0) {
        
        $_SESSION['meChat_logged']    = true;
        $_SESSION['meChat_id']        = $result[0]['ID'];
        $_SESSION['meChat_data']      = $result[0];
        $_SESSION['meChat_chatboxes'] = array();
        return true; // Returns true if logged
    }
    return false; // Returns false if the user does not exist    
}



/*

FUNCTION: meChatLogged_Logout()
DESCRIPTION: Logout
ARGUMENTS:
    none
    
*/
function meChatLogged_Logout()
{
    if (isset($_SESSION['meChat_logged']) && $_SESSION['meChat_logged'] == true) {
        
        unset($_SESSION['meChat_logged']);
        unset($_SESSION['meChat_id']);
        unset($_SESSION['meChat_data']);
        unset($_SESSION['meChat_chatboxes']);
        return true; // Returns true if the session was destroyed
    }
    return false; // Returns false if not logged
}


/*

FUNCTION: meChatLogged()
DESCRIPTION: Checks if the user is logged
ARGUMENTS:
    none
    
*/
function meChatLogged()
{    
    global $mechat_db;
        
    if (isset($_SESSION['meChat_logged']) && $_SESSION['meChat_logged'] == true) {
        
        # Query to save the last update of the user
        $query = "UPDATE `wp_cendrillon_6239_users` SET `lastupdate`= :timestamp WHERE (`ID` = :me);";
        $stmt  = $mechat_db->prepare($query);

        # Bind parameters
        $timestamp = gmdate('U');
        $stmt->bindParam(':me', $_SESSION['meChat_id'], PDO::PARAM_INT);
        $stmt->bindParam(':timestamp', $timestamp, PDO::PARAM_INT);

        $stmt->execute(); // Executes the query      
        
        return $_SESSION['meChat_id']; // Returns the user id if are logged
    }
    return false; // Returns false if are not logged
}



/*

FUNCTION: meChat_Update($chatID, $property, $value)
DESCRIPTION: Update user property
ARGUMENTS:
    $chatID - user id
    $property - user property
    $value - value to be assigned
    
*/
function meChat_Update($chatID, $property, $value)
{    
    global $mechat_db;
        
    # Query to check that the user with the $chatID exists
    $query = "SELECT * FROM `wp_cendrillon_6239_users` WHERE `ID` = :id;";
    $stmt  = $mechat_db->prepare($query);
    
    # Bind parameters
    $stmt->bindParam(':id', $chatID, PDO::PARAM_INT);
    
    # Check if the query was executed successfully and the number of results is greater than zero
    if ($stmt->execute() && count($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) > 0) {
        
        # Query to update the user info
        $query = "UPDATE `usewp_cendrillon_6239_users` SET `".$property."`= :value WHERE (`ID` = :id);";
        $stmt  = $mechat_db->prepare($query);
            
        # Bind parameters
        $stmt->bindParam(':id', $chatID, PDO::PARAM_INT);
        $stmt->bindParam(':value', $value, PDO::PARAM_STR);

        if($stmt->execute()) // Executes the query
        {
            return true; // Returns true if successful
        } else {
            return false; // Returns false if the query is not executed successfully
        }
    }
    return false; // Returns false if the user does not exist   
}



/*

FUNCTION: meChat_sendMessage($from_chatID, $to_chatID, $message)
DESCRIPTION: Send message to the user
ARGUMENTS:
    $from_chatID - user id that will send
    $to_chatID - user id that will receive
    $message - message to be sent
    
*/
function meChat_sendMessage($from_chatID, $to_chatID, $message)
{
    global $mechat_db; // Call global variable
    
    # Query to check that the users with the $from_chatID and $to_chatID exists
    $query = "SELECT * FROM `wp_cendrillon_6239_users` WHERE (`ID` = :from) OR (`ID` = :to);";
    $stmt  = $mechat_db->prepare($query);
    
    # Bind parameters
    $stmt->bindParam(':from', $from_chatID, PDO::PARAM_INT);
    $stmt->bindParam(':to', $to_chatID, PDO::PARAM_INT);
    
    # Send message if successful query and the number of users found is equals to two
    if ($stmt->execute() && count($stmt->fetchAll(PDO::FETCH_ASSOC)) == 2) {
        
        # Query to send the message
        $query = "INSERT INTO `messages` (`id`, `from_user_id`, `to_user_id`, `message`, `date_timestamp`, `read`, `read_timestamp`) VALUES (NULL, :from, :to, :message, :date_timestamp, :read, :read_timestamp);";
        $stmt  = $mechat_db->prepare($query);
        
        # Bind parameters
        $stmt->bindParam(':from', $from_chatID, PDO::PARAM_INT);
        $stmt->bindParam(':to', $to_chatID, PDO::PARAM_INT);
        $stmt->bindParam(':message', $message, PDO::PARAM_STR);
        $value_date_timestamp = gmdate('U');
        $stmt->bindParam(':date_timestamp', $value_date_timestamp, PDO::PARAM_INT);
        $value_read = 0;
        $stmt->bindParam(':read', $value_read, PDO::PARAM_INT);
        $value_read_timestamp = -1;
        $stmt->bindParam(':read_timestamp', $value_read_timestamp, PDO::PARAM_INT);
        
        if (!$stmt->execute())
            return false; // Returns false if the query is not executed successfully
        return true; // Returns true if successful
    }
    return false; // Returns false if the query is not executed successfully or the users not exist 
}



/*

FUNCTION: meChatLogged_receiveMessage($chatID, $starting, $method = true, $order = true)
DESCRIPTION: Returns the last messages
ARGUMENTS:
    $chatID - user id
    $starting - from a reference
    $method - TRUE: recent messages
              FALSE: old messages
    $order - TRUE: the oldest messages to the most recent
             FALSE: the most recent message to the oldest
    $limit - maximum results
    
*/
function meChatLogged_receiveMessage($chatID, $starting, $method = true, $order = true, $limit = 20)
{
    global $mechat_db; // Call global variable
    
    # Checks if the user is logged
    if (($me = meChatLogged()) != false) {
        
        # Checks that the user with the $chatID exists
        if (($to = meChat_Exists($chatID)) != false) {
            
            # Method
            if($method == true) $method = '>';
            else $method = '<';
            
            # Order
            if($order == true) $order = 'ASC';
            else $order = 'DESC';
            
            # Query to load the last 20 messages
            $query = "SELECT * FROM (SELECT * FROM `messages` WHERE (((`from_user_id` = :me AND `to_user_id` = :to) OR (`from_user_id` = :to AND `to_user_id` = :me)) AND `id` ".$method." :starting) ORDER BY `date_timestamp` DESC LIMIT ".$limit.") recentmessages ORDER BY recentmessages.id ".$order."";
            $stmt  = $mechat_db->prepare($query);
            
            # Bind parameters
            $stmt->bindParam(':me', $me, PDO::PARAM_INT);
            $stmt->bindParam(':to', $to['ID'], PDO::PARAM_INT);
            $stmt->bindParam(':starting', $starting, PDO::PARAM_INT);
            
            # Get user data :to
            $array = array();
            $array['id']       = $to['ID']; //id
            $array['name']       = $to['user_login']; //user name
            $array['picture']    = $to['picture']; //user photo
            $array['lastupdate'] = $to['lastupdate']; //last updated
            
            if (!$stmt->execute()) //If the query is not executed successfully
                return $array; // Returns an array containing only the user data
            
            # Get messages     
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {   
                
                $array['messages'][] = array(
                    'from' => $row['from_user_id'],
                    'message' => $row
                );
            }
            return $array; // Returns the array containing the messages
        }
    }
    return false; // Returns false if are not logged
}



/*

FUNCTION: meChatLogged_recentlyMessages($minutes = 10)
DESCRIPTION: Returns the last received messages
ARGUMENTS:
    $minutes - minutes before
    
*/
function meChatLogged_recentlyMessages($minutes = 10)
{
    global $mechat_db; // Call global variable
    
    # Checks if the user is logged
    if (($chatID = meChatLogged()) != false)
    {
        # Query to check the last messages received, with $minutes before...
        $query = "SELECT * FROM `messages` 
    WHERE `to_user_id` = :id AND `read` = '0' AND `date_timestamp` > '" . (gmdate('U') - ($minutes * 60)) . "' 
    GROUP BY `from_user_id`
    ORDER BY `date_timestamp` DESC";
        $stmt  = $mechat_db->prepare($query);
        
        # Bind parameters
        $stmt->bindParam(':id', $chatID, PDO::PARAM_INT);
        
        if (!$stmt->execute())
        {
            return array(); // Returns an empty array, if there error with the query
        } else {
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Returns the array containing the messages  
        }
    }
    return false; // Returns false if are not logged
}



/*

FUNCTION: meChatLogged_openChat($chatID)
DESCRIPTION: Open a chatbox
ARGUMENTS:
    $chatID - user id
    
*/
function meChatLogged_openChat($chatID)
{
    global $mechat_db; // Call global variable
    
    # Checks if the user is logged
    if (($me = meChatLogged()) != false) {
        
        # Query to check that the user with the $chatID exists
        if (($to = meChat_Exists($chatID)) != false) {
            
            if (isset($_SESSION['meChat_chatboxes']) && !is_array($_SESSION['meChat_chatboxes']))
                $_SESSION['meChat_chatboxes'] = array();
            if (array_search($chatID, $_SESSION['meChat_chatboxes']) === false) {
                $_SESSION['meChat_chatboxes'][] = $chatID;
            }
            
            # Query to load the last 20 messages
            $query = "SELECT * FROM (SELECT * FROM `messages` WHERE (`from_user_id` = :me AND `to_user_id` = :to) OR (`from_user_id` = :to AND `to_user_id` = :me) ORDER BY `date_timestamp` DESC LIMIT 20) recentmessages ORDER BY recentmessages.id ASC";
            $stmt  = $mechat_db->prepare($query);
            
            # Bind parameters
            $stmt->bindParam(':me', $me, PDO::PARAM_INT);
            $stmt->bindParam(':to', $to['ID'], PDO::PARAM_INT);
            
            # Get user data :to
            $array = array();
            $array['id']       = $to['ID']; //id
            $array['name']       = $to['user_login']; //user name
            $array['picture']    = $to['picture']; //user photo
            $array['lastupdate'] = $to['lastupdate']; //last updated
            
            if (!$stmt->execute()) // If the query is not executed successfully
                return $array; // Returns an array containing only the user data
                
            # Get messages 
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                
                $array['messages'][] = array(
                    'from' => $row['from_user_id'],
                    'message' => $row
                );
            }
            return $array; // Returns the array containing the messages  
        }
        return false; // Returns false if the user does not exist
    }
    return false; // Returns false if are not logged
}



/*

FUNCTION: meChatLogged_markAllAsRead($chatID)
DESCRIPTION: Mark all messages as read
ARGUMENTS:
    $chatID - user id
    
*/
function meChatLogged_markAllAsRead($chatID)
{
    global $mechat_db; // Call global variable
    
    # Checks if the user is logged
    if (($me = meChatLogged()) != false) {
        
        # Checks that the user with the $chatID exists
        if (($to = meChat_Exists($chatID)) != false) {
            
            # Query to mark all messages as read
            $query = "UPDATE `messages` SET `read`= '1', `read_timestamp`= :timestamp WHERE (`from_user_id` = :me AND `to_user_id` = :to) OR (`from_user_id` = :to AND `to_user_id` = :me);";
            $stmt  = $mechat_db->prepare($query);
            
            # Bind parameters
            $timestamp = gmdate('U');
            $stmt->bindParam(':me', $me, PDO::PARAM_INT);
            $stmt->bindParam(':to', $to['id'], PDO::PARAM_INT);
            $stmt->bindParam(':timestamp', $timestamp, PDO::PARAM_INT);
            
            if (!$stmt->execute())
                return false; // Returns false if there error with the query
            return true; // Returns true if successful
        }
    }
    return false; // Returns false if are not logged
}



/*

FUNCTION: meChatLogged_closeChat($chatID)
DESCRIPTION: Close a chatbox
ARGUMENTS:
    $chatID - user id
    
*/
function meChatLogged_closeChat($chatID)
{
    # Remove user of the opened chatboxes
    if (($chatbox = array_search($chatID, $_SESSION['meChat_chatboxes'])) !== false) {
        
        # Mark all messages as read
        meChatLogged_markAllAsRead($chatID); 
        
        unset($_SESSION['meChat_chatboxes'][$chatbox]);
        return true; // Returns true if the chatbox is found and closed
    }
    return false; // Returns false if the chatbox is not found
}



/*

FUNCTION: meChatLogged_openedChat()
DESCRIPTION: Returns the opened chatboxes
ARGUMENTS:
    none
    
*/
function meChatLogged_openedChat()
{
    if (isset($_SESSION['meChat_chatboxes']))
        return $_SESSION['meChat_chatboxes']; // Returns array of opened chatboxes
    return array(); // Returns empty array if none is open
}



/*

FUNCTION: meChatLogged_Friends($page = false, $max_results = 15)
DESCRIPTION: Returns the list of friends
ARGUMENTS:
    $page - page
    $max_results - maximum results per page
    
*/
function meChatLogged_Friends($page = false, $max_results = 15)
{
    global $mechat_db; // Call global variable
    
    # Checks if the user is logged
    if (($me = meChatLogged()) != false) {
        
        # Pagination
        $limit = '';
        if($page !== false)
        {
            $start = (($page) * $max_results);            
            $limit = 'LIMIT '.$start.','.($max_results);
        }
        
        # Query to return the list of friends
        $query = "SELECT `friends`.*,`wp_cendrillon_6239_users`.`user_login` AS `friend_name`,`wp_cendrillon_6239_users`.`picture` AS `friend_picture`,`wp_cendrillon_6239_users`.`lastupdate` AS `friend_lastupdate` FROM ( SELECT `friends_list`.`ID` AS `friendship_id`, IF(`user_one` != :me , `user_one`, `user_two`) AS `friend_id` FROM `friends_list` WHERE (`user_one` = :me OR `user_two` = :me) ".$limit.") `friends` INNER JOIN `wp_cendrillon_6239_users` ON `wp_cendrillon_6239_users`.`ID` = `friends`.`friend_id`;";
        $stmt  = $mechat_db->prepare($query);
        
        # Bind parameters            
        $stmt->bindParam(':me', $me, PDO::PARAM_INT);
        
        if (!$stmt->execute()) return array(); // Returns an empty array, if there error with the query
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Returns array of friends

    }
    return false; // Returns false if are not logged
}



/*

FUNCTION: meChat_CountUsers()
DESCRIPTION: Return total users
ARGUMENTS:
    none
    
*/
function meChat_CountUsers()
{
    global $mechat_db; // Call global variable
    
    # Query to get the total of registered users
    $query = "SELECT count(*) FROM `users`";
    $stmt = $mechat_db->prepare($query);
    
    if ($stmt->execute() != false)
    {
        if (count($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) > 0)
        {
            return $result[0]['count(*)']; // Return total users
        }

    }
    return false; // Returns false if there error with the query
}



/*

FUNCTION: meChat_CountRecentUsers($minutes = 10)
DESCRIPTION: Returns the total of recent users
ARGUMENTS:
    $minutes - minutes before
    
*/
function meChat_CountRecentUsers($minutes = 10)
{
    global $mechat_db; // Call global variable
    
    # Query to get the total of recent users
    $query = "SELECT count(*) FROM `users` 
    WHERE `lastupdate` > '" . (gmdate('U') - ($minutes * 60)) . "';";
    $stmt = $mechat_db->prepare($query);
    
    if ($stmt->execute() != false)
    {
        if (count($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) > 0)
        {
            return $result[0]['count(*)']; // Returns the total of recent users
        }

    }
    return false; // Returns false if there error with the query
}



/*

FUNCTION: meChat_CountMessages($from_chatID = null, $to_chatID = null)
DESCRIPTION: Returns the total of messages
ARGUMENTS:
    $from_chatID - user id that sent
                   null: all users
    $to_chatID - user id that receive
                 null: all users
    
*/
function meChat_CountMessages($from_chatID = null, $to_chatID = null)
{
    global $mechat_db; // Call global variable
    
    # Query to get the total of messages   
    if(!is_null($from_chatID) && !is_null($to_chatID)) // Total messages between users
    {
        $query = "SELECT count(*) FROM `messages` WHERE (`from_user_id` = :from AND `to_user_id` = :to) OR (`from_user_id` = :to AND `to_user_id` = :from);";
        $stmt = $mechat_db->prepare($query);
        
        # Bind parameters
        $stmt->bindParam(':from', $from_chatID, PDO::PARAM_INT);
        $stmt->bindParam(':to', $to_chatID, PDO::PARAM_INT);        
    }
    if(is_null($from_chatID) && is_null($to_chatID)) // Total of messages
    {
        $query = "SELECT count(*) FROM `messages`;";
        $stmt = $mechat_db->prepare($query);
    }
    if(!is_null($from_chatID) && is_null($to_chatID)) // Only sent by $from_chatID
    {
        $query = "SELECT count(*) FROM `messages` WHERE `from_user_id` = :from;";
        $stmt = $mechat_db->prepare($query);
        
        # Bind parameters
        $stmt->bindParam(':from', $from_chatID, PDO::PARAM_INT);       
    }
    if(is_null($from_chatID) && !is_null($to_chatID)) // Only received by $to_chatID
    {
        $query = "SELECT count(*) FROM `messages` WHERE `to_user_id` = :to;";
        $stmt = $mechat_db->prepare($query);
        
        # Bind parameters
        $stmt->bindParam(':to', $to_chatID, PDO::PARAM_INT);           
    }
        
    if ($stmt->execute() != false)
    {
        if (count($result = $stmt->fetchAll(PDO::FETCH_ASSOC)) > 0)
        {
            return $result[0]['count(*)']; // Returns the total of messages
        }

    }
    return false; // Returns false if there error with the query
}



/*

FUNCTION: meChat_CountConversations()
DESCRIPTION: Returns the total of conversations
ARGUMENTS:
    none
    
*/
function meChat_CountConversations()
{
    global $mechat_db; // Call global variable
    
    # Query to get the total of conversations
    $query = "SELECT count(*) FROM `messages` GROUP BY `from_user_id`, `to_user_id`;";
    $stmt = $mechat_db->prepare($query);
    
    if ($stmt->execute() != false)
    {
        return count($stmt->fetchAll(PDO::FETCH_ASSOC)); // Returns the total of conversations
    }
    return false; // Returns false if there error with the query
}



/*

FUNCTION: meChat_CountFriendships()
DESCRIPTION: Returns the total of friendships
ARGUMENTS:
    none
    
*/
function meChat_CountFriendships()
{
    global $mechat_db; // Call global variable
    
    # Query to get the total of conversations
    $query = "SELECT * FROM `friendships` GROUP BY `id_user_1`, `id_user_2`;";
    $stmt = $mechat_db->prepare($query);
    
    if ($stmt->execute() != false)
    {
        return count($stmt->fetchAll(PDO::FETCH_ASSOC)); // Returns the total of friendships
    }
    return false; // Returns false if there error with the query
}


/*

THIS FUNCTION IS COMPLEMENTARY TO OTHER

*/
function mechat_buildWHERE($where)
{        
    $build_WHERE = '';
    if($where != null)
    {
        # Separator
        $separator = 'AND';
        if(isset($where['_separator']))
        {
            $separator = $where['_separator'];
            unset($where['_separator']);
        }
        
        # Build WHERE clause
        $i = 0;
        foreach ($where as $key => $value)
        {               
            if($i == 0 & count($where) > 0)
            {
                $build_WHERE .= 'WHERE '; 
            }
            
            $build_WHERE .= '`'.$key.'` '.$value;
            
            if($i < count($where) - 1)
            {
                $build_WHERE .= ' ' . $separator . ' ';
            }
            
            $i++;            
        }
    }
    return $build_WHERE;
}



/*

THIS FUNCTION IS COMPLEMENTARY TO OTHER

*/
function mechat_buildORDER($order)
{
    $build_ORDER = '';
    if($order != null)
    {
        # Separator
        $separator = ',';
        if(isset($order['_separator']))
        {
            $separator = $order['_separator'];
            unset($order['_separator']);
        }
        
        # Build ORDER clause
        $i = 0;
        foreach ($order as $key => $value)
        {   
            if($i == 0 & count($order) > 0)
            {
                $build_ORDER .= 'ORDER BY '; 
            }   
            
            $build_ORDER .= '`'.$key.'` '.$value;
            
            if($i < count($order) - 1)
            {
                $build_ORDER .= ' ' . $separator . ' ';
            }
            
            $i++;
        }
    }
    return $build_ORDER;
}



/*

FUNCTION: meChat_ListUsers($where = null, $order = null, $page = 0, $max_results = 10)
DESCRIPTION: Return the users list
ARGUMENTS:
    $where - condition (array)
        Example: array("id" => ">= 1", "identifier" => "= lower('TEST')")
    $order - sort results (array)
        Example: array('id' => 'ASC')
    $page - page
    $max_results - maximum results
    
*/
function meChat_ListUsers($where = null, $order = null, $page = 0, $max_results = 10)
{
    global $mechat_db; // Call global variable
    
    # Pagination
    $limit = '';
    if($page !== false)
    {
        $start = (($page) * $max_results);            
        $limit = 'LIMIT '.$start.','.($max_results);
    }    

    # Query to get the list of users
    $query = "SELECT * FROM `users` ".mechat_buildWHERE($where)." ".mechat_buildORDER($order)." ".$limit;
    $stmt = $mechat_db->prepare($query);

    if ($stmt->execute() != false)
    {
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Return the users list
    }
    return false; // Returns false if there error with the query
}



/*

FUNCTION: meChat_ListRecentUsers($minutes = 10, $where = null, $order = null, $page = 0, $max_results = 10)
DESCRIPTION: Return the recent users list
ARGUMENTS:
    $minutes - minutes before
    $where - condition (array)
        Example: array("id" => ">= 1", "identifier" => "= lower('TEST')")
    $order - sort results (array)
        Example: array('id' => 'ASC')
    $page - page
    $max_results - maximum results
    
*/
function meChat_ListRecentUsers($minutes = 10, $where = null, $order = null, $page = 0, $max_results = 10)
{
    global $mechat_db; // Call global variable
    
    # Pagination
    $limit = '';
    if($page !== false)
    {
        $start = (($page) * $max_results);            
        $limit = 'LIMIT '.$start.','.($max_results);
    }    
    
    # Query to get the list of recent users
    $query = "SELECT * FROM `users` WHERE `lastupdate` > '" . (gmdate('U') - ($minutes * 60)) . "' AND (" . str_replace('WHERE', '', mechat_buildWHERE($where)) . ") ".mechat_buildORDER($order)." ".$limit;
    $stmt = $mechat_db->prepare($query);

    if ($stmt->execute() != false)
    {
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Return the recent users list
    }
    return false; // Returns false if there error with the query
}



/*

FUNCTION: meChat_ListMessages($where = null, $order = null, $page = 0, $max_results = 10)
DESCRIPTION: Return the messages list
ARGUMENTS:
    $where - condition (array)
        Example: array("read_timestamp" => ">= 1", "id" => "< 50")
    $order - sort results (array)
        Example: array('id' => 'ASC')
    $page - page
    $max_results - maximum results
    
*/
function meChat_ListMessages($where = null, $order = null, $page = 0, $max_results = 10)
{
    global $mechat_db; // Call global variable
    
    # Pagination
    $limit = '';
    if($page !== false)
    {
        $start = (($page) * $max_results);            
        $limit = 'LIMIT '.$start.','.($max_results);
    }        
    
    # Query to get the list of messages
    $query = "SELECT * FROM `messages` ".mechat_buildWHERE($where)." ".mechat_buildORDER($order)." ".$limit;
    $stmt = $mechat_db->prepare($query);

    if ($stmt->execute() != false)
    {
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Return the messages list
    }
    return false; // Returns false if there error with the query
}



/*

FUNCTION: meChat_ListConversations($where = null, $order = null, $page = 0, $max_results = 10)
DESCRIPTION: Returns the conversations list
ARGUMENTS:
    $where - condition (array)
        Example: array("read_timestamp" => ">= 1", "id" => "< 50")
    $order - sort results (array)
        Example: array('id' => 'ASC')
    $page - page
    $max_results - maximum results
    
*/
function meChat_ListConversations($where = null, $order = null, $page = 0, $max_results = 10)
{
    global $mechat_db; // Call global variable
    
    # Pagination
    $limit = '';
    if($page !== false)
    {
        $start = (($page) * $max_results);            
        $limit = 'LIMIT '.$start.','.($max_results);
    }        
    
    # Query to get the list of messages
    $query = "SELECT * FROM `messages` ".mechat_buildWHERE($where)." GROUP BY `from_user_id`, `to_user_id` ".mechat_buildORDER($order)." ".$limit;
    $stmt = $mechat_db->prepare($query);

    if ($stmt->execute() != false)
    {
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Returns the conversations list
    }
    return false; // Returns false if there error with the query
}



/*

FUNCTION: meChat_ListFriendships($where = null, $order = null, $page = 0, $max_results = 10)
DESCRIPTION: Returns the friendships list
ARGUMENTS:
    $where - condition (array)
        Example: array("read_timestamp" => ">= 1", "id" => "< 50")
    $order - sort results (array)
        Example: array('id' => 'ASC')
    $page - page
    $max_results - maximum results
    
*/
function meChat_ListFriendships($where = null, $order = null, $page = 0, $max_results = 10)
{
    global $mechat_db; // Call global variable
    
    # Pagination
    $limit = '';
    if($page !== false)
    {
        $start = (($page) * $max_results);            
        $limit = 'LIMIT '.$start.','.($max_results);
    }        
    
    # Query to get the list of messages
    $query = "SELECT * FROM `friendships` ".mechat_buildWHERE($where)." GROUP BY `id_user_1`, `id_user_2` ".mechat_buildORDER($order)." ".$limit;
    $stmt = $mechat_db->prepare($query);

    if ($stmt->execute() != false)
    {
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Returns the friendships list
    }
    return false; // Returns false if there error with the query
}

?>