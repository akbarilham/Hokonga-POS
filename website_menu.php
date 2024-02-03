<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

if(!$login_branch) { $login_branch = "CORP_01"; }
if(!$key_gate) { $key_gate = $client_id; }

$mmenu = "website";
$smenu = "website_menu";

$link_list = "$home/website_menu.php";
$link_post = "$home/website_menu_post.php";
$link_upd = "$home/website_menu_upd.php";
$link_del = "$home/website_menu_del.php";
$link_list_ordering = "$home/website_menu_upd_sort.php";
?>


<!DOCTYPE html>
<html lang="<?=$lang?>">
  <head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="Rachel Build, Smart Work, Bootstrap, Responsive">
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
            <?=$hsm_name_08_01?> : <?=$key?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<div class="col-sm-6">
			
						<?
						$queryC = "SELECT count(client_id) FROM client WHERE web_flag = '1' AND branch_code = '$login_branch'";
						$resultC = mysql_query($queryC);
						$total_recordC = mysql_result($resultC,0,0);

						$queryD = "SELECT client_id,client_name,homepage FROM client WHERE web_flag = '1' AND branch_code = '$login_branch' 
								ORDER BY userlevel DESC";
						$resultD = mysql_query($queryD);
						if (!$resultD) {   error("QUERY_ERROR");   exit; }

						echo("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");

						for($i = 0; $i < $total_recordC; $i++) {
							$web_client_id = mysql_result($resultD,$i,0);
							$web_client_name = mysql_result($resultD,$i,1);
							$web_client_homepage = mysql_result($resultD,$i,2);
        
							if($web_client_id == $key) {
								$slc_gate = "selected";
								$slc_disable = "";
							} else {
								$slc_gate = "";
								$slc_disable = "disabled";
							}

							echo("<option value='$PHP_SELF?key_gate=$web_client_id' $slc_gate>[ $web_client_id ] $web_client_homepage</option>");
						}
						echo("</select>
			
			</div>
			
			
			<div class='col-sm-2' align=right></div>
			<div class='col-sm-4'><!--- sorting here // --->
			
			
			</div>");
			?>
			</div>
			
			<div>&nbsp;</div>
			
			
<?
echo ("
<section id='unseen'>
<table width=100% cellspacing=0 cellpadding=0 border=0>
<tr>
   <td height=25 align=center bgColor=#EFEFEF width=9%>No.</td>
   <td bgColor=#EFEFEF width=36%>$txt_web_menu_05</td>
   <td bgColor=#EFEFEF width=20%>$txt_web_menu_06</td>
   <td bgColor=#EFEFEF width=10%>$txt_web_menu_07</td>
   <td align=center bgColor=#EFEFEF width=6%>$txt_web_menu_08</td>
   <td align=center bgColor=#EFEFEF width=7%>$txt_web_menu_09</td>
   <td align=center bgColor=#EFEFEF width=6%>$txt_comm_frm12</td>
   <td align=center bgColor=#EFEFEF width=6%>$txt_comm_frm13</td>
</tr>
");



$query_mmx = "SELECT uid,room,b_num,b_ord,b_loco,b_title,onoff,b_type,b_option,b_lagday,b_rows,b_permit FROM wpage_config 
			WHERE lang='$lang' AND b_depth = '1' AND gate = '$key_gate' AND branch_code = '$login_branch' ORDER BY b_ord ASC, b_num ASC";
$result_mmx = mysql_query($query_mmx);
$row_mmx = mysql_num_rows($result_mmx);
          
while($row_mmx = mysql_fetch_object($result_mmx)) {
  $mmx_uid = $row_mmx->uid;
  $mmx_room = $row_mmx->room;
  $mmx_mnum = $row_mmx->b_num;
  $mmx_mord = $row_mmx->b_ord;
  $mmx_mcode = $row_mmx->b_loco;
  $mmx_mname = $row_mmx->b_title;
	$mmx_mname = stripslashes($mmx_mname);
  $mmx_mshow = $row_mmx->onoff;
  $mmx_type = $row_mmx->b_type;
  $mmx_option = $row_mmx->b_option;
  $mmx_lagday = $row_mmx->b_lagday;
  $mmx_rows = $row_mmx->b_rows;
  $mmx_permit = $row_mmx->b_permit;
  
  
  if($mmx_mshow == "1") {
    $mshow_txt = "<font color=blue>ON</font>";
    $msubj_color = "#000000";
  } else {
    $mshow_txt = "<font color=red>OFF</font>";
    $msubj_color = "#888888";
  }

  echo ("
  <tr><td colspan=8 height=20 bgcolor=#FFFFFF></td></tr>
  <tr height=22 bgcolor=#FFFFFF>
    <td align=center>$mmx_mord</td>
    <td>&nbsp;<font color='$msubj_color'>$mmx_mname</font> ($mmx_mcode)</td>");
	
		if($mmx_type == "islide") {
		    $mmxb_style = "Slide Show";
		} else if($mmx_type == "icol1") {
		    $mmxb_style = "Box 1C";
		} else if($mmx_type == "icol3") {
		    $mmxb_style = "Box 3C";
	    } else if($mmx_type == "icol4") {
		    $mmxb_style = "Box 4C";
	    } else if($mmx_type == "igrid3") {
		    $mmxb_style = "Grid 3C";
	    } else if($mmx_type == "imovie") {
		    $mmxb_style = "Movie";
	    } else if($mmx_type == "icontact") {
		    $mmxb_style = "Contact Intro";
	    } else if($mmx_type == "ipricing") {
		    $mmxb_style = "Pricing";
	    } else if($mmx_type == "icountdown") {
		    $mmxb_style = "Countdown";
	    } else if($mmx_type == "ifullimg") {
		    $mmxb_style = "Full Img";
		} else if($mmx_type == "iteam") {
		    $mmxb_style = "Team Intro";
		} else if($mmx_type == "itesti") {
		    $mmxb_style = "Testimonial";
		} else if($mmx_type == "blog1") {
		    $mmxb_style = "Blog Full";
	    } else if($mmx_type == "blog3") {
		    $mmxb_style = "Blog 3C";
		} else if($mmx_type == "blog4") {
		    $mmxb_style = "Blog 4C";
		} else if($mmx_type == "blogx") {
		    $mmxb_style = "Blog Text";
	    } else if($mmx_type == "pofo2") {
		    $mmxb_style = "Portfolio 2C";
		} else if($mmx_type == "pofo3") {
		    $mmxb_style = "Portfolio 3C";
		} else if($mmx_type == "pofo4") {
		    $mmxb_style = "Portfolio 4C";
		} else if($mmx_type == "pofo5") {
		    $mmxb_style = "Portfolio 5C";
		} else if($mmx_type == "pofod1") {
		    $mmxb_style = "Portfolio+ Full";
		} else if($mmx_type == "pofod2") {
		    $mmxb_style = "Portfolio+ 2C";
		} else if($mmx_type == "pofod3") {
		    $mmxb_style = "Portfolio+ 3C";
		} else if($mmx_type == "pofod4") {
		    $mmxb_style = "Portfolio+ 4C";
		} else if($mmx_type == "vod") {
		    $mmxb_style = "VOD";
		} else if($mmx_type == "emag") {
		    $mmxb_style = "Magazine";
		} else if($mmx_type == "bbs") {
		    $mmxb_style = "Msg List";
		} else if($mmx_type == "qna") {
		    $mmxb_style = "Q&A";
		} else if($mmx_type == "faq") {
		    $mmxb_style = "FAQ";
		} else if($mmx_type == "week") {
		    $mmxb_style = "Weekly Bulletin";
		} else if($mmx_type == "time") {
		    $mmxb_style = "Timeline";
		} else if($mmx_type == "team") {
		    $mmxb_style = "Team";
		} else if($mmx_type == "contact") {
		    $mmxb_style = "Contact";
		} else if($mmx_type == "blnk") {
		    $mmxb_style = "Blank";
		} else if($mmx_type == "link") {
		    $mmxb_style = "<font color=blue>- URL -</font>";
	    } else if($mmx_type == "x") {
		    $mmxb_style = "";
	    } else {
		    $mmxb_style = "Unknown";
	    }


      if($mmx_option == "0") {
	      $mmxb_option = "<font color=#CCCCCC>Default</font>";
      } else if($mmx_option == "1") {
	      $mmxb_option = "Image";
      } else if($mmx_option == "3") {
	      $mmxb_option = "Data +";
      } else if($mmx_option == "4") {
	      $mmxb_option = "Sound";
      } else if($mmx_option == "5") {
	      $mmxb_option = "Movie";
	  } else if($mmx_option == "6") {
	      $mmxb_option = "FLV/MP4";
	  } else if($mmx_option == "8") {
	      $mmxb_option = "Mailer";
      } else {
	      $mmxb_option = "Unknown";
      }

      if($mmx_type == "x" OR $mmx_room == "main") {
		echo("<td>&nbsp;</td>");
		echo("<td>&nbsp;</td>");
		echo("<td align=center>&nbsp;</td>");
	  } else {
		echo("<td>$mmx_type ($mmxb_style)</td>");
		echo("<td>{$mmxb_option} ($mmx_permit)</td>");
		echo("<td align=center>{$mmx_rows}</td>");
	  }
	
	
	

    if($mmx_room == "main") {
		echo ("
		<td align=center><a href='$link_post?b_depth=2&pcode=$mmx_mcode&room=$mmx_room&key_gate=$key_gate'>$txt_web_menu_09</a></td>
		<td align=center><a href='$link_upd?b_depth=1&pcode=$mmx_mcode&room=$mmx_room&key_gate=$key_gate&uid=$mmx_uid'>[$txt_comm_frm12]</a></td>
		<td align=center>$mshow_txt</td>
		");
	} else {
		echo ("
		<td align=center><a href='$link_post?b_depth=2&pcode=$mmx_mcode&room=$mmx_room&key_gate=$key_gate'>$txt_web_menu_09</a></td>
		<td align=center><a href='$link_upd?b_depth=1&pcode=$mmx_mcode&room=$mmx_room&key_gate=$key_gate&uid=$mmx_uid'>[$txt_comm_frm12]</a></td>
		<td align=center><a href='$link_del?b_depth=1&pcode=$mmx_mcode&room=$mmx_room&key_gate=$key_gate&uid=$mmx_uid'>$mshow_txt</a></td>
		");
	}
	
	echo ("
  </tr>
  <tr><td colspan=8 height=1 bgcolor=#333333></td></tr>
  ");


  $query = "SELECT uid,room,b_num,b_title,b_type,b_option,b_lagday,b_rows,b_permit,b_loco,onoff,
            show_short,show_intro,show_intro2,show_head,show_foot,host_link,host_link_url FROM wpage_config 
            WHERE b_loco = '$mmx_mcode' AND lang = '$lang' AND gate = '$key_gate' AND branch_code = '$login_branch' AND b_depth = '2' 
            ORDER BY b_num ASC, uid ASC";
  $result = mysql_query($query);
  if (!$result) { error("QUERY_ERROR"); exit; }

  while($row = mysql_fetch_object($result)) {
    $b_uid = $row->uid;
    $b_room = $row->room;
	$b_num = $row->b_num;
    $b_title= $row->b_title;
		$b_title = stripslashes($b_title);
    $b_type= $row->b_type;
    $b_option= $row->b_option;
    $b_lagday = $row->b_lagday;
    $b_rows = $row->b_rows;
    $b_permit = $row->b_permit;
    $b_loco = $row->b_loco;
    $onoff = $row->onoff;
    $show_short = $row->show_short;
    $show_intro = $row->show_intro;
	$show_intro2 = $row->show_intro2;
    $show_head = $row->show_head;
    $show_foot = $row->show_foot;
	$host_link = $row->host_link;
	$host_link_url = $row->host_link_url;
    
    if($show_short == "1") {
      $show_short_chk = "checked";
      $show_short_link = "<i class='fa fa-bolt'></i>&nbsp;";
    } else {
      $show_short_chk = "";
      $show_short_link = "";
    }
    if($show_intro == "1") {
      $show_intro_chk = "checked";
      $show_intro_link = "<i class='fa fa-home'></i>&nbsp;";
    } else {
      $show_intro_chk = "";
      $show_intro_link = "";
    }
	if($show_intro2 == "1") {
      $show_intro2_chk = "checked";
      $show_intro2_link = "<i class='fa fa-dashboard'></i>&nbsp;";
    } else {
      $show_intro2_chk = "";
      $show_intro2_link = "";
    }
    if($show_head == "1") {
      $show_head_chk = "checked";
      $show_head_link = "<i class='fa fa-minus'></i>&nbsp;";
    } else {
      $show_head_chk = "";
      $show_head_link = "";
    }
    if($show_foot == "1") {
      $show_foot_chk = "checked";
      $show_foot_link = "<i class='fa fa-download'></i>&nbsp;";
    } else {
      $show_foot_chk = "";
      $show_foot_link = "";
    }

    echo ("
    <tr bgcolor=#FFFFFF>
      <td height=28 align=right>{$show_intro2_link} {$show_short_link}{$show_intro_link}{$show_head_link}{$show_foot_link}</td>");

      if($onoff == "1") {
        $font_sbj = "#000000";
      } else {
        $font_sbj = "#888888";
      }
      

      // 현재의 uid 보다 하나 적은 수
      $query_uidlow = "SELECT uid,b_num FROM wpage_config 
                  WHERE b_num < '$b_num' AND b_loco = '$mmx_mcode' AND lang = '$lang' AND gate = '$key_gate' AND branch_code = '$login_branch' AND b_depth = '2' 
				  ORDER BY b_num DESC";
      $result_uidlow = mysql_query($query_uidlow);
        if(!$result_uidlow) { error("QUERY_ERROR"); exit; }
        $low_uid = @mysql_result($result_uidlow,0,0);
        $low_num = @mysql_result($result_uidlow,0,1);
      
      if($low_uid) {
        $uid_uplink = "<a href='$link_list_ordering?uid=$b_uid&b_num=$b_num&target_uid=$low_uid&target_num=$low_num&key_gate=$key_gate'><i class='fa fa-chevron-up'></i></a>";
      } else {
        $uid_uplink = "<font color=#AAAAAA><i class='fa fa-chevron-up'></i></font>";
      }

      // 현재의 uid 보다 하나 큰 수
      $query_uidhigh = "SELECT uid,b_num FROM wpage_config 
                  WHERE b_num > '$b_num' AND b_loco = '$mmx_mcode' AND lang = '$lang' AND gate = '$key_gate' AND branch_code = '$login_branch' AND b_depth = '2' 
				  ORDER BY b_num ASC";
      $result_uidhigh = mysql_query($query_uidhigh);
        if(!$result_uidhigh) { error("QUERY_ERROR"); exit; }
        $high_uid = @mysql_result($result_uidhigh,0,0);
        $high_num = @mysql_result($result_uidhigh,0,1);
      
      if($high_uid) {
        $uid_downlink = "<a href='$link_list_ordering?uid=$b_uid&b_num=$b_num&target_uid=$high_uid&target_num=$high_num&key_gate=$key_gate'><i class='fa fa-chevron-down'></i></a>";
      } else {
        $uid_downlink = "<font color=#AAAAAA><i class='fa fa-chevron-down'></i></font>";
      }

      echo("<td>{$uid_uplink}{$uid_downlink} <font color='$font_sbj'> $b_title</font> ($b_room)</td>");


		if($b_type == "islide") {
		    $board_style = "Slide Show";
		} else if($b_type == "icol1") {
		    $board_style = "Box 1C";
		} else if($b_type == "icol3") {
		    $board_style = "Box 3C";
	    } else if($b_type == "icol4") {
		    $board_style = "Box 4C";
	    } else if($b_type == "igrid3") {
		    $board_style = "Grid 3C";
	    } else if($b_type == "imovie") {
		    $board_style = "Movie";
	    } else if($b_type == "icontact") {
		    $board_style = "Contact Intro";
	    } else if($b_type == "ipricing") {
		    $board_style = "Pricing";
	    } else if($b_type == "icountdown") {
		    $board_style = "Countdown";
	    } else if($b_type == "ifullimg") {
		    $board_style = "Full Img";
		} else if($b_type == "iteam") {
		    $board_style = "Team Intro";
		} else if($b_type == "itesti") {
		    $board_style = "Testimonial";
		} else if($b_type == "blog1") {
		    $board_style = "Blog Full";
	    } else if($b_type == "blog3") {
		    $board_style = "Blog 3C";
		} else if($b_type == "blog4") {
		    $board_style = "Blog 4C";
		} else if($b_type == "blogx") {
		    $board_style = "Blog Text";
	    } else if($b_type == "pofo2") {
		    $board_style = "Portfolio 2C";
		} else if($b_type == "pofo3") {
		    $board_style = "Portfolio 3C";
		} else if($b_type == "pofo4") {
		    $board_style = "Portfolio 4C";
		} else if($b_type == "pofo5") {
		    $board_style = "Portfolio 5C";
		} else if($b_type == "pofod1") {
		    $board_style = "Portfolio+ Full";
		} else if($b_type == "pofod2") {
		    $board_style = "Portfolio+ 2C";
		} else if($b_type == "pofod3") {
		    $board_style = "Portfolio+ 3C";
		} else if($b_type == "pofod4") {
		    $board_style = "Portfolio+ 4C";
		} else if($b_type == "serm") {
		    $board_style = "Sermon";
		} else if($b_type == "emag") {
		    $board_style = "Magazine";
		} else if($b_type == "bbs") {
		    $board_style = "Msg List";
		} else if($b_type == "qna") {
		    $board_style = "Q&A";
		} else if($b_type == "faq") {
		    $board_style = "FAQ";
		} else if($b_type == "week") {
		    $board_style = "Weekly Bulletin";
		} else if($b_type == "time") {
		    $board_style = "Timeline";
		} else if($b_type == "team") {
		    $board_style = "Team";
		} else if($b_type == "contact") {
		    $board_style = "Contact";
		} else if($b_type == "blnk") {
		    $board_style = "Blank";
		} else if($b_type == "link") {
		    $board_style = "<font color=blue>- URL -</font>";
	    } else if($b_type == "x") {
		    $board_style = "";
	    } else {
		    $board_style = "Unknown";
	    }
		
		if($host_link == "1" AND $b_type == "blnk") {
			$board_style_txt = "<font color=red>$host_link_url</font>";
		} else {
			$board_style_txt = $board_style;
		}

      echo("<td>$b_type ($board_style_txt)</td>");

      if($b_option == "0") {
	      $board_option = "<font color=#CCCCCC>Default</font>";
      } else if($b_option == "1") {
	      $board_option = "Image";
      } else if($b_option == "2") {
	      $board_option = "Flash";
      } else if($b_option == "3") {
	      $board_option = "Data +";
      } else if($b_option == "4") {
	      $board_option = "Sound";
      } else if($b_option == "5") {
	      $board_option = "Movie";
	    } else if($b_option == "6") {
	      $board_option = "FLV/MP4";
	    } else if($b_option == "8") {
	      $board_option = "Mailer";
      } else {
	      $board_option = "Unknown";
      }

      if($b_type == "x") {
		echo("<td>&nbsp;</td>");
		echo("<td align=center>&nbsp;</td>");
	  } else {
		echo("<td>{$board_option} ($b_permit)</td>");
		echo("<td align=center>{$b_rows}</td>");
	  }
      echo("<td align=center><a href='$link_post?b_depth=3&pcode=$b_loco&room=$b_room&key_gate=$key_gate'>$txt_web_menu_09</a></td>");
      

      echo("<td align=center><a href='$link_upd?b_depth=2&pcode=$b_loco&room=$b_room&key_gate=$key_gate&uid=$b_uid'><font color='navy'>[$txt_comm_frm12]</font></a></td>");
      echo("<td align=center><a href='$link_del?b_depth=2&pcode=$b_loco&room=$b_room&key_gate=$key_gate&uid=$b_uid'><font color='navy'>[$txt_comm_frm13]</font></a></td>");
      echo("<td align=center></td>");
    echo("</tr>");
    echo("<tr><td height=1></td><td colspan=8 height=1 bgcolor=#DDDDDD></td></tr>");
    
    
    
  $query_sub = "SELECT uid,room,b_num,b_title,b_type,b_option,b_lagday,b_rows,b_permit,b_loco,onoff,show_short,show_intro,show_intro2,show_head,show_foot 
          FROM wpage_config WHERE b_loco = '$mmx_mcode' AND lang = '$lang' AND gate = '$key_gate' AND branch_code = '$login_branch' AND b_depth = '3' 
          AND room LIKE '$b_room%' ORDER BY b_num ASC, uid ASC";
  $result_sub = mysql_query($query_sub);
  if (!$result_sub) { error("QUERY_ERROR"); exit; }

  while($row_sub = mysql_fetch_object($result_sub)) {
    $sb_uid = $row_sub->uid;
	$sb_room = $row_sub->room;
    $sb_num = $row_sub->b_num;
    $sb_title= $row_sub->b_title;
		$sb_title = stripslashes($sb_title);
    $sb_type= $row_sub->b_type;
    $sb_option= $row_sub->b_option;
    $sb_lagday = $row_sub->b_lagday;
    $sb_rows = $row_sub->b_rows;
    $sb_permit = $row_sub->b_permit;
    $sb_loco = $row_sub->b_loco;
    $sb_onoff = $row_sub->onoff;
    $sshow_short = $row_sub->show_short;
    $sshow_intro = $row_sub->show_intro;
	$sshow_intro2 = $row_sub->show_intro2;
    $sshow_head = $row_sub->show_head;
	$sshow_foot = $row_sub->show_foot;
    
    if($sshow_short == "1") {
      $sshow_short_chk = "checked";
      $sshow_short_link = "<i class='fa fa-bolt'></i>&nbsp;";
    } else {
      $sshow_short_chk = "";
      $sshow_short_link = "";
    }
    if($sshow_intro == "1") {
      $sshow_intro_chk = "checked";
      $sshow_intro_link = "<i class='fa fa-home'></i>&nbsp;";
    } else {
      $sshow_intro_chk = "";
      $sshow_intro_link = "";
    }
	if($sshow_intro2 == "1") {
      $sshow_intro2_chk = "checked";
      $sshow_intro2_link = "<i class='fa fa-dashboard'></i>&nbsp;";
    } else {
      $sshow_intro2_chk = "";
      $sshow_intro2_link = "";
    }
	if($sshow_head == "1") {
      $sshow_head_chk = "checked";
      $sshow_head_link = "<i class='fa fa-minus'></i>&nbsp;";
    } else {
      $sshow_head_chk = "";
      $sshow_head_link = "";
    }
    if($sshow_foot == "1") {
      $sshow_foot_chk = "checked";
      $sshow_foot_link = "<i class='fa fa-download'></i>&nbsp;";
    } else {
      $sshow_foot_chk = "";
      $sshow_foot_link = "";
    }

    echo ("
    <tr>
      <td height=28 align=right>{$sshow_intro2_link} {$sshow_short_link}{$sshow_intro_link}{$sshow_head_link}{$sshow_foot_link}</td>");

      if($sb_onoff == "1") {
        $sb_font_sbj = "#000000";
      } else {
        $sb_font_sbj = "#888888";
      }
      

      // 현재의 uid 보다 하나 적은 수
      $query_uidlow2 = "SELECT uid,b_num FROM wpage_config 
                  WHERE b_num < '$sb_num' AND b_loco = '$mmx_mcode' AND lang = '$lang' AND gate = '$key_gate' AND branch_code = '$login_branch' 
                  AND b_depth = '3' AND room LIKE '$room%' ORDER BY b_num DESC";
      $result_uidlow2 = mysql_query($query_uidlow2);
        if(!$result_uidlow2) { error("QUERY_ERROR"); exit; }
        $low2_uid = @mysql_result($result_uidlow2,0,0);
        $low2_num = @mysql_result($result_uidlow2,0,1);
      
      if($low2_uid) {
        $uid2_uplink = "<a href='$link_list_ordering?uid=$sb_uid&b_num=$sb_num&target_uid=$low2_uid&target_num=$low2_num&key_gate=$key_gate'><i class='fa fa-chevron-up'></i></a>";
      } else {
        $uid2_uplink = "<font color=#AAAAAA><i class='fa fa-chevron-up'></i></font>";
      }

      // 현재의 uid 보다 하나 큰 수
      $query_uidhigh2 = "SELECT uid,b_num FROM wpage_config 
                  WHERE b_num > '$sb_num' AND b_loco = '$mmx_mcode' AND lang = '$lang' AND gate = '$key_gate' AND branch_code = '$login_branch' 
                  AND b_depth = '3' AND room LIKE '$room%' ORDER BY b_num ASC";
      $result_uidhigh2 = mysql_query($query_uidhigh2);
        if(!$result_uidhigh2) { error("QUERY_ERROR"); exit; }
        $high2_uid = @mysql_result($result_uidhigh2,0,0);
        $high2_num = @mysql_result($result_uidhigh2,0,1);
      
      if($high2_uid) {
        $uid2_downlink = "<a href='$link_list_ordering?uid=$sb_uid&b_num=$sb_num&target_uid=$high2_uid&target_num=$high2_num&key_gate=$key_gate'><i class='fa fa-chevron-down'></i></a>";
      } else {
        $uid2_downlink = "<font color=#AAAAAA><i class='fa fa-chevron-down'></i></font>";
      }

      echo("<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {$uid2_uplink}{$uid2_downlink} <font color='$sb_font_sbj'>$sb_title</font> ($sb_room)</td>");


		if($sb_type == "islide") {
		    $sboard_style = "Slide Show";
		} else if($sb_type == "icol1") {
		    $sboard_style = "Box 1C";
		} else if($sb_type == "icol3") {
		    $sboard_style = "Box 3C";
	    } else if($sb_type == "icol4") {
		    $sboard_style = "Box 4C";
	    } else if($sb_type == "igrid3") {
		    $sboard_style = "Grid 3C";
	    } else if($sb_type == "imovie") {
		    $sboard_style = "Movie";
	    } else if($sb_type == "icontact") {
		    $sboard_style = "Contact Intro";
	    } else if($sb_type == "ipricing") {
		    $sboard_style = "Pricing";
	    } else if($sb_type == "icountdown") {
		    $sboard_style = "Countdown";
	    } else if($sb_type == "ifullimg") {
		    $sboard_style = "Full Img";
		} else if($sb_type == "iteam") {
		    $sboard_style = "Team Intro";
		} else if($sb_type == "itesti") {
		    $sboard_style = "Testimonial";
		} else if($sb_type == "blog1") {
		    $sboard_style = "Blog Full";
	    } else if($sb_type == "blog3") {
		    $sboard_style = "Blog 3C";
		} else if($sb_type == "blog4") {
		    $sboard_style = "Blog 4C";
		} else if($sb_type == "blogx") {
		    $sboard_style = "Blog Text";
	    } else if($sb_type == "pofo2") {
		    $sboard_style = "Portfolio 2C";
		} else if($sb_type == "pofo3") {
		    $sboard_style = "Portfolio 3C";
		} else if($sb_type == "pofo4") {
		    $sboard_style = "Portfolio 4C";
		} else if($sb_type == "pofo5") {
		    $sboard_style = "Portfolio 5C";
		} else if($sb_type == "pofod1") {
		    $sboard_style = "Portfolio+ Full";
		} else if($sb_type == "pofod2") {
		    $sboard_style = "Portfolio+ 2C";
		} else if($sb_type == "pofod3") {
		    $sboard_style = "Portfolio+ 3C";
		} else if($sb_type == "pofod4") {
		    $sboard_style = "Portfolio+ 4C";
		} else if($sb_type == "serm") {
		    $sboard_style = "Sermon";
		} else if($sb_type == "emag") {
		    $sboard_style = "Magazine";
		} else if($sb_type == "bbs") {
		    $sboard_style = "Msg List";
		} else if($sb_type == "qna") {
		    $sboard_style = "Q&A";
		} else if($sb_type == "faq") {
		    $sboard_style = "FAQ";
		} else if($sb_type == "week") {
		    $sboard_style = "Weekly Bulletin";
		} else if($sb_type == "time") {
		    $sboard_style = "Timeline";
		} else if($sb_type == "team") {
		    $sboard_style = "Team";
		} else if($sb_type == "contact") {
		    $sboard_style = "Contact";
		} else if($sb_type == "blnk") {
		    $sboard_style = "Blank";
		} else if($sb_type == "link") {
		    $sboard_style = "<font color=blue>- URL -</font>";
	    } else if($sb_type == "x") {
		    $sboard_style = "";
	    } else {
		    $sboard_style = "Unknown";
	    }
		
		echo("<td>$sb_type ($sboard_style)</td>");

      if($sb_option == "0") {
	      $sboard_option = "<font color=#CCCCCC>Default</font>";
      } else if($sb_option == "1") {
	      $sboard_option = "Image";
      } else if($sb_option == "2") {
	      $sboard_option = "Flash";
      } else if($sb_option == "3") {
	      $sboard_option = "Data +";
      } else if($sb_option == "4") {
	      $sboard_option = "Sound";
      } else if($sb_option == "5") {
	      $sboard_option = "Movie";
	    } else if($sb_option == "6") {
	      $sboard_option = "FLV/MP4";
	    } else if($sb_option == "8") {
	      $sboard_option = "Mailer";
      } else {
	      $sboard_option = "Unknown";
      }

      echo("<td>{$sboard_option} ($sb_permit)</td>");

      
      echo("<td align=center>{$sb_rows}</td>");
      echo("<td align=center></td>");
      

      echo("<td align=center><a href='$link_upd?b_depth=3&pcode=$sb_loco&room=$sb_room&key_gate=$key_gate&uid=$sb_uid'><font color='navy'>[$txt_comm_frm12]</font></a></td>");
      echo("<td align=center><a href='$link_del?b_depth=3&pcode=$sb_loco&room=$sb_room&key_gate=$key_gate&uid=$sb_uid'><font color='navy'>[$txt_comm_frm13]</font></a></td>");
      echo("<td align=center></td>");
    echo("</tr>");
    echo("<tr><td height=1></td><td colspan=8 height=1 bgcolor=#DDDDDD></td></tr>");
  }
    
    
    
    
  }

}
?>
</table>

		</section>
		
				<br>
				<a href="<?=$link_post?>?key_gate=<?=$key_gate?>"><input type="button" value="<?=$txt_web_menu_10?>" class="btn btn-primary"></a>
			
		
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

<? } ?>