

<div class="panel-body progress-panel">
<div class="task-progress">
<h1>SECURITY EDIT CODE</h1>
<p><?=$login_id?>-<?=$hostname?></p>
</div>
</div>

<form id='sec' name='sec' autocomplete='off' action='pos.php'>
	<input type='hidden' class='form-control' style='width:50%;border-left:1px solid transparent;border-top-left-radius:0px;border-bottom-left-radius:0px' id='bind' name='bind' placeholder='SECURITY CODE' value='<?=$bind?>'>
	<input type='hidden' class='form-control' style='width:50%;border-left:1px solid transparent;border-top-left-radius:0px;border-bottom-left-radius:0px' id='trans' name='trans' placeholder='SECURITY CODE' value='<?=$trans?>'>
	<table style='width:100%'>
		<tr>
			<td style='width:50%'><input type='password' class='form-control submit_on_enter_sec' style='width:90%;border-left:1px solid transparent;border-top-left-radius:0px;border-bottom-left-radius:0px' id='security' autocomplete="off" placeholder='SECURITY CODE'></td>
			<!-- <td style='width:50%'><?php  echo '<a href="'.$home.'/pos.php" class="btn btn-primary" style="float:right; color:#fff; width:90%;border-color:#81C784; border-top-right-radius:0px;border-bottom-right-radius:0px;" >BACK</a>'; ?></td> -->
		</tr>
	</table>


</form>

<div>&nbsp;</div>
