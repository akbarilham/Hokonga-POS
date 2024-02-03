
    <?
	// 1. Product Search
	global $ratio_nav2_pre,$ratio_nav3_pre,$ratio_nav4_pre,$ratio_nav5_pre,$ratio_nav6_pre;
	// 2. Purchase Order
	$query_nav2a = "SELECT count(uid) FROM shop_purchase WHERE f_class = 'out' AND order_status < '4'";
	$result_nav2a = mysql_query($query_nav2a,$dbconn);
		if (!$result_nav2a) { error("QUERY_ERROR"); exit; }
	$all_nav2a = @mysql_result($result_nav2a,0,0);
	
	$query_nav2 = "SELECT count(uid) FROM shop_purchase WHERE f_class = 'out' AND order_status = '1'";
	$result_nav2 = mysql_query($query_nav2,$dbconn);
		if (!$result_nav2) { error("QUERY_ERROR"); exit; }
	$all_nav2 = @mysql_result($result_nav2,0,0);
	if($all_nav2 != 0 && $all_nav2 != NULL && $all_nav2a != 0 && $all_nav2a != NULL){ // isset variable not empty
		$ratio_nav2_pre = ( $all_nav2 / $all_nav2a ) * 100;
	}
	$ratio_nav2 = round($ratio_nav2_pre);
	
	// 3. Purchase Approval
	$query_nav3a = "SELECT count(uid) FROM shop_purchase WHERE f_class = 'out' AND order_status < '4'";
	$result_nav3a = mysql_query($query_nav3a,$dbconn);
		if (!$result_nav3a) { error("QUERY_ERROR"); exit; }
	$all_nav3a = @mysql_result($result_nav3a,0,0);
	
	$query_nav3 = "SELECT count(uid) FROM shop_purchase WHERE f_class = 'out' AND order_status = '2'";
	$result_nav3 = mysql_query($query_nav3,$dbconn);
		if (!$result_nav3) { error("QUERY_ERROR"); exit; }
	$all_nav3 = @mysql_result($result_nav3,0,0);
	if($all_nav3 != 0 && $all_nav3 != NULL && $all_nav3a != 0 && $all_nav3a != NULL){ // isset variable not empty
		$ratio_nav3_pre = ( $all_nav3 / $all_nav3a ) * 100;
	}
	$ratio_nav3 = round($ratio_nav3_pre);
	
	
	// 4. Physical Check
	$query_nav4a = "SELECT count(uid) FROM shop_purchase WHERE f_class = 'out' AND do_status < '4'";
	$result_nav4a = mysql_query($query_nav4a,$dbconn);
		if (!$result_nav4a) { error("QUERY_ERROR"); exit; }
	$all_nav4a = @mysql_result($result_nav4a,0,0);
	
	$query_nav4 = "SELECT count(uid) FROM shop_purchase WHERE f_class = 'out' AND do_status < '4' AND check_status = '1'";
	$result_nav4 = mysql_query($query_nav4,$dbconn);
		if (!$result_nav4) { error("QUERY_ERROR"); exit; }
	$all_nav4 = @mysql_result($result_nav4,0,0);
	if($all_nav4 != 0 && $all_nav4 != NULL && $all_nav4a != 0 && $all_nav4a != NULL){ // isset variable not empty
		$ratio_nav4_pre = ( $all_nav4 / $all_nav4a ) * 100;
	}
	$ratio_nav4 = round($ratio_nav4_pre);
	
	
	// 5. Warehousing
	$query_nav5a = "SELECT count(uid) FROM shop_purchase WHERE f_class = 'out' AND do_status = '1'";
	$result_nav5a = mysql_query($query_nav5a,$dbconn);
		if (!$result_nav5a) { error("QUERY_ERROR"); exit; }
	$all_nav5a = @mysql_result($result_nav5a,0,0);
	
	$query_nav5 = "SELECT count(uid) FROM shop_purchase WHERE f_class = 'out' AND do_status = '1' AND check_status > '0'";
	$result_nav5 = mysql_query($query_nav5,$dbconn);
		if (!$result_nav5) { error("QUERY_ERROR"); exit; }
	$all_nav5 = @mysql_result($result_nav5,0,0);
	if($all_nav5 != 0 && $all_nav5 != NULL && $all_nav5a != 0 && $all_nav5a != NULL){ // isset variable not empty
		$ratio_nav5_pre = ( $all_nav5 / $all_nav5a ) * 100;
	}
	$ratio_nav5 = round($ratio_nav5_pre);
	
	// 6. Warehousing Check
	$query_nav6a = "SELECT count(uid) FROM shop_purchase WHERE f_class = 'out' AND do_status < '4' AND check_status > '0'";
	$result_nav6a = mysql_query($query_nav6a,$dbconn);
		if (!$result_nav6a) { error("QUERY_ERROR"); exit; }
	$all_nav6a = @mysql_result($result_nav6a,0,0);
	
	$query_nav6 = "SELECT count(uid) FROM shop_purchase WHERE f_class = 'out' AND do_status = '3' AND check_status > '0'";
	$result_nav6 = mysql_query($query_nav6,$dbconn);
		if (!$result_nav6) { error("QUERY_ERROR"); exit; }
	$all_nav6 = @mysql_result($result_nav6,0,0);
	if($all_nav6 != 0 && $all_nav6 != NULL && $all_nav6a != 0 && $all_nav6a != NULL){ // isset variable not empty
		$ratio_nav6_pre = ( $all_nav6 / $all_nav6a ) * 100;
	}
	$ratio_nav6 = round($ratio_nav6_pre);
	
	
	// 7. Payment
	
	?>
	
	
	<div class="row">
    <div class="col-sm-12">
        <section class="panel">
			<div class="panel-body">
		
				<div class="our-skill">
                    <div class="skill">
						<? if(($now_group_admin == "1" AND $smodule_0101 == "1") OR $now_group_admin == "0") { ?>
                        <div class="our-progress">
                            <a href="<?=$link_module_0101?>"><div id="donutchart1" data-percent="100"></div></a>
                            <p><?=$title_module_0101?></p>
                        </div>
						<? } ?>
						
						<? if(($now_group_admin == "1" AND $smodule_0102 == "1") OR $now_group_admin == "0") { ?>
                        <div class="our-progress">
                            <a href="<?=$link_module_0102?>"><div id="donutchart2" data-percent="<?=$ratio_nav2?>"></div></a>
                            <p><?=$title_module_0102?></p>
                        </div>
						<? } ?>

                        <? if(($now_group_admin == "1" AND $smodule_0103 == "1") OR $now_group_admin == "0") { ?>
						<div class="our-progress">
                            <a href="<?=$link_module_0103?>"><div id="donutchart3" data-percent="<?=$ratio_nav3?>"></div></a>
                            <p><?=$title_module_0103?></p>
                        </div>
						<? } ?>

                        <? if(($now_group_admin == "1" AND $smodule_0104 == "1") OR $now_group_admin == "0") { ?>
						<div class="our-progress">
                            <a href="<?=$link_module_0104?>"><div id="donutchart4" data-percent="<?=$ratio_nav4?>"></div></a>
                            <p><?=$title_module_0104?></p>
                        </div>
						<? } ?>
						
						<? if(($now_group_admin == "1" AND $smodule_0105 == "1") OR $now_group_admin == "0") { ?>
						<div class="our-progress">
                            <a href="<?=$link_module_0105?>"><div id="donutchart5" data-percent="100"></div></a>
                            <p><?=$title_module_0105?></p>
                        </div>
						<? } ?>
						
						<? if(($now_group_admin == "1" AND $smodule_0106 == "1") OR $now_group_admin == "0") { ?>
                        <div class="our-progress">
                            <a href="<?=$link_module_0106?>"><div id="donutchart6" data-percent="<?=$ratio_nav6?>"></div></a>
                            <p><?=$title_module_0106?></p>
                        </div>
						<? } ?>
						

                    </div>
                </div>
		
			</div>
		</section>
	</div>
	</div>
