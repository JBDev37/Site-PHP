<?php

include('php/config.php');

# Check if are logged in
if(!isset($_SESSION))
{
     session_start();
}
if(isset($_SESSION['logged']))
{
    if($_SESSION['logged'] == true)
    {
        header('Location: index.php');
    }
}

$password_status = '';
if(isset($_POST['password']))
{
    if(md5($_POST['password']) == $me_chat_manager_config['password'])
    {
        $_SESSION['logged'] = true;
        $_SESSION['login_timestamp'] = gmdate('u', time());
        header('Location: index.php');
    }
    else
    {
        $password_status = '<div class="alert alert-danger"><strong>Ahh!</strong> Incorrect password.</div>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php include('includes/head.php'); ?>
    <title>meChat Manager - Login</title>
    
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Log into Manager</h3>
                    </div>
                    <div class="panel-body">
                        <?=$password_status?>
                        <form action="login.php" method="post" role="form">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <!--<div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div>-->
                                <button type="submit" class="btn btn-lg btn-success btn-block">Login</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include('includes/body_footer.php'); ?>

</body>

</html>