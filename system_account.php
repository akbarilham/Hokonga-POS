<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_account";

$link_list = "$home/system_account.php";

$query_AC = "SELECT count(uid) FROM code_acc_catg WHERE f_class = 'in'";
$result_AC = mysql_query($query_AC);
if (!$result_AC) { error("QUERY_ERROR"); exit; }
// $total_AC = @mysql_result($result_AC,0,0);
$total_AC = 2;

$query_BC = "SELECT count(uid) FROM code_acc_catg WHERE f_class = 'out'";
$result_BC = mysql_query($query_BC);
if (!$result_BC) { error("QUERY_ERROR"); exit; }
$total_BC = @mysql_result($result_BC,0,0);
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
        
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$hsm_name_09_13?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
	
		
		
<section id="unseen">
<?
echo ("
<table width=100%>
<tr>
  <td height=22 width=45%>");
    
      $queryC = "SELECT count(uid) FROM client_branch WHERE userlevel > '0'";
      $resultC = mysql_query($queryC);
      $total_recordC = mysql_result($resultC,0,0);

      $queryD = "SELECT branch_code,branch_name FROM client_branch WHERE userlevel > '0' ORDER BY userlevel DESC, branch_code ASC";
      $resultD = mysql_query($queryD);

      echo("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");
      echo("<option value='$PHP_SELF'>:: $txt_comm_frm25</option>");

      for($i = 0; $i < $total_recordC; $i++) {
        $menu_code = mysql_result($resultD,$i,0);
        $menu_name = mysql_result($resultD,$i,1);
        
        if($menu_code == $key) {
          $slc_gate = "selected";
        } else {
          $slc_gate = "";
        }

      echo("<option value='$PHP_SELF?keyfield=branch_code&key=$menu_code' $slc_gate>[ $menu_code ] $menu_name</option>");
      }
      echo("</select>");  
  
  echo ("
  </td>
  <td width=55% align=right>

  </td>
</tr>
<tr><td colspan=2 height=10></td></tr>

<tr><td colspan=2>
<table width=100% class=\"table table-bordered table-striped table-condensed\">
<tr height=22>
   <td colspan=6 bgcolor=#EFEFEF>&nbsp; $txt_sys_account_05</td>
</tr>
");


$query_A = "SELECT uid,f_class,catg FROM code_acc_catg WHERE f_class = 'in' ORDER BY catg ASC";
$result_A = mysql_query($query_A);
if (!$result_A) {   error("QUERY_ERROR");   exit; }

for($a = 0; $a < $total_AC; $a++) {
   $fA_uid = mysql_result($result_A,$a,0);
   $fA_class = mysql_result($result_A,$a,1);
   $fA_catg = mysql_result($result_A,$a,2);
   
   $fA_catg_txt = "txt_sys_account_05_"."$fA_catg";

  echo("<tr height=22>");
  echo("<td width=10% bgcolor=#FFFFFF>&nbsp;</td>");
  echo("<td colspan=5 bgcolor=#FFFFFF>
      <table width=100%  style='margin: -7px'>
      <tr>
        <td width=50%>&nbsp; ($fA_catg) ${$fA_catg_txt}</td>
        <td width=50% align=right>
            <a href='$link_list?mode=add&catg=$fA_catg&keyfield=$keyfield&key=$key'>$txt_sys_account_09</a> &nbsp;
            <i class='fa fa-caret-down'></i> &nbsp;&nbsp; 
        </td>
      </tr>
      </table></td>");
  echo("</tr>");
  
    // 세부 항목 [리스트] - 수정/삭제
    $query_H1C = "SELECT count(uid) FROM code_acc_list WHERE catg = '$fA_catg' AND lang = '$lang'";
    $result_H1C = mysql_query($query_H1C);
    if (!$result_H1C) {   error("QUERY_ERROR");   exit; }
    
    $total_H1C = @mysql_result($result_H1C,0,0);
    
    if($key) {
      $query_H1 = "SELECT uid,acc_code,acc_name,$key FROM code_acc_list 
                WHERE catg = '$fA_catg' AND lang = '$lang' ORDER BY acc_code ASC";
    } else {
      $query_H1 = "SELECT uid,acc_code,acc_name,branch_code FROM code_acc_list 
                WHERE catg = '$fA_catg' AND lang = '$lang' ORDER BY acc_code ASC";
    }
    $result_H1 = mysql_query($query_H1);
    if (!$result_H1) {   error("QUERY_ERROR");   exit; }
    
    for($h1 = 0; $h1 < $total_H1C; $h1++) {
      $H1_acc_uid = mysql_result($result_H1,$h1,0);   
      $H1_acc_code = mysql_result($result_H1,$h1,1);
      $H1_acc_name = mysql_result($result_H1,$h1,2);
      $H1_acc_brcode = mysql_result($result_H1,$h1,3);

      
      // 수정/삭제 버튼 활성화
      if($H1_acc_brcode == "1" OR !$key) {
        $acc_btn_act1 = "";
        $acc_txt_display1 = "<font color=red>v</font>";
      } else {
        $acc_btn_act1 = "disabled";
        $acc_txt_display1 = "";
      }
  
    echo ("
    <tr height=22>
      <form name='act_upd' method='post' action='system_account_act.php'>
      <input type=hidden name='add_mode' value='ACC_UPD'>
      <input type=hidden name='new_class' value='$fA_class'>
      <input type=hidden name='new_catg' value='$fA_catg'>
      <input type=hidden name='new_acc_uid' value='$H1_acc_uid'>
      <input type=hidden name='new_acc_code' value='$H1_acc_code'>
      <input type=hidden name='keyfield' value='$keyfield'>
      <input type=hidden name='key' value='$key'>
      
    
      <td width=10% bgcolor=#FFFFFF>&nbsp;</td>
      <td width=10% bgcolor=#FFFFFF>&nbsp;</td>
      <td width=7% bgcolor=#FFFFFF align=center>$H1_acc_code</td>
      <td width=59% bgcolor=#FFFFFF>&nbsp; <input type=text name='new_acc_name' value='$H1_acc_name' style='WIDTH: 200px'> &nbsp;&nbsp;&nbsp;");
      
      if($H1_acc_brcode == "1") {
        echo ("<input type=checkbox name='new_acc_chk' value='1' checked>");
      } else {
        echo ("<input type=checkbox name='new_acc_chk' value='1'>");
      }
      
      echo ("
      &nbsp;&nbsp;&nbsp; $acc_txt_display1
      </td>
      <td width=7% bgcolor=#FFFFFF align=center><input type=submit value='$txt_comm_frm12' class='btn btn-default btn-sm'></td>
      </form>
      
      <form name='act_del' method='post' action='system_account_act.php'>
      <input type=hidden name='add_mode' value='ACC_DEL'>
      <input type=hidden name='new_class' value='$fA_class'>
      <input type=hidden name='new_catg' value='$fA_catg'>
      <input type=hidden name='new_acc_uid' value='$H1_acc_uid'>
      <input type=hidden name='new_acc_code' value='$H1_acc_code'>
      <input type=hidden name='keyfield' value='$keyfield'>
      <input type=hidden name='key' value='$key'>
      <td width=7% bgcolor=#FFFFFF align=center><input $acc_btn_act1 type=submit value='$txt_comm_frm13' class='btn btn-default btn-sm'></td>
      </form>
    </tr>");
  
    }
  
  // 세부항목 추가 입력란
  if($mode == "add" AND $catg == $fA_catg) {
  
    echo ("
    <form name='act_add' method='post' action='system_account_act.php'>
    <input type=hidden name='add_mode' value='ACC_ADD'>
    <input type=hidden name='new_class' value='$fA_class'>
    <input type=hidden name='new_catg' value='$fA_catg'>
    <input type=hidden name='keyfield' value='$keyfield'>
    <input type=hidden name='key' value='$key'>
    
    <tr height=22>
      <td width=10% bgcolor=#FFFFFF>&nbsp;</td>
      <td width=10% bgcolor=#FFFFFF>&nbsp;</td>
      <td width=7% bgcolor=#FFFFFF align=center>+</td>
      <td width=59% bgcolor=#FFFFFF>&nbsp; <input type=text name='new_acc_name' style='WIDTH: 200px'></td>
      <td colspan=2 width=14% bgcolor=#FFFFFF align=center><input type=submit value='$txt_sys_account_10' class='btn btn-default btn-sm'></td>
    </tr>
    </form>");
  
  
  }
  
  
}




echo ("
</table>
</td></tr>


<tr><td colspan=2 height=10></td></tr>

<!------------ 지출 항목 // --------------------------------------------------->


<tr><td colspan=2>
<table width=100% class=\"table table-bordered table-striped table-condensed\">
<tr height=22>
   <td colspan=6 bgcolor=#EFEFEF>&nbsp; $txt_sys_account_06</td>
</tr>
");


$query_B = "SELECT uid,f_class,catg FROM code_acc_catg WHERE f_class = 'out' ORDER BY catg ASC";
$result_B = mysql_query($query_B);
if (!$result_B) {   error("QUERY_ERROR");   exit; }

for($b = 0; $b < $total_BC; $b++) {
   $fB_uid = mysql_result($result_B,$b,0);
   $fB_class = mysql_result($result_B,$b,1);
   $fB_catg = mysql_result($result_B,$b,2);
   
   $fB_catg_txt = "txt_sys_account_06_"."$fB_catg";

  echo("<tr height=22>");
  echo("<td width=10% bgcolor=#FFFFFF>&nbsp;</td>");
  echo("<td colspan=5 bgcolor=#FFFFFF>
      <table width=100% style='margin: -7px'>
      <tr>
        <td width=50%>&nbsp; ($fB_catg) ${$fB_catg_txt}</td>
        <td width=50% align=right>
            <a href='$link_list?mode=add&catg=$fB_catg&keyfield=$keyfield&key=$key'>$txt_sys_account_09</a> &nbsp;
            <i class='fa fa-caret-down'></i> &nbsp;&nbsp; 
        </td>
      </tr>
      </table></td>");
  echo("</tr>");
  
    // 세부 항목 [리스트] - 수정/삭제
    $query_H2C = "SELECT count(uid) FROM code_acc_list WHERE catg = '$fB_catg' AND lang = '$lang'";
    $result_H2C = mysql_query($query_H2C);
    if (!$result_H2C) {   error("QUERY_ERROR");   exit; }
    
    $total_H2C = @mysql_result($result_H2C,0,0);
    
    if($key) {
      $query_H2 = "SELECT uid,acc_code,acc_name,$key FROM code_acc_list 
                WHERE catg = '$fB_catg' AND lang = '$lang' ORDER BY acc_code ASC";
    } else {
      $query_H2 = "SELECT uid,acc_code,acc_name,branch_code FROM code_acc_list 
                WHERE catg = '$fB_catg' AND lang = '$lang' ORDER BY acc_code ASC";
    }
    $result_H2 = mysql_query($query_H2);
    if (!$result_H2) {   error("QUERY_ERROR");   exit; }
    
    for($h2 = 0; $h2 < $total_H2C; $h2++) {
      $H2_acc_uid = mysql_result($result_H2,$h2,0);   
      $H2_acc_code = mysql_result($result_H2,$h2,1);
      $H2_acc_name = mysql_result($result_H2,$h2,2);
      $H2_acc_brcode = mysql_result($result_H2,$h2,3);
      
      // 수정/삭제 버튼 활성화
      if($H2_acc_brcode == "1" OR !$key) {
        $acc_btn_act2 = "";
        $acc_txt_display2 = "<font color=red>v</font>";
      } else {
        $acc_btn_act2 = "disabled";
        $acc_txt_display2 = "";
      }
  
    echo ("
    <tr height=22>
      <form name='act_updB' method='post' action='system_account_act.php'>
      <input type=hidden name='add_mode' value='ACC_UPD'>
      <input type=hidden name='new_class' value='$fB_class'>
      <input type=hidden name='new_catg' value='$fB_catg'>
      <input type=hidden name='new_acc_uid' value='$H2_acc_uid'>
      <input type=hidden name='new_acc_code' value='$H2_acc_code'>
      <input type=hidden name='keyfield' value='$keyfield'>
      <input type=hidden name='key' value='$key'>
    
      <td width=10% bgcolor=#FFFFFF>&nbsp;</td>
      <td width=10% bgcolor=#FFFFFF>&nbsp;</td>
      <td width=7% bgcolor=#FFFFFF align=center>$H2_acc_code</td>
      <td width=59% bgcolor=#FFFFFF>&nbsp; <input type=text name='new_acc_name' value='$H2_acc_name' style='WIDTH: 200px'> &nbsp;&nbsp;&nbsp;");
      
      if($H2_acc_brcode == "1") {
        echo ("<input type=checkbox name='new_acc_chk' value='1' checked>");
      } else {
        echo ("<input type=checkbox name='new_acc_chk' value='1'>");
      }
      
      echo ("
      &nbsp;&nbsp;&nbsp; $acc_txt_display2
      </td>
      <td width=7% bgcolor=#FFFFFF align=center><input type=submit value='$txt_comm_frm12' class='btn btn-default btn-sm'></td>
      </form>
      
      <form name='act_delB' method='post' action='system_account_act.php'>
      <input type=hidden name='add_mode' value='ACC_DEL'>
      <input type=hidden name='new_class' value='$fB_class'>
      <input type=hidden name='new_catg' value='$fB_catg'>
      <input type=hidden name='new_acc_uid' value='$H2_acc_uid'>
      <input type=hidden name='new_acc_code' value='$H2_acc_code'>
      <input type=hidden name='keyfield' value='$keyfield'>
      <input type=hidden name='key' value='$key'>
      <td width=7% bgcolor=#FFFFFF align=center><input $acc_btn_act2 type=submit value='$txt_comm_frm13' class='btn btn-default btn-sm'></td>
      </form>
    </tr>");
  
    }
  
  // 세부항목 추가 입력란
  if($mode == "add" AND $catg == $fB_catg) {
  
    echo ("
    <form name='act_addB' method='post' action='system_account_act.php'>
    <input type=hidden name='add_mode' value='ACC_ADD'>
    <input type=hidden name='new_class' value='$fB_class'>
    <input type=hidden name='new_catg' value='$fB_catg'>
    <input type=hidden name='keyfield' value='$keyfield'>
      <input type=hidden name='key' value='$key'>
    
    <tr height=22>
      <td width=10% bgcolor=#FFFFFF>&nbsp;</td>
      <td width=10% bgcolor=#FFFFFF>&nbsp;</td>
      <td width=7% bgcolor=#FFFFFF align=center>+</td>
      <td width=59% bgcolor=#FFFFFF>&nbsp; <input type=text name='new_acc_name' style='WIDTH: 200px'></td>
      <td colspan=2 width=14% bgcolor=#FFFFFF align=center><input type=submit value='$txt_sys_account_10' class='btn btn-default btn-sm'></td>
    </tr>
    </form>");
  
  
  }
  
  
}




echo ("
</table>
</td></tr>

</table>
");
?>
</section>	

		
			<br />
			<div class="form-actions">
				<a href="<?echo("$link_post?gate=$login_gate")?>"><input type="button" value="<?=$txt_sys_category_02?>" class="btn btn-primary"></a>
			</div>
        </div>
		
        </section>
						
						
						
    
    
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

<? } ?>