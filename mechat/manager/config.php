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

$title = '';
$section = '';

if(empty($_GET) || (empty($_GET) == false && ((key($_GET) == 'settings' || key($_GET) == 'imageupload' || key($_GET) == 'strings')) == false))
{
    header('Location: index.php');
}
else
{        
    if(key($_GET) == 'settings')
    {
        $title = 'Settings';
        $section = 'me_chat_settings';
    }
    if(key($_GET) == 'imageupload')
    {
        $title = 'Image Upload';
        $section = 'me_chat_imageupload';
    }
    if(key($_GET) == 'strings')
    {
        $title = 'Strings';
        $section = 'me_chat_strings';
    }        
}

if(!is_null($me_chat_config) && !empty($me_chat_config))
{
    $me_chat_config = $me_chat_config[$section];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>meChat Manager - Config: <?=$title?></title>    
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
                            Config: <?=$title?>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-cog"></i> Config: <?=$title?>
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                
                <div class="row">
<div class="col-lg-12">
    
	<form id="me_chat_manager_config" class="form-horizontal" role="form">
        
        <?php foreach($me_chat_config as $key => $value): ?>
        
			<div class="form-group">
                
				<label class="control-label col-sm-3" for="<?=$section?>:<?=$key?>"><?=$key?></label>
				
                <div class="col-sm-9">
					
                    <input type="text" class="form-control" id="<?=$section?>:<?=$key?>" placeholder="Ex: localhost" name="<?=$section?>:<?=$key?>" value="<?=(is_bool($value) ? ($value == true ? 'true' : 'false') : $value)?>">
                    
				</div>
                
			</div>
            <?php endforeach; ?>
        
<?php if($me_chat_config != false): ?>
        
        <div class="alert" style="display: none;"></div>
        
<?php else: ?>
        
        <div class="alert alert-danger">
            Could not find the configuration file "mechat/config.json".
        </div>  
        
<?php endif; ?>        
        
<?php if($me_chat_config != false) { ?>
			<div class="form-group">
                
				<div class="col-sm-offset-2 col-sm-10">
                    
					<button type="submit" class="btn btn-default">Save</button>
                    
				</div>
                
			</div>  
<?php } ?>            
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
$('#me_chat_manager_config [type="checkbox"]').click(function () {
    if($(this).is(':checked'))
    {
        $(this).val('checked');   
    }
    else
    {
        $(this).val('');    
    }
});

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
        url: 'php/templates/ajax.config.php',
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
