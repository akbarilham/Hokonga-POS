<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";
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

<body>
<?
$LIST_TH_COLOR = "#CCDACA";
$ICON = "$home/admin/image";
$box_style = "style='BORDER:1px solid;COLOR:#222222'";
$btn_style = "style='BORDER:1px solid;COLOR:#222222'";


if(!$step) {
   $step = 1;
}


if($step == 1) {
   $next_step = $step + 1;
?>

<center><br><br><font color=#006699>Select Main Category</font></center>

<table width="280" border="0" cellpadding="1" cellspacing="0" align="center">
<form name="choose_cat" method="post" action="<?echo("$PHP_SELF")?>?lang=<?echo("$lang")?>&step=<?echo("$next_step")?>&code=<?echo("$code")?>&gate=<?echo("$gate")?>&key=<?=$key?>">
<tr>
   <td colspan="2" align="right">STEP [<?echo("$step")?> / 4]</td>
</tr>   
<tr>
   <td bgColor="#E1E0C8">

   
<!----------- 실제 테이블 구현 --------------------------->

   <table class="table table-bordered table-striped table-condensed">
   <thead>
   <tr bgcolor=#006699> 
     <th align=center><font color=white>Select Main Category</font></td>
   </tr>
   </thead>
   
   <tbody>
   <tr align=center>
      <td bgColor="#E1E0C8">
        <select name="big_cat">
<?
########## Big_Category 데이터베이스에서 레코드를 검색한다. ##########
$query = "SELECT * FROM zone_acc_level2 WHERE code1 = '$key' ORDER BY code2";
$result = mysql_query($query);
if (!$result) {
   error("QUERY_ERROR");
   exit;
}   
$rows = mysql_num_rows($result);

   while($row = mysql_fetch_object($result)) {
      $big_cat_code = $row->code2;
      $big_cat_name = $row->name2;
      $write_big_cat = "($big_cat_code) $big_cat_name";

      echo("<option value='$row->code2'>$write_big_cat");
   }

?>
      </select>
      </td>      
   </tr>

   <tr>
      <td bgColor="lightyellow"align="center">
      Select Main Category before Next.<p>
      <input type="submit" value="Next" style="BORDER: 1px solid; COLOR: black;">
      </td>
   </tr>
   </tbody>
   </table>
<!-------------------------------------------------------->

   </td>
</tr>
</table>
</form>
</body>
</html>





<?
} 
//////////////////////////////////////// Step 2 ////////////////
if ($step == 2) {
$next_step = $step + 1;

########## Big_Category 데이터베이스에서 레코드를 검색한다. ##########
$query = "SELECT * FROM zone_acc_level2 WHERE code2 = '$big_cat'";
$result = mysql_query($query);
if (!$result) {
   error("QUERY_ERROR");
   exit;
}   

$row = mysql_fetch_row($result);

      $big_cat_code = $row[1];
      $big_cat_name = $row[2];
      $write_big_cat = "($big_cat_code) $big_cat_name";
?>

<center><br><br><font color=#006699>Select Mid Category</font></center>

<table width="280" border="0" cellpadding="1" cellspacing="0" align="center">
<form name="choose_cat" method="post" action="<?echo("$PHP_SELF")?>?lang=<?echo("$lang")?>&step=<?echo("$next_step")?>&code=<?echo("$code")?>&gate=<?echo("$gate")?>&key=<?=$key?>">
<tr>
   <td colspan="2" align="right">STEP [<?echo("$step")?> / 4]</td>
</tr>   

<tr>
   <td bgColor="#E1E0C8">
   <table class="table table-bordered table-striped table-condensed">
   <thead>
   <tr bgcolor=#006699> 
     <th align=center><font color=white>Main: <?echo "$write_big_cat" ?></font></th>
   </tr>
   </thead>
   
   <tbody>
   <tr align=center>
      <td bgColor="#E1E0C8">
         <select name="m_cat">
<?
########## m_Category 데이터베이스에서 레코드를 검색한다. ##########
$query = "SELECT * FROM zone_acc_level3 WHERE code2 = '$big_cat' ORDER BY code3";
$result = mysql_query($query);  //쿼리문을 SQL서버에 전송
if (!$result) {
   error("QUERY_ERROR");
   exit;
}   
$rows = mysql_num_rows($result);  //결과레코드에서 행의 수 반환

   while($row = mysql_fetch_object($result)) {
      $m_cat_code = $row->code3;
      $m_cat_name = $row->name3;
      $write_m_cat = "($m_cat_code) $m_cat_name";
      echo("<option value='$row->code3'>$write_m_cat");
   }

?>
      </select>
      </td>      
   </tr>

   <tr>
      <td bgColor="lightyellow" align="center">
      Select Mid Category Before Next.<p>

      <input type="hidden" name=big_cat_code value="<? echo "$big_cat_code" ?>">
      <input type="hidden" name=big_cat_name value="<? echo "$big_cat_name" ?>">
      <input type="hidden" name=write_big_cat value="<? echo "$write_big_cat" ?>">

      <input type="submit" value="Next" style="BORDER: 1px solid; COLOR: black;">
      </td>
   </tr>
   </tbody>
   </table>
<!-------------------------------------------------------->

   </td>
</tr>
</table>
</form>



<?
} 
//////////////////////////////////////// Step 3 ////////////////
if ($step == 3) {
$next_step = $step + 1;

########## Mid_Category 데이터베이스에서 레코드를 검색한다. ##########
$query = "SELECT * FROM zone_acc_level3 WHERE code3 = '$m_cat'";
$result = mysql_query($query);
if (!$result) {
   error("QUERY_ERROR");
   exit;
}   

$row = mysql_fetch_row($result);

      $m_cat_code = $row[2];
      $m_cat_name = $row[3];
      $write_m_cat = "($m_cat_code) $m_cat_name";
?>

<center><br><br><font color=#006699>Select Sub Category</font></center>

<table width="280" border="0" cellpadding="1" cellspacing="0" align="center">
<form name="choose_cat" method="post" action="<?echo("$PHP_SELF")?>?lang=<?echo("$lang")?>&step=<?echo("$next_step")?>&code=<?echo("$code")?>&gate=<?echo("$gate")?>&key=<?=$key?>">
<thead>
<tr>
   <td colspan="2" align="right">STEP [<?echo("$step")?> / 4]</td>
</tr>   

<tbody>
<tr>
   <td bgColor="#E1E0C8">
   <table class="table table-bordered table-striped table-condensed">
   <thead>
   <tr bgcolor=#006699> 
     <th align=center><font color=white>Mid: <?echo "$write_m_cat" ?></font></th>
   </tr>
   </thead>
   
   <tbody>
   <tr align=center>
      <td bgColor="#E1E0C8">
         <select name="s_cat">
<?
########## s_Category 데이터베이스에서 레코드를 검색한다. ##########
$query = "SELECT * FROM zone_acc_level4 WHERE code3 = '$m_cat' ORDER BY code3";
$result = mysql_query($query);  //쿼리문을 SQL서버에 전송
if (!$result) {
   error("QUERY_ERROR");
   exit;
}   
$rows = mysql_num_rows($result);  //결과레코드에서 행의 수 반환

if(!$rows) {
    echo("<option value='$m_cat_code'>None</option>");
} else {
   while($row = mysql_fetch_object($result)) {
      $s_cat_code = $row->code4;
      $s_cat_name = $row->name4;
      $write_s_cat = "($s_cat_code) $s_cat_name";
      echo("<option value='$row->code4'>$write_s_cat</option>");
   }
}
?>
      </select>
      </td>      
   </tr>

   <tr>
      <td bgColor="lightyellow" align="center">
      Select Sub Category Before Next.<p>

      <input type="hidden" name=big_cat_code value="<? echo "$big_cat_code" ?>">
      <input type="hidden" name=big_cat_name value="<? echo "$big_cat_name" ?>">
      <input type="hidden" name=write_big_cat value="<? echo "$write_big_cat" ?>">
      <input type="hidden" name=m_cat_code value="<? echo "$m_cat_code" ?>">
      <input type="hidden" name=m_cat_name value="<? echo "$m_cat_name" ?>">
      <input type="hidden" name=write_m_cat value="<? echo "$write_m_cat" ?>">

      <input type="submit" value="Next" style="BORDER: 1px solid; COLOR: black;">
      </td>
   </tr>
   </tbody>
   </table>
<!-------------------------------------------------------->

   </td>
</tr>
</table>
</form>



<?
} 

##################### Step 4 (마지막 단계) ################
if ($step == 4) {

$query = "SELECT * FROM zone_acc_level4 WHERE code4 = '$s_cat'";
$result = mysql_query($query); 
if (!$result) {
   error("QUERY_ERROR");
   exit;
}
$row = mysql_fetch_row($result);
if(!$row) {
  $s_cat_code = $s_cat;
  $s_cat_name = "None";
  $write_s_cat = "($s_cat_code) $s_cat_name";
} else {
  $s_cat_code = $row[3];
  $s_cat_name = $row[4];
  $write_s_cat = "($s_cat_code) $s_cat_name";
}


#### 최고 큰 수를 얻어서 uid에 +1 하여 추가
$query = "SELECT max(code) FROM zone_acc_list WHERE code4 = '$s_cat_code'";

$result = mysql_query($query);
if (!$result) {
   error("QUERY_ERROR");
   exit;
}   
$row = mysql_fetch_row($result);
if($row[0] == 0) {
  $new_row_code = "$s_cat_code".".01";
} else {
  $new_row_exp = explode(".",$row[0]);
	$new_row_plus = $new_row_exp[1] + 1;
	$new_row_plus2 = sprintf("%02d", $new_row_plus); // 2자리수
  $new_row_code =  "$new_row_exp[0]".".$new_row_plus2";
}

if($code == "list") {
?>

<script language="javascript">
function selectIt(form) {
   var form_object = eval("opener.document.signform");
      form_object.new_acc_code.focus();
   self.close();
}
</script>

<? } else { ?>

<script language="javascript">
function selectIt(form) {
   var form_object = eval("opener.document.signform");
      form_object.new_acc_code.value = '<?=$new_row_code?>';
   self.close();
}
</script>

<? } ?>

<center><br><br><font color=#006699>Category Selected !</font></center>

<table width="280" border="0" cellpadding="1" cellspacing="0" align="center">
<form name="choose_cat" method="post" action="<?echo("$PHP_SELF")?>?lang=<?echo("$lang")?>&step=<?echo("$next_step")?>&code=<?echo("$code")?>&gate=<?echo("$gate")?>&key=<?=$key?>">

<tr>
   <td colspan="2" align="right">STEP [<?echo("$step")?> / 3]</td>
</tr>   
<tr>
   <td bgColor="#E1E0C8">

<!-------------------------------------------------------->
   <table width="278" border="0" cellpadding="5" cellspacing="1" align="center">
   <tr align=center>
      <td bgColor="#E1E0C8">
        Main: <?echo "$write_big_cat" ?>
      </td>
   </tr>
   <tr align=center>
      <td bgColor="#E1E0C8">
        Mid: <?echo "$write_m_cat" ?>
      </td>
   </tr>
   <tr align=center>
      <td bgColor="#E1E0C8">
        Sub: <?echo "$write_s_cat" ?>
      </td>
   </tr>
   <tr align=center>
      <td bgColor="#006699">
        <font color=white>New Accounting Code: <?=$new_row_code?></font>
      </td>
   </tr>

  <tr><td height=22 bgColor=#E1E0C8 align=center>Your Selection Completed.</td></tr>
  
  <tr>
  <input type="hidden" name="code" value="<?echo("$code")?>">
    <td height=25 bgColor="#E1E0C8" align="center">
      <input type="button" value="Confirm" onClick="selectIt(this.form)" style="BORDER: 1px solid; COLOR: black;">
    </td>
  </tr>
  </table>      
<!-------------------------------------------------------->

   </td>
</tr>
</table>
</form>

<?
}
?>

</body>
</html>

<? } ?>