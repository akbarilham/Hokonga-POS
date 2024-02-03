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
$smenu = "website_layout";

if(!$step_next) {



// Logo
$query_logo = "SELECT img1 FROM client_branch WHERE branch_code = '$login_branch'";
$result_logo = mysql_query($query_logo);
	if(!$result_logo) { error("QUERY_ERROR"); exit; }
	$row_logo = mysql_fetch_object($result_logo);
$photo1 = $row_logo->img1;


// Image Directory
if($client_id == "host") {
	$savedir = "user_file";
} else {
	// $savedir = "user/$client_id/user_file";
	$savedir = "user_file";
}


$query = "SELECT uid,theme,theme_mode,banner_show,layout,align,bgcolor,bgcolor_body,background,margin_top,margin_left,
          main_box_line,main_box_color,bgimg_body,bgimg_left,bottom,bottom_bgcolor,bottom_menu1,bottom_menu2,
          main_page,main_page_width,main_page_content,main_page_space,main_page_menustripe,main_page_menuloco,
          mmbar_bgcolor,mmbar_bgcolor_on,mmbar_bgcolor_off,
          mmbar_fontcolor,mmbar_height,footbar_bgcolor,default_lang,lang2nd,lang3rd,
          layout_topmenu,layout_loginshow,layout_menushow,layout_calshow,
          layout_calpermit,layout_shopshow,layout_catashow,layout_modelshow,layout_emagshow,mmbar_layout,mmbar_set,mmbar_set_opt,
          intro_display,intro_bgcolor,intro_reload,intro_block,intro_margin_top FROM layout WHERE gate = '$key_gate' AND branch_code = '$login_branch'";
$result = mysql_query($query);
if(!$result) {      
   error("QUERY_ERROR");
   exit;
}
   $row = mysql_fetch_object($result);

   $uid = $row->uid;   
   $theme = $row->theme;
   $theme_mode = $row->theme_mode;
   $banner_show = $row->banner_show;
   $layout = $row->layout;
   $align = $row->align;
   $bgcolor = $row->bgcolor;
   $bgcolor_body = $row->bgcolor_body;
   $background = $row->background;
   $margin_top = $row->margin_top;
   $margin_left = $row->margin_left;
   $main_box_line = $row->main_box_line;
   $main_box_color = $row->main_box_color;
   $bgimg_body = $row->bgimg_body;
   $bgimg_left = $row->bgimg_left;
   $bottom = $row->bottom;
   $bottom_bgcolor = $row->bottom_bgcolor;
   $bottom_menu1 = $row->bottom_menu1;
   $bottom_menu2 = $row->bottom_menu2;
   $main_page = $row->main_page;
   $main_page_width = $row->main_page_width;
   $main_page_content = $row->main_page_content;
   $main_page_space = $row->main_page_space;
   $main_page_menustripe = $row->main_page_menustripe;
   $main_page_menuloco = $row->main_page_menuloco;
   $mmbar_bgcolor = $row->mmbar_bgcolor;
   $mmbar_bgcolor_on = $row->mmbar_bgcolor_on;
   $mmbar_bgcolor_off = $row->mmbar_bgcolor_off;
   $mmbar_fontcolor = $row->mmbar_fontcolor;
   $mmbar_height = $row->mmbar_height;
   $footbar_bgcolor = $row->footbar_bgcolor;
   $default_lang = $row->default_lang;
   $lang2nd = $row->lang2nd;
   $lang3rd = $row->lang3rd;
   $layout_topmenu = $row->layout_topmenu;
   $layout_loginshow = $row->layout_loginshow;
   $layout_menushow = $row->layout_menushow;
   $layout_calshow = $row->layout_calshow;
   $b_permit = $row->layout_calpermit;
   $layout_shopshow = $row->layout_shopshow;
   $layout_catashow = $row->layout_catashow;
   $layout_modelshow = $row->layout_modelshow;
   $layout_emagshow = $row->layout_emagshow;
   $mmbar_layout = $row->mmbar_layout;
   $mmbar_set = $row->mmbar_set;
   $mmbar_set_opt = $row->mmbar_set_opt;
   $intro_display = $row->intro_display;
   $intro_bgcolor = $row->intro_bgcolor;
   $intro_reload = $row->intro_reload;
   $intro_block = $row->intro_block;
   $intro_margin_top = $row->intro_margin_top;
  
  if($intro_block == "0") {
    $intro_block_chk = "";
  } else if($intro_block == "1") {
    $intro_block_chk = "checked";
  }

  if($default_lang == "en") {
    $lang2nd_tmp = "ko";
    $lang3rd_tmp = "in";
  } else if($default_lang == "ko") {
    $lang2nd_tmp = "en";
    $lang3rd_tmp = "in";
  } else if($default_lang == "in") {
    $lang2nd_tmp = "en";
    $lang3rd_tmp = "ko";
  }

  if($lang2nd_tmp == "en") {
    $lang2nd_tmp_txt = "English";
  } else if($lang2nd_tmp == "ko") {
    $lang2nd_tmp_txt = "Korean";
  } else if($lang2nd_tmp == "in") {
    $lang2nd_tmp_txt = "Indonesian";
  }
  
  if($lang3rd_tmp == "en") {
    $lang3rd_tmp_txt = "English";
  } else if($lang3rd_tmp == "ko") {
    $lang3rd_tmp_txt = "Korean";
  } else if($lang3rd_tmp == "in") {
    $lang3rd_tmp_txt = "Indonesian";
  }
   

// 초기 데이터입력 필요 여부
if($row) {
  $submit_txt = "Update Website Layout";
  $action_mode = "update";
} else {
  $submit_txt = "Create Website Layout Table";
  $action_mode = "post";
}


// Default Language
if($default_lang == "ko") {
  $lang_chk_ko = "checked";
} else {
  $lang_chk_ko = "";
}
if($default_lang == "in") {
  $lang_chk_in = "checked";
} else {
  $lang_chk_in = "";
}
if($default_lang == "en") {
  $lang_chk_en = "checked";
} else {
  $lang_chk_en = "";
}


// Intro Display
if($intro_display == "1") {
  $intro_display_chk0 = "";
  $intro_display_chk1 = "checked";
  $intro_display_chk2 = "";
} else if($intro_display == "2") {
  $intro_display_chk0 = "";
  $intro_display_chk1 = "";
  $intro_display_chk2 = "checked";
} else if($intro_display == "0") {
  $intro_display_chk0 = "checked";
  $intro_display_chk1 = "";
  $intro_display_chk2 = "";
}


// Menu Strip Location
if($main_page_menuloco == "right") {
  $main_page_menuloco_chk1 = "";
  $main_page_menuloco_chk2 = "checked";
} else {
  $main_page_menuloco_chk1 = "checked";
  $main_page_menuloco_chk2 = "";
}


// Website Styles



if($main_page == "main" OR $main_page == "") {
  $style_chk0 = "checked";
} else {
  $style_chk0 = "";
}

if($main_page == "shop") {
  $style_chk1 = "checked";
} else {
  $style_chk1 = "";
}
if($main_page == "dir") {
  $style_chk2 = "checked";
} else {
  $style_chk2 = "";
}
if($main_page == "tour") {
  $style_chk3 = "checked";
} else {
  $style_chk3 = "";
}
if($main_page == "proverty") {
  $style_chk4 = "checked";
} else {
  $style_chk4 = "";
}
if($main_page == "magz") {
  $style_chk5 = "checked";
} else {
  $style_chk5 = "";
}
if($main_page == "model") {
  $style_chk6 = "checked";
} else {
  $style_chk6 = "";
}
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
            <?=$hsm_name_08_09?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		<div class="form">
			
<?
$query_cnt = "SELECT count(uid) FROM layout WHERE gate = '$key_gate' AND branch_code = '$login_branch'";
$result_cnt = mysql_query($query_cnt);
if (!$result_cnt) {   error("QUERY_ERROR");   exit; }

$cnt_uid = @mysql_result($result_cnt,0,0);


if($cnt_uid > 0) {


	echo ("
	<form class='cmxform form-horizontal adminex-form' name='signformnow' method='post' ENCTYPE='multipart/form-data' action='website_layout.php'>
	<input type='hidden' name='step_next' value='permit_update'>
	<input type='hidden' name='lang' value='$lang'>
	<input type='hidden' name='key_gate' value='$key_gate'>
	<input type='hidden' name='new_uid' value='$uid'>
	<input type='hidden' name='org_photo1' value='$photo1'>");
	?>
	
										
										<div class="form-group ">
											<label for="cname" class="control-label col-sm-3"><?=$txt_web_menu_11?></label>
											<div class="col-sm-9">
										
											<?
                                            $queryC = "SELECT count(client_id) FROM client WHERE web_flag = '1' AND branch_code = '$login_branch'";
											$resultC = mysql_query($queryC);
											$total_recordC = mysql_result($resultC,0,0);

											$queryD = "SELECT client_id,client_name,homepage FROM client WHERE web_flag = '1' AND branch_code = '$login_branch' 
													ORDER BY userlevel DESC";
											$resultD = mysql_query($queryD);

											echo ("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>");
											echo ("<option value=\"\">:: $txt_comm_frm24</option>");

											for($i = 0; $i < $total_recordC; $i++) {
												$web_client_id = mysql_result($resultD,$i,0);
												$web_client_name = mysql_result($resultD,$i,1);
												$web_client_homepage = mysql_result($resultD,$i,2);
        
												if($web_client_id == $key_gate) {
													$slc_gate = "selected";
													$slc_disable = "";
												} else {
													$slc_gate = "";
													$slc_disable = "disabled";
												}

												echo("<option $slc_disable value='$PHP_SELF?key_gate=$web_client_id' $slc_gate>[ $web_client_id ] $web_client_homepage</option>");
											}
											echo("</select>");
											?>
											
											</div>
										</div>
										
										
										<div class="form-group ">
											<label for="cname" class="control-label col-sm-3">Logo</label>
											<div class="col-sm-9">
											<?
											if($photo1 != "") {
												echo ("<img src='$savedir/$photo1' border=0>");
											} else {
												echo ("<input disabled type=text name='dis_photo1' value='No Image' class='form-control'>");
											}
											?>
											</div>
										</div>
										
										<div class="form-group">
											<label for="cname" class="control-label col-sm-3">Logo File</label>
											<div class="col-sm-9">
												<input type="file" class='form-control' name="photo1">
											</div>
										</div>
										
										
							
	<?
	echo ("
	<div class='form-group'>											
		<label for='cname' class='control-label col-sm-3'>
				Default Language<br>- $lang2nd_tmp_txt<br>- $lang3rd_tmp_txt</label>
		<div class='col-sm-9'>
			<input type=radio name='default_lang' value='en' $lang_chk_en> English &nbsp;
			<input type=radio name='default_lang' value='in' $lang_chk_in> Indonesian &nbsp;
			<input type=radio name='default_lang' value='ko' $lang_chk_ko> Korean"); ?>
			
				<br>
				<? if($lang2nd == "") { ?>
				<input type=radio name="new_lang2nd" value="" checked> <font color=red>Hold</font> &nbsp;&nbsp; 
				<input type=radio name="new_lang2nd" value="<?=$lang2nd_tmp?>"> <font color=blue>Activate Now !</font>
				<? } else { ?>
				<input type=radio name="new_lang2nd" value=""> <font color=red>Hold</font> &nbsp;&nbsp; 
				<input type=radio name="new_lang2nd" value="<?=$lang2nd_tmp?>" checked> <font color=blue>Activated</font>
				<? } ?>
				
				<br>
				<? if($lang3rd == "") { ?>
				<input type=radio name="new_lang3rd" value="" checked> <font color=red>Hold</font> &nbsp;&nbsp; 
				<input type=radio name="new_lang3rd" value="<?=$lang3rd_tmp?>"> <font color=blue>Activate Now !</font>
				<? } else { ?>
				<input type=radio name="new_lang3rd" value=""> <font color=red>Hold</font> &nbsp;&nbsp; 
				<input type=radio name="new_lang3rd" value="<?=$lang3rd_tmp?>" checked> <font color=blue>Activated</font>
				<? } ?>
				
				
		</div>
	</div>
	
	
	<div class='form-group'>											
		<label for='cname' class='control-label col-sm-3'>Introduction Page</label>
		<div class='col-sm-9'>
			<input type=radio name="intro_display" value="0" <?=$intro_display_chk0?>> No Intro Page &nbsp;&nbsp; 
			<input type=radio name="intro_display" value="1" <?=$intro_display_chk1?>> <font color=blue>Image Banner</font> &nbsp;&nbsp; 
			<input type=radio name="intro_display" value="2" <?=$intro_display_chk2?>> HTML
		</div>
	</div>
	
	
	<div class='form-group'>											
		<label for='cname' class='control-label col-sm-3'>Main Page Dimension</label>
		<div class='col-sm-9'>
			Width <input type="text" name="main_page_width" maxlength=4 value="<?=$main_page_width?>" style="width:40px;height:20px;text-align:right"> pixel 
			&nbsp;&nbsp;&nbsp; 
			- Contents Width <input type="text" name="main_page_content" maxlength=3 value="<?=$main_page_content?>" style="width:40px;height:20px;text-align:right"> pixel &nbsp;&nbsp; 
			- Space Width <input type="text" name="main_page_space" maxlength=2 value="<?=$main_page_space?>" style="width:40px;height:20px;text-align:right"> pixel
		</div>
	</div>
	
	
	<div class='form-group'>											
		<label for='cname' class='control-label col-sm-3'>Menu Bar Style</label>
		<div class='col-sm-3'>
			<select name="mmbar_set" class='form-control'>
            <? if($mmbar_set == "rolldownA") { ?>
			<option value="rolldownA" selected>Roll Down A</option>
			<? } else { ?>
			<option value="rolldownA">Roll Down A</option>
			<? } ?>
			<? if($mmbar_set == "rolldownB") { ?>
			<option value="rolldownB" selected>Roll Down B - Category</option>
			<? } else { ?>
			<option value="rolldownB">Roll Down B - Category</option>
			<? } ?>
			</select>
		</div>
		<div class='col-sm-3'>
			<select name="new_layout_loginshow" class='form-control'>
			<? if($layout_loginshow == "1") { ?>
			<option value="1" selected>Default Login Menu</option>
			<? } else { ?>
			<option value="1">Default Login Menu</option>
			<? } ?>
			<? if($layout_loginshow == "2") { ?>
			<option value="2" selected>Top Login Menu</option>
			<? } else { ?>
			<option value="2">Top Login Menu</option>
			<? } ?>
			<? if($layout_loginshow == "0") { ?>
			<option value="0" selected>No Login Menu</option>
			<? } else { ?>
			<option value="0">No Login Menu</option>
			<? } ?>
			</select>
		</div>
	</div>
	
	
	<div class='form-group'>											
		<label for='cname' class='control-label col-sm-3'>Banner Display</label>
		<div class='col-sm-9'>
			<? if($banner_show == "random") { ?>
			<input type=radio name="new_banner_show" value="random" checked> Random &nbsp; 
			<? } else { ?>
			<input type=radio name="new_banner_show" value="random"> Random &nbsp; 
			<? } ?>
			<? if($banner_show == "menu") { ?>
			<input type=radio name="new_banner_show" value="menu" checked> Menu (Category) &nbsp; 
			<? } else { ?>
			<input type=radio name="new_banner_show" value="menu"> Menu (Category) &nbsp; 
			<? } ?>
			<!--
			<? if($banner_show == "cat") { ?>
			<input type=radio name="new_banner_show" value="cat" checked> Shop Category &nbsp; 
			<? } else { ?>
			<input type=radio name="new_banner_show" value="cat"> Shop Category &nbsp; 
			<? } ?>
			-->
			<? if($banner_show == "latest") { ?>
			<input type=radio name="new_banner_show" value="latest" checked> Latest One
			<? } else { ?>
			<input type=radio name="new_banner_show" value="latest"> Latest One
			<? } ?>
		</div>
	</div>
	
	
	<div class='form-group'>											
		<label for='cname' class='control-label col-sm-3'>Main Page Includes</label>
		<div class='col-sm-9'>
			<? if($layout_calshow == "1") { ?>
			<input type=checkbox name="layout_calshow" value="1" checked> Calendar
			<? } else { ?>
			<input type=checkbox name="layout_calshow" value="1"> Calendar
			<? } ?>
			
			&nbsp;&nbsp;&nbsp; 
			
			<? if($layout_emagshow == "1") { ?>
			<input type=checkbox name="layout_emagshow" value="1" checked> Magazine
			<? } else { ?>
			<input type=checkbox name="layout_emagshow" value="1"> Magazine
			<? } ?>
			
			&nbsp;&nbsp;&nbsp; 
			
			<? if($layout_shopshow == "1") { ?>
			<input type=checkbox name="layout_shopshow" value="1" checked> Products (Shop)
			<? } else { ?>
			<input type=checkbox name="layout_shopshow" value="1"> Products (Shop)
			<? } ?>
		</div>
	</div>
	
	
	<div class='form-group'>											
		<label for='cname' class='control-label col-sm-3'>- Calendar</label>
		<div class='col-sm-3'>
			<select name='layout_calpermit' class='form-control'>
			<? if($b_permit == "0") { ?>
			<option value="0" selected>0 - Free Access</option>
			<? } else {?>
			<option value="0">0 - Free Access</option>
			<? } ?>

			<? if($b_permit == "1") { ?>
			<option value="1" selected>1 - Writable After Login</option>
			<? } else {?>
			<option value="1">1 - Writable After Login</option>
			<? } ?>

			<? if($b_permit == "2") { ?>
			<option value="2" selected>2 - Read-Only Before/After Login</option>
			<? } else {?>
			<option value="2">2 - Read-Only Before/After Login</option>
			<? } ?>

			<? if($b_permit == "3") { ?>
			<option value="3" selected>3 - Read-Only After Login</option>
			<? } else {?>
			<option value="3">3 - Read-Only After Login</option>
			<? } ?>
			</select>
		</div>
	</div>
	
	
	
	<div class='form-group'>											
		<label for='cname' class='control-label col-sm-3'>Bottom</label>
		<div class='col-sm-9'>
			<? if($bottom == "1") { ?>
			<input type=checkbox name="bottom" value="1" checked> Show Foot Box
			<? } else { ?>
			<input type=checkbox name="bottom" value="1"> Show Foot Box
			<? } ?>
			
			&nbsp;&nbsp; 
			- Background Color <input type="color" name="bottom_bgcolor" maxlength=20 value="<?=$bottom_bgcolor?>" style="width:80px;height:20px">
		</div>
	</div>
	
    
	<div class='form-group'>											
		<label for='cname' class='control-label col-sm-3'></label>
		<div class='col-sm-3'>
		
		
			<?
			$query1C = "SELECT count(uid) FROM wpage_config 
					WHERE lang = '$lang' AND b_depth = '1' AND b_loco != 'main' AND gate = '$key_gate' AND branch_code = '$login_branch'";
			$result1C = mysql_query($query1C);
			$total_record1C = @mysql_result($result1C,0,0);

			$query1D = "SELECT room,b_loco,b_title FROM wpage_config 
					WHERE lang = '$lang' AND b_depth = '1' AND b_loco != 'main' AND gate = '$key_gate' AND branch_code = '$login_branch' 
					ORDER BY b_ord ASC, b_num ASC, room ASC";
			$result1D = mysql_query($query1D);
			?>

			<select name="bottom_menu1" class='form-control'>
			<option value="">:: Select Menu 1</option>
			<?
			for($i1 = 0; $i1 < $total_record1C; $i1++) {
				$menu1_room = mysql_result($result1D,$i1,0);
				$menu1_loco = mysql_result($result1D,$i1,1);
				$menu1_title = mysql_result($result1D,$i1,2);
					$menu1_title = stripslashes($menu1_title);
        
				if($menu1_loco == $bottom_menu1) {
					$menu1_slct = "selected"; 
				} else {
					$menu1_slct = ""; 
				}
				echo("<option value='$menu1_loco' $menu1_slct>$menu1_title ($menu1_loco)</option>");
			}
			?>
			</select>
		
		</div>
		<div class='col-sm-3'>
			
			<?
			$query2C = "SELECT count(uid) FROM wpage_config 
					WHERE lang = '$lang' AND b_depth = '1' AND b_loco != 'main' AND gate = '$key_gate' AND branch_code = '$login_branch'";
			$result2C = mysql_query($query2C);
			$total_record2C = @mysql_result($result2C,0,0);

			$query2D = "SELECT room,b_loco,b_title FROM wpage_config 
					WHERE lang = '$lang' AND b_depth = '1' AND b_loco != 'main' AND gate = '$key_gate' AND branch_code = '$login_branch' 
					ORDER BY b_ord ASC, b_num ASC, room ASC";
			$result2D = mysql_query($query2D);
			?>

			<select name="bottom_menu2" class='form-control'>
			<option value="">:: Select Menu 2</option>
			<?
			for($i2 = 0; $i2 < $total_record2C; $i2++) {
				$menu2_room = mysql_result($result2D,$i2,0);
				$menu2_loco = mysql_result($result2D,$i2,1);
				$menu2_title = mysql_result($result2D,$i2,2);
					$menu2_title = stripslashes($menu2_title);
        
				if($menu2_loco == $bottom_menu2) {
					$menu2_slct = "selected"; 
				} else {
					$menu2_slct = ""; 
				}
				echo("<option value='$menu2_loco' $menu2_slct>$menu2_title ($menu2_loco)</option>");
			}
			?>
			</select>
		</div>
		<div class='col-sm-3'>Foot Box Small Column</div>
	</div>
	
	
	<div class='form-group'>											
		<label for='cname' class='control-label col-sm-3'>Alignment</label>
		<div class='col-sm-9'>
			<? if($align == "left") { ?>
			<input type="radio" name="align" value="left" checked> Left &nbsp;&nbsp;
			<? } else { ?>
			<input type="radio" name="align" value="left"> Left &nbsp;&nbsp;
			<? } ?>
    
			<? if($align == "center" OR $align == "") { ?>
			<input type="radio" name="align" value="center" checked> Center &nbsp;&nbsp;
			<? } else { ?>
			<input type="radio" name="align" value="center"> Center &nbsp;&nbsp;
			<? } ?>
    
			<? if($align == "right") { ?>
			<input type="radio" name="align" value="right" checked> Right &nbsp;&nbsp;
			<? } else { ?>
			<input type="radio" name="align" value="right"> Right &nbsp;&nbsp;
			<? } ?>
		</div>
	</div>
	
	
	<div class='form-group'>											
		<label for='cname' class='control-label col-sm-3'>Background Color</label>
		<div class='col-sm-9'>
			<input type="color" name="bgcolor" maxlength=20 value="<?=$bgcolor?>" style="width:80px;height:20px"> 
			&nbsp;&nbsp; BODY: 
			<input type="color" name="bgcolor_body" maxlength=20 value="<?=$bgcolor_body?>" style="width:80px;height:20px">
		</div>
	</div>
	
	
	<div class='form-group'>											
		<label for='cname' class='control-label col-sm-3'>Background Image</label>
		<div class='col-sm-9'>
			<? if($background == "") { ?>
			<input type="radio" name="background" value="" checked> None &nbsp;&nbsp;
			<? } else { ?>
			<input type="radio" name="background" value=""> None &nbsp;&nbsp;
			<? } ?>
    
			<? if($background == "1") { ?>
			<input type="radio" name="background" value="1" checked> Background Image &nbsp;&nbsp;
			<? } else { ?>
			<input type="radio" name="background" value="1"> Background Image &nbsp;&nbsp;
			<? } ?>
		</div>
	</div>
	
	
	<div class='form-group'>											
		<label for='cname' class='control-label col-sm-3'>&nbsp;&nbsp;</label>
		<div class='col-sm-6'>
			<input type="file" name="bg_img3" class='form-control'>
		</div>
		<div class='col-sm-3'>
			(Replace Background Image)
		</div>
	</div>
	
	
	<div class='form-group'>											
		<label for='cname' class='control-label col-sm-3'>Margin &nbsp;&nbsp;</label>
		<div class='col-sm-9'>
			- Top : <input type="text" name="margin_top" maxlength=3 value="<?=$margin_top?>" style="width:40px;height:20px;text-align:right"> pixel &nbsp;&nbsp; 
			- Left : <input type="text" name="margin_left" maxlength=3 value="<?=$margin_left?>" style="width:40px;height:20px;text-align:right"> pixel
		</div>
	</div>
	
	
	<div class='form-group'>											
		<label for='cname' class='control-label col-sm-3'>Footer Bg Color</label>
		<div class='col-sm-9'>
			<input type="color" name="footbar_bgcolor" maxlength=20 value="<?=$footbar_bgcolor?>" style="width:80px;height:20px">
		</div>
	</div>
	
	

	
	<? echo ("
	
	<div class='form-group'>											
		<label for='cname' class='control-label col-sm-3'>
			<input type=checkbox name='upd_allchk' value='1'> <font color=red>Check</font></label>
		<div class='col-sm-9'>
			<input type='submit' value='$txt_web_layout_01' class='btn btn-primary'>
			<input type='reset' value='$txt_comm_frm07' class='btn btn-default'>
		</div>
	</div>
	</form>
	");
	?>
	

<?
} else {

	echo ("
	<form class='cmxform form-horizontal adminex-form' name='signform2' method='post' ENCTYPE='multipart/form-data' action='website_layout.php'>
	<input type='hidden' name='step_next' value='permit_post'>
	<input type='hidden' name='lang' value='$lang'>
	<input type='hidden' name='key_gate' value='$key_gate'>
	
	<div class='form-group'>											
		<label for='cname' class='control-label col-sm-3'>&nbsp;</label>
		<div class='col-sm-9'>
			<input class='form-control' type='submit' value='$txt_web_layout_02'>
		</div>
	</div>
	</form>
	");


}
?>
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
} else if($step_next == "permit_update") {


	if(!$upd_allchk) {
		$upd_allchk = "0";
	}
	
	$signdate = time();
	$m_ip = getenv('REMOTE_ADDR');
  
	// Save Directory
	if($client_id == "host") {
		$savedir = "user_file";
	} else {
		// $savedir = "user/$client_id/user_file";
		$savedir = "user_file";
	}

	if($upd_allchk == "1") {
	
		if(!$theme_mode) {
			$theme_mode = "0";
		}
		if(!$layout_menushow) {
			$layout_menushow = "0";
		}
		if(!$layout_calshow) {
			$layout_calshow = "0";
		}
		if(!$layout_shopshow) {
			$layout_shopshow = "0";
		}
		if(!$layout_catashow) {
			$layout_catashow = "0";
		}
		if(!$layout_modelshow) {
			$layout_modelshow = "0";
		}
		if(!$layout_emagshow) {
			$layout_emagshow = "0";
		}
		if(!$bottom) {
			$bottom = "0";
		}
		if(!$intro_block) {
			$intro_block = "0";
		}
		
		$bg_img3_txt = "bg_all".".gif";
		
		if($bg_img3 != "") {
			if(!copy($bg_img3,"$savedir/$bg_img3_txt")) {
				error("UPLOAD_COPY_FAILURE");
				exit;
			}
		}
		
		$new_main_page_width = $main_page_content + $main_page_menustripe + $main_page_space;
		
		$query = "UPDATE layout SET default_lang = '$default_lang', lang2nd = '$new_lang2nd', lang3rd = '$new_lang3rd', 
				intro_display = '$intro_display', intro_bgcolor = '$intro_bgcolor', intro_reload = '$intro_reload', 
				intro_margin_top = '$intro_margin_top', intro_block = '$intro_block', main_page = '$new_web_style', 
				main_page_width = '$new_main_page_width', main_page_content = '$main_page_content', main_page_menustripe = '$main_page_menustripe', 
				main_page_space = '$main_page_space', main_page_menuloco = '$main_page_menuloco',
				layout_loginshow = '$new_layout_loginshow', banner_show = '$new_banner_show', 
				layout_calshow = '$layout_calshow', layout_calpermit = '$layout_calpermit', 
				layout_emagshow = '$layout_emagshow', layout_shopshow = '$layout_shopshow',
				bottom = '$bottom', bottom_bgcolor = '$bottom_bgcolor', bottom_menu1 = '$bottom_menu1', bottom_menu2 = '$bottom_menu2', 
				align = '$align', bgcolor = '$bgcolor', bgcolor_body = '$bgcolor_body', 
				background = '$background', margin_top = '$margin_top', margin_left = '$margin_left',
				mmbar_set = '$mmbar_set', mmbar_height = '$mmbar_height', footbar_bgcolor = '$footbar_bgcolor' 
				WHERE uid = '$new_uid' AND gate = '$key_gate' AND branch_code = '$login_branch'";
		$result = mysql_query($query);
		if(!$result) { error("QUERY_ERROR"); exit; }

	}
	
	
	// LOGO Image
	if($photo1 != "") {

			$full_filename1 = explode(".", "$photo1_name");
			$extension1 = $full_filename1[sizeof($full_filename1)-1];
	
			if(strcmp($extension1,"JPG") AND 
			   strcmp($extension1,"jpg") AND
			   strcmp($extension1,"GIF") AND
			   strcmp($extension1,"gif") AND
			   strcmp($extension1,"PNG") AND
			   strcmp($extension1,"png")) 
			{ 
			   error("NO_ACCESS_UPLOAD");
			   exit;
			}

			$new_filename1 = "logo_"."$login_branch"."_1.{$extension1}";

			if($org_photo1 != "") {
				if(!unlink("$savedir/$org_photo1")) {
					error("FILE_DELETE_FAILURE");
					exit;
				}
			}

			  if(!copy("$photo1","$savedir/$photo1_name")) {
			     error("UPLOAD_COPY_FAILURE");
			     exit;
			  }
			  if(!rename("$savedir/$photo1_name","$savedir/$new_filename1")) {
			    error("UPLOAD_COPY_FAILURE");
			    exit;
			  }
			  
			if($photo1 == "") { $upd_filename1 = $org_photo1; } else { $upd_filename1 = $new_filename1; }
			
			$query_logo = "UPDATE client_branch SET img1 = '$upd_filename1' WHERE branch_code = '$login_branch'"; 
			$result_logo = mysql_query($query_logo);
			if(!$result_logo) { error("QUERY_ERROR"); exit; }

	}
	


  echo("<meta http-equiv='Refresh' content='0; URL=$home/website_layout.php?key_gate=$key_gate'>");
  exit;
  

} else if($step_next == "permit_post") {

	$query = "INSERT INTO layout (uid, gate, branch_code) VALUES ('', '$key_gate', '$login_branch')";
	$result = mysql_query($query);
    if(!$result) { error("QUERY_ERROR"); exit; }

  echo("<meta http-equiv='Refresh' content='0; URL=$home/website_layout.php?key_gate=$key_gate'>");
  exit;
  
}

}
?>