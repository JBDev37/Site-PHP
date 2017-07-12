<?php
ob_start();
ini_set('display_errors','on');
error_reporting(E_ALL);
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

    <title>meChat Manager - Dashboard</title>    
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
                            Dashboard <small>Overview</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-users fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?=meChat_CountUsers()?></div>
                                        <div>Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="table.php?users">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-child fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?=meChat_CountRecentUsers(5)?></div>
                                        <div>Users connected</div>
                                    </div>
                                </div>
                            </div>
                            <a href="table.php?usersconnected">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>                    
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comment fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?=meChat_CountMessages()?></div>
                                        <div>Messages</div>
                                    </div>
                                </div>
                            </div>
                            <a href="table.php?messages">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?=meChat_CountConversations()?></div>
                                        <div>Conversations</div>
                                    </div>
                                </div>
                            </div>
                            <a href="table.php?conversations">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-retweet fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge"><?=meChat_CountFriendships()?></div>
                                        <div>Friendships</div>
                                    </div>
                                </div>
                            </div>
                            <a href="table.php?friendships">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
<?php

/*if (@mysql_connect($me_chat_config['me_chat_database']['host'], $me_chat_config['me_chat_database']['user'], $me_chat_config['me_chat_database']['password']) != false):

?>
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-tasks fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">OK</div>
                                        <div>Database connection</div>
                                    </div>
                                </div>
                            </div>
                            <a href="installer.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View configurations</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
<?php else: ?>
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-tasks fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">FAIL</div>
                                        <div>Database connection</div>
                                    </div>
                                </div>
                            </div>
                            <a href="installer.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View configurations</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
<?php endif; */?>
                    <!--</div>
                    <div class="col-lg-3 col-md-6"> -->
<?php

if (is_dir($_SERVER['DOCUMENT_ROOT'] . $me_chat_config['me_chat_settings']['path']) && is_writable($_SERVER['DOCUMENT_ROOT'] . $me_chat_config['me_chat_settings']['path'] . 'config.json')):

?>
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-folder fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">OK</div>
                                        <div>meChat Path</div>
                                    </div>
                                </div>
                            </div>
                            <a href="installer.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View configurations</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
<?php else: ?>
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-folder fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">FAIL</div>
                                        <div>meChat Path</div>
                                    </div>
                                </div>
                            </div>
                            <a href="installer.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View configurations</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
<?php endif; ?>
                    </div>
                    <div class="col-lg-3 col-md-6">
<?php

if (is_dir($_SERVER['DOCUMENT_ROOT'] . $me_chat_config['me_chat_imageupload']['path']) && is_writable($_SERVER['DOCUMENT_ROOT'] . $me_chat_config['me_chat_imageupload']['path'])):

?>
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-image fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">OK</div>
                                        <div>Image upload</div>
                                    </div>
                                </div>
                            </div>
                            <a href="config.php?imageupload">
                                <div class="panel-footer">
                                    <span class="pull-left">View configurations</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
<?php else: ?>
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-image fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">FAIL</div>
                                        <div>Image upload</div>
                                    </div>
                                </div>
                            </div>
                            <a href="config.php?imageupload">
                                <div class="panel-footer">
                                    <span class="pull-left">View configurations</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
<?php endif; ?>
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

</body>

</html>
