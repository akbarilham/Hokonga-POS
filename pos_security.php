<?php

include "config/common.php";

if (!$login_id OR $login_id == "" OR $login_level < "1") {
  echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
include "config/dbconn.php";
include "config/text_main_{$lang}.php";
include "config/user_functions_{$lang}.php";
?>

<!-- Bootstrap core CSS -->
<script language="javascript">
	function selectIt() {
	window.opener.location.href = '<?php echo $home ?>/pos.php';
	window.close();
	}
</script>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-reset.css" rel="stylesheet">
<div class="panel-body progress-panel">
<div class="task-progress">
<h1>SECURITY CODE</h1>
<p><?php echo $login_id ?>-<?php echo $hostname ?></p>
</div>
</div>
<style>
    #security{
    	-webkit-text-security:disc;
    }
</style>
<?php
$void = $_GET['void'] ?? null;
// $void = $_GET['void'] ?? 'void';
$uid = $_GET['uid'] ?? $uid;
$del = $_GET['del'] ?? $del;
$fail = $fail ?? false;

if($void == 'void'){ ?>
	<?php  echo '<a href="'.$home.'/pos_master.php?trans=list" class="btn btn-primary" style=" color:#fff; width:10%;border-color:#81C784;border-bottom-left-radius:0px;border-top-left-radius:0px;" >BACK</a>'; ?>
	<div>&nbsp;</div>
	<form id='sec' name='sec' action='pos_cart_void.php' method='get'>
		<?php
			if($fail == 'faild'){
				?>
					<p style='color:red;'>SECURITY SALAH</p>
				<?php
			}
		?>
		<input type='hidden' class='form-control' style='width:50%;border-left:1px solid transparent;border-top-left-radius:0px;border-bottom-left-radius:0px' id='void' name='void' placeholder='SECURITY CODE' value='<?php echo $void ?>'>
		<input type='hidden' class='form-control' style='width:50%;border-left:1px solid transparent;border-top-left-radius:0px;border-bottom-left-radius:0px' id='uid' name='uid' placeholder='SECURITY CODE' value='<?php echo $uid ?>'>
		<input type='hidden' class='form-control' style='width:50%;border-left:1px solid transparent;border-top-left-radius:0px;border-bottom-left-radius:0px' id='trans' name='trans' placeholder='SECURITY CODE' value='<?php echo $trans ?>'>
		<table style='width:100%'>
		<tr>
			<td style='width:50%'><input autofocus type='password' class='form-control submit_on_enter_sec' style='width:90%;border-left:1px solid transparent;border-top-left-radius:0px;border-bottom-left-radius:0px' id='security' name='security' placeholder='SECURITY CODE'></td>
			<!-- <td style='width:50%'><?php  echo '<a href="'.$home.'/pos.php" class="btn btn-primary" style="float:right; color:#fff; width:90%;border-color:#81C784; border-top-right-radius:0px;border-bottom-right-radius:0px;" >BACK</a>'; ?></td> -->
		</tr>
	</table>

</form>

<?php } else { ?>

	<input type="button" class="btn btn-primary" style=" color:#fff; width:40%;border-color:#81C784;border-bottom-left-radius:0px;border-top-left-radius:0px;" value="CANCEL" onclick="selectIt()">
	<div>&nbsp;</div>
	<form id='sec' name='sec' action='pos_edit_row.php' method='get'>
		<?php
			if($fail == 'faild'){
				?>
					<p style='color:red;'>SECURITY SALAH</p>
				<?
			}
		?>
		<input type='hidden' class='form-control' style='width:50%;border-left:1px solid transparent;border-top-left-radius:0px;border-bottom-left-radius:0px' id='bind' name='bind' placeholder='SECURITY CODE' value='<?php echo $bind ?>'>
		<input type='hidden' class='form-control' style='width:50%;border-left:1px solid transparent;border-top-left-radius:0px;border-bottom-left-radius:0px' id='trans' name='trans' placeholder='SECURITY CODE' value='<?php echo $trans ?>'>
		<input type='hidden' class='form-control' style='width:50%;border-left:1px solid transparent;border-top-left-radius:0px;border-bottom-left-radius:0px' id='val' name='val' placeholder='SECURITY CODE' value='<?php echo $val ?>'>
		<input type='hidden' class='form-control' style='width:50%;border-left:1px solid transparent;border-top-left-radius:0px;border-bottom-left-radius:0px' id='id' name='id' placeholder='SECURITY CODE' value='<?php echo $uid ?>'>
		<input type='hidden' class='form-control' style='width:50%;border-left:1px solid transparent;border-top-left-radius:0px;border-bottom-left-radius:0px' id='del' name='del' placeholder='SECURITY CODE' value='<?php echo $del ?>'>
		<input type='hidden' class='form-control' style='width:50%;border-left:1px solid transparent;border-top-left-radius:0px;border-bottom-left-radius:0px' id='uid' name='uid' placeholder='SECURITY CODE' value='<?php echo $uid ?>'>
		<input type='hidden' class='form-control' style='width:50%;border-left:1px solid transparent;border-top-left-radius:0px;border-bottom-left-radius:0px' id='cek' name='cek' placeholder='SECURITY CODE' value='cek'>
		<table style='width:100%'>
			<tr>
				<td style='width:50%'><input autofocus type='password' class='form-control submit_on_enter_sec' style='width:90%;border-left:1px solid transparent;border-top-left-radius:0px;border-bottom-left-radius:0px' id='security' name='security' placeholder='SECURITY CODE'></td>
			</tr>
		</table>
	</form>
<?php } ?>
<div>&nbsp;</div>

<?php } } ?>