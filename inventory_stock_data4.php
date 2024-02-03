<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "inventory";
$smenu = "inventory_stock_data4";
if (isset($_GET['sorting_key'])) {
  $sorting_key = $_GET['sorting_key'];
}
if (isset($_GET['keyfield'])) {
  $keyfield = $_GET['keyfield'];
 }
$step_next = $_POST['step_next'] ? $_POST['step_next'] : '' ; // new code for step_next post
if(!$step_next) {

$num_per_page = 20; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom

$link_list = "$home/inventory_stock_data4.php";
$link_list_action = "$home/inventory_stock_data4.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3&page=$page&mode=upd&view=qty";
$link_post = "$home/inventory_stock_data3.php4mode=post&sorting_key=$sorting_key&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3&page=$page";
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
// Begining of Stock
$query_ym1 = "SELECT date FROM final_monthly_stock WHERE stock_end > '0' AND date > '1' ORDER BY date DESC";
$result_ym1 = mysql_query($query_ym1);
	if (!$result_ym1) {   error("QUERY_ERROR");   exit; }
$ym1_date = @mysql_result($result_ym1,0,0);
	$ym1_date1 = substr($ym1_date,0,4);
	$ym1_date2 = substr($ym1_date,4,2);
	
	
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
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND gudang_code = '$keyC' AND shop_code LIKE 'A%' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND gudang_code = '$keyC' AND shop_code LIKE 'A%' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND gudang_code = '$keyC' AND shop_code LIKE 'A%' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND gudang_code = '$keyC' AND shop_code LIKE 'A%' AND catg_code != ''";
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
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND shop_code LIKE 'A%' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND shop_code LIKE 'A%' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND shop_code LIKE 'A%' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "branch_code = '$keyA' AND brand_code = '$keyB' AND shop_code LIKE 'A%' AND catg_code != ''";
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
							$sorting_filter = "branch_code = '$keyA' AND gudang_code = '$keyC' AND shop_code LIKE 'A%' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "branch_code = '$keyA' AND gudang_code = '$keyC' AND shop_code LIKE 'A%' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "branch_code = '$keyA' AND gudang_code = '$keyC' AND shop_code LIKE 'A%' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "branch_code = '$keyA' AND gudang_code = '$keyC' AND shop_code LIKE 'A%' AND catg_code != ''";
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
							$sorting_filter = "branch_code = '$keyA' AND shop_code LIKE 'A%' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "branch_code = '$keyA' AND shop_code LIKE 'A%' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "branch_code = '$keyA' AND shop_code LIKE 'A%' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "branch_code = '$keyA' AND shop_code LIKE 'A%' AND catg_code != ''";
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
							$sorting_filter = "brand_code = '$keyB' AND gudang_code = '$keyC' AND shop_code LIKE 'A%' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "brand_code = '$keyB' AND gudang_code = '$keyC' AND shop_code LIKE 'A%' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "brand_code = '$keyB' AND gudang_code = '$keyC' AND shop_code LIKE 'A%' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "brand_code = '$keyB' AND gudang_code = '$keyC' AND shop_code LIKE 'A%' AND catg_code != ''";
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
							$sorting_filter = "brand_code = '$keyB' AND shop_code LIKE 'A%' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "brand_code = '$keyB' AND shop_code LIKE 'A%' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "brand_code = '$keyB' AND shop_code LIKE 'A%' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "brand_code = '$keyB' AND shop_code LIKE 'A%' AND catg_code != ''";
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
							$sorting_filter = "gudang_code = '$keyC' AND shop_code LIKE 'A%' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "gudang_code = '$keyC' AND shop_code LIKE 'A%' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "gudang_code = '$keyC' AND shop_code LIKE 'A%' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "gudang_code = '$keyC' AND shop_code LIKE 'A%' AND catg_code != ''";
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
							$sorting_filter = "shop_code LIKE 'A%' AND catg_code = '$key3'";
						} else {
							$sorting_filter = "shop_code LIKE 'A%' AND catg_code LIKE '$key2%'";
						}
					} else {
							$sorting_filter = "shop_code LIKE 'A%' AND catg_code LIKE '$key1%'";
					}
				} else {
							$sorting_filter = "shop_code LIKE 'A%' AND catg_code != ''";
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
		<? // include "navbar_inventory_sco.inc"; ?>
		
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            <?=$txt_sales_sales_01?> (<?=$txt_sys_shop_072?>)
			
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
				<option value='$PHP_SELF?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&keyB=$keyB&keyC=$keyC&key1=$key1&key2=$key2&key3=$key3'>$txt_comm_frm20</option>");
			
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
					
					$link_list_branch = "$PHP_SELF?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&key=$key&keyA=$k_branch_code&keyB=$keyB&keyC=$keyC&key1=$key1&key2=$key2&key3=$key3";
				
					echo ("<option disabled value='$link_list_branch' $slc_branch>$k_branch_name</option>");
					

							$query_sh1c = "SELECT count(uid) FROM client_shop WHERE branch_code = '$k_branch_code' AND associate = '1' AND shop_type = 'off'";
							$result_sh1c = mysql_query($query_sh1c);
								if (!$result_sh1c) {   error("QUERY_ERROR");   exit; }
    
							$total_sh1c = @mysql_result($result_sh1c,0,0);
							
							$query_sh1 = "SELECT shop_code,shop_name FROM client_shop WHERE branch_code = '$k_branch_code' AND associate = '1' AND shop_type = 'off' 
										ORDER BY shop_code ASC";
							$result_sh1 = mysql_query($query_sh1);
								if (!$result_sh1) {   error("QUERY_ERROR");   exit; }
    
							for($sh1 = 0; $sh1 < $total_sh1c; $sh1++) {
								$sh1_shop_code = mysql_result($result_sh1,$sh1,0);
								$sh1_shop_name = mysql_result($result_sh1,$sh1,1);
								
								$link_list_sh1 = "$PHP_SELF?sorting_key=$sorting_key&page=$my_page&keyfield=$keyfield&key=$encoded_key&keyA=$k_branch_code&keyB=$keyB&keyC=$keyC&keyD=$sh1_shop_code&key1=$key1&key2=$key2&key3=$key3";
							
								if($keyD == $sh1_shop_code) {
									echo ("<option value='$link_list_sh1' selected>&nbsp;&nbsp; [$sh1_shop_code] $sh1_shop_name</option>");
								} else {
									echo ("<option value='$link_list_sh1'>&nbsp;&nbsp; [$sh1_shop_code] $sh1_shop_name</option>");
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
			<form name='search1' method='post' action='inventory_stock_data4.php'>
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
			
			<form name='search2' method='post' action='inventory_stock_data4.php'>
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
			
			<div>&nbsp;</div>
			
			
        <section id="unseen">
		<table class="table table-bordered table-condensed">
        <thead>
        <tr>
            <th>No.</th>
            <th><?=$txt_sys_brand_14?></th>
			<th><?=$txt_invn_stockin_04?></th>
            <th><?=$txt_invn_stockin_06?></th>
			<th><?=$txt_invn_stockin_05?></th>
			
			<?
			if($keyD) {
			
				echo ("
				<th>$txt_invn_stockin_71</th>
				<th>$txt_invn_stockin_31</th>
				<th>$txt_invn_stockin_32</th>
				<th>$txt_invn_stockin_33</th>
				<th>$txt_invn_stockin_72</th>
				");
			
			} else {
				
				echo ("<th>TOTAL</th>");
				
				$query_gc = "SELECT count(uid) FROM client_branch WHERE branch_code != 'CORP_01'";
				$result_gc = mysql_query($query_gc);
					if (!$result_gc) {   error("QUERY_ERROR");   exit; }
				$total_gc = @mysql_result($result_gc,0,0);
				
				// store 게시물 수 제한
				// if($total_gc > 5) {
				// 	$total_gc = 5;
				// }
				
				
				$query_g = "SELECT branch_code,branch_name,branch_name2 FROM client_branch WHERE branch_code != 'CORP_01' ORDER BY branch_code ASC";
				$result_g = mysql_query($query_g);
				if (!$result_g) {   error("QUERY_ERROR");   exit; }
    
				for($g = 0; $g < $total_gc; $g++) {
					$g_branch_code = mysql_result($result_g,$g,0);
					$g_branch_name = mysql_result($result_g,$g,1);
					$g_branch_name2 = mysql_result($result_g,$g,2);
					
					$link_list_g = "$link_list?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&keyA=$g_branch_code&keyB=$keyB&keyC=$keyC&key1=$key1&key2=$key2&key3=$key3";
							
					echo ("<th><a href='$link_list_g' class='tooltips' title=\"\" data-toggle='tooltip' data-placement='top' data-original-title='$g_branch_name'><b>$g_branch_name2</b></a></th>");
				
				}
				
			}
			?>		
        </tr>
        </thead>
		
		
        <tbody>
<?
// Previous Stock
if(!eregi("[^[:space:]]+",$key)) {
	$query_prv = "SELECT sum(stock_end) FROM final_monthly_stock WHERE $sorting_filter AND date = '$ym1_date'";
} else {
	$query_prv = "SELECT sum(stock_end) FROM final_monthly_stock WHERE $sorting_filter AND date = '$ym1_date' AND $keyfield LIKE '%$key%'";
}
$result_prv = mysql_query($query_prv);
if (!$result_prv) { error("QUERY_ERROR"); exit; }

$prv_stock_end = @mysql_result($result_prv,0,0);
	$prv_stock_end_K = number_format($prv_stock_end);
	
	

	if(!eregi("[^[:space:]]+",$key)) {
		$query_tsmS1 = "SELECT sum(stock) FROM shop_product_list_qty WHERE $sorting_filter AND flag = 'out'";
	} else {
		$query_tsmS1 = "SELECT sum(stock) FROM shop_product_list_qty WHERE $sorting_filter AND flag = 'out' AND $keyfield LIKE '%$key%'";
	}
	$result_tsmS1 = mysql_query($query_tsmS1);
	if (!$result_tsmS1) { error("QUERY_ERROR"); exit; }

	$prd_tsmS1_qty_in = @mysql_result($result_tsmS1,0,0);
		$prd_tsmS1_qty_in_K = number_format($prd_tsmS1_qty_in);


	if(!eregi("[^[:space:]]+",$key)) {
		$query_tsmS2 = "SELECT sum(stock) FROM shop_product_list_qty WHERE $sorting_filter AND flag = 'out2'";
	} else {
		$query_tsmS2 = "SELECT sum(stock) FROM shop_product_list_qty WHERE $sorting_filter AND flag = 'out2' AND$keyfield LIKE '%$key%'";
	}
	$result_tsmS2 = mysql_query($query_tsmS2);
	if (!$result_tsmS2) { error("QUERY_ERROR"); exit; }

	$prd_tsmS2_qty_out = @mysql_result($result_tsmS2,0,0);
		$prd_tsmS2_qty_out_K = number_format($prd_tsmS2_qty_out);

	$prd_tsmS2_qty_now = $prd_tsmS1_qty_in - $prd_tsmS2_qty_out;
		$prd_tsmS2_qty_now_K = number_format($prd_tsmS2_qty_now);

$prd_grand_total_stock = $prd_tsmS2_qty_now + $prv_stock_end;
	$prd_grand_total_stock_K = number_format($prd_grand_total_stock);
	


echo ("
<tr height=22>
   <td colspan=5 align=right><b>Total</b></td>");
   
	if($keyD) {
	echo ("
	<td align=right>$prv_stock_end_K</td>
	<td align=right>{$prd_tsmS1_qty_in_K}</td>
	<td align=right>{$prd_tsmS2_qty_out_K}</td>
	<td align=right>{$prd_tsmS2_qty_now_K}</td>
	<td align=right>$prd_grand_total_stock_K</td>
	");

	} else {
	
				// Total
				$query_gsum = "SELECT sum(stock_end) FROM final_monthly_stock WHERE $sorting_filter AND date = '$ym1_date'";
				$result_gsum = mysql_query($query_gsum);
					if (!$result_gsum) { error("QUERY_ERROR"); exit; }
				$prd_gsum_now = @mysql_result($result_gsum,0,0);

				
				$query_gsum1 = "SELECT sum(stock) FROM shop_product_list_qty WHERE $sorting_filter AND flag = 'out'";
				$result_gsum1 = mysql_query($query_gsum1);
					if (!$result_gsum1) { error("QUERY_ERROR"); exit; }

				$prd_gsum1_qty = @mysql_result($result_gsum1,0,0);
					$prd_gsum1_qty_K = number_format($prd_gsum1_qty);
					
				$query_gsum2 = "SELECT sum(stock) FROM shop_product_list_qty WHERE $sorting_filter AND flag = 'out2'";
				$result_gsum2 = mysql_query($query_gsum2);
					if (!$result_gsum2) { error("QUERY_ERROR"); exit; }

				$prd_gsum2_qty = @mysql_result($result_gsum2,0,0);
					$prd_gsum2_qty_K = number_format($prd_gsum2_qty);
					
				$prd_gsum3_qty = $prd_gsum_now + $prd_gsum1_qty - $prd_gsum2_qty; // Stock
					$prd_gsum3_qty_K = number_format($prd_gsum3_qty);
				
				echo ("<td align=right>{$prd_gsum3_qty_K}</td>");
				
    
				for($g = 0; $g < $total_gc; $g++) {
					$g_branch_code = mysql_result($result_g,$g,0);
					
					// SUM
					$query_tsum = "SELECT sum(stock_end) FROM final_monthly_stock WHERE $sorting_filter AND branch_code = '$g_branch_code' AND date = '$ym1_date'";
					$result_tsum = mysql_query($query_tsum);
						if (!$result_tsum) { error("QUERY_ERROR"); exit; }
					$prd_tsum_now = @mysql_result($result_tsum,0,0);

					
					$query_tsum1 = "SELECT sum(stock) FROM shop_product_list_qty 
								WHERE $sorting_filter AND flag = 'out' AND branch_code = '$g_branch_code'";
					$result_tsum1 = mysql_query($query_tsum1);
						if (!$result_tsum1) { error("QUERY_ERROR"); exit; }
					$prd_tsum1_qty = @mysql_result($result_tsum1,0,0);
						$prd_tsum1_qty_K = number_format($prd_tsum1_qty);
					
					$query_tsum2 = "SELECT sum(stock) FROM shop_product_list_qty 
								WHERE $sorting_filter AND flag = 'out2' AND branch_code = '$g_branch_code'";
					$result_tsum2 = mysql_query($query_tsum2);
						if (!$result_tsum2) { error("QUERY_ERROR"); exit; }
					$prd_tsum2_qty = @mysql_result($result_tsum2,0,0);
						$prd_tsum2_qty_K = number_format($prd_tsum2_qty);
					
					$prd_tsum3_qty = $prd_tsum_now + $prd_tsum1_qty - $prd_tsum2_qty; // Stock
						$prd_tsum3_qty_K = number_format($prd_tsum3_qty);
					
							
					echo ("<td>$prd_tsum3_qty_K</td>");
				
				}
	}
	echo ("
</tr>");


$time_limit = 60*60*24*$notify_new_article; 

  if(!eregi("[^[:space:]]+",$key)) {
    $query = "SELECT uid,brand_code,catg_code,pcode,pname,price_orgin,stock_org,supp_code,shop_code,org_pcode,org_barcode,gcode
      FROM shop_product_list WHERE $sorting_filter1 ORDER BY $sorting_key $sort_now";
  } else {
    $query = "SELECT uid,brand_code,catg_code,pcode,pname,price_orgin,stock_org,supp_code,shop_code,org_pcode,org_barcode,gcode
      FROM shop_product_list WHERE $sorting_filter1 AND $keyfield LIKE '%$key%' ORDER BY $sorting_key $sort_now";
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
   $H_pname = mysql_result($result,$i,4);
   $H_price_orgin = mysql_result($result,$i,5);
   		$H_price_orgin = floatval($H_price_orgin); //DOUBLE STRING 
   		$H_price_orgin_K = number_format($H_price_orgin);
   $H_qty = mysql_result($result,$i,6);
   		$H_qty_K = number_format($prd_qty);
   $H_supp_code = mysql_result($result,$i,7);
   $H_shop_code = mysql_result($result,$i,8);
   $H_org_pcode = mysql_result($result,$i,9);
   $H_org_barcode = mysql_result($result,$i,10);
   $H_gcode = mysql_result($result,$i,11);

        
    // Stock of Begining
	$query_sub1 = "SELECT sum(stock_end) FROM final_monthly_stock WHERE pcode = '$H_pcode' AND date = '$ym1_date' AND $sorting_filter";
	$result_sub1 = mysql_query($query_sub1);
		if (!$result_sub1) { error("QUERY_ERROR"); exit; }
	$sub1_qty = @mysql_result($result_sub1,0,0);
		$sub1_qty_K = number_format($sub1_qty);
	
	// 해당 상품코드의 수량 추출 [입고]
    $query_sub1 = "SELECT sum(stock) FROM shop_product_list_qty WHERE pcode = '$H_pcode' AND flag = 'out' AND $sorting_filter";
    $result_sub1 = mysql_query($query_sub1);
   
    $sum_qty_in = @mysql_result($result_sub1,0,0);
        $sum_qty_in_K = number_format($sum_qty_in);

    // 해당 상품코드의 수량 추출 [출고]
    $query_sub2 = "SELECT sum(stock) FROM shop_product_list_qty WHERE pcode = '$H_pcode' AND flag = 'out2' AND $sorting_filter";
    $result_sub2 = mysql_query($query_sub2);
   
    $sum_qty_out = @mysql_result($result_sub2,0,0);
        $sum_qty_out_K = number_format($sum_qty_out);
    
    // 해당 상품코드의 수량 추출 [재고]
    $sum_qty_now = $sum_qty_in - $sum_qty_out;
        $sum_qty_now_K = number_format($sum_qty_now);
	
	// Stock Final
	$sum_qty_now2 = $sub1_qty + $sum_qty_now;
		$sum_qty_now2_K = number_format($sum_qty_now2);



    // 줄 색깔
    if($uid == $H_uid AND ( $mode == "upd" OR $mode == "del" OR $mode == "post" )) {
      $highlight_color = "#FAFAB4";
    } else {
      $highlight_color = "#FFFFFF";
    }
    
    // 하위 수량 테이블 링크
    $query_qs1 = "SELECT count(uid) FROM shop_product_list_qty WHERE pcode = '$H_pcode' AND $sorting_filter";
    $result_qs1 = mysql_query($query_qs1,$dbconn);
      if (!$result_qs1) { error("QUERY_ERROR"); exit; }
    $total_qs = @mysql_result($result_qs1,0,0);
    
	if($keyC) {
		if($view == "qty" AND $H_uid == $uid AND ( $mode == "upd" OR $mode == "del" )) {
			$H_prd_qty_link = "<i class='fa fa-caret-down'></i> <a href='$link_list_action&mode=upd&uid=$H_uid&view=qty'>$sum_qty_out_K</a>";
		} else {
			$H_prd_qty_link = "<a href='$link_list_action&mode=upd&uid=$H_uid&view=qty'>$sum_qty_out_K</a>";
		}
	} else {
			$H_prd_qty_link = "$sum_qty_out_K";
	}

  echo ("<tr>");
	echo("<td bgcolor='$highlight_color'>$article_num</td>");
	echo("<td bgcolor='$highlight_color'>$H_brand_name</td>");
  
	echo("<td bgcolor='$highlight_color'><a href='#' class='tooltips' title=\"\" data-toggle='tooltip' data-placement='top' data-original-title='$H_catg_full'>$H_catg_code</a></td>");
	echo("<td bgcolor='$highlight_color'>$H_org_pcode</td>");
	
	if($keyD) {
		echo("<td bgcolor='$highlight_color'><a href='$link_list_action&mode=upd&uid=$H_uid&view=qty'>{$H_pname}</a></td>");
	} else {
		echo("<td bgcolor='$highlight_color'>{$H_pname}</td>");
	}

	if($keyD) {
		
		echo ("
		<td bgcolor='$highlight_color' align=right>{$sub1_qty_K}</td>
		<td bgcolor='$highlight_color' align=right>{$sum_qty_in_K}</td>
		<td bgcolor='$highlight_color' align=right>{$sum_qty_out_K}</td>
		<td bgcolor='$highlight_color' align=right>{$sum_qty_now_K}</td>
		<td bgcolor='$highlight_color' align=right>{$sum_qty_now2_K}</td>");

	} else {
		
		echo ("<td align=right>{$sum_qty_now_K}</td>");
    
				for($g = 0; $g < $total_gc; $g++) {
					$g_branch_code = mysql_result($result_g,$g,0);

					
					// SUM
					$query_sum1 = "SELECT sum(stock) FROM shop_product_list_qty 
								WHERE $sorting_filter AND flag = 'out' AND branch_code = '$g_branch_code' AND pcode = '$H_pcode'";
					$result_sum1 = mysql_query($query_sum1);
						if (!$result_sum1) { error("QUERY_ERROR"); exit; }

					$prd_sum1_qty = @mysql_result($result_sum1,0,0);
						$prd_sum1_qty_K = number_format($prd_sum1_qty);
					
					$query_sum2 = "SELECT sum(stock) FROM shop_product_list_qty 
								WHERE $sorting_filter AND flag = 'out2' AND branch_code = '$g_branch_code' AND pcode = '$H_pcode'";
					$result_sum2 = mysql_query($query_sum2);
						if (!$result_sum2) { error("QUERY_ERROR"); exit; }

					$prd_sum2_qty = @mysql_result($result_sum2,0,0);
						$prd_sum2_qty_K = number_format($prd_sum2_qty);
					
					$prd_sum3_qty = $prd_sum1_qty - $prd_sum2_qty; // Stock
						$prd_sum3_qty_K = number_format($prd_sum3_qty);
					
							
					echo ("<td>$prd_sum3_qty_K</td>");
				
				}
	}
	
	
  
      
  echo("</tr>");


  
      // 하위 수량 테이블 보여 주기
      if($view == "qty" AND $uid == "$H_uid") {
    
        $query_qs2 = "SELECT uid,stock,date,flag,pay_num,gudang_code,supp_code,shop_code,org_uid,date 
                      FROM shop_product_list_qty WHERE pcode = '$H_pcode' AND shop_code = '$keyD' ORDER BY date ASC, flag ASC, shop_code ASC";
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
            $qs_flag_txt = "<font color=blue>IN (+)</font>";
		  } else if($qs_flag == "out2") {
            $qs_flag_txt = "<font color=red>SOLD (-)</font>";
          } else if($qs_flag == "in") {
            $qs_flag_txt = "<font color=blue>WH (+)</font>";
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
            <form name='qs_signform' method='post' action='inventory_stock_data4.php'>
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
            <input type='hidden' name='catg' value='$catg'>
            <input type='hidden' name='new_uid' value='$H_uid'>
            <input type='hidden' name='qs_uid' value='$qs_uid'>
            <input type='hidden' name='qs_flag' value='$qs_flag'>
            <input type='hidden' name='qs_shop_code' value='$qs_shop_code'>
            <input type='hidden' name='qs_pcode' value='$prd_code'>
            <input type='hidden' name='qs_price_orgin' value='$qs_price_orgin'>
            <input type='hidden' name='qs_org_stock' value='$qs_stock'>
            <input type='hidden' name='qs_org_remain' value='$sum_qty_now'>
            
            
            <td>&nbsp;</td>
            <td>$qs_flag_txt</td>");
			
			if($qs_shop_code AND $qs_shop_code != "") {
				echo ("
				<td colspan=3>
					<a href='#' class='tooltips' title=\"\" data-toggle='tooltip' data-placement='top' data-original-title='$qs_shop_name'>[$qs_shop_code]</a> $qs_date_txt &nbsp;&nbsp; 
					/ $qs_price_orgin_K x $qs_stock = $qs_tprice_orgin_K
				</td>");
			} else {
				echo ("
				<td colspan=3>
					[Initial] $qs_date_txt &nbsp;&nbsp; 
					/ $qs_price_orgin_K x $qs_stock = $qs_tprice_orgin_K
				</td>");
			}
            
            // 각 입출고
            if($qs_flag == "out2") { 
              echo ("<td align=right><font color=red>-</font>&nbsp;<input type=text name='qs_stock' value='$qs_stock' style='WIDTH: 40px; HEIGHT: 22px; text-align: center'></td>");
            } else {
              echo ("<td align=right><font color=blue>+</font>&nbsp;<input type=text name='qs_stock' value='$qs_stock' style='WIDTH: 40px; HEIGHT: 22px; text-align: center'></td>");
            }
			
			if($qs_flag == "out") {
				$qs_stock_chg_submit = "";
			} else {
				$qs_stock_chg_submit = "disabled";
			}
            
            echo ("
            <td align=center><input $qs_stock_chg_submit type=submit value='+/-' style='WIDTH: 35px' class='btn btn-default btn-xs'></td>
            </form>
                  
            
            <form name='qs_signform' method='post' action='inventory_stock_data4.php'>
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
                  <input type='hidden' name='catg' value='$catg'>
                  <input type='hidden' name='new_uid' value='$H_uid'>
                  <input type='hidden' name='qs_uid' value='$qs_uid'>
                  <input type='hidden' name='qs_flag' value='$qs_flag'>
                  <input type='hidden' name='qs_shop_code' value='$qs_shop_code'>
                  <input type='hidden' name='qs_pcode' value='$prd_code'>
                  <input type='hidden' name='qs_stock' value='$qs_stock'>
                  <input type='hidden' name='qs_org_remain' value='$sum_qty_now'>
            <td align=center><input $qs_stock_chg_submit type=submit value='-' style='WIDTH: 35px' class='btn btn-default btn-xs'></td>
            </form>
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
} else if($step_next == "permit_qty") { // 수량 하위테이블 개별정보 수정

	$signdate = time();
	$post_date1 = date("Ymd",$signdate);
	$post_date2 = date("His",$signdate);
	$post_dates = "$post_date1"."$post_date2";
  

		$query_GM2 = "UPDATE shop_product_list_qty SET stock = '$qs_stock', price_orgin = '$qs_price_orgin' WHERE uid = '$qs_uid'";
		$result_GM2 = mysql_query($query_GM2);
		if (!$result_GM2) { error("QUERY_ERROR"); exit; }
    
		// 카트 정보 변경
		if($qs_flag == "S") {
			$query_GM3 = "UPDATE shop_cart SET qty = '$qs_stock' WHERE uid = '$qs_cart_uid' AND expire = '1'";
			$result_GM3 = mysql_query($query_GM3);
			if (!$result_GM3) { error("QUERY_ERROR"); exit; }
		}
    
    
		// 결제정보 변경(shop_payment, finance) - 수량, 원가, 판매총액, 결제일 등
		if($qs_flag == "S") {
			$query_GM4 = "UPDATE shop_payment SET qty = '$qs_stock', pay_amount = '$qs_pay_amount' WHERE uid = '$qs_pay_uid'";
			$result_GM4 = mysql_query($query_GM4);
			if (!$result_GM4) { error("QUERY_ERROR"); exit; }
      
			$query_GM5 = "UPDATE finance SET qty = '$qs_stock', amount = '$qs_pay_amount' WHERE pay_num = '$qs_pay_num'";
			$result_GM5 = mysql_query($query_GM5);
			if (!$result_GM5) { error("QUERY_ERROR"); exit; }
		}
    
    
		// 상품정보 수정(shop_product_list) - 입고수량, 판매수량, 현재재고 -------------------------//
    
		// [1] shop_product_list_shop의 shop 미지정 재고 정보 출력
		$sh1_query = "SELECT pcode,qty_org,qty_sell,qty_now,price_orgin,price_sale,price_sale2 FROM shop_product_list_shop 
					WHERE branch_code = '$login_branch' AND shop_code = '' ORDER BY uid DESC";
		$sh1_result = mysql_query($sh1_query);
			if (!$sh1_result) { error("QUERY_ERROR"); exit; }
		$sh1_pcode = @mysql_result($sh1_result,0,0);
		$sh1_qty_org = @mysql_result($sh1_result,0,1);
		$sh1_qty_sell = @mysql_result($sh1_result,0,2);
		$sh1_qty_now = @mysql_result($sh1_result,0,3);
		$sh1_price_orgin = @mysql_result($sh1_result,0,4);
		$sh1_price_sale = @mysql_result($sh1_result,0,5);
		$sh1_price_sale2 = @mysql_result($sh1_result,0,6);
    
    
		// [2] shop_product_list_qty에서 in/out별로 수량 정보 합계
		$sh21_query = "SELECT sum(stock) FROM shop_product_list_qty WHERE branch_code = '$login_branch' AND pcode = '$qs_pcode' AND flag = 'in' ORDER BY uid DESC";
		$sh21_result = mysql_query($sh21_query);
			if (!$sh21_result) { error("QUERY_ERROR"); exit; }
		$sh21_sum_qty_buy = @mysql_result($sh21_result,0,0);

		$sh22_query = "SELECT sum(stock) FROM shop_product_list_qty WHERE branch_code = '$login_branch' AND pcode = '$qs_pcode' AND flag = 'out' ORDER BY uid DESC";
		$sh22_result = mysql_query($sh22_query);
			if (!$sh22_result) { error("QUERY_ERROR"); exit; }
		$sh22_sum_qty_sell = @mysql_result($sh22_result,0,0);
    
		$sh2_sum_qty = $sh21_sum_qty_buy - $sh22_sum_qty_sell;
    
    
		// [3] shop_product_list의 재고 정보 수정
		$query_sh3 = "UPDATE shop_product_list SET stock_org = '$sh21_sum_qty_buy', stock_now = '$sh2_sum_qty' WHERE pcode = '$qs_pcode'";
		$result_sh3 = mysql_query($query_sh3);
		if (!$result_sh3) { error("QUERY_ERROR"); exit; }
    
    
		// [4] shop_product_list_shop의 shop 미지정 재고 증감 계산
		$sh4_query = "SELECT sum(qty_org),sum(qty_now) FROM shop_product_list_shop WHERE branch_code = '$login_branch' AND shop_code != '' ORDER BY uid DESC";
		$sh4_result = mysql_query($sh4_query);
		if (!$sh4_result) { error("QUERY_ERROR"); exit; }

		$sh4_sum_qty_org = @mysql_result($sh4_result,0,0);
		$sh4_sum_qty_now = @mysql_result($sh4_result,0,1);
    
    
		$sh4_sum_qty_org_new = $sh21_sum_qty_buy - $sh4_sum_qty_org;
		$sh4_sum_qty_now_new = $sh2_sum_qty - $sh4_sum_qty_now;
    
    
		// [5] shop_product_list_shop의 shop 미지정 재고 정보 수정
		$query_sh5 = "UPDATE shop_product_list_shop SET stock_org = '$sh4_sum_qty_org_new', stock_now = '$sh4_sum_qty_now_new' 
						WHERE branch_code = '$login_branch' AND shop_code = '' ORDER BY uid DESC";
		$result_sh3 = mysql_query($query_sh3);
		if (!$result_sh3) { error("QUERY_ERROR"); exit; }


		echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_stock_data4.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3&page=$page&mode=upd&view=qty&uid=$new_uid'>");
		exit;



} else if($step_next == "permit_qty_del") { // 수량 하위테이블 개별정보 삭제

	$signdate = time();
	$post_date1 = date("Ymd",$signdate);
	$post_date2 = date("His",$signdate);
	$post_dates = "$post_date1"."$post_date2";
	

		$query_GM2 = "DELETE FROM shop_product_list_qty WHERE uid = '$qs_uid'";
		$result_GM2 = mysql_query($query_GM2);
		if (!$result_GM2) { error("QUERY_ERROR"); exit; }
    
		// 카트 정보 삭제
		if($qs_flag == "S") {
			$query_GM3 = "DELETE FROM shop_cart WHERE uid = '$qs_cart_uid' AND expire = '1'";
			$result_GM3 = mysql_query($query_GM3);
			if (!$result_GM3) { error("QUERY_ERROR"); exit; }
		}
    
    
		// 결제정보 삭제(shop_payment, finance) - 수량, 원가, 판매총액, 결제일 등
		if($qs_flag == "S") {
			$query_GM4 = "DELETE FROM shop_payment WHERE uid = '$qs_pay_uid'";
			$result_GM4 = mysql_query($query_GM4);
			if (!$result_GM4) { error("QUERY_ERROR"); exit; }
      
			$query_GM5 = "DELETE FROM finance WHERE pay_num = '$qs_pay_num'";
			$result_GM5 = mysql_query($query_GM5);
			if (!$result_GM5) { error("QUERY_ERROR"); exit; }
		}
    
    
		// 상품정보 수정(shop_product_list) - 입고수량, 판매수량, 현재재고 -------------------------//
    
		// [1] shop_product_list_shop의 shop 미지정 재고 정보 출력
		$sh1_query = "SELECT pcode,qty_org,qty_sell,qty_now,price_orgin,price_sale,price_sale2 FROM shop_product_list_shop 
					WHERE branch_code = '$login_branch' AND shop_code = '' ORDER BY uid DESC";
		$sh1_result = mysql_query($sh1_query);
			if (!$sh1_result) { error("QUERY_ERROR"); exit; }
		$sh1_pcode = @mysql_result($sh1_result,0,0);
		$sh1_qty_org = @mysql_result($sh1_result,0,1);
		$sh1_qty_sell = @mysql_result($sh1_result,0,2);
		$sh1_qty_now = @mysql_result($sh1_result,0,3);
		$sh1_price_orgin = @mysql_result($sh1_result,0,4);
		$sh1_price_sale = @mysql_result($sh1_result,0,5);
		$sh1_price_sale2 = @mysql_result($sh1_result,0,6);
    
    
		// [2] shop_product_list_qty에서 in/out별로 수량 정보 합계
		$sh21_query = "SELECT sum(stock) FROM shop_product_list_qty WHERE branch_code = '$login_branch' AND pcode = '$qs_pcode' AND flag = 'in' ORDER BY uid DESC";
		$sh21_result = mysql_query($sh21_query);
			if (!$sh21_result) { error("QUERY_ERROR"); exit; }
		$sh21_sum_qty_buy = @mysql_result($sh21_result,0,0);

		$sh22_query = "SELECT sum(stock) FROM shop_product_list_qty WHERE branch_code = '$login_branch' AND pcode = '$qs_pcode' AND flag = 'out' ORDER BY uid DESC";
		$sh22_result = mysql_query($sh22_query);
			if (!$sh22_result) { error("QUERY_ERROR"); exit; }
		$sh22_sum_qty_sell = @mysql_result($sh22_result,0,0);
    
		$sh2_sum_qty = $sh21_sum_qty_buy - $sh22_sum_qty_sell;
    
    
		// [3] shop_product_list의 재고 정보 수정
		$query_sh3 = "UPDATE shop_product_list SET stock_org = '$sh21_sum_qty_buy', stock_now = '$sh2_sum_qty' WHERE pcode = '$qs_pcode'";
		$result_sh3 = mysql_query($query_sh3);
		if (!$result_sh3) { error("QUERY_ERROR"); exit; }
    
    
		// [4] shop_product_list_shop의 shop 미지정 재고 증감 계산
		$sh4_query = "SELECT sum(qty_org),sum(qty_now) FROM shop_product_list_shop WHERE branch_code = '$login_branch' AND shop_code != '' ORDER BY uid DESC";
		$sh4_result = mysql_query($sh4_query);
			if (!$sh4_result) { error("QUERY_ERROR"); exit; }
		$sh4_sum_qty_org = @mysql_result($sh4_result,0,0);
		$sh4_sum_qty_now = @mysql_result($sh4_result,0,1);
    
		$sh4_sum_qty_org_new = $sh21_sum_qty_buy - $sh4_sum_qty_org;
		$sh4_sum_qty_now_new = $sh2_sum_qty - $sh4_sum_qty_now;
    
    
		// [5] shop_product_list_shop의 shop 미지정 재고 정보 수정
		$query_sh5 = "UPDATE shop_product_list_shop SET stock_org = '$sh4_sum_qty_org_new', stock_now = '$sh4_sum_qty_now_new' 
					WHERE branch_code = '$login_branch' AND shop_code = '' ORDER BY uid DESC";
		$result_sh3 = mysql_query($query_sh3);
		if (!$result_sh3) { error("QUERY_ERROR"); exit; }

		echo("<meta http-equiv='Refresh' content='0; URL=$home/inventory_stock_data4.php?sorting_key=$sorting_key&keyfield=$keyfield&key=$key&keyA=$keyA&keyB=$keyB&keyC=$keyC&keyD=$keyD&key1=$key1&key2=$key2&key3=$key3&page=$page&mode=upd&view=qty&uid=$new_uid'>");
		exit;
}

}
?>