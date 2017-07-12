<?php

include_once('php/config.php');
include_once('php/functions.php');

?>
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
                        <a href="table.php?users"><i class="fa fa-fw fa-users"></i> Users <span class="label label-primary"><?=meChat_CountUsers()?></span></a>
                    </li>
                    <li>
                        <a href="table.php?usersconnected"><i class="fa fa-fw fa-child"></i> Users connected <span class="label label-primary"><?=meChat_CountRecentUsers(5)?></span></a>
                    </li>
                    <li>
                        <a href="table.php?messages"><i class="fa fa-fw fa-comment"></i> Messages <span class="label label-primary"><?=meChat_CountMessages()?></span></a>
                    </li>
                    <li>
                        <a href="table.php?conversations"><i class="fa fa-fw fa-comments"></i> Conversations <span class="label label-primary"><?=meChat_CountConversations()?></span></a>
                    </li>
                    <li>
                        <a href="table.php?friendships"><i class="fa fa-fw fa-globe"></i> Friendships <span class="label label-primary"><?=meChat_CountFriendships()?></span></a>
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