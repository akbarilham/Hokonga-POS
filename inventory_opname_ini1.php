<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "inventory";
$smenu = "inventory_opname_ini1";
if (isset($_POST['sorting_key'])) {
  $sorting_key = $_POST['sorting_key'];
}
if (isset($_POST['keyfield'])) {
  $keyfield = $_POST['keyfield'];
 }
$sorting_table = $_POST['sorting_table']?$_POST['sorting_table']:'';
$step_next = $_POST['step_next'] ? $_POST['step_next'] : '' ; // new code for step_next post
if(!$step_next) {

$num_per_page = 50; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom


$link_list = "$home/inventory_opname_ini1.php";
$link_list_action = "$home/inventory_opname_ini1.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3&page=$page&mode=upd&view=qty";

$link_post = "$home/inventory_opname_ini1.php?mode=post&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3&page=$page";
$link_post_catg = "$home/inventory_opname_ini1.php?mode=post_catg&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3&page=$page";
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
	
	<script language="javascript">
	function Popup_Win(ref) {
		var window_left = (screen.width-800)/2;
		var window_top = (screen.height-480)/2;
		window.open(ref,"cat_win",'width=310,height=320,status=no,top=' + window_top + ',left=' + window_left + '');
	}
	</script>

  </head>



<section id="container" class="">
      
	  <? include "header.inc"; ?>
	  
      <!--main content start-->
      <section id="main-content">

<?
if($keyA AND ($keyC OR $keyD)) {
	$input_box_color = "#006699";
	$submit_dis = "";
} else {
	$input_box_color = "#AAAAAA";
	$submit_dis = "disabled";
}


// Filtering

// $keyA = branch_code
// $keyB = brand_code
// $keyC = gudang_code
// $keyD = shop_code

$keyA = $_GET['keyA'] ? $_GET['keyA'] : '' ;
$keyB = $_GET['keyB'] ? $_GET['keyB'] : '' ;
$keyC = $_GET['keyC'] ? $_GET['keyC'] : '' ;
$keyD = $_GET['keyD'] ? $_GET['keyD'] : '' ;
$key1 = $_GET['key1'] ? $_GET['key1'] : '' ;
$key2 = $_GET['key2'] ? $_GET['key2'] : '' ;
$key3 = $_GET['key3'] ? $_GET['key3'] : '' ;
if($keyA) {
	if($keyB) {
		if($keyC) {
			if($keyD) {
				if($key1) {
					if($key2) {
						if($key3) {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND gudang_code = '$keyC' AND shop_code = '$keyD' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND gudang_code = '$keyC' AND shop_code = '$keyD' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND gudang_code = '$keyC' AND shop_code = '$keyD' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND gudang_code = '$keyC' AND shop_code = '$keyD' AND catg_code != ''";
				}
			} else {
				if($key1) {
					if($key2) {
						if($key3) {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND gudang_code = '$keyC' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND gudang_code = '$keyC' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND gudang_code = '$keyC' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND gudang_code = '$keyC' AND catg_code != ''";
				}
			}
		} else {
			if($keyD) {
				if($key1) {
					if($key2) {
						if($key3) {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND shop_code = '$keyD' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND shop_code = '$keyD' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND shop_code = '$keyD' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND shop_code = '$keyD' AND catg_code != ''";
				}
			} else {
				if($key1) {
					if($key2) {
						if($key3) {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND catg_code != ''";
				}
			}
		}
	} else {
		if($keyC) {
			if($keyD) {
				if($key1) {
					if($key2) {
						if($key3) {
							$sorting_filter = "branch_code = '$keyA' AND gudang_code = '$keyC' AND shop_code = '$keyD' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "branch_code = '$keyA' AND gudang_code = '$keyC' AND shop_code = '$keyD' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "branch_code = '$keyA' AND gudang_code = '$keyC' AND shop_code = '$keyD' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "branch_code = '$keyA' AND gudang_code = '$keyC' AND shop_code = '$keyD' AND catg_code != ''";
				}
			} else {
				if($key1) {
					if($key2) {
						if($key3) {
							$sorting_filter = "branch_code = '$keyA' AND gudang_code = '$keyC' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "branch_code = '$keyA' AND gudang_code = '$keyC' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "branch_code = '$keyA' AND gudang_code = '$keyC' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "branch_code = '$keyA' AND gudang_code = '$keyC' AND catg_code != ''";
				}
			}
		} else {
			if($keyD) {
				if($key1) {
					if($key2) {
						if($key3) {
							$sorting_filter = "branch_code = '$keyA' AND shop_code = '$keyD' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "branch_code = '$keyA' AND shop_code = '$keyD' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "branch_code = '$keyA' AND shop_code = '$keyD' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "branch_code = '$keyA' AND shop_code = '$keyD' AND catg_code != ''";
				}
			} else {
				if($key1) {
					if($key2) {
						if($key3) {
							$sorting_filter = "branch_code = '$keyA' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "branch_code = '$keyA' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "branch_code = '$keyA' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "branch_code = '$keyA' AND catg_code != ''";
				}
			}
		}
	}
} else {
	if($keyB) {
		if($keyC) {
			if($keyD) {
				if($key1) {
					if($key2) {
						if($key3) {
							$sorting_filter = "brand_code = '$keyB' AND gudang_code = '$keyC' AND shop_code = '$keyD' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "brand_code = '$keyB' AND gudang_code = '$keyC' AND shop_code = '$keyD' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "brand_code = '$keyB' AND gudang_code = '$keyC' AND shop_code = '$keyD' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "brand_code = '$keyB' AND gudang_code = '$keyC' AND shop_code = '$keyD' AND catg_code != ''";
				}
			} else {
				if($key1) {
					if($key2) {
						if($key3) {
							$sorting_filter = "brand_code = '$keyB' AND gudang_code = '$keyC' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "brand_code = '$keyB' AND gudang_code = '$keyC' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "brand_code = '$keyB' AND gudang_code = '$keyC' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "brand_code = '$keyB' AND gudang_code = '$keyC' AND catg_code != ''";
				}
			}
		} else {
			if($keyD) {
				if($key1) {
					if($key2) {
						if($key3) {
							$sorting_filter = "brand_code = '$keyB' AND shop_code = '$keyD' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "brand_code = '$keyB' AND shop_code = '$keyD' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "brand_code = '$keyB' AND shop_code = '$keyD' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "brand_code = '$keyB' AND shop_code = '$keyD' AND catg_code != ''";
				}
			} else {
				if($key1) {
					if($key2) {
						if($key3) {
							$sorting_filter = "brand_code = '$keyB' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "brand_code = '$keyB' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "brand_code = '$keyB' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "brand_code = '$keyB' AND catg_code != ''";
				}
			}
		}
	} else {
		if($keyC) {
			if($keyD) {
				if($key1) {
					if($key2) {
						if($key3) {
							$sorting_filter = "gudang_code = '$keyC' AND shop_code = '$keyD' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "gudang_code = '$keyC' AND shop_code = '$keyD' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "gudang_code = '$keyC' AND shop_code = '$keyD' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "gudang_code = '$keyC' AND shop_code = '$keyD' AND catg_code != ''";
				}
			} else {
				if($key1) {
					if($key2) {
						if($key3) {
							$sorting_filter = "gudang_code = '$keyC' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "gudang_code = '$keyC' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "gudang_code = '$keyC' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "gudang_code = '$keyC' AND catg_code != ''";
				}
			}
		} else {
			if($keyD) {
				if($key1) {
					if($key2) {
						if($key3) {
							$sorting_filter = "shop_code = '$keyD' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "shop_code = '$keyD' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "shop_code = '$keyD' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "shop_code = '$keyD' AND catg_code != ''";
				}
			} else {
				if($key1) {
					if($key2) {
						if($key3) {
							$sorting_filter = "catg_code = '$key3'";
						} else {
							$sorting_filter = "catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "catg_code != ''";
				}
			}
		}
	}
}



// 정렬 필터링
if(!$sorting_key) { $sorting_key = "org_pcode"; }
if($sorting_key == "post_date" OR $sorting_key == "stock_now") {
  $sort_now = "DESC";
} else {
  $sort_now = "ASC";
}

if($sorting_key == "pcode") { $chk1 = "selected"; } else { $chk1 = ""; }
if($sorting_key == "pname") { $chk2 = "selected"; } else { $chk2 = ""; }
if($sorting_key == "org_pcode") { $chk3 = "selected"; } else { $chk3 = ""; }
if($sorting_key == "org_barcode") { $chk4 = "selected"; } else { $chk4 = ""; }
if($sorting_key == "post_date") { $chk5 = "selected"; } else { $chk5 = ""; }
if($sorting_key == "stock_now") { $chk6 = "selected"; } else { $chk6 = ""; }


// 공급자용 상품 코드 입력란 필요 여부



//===================== new page code ======================
//Yogi Anditia
if(!$page) { 
  if(isset($_GET['page'])){
    $page = intval($_GET['page']); //get value from url
    if(intval($_GET['page'])==null){
      $page = 1;
    }else{
      $page = intval($_GET['page']); 
    }
  }else{
    $page = 1;
  }
}
//===========================================================


// Total Count ---------------------------------------------------- //
if(!eregi("[^[:space:]]+",$key)) {
  $query = "SELECT count(uid) FROM shop_stock_list WHERE shop_code = '' AND stock_now > '0' AND $sorting_filter";
} else {
  $encoded_key = urlencode($key);
  $query = "SELECT count(uid) FROM shop_stock_list WHERE shop_code = '' AND stock_now > '0' AND $sorting_filter AND $keyfield LIKE '%$key%'";  
}
$result = mysql_query($query);
if (!$result) {
   error("QUERY_ERROR");
   exit;
}
$total_record = mysql_result($result,0,0);
	$total_record_K = number_format($total_record);

// Display Range of records ------------------------------- //
if(!$total_record) {
   $first = 1;
   $last = 0;   
} else {
   $first = $num_per_page*($page-1);
   $last = $num_per_page*$page;

   $IsNext = $total_record - $last;
   if($IsNext > 0) {
      $last -= 1;
   } else {
      $last = $total_record - 1;
   }      
}

$total_page = ceil($total_record/$num_per_page);
?>
    

       
						
		<!--body wrapper start-->
        <div class="wrapper">
		
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$hsm_name_02_022?> &nbsp;&nbsp; - <?=$txt_sys_shop_079?>
			
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
		
			<div class="row">
			<?
			echo ("
			<div class='col-sm-4'>
				<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>
				<option value='$PHP_SELF?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&keyB=$keyB&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3'>$txt_comm_frm20</option>");
			
				$query_guc = "SELECT count(uid) FROM client_branch WHERE branch_code != 'CORP_01'";
				$result_guc = mysql_query($query_guc);
				$total_guc = @mysql_result($result_guc,0,0);

				$query_gu = "SELECT branch_code,branch_name FROM client_branch WHERE branch_code != 'CORP_01' ORDER BY branch_code ASC";
				$result_gu = mysql_query($query_gu);
			
				for($gu = 0; $gu < $total_guc; $gu++) {
					$k_branch_code = mysql_result($result_gu,$gu,0);
					$k_branch_name = mysql_result($result_gu,$gu,1);
        
					if($k_branch_code == $keyA) {
						$slc_branch = "selected";
					} else {
						$slc_branch = "";
					}
					
					$link_list_branch = "$PHP_SELF?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&key=$key&keyA=$k_branch_code&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3";
				
					echo ("<option disabled value='$link_list_branch' $slc_branch>$k_branch_name</option>");
					
						$query_gdc = "SELECT count(uid) FROM code_gudang WHERE branch_code = '$k_branch_code' AND userlevel > '0'";
						$result_gdc = mysql_query($query_gdc);
							if (!$result_gdc) {   error("QUERY_ERROR");   exit; }
    
						$total_gdc = @mysql_result($result_gdc,0,0);
						
						$query_gd = "SELECT branch_code,gudang_code,gudang_name FROM code_gudang WHERE branch_code = '$k_branch_code' AND userlevel > '0' ORDER BY gudang_code ASC";
						$result_gd = mysql_query($query_gd);
							if (!$result_gd) {   error("QUERY_ERROR");   exit; }
    
						for($gd = 0; $gd < $total_gdc; $gd++) {
							$gd_branch_code = mysql_result($result_gd,$gd,0);
							$gd_gudang_code = mysql_result($result_gd,$gd,1);
							$gd_gudang_name = mysql_result($result_gd,$gd,2);
							
							$link_list_gudang = "$PHP_SELF?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&keyA=$gd_branch_code&keyB=$keyB&keyC=$gd_gudang_code&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3";
							
							if($keyC == $gd_gudang_code) {
								echo ("<option value='$link_list_gudang' selected>&nbsp;&nbsp; [$gd_gudang_code] $gd_gudang_name</option></li>");
							} else {
								echo ("<option value='$link_list_gudang'>&nbsp;&nbsp; [$gd_gudang_code] $gd_gudang_name</option>>");
							}
						}
					
				}
			
				echo ("
				</select>
			</div>
			
			<div class='col-sm-2'>
				<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>
				<option value='$PHP_SELF?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&key=$key&keyA=$keyA&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3'>$txt_comm_frm40</option>");
			
				$query_bnc = "SELECT count(uid) FROM shop_brand";
				$result_bnc = mysql_query($query_bnc);
				$total_bnc = @mysql_result($result_bnc,0,0);

				$query_bn = "SELECT brand_code,brand_name FROM shop_brand ORDER BY brand_code ASC";
				$result_bn = mysql_query($query_bn);
			
				for($bn = 0; $bn < $total_bnc; $bn++) {
					$k_brand_code = mysql_result($result_bn,$bn,0);
					$k_brand_name = mysql_result($result_bn,$bn,1);
        
					if($k_brand_code == $keyB) {
						$slc_brand = "selected";
					} else {
						$slc_brand = "";
					}
				
					echo ("<option value='$PHP_SELF?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$k_brand_code&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3' $slc_brand>$k_brand_name</option>");
				}
			
				echo ("
				</select>
			</div>
			
			<div class='col-sm-2'>
				<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>
				<option value='$PHP_SELF?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key2=$key2&key3=$key3'>:: Category 1</option>");
			
				$query_cat1c = "SELECT count(uid) FROM shop_catgbig WHERE lang = '$lang'";
				$result_cat1c = mysql_query($query_cat1c);
				$total_cat1c = @mysql_result($result_cat1c,0,0);

				$query_cat1 = "SELECT lcode,lname FROM shop_catgbig WHERE lang = '$lang' ORDER BY lcode ASC";
				$result_cat1 = mysql_query($query_cat1);
			
				for($cat1 = 0; $cat1 < $total_cat1c; $cat1++) {
					$cat1_code = mysql_result($result_cat1,$cat1,0);
					$cat1_name = mysql_result($result_cat1,$cat1,1);
						$cat1_name = stripslashes($cat1_name);
        
					if($cat1_code == $key1) {
						$slc_cat1 = "selected";
					} else {
						$slc_cat1 = "";
					}
				
					echo ("<option value='$PHP_SELF?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$cat1_code&key2=$key2&key3=$key3' $slc_cat1>$cat1_name</option>");
				}
			
				echo ("
				</select>
			</div>
			
			<div class='col-sm-2'>
				<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>
				<option value='$PHP_SELF?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key3=$key3'>:: Category 2</option>");
			
				$query_cat2c = "SELECT count(uid) FROM shop_catgmid WHERE lang = '$lang' AND lcode = '$key1'";
				$result_cat2c = mysql_query($query_cat2c);
				$total_cat2c = @mysql_result($result_cat2c,0,0);

				$query_cat2 = "SELECT mcode,mname FROM shop_catgmid WHERE lang = '$lang' AND lcode = '$key1' ORDER BY mcode ASC";
				$result_cat2 = mysql_query($query_cat2);
			
				for($cat2 = 0; $cat2 < $total_cat2c; $cat2++) {
					$cat2_code = mysql_result($result_cat2,$cat2,0);
					$cat2_name = mysql_result($result_cat2,$cat2,1);
						$cat2_name = stripslashes($cat2_name);
        
					if($cat2_code == $key2) {
						$slc_cat2 = "selected";
					} else {
						$slc_cat2 = "";
					}
				
					echo ("<option value='$PHP_SELF?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$cat2_code&key3=$key3' $slc_cat2>$cat2_name</option>");
				}
			
				echo ("
				</select>
			</div>
			
			<div class='col-sm-2'>
				<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>
				<option value='$PHP_SELF?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2'>:: Category 3</option>");
			
				$query_cat3c = "SELECT count(uid) FROM shop_catgsml WHERE lang = '$lang' AND lcode = '$key1' AND mcode = '$key2'";
				$result_cat3c = mysql_query($query_cat3c);
				$total_cat3c = @mysql_result($result_cat3c,0,0);

				$query_cat3 = "SELECT scode,sname FROM shop_catgsml WHERE lang = '$lang' AND lcode = '$key1' AND mcode = '$key2' ORDER BY scode ASC";
				$result_cat3 = mysql_query($query_cat3);
			
				for($cat3 = 0; $cat3 < $total_cat3c; $cat3++) {
					$cat3_code = mysql_result($result_cat3,$cat3,0);
					$cat3_name = mysql_result($result_cat3,$cat3,1);
						$cat3_name = stripslashes($cat3_name);
        
					if($cat3_code == $key3) {
						$slc_cat3 = "selected";
					} else {
						$slc_cat3 = "";
					}
				
					echo ("<option value='$PHP_SELF?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$cat3_code' $slc_cat3>$cat3_name</option>");
				}
			
				echo ("
				</select>
			</div>
			");
			
			?>
			
			</div>
			
			<div>&nbsp;</div>
			
			<div class="row">
			<?
			echo ("
			<form name='search1' method='post' action='inventory_opname_ini1.php'>
			<div class='col-sm-2'>
				<select name='keyfield' class='form-control'>
				<option value='org_pcode'>Original Code</option>
				<option value='org_barcode'>Original Barcode</option>
				<option value='pcode'>$txt_invn_stockin_06</option>
				<option value='pname'>$txt_invn_stockin_05</option>
				<option value='post_date'>$txt_invn_stockin_18</option>
				</select>
			</div>
			
			<div class='col-sm-3'>
				<input type='text' name='key' class='form-control'> 
			</div>
			<input type='hidden' name='keyA' value='$keyA'>
			<input type='hidden' name='keyB' value='$keyB'>
			<input type='hidden' name='keyC' value='$keyC'>
			<input type='hidden' name='keyD' value='$keyD'>
			<input type='hidden' name='key1' value='$key1'>
			<input type='hidden' name='key2' value='$key2'>
			<input type='hidden' name='key3' value='$key3'>
			</form>
			
			
			<div class='col-sm-2'>$total_record_K [<font color='navy'>$page</font>/$total_page]</div>
			
			<form name='search2' method='post' action='inventory_opname_ini1.php'>
			<input type='hidden' name='keyfield' value='pname'>
			<div class='col-sm-3'>
				<input type='text' name='key' class='form-control' placeholder='$txt_invn_stockin_05'> 
			</div>
			<input type='hidden' name='keyA' value='$keyA'>
			<input type='hidden' name='keyB' value='$keyB'>
			<input type='hidden' name='keyC' value='$keyC'>
			<input type='hidden' name='keyD' value='$keyD'>
			<input type='hidden' name='key1' value='$key1'>
			<input type='hidden' name='key2' value='$key2'>
			<input type='hidden' name='key3' value='$key3'>
			</form>
			
			<div class='col-sm-2'>
			<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control'>
			<option value='$PHP_SELF?sorting_key=org_pcode&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3' $chk3>Original Code</option>
			<option value='$PHP_SELF?sorting_key=org_barcode&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3' $chk4>Original Barcode</option>
			<option value='$PHP_SELF?sorting_key=post_date&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3' $chk5>$txt_invn_stockin_18</option>
			<option value='$PHP_SELF?sorting_key=pcode&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3' $chk1>$txt_invn_stockin_06</option>
			<option value='$PHP_SELF?sorting_key=pname&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3' $chk2>$txt_invn_stockin_05</option>
			<option value='$PHP_SELF?sorting_key=stock_now&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3' $chk6>$txt_invn_stockin_33</option>
			</select>");
			
			?>
			
			</div>
			</div>

<? if($keyC) { ?>			
			
				<ul class="pagination pagination-sm pull-right">
				<?
				$total_block = ceil($total_page/$page_per_block);
				$block = ceil($page/$page_per_block);

				$first_page = ($block-1)*$page_per_block;
				$last_page = $block*$page_per_block;

				if($total_block <= $block) {
					$last_page = $total_page;
				}

				if($block > 1) {
					$my_page = $first_page;
					echo("<li><a href=\"$link_list?sorting_key=$sorting_key&page=$my_page&keyfield=$keyfield&key=$encoded_key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3\">Prev $page_per_block</a></li>");
				}


				if ($page > 1) {
					$page_num = $page - 1;
					echo("<li><a href=\"$link_list?sorting_key=$sorting_key&page=$page_num&keyfield=$keyfield&key=$encoded_key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3\">&laquo;</a></li>");
				} else {
					echo("<li><a href='#'>&laquo;</a></li>");
				}

				for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
				if($page == $direct_page) {
					echo("<li class='active'><a href='#'>$direct_page</a></li>");
				} else {
					echo("<li><a href=\"$link_list?sorting_key=$sorting_key&page=$direct_page&keyfield=$keyfield&key=$encoded_key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3\">$direct_page</a></li>");
				}
				}

				if ($IsNext > 0) {
				$page_num = $page + 1;   
					echo("<li><a href=\"$link_list?sorting_key=$sorting_key&page=$page_num&keyfield=$keyfield&key=$encoded_key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3\">&raquo;</a></li>");
				} else { 
					echo("<li><a href='#'>&raquo;</a></li>");
				}

				if($block < $total_block) {
					$my_page = $last_page+1;
					echo("<li><a href=\"$link_list?sorting_key=$sorting_key&page=$my_page&keyfield=$keyfield&key=$encoded_key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3\">Next $page_per_block</a>");
				}
				?>
				</ul>
			
			
        <section>
		<table class="table table-bordered table-condensed">
        <thead>
        <tr>
            <th>No.</th>
			<!--<th><?=$txt_sys_brand_14?></th>-->
			<!--<th><?=$txt_invn_stockin_04?></th>-->
			<th><?=$txt_invn_stockin_06?></th>
			<!--<th><?=$txt_invn_stockin_05?></th>-->
			<th><?=$txt_invn_stockin_33?></th>
        </tr>
        </thead>
		
		
        <tbody>
<?
// Total Stocks in WHs

	if(!eregi("[^[:space:]]+",$key)) {
		$query_tsmW1 = "SELECT sum(stock) FROM shop_product_list_qty WHERE $sorting_filter AND flag = 'in' AND shop_code = ''";
	} else {
		$query_tsmW1 = "SELECT sum(stock) FROM shop_product_list_qty WHERE $sorting_filter AND flag = 'in' AND shop_code = '' AND $keyfield LIKE '%$key%'";
	}
	$result_tsmW1 = mysql_query($query_tsmW1);
	if (!$result_tsmW1) { error("QUERY_ERROR"); exit; }

	$prd_tsmW1_qty_in = @mysql_result($result_tsmW1,0,0);
		$prd_tsmW1_qty_in_K = number_format($prd_tsmW1_qty_in);


	if(!eregi("[^[:space:]]+",$key)) {
		$query_tsmW2 = "SELECT sum(stock) FROM shop_product_list_qty WHERE $sorting_filter AND flag = 'out' AND shop_code != ''";
	} else {
		$query_tsmW2 = "SELECT sum(stock) FROM shop_product_list_qty WHERE $sorting_filter AND flag = 'out' AND shop_code != '' AND $keyfield LIKE '%$key%'";
	}
	$result_tsmW2 = mysql_query($query_tsmW2);
	if (!$result_tsmW2) { error("QUERY_ERROR"); exit; }

	$prd_tsmW2_qty_out = @mysql_result($result_tsmW2,0,0);
		$prd_tsmW2_qty_out_K = number_format($prd_tsmW2_qty_out);

	$prd_tsmW2_qty_now = $prd_tsmW1_qty_in - $prd_tsmW2_qty_out;
		$prd_tsmW2_qty_now_K = number_format($prd_tsmW2_qty_now);
	
	// Total Item Count
	if(!eregi("[^[:space:]]+",$key)) {
		$query_tcS1 = "SELECT count(org_pcode) FROM shop_product_list_qty WHERE $sorting_filter AND flag = 'in' AND shop_code = '' AND stock > '0'";
	} else {
		$query_tcS1 = "SELECT count(org_pcode) FROM shop_product_list_qty WHERE $sorting_filter AND flag = 'in' AND shop_code = '' AND stock > '0' AND $keyfield LIKE '%$key%'";
	}
	$result_tcS1 = mysql_query($query_tcS1);
	if (!$result_tcS1) { error("QUERY_ERROR"); exit; }

	$prd_tcS1_qty_in = @mysql_result($result_tcS1,0,0);
		$prd_tcS1_qty_in_K = number_format($prd_tcS1_qty_in);


echo ("
<tr height=22>
   <td>&nbsp;</td>
   <td align=right><b>Total</b></td>
   <td><b>{$prd_tsmW2_qty_now_K}</b> ( $prd_tcS1_qty_in_K items )</td>
</tr>
");


			
			echo ("
			<form name='qs_signform' method='post' action='inventory_opname_ini1.php'>
            <input type='hidden' name='step_next' value='permit_qty_check'>
            <input type='hidden' name='sorting_table' value='$sorting_table'>
            <input type='hidden' name='sorting_key' value='$sorting_key'>
            <input type='hidden' name='keyfield' value='$keyfield'>
            <input type='hidden' name='key' value='$key'>
			<input type='hidden' name='keyA' value='$keyA'>
			<input type='hidden' name='keyB' value='$keyB'>
			<input type='hidden' name='keyC' value='$keyC'>
			<input type='hidden' name='keyD' value='$keyD'>
			<input type='hidden' name='key1' value='$key1'>
			<input type='hidden' name='key2' value='$key2'>
			<input type='hidden' name='key3' value='$key3'>
            <input type='hidden' name='page' value='$page'>");




$time_limit = 60*60*24*$notify_new_article; 

  if(!eregi("[^[:space:]]+",$key)) {
    $query = "SELECT uid,brand_code,catg_code,pcode,supp_code,shop_code,org_pcode,org_barcode,gcode
      FROM shop_stock_list WHERE shop_code = '' AND stock_now > '0' AND $sorting_filter ORDER BY $sorting_key $sort_now";
  } else {
    $query = "SELECT uid,brand_code,catg_code,pcode,supp_code,shop_code,org_pcode,org_barcode,gcode
      FROM shop_stock_list WHERE shop_code = '' AND stock_now > '0' AND $sorting_filter AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
  }

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $H_uid = mysql_result($result,$i,0);   
   $H_brand_code = mysql_result($result,$i,1);
		$query_bname = "SELECT brand_name FROM shop_brand WHERE brand_code = '$H_brand_code'";
		$result_bname = mysql_query($query_bname);
			if (!$result_bname) {   error("QUERY_ERROR");   exit; }
		$H_brand_name = @mysql_result($result_bname,0,0);
   $H_catg_code = mysql_result($result,$i,2);
   
		$query_cg3 = "SELECT mcode,sname FROM shop_catgsml WHERE lang = '$lang' AND scode = '$H_catg_code'";
		$result_cg3 = mysql_query($query_cg3);
			if (!$result_cg3) {   error("QUERY_ERROR");   exit; }
		$cg2_code = @mysql_result($result_cg3,0,0);
		$cg3_name = @mysql_result($result_cg3,0,1);
			$cg3_name = stripslashes($cg3_name);
			
		$query_cg2 = "SELECT lcode,mname FROM shop_catgmid WHERE lang = '$lang' AND mcode = '$cg2_code'";
		$result_cg2 = mysql_query($query_cg2);
			if (!$result_cg2) {   error("QUERY_ERROR");   exit; }
		$cg1_code = @mysql_result($result_cg2,0,0);
		$cg2_name = @mysql_result($result_cg2,0,1);
			$cg2_name = stripslashes($cg2_name);
			
		$query_cg1 = "SELECT lname FROM shop_catgbig WHERE lang = '$lang' AND lcode = '$cg1_code'";
		$result_cg1 = mysql_query($query_cg1);
			if (!$result_cg1) {   error("QUERY_ERROR");   exit; }
		$cg1_name = @mysql_result($result_cg1,0,0);
			$cg1_name = stripslashes($cg1_name);
   
		$H_catg_full = "$cg1_name"." &gt; "."$cg2_name"." &gt; "."$cg3_name";
   
   $H_pcode = mysql_result($result,$i,3);
   $H_supp_code = mysql_result($result,$i,4);
   $H_shop_code = mysql_result($result,$i,5);
   $H_org_pcode = mysql_result($result,$i,6);
   $H_org_barcode = mysql_result($result,$i,7);
   $H_gcode = mysql_result($result,$i,8);

        
    // 해당 상품코드의 수량 추출 [입고]
    $query_sub1 = "SELECT sum(stock) FROM shop_product_list_qty WHERE pcode = '$H_pcode' AND flag = 'in' AND $sorting_filter";
    $result_sub1 = mysql_query($query_sub1);
   
    $sum_qty_in = @mysql_result($result_sub1,0,0);
        $sum_qty_in_K = number_format($sum_qty_in);

    // 해당 상품코드의 수량 추출 [출고]
    $query_sub2 = "SELECT sum(stock) FROM shop_product_list_qty WHERE pcode = '$H_pcode' AND flag = 'out' AND $sorting_filter";
    $result_sub2 = mysql_query($query_sub2);
   
    $sum_qty_out = @mysql_result($result_sub2,0,0);
        $sum_qty_out_K = number_format($sum_qty_out);
    
    // 해당 상품코드의 수량 추출 [재고]
    $sum_qty_now = $sum_qty_in - $sum_qty_out;
        $sum_qty_now_K = number_format($sum_qty_now);
	
	if(!$sum_qty_now OR $sum_qty_now < 1) {
		$sum_qty_now = "";
	}


    // Row Colour
    if(!$sum_qty_now OR $sum_qty_now < 1) {
      $highlight_color = "#FAFAB4";
    } else {
      $highlight_color = "#FFFFFF";
    }
    
    // 하위 수량 테이블 링크
    $query_qs1 = "SELECT count(uid) FROM shop_product_list_qty WHERE pcode = '$H_pcode' AND flag = 'out' AND $sorting_filter";
    $result_qs1 = mysql_query($query_qs1,$dbconn);
      if (!$result_qs1) { error("QUERY_ERROR"); exit; }
    $total_qs = @mysql_result($result_qs1,0,0);
    
    if($view == "qty" AND $prd_uid == $uid AND ( $mode == "upd" OR $mode == "del" )) {
      $H_prd_qty_link = "<i class='fa fa-caret-down'></i> <a href='$link_list?sorting_key=$sorting_key&page=$my_page&keyfield=$keyfield&key=$encoded_key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3&mode=upd&uid=$prd_uid&view=qty'>$sum_qty_out_K</a>";
    } else {
      $H_prd_qty_link = "<a href='$link_list?mode=upd&uid=$prd_uid&view=qty'>$sum_qty_out_K</a>";
    }

	echo ("
	<tr>
		<td bgcolor='$highlight_color'>$article_num</td>
		<!--<td>$H_brand_name</td>-->
		<!--<td><a href='#' class='tooltips' title=\"\" data-toggle='tooltip' data-placement='top' data-original-title='$H_catg_full'>$H_catg_code</a></td>-->
		<td bgcolor='$highlight_color'>$H_org_pcode</td>
		<!--<td>{$H_pname}</td>-->
		<td bgcolor='$highlight_color'><input type='text' name='new_qty_now[$H_uid]' value='$sum_qty_now' maxlength=6 style='border: 1px solid $input_box_color; width:60px; height: 20px; padding-right: 5px; text-align: center'></td>
	</tr>");
    


   $article_num--;
}
?>
		
        </tbody>
        </table>
		
		<input <?=$submit_dis?> type="submit" value="Update this Page" class="btn btn-primary">
		</form>
		</section>
		
		
			
				<ul class="pagination pagination-sm pull-right">
				<?
				$total_block = ceil($total_page/$page_per_block);
				$block = ceil($page/$page_per_block);

				$first_page = ($block-1)*$page_per_block;
				$last_page = $block*$page_per_block;

				if($total_block <= $block) {
					$last_page = $total_page;
				}

				if($block > 1) {
					$my_page = $first_page;
					echo("<li><a href=\"$link_list?sorting_key=$sorting_key&page=$my_page&keyfield=$keyfield&key=$encoded_key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3\">Prev $page_per_block</a></li>");
				}


				if ($page > 1) {
					$page_num = $page - 1;
					echo("<li><a href=\"$link_list?sorting_key=$sorting_key&page=$page_num&keyfield=$keyfield&key=$encoded_key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3\">&laquo;</a></li>");
				} else {
					echo("<li><a href='#'>&laquo;</a></li>");
				}

				for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
				if($page == $direct_page) {
					echo("<li class='active'><a href='#'>$direct_page</a></li>");
				} else {
					echo("<li><a href=\"$link_list?sorting_key=$sorting_key&page=$direct_page&keyfield=$keyfield&key=$encoded_key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3\">$direct_page</a></li>");
				}
				}

				if ($IsNext > 0) {
				$page_num = $page + 1;   
					echo("<li><a href=\"$link_list?sorting_key=$sorting_key&page=$page_num&keyfield=$keyfield&key=$encoded_key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3\">&raquo;</a></li>");
				} else { 
					echo("<li><a href='#'>&raquo;</a></li>");
				}

				if($block < $total_block) {
					$my_page = $last_page+1;
					echo("<li><a href=\"$link_list?sorting_key=$sorting_key&page=$my_page&keyfield=$keyfield&key=$encoded_key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3\">Next $page_per_block</a>");
				}
				?>
				</ul>

<? } ?>
				
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
} else if($step_next == "permit_qty_check") {


	$signdate = time();
	$post_date1 = date("Ymd",$signdate);
	$post_date2 = date("His",$signdate);
	$post_dates = "$post_date1"."$post_date2";
	

	$num_per_page = 50; // number of article lines per page
	$page_per_block = 10; // number of pages displayed in the bottom


	
if($keyA) {
	if($keyB) {
		if($keyC) {
			if($keyD) {
				if($key1) {
					if($key2) {
						if($key3) {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND gudang_code = '$keyC' AND shop_code = '$keyD' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND gudang_code = '$keyC' AND shop_code = '$keyD' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND gudang_code = '$keyC' AND shop_code = '$keyD' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND gudang_code = '$keyC' AND shop_code = '$keyD' AND catg_code != ''";
				}
			} else {
				if($key1) {
					if($key2) {
						if($key3) {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND gudang_code = '$keyC' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND gudang_code = '$keyC' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND gudang_code = '$keyC' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND gudang_code = '$keyC' AND catg_code != ''";
				}
			}
		} else {
			if($keyD) {
				if($key1) {
					if($key2) {
						if($key3) {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND shop_code = '$keyD' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND shop_code = '$keyD' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND shop_code = '$keyD' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND shop_code = '$keyD' AND catg_code != ''";
				}
			} else {
				if($key1) {
					if($key2) {
						if($key3) {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND catg_code != ''";
				}
			}
		}
	} else {
		if($keyC) {
			if($keyD) {
				if($key1) {
					if($key2) {
						if($key3) {
							$sorting_filter = "branch_code = '$keyA' AND gudang_code = '$keyC' AND shop_code = '$keyD' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "branch_code = '$keyA' AND gudang_code = '$keyC' AND shop_code = '$keyD' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "branch_code = '$keyA' AND gudang_code = '$keyC' AND shop_code = '$keyD' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "branch_code = '$keyA' AND gudang_code = '$keyC' AND shop_code = '$keyD' AND catg_code != ''";
				}
			} else {
				if($key1) {
					if($key2) {
						if($key3) {
							$sorting_filter = "branch_code = '$keyA' AND gudang_code = '$keyC' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "branch_code = '$keyA' AND gudang_code = '$keyC' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "branch_code = '$keyA' AND gudang_code = '$keyC' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "branch_code = '$keyA' AND gudang_code = '$keyC' AND catg_code != ''";
				}
			}
		} else {
			if($keyD) {
				if($key1) {
					if($key2) {
						if($key3) {
							$sorting_filter = "branch_code = '$keyA' AND shop_code = '$keyD' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "branch_code = '$keyA' AND shop_code = '$keyD' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "branch_code = '$keyA' AND shop_code = '$keyD' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "branch_code = '$keyA' AND shop_code = '$keyD' AND catg_code != ''";
				}
			} else {
				if($key1) {
					if($key2) {
						if($key3) {
							$sorting_filter = "branch_code = '$keyA' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "branch_code = '$keyA' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "branch_code = '$keyA' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "branch_code = '$keyA' AND catg_code != ''";
				}
			}
		}
	}
} else {
	if($keyB) {
		if($keyC) {
			if($keyD) {
				if($key1) {
					if($key2) {
						if($key3) {
							$sorting_filter = "brand_code = '$keyB' AND gudang_code = '$keyC' AND shop_code = '$keyD' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "brand_code = '$keyB' AND gudang_code = '$keyC' AND shop_code = '$keyD' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "brand_code = '$keyB' AND gudang_code = '$keyC' AND shop_code = '$keyD' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "brand_code = '$keyB' AND gudang_code = '$keyC' AND shop_code = '$keyD' AND catg_code != ''";
				}
			} else {
				if($key1) {
					if($key2) {
						if($key3) {
							$sorting_filter = "brand_code = '$keyB' AND gudang_code = '$keyC' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "brand_code = '$keyB' AND gudang_code = '$keyC' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "brand_code = '$keyB' AND gudang_code = '$keyC' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "brand_code = '$keyB' AND gudang_code = '$keyC' AND catg_code != ''";
				}
			}
		} else {
			if($keyD) {
				if($key1) {
					if($key2) {
						if($key3) {
							$sorting_filter = "brand_code = '$keyB' AND shop_code = '$keyD' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "brand_code = '$keyB' AND shop_code = '$keyD' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "brand_code = '$keyB' AND shop_code = '$keyD' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "brand_code = '$keyB' AND shop_code = '$keyD' AND catg_code != ''";
				}
			} else {
				if($key1) {
					if($key2) {
						if($key3) {
							$sorting_filter = "brand_code = '$keyB' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "brand_code = '$keyB' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "brand_code = '$keyB' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "brand_code = '$keyB' AND catg_code != ''";
				}
			}
		}
	} else {
		if($keyC) {
			if($keyD) {
				if($key1) {
					if($key2) {
						if($key3) {
							$sorting_filter = "gudang_code = '$keyC' AND shop_code = '$keyD' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "gudang_code = '$keyC' AND shop_code = '$keyD' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "gudang_code = '$keyC' AND shop_code = '$keyD' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "gudang_code = '$keyC' AND shop_code = '$keyD' AND catg_code != ''";
				}
			} else {
				if($key1) {
					if($key2) {
						if($key3) {
							$sorting_filter = "gudang_code = '$keyC' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "gudang_code = '$keyC' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "gudang_code = '$keyC' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "gudang_code = '$keyC' AND catg_code != ''";
				}
			}
		} else {
			if($keyD) {
				if($key1) {
					if($key2) {
						if($key3) {
							$sorting_filter = "shop_code = '$keyD' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "shop_code = '$keyD' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "shop_code = '$keyD' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "shop_code = '$keyD' AND catg_code != ''";
				}
			} else {
				if($key1) {
					if($key2) {
						if($key3) {
							$sorting_filter = "catg_code = '$key3'";
						} else {
							$sorting_filter = "catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "catg_code != ''";
				}
			}
		}
	}
}

if(!$sorting_key) { $sorting_key = "org_pcode"; }
if($sorting_key == "post_date" OR $sorting_key == "stock_now") {
  $sort_now = "DESC";
} else {
  $sort_now = "ASC";
}


if(!$page) { $page = 1; }


// Total Count ---------------------------------------------------- //
if(!eregi("[^[:space:]]+",$key)) {
  $query = "SELECT count(uid) FROM shop_stock_list WHERE shop_code = '' AND stock_now > '0' AND $sorting_filter";
} else {
  $encoded_key = urlencode($key);
  $query = "SELECT count(uid) FROM shop_stock_list WHERE shop_code = '' AND stock_now > '0' AND $sorting_filter AND $keyfield LIKE '%$key%'";  
}
$result = mysql_query($query);
if (!$result) {
   error("QUERY_ERROR");
   exit;
}
$total_record = mysql_result($result,0,0);


// Display Range of records ------------------------------- //
if(!$total_record) {
   $first = 1;
   $last = 0;   
} else {
   $first = $num_per_page*($page-1);
   $last = $num_per_page*$page;

   $IsNext = $total_record - $last;
   if($IsNext > 0) {
      $last -= 1;
   } else {
      $last = $total_record - 1;
   }      
}

$total_page = ceil($total_record/$num_per_page);


$time_limit = 60*60*24*$notify_new_article; 

  if(!eregi("[^[:space:]]+",$key)) {
    $query = "SELECT uid,brand_code,catg_code,supp_code,shop_code,org_pcode,org_barcode,gcode
      FROM shop_stock_list WHERE shop_code = '' AND stock_now > '0' AND $sorting_filter ORDER BY $sorting_key $sort_now";
  } else {
    $query = "SELECT uid,brand_code,catg_code,supp_code,shop_code,org_pcode,org_barcode,gcode
      FROM shop_stock_list WHERE shop_code = '' AND stock_now > '0' AND $sorting_filter AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
  }

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $li_uid = mysql_result($result,$i,0);   
   $li_brand_code = mysql_result($result,$i,1);
   $li_catg_code = mysql_result($result,$i,2);
   $li_pcode = mysql_result($result,$i,3);
   $li_supp_code = mysql_result($result,$i,4);
   $li_shop_code = mysql_result($result,$i,5);
   $li_org_pcode = mysql_result($result,$i,6);
   $li_org_barcode = mysql_result($result,$i,7);
   $li_gcode = mysql_result($result,$i,8);

    // Stock IN
	$query_sub1 = "SELECT sum(stock) FROM shop_product_list_qty WHERE pcode = '$li_pcode' AND flag = 'in' AND $sorting_filter";
    $result_sub1 = mysql_query($query_sub1);
    $sum_qty_in = @mysql_result($result_sub1,0,0);

	// Stock OUT
    $query_sub2 = "SELECT sum(stock) FROM shop_product_list_qty WHERE pcode = '$li_pcode' AND flag = 'out' AND $sorting_filter";
    $result_sub2 = mysql_query($query_sub2);
    $sum_qty_out = @mysql_result($result_sub2,0,0);
    
	// Stock Remain
    $sum_qty_now = $sum_qty_in - $sum_qty_out;

	// if($new_qty_now[$li_uid] > 0) {

	// Stocks in WHs
	$query_cnt2dt = "SELECT count(uid),sum(stock) FROM shop_product_list_qty WHERE flag = 'in' AND pcode = '$li_pcode' AND gudang_code = '$keyC'";
	$result_cnt2dt = mysql_query($query_cnt2dt);
		if (!$result_cnt2dt) { error("QUERY_ERROR"); exit; }
	$qty_cnt2dt = @mysql_result($result_cnt2dt,0,0);
	$qty_sum2dt = @mysql_result($result_cnt2dt,0,1);
	
		$query_uid2dt = "SELECT uid FROM shop_product_list_qty WHERE flag = 'in' AND pcode = '$li_pcode' AND gudang_code = '$keyC' ORDER BY uid DESC";
		$result_uid2dt = mysql_query($query_uid2dt);
			if (!$result_uid2dt) { error("QUERY_ERROR"); exit; }
		$max_uid2dt = @mysql_result($result_uid2dt,0,0);
	
		if($qty_cnt2dt > 0) {
		
				$result_U1 = mysql_query("UPDATE shop_product_list_qty SET stock = '$new_qty_now[$li_uid]', date = '$post_dates', date = '$check_dates', 
							org_uid = '$li_uid', branch_code = '$keyA', gudang_code = '$keyC', group_code = '', shop_code = '', 
							virtual = '0', ini = '1' WHERE uid = '$max_uid2dt'");
				if(!$result_U1) { error("QUERY_ERROR"); exit; }
			
				// SUM
				$result_sum = mysql_query("UPDATE shop_product_list SET stock_org = '$new_qty_now[$li_uid]', stock_now = '$new_qty_now[$li_uid]' 
							WHERE pcode = '$li_pcode'");
				if(!$result_sum) { error("QUERY_ERROR"); exit; }
			
		} else {

				$query_SH3 = "INSERT INTO shop_product_list_qty (uid,org_uid,flag,branch_code,supp_code,shop_code,gudang_code,
						catg_code,gcode,pcode,org_pcode,org_barcode,stock,stock_check,stock_loss,date,check_date,virtual,ini) 
						values ('','$li_uid','in','$keyA','$li_supp_code','','$keyC','$li_catg_code','$li_gcode','$li_pcode','$li_org_pcode',
						'$li_org_barcode','$new_qty_now[$li_uid]','0','0','$post_dates','$post_dates','0','1')";
				$result_SH3 = mysql_query($query_SH3);
				if (!$result_SH3) { error("QUERY_ERROR"); exit; }
			
				// SUM
				$result_sum = mysql_query("UPDATE shop_product_list SET stock_org = '$new_qty_now[$li_uid]', stock_now = '$new_qty_now[$li_uid]' 
							WHERE pcode = '$li_pcode'");
				if(!$result_sum) { error("QUERY_ERROR"); exit; }	
				
		}
		
	// }

    


   $article_num--;
}

  

	echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_opname_ini1.php?mode=upd&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3&page=$page'>");
	exit;


}

}
?>