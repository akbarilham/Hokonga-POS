<?
echo ("
<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_comm_frm24</label>
    <div class='col-sm-8'>");
	
		$queryE = "SELECT count(uid) FROM client WHERE userlevel > '0'";
		$resultE = mysql_query($queryE);
		$total_recordE = mysql_result($resultE,0,0);

		$queryF = "SELECT client_id,client_name,userlevel FROM client WHERE userlevel > '0' ORDER BY userlevel DESC, client_code ASC";
		$resultF = mysql_query($queryF);

		echo("<select name='new_system_gate' class='form-control'>");

		for($i = 0; $i < $total_recordE; $i++) {
			$client_id = mysql_result($resultF,$i,0);
			$client_name = mysql_result($resultF,$i,1);
			$client_level = mysql_result($resultF,$i,2);
        
			if($client_id == $user_gate) {
				$slc_gateF = "selected";
				$slc_disableF = "";
			} else {
				$slc_gateF = "";
				$slc_disableF = "disabled";
			}
        
			if($client_level < '4') {
				echo("<option value='$client_id' $slc_gateF>&nbsp;&nbsp;&nbsp; &gt; $client_name [ $client_id ]</option>");
			} else {
				echo("<option value='$client_id' $slc_gateF>$client_name [ $client_id ]</option>");
			}
		}
      echo("</select>
	  
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>ID / Password</label>
    <div class='col-sm-4'>
		<input type='text' class='form-control' id='l-name' name='user_id' value='$user_id' maxlength=12>
	</div>
	<div class='col-sm-4'>
		<input type='password' class='form-control' id='l-name' name='user_pwd' maxlength=12 placeholder='New Password'>
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_hr_member_16</label>
    <div class='col-sm-4'>
		<input type=radio name='mlist' value='1' $mlist_chk1> $txt_hr_member_17 &nbsp;&nbsp; 
	    <input type=radio name='mlist' value='0' $mlist_chk0> $txt_hr_member_18
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>E-mail</label>
    <div class='col-sm-8'>
		<input type='email' class='form-control' id='l-name' name='email' value='$email'>
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_sys_client_05</label>
    <div class='col-sm-8'>
		<input type='url' class='form-control' id='l-name' name='homepage' value='$homepage' placeholder='http://'>
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_sys_client_09</label>
    <div class='col-sm-4'>
		<input type='tel' class='form-control' id='l-name' name='phone_cel' value='$phone_cel'>
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_stf_member_07</label>
    <div class='col-sm-4'>");
	
		if(!strcmp($userlevel,"0")) {
			echo("<input type=\"radio\" name=\"userlevel\" value=\"0\" CHECKED> <font color=red>Hold</font> &nbsp;&nbsp; ");
		} else {
			echo("<input type=\"radio\" name=\"userlevel\" value=\"0\"> <font color=red>Hold</font> &nbsp;&nbsp; ");
		}

		if(!strcmp($userlevel,"1")) {
			echo("<input type=\"radio\" name=\"userlevel\" value=\"1\" CHECKED> $txt_hr_member_381 &nbsp;&nbsp; ");
		} else {
			echo("<input type=\"radio\" name=\"userlevel\" value=\"1\"> $txt_hr_member_381 &nbsp;&nbsp; ");
		}
   
		if(!strcmp($userlevel,"2")) {
			echo("<input type=\"radio\" name=\"userlevel\" value=\"2\" CHECKED> <font color=blue>$txt_hr_member_382</font> &nbsp;&nbsp; ");
		} else {
			echo("<input type=\"radio\" name=\"userlevel\" value=\"2\"> <font color=blue>$txt_hr_member_382</font> &nbsp;&nbsp; ");
		}
		
		echo ("
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>{$photo_img1_txt} {$txt_hr_member_44}</label>
    <div class='col-sm-4'>
		<input type='file' class='form-control' id='l-name' name='photofile1'>
	</div>
	<div class='col-sm-4'>
		JPG/GIF/PNG ");
		if($photo1 != "none") {
			echo ("&nbsp;&nbsp; <input type=checkbox name='photo1_chg' value='1'> $txt_comm_frm08");
		}
		echo ("
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_hr_member_3295</label>
    <div class='col-sm-8'>
		<input type='text' class='form-control' id='l-name' name='expel_reason2' value='$expel_reason2' placeholder='$txt_hr_member_3294'>
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_sys_client_26</label>
    <div class='col-sm-8'>
		<textarea name='memo' class='form-control' rows=4>$memo</textarea>
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>&nbsp;</label>
    <div class='col-sm-4'>
		<img src='include/_barcode/html/image.php?code=code39&o=1&dpi=72&t=30&r=2&rot=0&text=$user_code&f1=Arial.ttf&f2=8&a1=&a2=&a3=' border=0>
	</div>
</div>

<div class='form-group'>
    <label class='col-sm-2 control-label'>$txt_sys_client_061</label>
    <div class='col-sm-4'>
		<input disabled type='text' class='form-control' id='l-name' name='signdate' value='$signdate_txt'>
	</div>
	<div class='col-sm-2' align=right>IP</div>
    <div class='col-sm-4'>
		<input disabled type='text' class='form-control' id='l-name' name='m_ip' value='$m_ip'>
	</div>
</div>
");
?>
