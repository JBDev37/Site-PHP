<?php

include('php/config.php');
include('php/functions.php');

# Check if are logged in
if(!isset($_SESSION)) {
     session_start();
}
if(!isset($_SESSION['logged']))
{
    header('Location: login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>meChat Manager - Change password</title>    
    <?php include('includes/head.php'); ?>
    
</head>

<body>

    <div id="wrapper">

        <?php include('includes/body_navbar.php'); ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Change Password
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-key"></i> Change password
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                
                <div class="row">
<div class="col-lg-12">
    
	<form id="me_chat_manager_config" class="form-horizontal" role="form">
        
        <div class="form-group">
            <label class="control-label col-sm-3" for="me_chat_manager_config:load_jquery">Password</label>
            <div class="col-sm-8">
                <input type="password" class="form-control" id="me_chat_manager_config:password" name="me_chat_manager_config:password">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-3" for="me_chat_manager_config:load_css">New password</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="me_chat_manager_config:newpassword" name="me_chat_manager_config:newpassword">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-3" for="me_chat_manager_config:message_invalid">Confirm password</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="me_chat_manager_config:confirmpassword" name="me_chat_manager_config:confirmpassword">
            </div>
        </div>

        <?php if($me_chat_config != false): ?>

        <div class="alert" style="display: none;"></div>

        <?php else: ?>

        <div class="alert alert-danger">
            Could not find the configuration file "mechat/manager/config.json".
        </div>

        <?php endif; ?> 

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Save</button>
            </div>
        </div>  
               
	</form>
    
</div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?php include('includes/body_footer.php'); ?>
    
    <script type="text/javascript">
$('#me_chat_manager_config [type="submit"]').click(function(event)
{
    event.preventDefault();
    var params = {};
    
    $.each($('#me_chat_manager_config input'), function(key, value)
    {
        params[$(this).attr('name')] = $(this).val();
    });    
    
    $.ajax(
    {
        url: 'php/templates/ajax.changepassword.php',
        type: 'POST',
        data: params,
        error: function()
        {
            alert('FAIL, TRY AGAIN.');
        },
        success: function(data)
        {   
            if(data.length != 0) data = JSON.parse(data);
            
            if(data.success == true)
            {
                $('#me_chat_manager_config').find('.alert').removeClass('alert-danger').addClass('alert-success').show().html(data.return);
            }
            else
            {
                $('#me_chat_manager_config').find('.alert').removeClass('alert-success').addClass('alert-danger').show().html(data.return);
            }
        }
    });
});        
    </script>
    
</body>

</html>
