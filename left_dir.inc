<table width=100% cellspacing=0 cellpadding=0 border=0>

<?
$link_dir = "$PHP_SELF?lang=$lang&loco=page_server&p_year=$p_year&p_month=$p_month&p_yearmonth=$p_yearmonth&p_quarter=$p_quarter&w_date_setA=$w_date_setA&w_date_setB=$w_date_setB&mode=$mode&vmode=$vmode";


if($grpAll == "all") {
echo ("
<tr><td colspan=6 height=2></td></tr>
<tr>
  <td width=5 height=15></td>
  <td width=9 height=15 valign=top></td>
  <td width=6></td>
  <td width=16 height=15 valign=top><i class='fa fa-folder-open-o'></i></td>
  <td width=7></td>");
  if(!$grpBrc AND !$grpShp) {
    echo ("<td width=155><a href='$link_dir' class='myB'><b>$txt_comm_frm30</b></a></td>");
  } else {
    echo ("<td width=155><a href='$link_dir' class='myB'>$txt_comm_frm30</a></td>");
  }
  echo ("
</tr>
");

  $queryAc = "SELECT count(uid) FROM client_branch";
  $resultAc = mysql_query($queryAc);
    if (!$resultAc) { error("QUERY_ERROR"); exit; }
  $totalAc = @mysql_result($resultAc,0,0);
  
  $queryA = "SELECT branch_code,branch_name FROM client_branch ORDER BY userlevel DESC, branch_code ASC";
  $resultA = mysql_query($queryA);
    if (!$resultA) {   error("QUERY_ERROR");   exit; }

  for($A = 0; $A < $totalAc; $A++) {
   $A_branch_code = mysql_result($resultA,$A,0);   
   $A_branch_name = mysql_result($resultA,$A,1);
   
   
    // SHOPs
    $queryBc = "SELECT count(uid) FROM client_shop WHERE branch_code = '$A_branch_code'";
    $resultBc = mysql_query($queryBc);
      if (!$resultBc) { error("QUERY_ERROR"); exit; }
    $totalBc = @mysql_result($resultBc,0,0);
    
    if($totalBc > 0) {
      if($grpBrc == $A_branch_code) {
        $icon_bullet_brc = "<i class='fa fa-folder-minus-o'></i>";
        $icon_folder_brc = "<i class='fa fa-folder-open-o'></i>";
      } else {
        $icon_bullet_brc = "<i class='fa fa-folder-plus-o'></i>";
        $icon_folder_brc = "<i class='fa fa-folder-o'></i>";
      }
    } else {
      if($grpBrc == $A_branch_code) {
        $icon_bullet_brc = "";
        $icon_folder_brc = "<i class='fa fa-folder-open-o'></i>";
      } else {
        $icon_bullet_brc = "";
        $icon_folder_brc = "<i class='fa fa-folder-o'></i>";
      }
    }
   

  echo ("
  <tr><td colspan=6>
  <table width=100% cellspacing=0 cellpadding=0 border=0>
  <tr><td colspan=6 height=2></td></tr>
  <tr>
    <td width=20 height=15></td>
    <td width=9 height=15 valign=top>$icon_bullet_brc</td>
    <td width=6></td>
    <td width=16 height=15 valign=top>$icon_folder_brc</td>
    <td width=7></td>");
    if($grpBrc == $A_branch_code) {
      if(!$grpShp) {
        echo("<td width=140><a href='$link_dir&grpAll=all' class='myB'><b>$A_branch_name</b></a></td>");
      } else {
        echo("<td width=140><a href='$link_dir&grpAll=all&grpBrc=$A_branch_code' class='myB'>$A_branch_name</a></td>");
      }
    } else {
        echo("<td width=140><a href='$link_dir&grpAll=all&grpBrc=$A_branch_code' class='myB'>$A_branch_name</a></td>");
    }
    echo ("
  </tr>
  </table>
  </td></tr>
  ");
  
    if($grpBrc == $A_branch_code) {
    $queryB = "SELECT shop_code,shop_name FROM client_shop  WHERE branch_code = '$A_branch_code' ORDER BY shop_code ASC";
    $resultB = mysql_query($queryB);
      if (!$resultB) {   error("QUERY_ERROR");   exit; }

    for($B = 0; $B < $totalBc; $B++) {
      $B_shop_code = mysql_result($resultB,$B,0);   
      $B_shop_name = mysql_result($resultB,$B,1);
      
      if($grpShp == $B_shop_code) {
        $icon_folder_shp = "<i class='fa fa-folder-open-o'></i>";
      } else {
        $icon_folder_shp = "<i class='fa fa-folder-o'></i>";
      }
   
      echo ("
      <tr><td colspan=6>
      <table width=100% cellspacing=0 cellpadding=0 border=0>
      <tr><td colspan=6 height=2></td></tr>
      <tr>
        <td width=30 height=15></td>
        <td width=9 height=15></td>
        <td width=6></td>
        <td width=16 height=15 valign=top>$icon_folder_shp</td>
        <td width=7></td>");
        if($grpShp == $B_shop_code) {
          echo("<td width=130><a href='$link_dir&grpAll=all&grpBrc=$A_branch_code&grpShp=$B_shop_code' class='myB'><b>$B_shop_name</b></a></td>");
        } else {
          echo("<td width=130><a href='$link_dir&grpAll=all&grpBrc=$A_branch_code&grpShp=$B_shop_code' class='myB'>$B_shop_name</a></td>");
        }
        echo ("
      </tr>
      </table>
      </td></tr>
      ");
    
    }
    }
  
  
  

  }



} else {

echo ("
<tr><td colspan=6 height=2></td></tr>
<tr>
  <td width=5 height=15></td>
  <td width=9 height=15 valign=top><i class='fa fa-plus-o'></i></td>
  <td width=6></td>
  <td width=16 height=15 valign=top><i class='fa fa-folder-o'></i></td>
  <td width=7></td>
  <td width=155><a href='$link_dir&grpAll=all' class='myB'><b>$txt_comm_frm30</b></a></td>
</tr>
");
}
?>

<tr><td colspan=6 height=10></td></tr>
</table>


