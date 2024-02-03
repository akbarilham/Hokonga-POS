<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "inventory";
$smenu = "inventory_stock_out";

if(!$step_next) {

$num_per_page = 10; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/inventory_stock_out.php";
$link_list_action = "$home/inventory_stock_out.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";

$link_post = "$home/inventory_stock_out.php?mode=post&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";
$link_del = "process_stock_del.php?mode=del&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page";
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
		var window_left = 0;
		var window_top = 0;
		ref = ref;      
		window.open(ref,"printpreWin",'width=810,height=650,status=no,scrollbars=yes,top=' + window_top + ',left=' + window_left + '');
	}
	</script>

  </head>



<section id="container" class="">
      
	  <? include "header.inc"; ?>
	  
      <!--main content start-->
      <section id="main-content">

<?
// Filtering

// $keyA = branch_code
// $keyB = brand_code
// $keyC = gudang_code
// $keyD = shop_code


	if($keyB) {
		if($key1) {
			if($key2) {
				if($key3) {
					$sorting_filter1 = "stock_now > '0' AND brand_code = '$keyB' AND catg_code = '$key3'";
				} else {
					$sorting_filter1 = "stock_now > '0' AND brand_code = '$keyB' AND catg_code LIKE '$key2%'";
				}
			} else {
					$sorting_filter1 = "stock_now > '0' AND brand_code = '$keyB' AND catg_code LIKE '$key1%'";
			}
		} else {
					$sorting_filter1 = "stock_now > '0' AND brand_code = '$keyB' AND catg_code != ''";
		}
	} else {
		if($key1) {
			if($key2) {
				if($key3) {
					$sorting_filter1 = "stock_now > '0' AND catg_code = '$key3'";
				} else {
					$sorting_filter1 = "stock_now > '0' AND catg_code LIKE '$key2%'";
				}
			} else {
					$sorting_filter1 = "stock_now > '0' AND catg_code LIKE '$key1%'";
			}
		} else {
					$sorting_filter1 = "stock_now > '0' AND catg_code != ''";
		}
	}



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



// Filter
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

if(!$page) { $page = 1; }


// Total Count ---------------------------------------------------- //
if(!eregi("[^[:space:]]+",$key)) {
  $query = "SELECT count(uid) FROM shop_product_list WHERE $sorting_filter1";
} else {
  $encoded_key = urlencode($key);
  $query = "SELECT count(uid) FROM shop_product_list WHERE $sorting_filter1 AND $keyfield LIKE '%$key%'";  
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
		<? include "navbar_inventory_sco.inc"; ?>
		
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$hsm_name_04_02?>
			
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
				<option value='$PHP_SELF?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3'>$txt_comm_frm20</option>");
			
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
					
					$link_list_branch = "$PHP_SELF?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&key=$key&keyA=$k_branch_code&keyB=$keyB&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3";
				
					echo ("<option value='$link_list_branch' $slc_branch>$k_branch_name</option>");
					
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
							
							$link_list_gudang = "$PHP_SELF?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&keyA=$k_branch_code&keyB=$keyB&keyC=$gd_gudang_code&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3";
							
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
			<form name='search' method='post' action='inventory_stock_out.php'>
			<div class='col-sm-2'>
				<select name='keyfield' class='form-control'>
				<option value='pcode' $chk1>$txt_invn_stockin_06</option>
				<option value='pname' $chk2>$txt_invn_stockin_05</option>
				<option value='org_pcode' $chk3>Original Code</option>
				<option value='org_barcode' $chk4>Original Barcode</option>
				<option value='post_date' $chk5>$txt_invn_stockin_18</option>
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
			
			<form name='search' method='post' action='inventory_stock_out.php'>
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
			<option value='$PHP_SELF?sorting_key=pcode&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3' $chk1>$txt_invn_stockin_06</option>
			<option value='$PHP_SELF?sorting_key=pname&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3' $chk2>$txt_invn_stockin_05</option>
			<option value='$PHP_SELF?sorting_key=org_pcode&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3' $chk3>Original Code</option>
			<option value='$PHP_SELF?sorting_key=org_barcode&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3' $chk4>Original Barcode</option>
			<option value='$PHP_SELF?sorting_key=post_date&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3' $chk5>$txt_invn_stockin_18</option>
			<option value='$PHP_SELF?sorting_key=stock_now&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3' $chk6>$txt_invn_stockin_33</option>
			</select>");
			
			?>
			
			</div>
			</div>
			
			<div>&nbsp;</div>
			
			
        <section id="unseen">
		<table class="table table-bordered table-condensed">
        <thead>
        <tr>
            <th>No.</th>
            <th><?=$txt_invn_stockin_04?></th>
            <th><?=$txt_invn_stockin_06?></th>
			<th><?=$txt_invn_stockin_05?></th>
			<th><?=$txt_invn_stockin_31?></th>
			<th><?=$txt_invn_stockin_32?></th>
			<th colspan=2><?=$txt_invn_stockin_33?></th>
        </tr>
        </thead>
		
		
        <tbody>
<?
// SUM in Warehouse
    if(!eregi("[^[:space:]]+",$key)) {
		$query_tsmW1 = "SELECT sum(stock) FROM shop_product_list_qty WHERE $sorting_filter AND shop_code = '' AND flag = 'in'";
	} else {
		$query_tsmW1 = "SELECT sum(stock) FROM shop_product_list_qty WHERE $sorting_filter AND shop_code = '' AND flag = 'in' AND $keyfield LIKE '%$key%'";
	}
	$result_tsmW1 = mysql_query($query_tsmW1);
	if (!$result_tsmW1) { error("QUERY_ERROR"); exit; }

	$prd_tsmW1_qty_in = @mysql_result($result_tsmW1,0,0);
		$prd_tsmW1_qty_in_K = number_format($prd_tsmW1_qty_in);


	if(!eregi("[^[:space:]]+",$key)) {
		$query_tsmW2 = "SELECT sum(stock) FROM shop_product_list_qty WHERE $sorting_filter AND shop_code != '' AND flag = 'out'";
	} else {
		$query_tsmW2 = "SELECT sum(stock) FROM shop_product_list_qty WHERE $sorting_filter AND shop_code != '' AND flag = 'out' AND $keyfield LIKE '%$key%'";
	}
	$result_tsmW2 = mysql_query($query_tsmW2);
	if (!$result_tsmW2) { error("QUERY_ERROR"); exit; }

	$prd_tsmW2_qty_out = @mysql_result($result_tsmW2,0,0);
		$prd_tsmW2_qty_out_K = number_format($prd_tsmW2_qty_out);

	$prd_tsmW2_qty_now = $prd_tsmW1_qty_in - $prd_tsmW2_qty_out;
		$prd_tsmW2_qty_now_K = number_format($prd_tsmW2_qty_now);


echo ("
<tr height=22>
   <td colspan=4 align=right><b>Total</b></td>
   <td align=right>{$prd_tsm_qty_in_K}</td>
   <td align=right>{$prd_tsm_qty_out_K}</td>
   <td colspan=2 align=right>{$prd_tsm_qty_now_K}</td>
</tr>
");



$time_limit = 60*60*24*$notify_new_article; 

  if(!eregi("[^[:space:]]+",$key)) {
    $query = "SELECT uid,gudang_code,catg_code,pcode,org_pcode,org_barcode,pname,price_orgin,stock_org,supp_code,shop_code,brand_code
      FROM shop_product_list WHERE $sorting_filter1 ORDER BY $sorting_key $sort_now";
  } else {
    $query = "SELECT uid,gudang_code,catg_code,pcode,org_pcode,org_barcode,pname,price_orgin,stock_org,supp_code,shop_code,brand_code
      FROM shop_product_list WHERE $sorting_filter1 AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
  }

$result = mysql_query($query);
if (!$result) {   error("QUERY_ERROR");   exit; }

$article_num = $total_record - $num_per_page*($page-1);

for($i = $first; $i <= $last; $i++) {
   $prd_uid = mysql_result($result,$i,0);   
   $prd_gudang_code = mysql_result($result,$i,1);
   $prd_catg = mysql_result($result,$i,2);
		$query_cg3 = "SELECT mcode,sname FROM shop_catgsml WHERE lang = '$lang' AND scode = '$prd_catg'";
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
   $prd_pcode = mysql_result($result,$i,3);
   $prd_org_pcode = mysql_result($result,$i,4);
   $prd_org_barcode = mysql_result($result,$i,5);
   $prd_name = mysql_result($result,$i,6);
   $prd_price_orgin = mysql_result($result,$i,7);
   		$prd_price_orgin = floatval($prd_price_orgin); //DOUBLE STRING 
   		$prd_price_orgin_K = number_format($prd_price_orgin);
   $prd_qty = mysql_result($result,$i,8);
   		$prd_qty_K = number_format($prd_qty);
   $H_supp_code = mysql_result($result,$i,9);
   $H_shop_code = mysql_result($result,$i,10);
   $H_brand_code = mysql_result($result,$i,11);

        
    // 해당 상품코드의 수량 추출 [입고]
    $query_sub1 = "SELECT sum(stock) FROM shop_product_list_qty WHERE pcode = '$prd_pcode' AND flag = 'in' AND $sorting_filter";
    $result_sub1 = mysql_query($query_sub1);
   
    $sum_qty_in = @mysql_result($result_sub1,0,0);
        $sum_qty_in_K = number_format($sum_qty_in);

    // 해당 상품코드의 수량 추출 [출고]
    $query_sub2 = "SELECT sum(stock) FROM shop_product_list_qty WHERE pcode = '$prd_pcode' AND flag = 'out' AND $sorting_filter";
    $result_sub2 = mysql_query($query_sub2);
   
    $sum_qty_out = @mysql_result($result_sub2,0,0);
        $sum_qty_out_K = number_format($sum_qty_out);
    
    // 해당 상품코드의 수량 추출 [재고]
    $sum_qty_now = $sum_qty_in - $sum_qty_out;
        $sum_qty_now_K = number_format($sum_qty_now);

$uid = $_GET['uid'];

    // 줄 색깔
    if($uid == $prd_uid AND ( $mode == "upd" OR $mode == "del" OR $mode == "post" )) {
      $highlight_color = "#FAFAB4";
    } else {
      $highlight_color = "#FFFFFF";
    }
    
    // 하위 수량 테이블 링크
    $query_qs1 = "SELECT count(uid) FROM shop_product_list_qty WHERE pcode = '$prd_pcode' AND flag = 'out' AND $sorting_filter";
    $result_qs1 = mysql_query($query_qs1,$dbconn);
      if (!$result_qs1) { error("QUERY_ERROR"); exit; }
    $total_qs = @mysql_result($result_qs1,0,0);
    
    if($view == "qty" AND $prd_uid == $uid AND ( $mode == "upd" OR $mode == "del" )) {
      $H_prd_qty_link = "<i class='fa fa-caret-down'></i> <a href='$link_list_action&mode=upd&uid=$prd_uid&view=qty'>$sum_qty_out_K</a>";
    } else {
      $H_prd_qty_link = "<a href='$link_list_action&mode=upd&uid=$prd_uid&view=qty'>$sum_qty_out_K</a>";
    }

  echo ("<tr>");
  echo("<td bgcolor='$highlight_color'>$article_num</td>");
  echo("<td bgcolor='$highlight_color'><a href='#' class='tooltips' title=\"\" data-toggle='tooltip' data-placement='top' data-original-title='$H_catg_full'>$prd_catg</a></td>");
  echo("<td bgcolor='$highlight_color'><a href='#' class='tooltips' title=\"\" data-toggle='tooltip' data-placement='top' data-original-title='$prd_pcode'>$prd_org_pcode</a></td>");
  if($sum_qty_now > '0') {
    echo("<td bgcolor='$highlight_color'><a href='$link_post&uid=$prd_uid'>{$prd_name}</a></td>");
  } else {
    echo("<td bgcolor='$highlight_color'>{$prd_name}</td>");
  }
  echo("<td bgcolor='$highlight_color' align=right>{$sum_qty_in_K}</td>");
  echo("<td bgcolor='$highlight_color' align=right>{$H_prd_qty_link}</td>");
  
  if($sum_qty_now > '0') {
	echo ("<td bgcolor='$highlight_color' align=right><i class='fa fa-chevron-left'></i></td>");
	echo ("<td bgcolor='$highlight_color' align=right><a href='$link_post&uid=$prd_uid'>{$sum_qty_now_K}</a></td>");
  } else {
	echo ("<td bgcolor='$highlight_color' align=right>&nbsp;</td>");
	echo ("<td bgcolor='$highlight_color' align=right>{$sum_qty_now_K}</td>");
  }
      
  echo("</tr>");


  
      // 하위 수량 테이블 보여 주기
      if($view == "qty" AND $uid == "$prd_uid") {
    
        $query_qs2 = "SELECT uid,stock,date,flag,pay_num,gudang_code,supp_code,shop_code,org_uid,date,do_num 
                      FROM shop_product_list_qty WHERE pcode = '$prd_pcode' AND flag = 'out' AND $sorting_filter ORDER BY date ASC";
        $result_qs2 = mysql_query($query_qs2,$dbconn);
        if (!$result_qs2) { error("QUERY_ERROR"); exit; }   

        for($qs = 0; $qs < $total_qs; $qs++) {
          $qs_uid = mysql_result($result_qs2,$qs,0);
          $qs_stock = mysql_result($result_qs2,$qs,1);
          $qs_date = mysql_result($result_qs2,$qs,2);
          $qs_flag = mysql_result($result_qs2,$qs,3);
          $qs_pay_num = mysql_result($result_qs2,$qs,4);
          $qs_gudang_code = mysql_result($result_qs2,$qs,5);
          $qs_supp_code = mysql_result($result_qs2,$qs,6);
          $qs_shop_code = mysql_result($result_qs2,$qs,7);
          $qs_org_uid = mysql_result($result_qs2,$qs,8);
          $qs_date = mysql_result($result_qs2,$qs,9);
          $qs_do_num = mysql_result($result_qs2,$qs,10);
          
          $qday1 = substr($qs_date,0,4);
	        $qday2 = substr($qs_date,4,2);
	        $qday3 = substr($qs_date,6,2);
	        $qday4 = substr($qs_date,8,2);
	        $qday5 = substr($qs_date,10,2);
	        $qday6 = substr($qs_date,12,2);

          if($lang == "ko") {
	          $qs_date_txt = "$qday1"."/"."$qday2"."/"."$qday3".", "."$qday4".":"."$qday5".":"."$qday6";
	        } else {
	          $qs_date_txt = "$qday3"."-"."$qday2"."-"."$qday1".", "."$qday4".":"."$qday5".":"."$qday6";
	        }
          
          // 상품 구입가격 [원가] ★
          $query_qsp = "SELECT price_orgin FROM shop_product_list WHERE uid = '$qs_org_uid'";
          $result_qsp = mysql_query($query_qsp,$dbconn);
          if (!$result_qsp) { error("QUERY_ERROR"); exit; }   
          
          $qs_price_orgin = @mysql_result($result_qsp,0,0);
          $qs_price_orgin_K = number_format($qs_price_orgin);
          
          $qs_tprice_orgin = $qs_price_orgin * $qs_stock;
          $qs_tprice_orgin_K = number_format($qs_tprice_orgin);
          
          // BUY/SELL FLAG
          if($qs_flag == "out") {
            $qs_flag_txt = "<font color=red>OUT (-)</font>";
          } else if($qs_flag == "in") {
            $qs_flag_txt = "<font color=blue>IN (+)</font>";
          } else {
            $qs_flag_txt = "<font color=red>?</font>";
          }
          
          // SHOP 이름 추출
          $query_qs6 = "SELECT shop_name FROM client_shop WHERE shop_code = '$qs_shop_code'";
          $result_qs6 = mysql_query($query_qs6,$dbconn);
          if (!$result_qs6) { error("QUERY_ERROR"); exit; }   
          
          $qs_shop_name = @mysql_result($result_qs6,0,0);
          
          if($qs_uid == $qty_uid) {
            $qs_uid_font_color = "red";
          } else {
            $qs_uid_font_color = "blue";
          }
          
          echo ("
          <tr height=22>
            <form name='qs_signform' method='post' action='inventory_stock_out.php'>
            <input type='hidden' name='step_next' value='permit_qty'>
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
            <input type='hidden' name='page' value='$page'>
            <input type='hidden' name='catg' value='$prd_catg'>
            <input type='hidden' name='new_uid' value='$prd_uid'>
            <input type='hidden' name='qs_uid' value='$qs_uid'>
            <input type='hidden' name='qs_flag' value='$qs_flag'>
            <input type='hidden' name='qs_shop_code' value='$qs_shop_code'>
            <input type='hidden' name='qs_pcode' value='$prd_pcode'>
            <input type='hidden' name='qs_price_orgin' value='$qs_price_orgin'>
            <input type='hidden' name='qs_org_stock' value='$qs_stock'>
            <input type='hidden' name='qs_org_remain' value='$sum_qty_now'>
            
            
            <td>&nbsp;</td>
            <td>$qs_flag_txt</td>

            <td colspan=3>
				<a href='#' class='tooltips' title=\"\" data-toggle='tooltip' data-placement='top' data-original-title='$qs_shop_name'>[$qs_shop_code]</a> $qs_date_txt &nbsp;&nbsp; 
				/ $qs_price_orgin_K x $qs_stock = $qs_tprice_orgin_K
			</td>");
            
            // 각 총출고
            if($qs_flag == "out" AND $qs_do_num == '') { 
              echo ("<td align=right><font color=red>-</font>&nbsp;<input type=text name='qs_stock' value='$qs_stock' style='WIDTH: 40px; HEIGHT: 22px; text-align: center'></td>");
              echo("<td align=center><input type=submit value='+/-' style='WIDTH: 35px' class='btn btn-default btn-xs'></td>");
            } else if($qs_flag == "out" AND $qs_do_num != '') { 
              echo ("<td align=right><font color=red>-</font>&nbsp;<input type=text name='qs_stock' value='$qs_stock' style='WIDTH: 40px; HEIGHT: 22px; text-align: center' disabled></td>");              
			  echo("<td align=center><input type=submit value='+/-' style='WIDTH: 35px' class='btn btn-default btn-xs' disabled></td>");              
            } else {
              echo ("<td align=right><font color=blue>+</font>&nbsp;<input type=text name='qs_stock' value='$qs_stock' style='WIDTH: 40px; HEIGHT: 22px; text-align: center'></td>");
              echo("<td align=center><input type=submit value='+/-' style='WIDTH: 35px' class='btn btn-default btn-xs'></td>");
            }
            
            echo ("
            </form>
            
            <form name='qs_signform' method='post' action='inventory_stock_out.php'>
                  <input type='hidden' name='step_next' value='permit_qty_del'>
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
                  <input type='hidden' name='page' value='$page'>
                  <input type='hidden' name='catg' value='$prd_catg'>
                  <input type='hidden' name='new_uid' value='$prd_uid'>
                  <input type='hidden' name='qs_uid' value='$qs_uid'>
                  <input type='hidden' name='qs_flag' value='$qs_flag'>
                  <input type='hidden' name='qs_shop_code' value='$qs_shop_code'>
                  <input type='hidden' name='qs_pcode' value='$prd_pcode'>
                  <input type='hidden' name='qs_stock' value='$qs_stock'>
                  <input type='hidden' name='qs_org_remain' value='$sum_qty_now'>");

            if($qs_flag == "out" AND $qs_do_num == '') { 
            	echo("<td align=center><input type=submit value='-' style='WIDTH: 35px' class='btn btn-default btn-xs'></td>");
			} else if($qs_flag == "out" AND $qs_do_num != '') { 
				echo("<td align=center><input type=submit value='-' style='WIDTH: 35px' class='btn btn-default btn-xs' disabled></td>");
			} else {
				echo("<td align=center><input type=submit value='-' style='WIDTH: 35px' class='btn btn-default btn-xs'></td>");
			}

         echo("</form>
          </tr>");
            
        }
    
    
    
      }




   $article_num--;
}
?>
		
        </tbody>
        </table>
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
			
        </div>
		
        </section>
		</div>
		</div>
		
	
		


		
		
		
		

		<? if($mode == "post" AND $uid) { ?>
		
		
		<div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            Stock Output
			
            
        </header>
		
        <div class="panel-body">
			
		<form name='signform' class="cmxform form-horizontal adminex-form" method='post' action="inventory_stock_out.php">
		<input type='hidden' name='step_next' value='permit_okay'>
		<input type='hidden' name='sorting_table' value='<?=$sorting_table?>'>
		<input type='hidden' name='sorting_key' value='<?=$sorting_key?>'>
		<input type='hidden' name='keyfield' value='<?=$keyfield?>'>
		<input type='hidden' name='key' value='<?=$key?>'>
		<input type='hidden' name='keyA' value='<?=$keyA?>'>
		<input type='hidden' name='keyB' value='<?=$keyB?>'>
		<input type='hidden' name='keyC' value='<?=$keyC?>'>
		<input type='hidden' name='keyD' value='<?=$keyD?>'>
		<input type='hidden' name='key1' value='<?=$key1?>'>
		<input type='hidden' name='key2' value='<?=$key2?>'>
		<input type='hidden' name='key3' value='<?=$key3?>'>
		<input type='hidden' name='page' value='<?=$page?>'>
		
		  <?
		  $query_upd = "SELECT uid,supp_code,shop_code,branch_code,gudang_code,catg_code,gcode,pcode,pname,
                        price_orgin,price_market,price_sale,stock_org,catg_uid,org_pcode,org_barcode FROM shop_product_list WHERE uid = '$uid'";
          $result_upd = mysql_query($query_upd);
          if(!$result_upd) { error("QUERY_ERROR"); exit; }
          $row_upd = mysql_fetch_object($result_upd);

          $upd_uid = $row_upd->uid;
          $upd_supp_code = $row_upd->supp_code;
          $upd_shop_code = $row_upd->shop_code;
          $upd_branch_code = $row_upd->branch_code;
          $upd_gudang_code = $row_upd->gudang_code;
          $upd_catg_code = $row_upd->catg_code;
          $upd_gcode = $row_upd->gcode;
          $upd_pcode = $row_upd->pcode;
          $upd_pname = $row_upd->pname;
          $upd_price_orgin = $row_upd->price_orgin;
			$upd_price_orgin_K = number_format($upd_price_orgin);
          $upd_price_market = $row_upd->price_market;
			$upd_price_market_K = number_format($upd_price_market);
          $upd_price_sale = $row_upd->price_sale;
			$upd_price_sale_K = number_format($upd_price_sale);
          $upd_stock_org = $row_upd->stock_org;
			$upd_stock_org_K = number_format($upd_stock_org);
          $upd_catg_uid = $row_upd->catg_uid;
		  $upd_org_pcode = $row_upd->org_pcode;
		  $upd_org_barcode = $row_upd->org_barcode;
          
          // 입고 합계
          $query_sumQ1 = "SELECT sum(stock) FROM shop_product_list_qty WHERE org_uid = '$upd_uid' AND flag = 'in'";
          $result_sumQ1 = mysql_query($query_sumQ1);
            if (!$result_sumQ1) { error("QUERY_ERROR"); exit; }
          $this_qty_in = @mysql_result($result_sumQ1,0,0);
          
          // 출고 합계
          $query_sumQ2 = "SELECT sum(stock) FROM shop_product_list_qty WHERE org_uid = '$upd_uid' AND flag = 'out'";
          $result_sumQ2 = mysql_query($query_sumQ2);
            if (!$result_sumQ2) { error("QUERY_ERROR"); exit; }
          $this_qty_out = @mysql_result($result_sumQ2,0,0);
			$this_qty_out_K = number_format($this_qty_out);
          
          // 남은 재고 합계
          $this_qty_now = $this_qty_in - $this_qty_out;
			$this_qty_now_K = number_format($this_qty_now);
          

      echo ("
      <input type=hidden name='add_mode' value='LIST_QTY'>
      <input type=hidden name='old_branch_code' value='$upd_branch_code'>
	  <input type=hidden name='old_gudang_code' value='$upd_gudang_code'>
	  <input type=hidden name='old_supp_code' value='$upd_supp_code'>
	  <input type=hidden name='old_shop_code' value='$upd_shop_code'>
      <input type=hidden name='new_uid' value='$upd_uid'>
      <input type=hidden name='new_qty_uid' value='$qty_uid'>
      <input type=hidden name='new_catg_uid' value='$upd_catg_uid'>
      <input type=hidden name='new_gcode' value='$upd_gcode'>
      <input type=hidden name='new_pcode' value='$upd_pcode'>
	  <input type=hidden name='new_branch_code' value='$key_br'>
      <input type=hidden name='new_price_orgin' value='$upd_price_orgin'>
      <input type=hidden name='new_price_sale' value='$upd_price_sale'>
      <input type=hidden name='old_stock_org' value='$upd_stock_org'>
      <input type=hidden name='old_stock_org_qty' value='$rm2_this_stock'>");
	  ?>
	    
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_invn_gudang_05?></label>
										<div class="col-sm-3">
											<input <?=$catg_disableA?> class="form-control" name="dis_gudang_code" value="<?=$upd_gudang_code?>" type="text" />
										</div>
										<div class="col-sm-2" align=right><?=$txt_invn_stockin_06?></div>
										<div class="col-sm-2">
											<input <?=$catg_disableA?> class="form-control" name="dis_m_cat_code" value="<?=$upd_catg_code?>" type="text" />
										</div>
										<div class="col-sm-2">
											<input <?=$catg_disableA?> class="form-control" name="dis_new_prd_code" value="<?=$upd_pcode?>" type="text" />
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Original Code</label>
										<div class="col-sm-3">
											<input <?=$catg_disableA?> class="form-control" name="dis_org_pcode" value="<?=$upd_org_pcode?>" type="text" />
										</div>
										<div class="col-sm-2" align=right>Original Barcode</div>
										<div class="col-sm-4">
											<input <?=$catg_disableA?> class="form-control" name="dis_org_barcode" value="<?=$upd_org_barcode?>" type="text" />
										</div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">&nbsp;</label>
										<div class="col-sm-9">
											<img src="include/_barcode/html/image.php?code=code39&o=1&dpi=72&t=30&r=2&rot=0&text=<?=$upd_pcode?>&f1=Arial.ttf&f2=8&a1=&a2=&a3=" border=0>
										</div>
                                    </div>
									
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3"><?=$txt_sys_supplier_06?></label>
                                        <div class="col-sm-9">
											<select class="form-control" name="new_supp_code" required>
											<?
											echo ("<option value=\"\">:: $txt_sys_supplier_13</option>");
              
											$query_P1 = "SELECT count(uid) FROM client_supplier";
											$result_P1 = mysql_query($query_P1,$dbconn);
												if (!$result_P1) { error("QUERY_ERROR"); exit; }
      
											$total_P1ss = @mysql_result($result_P1,0,0);
      
											$query_P2 = "SELECT uid,supp_code,supp_name,userlevel FROM client_supplier ORDER BY supp_name ASC"; 
											$result_P2 = mysql_query($query_P2,$dbconn);
												if (!$result_P2) { error("QUERY_ERROR"); exit; }

											for($p = 0; $p < $total_P1ss; $p++) {
												$supp_uid = mysql_result($result_P2,$p,0);
												$supp_code = mysql_result($result_P2,$p,1);
												$supp_name = mysql_result($result_P2,$p,2);
												$supp_userlevel = mysql_result($result_P2,$p,3);
                
												if($supp_code == $upd_supp_code) {
													$supp_slct = "selected";
												} else {
													$supp_slct = "";
												}
              
												echo("<option value='$supp_code' $supp_slct>[$supp_code] $supp_name</option>");
											}
											?>
											</select>
										</div>
                                    </div>
									
									
									<?
									// Product Name, Price & Quantity
									echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_05</label>
                                        <div class='col-sm-9'>
											<input style='text' class='form-control' name='new_prd_name' value='$upd_pname'>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_09</label>
                                        <div class='col-sm-3'>
											<input disabled style='text' class='form-control' name='dis_new_price_orgin' value='$upd_price_orgin_K' style='text-align: right'>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_10</label>
                                        <div class='col-sm-3'>
											<input disabled style='text' class='form-control' name='dis_new_price_market' value='$upd_price_market_K' style='text-align: right'>
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_12</label>
                                        <div class='col-sm-3'>
											<input disabled style='text' class='form-control' name='dis_new_price_sale' value='$upd_price_sale_K' style='text-align: right'>
										</div>
                                    </div>
									
									
									
									
									<!--------- select corporate & warehouse // ----------------------------------------------------->
									
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_comm_frm23</label>
                                        <div class='col-sm-4'>");
											$query_brc = "SELECT count(uid) FROM client_branch WHERE userlevel > '0' AND userlevel < '5'";
											$result_brc = mysql_query($query_brc);
											$total_record_br = @mysql_result($result_brc,0,0);

											$query_br = "SELECT branch_code,branch_name FROM client_branch WHERE userlevel > '0' AND userlevel < '5' ORDER BY branch_code ASC";
											$result_br = mysql_query($query_br);

											echo("<select name='select' onChange=\"MM_jumpMenu('parent',this,0)\" class='form-control' required>");
											echo("<option value=\"\">:: $txt_comm_frm32</option>");

											for($br = 0; $br < $total_record_br; $br++) {
												$br_menu_code = mysql_result($result_br,$br,0);
												$br_menu_name = mysql_result($result_br,$br,1);
        
												if($br_menu_code == $key_br) {
													$br_slc_gate = "selected";
												} else {
													$br_slc_gate = "";
												}
												
												if($br_menu_code == $login_branch) {
													$sx_tag = "";
												} else {
													$sx_tag = "+ [SX]";
												}

												echo("<option value='$PHP_SELF?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&page=$page&uid=$uid&mode=$mode&key_br=$br_menu_code&key_gt=$key_gt&key_sh=$key_sh' $br_slc_gate>[ $br_menu_code ] $br_menu_name $sx_tag</option>");
											}
											echo("</select>
										</div>
                                    </div>");
									
									if($key_br) {
									
									echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_comm_frm24</label>
                                        <div class='col-sm-4'>");
											$query_gtc = "SELECT count(uid) FROM code_gudang WHERE branch_code = '$key_br' AND userlevel > '0'";
											$result_gtc = mysql_query($query_gtc);
											$total_record_gt = @mysql_result($result_gtc,0,0);

											$query_gt = "SELECT gudang_code,gudang_name FROM code_gudang 
														WHERE branch_code = '$key_br' AND userlevel > '0' ORDER BY gudang_code ASC";
											$result_gt = mysql_query($query_gt);

											echo("<select name='new_gudang_code' class='form-control' required>");

											for($gt = 0; $gt < $total_record_gt; $gt++) {
												$gt_menu_code = mysql_result($result_gt,$gt,0);
												$gt_menu_name = mysql_result($result_gt,$gt,1);
        
												if($gt_menu_code == $upd_gudang_code) {
													$gt_slc_gate = "selected";
												} else {
													$gt_slc_gate = "";
												}

												echo("<option value='$gt_menu_code' $gt_slc_gate>[ $gt_menu_code ] $gt_menu_name</option>");
											}
											echo("</select>
											
											
										</div>
                                    </div>
									
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockout_01</label>
                                        <div class='col-sm-4'>
											<select name='new_shop_code' class='form-control'>
											<option value=\"\">- $txt_invn_stockout_41</option>");
              
											$query_S1 = "SELECT count(uid) FROM client_shop WHERE branch_code = '$key_br' AND userlevel > '0'";
											$result_S1 = mysql_query($query_S1,$dbconn);
											if (!$result_S1) { error("QUERY_ERROR"); exit; }
      
											$total_S1ss = @mysql_result($result_S1,0,0);
      
											$query_S2 = "SELECT uid,shop_code,shop_name,associate FROM client_shop 
														WHERE branch_code = '$key_br' AND userlevel > '0' ORDER BY shop_code ASC";
											$result_S2 = mysql_query($query_S2,$dbconn);
											if (!$result_S2) { error("QUERY_ERROR"); exit; }   

											for($s = 0; $s < $total_S1ss; $s++) {
												$shop_uid = mysql_result($result_S2,$s,0);
												$shop_code = mysql_result($result_S2,$s,1);
												$shop_name = mysql_result($result_S2,$s,2);
												$shop_associate = mysql_result($result_S2,$s,3);
                
												if($shop_code == $rm2_this_shop_code) {
													$shop_slct = "selected";
												} else {
													$shop_slct = "";
												}
												
												if($shop_associate == "0") {
													$shop_associate_tag = "- $txt_sys_shop_071";
												} else {
													$shop_associate_tag = " ";
												}
              
												echo("<option value='$shop_code' $shop_slct>[$shop_code] $shop_name $shop_associate_tag</option>");
											}
											echo ("</select>
										</div>
                                    </div>");
									
									}
									
									
									echo ("
									<div class='form-group'>
                                        <label for='cname' class='control-label col-sm-3'>$txt_invn_stockin_17</label>
                                        <div class='col-sm-2'>
											<select name='new_stock_qty' class='form-control'>");
											for($q = 1; $q <= $this_qty_now; $q++) {
												echo("<option value='$q'>$q</option>");
											}
              
											echo ("
											</select>
										</div>
										<div class='col-sm-7'>
											 / $this_qty_now_K ($upd_stock_org_K)  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
											<!--<input type=checkbox name='return' value='1'> <font color=red>$txt_invn_stockout_03</font>-->
										</div>
                                    </div>");
									
									
									
									// Stock-out Not Available when no sale price
									if($upd_price_sale < '1') {
										$stock_output_disable = "disabled";
									} else {
										$stock_output_disable = "";
									}
            
             
									// Condition for only INVENTORY MANAGER that Stock Out to SHOP
									if($login_level == "2" OR $login_level > "3"){
										$btnDisabled = "disabled";
									} else {
										$btnDisabled = "";
									}
			
									
									echo ("
									<div class='form-group'>
                                        <div class='col-sm-offset-3 col-sm-9'>
											<input $stock_output_disable class='btn btn-primary' type='submit' value='$txt_invn_stockout_02'>
										</div>
                                    </div>");
									?>
		
		
		
		
		
		</form>

			
		</div>
		</section>
		</div>
		</div>

		<? } ?>


		
		
		

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
	
	<script src="js/jquery.donutchart.js"></script>
	
	<script>
	(function () {

        $("#donutchart1").donutchart({'size': 100, 'fgColor': '#9ed154', 'bgColor': '#eeeeee' });
        $("#donutchart1").donutchart("animate");

        $("#donutchart2").donutchart({'size': 100, 'fgColor': '#006699', 'bgColor': '#eeeeee'  });
        $("#donutchart2").donutchart("animate");

        $("#donutchart3").donutchart({'size': 100, 'fgColor': '#9ed154', 'bgColor': '#eeeeee'  });
        $("#donutchart3").donutchart("animate");

        $("#donutchart4").donutchart({'size': 100, 'fgColor': '#9ed154', 'bgColor': '#eeeeee'  });
        $("#donutchart4").donutchart("animate");

        $("#donutchart5").donutchart({'size': 100, 'fgColor': '#9ed154', 'bgColor': '#eeeeee'  });
        $("#donutchart5").donutchart("animate");
		
		$("#donutchart6").donutchart({'size': 100, 'fgColor': '#9ed154', 'bgColor': '#eeeeee'  });
        $("#donutchart6").donutchart("animate");
		
		$("#donutchart7").donutchart({'size': 100, 'fgColor': '#9ed154', 'bgColor': '#eeeeee'  });
        $("#donutchart7").donutchart("animate");

    }());
	</script>


  </body>
</html>


<?
} else if($step_next == "permit_okay") {


  $signdate = time();
  $post_date1 = date("Ymd",$signdate);
  $post_date2 = date("His",$signdate);
  $post_dates = "$post_date1"."$post_date2";
  
	  
	// DO Number
	$exp_br_code = explode("_",$login_branch);
	$exp_branch_code = $exp_br_code[1];
  
	$new_do_num = "SJ-"."$exp_branch_code"."-"."$post_dates";
	
	// SX - Sales-Data eXchange
	$new_sx_num = "SX-"."$exp_branch_code"."-"."$post_dates";
	
	
	// 다른 회사[지사]로 Stock 이동시 목적지 창고나 상점 데이터 (_do, _qty)에는 출발지 정보가 입력되어야 함
	// Warehouse ("$new_gudang_code" from "$key_gt")
	// 즉, branch_code2, gudang_code2, shop_code2에 출발지 정보 입력
	// gudang_code가 없을 때
	
	
	if($new_branch_code == $login_branch) {
		$new_branch_code2 = "";
		$new_gudang_code2 = "";
		$new_sx_num2 = ""; // IMPORTANT !
	} else {
		$new_branch_code2 = $new_branch_code;
		$new_gudang_code2 = $new_gudang_code;
		$new_sx_num2 = $new_sx_num; // IMPORTANT !
	}
	
	if($new_shop_code != "" AND $new_shop_code != "cancel") {
		$new_shop_code2 = $new_shop_code;
	} else {
		$new_shop_code2 = "";
	}
	

  
  
  // 상품 수정
  if($add_mode == "LIST_CHG") { // 분할출고시 새로운 상품코드 생성
  
    // 출고 취소의 경우
    // if($new_shop_code == "cancel") {
    //   $new_shop_code2 = "";
    // } else {
    //   $new_shop_code2 = $new_shop_code;
    // }
    
    // 출고 후 남은 재고로 상품정보 변경
    $remain_qty = $old_stock_org - $new_stock_org;
    

    // 분할 출고된 새로운 상품코드 생성
    
    
    
    // 출고 정보 수정 (출고 형식 - 0:전체 출고, 1:분할 출고 / 출고 상태 - 0:미출고, 1:일부 출고, 2:출고 완료)
    $query_sumQ4 = "SELECT sum(this_stock) FROM shop_product_list_qty WHERE org_uid = '$new_uid'";
    $result_sumQ4 = mysql_query($query_sumQ4);
      if (!$result_sumQ4) { error("QUERY_ERROR"); exit; }
    $t_this_qty4 = @mysql_result($result_sumQ4,0,0);
    
    $rm2_query = "SELECT uid,org_stock,this_stock FROM shop_product_list_qty WHERE org_uid = '$new_uid' ORDER BY uid ASC";
    $rm2_result = mysql_query($rm2_query);
    if (!$rm2_result) { error("QUERY_ERROR"); exit; }
    $rm2_this_uid = @mysql_result($rm2_result,0,0);
    $rm2_org_stock = @mysql_result($rm2_result,0,1);
    $rm2_this_stock = @mysql_result($rm2_result,0,2);
    
    if($t_this_qty4) {
      if($t_this_qty4 == $rm2_org_stock) {
        $new_store_type = "1";
        $new_store_status = "2";
      } else {
        $new_store_type = "1";
        $new_store_status = "1";
      }
    } else {
        $new_store_type = "0";
        $new_store_status = "2";
    }
    
    $result_CHG = mysql_query("UPDATE shop_product_list SET store_type = '$new_store_type', store_status = '$new_store_status', 
                  store_date = '$post_dates', shop_code = '$new_shop_code2' WHERE uid = '$new_uid'",$dbconn);
    if(!$result_CHG) { error("QUERY_ERROR"); exit; }



    
  
  } else if($add_mode == "LIST_QTY") { // 출고 ▶▶▶▶▶
  
    // 출고 취소의 경우
    if($new_shop_code == "cancel") {
      $new_shop_code_x = "";
    } else {
      $new_shop_code_x = $new_shop_code;
    }
    
    // 출고 취소
    if($new_shop_code == "cancel") {
    
        /*
        $query_D3 = "DELETE FROM shop_product_list_qty WHERE uid = '$new_qty_uid'";
        $result_D3 = mysql_query($query_D3);
        if (!$result_D3) { error("QUERY_ERROR"); exit; }
        */
    
    } else {
    
        // shop_product_list 상품 상세 정보 추출

          $query_dari = "SELECT uid,catg_uid,branch_code,gate,catg_code,pcode,org_pcode,org_barcode,pname,shop_code,gudang_code,supp_code
            product_color,product_size,product_option1,product_option2,product_option3,product_option4,product_option5,
            currency,price_orgin,price_market,price_sale,price_sale2,price_margin,dc_rate,save_point,stock_org,stock_sell,stock_now,
            sold_out,post_date,upd_date,store_type,store_status,store_date,pay_code,pay_status,pay_date,
            confirm_status,confirm_date,brand_code FROM shop_product_list WHERE uid = '$new_uid'";
          $result_dari = mysql_query($query_dari);
          if(!$result_dari) { error("QUERY_ERROR"); exit; }
          $row_dari = mysql_fetch_object($result_dari);

          $dari_uid = $row_dari->uid;
          $dari_catg_uid = $row_dari->catg_uid;
          $dari_branch_code = $row_dari->branch_code;
          $dari_gate = $row_dari->gate;
          $dari_catg_code = $row_dari->catg_code;
          $dari_pcode = $row_dari->pcode;
		  $dari_org_pcode = $row_dari->org_pcode;
		  $dari_org_barcode = $row_dari->org_barcode;
          $dari_pname = $row_dari->pname;
          $dari_shop_code = $row_dari->shop_code;
          $dari_gudang_code = $row_dari->gudang_code;
          $dari_supp_code = $row_dari->supp_code;
          $dari_product_color = $row_dari->product_color;
          $dari_product_size = $row_dari->product_size;
          $dari_product_option1 = $row_dari->product_option1;
          $dari_product_option2 = $row_dari->product_option2;
          $dari_product_option3 = $row_dari->product_option3;
          $dari_product_option4 = $row_dari->product_option4;
          $dari_product_option5 = $row_dari->product_option5;
          $dari_currency = $row_dari->currency;
		  $dari_price_orgin = $row_dari->price_orgin;
          $dari_price_market = $row_dari->price_market;
          $dari_price_sale = $row_dari->price_sale;
          $dari_price_sale2 = $row_dari->price_sale2;
          $dari_price_margin = $row_dari->price_margin;
          $dari_dc_rate = $row_dari->dc_rate;
          $dari_save_point = $row_dari->save_point;
          $dari_stock_org = $row_dari->stock_org;
          $dari_stock_sell = $row_dari->stock_sell;
          $dari_stock_now = $row_dari->stock_noq;
          $dari_sold_out = $row_dari->sold_out;
          $dari_post_date = $row_dari->post_date;
          $dari_upd_date = $row_dari->dari_upd_date;
          $dari_store_type = $row_dari->store_type;
          $dari_store_status = $row_dari->store_status;
          $dari_store_date = $row_dari->store_date;
          $dari_pay_code = $row_dari->pay_code;
          $dari_pay_status = $row_dari->pay_status;
          $dari_pay_date = $row_dari->pay_date;
          $dari_conform_status = $row_dari->confirm_status;
          $dari_confirm_date = $row_dari->confirm_date;
		  $dari_brand_code = $row_dari->brand_code;
		  
							// Group Code
							$query_sh = "SELECT group_code FROM client_shop WHERE shop_code = '$new_shop_code'";
							$result_sh = mysql_query($query_sh);
								if (!$result_sh) { error("QUERY_ERROR"); exit; }
							$sh_group_code = @mysql_result($result_sh,0,0);
        
        // 판매가격
        
        
        // shop_product_list_qty 출고 정보 입력
        $query_SH3 = "INSERT INTO shop_product_list_qty (uid,org_uid,branch_code,brand_code,gudang_code,group_code,shop_code,catg_code,
          gcode,pcode,org_pcode,org_barcode,supp_code,stock,date,price_orgin,flag,branch_code2,gudang_code2,shop_code2,sx_num) 
		  values ('','$new_uid','$old_branch_code','$dari_brand_code','$old_gudang_code','$sh_group_code','$new_shop_code','$dari_catg_code',
		  '$new_gcode','$new_pcode','$dari_org_pcode','$dari_org_barcode','$new_supp_code','$new_stock_qty','$post_dates','$dari_price_orgin','out',
		  '$new_branch_code2','$new_gudang_code2','$new_shop_code2','$new_sx_num2')";
        $result_SH3 = mysql_query($query_SH3);
        if (!$result_SH3) { error("QUERY_ERROR"); exit; }
        
        
        
          // shop_product_list_shop에 동일 Shop, 동일 상품코드가 있는지 확인
          $scv_query = "SELECT count(uid) FROM shop_product_list_shop WHERE pcode = '$new_pcode' AND shop_code = '$new_shop_code'";
          $scv_result = mysql_query($scv_query,$dbconn);
            if (!$scv_result) { error("QUERY_ERROR"); exit; }
          $scv_count = @mysql_result($scv_result,0,0);
          
          // 하위 수량테이블 수정된 재고 합계 추출
          $s_queryA = "SELECT sum(stock) FROM shop_product_list_qty WHERE pcode = '$new_pcode' AND shop_code = '$new_shop_code' AND flag = 'out'";
          $s_resultA = mysql_query($s_queryA,$dbconn);
              if (!$s_resultA) { error("QUERY_ERROR"); exit; }
          $sA_qty_now = @mysql_result($s_resultA,0,0); // 수정된 수량 합계
          
          // 하위 SHOP 상품 테이블의 판매된 총수 추출
          $s_queryB = "SELECT sum(qty_org),sum(qty_now),sum(qty_sell) FROM shop_product_list_shop 
                        WHERE pcode = '$new_pcode' AND shop_code = '$new_shop_code'"; // Shop이 지정된 재고 수량
          $s_resultB = mysql_query($s_queryB,$dbconn);
              if (!$s_resultB) { error("QUERY_ERROR"); exit; }
          $sB_qty_org = @mysql_result($s_resultB,0,0);
          $sB_qty_now = @mysql_result($s_resultB,0,1);
          $sB_qty_sell = @mysql_result($s_resultB,0,2);
            
          $newA_qty_org = $sA_qty_now; // 변경된 재고: 수정된 수량 합계
          $newA_qty_now = $newA_qty_org - $sB_qty_sell; // 재고수정: 변경된 재고에서 원판매수량을 공제

          
          // 하위 Shop 지정 정보 및 수량 정보 수정
          if($scv_count > "0") { //

            
            // Shop이 지정된 재고수량 변경
            $result_Tv = mysql_query("UPDATE shop_product_list_shop SET qty_org = '$newA_qty_org', qty_now = '$newA_qty_now' 
                        WHERE pcode = '$new_pcode' AND shop_code = '$new_shop_code'",$dbconn);
            if(!$result_Tv) { error("QUERY_ERROR"); exit; }
        
          } else {
        
            // shop_product_list_shop 출고 정보 저장
            $query_R1 = "INSERT INTO shop_product_list_shop (uid,org_uid,branch_code,brand_code,gudang_code,group_code,shop_code,catg_code,
              gcode,pcode,org_pcode,org_barcode,pname,supp_code,product_color,product_size,
              product_option1,product_option2,product_option3,product_option4,product_option5,
              price_orgin,price_market,price_sale,price_sale2,price_margin,
              dc_rate,save_point,qty_org,qty_sell,qty_now,store_date) 
            values ('','$new_uid','$new_branch_code2','$dari_brand_code','$new_gudang_code2','$sh_group_code','$new_shop_code2','$dari_catg_code',
              '$dari_gcode','$dari_pcode','$dari_org_pcode','$dari_org_barcode','$dari_pname','$dari_supp_code',
              '$dari_product_color','$dari_product_size',
              '$dari_product_option1','$dari_product_option2','$dari_product_option3','$dari_product_option4','$dari_product_option5',
              '$dari_price_orgin','$dari_price_market','$dari_price_sale','$dari_price_sale2','$dari_price_margin',
              '$dari_dc_rate','$dari_save_point','$new_stock_qty','0','$new_stock_qty','$post_dates')";
            $result_R1 = mysql_query($query_R1);
            if (!$result_R1) { error("QUERY_ERROR"); exit; }
        
          }
        
        
		
		


      }
    }

  echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_stock_out.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3&page=$page&uid=$new_uid'>");
  exit;



} else if($step_next == "permit_qty") { // 수량 하위테이블 개별정보 수정

    
    // 현재의 남은 수량
    $qs_stock2 = $qs_org_remain + $qs_org_stock;
    
    // 새입력값은 음수나 0이 될 수 없고 남은 수량의 한도 내에 있어야 함
    if($qs_stock > 0 AND $qs_stock <= $qs_stock2) {
      $query_GM2 = "UPDATE shop_product_list_qty SET stock = '$qs_stock' WHERE uid = '$qs_uid'";
      $result_GM2 = mysql_query($query_GM2);
      if (!$result_GM2) { error("QUERY_ERROR"); exit; }
    }

          
          // 하위 수량테이블 수정된 재고 합계 추출
          $s_queryA = "SELECT sum(stock) FROM shop_product_list_qty 
                        WHERE pcode = '$qs_pcode' AND shop_code = '$qs_shop_code' AND flag = 'out'";
          $s_resultA = mysql_query($s_queryA,$dbconn);
              if (!$s_resultA) { error("QUERY_ERROR"); exit; }
          $sA_qty_now = @mysql_result($s_resultA,0,0); // 수정된 수량 합계
          
          // 하위 SHOP 상품 테이블의 판매된 총수 추출
          $s_queryB = "SELECT sum(qty_org),sum(qty_now),sum(qty_sell) FROM shop_product_list_shop 
                        WHERE pcode = '$qs_pcode' AND shop_code = '$qs_shop_code'"; // Shop이 지정된 재고 수량
          $s_resultB = mysql_query($s_queryB,$dbconn);
              if (!$s_resultB) { error("QUERY_ERROR"); exit; }
          $sB_qty_org = @mysql_result($s_resultB,0,0);
          $sB_qty_now = @mysql_result($s_resultB,0,1);
          $sB_qty_sell = @mysql_result($s_resultB,0,2);
          
          $newA_qty_org = $sA_qty_now; // 변경된 재고: 수정된 수량 합계
          $newA_qty_now = $newA_qty_org - $sB_qty_sell; // 재고수정: 변경된 재고에서 원판매수량을 공제

            
          // Shop이 지정된 재고수량 변경
          $result_Tv = mysql_query("UPDATE shop_product_list_shop SET qty_org = '$newA_qty_org', qty_now = '$newA_qty_now' 
                        WHERE pcode = '$qs_pcode' AND shop_code = '$qs_shop_code'",$dbconn);
          if(!$result_Tv) { error("QUERY_ERROR"); exit; }
    



echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_stock_out.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3&page=$page&view=qty&uid=$new_uid'>");
exit;



} else if($step_next == "permit_qty_del") { // 수량 하위테이블 개별정보 삭제

    $query_GM2 = "DELETE FROM shop_product_list_qty WHERE uid = '$qs_uid'";
    $result_GM2 = mysql_query($query_GM2);
    if (!$result_GM2) { error("QUERY_ERROR"); exit; }
    
    
          
          // 하위 수량테이블 수정된 재고 합계 추출
          $s_queryA = "SELECT sum(stock) FROM shop_product_list_qty 
                        WHERE pcode = '$qs_pcode' AND shop_code = '$qs_shop_code' AND flag = 'out'";
          $s_resultA = mysql_query($s_queryA,$dbconn);
              if (!$s_resultA) { error("QUERY_ERROR"); exit; }
          $sA_qty_now = @mysql_result($s_resultA,0,0); // 수정된 수량 합계
          
          // 하위 SHOP 상품 테이블의 판매된 총수 추출
          $s_queryB = "SELECT sum(qty_org),sum(qty_now),sum(qty_sell) FROM shop_product_list_shop 
                        WHERE pcode = '$qs_pcode' AND shop_code = '$qs_shop_code'"; // Shop이 지정된 재고 수량
          $s_resultB = mysql_query($s_queryB,$dbconn);
              if (!$s_resultB) { error("QUERY_ERROR"); exit; }
          $sB_qty_org = @mysql_result($s_resultB,0,0);
          $sB_qty_now = @mysql_result($s_resultB,0,1);
          $sB_qty_sell = @mysql_result($s_resultB,0,2);
            
          $newA_qty_org = $sA_qty_now; // 변경된 재고: 수정된 수량 합계
          $newA_qty_now = $newA_qty_org - $sB_qty_sell; // 재고수정: 변경된 재고에서 원판매수량을 공제

            
          // Shop이 지정된 재고수량 변경
          $result_Tv = mysql_query("UPDATE shop_product_list_shop SET qty_org = '$newA_qty_org', qty_now = '$newA_qty_now' 
                        WHERE pcode = '$qs_pcode' AND shop_code = '$qs_shop_code'",$dbconn);
          if(!$result_Tv) { error("QUERY_ERROR"); exit; }


echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_stock_out.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3&page=$page&view=qty&uid=$new_uid'>");
exit;
}

}
?>