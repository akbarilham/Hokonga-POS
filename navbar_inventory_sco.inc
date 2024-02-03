
    <?
    global $ratio_nav1_pre, $ratio_nav3_pre,$ratio_nav4_pre;
	// 1. Stock Input [0201]
	$query_nav1a = "SELECT count(uid) FROM shop_purchase WHERE f_class = 'out' AND order_status < '4'";
	$result_nav1a = mysql_query($query_nav1a,$dbconn);
		if (!$result_nav1a) { error("QUERY_ERROR"); exit; }
	$all_nav1a = @mysql_result($result_nav1a,0,0);
	
	$query_nav1 = "SELECT count(uid) FROM shop_purchase WHERE f_class = 'out' AND order_status = '2'";
	$result_nav1 = mysql_query($query_nav1,$dbconn);
		if (!$result_nav1) { error("QUERY_ERROR"); exit; }
	$all_nav1 = @mysql_result($result_nav1,0,0);
	if($all_nav1 != 0 && $all_nav1 != NULL && $all_nav1a != 0 && $all_nav1a != NULL){ // isset variable not empty
		$ratio_nav1_pre = ( $all_nav1 / $all_nav1a ) * 100;
	}
	$ratio_nav1 = round($ratio_nav1_pre);
	
	
	// 2. Stock Output [0204]
	
	
	
	// 3. Delivery Check [0205]
	$query_nav3a = "SELECT count(uid) FROM shop_product_list_qty WHERE flag = 'out'";
	$result_nav3a = mysql_query($query_nav3a,$dbconn);
		if (!$result_nav3a) { error("QUERY_ERROR"); exit; }
	$all_nav3a = @mysql_result($result_nav3a,0,0);
	
	$query_nav3 = "SELECT count(uid) FROM shop_product_list_qty WHERE flag = 'out' AND do_status = '1'";
	$result_nav3 = mysql_query($query_nav3,$dbconn);
		if (!$result_nav3) { error("QUERY_ERROR"); exit; }
	$all_nav3 = @mysql_result($result_nav3,0,0);
	if($all_nav3 != 0 && $all_nav3 != NULL && $all_nav3a != 0 && $all_nav3a != NULL){ // isset variable not empty
		$ratio_nav3_pre = ( $all_nav3 / $all_nav3a ) * 100;
	}
	$ratio_nav3 = round($ratio_nav3_pre);
	
	
	// 4. Surat Jalan [0206]
	$query_nav4a = "SELECT count(uid) FROM shop_product_list_do";
	$result_nav4a = mysql_query($query_nav4a,$dbconn);
		if (!$result_nav4a) { error("QUERY_ERROR"); exit; }
	$all_nav4a = @mysql_result($result_nav4a,0,0);
	
	$query_nav4 = "SELECT count(uid) FROM shop_product_list_do WHERE date_do_sent > '1'";
	$result_nav4 = mysql_query($query_nav4,$dbconn);
		if (!$result_nav4) { error("QUERY_ERROR"); exit; }
	$all_nav4 = @mysql_result($result_nav4,0,0);
	
	if($all_nav4 != 0 && $all_nav4 != NULL && $all_nav4a != 0 && $all_nav4a != NULL){ // isset variable not empty
		$ratio_nav4_pre = ( $all_nav4 / $all_nav4a ) * 100;
	}
	$ratio_nav4 = round($ratio_nav4_pre);
	
	
	// 5. Billing Management [0207]
	
	// 6. Product Pick-up [0209]
	
	// 7. Stock Opname [0210]
	
	?>
	
	
	<div class="row">
    <div class="col-sm-12">
        <section class="panel">
			<div class="panel-body">
		
				<div class="our-skill">
                    <div class="skill">
						<? if(($now_group_admin == "1" AND $smodule_0201 == "1") OR $now_group_admin == "0") { ?>
                        <div class="our-progress">
                            <a href="<?=$link_module_0201?>"><div id="donutchart1" data-percent="100"></div></a>
                            <p><?=$title_module_0201?></p>
                        </div>
						<? } ?>

                        <? if(($now_group_admin == "1" AND $smodule_0205 == "1") OR $now_group_admin == "0") { ?>
						<div class="our-progress">
                            <a href="<?=$link_module_0205?>"><div id="donutchart3" data-percent="<?=$ratio_nav3?>"></div></a>
                            <p><?=$title_module_0205?></p>
                        </div>
						<? } ?>

                        <? if(($now_group_admin == "1" AND $smodule_0206 == "1") OR $now_group_admin == "0") { ?>
						<div class="our-progress">
                            <a href="<?=$link_module_0206?>"><div id="donutchart4" data-percent="70"></div></a>
                            <p><?=$title_module_0206?></p>
                        </div>
						<? } ?>
						
						<? if(($now_group_admin == "1" AND $smodule_0204 == "1") OR $now_group_admin == "0") { ?>
                        <div class="our-progress">
                            <a href="<?=$link_module_0204?>"><div id="donutchart2" data-percent="100"></div></a>
                            <p><?=$title_module_0204?></p>
                        </div>
						<? } ?>
						
						<? if(($now_group_admin == "1" AND $smodule_0207 == "1") OR $now_group_admin == "0") { ?>
						<div class="our-progress">
                            <a href="<?=$link_module_0207?>"><div id="donutchart5" data-percent="<?=$ratio_nav5?>"></div></a>
                            <p><?=$title_module_0207?></p>
                        </div>
						<? } ?>
						
						<? if(($now_group_admin == "1" AND $smodule_0209 == "1") OR $now_group_admin == "0") { ?>
                        <div class="our-progress">
                            <a href="<?=$link_module_0209?>"><div id="donutchart6" data-percent="<?=$ratio_nav6?>"></div></a>
                            <p><?=$title_module_0209?></p>
                        </div>
						<? } ?>
						
						<? if(($now_group_admin == "1" AND $smodule_0210 == "1") OR $now_group_admin == "0") { ?>
                        <div class="our-progress">
                            <a href="<?=$link_module_0210?>"><div id="donutchart7" data-percent="<?=$ratio_nav6?>"></div></a>
                            <p><?=$title_module_0210?></p>
                        </div>
						<? } ?>

                    </div>
                </div>
		
			</div>
		</section>
	</div>
	</div>
