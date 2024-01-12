<?php
session_start();
//session_destroy();
//echo "<pre>";
//print_r($_SESSION['user']);
//unset($_SESSION['user'][0]);
if(isset($_GET['delkey']))
{    
    $key = base64_decode($_GET['delkey']);
    unset($_SESSION['user'][$key]);
    $newarr = array_filter($_SESSION['user']);
    $_SESSION['user'] = array_values($newarr);

    //session_destroy();
    header("Location: index.php");
    exit();
    
}
if(isset($_GET['mode']) && $_GET['mode']=='reset')
{
    session_destroy();
    header("Location: index.php");

    $files = glob('profile/*');  
    foreach($files as $file) { 
    
        if(is_file($file))
        {
            unlink($file);
        }   
             
    }
}



?>
<html>
    <head>    
        <title>Exam</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        <link rel="stylesheet" href="assets/css/bootstrap.css">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

        <style>
            .container { margin: 50px auto; max-width: 960px; }
            table thead th {
            cursor: pointer;
            }

            table thead th.nosort {
            cursor: initial;
            }

            .table_sortable thead th:after {
                display: inline-block;
                padding: 0 .25rem;
            }

            .table_sortable thead th.desc:after {
                content: '↑';
            }

            .table_sortable thead th.asc:after {
                content: '↓';
            }
            .showimagediv {
                display: none;

            }
            .medium{
                height:200px;
            }

        </style>

    </head>
    <body>

    <div class="container">
        <div class="row">
            <div class="col-lg-10">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" id="addUser">
                Add User
                </button>
            </div>
            <div class="col-lg-2">
                <?=(isset($_SESSION['user'])) ? '<a href="index.php?mode=reset">Delete All</a>' : '';?>                
            </div>
        </div>    
        <div class="row">
            <div class="col-lg-12">
                <div class="main-box clearfix">
                    <div class="table-responsive">
                        <table id="myTable" class="table user-list">
                            <thead>
                                <tr>
                                    <!--<th><span>User</span></th>
                                    <th><span>Created</span></th>
                                    <th class="text-center"><span>Status</span></th>
                                    <th><span>Email</span></th>
                                    <th>&nbsp;</th>-->
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th class="nosort" title="nosort">Image</th>
                                    <th class="nosort" title="nosort">Address</th>
                                    <th class="nosort" title="nosort">Gender</th>
                                    <th class="nosort" title="nosort">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(isset($_SESSION['user']) && !empty($_SESSION['user']))
                                {
                                    foreach($_SESSION['user'] as $key=>$value)
                                    {
                                        $encoded_key = base64_encode($key);
                                        ?>
                                        <tr>
                                            <td><?=$key+1;?></td>
                                            <td><?=($value['name'] != '') ? $value['name'] : '';?></td>
                                            <td>
                                                <?php
                                                if(isset($value['image']))
                                                {
                                                ?>
                                                    <img src="<?=($value['image'] != '') ? $value['image'] : '';?>" alt="">
                                                    <span class="user-subhead"><a class="gallerythumbnail" data-id="<?=$key+1;?>" data-img="<?=($value['image'] != '') ? $value['image'] : '';?>">Preview</a></span>
                                                    <span class="showimagediv"></span>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                            <td><?=($value['address'] != '') ? $value['address'] : '';?></td>
                                            <td><?=($value['gender'] != '') ? $value['gender'] : '';?></td>
                                            <td style="width: 20%;">
                                                <a href="javascript:void(0);" class="table-link" data-id="<?=$key?>" data-mode="view">
                                                    <span class="fa-stack">
                                                        <i class="fa fa-square fa-stack-2x"></i>
                                                        <i class="fa fa-search-plus fa-stack-1x fa-inverse"></i>
                                                    </span>
                                                </a>
                                                <a href="javascript:void(0);" class="table-link" data-id="<?=$key?>" data-mode="edit">
                                                    <span class="fa-stack">
                                                        <i class="fa fa-square fa-stack-2x"></i>
                                                        <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                                    </span>
                                                </a>
                                                <a href="index.php?delkey=<?=$encoded_key?>" class="table-link danger">
                                                    <span class="fa-stack">
                                                        <i class="fa fa-square fa-stack-2x"></i>
                                                        <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                                                    </span>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php

                                    }
                                
                                }
                                else
                                {
                                    echo '<tr><td colspan="6">No Data Found!</td></tr>';
                                }
                                ?>
                                
                                
                            </tbody>
                        </table>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
    <!-- Modal start-->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="registrationForm" method="post" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="form-group mb-3">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name"  placeholder="Enter Name" required>       
                        </div>
                        <div class="form-group mb-3">
                            <label for="image">Image</label><br>
                            <input type="file" class="form-control-file" id="image" name="image" required>     
                            <span class="showimageform"></span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" rows="3" name="address"></textarea>      
                        </div>
                       
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="male" value="male" checked>
                            <label class="form-check-label" for="male">
                               Male
                            </label>
                            </div>
                            <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                            <label class="form-check-label" for="female">
                                Female
                            </label>
                        </div>
                        <input type="hidden" name="key_id" id="key_id"/>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal end-->


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/jquery-tablesortable"></script>
    <script>
    $('#myTable').tableSortable();
    </script>

    <script>
        $(document).ready(function() {

            $("#registrationForm").submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: 'process.php',
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        //$('#exampleModal').modal('toggle');
                        location.reload();
                        //$("#registrationForm").trigger("reset");
                       // $('.showimageform').html('');
                        //$('.modal-footer').show();
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });

            $('.gallerythumbnail').on('click', function() {
                $('.showimagediv').html('').hide();
                if($(this).attr("data-img") !='')
                {
                    var img = $('<img />', {
                            src     : $(this).attr("data-img"),
                            'class' : 'medium'
                        });
                }
                else
                {
                    var img = '';
                }
                
                // $(this).next('.showimagediv').show();
                $(this).closest('tr').find('.showimagediv').html(img).show();
                //$('.showimagediv').html(img).show();

            });

            
            $('.table-link').on('click', function(event){
                var id = $(this).attr("data-id");
                var mode = $(this).attr("data-mode");
                $('.showimageform').html('');
                var sendData = {'mode':mode,'id':id};

                $.ajax({
                    url: 'process.php',
                    type: 'POST',
                    dataType: "json",
                    data: {sendData:sendData},
                    success: function (response) {
         
                        //$('#exampleModal').modal('toggle');
                        //location.reload();
                        $('#name').val(response.name);
                        $('#address').val(response.address);
                        var img = $('<img />', {
                            src     : response.image,
                            'class' : 'medium'
                        });

                        $('.showimageform').html(img);
                        
                        $('#'+response.gender).prop("checked", true); 
                        if(mode == 'view')
                        {
                            $('#exampleModalLabel').text('View');
                            $('.modal-footer').hide();
                        }
                        else if(mode == 'edit')
                        {
                            $('#key_id').val(response.key);
                            $('#exampleModalLabel').text('Edit');
                            $('.modal-footer').show();
                        }
                        else
                        {
                            $('#exampleModalLabel').text('Form');
                            $('.modal-footer').show();
                        }
                        
                        $('#exampleModal').modal('toggle');
                    },

                });


                
            });
            
            $('#addUser').on('click', function() {
                $("#registrationForm").trigger("reset");
                $('.showimageform').html('');
                $('.modal-footer').show();
            });
        
        });

       
    </script>
    </body>
</html>