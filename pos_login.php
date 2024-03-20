<?php
session_start();

include "config/common.php";
include "config/dbconn.php";
include "config/text_main_{$lang}.php";
include "config/user_functions_{$lang}.php";

$mmenu = "user";
$smenu = "user_login";
$step_next = false;
//======== get step next value if php 5.3 > ============
if(isset($_POST['step_next'])){
 $step_next = $_POST['step_next'];
 //echo $step_next;
} // new code for step_next post
//=========================================
if(!$step_next) {

$query_logo = "SELECT img1 FROM client_branch WHERE branch_code = 'CORP_01'";
$result_logo = mysqli_query($dbconn, $query_logo);
if(!$result_logo) { error("QUERY_ERROR"); exit; }
   $row_logo = mysql_fetch_object($result_logo);

$logo_file = $row_logo->img1;

?>

<!DOCTYPE html>
<html lang="<?php echo $lang?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FEEL BUY, ikbiz, Bootstrap, Responsive, Youngkay">
    <link rel="shortcut icon" href="img/favicon.ico">

    <title><?php echo $web_erp_name?></title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

  <body class="login-body">

    <div class="container">

      <form class="form-signin" method="post" action="pos_login.php">
	  <input type="hidden" name="step_next" value="permit_okay">
	  
        <h2 class="form-signin-heading">sign in now</h2>
        <div class="login-wrap">
            <input type="text" name="new_id" class="form-control" placeholder="User ID" autofocus>
            <input type="password" name="new_pwd" class="form-control" placeholder="Password">
            <label class="checkbox">
                <input type="checkbox" value="remember-me"> Remember me
                <span class="pull-right">
                    <a data-toggle="modal" href="#myModal"> Forgot Password?</a>

                </span>
            </label>
            <button class="btn btn-lg btn-login btn-block" type="submit">Sign in</button>
        </div>
	  </form>

          <!-- Modal -->
          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title">Forgot Password ?</h4>
                      </div>
                      <div class="modal-body">
                          <p>Enter your e-mail address below to reset your password.</p>
                          <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">

                      </div>
                      <div class="modal-footer">
                          <button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>
                          <button class="btn btn-success" type="button">Submit</button>
                      </div>
                  </div>
              </div>
          </div>
          <!-- modal -->


    </div>



    <!-- js placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>


  </body>
</html>

<?php
} else if($step_next == "permit_okay") {

    $new_id = $_POST['new_id'];
    $new_pwd = $_POST['new_pwd'];

	$query1 = "SELECT branch_code,gate,subgate,shop_code,user_pw,user_level,visit,default_lang,user_name,shop_flag,shop_userlevel 
			FROM admin_user WHERE user_id = '$new_id'";
	$result1 = mysqli_query($dbconn, $query1);
	if(!$result1) { error("QUERY_ERROR"); exit; }
	$row1 = mysql_fetch_object($result1);

	$db_branch = $row1->branch_code;
	$db_gate = $row1->gate;
	$db_subgate = $row1->subgate;
	$db_shop_code = $row1->shop_code;
	$db_passwd = $row1->user_pw;
	$db_userlevel = $row1->user_level;
	$cnt_visit = $row1->visit;
	$db_lang = $row1->default_lang;
	$db_user_name = $row1->user_name;
	$db_shop_flag = $row1->shop_flag; // 0=non-shop, 1=associate store, 2=branch shop
	$db_shop_userlevel = $row1->shop_userlevel; // 1=new, 2=cashier, 3=head cashier, 4=store manager
   

	// change Input-Word into Password
	$result2 = mysqli_query($dbconn, "SELECT old_password('$new_pwd')"); // login with old_password; because different mysql version
	$user_passwd2 = mysql_result($result2,0,0);
    if(strcmp($db_passwd,$user_passwd2)) {      
        error("LOGIN_INVALID_PW");
        exit;
    } else {

        $signdate = time();
        $m_ip = getenv('REMOTE_ADDR');
        
        $cnt_visit = $cnt_visit + 1;	
        $resultV = mysqli_query($dbconn, "UPDATE admin_user SET visit = $cnt_visit, log_in = $signdate, log_ip = '$m_ip' WHERE user_id = '$new_id'");
        if(!$resultV) { error("QUERY_ERROR"); exit; }
    

    //session_start();
    $login_id = "$new_id";
    $login_level = "$db_userlevel";
    $login_branch = "$db_branch";
    $login_gate = "$db_gate";
    $login_subgate = "$db_subgate";
    $login_shop = "$db_shop_code";
    $login_ip = "$m_ip";
    $login_user_name = "$db_user_name";
    $login_shop_flag = "$db_shop_flag";
    $login_shop_userlevel = "$db_shop_userlevel";
    
    
    SetCookie("login_id",$login_id,0,"/");
    SetCookie("login_level",$login_level,0,"/");
    SetCookie("login_branch",$login_branch,0,"/");
    SetCookie("login_gate",$login_gate,0,"/");
    SetCookie("login_subgate",$login_subgate,0,"/");
    SetCookie("login_shop",$login_shop,0,"/");
    SetCookie("login_ip",$login_ip,0,"/"); 
    SetCookie("loco",$loco,0,"/");
    SetCookie("login_user_name",$login_user_name,0,"/");
    SetCookie("login_shop_flag",$login_shop_flag,0,"/");
    SetCookie("login_shop_userlevel",$login_shop_userlevel,0,"/");

        
    echo ("<meta http-equiv='Refresh' content='0; URL=pos.php'>");

    }

}
?>