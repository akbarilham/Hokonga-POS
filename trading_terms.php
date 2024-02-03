<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "crm";
$smenu = "crm_member";

GLOBAL $uids;

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
	
	<script type="text/JavaScript">
	<!--
	function MM_jumpMenu(targ,selObj,restore){ //v3.0
		eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
		if (restore) selObj.selectedIndex=0;
	}
	//-->
	</script>

  </head>



<section id="container" class="">
      
	  <? include "header.inc"; ?>
	  
      <!--main content start-->
      <section id="main-content">
 
<?
$uid = $_GET['uid'];
$tt_uid = $_GET['tt_uid'];
$query = "SELECT uid,branch_code,corp_nickname FROM member_main WHERE uid = '$uid'";
$result = mysql_query($query);
if(!$result) {      
   error("QUERY_ERROR");
   exit;
}
$row = mysql_fetch_object($result);

$uid2 = $row->uid;
$tt_branch_code = $row->branch_code;
$tt_corp_nickname = $row->corp_nickname;

$query_TT = "SELECT uid,tt_uid,years,regular_discount,fixed_rebate,promotion_support,
            conditional_rebate,common_assortment,opening_costs,listing_fee,season_discount,
            post_date,last_ip,audit FROM trading_terms WHERE uid = '$uid2' AND tt_uid = '$tt_uid' ";
$result_TT = mysql_query($query_TT);
if (!$result_TT) { error("QUERY_ERROR"); exit; }

$uids = @mysql_result($result_TT,0,0);
$tt_uids = @mysql_result($result_TT,0,1);
$years = @mysql_result($result_TT,0,2);
$regular_discount = @mysql_result($result_TT,0,3);
$fixed_rebate = @mysql_result($result_TT,0,4);
$promotion_support = @mysql_result($result_TT,0,5);
$conditional_rebate = @mysql_result($result_TT,0,6);
$common_assortment = @mysql_result($result_TT,0,7);
$opening_costs = @mysql_result($result_TT,0,8);
$listing_fee = @mysql_result($result_TT,0,9);
$season_discount = @mysql_result($result_TT,0,10);
$post_date = @mysql_result($result_TT,0,11);
$last_ip = @mysql_result($result_TT,0,12);
$audit = @mysql_result($result_TT,0,13);
?>

        
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$txt_stf_member_03?>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                <form class="cmxform form-horizontal adminex-form" name="tradingtermsupd" method="post" action="trading_terms.php?uid=<?=$uid2?>&tt_uid=<?=$tt_uid?>&page=<?=$page?>">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='staff_uid' value='<?=$staff_uid?>'>
								<input type='hidden' name='org_name' value='<?=$user_name?>'>
								<input type='hidden' name='sorting_key' value='<?=$sorting_key?>'>
								<input type='hidden' name='keyfield' value='<?=$keyfield?>'>
								<input type='hidden' name='key' value='<?=$key?>'>
								<input type='hidden' name='page' value='<?=$page?>'>
								<input type='hidden' name='mb_level' value='<?=$mb_level?>'>
								<input type='hidden' name='mb_type' value='<?=$mb_type?>'>

                <div class="form-group ">
                    <label for="cname" class="control-label col-sm-3">Years</label>
                    <div class="col-sm-9">
                  
                    <?
                    // Time declaration
                    $current = time();
                    $ye_current = date('Y',$current);
                    $ye_begin = "2013";
                    $ye_using = $ye_current - $ye_begin; // total pengurangan

                    // Link for year
                    echo("<select name='years' class='form-control' onChange=\"MM_jumpMenu('parent',this,0)\">");
                    echo("<option value='' $slc_brc>:: Select Years</option>");
                    for ($k=1; $k <= $ye_using; $k++) { 
                    $ye_using_plus = $ye_begin + $k; //looping tahunan

                      if($years == $ye_using_plus || $tt_uid == $k) {
                        $slc_brc = "selected";
                      } else {
                        $slc_brc = "";
                      }
                      echo("<option value='$PHP_SELF?uid=$uid&tt_uid=$k&page=$page' $slc_brc>$ye_using_plus</option>");

                    }
                    echo("</select>");
                    ?>

                    <?
                    // Pass year value based on tt_uid
                    for ($k=1; $k <= $ye_using; $k++) { 
                    $ye_using_plus = $ye_begin + $k; //looping tahunan                      
                        if($tt_uid == $k){
                          echo("<input type='hidden' name='years' value='$ye_using_plus' class='form-control' />");
                        }
                    }                    
                    ?>                    
                      </div>
                </div>
            

                  <div class="form-group ">
                      <label for="cname" class="control-label col-sm-3"><?=$txt_comm_frm23?></label>
                      <div class="col-sm-9">
										
											<?
											if($now_group_admin == "1" OR $login_level > "3") {
												$queryE = "SELECT count(uid) FROM client_branch";
											} else {
												$queryE = "SELECT count(uid) FROM client_branch WHERE branch_code = '$login_branch'";
											}
											$resultE = mysql_query($queryE);
											$total_recordE = mysql_result($resultE,0,0);

											if($now_group_admin == "1" OR $login_level > "3") {
												$queryF = "SELECT branch_code,branch_name FROM client_branch ORDER BY branch_code ASC";
											} else {
												$queryF = "SELECT branch_code,branch_name FROM client_branch WHERE branch_code = '$tt_branch_code' ORDER BY branch_code ASC";
											}
											$resultF = mysql_query($queryF);

											echo("<select name='corporate' class='form-control'>");
											if($now_group_admin == "1" OR $login_level > "3") {
												echo("<option value='$PHP_SELF'>:: $txt_comm_frm32</option>");
											}

											for($i = 0; $i < $total_recordE; $i++) {
												$branch_code = mysql_result($resultF,$i,0);
												$branch_name = mysql_result($resultF,$i,1);

												if($branch_code == $tt_branch_code) {
													$slc_brc = "selected";
												} else {
													$slc_brc = "";
												}
        
												echo("<option value='$branch_code' $slc_brc>[$branch_code] $branch_name</option>");
											}
											echo("</select>");
											?>
											
                      </div>
                  </div>
									
									<div class="form-group ">
                      <label for="cname" class="control-label col-sm-3">Nickname</label>
                      <div class="col-sm-9">
                          <input class="form-control" id="cname" name="nickname" value="<?=$tt_corp_nickname?>" type="text" required />
                      </div>
                  </div>              

                  <div class="form-group ">
                      <label for="cname" class="control-label col-sm-3">Regular Discount</label>
                      <div class="col-sm-3">
                          <input class="form-control" id="cname" name="regular_discount" value="<?=$regular_discount?>" type="text" style="text-align: center"/>
                      </div>
                      <div class="col-sm-4">
                        <div>%</div> 
                      </div>                     
                  </div>

									<div class="form-group ">
                      <label for="cname" class="control-label col-sm-3">Fixed Rebate</label>
                      <div class="col-sm-3">
                          <input class="form-control" id="cname" name="fixed_rebate" value="<?=$fixed_rebate?>" type="text" style="text-align: center"/>
                      </div>
                      <div class="col-sm-4">
                        <div>%</div>                      
                      </div>
                  </div>

                  <div class="form-group ">
                      <label for="cname" class="control-label col-sm-3">Promotion Support</label>
                      <div class="col-sm-3">
                          <input class="form-control" id="cname" name="promotion_support" value="<?=$promotion_support?>" type="text" style="text-align: center"/>
                      </div>
                      <div class="col-sm-4">
                        <div>%</div>   
                      </div>                   
                  </div>
									
									<div class="form-group ">
                      <label for="cname" class="control-label col-sm-3">Conditional Rebate</label>
                      <div class="col-sm-3">
                          <input class="form-control" id="cname" name="conditional_rebate" value="<?=$conditional_rebate?>" type="text" style="text-align: center"/>
                      </div>
                      <div class="col-sm-4">
                        <div>%</div> 
                      </div>                     
                  </div>
									
                  <div class="form-group ">
                      <label for="cname" class="control-label col-sm-3">Common Assortment</label>
                      <div class="col-sm-3">
                        <?
                        $ca_query0 = "SELECT count(uid) FROM trading_terms_common";
                        $ca_result0 = mysql_query($ca_query0);
                        $ca_total = mysql_result($ca_result0,0,0);   

                        echo("<select name='common_assortment' class='form-control'>");
                          
                          echo("<option value='' $slc_brc>:: Select Common Assortment</option>");

                        for ($i=0; $i <$ca_total ; $i++) { 

                          $ca_query = "SELECT * FROM trading_terms_common";
                          $ca_result = mysql_query($ca_query);
                          $ca_num = mysql_result($ca_result,$i,0);
                          $ca_list = mysql_result($ca_result,$i,1);

                          if($ca_list == $common_assortment) {
                            $slc_brc = "selected";
                          } else {
                            $slc_brc = "";
                          }

                          echo("<option value='$ca_list' $slc_brc>Lock & Lock $ca_list</option>");
                        }

                        echo("</select>");
                        ?>
                      </div>          
                  </div>
									
									<div class="form-group ">
                      <label for="cname" class="control-label col-sm-3">iOpening Costs</label>
                      <div class="col-sm-3">
                          <input class="form-control" id="ctel" name="opening_costs" value="<?=$opening_costs?>" maxlength="60" type="tel" style="text-align: center"/>
                      </div>
                      <div class="col-sm-4">
                        <div>%</div>                      
                      </div>
                  </div>
									
									<div class="form-group ">
                      <label for="cname" class="control-label col-sm-3">Listing Fee</label>
                      <div class="col-sm-3">
                          <input class="form-control" id="ctel" name="listing_fee" value="<?=$listing_fee?>" maxlength="60" type="tel" style="text-align: center"/>
                      </div>
                      <div class="col-sm-4">
                        <div>%</div>                      
                      </div>
                  </div>
									
									<div class="form-group ">
                      <label for="cname" class="control-label col-sm-3">Season Discount</label>
                      <div class="col-sm-3">
                          <input class="form-control" id="ctel" name="season_discount" value="<?=$season_discount?>" maxlength="60" type="tel" style="text-align: center"/>
                      </div>
                      <div class="col-sm-4">
                        <div>%</div>                      
                      </div>
                  </div>
									
									
                  <div class="form-group ">
                      <label for="cname" class="control-label col-sm-3"><?=$txt_sys_client_06?></label>
                      <div class="col-sm-4">
                          <input readonly class="form-control" id="signdate" name="post_date" value="<?=$post_date?>" type="text" />
                  </div>

									<div class="col-sm-1" align=right>IP</div>
										<div class="col-sm-4">
                        <input readonly class="form-control" id="cname" name="m_ip" value="<?echo("$m_ip")?>" type="text" />
                    </div>
                  </div>
											
                  <div class="form-group">
                      <div class="col-sm-offset-3 col-sm-9">
                          <input class="btn btn-primary" type="submit" value="<?=$txt_comm_frm05?>">
                          <input class="btn btn-default" type="reset" value="<?=$txt_comm_frm07?>">
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

$uid = $_GET['uid'];
$tt_uid = $_GET['tt_uid'];

$query = "SELECT uid FROM member_main WHERE uid = '$uid'";
$result = mysql_query($query);
if(!$result) {      
   error("QUERY_ERROR");
   exit;
}
$row = mysql_fetch_object($result);

$uid2 = $row->uid;

  $query_TT = "SELECT uid,tt_uid,audit FROM trading_terms WHERE uid = '$uid2' AND tt_uid = '$tt_uid'";
  $result_TT = mysql_query($query_TT);
  if (!$result_TT) { error("QUERY_ERROR"); exit; }

  $uids = @mysql_result($result_TT,0,0);
  $tt_uids = @mysql_result($result_TT,0,1);
  $audits = @mysql_result($result_TT,0,2);

  $post_date = time();
  $m_ip = getenv('REMOTE_ADDR');

  if($uids == '' OR $audits == '') {
    //var_dump($audits);
    $query_M0 = "INSERT INTO trading_terms (uid,tt_uid,years,regular_discount,fixed_rebate,promotion_support,conditional_rebate,common_assortment,opening_costs,listing_fee,season_discount,post_date,last_ip,audit) VALUES ('$uid2','$tt_uid','$years','$regular_discount','$fixed_rebate','$promotion_support','$conditional_rebate','$common_assortment','$opening_costs','$listing_fee','$season_discount','$post_date','$last_ip','1')";
   //var_dump($query_M0); die();
    $result_M0 = mysql_query($query_M0);
    if (!$result_M0) { error("QUERY_ERROR"); exit; }
  
  } else {

    // 정보 변경
    $query_M1  = "UPDATE trading_terms SET tt_uid = '$tt_uid', years = '$years', regular_discount = '$regular_discount', fixed_rebate = '$fixed_rebate', promotion_support = '$promotion_support', conditional_rebate = '$conditional_rebate', common_assortment = '$common_assortment', opening_costs = '$opening_costs', listing_fee = '$listing_fee', season_discount = '$season_discount', post_date = '$post_date', last_ip = '$m_ip', audit = '1' WHERE uid = '$uids' AND tt_uid = '$tt_uid'";
    //var_dump($query_M1); die();
    $result_M1 = mysql_query($query_M1);
    if (!$result_M1) { error("QUERY_ERROR"); exit; }

  }

  echo("<meta http-equiv='Refresh' content='0; URL=$home/crm_member.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page&mb_level=$mb_level&mb_type=$mb_type'>");
  exit;
  

}

}
?>
