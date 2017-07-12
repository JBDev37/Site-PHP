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

$title = ''; // Title

# Selected table
if(empty($_GET) || (empty($_GET) == false && ((key($_GET) == 'users' || key($_GET) == 'usersconnected' || key($_GET) == 'messages' || key($_GET) == 'conversations' || key($_GET) == 'friendships')) == false))
{
    header('Location: index.php');
}
else
{        
    if(key($_GET) == 'users')
    {
        $title = 'Users';
    }
    if(key($_GET) == 'usersconnected')
    {
        $title = 'Users Connected';
    }
    if(key($_GET) == 'messages')
    {
        $title = 'Messages';
    }    
    if(key($_GET) == 'conversations')
    {
        $title = 'Conversations';
    } 
    if(key($_GET) == 'friendships')
    {
        $title = 'Friendships';
    }      
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>meChat Manager - Table: <?=$title?></title>    
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
                            Table: <?=$title?>
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-table"></i> Table: <?=$title?>
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
<div class="col-lg-12">    
    <div class="input-group col-md-4">
        <input type="text" class="form-control me-chat-manager-table-search-input" placeholder="Search for...">
        <br>
        <small>The identifier filter works only in the users table.</small>
    </div> 
    <br>
	<div class="table-responsive">        
		<table class="table table-hover table-striped me-chat-manager-table">
			<thead>
				<tr class="me-chat-manager-table-columns"></tr>
			</thead>
			<tbody class="me-chat-manager-table-rows"></tbody>
            <tfoot>
				<tr class="me-chat-manager-table-columns"></tr>
			</tfoot>
		</table>       
	</div>
    <div class="me-chat-manager-center">
        <ul class="pagination pagination-md">
            <li>
                <a href="#" class="me-chat-manager-table-pager-previous" aria-label="Previous">
                <span aria-hidden="true">Previous</span>
                </a>
            </li>
            <li>
                <a href="#" class="me-chat-manager-table-pager-next" aria-label="Next">
                <span aria-hidden="true">Next</span>
                </a>
            </li>
        </ul>
    </div>     
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
/* Store table properties */        
var tableProperties = {
    table: '<?=key($_GET)?>',
    page: 0,
    max_results: 15,
    search: ''
};

/* Store DOM of the edit modal */
var modalEdit = false;
        
$(document).ready(function()
{
    /* Get table */
    getTable(tableProperties.table, tableProperties.page, tableProperties.max_results, tableProperties.search);
           
    /* Create modal to edit */
    modalEdit = $('<div>').html('\
    <div class="modal fade" role="dialog">\
        <div class="modal-dialog">\
            <div class="modal-content">\
                <div class="modal-header">\
                    <button type="button" class="close" data-dismiss="modal">&times;</button>\
                    <h4 class="modal-title">Edit row</h4>\
                </div>\
                <div class="modal-body">\
                </div>\
                <div class="modal-footer">\
                    <button type="submit" class="btn btn-primary" data-dismiss="modal">Save</button>\
                    <button type="submit" class="btn btn-danger" data-dismiss="modal">Delete</button>\
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>\
                </div>\
            </div>\
        </div>\
    </div>');
    modalEdit = $(modalEdit).find('.modal');
    $('body').append(modalEdit);
});        

/* Filter */
$('.me-chat-manager-table-search-input').keyup(function()
{  
    $('.me-chat-manager-table-columns, .me-chat-manager-table-rows').html('');
    
    tableProperties.page = 0;
    tableProperties.search = $(this).val();
    
    getTable(tableProperties.table, tableProperties.page, tableProperties.max_results, tableProperties.search);
});

/* Next page */        
$('.me-chat-manager-table-pager-next').click(function(event)
{   
    $('.me-chat-manager-table-columns, .me-chat-manager-table-rows').html('');
    
    tableProperties.page++;
    if(tableProperties.page >= 0) $('.me-chat-manager-table-pager-previous').show();
    
    getTable(tableProperties.table, tableProperties.page, tableProperties.max_results, $('.me-chat-manager-table-search-input').val());
    
    event.preventDefault();
});  
        
/* Previous page */        
$('.me-chat-manager-table-pager-previous').click(function(event)
{    
    $('.me-chat-manager-table-columns, .me-chat-manager-table-rows').html('');
    
    tableProperties.page--;
    if(tableProperties.page < 0) $(this).hide();
    
    getTable(tableProperties.table, tableProperties.page, tableProperties.max_results, $('.me-chat-manager-table-search-input').val());
    
    event.preventDefault();
});  
       
/* Get table via AJAX */        
function getTable(table, page, max_results, search)
{
    $.ajax(
    {
        url: 'php/templates/ajax.table.php',
        type: 'POST',
        data: {table: table, page: page, max_results: max_results, search: search},
        error: function()
        {
            alert('FAIL, TRY AGAIN.');
        },
        success: function(data)
        {   
            if(data.length != 0) data = JSON.parse(data);
            
            $(data.columns).each(function(key, value)
            {
                $('<th>').html(value).appendTo(('.me-chat-manager-table .me-chat-manager-table-columns'));
                
                /*
                if((data.columns.length - 1) == key)
                {
                    $('<th>').html('Edit').appendTo(('.me-chat-manager-table .me-chat-manager-table-columns'));
                }
                */
            });
            
            
            $(data.rows).each(function(key, value)
            {
                var tr = $('<tr>').appendTo($('.me-chat-manager-table .me-chat-manager-table-rows'));
                $(tr).data('me-chat-manager-editrow', {key: data.columns, value: value});
                
                $(value).each(function(key, value)
                {
                    $(tr).append($('<td>').html(value));
                });
                
                // $(tr).append($('<td>').html('<button class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></button>'));
            });           
        }
    });        
}
    
/* Show edit modal */
/*
$(document).on('touchstart mousedown', '.me-chat-manager-table tr button', function()
{ 
    var rowData = $(this).closest('tr').data('me-chat-manager-editrow');
    var values = {};
    
    for (var i = 0; i < rowData.value.length; i++)
    { 
        values[rowData.key[i]] = rowData.value[i];
    }
    
    for (var key in values)
    {
        if (values.hasOwnProperty(key))
        {
            console.log(key);
            
            $('<div class="form-group">').html('\
<div class="form-group">\
    <label>'+ key +'</label>\
    <input type="text" class="form-control" value="'+ values[key] +'">\
</div>').appendTo($(modalEdit).find('.modal-body'));
        }
    }
                      
    $(modalEdit).modal(
    {
        show: true
    });
});
*/    
    </script>
    
</body>

</html>
