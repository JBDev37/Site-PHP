<?php
    
include('php/config.php');

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

    <title>meChat Manager - Installer</title>    
    <?php include('includes/head.php'); ?>
    
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">meChat Manager</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Administrator <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="changepassword.php"><i class="fa fa-fw fa-gear"></i> Password</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="installer.php"><i class="fa fa-fw fa-cogs"></i> Installer</a>
                    </li>
                    <li>
                        <a href="config.php?settings"><i class="fa fa-fw fa-cog"></i> Config: Settings</a>
                    </li>
                    <li>
                        <a href="config.php?strings"><i class="fa fa-fw fa-cog"></i> Config: Strings</a>
                    </li>
                    <li>
                        <a href="config.php?imageupload"><i class="fa fa-fw fa-cog"></i> Config: Image Upload</a>
                    </li>                    
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Installer
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-cogs"></i> Installer
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
<div class="col-lg-12">
	<form id="me_chat_manager_config" class="form-horizontal" role="form">
		<div>
			<h3>meChat Path (relative to site root)</h3>
			<div name="me_chat_settings" class="alert" style="display: none;"></div>
			<div class="form-group">
				<div class="col-xs-12 col-md-6">
					<input name="me_chat_settings:path" type="text" class="form-control" placeholder="Ex: plugins/mechat/" value="<?=$me_chat_config['me_chat_settings']['path'];?>">
                    <i>Relative to site root, end with forward slash "/".</i>
				</div>
			</div>
		</div>
		<div>
			<h3>Database connection</h3>
			<div class="alert" name="me_chat_database" style="display: none;"></div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="me_chat_database:host">Server</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="me_chat_database:host" placeholder="Ex: localhost" name="me_chat_database:host" value="<?=$me_chat_config['me_chat_database']['host'];?>">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="me_chat_database:user">Username</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="me_chat_database:user" placeholder="Enter username" name="me_chat_database:user" value="<?=$me_chat_config['me_chat_database']['user'];?>">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="me_chat_database:password">Password</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="me_chat_database:password" placeholder="Enter password" name="me_chat_database:password" value="<?=$me_chat_config['me_chat_database']['password'];?>">
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="me_chat_database:database">Database</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="me_chat_database:database" placeholder="Enter database name" name="me_chat_database:database" value="<?=$me_chat_config['me_chat_database']['database'];?>">
					<div class="checkbox">
						<label><input type="checkbox" name="me_chat_database:createdatabase"> Create database</label>
					</div>
				</div>
			</div>
		</div>
		<div>
			<h3>Image upload</h3>
			<div class="alert" name="me_chat_imageupload" style="display: none;"></div>
            <div class="form-group">
				<label class="control-label col-sm-2" for="me_chat_imageupload:path">Allow</label>
				<div class="col-sm-10">
					<div class="checkbox">
						<label><input type="checkbox" name="me_chat_imageupload:allow"></label>
					</div>
				</div>
			</div>        
			<div class="form-group">
				<label class="control-label col-sm-2" for="me_chat_imageupload:path">Path</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="me_chat_imageupload:path" placeholder="Ex: /plugins/mechat/imageupload" name="me_chat_imageupload:path" value="<?=$me_chat_config['me_chat_imageupload']['path'];?>">
					<i>Relative to site root, end with forward slash "/".</i>
					<div class="checkbox">
						<label><input type="checkbox" name="me_chat_imageupload:createpath"> Create path</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="me_chat_imageupload:maxsize">Max size</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="me_chat_imageupload:maxsize" placeholder="Ex: 2.5" name="me_chat_imageupload:maxsize" value="<?=$me_chat_config['me_chat_imageupload']['maxsize'];?>">
					<i>In megabytes (Don't use comma).</i>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-2" for="me_chat_imageupload:extension">New extension</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" id="me_chat_imageupload:extension" placeholder="Ex: .jpg" name="me_chat_imageupload:extension" value="<?=$me_chat_config['me_chat_imageupload']['extension'];?>">
				</div>
			</div>
            <hr>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-default">Save</button>
				</div>
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
        url: 'php/templates/ajax.installer.php',
        type: 'POST',
        data: params,
        error: function()
        {
            alert('FAIL, TRY AGAIN.');
        },
        success: function(data)
        {   
            console.log(data);
            if(data.length != 0) data = JSON.parse(data);
            
            for (i = 0; i < data.length; i++)
            { 
                if(data[i].success == true)
                {
                    $('[name='+ data[i].name +']').removeClass('alert-danger').addClass('alert-success').show().html(data[i].return);
                }
                else
                {
                    $('[name='+ data[i].name +']').removeClass('alert-success').addClass('alert-danger').show().html(data[i].return);
                }
            }
        }
    });
});        
    </script>
    
</body>

</html>
