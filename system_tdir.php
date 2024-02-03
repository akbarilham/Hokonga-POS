<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "system";
$smenu = "system_tdir";

$link_list = "$home/system_tdir.php";
$link_post = "$home/system_tdir_post.php";
$link_upd = "$home/system_tdir_upd.php";
$link_del = "$home/system_tdir_del.php";
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
        
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$hsm_name_09_341?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		<section id="unseen">
		<table class="table table-bordered table-striped table-condensed">
			
<?
echo ("
        <thead>
		<tr>
			<th colspan=2 width=50%>$txt_sys_category_05</td>
			<th colspan=2 width=50%>$txt_sys_category_06</td>
		</tr>
		</thead>
		
		<tbody>");

		$big_cat_array = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12", "13", "14", "15", "16", "17", "18", "19", "20", 
						"21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "37", "38", "39", "40", 
						"41", "42", "43", "44", "45", "46", "47", "48", "49", "50", "51", "52", "53", "54", "55", "56", "57", "58", "59", "60", 
						"61", "62", "63", "64", "65", "66", "67", "68", "69", "70", "71", "72", "73", "74", "75", "76", "77", "78", "79", "80", 
						"81", "82", "83", "84", "85", "86", "87", "88", "89", "90", "91", "92", "93", "94", "95", "96", "97", "98", "99");

		// 대분류 데이터베이스에서 레코드를 검색
		$big_query = "SELECT * FROM dir6_catgbig WHERE lang = '$lang' ORDER BY lcode";
		$big_result = mysql_query($big_query);
		if (!$big_result) {
		   error("QUERY_ERROR");
		   exit;
		}   
		$big_rows = mysql_num_rows($big_result);  // 대분류에 들어있는 분류수
		
		$j=0;
  
		while($big_row = mysql_fetch_object($big_result)) {

		  	$big_code = $big_row->lcode;
		  	$big_name = $big_row->lname;
		  	  $big_name = stripslashes($big_name);
		  	$big_memo = $big_row->memo;
		  	  $big_memo = stripslashes($big_memo);
		  	$big_mb_code1 = $big_row->mb_code1;
		  	$big_mb_code2 = $big_row->mb_code2;
		  	$big_mb_code3 = $big_row->mb_code3;
		  	
		  	$j2 = $j + 1;
		  	
		  	// 중분류
		  	$mid_query = "SELECT * FROM dir6_catgmid WHERE lang = '$lang' AND lcode = '$big_code' ORDER BY mcode";
		  	$mid_result = mysql_query($mid_query);  // 쿼리문을 SQL서버에 전송
		  	if (!$mid_result) {
		     		error("QUERY_ERROR");
		     		exit;
		  	}   
		  	$mid_rows = mysql_num_rows($mid_result);  // 중분류에 들어있는 분류수
    
			// 대분류 수정 링크
	    echo ("
			<form name='formB' method='post' action='$home/process_tdir_updB.php'>
			<input type='hidden' name='lang' value='$lang'>
			<input type='hidden' name='gate' value='$gate'>
			<input type='hidden' name='mode' value='big'>
			<input type='hidden' name='uid' value='$uid'>
			
			<tr height=24>
      <td bgcolor=#FFFFFF rowspan=$mid_rows>
          <table width=100% cellspacing=0 cellpadding=0 border=0>
          <tr>
            <td width=10></td>
            <td width=20>$big_code</td>
            <td width=180><input type=text name='bname' value=\"$big_name\" style='WIDTH: 180px; HEIGHT: 22px'></td>
              <input type=hidden name='bcode' value=\"$big_code\">
            <td width=5></td>");
            
            if($mode == "big" AND $uid == "$big_code") {
              echo ("<td>&nbsp;</td>");
            } else {
              echo ("<td><a href='$link_list?mode=big&uid=$big_code'><i class='fa fa-user'></i></a></td>");
            }
            
            echo ("</tr>");
            
            if($mode == "big" AND $uid == "$big_code") {
              echo ("
              <tr>
                <td></td>
                <td></td>
                <td colspan=2>
                  
                  <select name='big_mb_code1' style='WIDTH: 100px; HEIGHT: 22px'>
                  <option value=''>:: $txt_comm_frm19:: </option>");
                  
                  $query_dirs1c = "SELECT count(uid) FROM member_staff WHERE userlevel > '0'";
                  $result_dirs1c = mysql_query($query_dirs1c,$dbconn);
                    if (!$result_dirs1c) { error("QUERY_ERROR"); exit; }
      
                  $total_dirs1c = @mysql_result($result_dirs1c,0,0);
      
                  $query_dirs1 = "SELECT code,name FROM member_staff WHERE userlevel > '0' 
                                  ORDER BY name ASC";
                  $result_dirs1 = mysql_query($query_dirs1,$dbconn);
                    if (!$result_dirs1) { error("QUERY_ERROR"); exit; }   

                  for($dirs1 = 0; $dirs1 < $total_dirs1c; $dirs1++) {
                    $dirs1_mb_code = mysql_result($result_dirs1,$dirs1,0);
                    $dirs1_mb_name = mysql_result($result_dirs1,$dirs1,1);
              
                    if($big_mb_code1 == $dirs1_mb_code) {
                      echo ("<option value='$dirs1_mb_code' selected>$dirs1_mb_name</option>");
                    } else {
                      echo ("<option value='$dirs1_mb_code'>$dirs1_mb_name</option>");
                    }
            
                  }
                  echo ("
                  </select>
                  
                  <select name='big_mb_code2' style='WIDTH: 100px; HEIGHT: 22px'>
                  <option value=''>:: $txt_comm_frm19:: </option>");
                  
                  $query_dirs2c = "SELECT count(uid) FROM member_staff WHERE userlevel > '0'";
                  $result_dirs2c = mysql_query($query_dirs2c,$dbconn);
                    if (!$result_dirs2c) { error("QUERY_ERROR"); exit; }
      
                  $total_dirs2c = @mysql_result($result_dirs2c,0,0);
      
                  $query_dirs2 = "SELECT code,name FROM member_staff WHERE userlevel > '0' 
                                  ORDER BY name ASC";
                  $result_dirs2 = mysql_query($query_dirs2,$dbconn);
                    if (!$result_dirs2) { error("QUERY_ERROR"); exit; }   

                  for($dirs2 = 0; $dirs2 < $total_dirs2c; $dirs2++) {
                    $dirs2_mb_code = mysql_result($result_dirs2,$dirs2,0);
                    $dirs2_mb_name = mysql_result($result_dirs2,$dirs2,1);
              
                    if($big_mb_code2 == $dirs2_mb_code) {
                      echo ("<option value='$dirs2_mb_code' selected>$dirs2_mb_name</option>");
                    } else {
                      echo ("<option value='$dirs2_mb_code'>$dirs2_mb_name</option>");
                    }
            
                  }
                  echo ("
                  </select>
				  
				  <br><input type=text name='big_memo' value=\"$big_memo\" style='WIDTH: 220px; HEIGHT: 22px; margin-top: 5px'>
                  
                </td>
              </tr>
              ");
            }
            
            echo ("
          </table>
			
			
			</td>

			<td rowspan=$mid_rows>
			<input type='submit' value='$txt_comm_frm12' style='$style_box; WIDTH: 50px'> ");
			if($j2 == $big_rows) {
			  echo("<a href='$home/process_tdir_del.php?lang=$lang&mode=big&bcode=$big_code&bname=$big_name&gate=$gate'>$txt_comm_frm13</a>");
			} else {
			  echo("<font color=#AAAAAA>$txt_comm_frm13</font>");
			}
			
			echo("
			</td>
			</form>
			");

		  	$i=0;

		  	while($mid_row = mysql_fetch_object($mid_result)) {

          $m_code = $mid_row->mcode;
				  $m_name = $mid_row->mname;
				    $m_name = stripslashes($m_name);
				  $mid_memo = $mid_row->memo;
		  	    $mid_memo = stripslashes($mid_memo);
		  	  $mid_mb_code1 = $mid_row->mb_code1;
		  	  $mid_mb_code2 = $mid_row->mb_code2;
		  	  $mid_mb_code3 = $mid_row->mb_code3;
				  
				  
				    $i2 = $i + 1;

		    		if($i == 0) {
		      	echo ("
				<form name='formM' method='post' action='$home/process_tdir_updM.php'>
				<input type='hidden' name='lang' value='$lang'>
			  <input type='hidden' name='gate' value='$gate'>
			  <input type='hidden' name='mode' value='form'>
			  <input type='hidden' name='uid' value='$uid'>
				
				<td bgcolor=#FFFFFF>

          <table width=100% cellspacing=0 cellpadding=0 border=0>
          <tr>
            <td width=10></td>
            <td width=40>$m_code</td>
            <td width=180><input type=text name='new_mname' value=\"$m_name\" style='WIDTH: 180px; HEIGHT: 22px'></td>
              <input type=hidden name='new_mcode' value=\"$m_code\">
            <td width=5></td>");
            
            if($mode == "form" AND $uid == "$m_code") {
              echo ("<td>&nbsp;</td>");
            } else {
              echo ("<td><a href='$link_list?mode=form&uid=$m_code'><i class='fa fa-user'></i></a></td>");
            }
            
            echo ("</tr>");
            
            if($mode == "form" AND $uid == "$m_code") {
              echo ("
              <tr>
                <td></td>
                <td></td>
                <td colspan=2>
                  
                  <select name='mid_mb_code1' style='WIDTH: 100px; HEIGHT: 22px'>
                  <option value=''>:: $txt_comm_frm19:: </option>");
                  
                  $query_dirs4c = "SELECT count(uid) FROM member_staff WHERE userlevel > '0'";
                  $result_dirs4c = mysql_query($query_dirs4c,$dbconn);
                    if (!$result_dirs4c) { error("QUERY_ERROR"); exit; }
      
                  $total_dirs4c = @mysql_result($result_dirs4c,0,0);
      
                  $query_dirs4 = "SELECT code,name FROM member_staff WHERE userlevel > '0' 
                                  ORDER BY name ASC";
                  $result_dirs4 = mysql_query($query_dirs4,$dbconn);
                    if (!$result_dirs4) { error("QUERY_ERROR"); exit; }   

                  for($dirs4 = 0; $dirs4 < $total_dirs4c; $dirs4++) {
                    $dirs4_mb_code = mysql_result($result_dirs4,$dirs4,0);
                    $dirs4_mb_name = mysql_result($result_dirs4,$dirs4,1);
              
                    if($mid_mb_code1 == $dirs4_mb_code) {
                      echo ("<option value='$dirs4_mb_code' selected>$dirs4_mb_name</option>");
                    } else {
                      echo ("<option value='$dirs4_mb_code'>$dirs4_mb_name</option>");
                    }
            
                  }
                  echo ("
                  </select>
                  
                  <select name='mid_mb_code2' style='WIDTH: 100px; HEIGHT: 22px'>
                  <option value=''>:: $txt_comm_frm19:: </option>");
                  
                  $query_dirs5c = "SELECT count(uid) FROM member_staff WHERE userlevel > '0'";
                  $result_dirs5c = mysql_query($query_dirs5c,$dbconn);
                    if (!$result_dirs5c) { error("QUERY_ERROR"); exit; }
      
                  $total_dirs5c = @mysql_result($result_dirs5c,0,0);
      
                  $query_dirs5 = "SELECT code,name FROM member_staff WHERE userlevel > '0' 
                                  ORDER BY name ASC";
                  $result_dirs5 = mysql_query($query_dirs5,$dbconn);
                    if (!$result_dirs5) { error("QUERY_ERROR"); exit; }   

                  for($dirs5 = 0; $dirs5 < $total_dirs5c; $dirs5++) {
                    $dirs5_mb_code = mysql_result($result_dirs5,$dirs5,0);
                    $dirs5_mb_name = mysql_result($result_dirs5,$dirs5,1);
              
                    if($mid_mb_code2 == $dirs5_mb_code) {
                      echo ("<option value='$dirs5_mb_code' selected>$dirs5_mb_name</option>");
                    } else {
                      echo ("<option value='$dirs5_mb_code'>$dirs5_mb_name</option>");
                    }
            
                  }
                  echo ("
                  </select>
				  
				  <br><input type=text name='mid_memo' value=\"$mid_memo\" style='WIDTH: 220px; HEIGHT: 22px; margin-top: 5px'>
                  
                </td>
              </tr>
              ");
            }
            
            echo ("
          </table>
        
        </td>

				<td><input type='submit' value='$txt_comm_frm12' class='btn btn-default btn-xs'> ");
				
				if($i2 == $mid_rows) {
				  echo("<a href='$home/process_tdir_del.php?lang=$lang&mode=mid&mcode=$m_code&mname=$m_name&gate=$gate'>$txt_comm_frm13</a>");
				} else {
				  echo("<font color=#AAAAAA>$txt_comm_frm13</font>");
				}
				
				echo("
				</td>
        </tr>
				</form>
				");

		    		} else {
		    		
		    		echo ("
				<tr height=24 bgcolor=#FFFFFF>

				<form name='formM' method='post' action='$home/process_tdir_updM.php'>
				<input type='hidden' name='lang' value='$lang'>
			  <input type='hidden' name='gate' value='$gate'>
			  <input type='hidden' name='mode' value='form'>
			  <input type='hidden' name='uid' value='$uid'>
				
				<td bgcolor=#FFFFFF>

          <table width=100% cellspacing=0 cellpadding=0 border=0>
          <tr>
            <td width=10></td>
            <td width=40>$m_code</td>
            <td width=180><input type=text name='new_mname' value=\"$m_name\" style='WIDTH: 180px; HEIGHT: 22px'></td>
              <input type=hidden name='new_mcode' value=\"$m_code\">
            <td width=5></td>");
            
            if($mode == "form" AND $uid == "$m_code") {
              echo ("<td>&nbsp;</td>");
            } else {
              echo ("<td><a href='$link_list?mode=form&uid=$m_code'><i class='fa fa-user'></i></a></td>");
            }
            
            echo ("</tr>");
            
            if($mode == "form" AND $uid == "$m_code") {
              echo ("
              <tr>
                <td></td>
                <td></td>
                <td colspan=2>
                  
                  <select name='mid_mb_code1' style='WIDTH: 100px; HEIGHT: 22px'>
                  <option value=''>:: $txt_comm_frm19:: </option>");
                  
                  $query_dirs4c = "SELECT count(uid) FROM member_staff WHERE userlevel > '0'";
                  $result_dirs4c = mysql_query($query_dirs4c,$dbconn);
                    if (!$result_dirs4c) { error("QUERY_ERROR"); exit; }
      
                  $total_dirs4c = @mysql_result($result_dirs4c,0,0);
      
                  $query_dirs4 = "SELECT code,name FROM member_staff WHERE userlevel > '0' 
                                  ORDER BY name ASC";
                  $result_dirs4 = mysql_query($query_dirs4,$dbconn);
                    if (!$result_dirs4) { error("QUERY_ERROR"); exit; }   

                  for($dirs4 = 0; $dirs4 < $total_dirs4c; $dirs4++) {
                    $dirs4_mb_code = mysql_result($result_dirs4,$dirs4,0);
                    $dirs4_mb_name = mysql_result($result_dirs4,$dirs4,1);
              
                    if($mid_mb_code1 == $dirs4_mb_code) {
                      echo ("<option value='$dirs4_mb_code' selected>$dirs4_mb_name</option>");
                    } else {
                      echo ("<option value='$dirs4_mb_code'>$dirs4_mb_name</option>");
                    }
            
                  }
                  echo ("
                  </select>
                  
                  <select name='mid_mb_code2' style='WIDTH: 100px; HEIGHT: 22px'>
                  <option value=''>:: $txt_comm_frm19:: </option>");
                  
                  $query_dirs5c = "SELECT count(uid) FROM member_staff WHERE userlevel > '0'";
                  $result_dirs5c = mysql_query($query_dirs5c,$dbconn);
                    if (!$result_dirs5c) { error("QUERY_ERROR"); exit; }
      
                  $total_dirs5c = @mysql_result($result_dirs5c,0,0);
      
                  $query_dirs5 = "SELECT code,name FROM member_staff WHERE userlevel > '0' 
                                  ORDER BY name ASC";
                  $result_dirs5 = mysql_query($query_dirs5,$dbconn);
                    if (!$result_dirs5) { error("QUERY_ERROR"); exit; }   

                  for($dirs5 = 0; $dirs5 < $total_dirs5c; $dirs5++) {
                    $dirs5_mb_code = mysql_result($result_dirs5,$dirs5,0);
                    $dirs5_mb_name = mysql_result($result_dirs5,$dirs5,1);
              
                    if($mid_mb_code2 == $dirs5_mb_code) {
                      echo ("<option value='$dirs5_mb_code' selected>$dirs5_mb_name</option>");
                    } else {
                      echo ("<option value='$dirs5_mb_code'>$dirs5_mb_name</option>");
                    }
            
                  }
                  echo ("
                  </select>
				  
				  <br><input type=text name='mid_memo' value=\"$mid_memo\" style='WIDTH: 220px; HEIGHT: 22px; margin-top: 5px'>
                  
                </td>
              </tr>
              ");
            }
            
            echo ("
          </table>
        </td>
				
				<td><input type='submit' value='$txt_comm_frm12' class='btn btn-default btn-xs'> ");
				
				if($i2 == $mid_rows) {
				  echo("<a href='$home/process_tdir_del.php?lang=$lang&mode=mid&mcode=$m_code&mname=$m_name&gate=$gate'>$txt_comm_frm13</a></td>");
				} else {
				  echo("<font color=#AAAAAA>$txt_comm_frm13</font>");
				}
				
				echo("
        </tr>
				</form>
				");
    				}

	  		$i++;
			}

  			// 중분류에 하부 항목이 없으면 없다고 보여줌 
  			if($mid_rows == 0) {
    			echo ("<td colspan=2 bgcolor=#FFFFFF align=left><font color=navy>$txt_sys_category_chk01</font></td></tr>");
  			}
  		$j++;
		}
		echo("
		</tbody>
    </table>")
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