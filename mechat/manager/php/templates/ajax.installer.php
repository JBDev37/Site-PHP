<?php

/*
    HIDE ALL ERROR MESSAGES BY DEFAULT, FOR JSON RESPONSE (THIS CODE WORKS PROPERLY)
*/
ini_set('error_reporting', 0);
error_reporting(0);



# Check if are logged in
if(!isset($_SESSION)) {
     session_start();
}
if(!isset($_SESSION['logged']))
{
    header('Location: login.php');
}



# Check that the keys were passed via POST
if (!(isset($_POST['me_chat_settings:path']) && isset($_POST['me_chat_database:host']) && isset($_POST['me_chat_database:user']) && isset($_POST['me_chat_database:password']) && isset($_POST['me_chat_database:database']) && isset($_POST['me_chat_database:createdatabase']) && isset($_POST['me_chat_imageupload:allow']) && isset($_POST['me_chat_imageupload:path']) && isset($_POST['me_chat_imageupload:createpath']) && isset($_POST['me_chat_imageupload:maxsize']) && isset($_POST['me_chat_imageupload:extension'])))
{
    exit();
}



$me_chat_settings = array(
    'properties' => array(
        'path' => $_POST['me_chat_settings:path']
    ) ,
    'name' => 'me_chat_settings',
    'return' => '',
    'success' => false
);
$me_chat_database = array(
    'properties' => array(
        'host' => $_POST['me_chat_database:host'],
        'user' => $_POST['me_chat_database:user'],
        'password' => $_POST['me_chat_database:password'],
        'database' => $_POST['me_chat_database:database'],
        'createdatabase' => $_POST['me_chat_database:createdatabase']
    ) ,
    'name' => 'me_chat_database',
    'return' => '',
    'success' => false
);
$me_chat_imageupload = array(
    'properties' => array(
        'allow' => $_POST['me_chat_imageupload:allow'],
        'path' => $_POST['me_chat_imageupload:path'],
        'createpath' => $_POST['me_chat_imageupload:createpath'],
        'maxsize' => $_POST['me_chat_imageupload:maxsize'],
        'extension' => $_POST['me_chat_imageupload:extension']
    ) ,
    'name' => 'me_chat_imageupload',
    'return' => '',
    'success' => false
);



# Check if the meChat folder is valid and contains the configuration file "config.json"
if (file_exists($_SERVER['DOCUMENT_ROOT'] . $me_chat_settings['properties']['path'] . 'config.json'))
{
    $me_chat_settings['return'] = 'The configuration file has been successfully found!';
    $me_chat_settings['success'] = true;
    if (!is_writable($_SERVER['DOCUMENT_ROOT'] . $me_chat_settings['properties']['path'] . 'config.json'))
    {
        $me_chat_settings['return'] = 'The configuration file "mechat/config.json" cannot be overwritten.';
        $me_chat_settings['success'] = false;
    }
}
else
{
    $me_chat_settings['return'] = 'The configuration file "mechat/config.json" was not found.';
}

# Save successful settings.
if ($me_chat_settings['success'] == true)
{
    $me_chat_config = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . $me_chat_settings['properties']['path'] . 'config.json') , true);
    
    
    $me_chat_config['me_chat_settings']['path'] = $me_chat_settings['properties']['path'];
    
    
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . $me_chat_settings['properties']['path'] . 'config.json', json_encode($me_chat_config));
}



# Check connection with the server
if (mysql_connect($me_chat_database['properties']['host'], $me_chat_database['properties']['user'], $me_chat_database['properties']['password']) != false)
{
    $mechat_db = new PDO('mysql:host=' . $me_chat_database['properties']['host'] . ';', $me_chat_database['properties']['user'], $me_chat_database['properties']['password'], array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT
    ));
    
    $me_chat_database['return'] = 'Connected to server successfully!';
    $me_chat_database['success'] = true;

    # Check if the database exists
    $result = $mechat_db->query("SELECT COUNT(*) FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '" . $me_chat_database['properties']['database'] . "'");
    $result = ($result->fetch(PDO::FETCH_ASSOC)['COUNT(*)'] > 0 ? true : false);
    if ($result == true)
    {
        $me_chat_database['return'] = 'Connected to database successfully!';
        $me_chat_database['success'] = true;

        # Check if database tables exists
        $result = $mechat_db->query("SELECT COUNT(*) FROM `" . $me_chat_database['properties']['database'] . "`.friendships, `" . $me_chat_database['properties']['database'] . "`.messages, `" . $me_chat_database['properties']['database'] . "`.users LIMIT 1");

        # The tables do not exist
        if ($result == false)
        {
            $me_chat_database['return'] = 'The tables don\'t exist. Failed to create the tables "mechat/sql.sql".';
            $me_chat_database['success'] = false;

            # Try to create the tables
            if (($sql = file_get_contents($_SERVER['DOCUMENT_ROOT'] . $me_chat_config['me_chat_settings']['path'] . 'sql.sql')) != false)
            {
                $result = $mechat_db->query('USE `' . $me_chat_database['properties']['database'] . '`; ' . $sql);
                if ($result != false)
                {
                    $me_chat_database['return'] = 'The tables don\'t exist, they have been successfully created!';
                    $me_chat_database['success'] = true;
                }
            }
        }
        else // Tables exist
        {
            $me_chat_database['return'] = 'Successfully connected to the database tables!';
            $me_chat_database['success'] = true;
        }
    }
    else
    {
        $me_chat_database['return'] = 'The database doesn\'t exist.';
        $me_chat_database['success'] = false;

        # Create database
        if ($me_chat_database['properties']['createdatabase'] == 'checked')
        {
            $result = $mechat_db->query('CREATE DATABASE `' . $me_chat_database['properties']['database'] . '`;');
            if ($result != false)
            {
                $me_chat_database['return'] = 'Database created successfully! Failed to create the tables "mechat/sql.sql".';
                $me_chat_database['success'] = false;

                # Try to create the tables
                if (($sql = file_get_contents($_SERVER['DOCUMENT_ROOT'] . $me_chat_config['me_chat_settings']['path'] . 'sql.sql')) != false)
                {
                    $result = $mechat_db->query('USE `' . $me_chat_database['properties']['database'] . '`; ' . $sql);
                    if ($result != false)
                    {
                        $me_chat_database['return'] = 'Database and tables created successfully!';
                        $me_chat_database['success'] = true;
                    }
                }
            }
        }
    }
}
else
{
    $me_chat_database['return'] = 'Failed to connect to the server.';
}

# Save successful settings
if ($me_chat_database['success'] == true)
{
    $me_chat_config = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . $me_chat_settings['properties']['path'] . 'config.json') , true);
    
    
    $me_chat_config['me_chat_database']['host'] = $me_chat_database['properties']['host'];
    $me_chat_config['me_chat_database']['database'] = $me_chat_database['properties']['database'];
    $me_chat_config['me_chat_database']['user'] = $me_chat_database['properties']['user'];
    $me_chat_config['me_chat_database']['password'] = $me_chat_database['properties']['password'];
    
    
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . $me_chat_settings['properties']['path'] . 'config.json', json_encode($me_chat_config));
}



# Check if upload of images is allowed
if ($me_chat_imageupload['properties']['allow'] == 'checked')
{
    # Check that the directory exists
    if (is_dir($_SERVER['DOCUMENT_ROOT'] . $me_chat_imageupload['properties']['path']))
    {
        $me_chat_imageupload['return'] = 'The directory was found!';
        $me_chat_imageupload['success'] = true;
        if (!is_writable($_SERVER['DOCUMENT_ROOT'] . $me_chat_imageupload['properties']['path']))
        {
            $me_chat_imageupload['return'] = 'The directory cannot be changed.';
            $me_chat_imageupload['success'] = false;
        }
    }
    else // Check that the directory does not exists
    {
        $me_chat_imageupload['return'] = 'The directory was not found.';
        $me_chat_imageupload['success'] = false;

        # Try to create directory
        if ($me_chat_imageupload['properties']['createpath'] == 'checked')
        {
            if (mkdir($_SERVER['DOCUMENT_ROOT'] . $me_chat_imageupload['properties']['path']))
            {
                $me_chat_imageupload['return'] = 'The directory was created successfully!';
                $me_chat_imageupload['success'] = true;
            }
            else
            {
                $me_chat_imageupload['return'] = 'The directory cannot be created.';
                $me_chat_imageupload['success'] = false;
            }
        }
    }
}
else
{
    $me_chat_imageupload['return'] = 'Uploading of images disabled.';
    $me_chat_imageupload['success'] = true;
}

# Save successful settings.
if ($me_chat_imageupload['success'] == true)
{
    $me_chat_config = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . $me_chat_settings['properties']['path'] . 'config.json') , true);
    
    
    $me_chat_config['me_chat_imageupload']['path'] = $me_chat_imageupload['properties']['path'];
    $me_chat_config['me_chat_imageupload']['maxsize'] = $me_chat_imageupload['properties']['maxsize'];
    $me_chat_config['me_chat_imageupload']['extension'] = $me_chat_imageupload['properties']['extension'];
    
    $me_chat_config['me_chat_settings']['box_allow_imageupload_maxsize'] = $me_chat_imageupload['properties']['maxsize'];
    
    # Allow upload images
    if ($me_chat_imageupload['properties']['allow'] == 'checked')
    {
        $me_chat_config['me_chat_settings']['box_allow_imageupload'] = true;
    }
    else
    {
        $me_chat_config['me_chat_settings']['box_allow_imageupload'] = false;  
    }
        
    
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . $me_chat_settings['properties']['path'] . 'config.json', json_encode($me_chat_config));
}



# Return JSON
echo json_encode(array(
    $me_chat_settings,
    $me_chat_database,
    $me_chat_imageupload
));
?>