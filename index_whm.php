<?
session_start();

include "config/common.inc";
include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "user";
$smenu = "user_login";
$step_next = false;
//======== get step next value if php 5.3 > ============
if(isset($_POST['step_next'])){
 $step_next = $_POST['step_next'];
 //echo $step_next;
} // new code for step_next post
//=========================================
if(!$step_next) {?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Warehouse Management</title>

        <!-- Bootstrap Core CSS -->
        <link href="whm/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Font Awesome CSS -->
        <link href="whm/css/font-awesome.min.css" rel="stylesheet">
		
		<!-- Custom CSS 
        <link href="whm/css/animate.css" rel="stylesheet">-->

        <!-- Custom CSS -->
        <link href="whm/css/style.css" rel="stylesheet">

        <!-- Template js -->
        <script src="whm/js/jquery-2.1.1.min.js"></script>
        <script src="whm/bootstrap/js/bootstrap.min.js"></script>
        <script src="whm/js/jquery.appear.js"></script>
        <script src="whm/js/contact_me.js"></script>
        <script src="whm/js/jqBootstrapValidation.js"></script>
        <script src="whm/js/modernizr.custom.js"></script>
        <script src="whm/js/script.js"></script>

        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>
    
    <body>
        
        
        <!-- Start Main Body Section -->
        <div class="mainbody-section text-center">
            <div class="container">
                <div class="row">
                    
                    <div class="col-md-3">
                        
                        <div class="menu-item blue">
                            <a href="<?=$home?>/wait_whm.php" data-toggle="modal">
                                <i class="fa fa-outdent"></i>
                                <p>Waiting List</p>
                            </a>
                        </div>

                         <div class="menu-item green">
                            <a href="<?=$home?>/packing_whm.php" data-toggle="modal">
                                <i class="fa fa-caret-square-o-down"></i>
                                <p>Packing</p>
                            </a>
                        </div>
                        
                    </div>
                    
                    <div class="col-md-6">
                        

                        <div class="row">
                            <div class="col-md-6">
                                <div class="menu-item color responsive">
                                    <a href="<?=$home?>/local_whm.php" data-toggle="modal">
                                        <i class="fa fa-sort-amount-desc"></i>
                                        <p>Local</p>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="menu-item light-orange responsive-2">
                                    <a href="<?=$home?>/return_whm.php" data-toggle="modal">
                                        <i class="fa fa-reply"></i>
                                        <p>Return</p>
                                    </a>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                    
                    <div class="col-md-3">
                        
                        <div class="menu-item light-red">
                            <a href="<?=$home?>/others_whm.php" data-toggle="modal">
                                <i class="fa fa-sign-out"></i>
                                <p>Others</p>
                            </a>
                        </div>
                   
                        
                    </div>
                </div>
            </div>
        </div>
        <!-- End Main Body Section -->
        
    </body>
    
</html>

<?}?>