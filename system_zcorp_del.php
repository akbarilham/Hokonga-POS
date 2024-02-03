<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_zcorp";

if(!$step_next) {
?>


<!DOCTYPE html>
<html lang="<?=$lang?>">
  <head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FEEL BUY, ikbiz, Bootstrap, Responsive, Youngkay">
    <link rel="shortcut icon" href="img/favicon.ico">

    <title><?=$web_erp_name?></title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="css/table-responsive.css" rel="stylesheet" />
      <!--right slidebar-->
      <link href="css/slidebars.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>



<section id="container" class="">
      
	<? include "header.inc"; ?>
	  
    <!--main content start-->
	<section id="main-content">
 
 
<?
$query = "SELECT uid,branch_code,branch_name,branch_type,ceo_name,email,homepage,phone1,phone2,phone_fax,
          phone_cell,addr1,addr2,zipcode,userlevel,signdate,memo,img1,prd_code FROM client_branch WHERE uid = '$uid'";

$result = mysql_query($query);
if(!$result) {      
   error("QUERY_ERROR");
   exit;
}
   $row = mysql_fetch_object($result);

$user_uid = $row->uid;
$branch_code = $row->branch_code;
$branch_name = $row->branch_name;
$branch_type = $row->branch_type;
$ceo_name = $row->ceo_name;
$email = $row->email;
$homepage = $row->homepage;
$phone1 = $row->phone1;
$phone2 = $row->phone2;
$phone_fax = $row->phone_fax;
$phone_cell = $row->phone_cell;
$addr1 = $row->addr1;
$addr2 = $row->addr2;
$zipcode = $row->zipcode;
$userlevel = $row->userlevel;
$signdate = $row->signdate;
  if($lang == "ko") {
    $signdates = date("Y/m/d, H:i:s",$signdate);	
  } else {
    $signdates = date("d-m-Y, H:i:s",$signdate);	
  }
$memo = $row->memo;
$photo1 = $row->img1;
$prd_code = $row->prd_code;

if($prd_code == "1") {
  $prd_code_chk = "checked";
} else {
  $prd_code_chk = "";
}

$savedir = "user_file";
?>

        
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            Delete Corporate Account
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" ENCTYPE="multipart/form-data" action="system_zcorp_del.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='user_uid' value='<?=$user_uid?>'>
								<input type='hidden' name='user_branch_code' value='<?=$branch_code?>'>
								<input type='hidden' name='org_photo1' value='<?=$photo1?>'>
								
                                    									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Corporate Code</label>
                                        <div class="col-sm-2">
                                            <input readonly class="form-control" id="cname" name="dis_branch_code" value="<?=$branch_code?>" type="text" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Corporate Name</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="branch_name" value="<?=$branch_name?>" type="text" required />
                                        </div>
                                    </div>
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Corporate Executive</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="ceo_name" value="<?=$ceo_name?>" type="text" />
                                        </div>
                                    </div>
									
									
                                    <div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_06?></label>
                                        <div class="col-sm-4">
                                            <input readonly class="form-control" id="signdate" name="signdate" value="<?=$signdates?>" type="text" />
                                        </div>
										<div class="col-sm-5"></div>
                                    </div>
											
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <input class="btn btn-primary" type="submit" value="<?=$txt_comm_frm08?>">
                                        </div>
                                    </div>
                                </form>
                            </div>
							
        </div>
        </section>
		</div>
		</div>
		</div>
						
						
						
    
    
	<? include "right_slidebar.inc"; ?>
	  
	<? include "footer.inc"; ?>

</section>


	<!-- js placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/respond.min.js" ></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>

  <!--right slidebar-->
  <script src="js/slidebars.min.js"></script>

    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>


  </body>

</html>

<?
} else if($step_next == "permit_okay") {


	$savedir = "user_file";

  $query  = "DELETE FROM client_branch WHERE uid = '$user_uid'"; 
  $result = mysql_query($query);
  if(!$result) { error("QUERY_ERROR"); exit; }
  
  // 계정 항목을 위한 필드 삭제
  $queryT = "ALTER TABLE code_acc_list DROP $user_branch_code";
  $resultT = mysql_query($queryT);
  if(!$resultT) { error("QUERY_ERROR"); exit; }


  echo("<meta http-equiv='Refresh' content='0; URL=$home/system_zcorp.php'>");
  exit;
  
}

}
?>