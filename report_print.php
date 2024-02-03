<script>
function printWindow(){
   bV = parseInt(navigator.appVersion)
   if (bV >= 4) window.print()
}
</script>

<?
// if(!$lang) { $lang == "ko"; }

include "../../config/common.inc";
include "../../config/dbconn.inc";
include "../../config/user_functions_{$lang}.inc";
include "../../config/headtag_{$lang}.inc";
include "../../config/text_main_{$lang}.inc";

$loco = "page_server";
$icon = "../../image/icon";
$link_print = "javascript:printWindow()";

// ���̺� ����
if($login_branch == "CORP_02") {
  $tbl_stock1 = "2";
}else if($login_branch == "CORP_02" OR $login_branch == "CORP_03" OR $login_branch == "CORP_04") {
  $tbl_stock1 = "1";
} else {
  $tbl_stock1 = "0";
}

if($login_branch == "CORP_04") {
  $tbl_stock2 = "1";
} else {
  $tbl_stock2 = "0";
}


// �����: $report_start_date
$rs_year = substr($report_start_date,0,4);
$rs_month = substr($report_start_date,4,2);
$rs_date = substr($report_start_date,6,2);


  // ���� ��¥
  $signdate = time();

  // ���� ��¥�� ����Ϻ��� ���ϱ�
  $today = date("Ymd");
  $this_year = date("Y");
  $this_month = date("m");
  $this_yearmonth = date("ym");
  $this_date = date("d");
  $this_week = date("D");
	      
  if(!$p_date_set) { $p_date_set = date("Ymd",$signdate); }

  if(!$p_year) { $p_year = date("Y",$signdate); }
  if(!$p_yearmonth) { $p_yearmonth = date("Ym",$signdate); }
  if(!$p_month) { $p_month = date("m",$signdate); }
  if(!$p_date) { $p_date = date("d",$signdate); }
  if(!$p_hour) { $p_hour = date("H",$signdate); }

  // �ش� ������ ��� �Լ�
  function get_totaldays ($p_year, $p_month) {
		$p_date =1;
		while(checkdate($p_month, $p_date, $p_year)) {
		$p_date++;
	}
	
	$p_date--;
	return $p_date;
	}

	// ������ ���� �� �ϼ��� ����.
		$totaldays = get_totaldays($p_year,$p_month);

	// ������ ���� 1���� ������ ����. �Ͽ����� 0.
		$first_day = date('w', mktime(0,0,0,$p_month,1,$p_year));

	// ���� Ȯ��
		if($p_month==2){
		if(!($p_year%4))$totaldays++;
		if(!($p_year%100))$totaldays--;
		if(!($p_year%400))$totaldays++;
		}

?>

<script language="javascript">
function Popup_Win(ref) {
      var window_left = 0;
      var window_top = 0;
      ref = ref;      
      window.open(ref,"printpreWin",'width=1020,height=500,status=no,scrollbars=yes,top=' + window_top + ',left=' + window_left + '');
}
</script>

<table width=100% cellspacing=0 cellpadding=0 border=0>
<tr>
  <td width=1%></td>
  <td colspan=5 height=20>
      <table width=100% cellspacing=0 cellpadding=0 border=0>
      <tr>
        <td width=80%>
          <?
          // �� �ݺ� (������� �ݳ����)
          $yy_s = $rs_year;
          $yy_f = $this_year;
  
  
          for($yy = $yy_s; $yy <= $yy_f; $yy++) {
  
            echo ("<b>$yy</b> &nbsp; ");
  
          // �� �ݺ� (�����κ��� �̴ޱ���)
          if($rs_year == $this_year) {
            $m_s = $rs_month;
          } else {
            $m_s = 1;
          }
          $m_f = $this_month;
    
          for($m = $m_s; $m <= $m_f; $m++) {

            // �ش� ���� 2�ڸ� ���ڷ� ǥ��
            $mm = sprintf("%02d", $m);
            $this_month_set = "$yy"."$mm";

            echo ("<a href='$PHP_SELF?lang=ko&loco=page_server&p_year=$yy&p_month=$mm&p_yearmonth=$this_month_set'>$mm</a> &nbsp;");
    
          }

          }
          ?>
        
        
        
        </td>

        <td width=20% align=right>
        
          <select name='select' onChange="MM_jumpMenu('parent',this,0)" style='<?=$style_box?>; WIDTH: 120px'>
          <?
          // ��¥�� ���۰� ����
          if($p_month == $this_month) { $totaldays2 = $this_date; } else { $totaldays2 = $totaldays; }

          for($d = 1; $d <= $totaldays2; $d++) {

          // ��¥�� 2�ڸ� ���ڷ� ǥ��
          $dd = sprintf("%02d", $d);
  
          // �ش� ��¥
          $this_date_set = "$p_year"."$p_month"."$dd";
          $this_month_set = "$p_year"."$p_month";
  
          // ��¥ ǥ��
          if($lang == "ko") {
            $full_dd_txt = "$p_year"."/"."$p_month"."/"."$dd";
          } else {
            $full_dd_txt = "$dd"."-"."$p_month"."-"."$p_year";
          }
          
          if($this_date_set == $p_date_set) {
            $this_date_set_slct = "selected";
          } else {
            $this_date_set_slct = "";
          }
          
          echo ("<option value='$PHP_SELF?lang=ko&loco=page_server&p_year=$p_year&p_month=$p_month&p_yearmonth=$this_month_set&p_date_set=$this_date_set' $this_date_set_slct>$full_dd_txt</option>");
          
          }
          ?>
          </select>
        
        
        </td>

      </tr>
      </table>
  </td>
  <td width=1%></td>
</tr>
<tr><td colspan=7 height=5></td></tr>

<tr>
  <td width=1% height=22></td>
  <td width=34% align=center valign=top>
      <table width=100% cellspacing=0 cellpadding=0 border=0>
      <tr><td height=22 bgcolor=#DEDEDE align=center><font class="contentD">���� ����</font></td>
      <tr><td height=10></td></tr>
      <tr><td valign=top><? include "report_sales.inc"; ?></td></tr>
      </table>
  </td>
  <td width=1%></td>
  <td width=34% align=center valign=top>
      <table width=100% cellspacing=0 cellpadding=0 border=0>
      <? if($tbl_stock1 == "2" OR $tbl_stock1 == "1") { ?>
      <tr><td height=22 bgcolor=#DEDEDE align=center><font class="contentD">��� ����</font></td>
      <tr><td height=10></td></tr>
      <tr><td valign=top><? include "report_stock_A{$tbl_stock1}.inc"; ?></td></tr>
      <tr><td height=10></td></tr>
      <? } ?>
      
      <? if($tbl_stock2 == "1") { ?>
      <tr><td valign=top><? include "report_stock_B.inc"; ?></td></tr>
      <tr><td height=10></td></tr>
      <? } ?>
      
      <tr><td height=22 bgcolor=#DEDEDE align=center><font class="contentD">���� ����</font></td>
      <tr><td height=10></td></tr>
      <tr><td valign=top><? include "report_balance.inc"; ?></td></tr>
      <tr><td height=10></td></tr>
      
      <? if($login_branch == "CORP_03" OR $login_branch == "CORP_04") { ?>
      <tr><td height=22 bgcolor=#DEDEDE align=center><font class="contentD">���� ����</font></td>
      <tr><td height=10></td></tr>
      <tr><td valign=top><? include "report_purchase.inc"; ?></td></tr>
      <? } else { ?>
      <tr><td height=22 bgcolor=#DEDEDE align=center><font class="contentD">���� ����</font></td>
      <tr><td height=10></td></tr>
      <tr><td valign=top><? include "report_collect.inc"; ?></td></tr>
      <? } ?>
      </table>
  </td>
  <td width=1%></td>
  <td width=28% align=center valign=top>
      <table width=100% cellspacing=0 cellpadding=0 border=0>
      <tr><td height=22 bgcolor=#DEDEDE align=center><font class="contentD">��� �� ���� ����</font></td>
      <tr><td height=10></td></tr>
      <tr><td valign=top><? include "report_finance.inc"; ?></td></tr>
      </table>
  </td>
  <td width=1%></td>
</tr>


<tr><td colspan=7 height=5></td></tr>
<tr>
  <td colspan=5 height=20></td>
  <td align=right>
    <a href='<?=$link_print?>'><img src='<?=$icon?>/icon_print.gif' border=0></a>
  </td>
  <td></td>
</tr>
</table>


