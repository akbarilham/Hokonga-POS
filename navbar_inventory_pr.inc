
    <?
	// 1. Product Search
	global $ratio_nav2_pre,$ratio_nav3_pre;
	// 2. Purchase Request
	$query_nav2a = "SELECT count(uid) FROM shop_purchase WHERE f_class = 'in' AND do_status < '3'";
	$result_nav2a = mysql_query($query_nav2a,$dbconn);
		if (!$result_nav2a) { error("QUERY_ERROR"); exit; }
	$all_nav2a = @mysql_result($result_nav2a,0,0);
	
	$query_nav2 = "SELECT count(uid) FROM shop_purchase WHERE f_class = 'in' AND do_status = '0'";
	$result_nav2 = mysql_query($query_nav2,$dbconn);
		if (!$result_nav2) { error("QUERY_ERROR"); exit; }
	$all_nav2 = @mysql_result($result_nav2,0,0);
	if($all_nav2 != 0 && $all_nav2 != NULL && $all_nav2a != 0 && $all_nav2a != NULL){ // isset variable not empty
		$ratio_nav2_pre = ( $all_nav2 / $all_nav2a ) * 100;
	}
	$ratio_nav2 = round($ratio_nav2_pre);
	
	// 3. Purchase Approval
	$query_nav3a = "SELECT count(uid) FROM shop_purchase WHERE f_class = 'in' AND order_status < '3'";
	$result_nav3a = mysql_query($query_nav3a,$dbconn);
		if (!$result_nav3a) { error("QUERY_ERROR"); exit; }
	$all_nav3a = @mysql_result($result_nav3a,0,0);
	
	$query_nav3 = "SELECT count(uid) FROM shop_purchase WHERE f_class = 'in' AND order_status = '1'";
	$result_nav3 = mysql_query($query_nav3,$dbconn);
		if (!$result_nav3) { error("QUERY_ERROR"); exit; }
	$all_nav3 = @mysql_result($result_nav3,0,0);
	if($all_nav3 != 0 && $all_nav3 != NULL && $all_nav3a != 0 && $all_nav3a != NULL){ // isset variable not empty
		$ratio_nav3_pre = ( $all_nav3 / $all_nav3a ) * 100;
	}
	$ratio_nav3 = round($ratio_nav3_pre);
	?>
	
	
	<div class="row">
    <div class="col-sm-12">
        <section class="panel">
			<div class="panel-body">
		
				<div class="our-skill">
                    <div class="skill">
						<? if(($now_group_admin == "1" AND $smodule_01B01 == "1") OR $now_group_admin == "0") { ?>
                        <div class="our-progress">
                            <a href="<?=$link_module_01B01?>"><div id="donutchart1" data-percent="100"></div></a>
                            <p><?=$title_module_01B01?></p>
                        </div>
						<? } ?>
						
						<? if(($now_group_admin == "1" AND $smodule_01B02 == "1") OR $now_group_admin == "0") { ?>
                        <div class="our-progress">
                            <a href="<?=$link_module_01B02?>"><div id="donutchart2" data-percent="<?=$ratio_nav2?>"></div></a>
                            <p><?=$title_module_01B02?></p>
                        </div>
						<? } ?>

                        <? if(($now_group_admin == "1" AND $smodule_01B03 == "1") OR $now_group_admin == "0") { ?>
						<div class="our-progress">
                            <a href="<?=$link_module_01B03?>"><div id="donutchart3" data-percent="<?=$ratio_nav3?>"></div></a>
                            <p><?=$title_module_01B03?></p>
                        </div>
						<? } ?>
                    </div>
                </div>
		
			</div>
		</section>
	</div>
	</div>
