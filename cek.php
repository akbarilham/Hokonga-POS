<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "6") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "restore";
$smenu = "restore_stock_opname_month";

			$query = "SELECT pnum,org_pcode,stocks FROM table_stock_201507_cvj2";
			$result = mysql_query($query);
			if (!$result) {   error("QUERY_ERROR");   exit; }


					$pnum = mysql_result($result,0,0);
					$org_pcode = mysql_result($result,0,1);
				
					// Duplication Check
					$query_pr = "SELECT count(org_pcode),pname,org_pcode FROM shop_product_list group by org_pcode asc";
					$result_pr = mysql_query($query_pr);
						if (!$result_pr) { error("QUERY_ERROR"); exit; }
					
					$pr_count = @mysql_result($result_pr,0,0);
					$pr_pname = @mysql_result($result_pr,0,1);
					$pr_code = @mysql_result($result_pr,0,2);
					echo ("$pr_count");
					if($pr_count > 1) { // Duplicated
						echo ("$org_pcode");

					} else if($pr_count < 1) { // No Registered
						echo ("$org_pcode");

					} else {
						$pr_color = "";
						$pr_duple_txt = "";
					}
					
			
}
