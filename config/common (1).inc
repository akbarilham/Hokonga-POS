<?
$DB_SERVER="localhost";      // Database Server machine
$DB_LOGIN="root";            // Database login ID
$DB_PASSWORD="";         // Database password
$DB="feelbuy";                // Database name


// Website Identity
$web_erp_name = "FEEL BUY ERP";
$copyright_name = "&copy; 2015 FEELBUY ERP. Built on Twitter Bootstrap & BrisHub ERP System.";


$admin_email = "info@ikbiz.com";

$home = "http://localhost/feelbuy";
$home_txt = "erp.feelbuy.co.id";
$root = "";

if(isset($_COOKIE['login_id']) || isset($_COOKIE['login_level'])) {
	$login_id = $_COOKIE['login_id'];
	$login_level = $_COOKIE['login_level'];
	$login_branch = $_COOKIE['login_branch'];
	$login_gate = $_COOKIE['login_gate'];
	//$login_subgate = $_COOKIE['login_subgate'];
	//$login_shop = $_COOKIE['login_shop'];
	$login_ip = $_COOKIE['login_ip'];
	$login_user_name = $_COOKIE['login_user_name'];
	$login_shop_flag = $_COOKIE['login_shop_flag'];
	$login_shop_userlevel = $_COOKIE['login_shop_userlevel'];
	
} // set cookies

global $step_next,$sorting_key,$key_shop,$key,$keyfield,$page,$mode,$PHP_SELF,$login_shop,$notify_new_article,$IsNext,$stat,$P_uid,$p_date_set,$step_next, $user_gender_chkM,$user_gender_chkF,$post_year,$p_year,$p_yearmonth,$p_month,$p_date,$p_hour,$p_total_price_K,$login_name,$login_ip,$grpBrc,$grpShp,$rp_title1,$login_user_name,$uid,$H_gcode,$prd_font_color,$org_pcode,$org_barcode,$H_cbm,$encoded_key,$H_prd_uid,$H_prd_code,$view,$pcode,$prd_pname,$otype,$po_currency; //make global variable for undifine variable;
global $upd_uid,$upd_branch_code,$upd_client_code,$upd_currency,$upd_po_tamount,$prd_price_orgin,$new_due_dates,$cart_mode,$loco,$prd_tsm_price_K,$smode,$txt_invn_stockin_44p,$keyA,$keyB,$keyC,$keyD,$key1,$key2,$key3,$prd_tsmS1_qty_in,$prd_qty,$prd_tsm_qty_in_K,$prd_tsm_qty_out_K,$prd_tsm_qty_now_K,$dis_submit,$keyC1,$sorting_table,$add_mode,$H2_cart_uid,$key_shop,$sorting_key,$total_qty,$p_total_price,$new_buyer_type,$add_due_dates,$tempo_date2,$sub_type,$tempo_date1,$tempo_date3,$H_cart_uid,$H_prd_code,$H_prd_stock_sell,$H_prd_stock_now,$H_shop_uid,$cart_prd_uid;
?>
