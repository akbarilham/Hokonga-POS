<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "6") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "restore";
$smenu = "restore_item_store";

if(!$step_next) {
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
	
	<script type="text/JavaScript">
	<!--
	function MM_jumpMenu(targ,selObj,restore){ //v3.0
		eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
		if (restore) selObj.selectedIndex=0;
	}
	//-->
	</script>

  </head>



<section id="container" class="">
      
	  <? include "header.inc"; ?>
	  
      <!--main content start-->
      <section id="main-content">
 
<?
$no_robot_code = rand(100000,999999);
$pin_key = rand(100000,999999);
?>

        
						
		<!--body wrapper start-->
        <div class="wrapper">
        <div class="row">
        <div class="col-sm-12">
        <section class="panel">
        <header class="panel-heading">
            Data Mining
            <span class="tools pull-right">
                <a href="javascript:;" class="fa fa-chevron-down"></a>
             </span>
        </header>
		
        <div class="panel-body">
		
							<div class="form">
                                <form class="cmxform form-horizontal adminex-form" name="signformnow" method="post" action="restore_item_store.php">
								<input type="hidden" name="step_next" value="permit_okay">
								<input type="hidden" name="user_id" value="<?=$login_id?>">
								<input type='hidden' name='mb_level' value='<?=$mb_level?>'>
								<input type='hidden' name='mb_type' value='<?=$mb_type?>'>
								
                                    
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Data</label>
                                        <div class="col-sm-9">
                                            <input class="form-control" id="cname" name="data_name" type="text" value="data_item_store" />
                                        </div>
                                    </div>
									
									<div class="form-group ">
                                        <label for="cname" class="control-label col-sm-3">Selection</label>
                                        <div class="col-sm-9">
                                            <input type="radio" name="job_slct" value="1" checked> Preview &nbsp;&nbsp;&nbsp;&nbsp; 
											<input type="radio" name="job_slct" value="2"> Update Table now &nbsp;&nbsp;&nbsp;&nbsp; 
											<input type="radio" name="job_slct" value="3"> <font color=red>Delete from Table</font>
                                        </div>
                                    </div>
									
                                    
                                    <input type="hidden" name="no_robot_pw_hidden" value="<?=$no_robot_code?>">
									<input type="hidden" name="pin_key" value="<?=$pin_key?>">
											
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <input class="btn btn-primary" type="submit" value="Submit">
                                            <input class="btn btn-default" type="reset" value="<?=$txt_comm_frm07?>">
                                        </div>
                                    </div>
                                </form>
                            </div>
							
        </div>
        </section>
		</div>
		</div>
		</div>
						
						
						
    
    
	<? include "right_slidebar.inc"; ?>
	  
	  <? include "footer.inc"; ?>
	  
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/respond.min.js" ></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>

  <!--right slidebar-->
  <script src="js/slidebars.min.js"></script>

    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>


  </body>
</html>

<?
} else if($step_next == "permit_okay") {


	$signdate = time();
	$post_date1 = date("Ymd",$signdate);
	$post_date2 = date("His",$signdate);
	$post_dates = "$post_date1"."$post_date2";
	
	if($job_slct == "3") {
		
		$query_del1 = "DELETE FROM table_ini_store";
		$result_del1 = mysql_query($query_del1);
		if(!$result_del1) { error("QUERY_ERROR"); exit; }
		
		
		echo("<meta http-equiv='Refresh' content='0; URL=$home/restore_item_store.php'>");
		exit;
	
	} else if($job_slct == "2") {
  
		$store_name_array = "Carrefour Ekspress Bintaro,Carrefour Ekspress Depok,Carrefour Ekspress Harapan Indah,Carrefour Ekspress Kebayoran Lama,Carrefour Ekspress Pasar Minggu,Carrefour Ekspress Sunter,Carrefour Ekspress Singaraja Bali,Carrefour Ekspress Pengayoman Makassar,Carrefour Ekspress Tamalanrea Makassar,Carrefour Ekspress Cipto Cirebon,Carrefour Ekspress Maguwo Yogyakarta,Carrefour Ekspress Solo Baru,Carrefour Ekspress Solo Pabelan,Carrefour Ekspress Ahmad Yani Surabaya,Carrefour Ekspress Blimbing Malang,Carrefour Ekspress Dukuh Kupang Surabaya,Carrefour Ambasador,Carrefour Bekasi Square,Carrefour Blue Mall Bekasi,Carrefour Blok M Square,Carrefour BSD,Carrefour Buaran,Carrefour Kasablanka,Carrefour Emporium Pluit Mall,Carrefour Cempaka Mas,Carrefour Cempaka Putih,Carrefour Central Park,Carrefour Cibinong,Carrefour Cibinong City Mall,Carrefour Cikarang,Carrefour Ciledug Tangerang,Carrefour Cipinang,Carrefour Ciputat,Carrefour Depok,Carrefour Duta Merlin,Carrefour Supermall Karawaci,Carrefour Karawang,Carrefour MOI Kelapa Gading,Carrefour Kramat jati,Carrefour Lebak Bulus,Carrefour Mangga Dua,Carrefour Pluit Village,Carrefour MT Haryono,Carrefour Permata Hijau,Carrefour Puri Indah,Carrefour Season City,Carrefour Taman Mini,Carrefour Taman Palem,Carrefour Tangerang City,Carrefour Transmart Tangcenter,Carrefour Transmart X Mall Kalimalang,Carrefour Sunset Road Denpasar Bali,Carrefour Panakkukang Makassar,Carrefour Serang,Carrefour Trans Studio Makassar,Carrefour Transmart Galara Mall Palu,Carrefour Palembang Square,Carrefour Kiara Condong Bandung,Carrefour Sukajadi Bandung,Carrefour Transmart Cimahi,Carrefour Transmart Cipadung,Carrefour Medan Citra Garden,Carrefour Medan Fair,Carrefour Plaza Ambarukmo Yogyakarta,Carrefour Banyumanik Semarang,Carrefour DP Mall Semarang,Carrefour Armada Magelang,Carrefour Paragon Solo,Carrefour Pekalongan,Carrefour Transmart Kediri,Carrefour Bubutan Junction Surabaya,Carrefour Golden City Surabaya,Carrefour ITC Surabaya,Carrefour Kalimas Surabaya,Carrefour Kalirungkut Surabaya,Carrefour Madiun,Carrefour Mojokerto,Carrefour Pasuruan,Yogya Bogor Junction,Yogya Cimanggu Bogor,Griya Arcamanik,Griya Batununggal,Yogya BTC,Griya Buah Batu,Yogya Cianjur,Yogya Plaza Cimahi,Yogya Ciwalk,Griya Dinasty,Yogya Grand Cirebon,Griya Margahayu,Yogya Tasikmalaya,Yogya Junction 8,Grand Yogya Kepatihan,Yogya Mitra Batik,Griya Pahlawan,Yogya Pajajaran,Griya Pasteur,Yogya Riau Junction,Griya Setrasari,Griya Setiabudi,Yogya Siliwangi,Yogya Grand Subang,Yogya Sukabumi,Yogya Sumber Sari,Yogya Sunda,Griya Ujung Berung,Lottemart Bekasi,Lottemart Bintaro,Lottemart Cimone,Lottemart Fatmawati,Lottemart Gandaria City,Lottemart Kelapa Gading,LOTTEMART KEMANG,Lottemart Kuningan,Lottemart Ratu Plaza,Lottemart Taman Surya,Lottemart Bandung Festival,Lottemart Bandung Electronic Center,Lottemart Medan,Mutiara Super Kitchen Caheum,Mutiara Super Kitchen Kopo,Mutiara Super Kitchen Soekarno Hatta,Mutiara Super Kitchen Ujung Berung,YENS BABY & KIDS,Yomart Grosir,FB Shop Central Park,FB Shop Emporium Pluit,FB Shop Kota Kasablanka,FB Shop Mall Artha Gading,FB Shop Paris Van Java,Carrefour Ekspress Bintaro,Carrefour Ekspress Harapan Indah,Carrefour Medan Citra Garden,Carrefour Medan Fair,Carrefour Ambasador,Carrefour Blue Mall Bekasi,Carrefour Bekasi Square,Carrefour Blok M Square,Carrefour BSD,Carrefour Buaran,Carrefour Emporium Pluit Mall,Carrefour Cempaka Mas,Carrefour Cempaka Putih,Carrefour Central Park,Carrefour Cibinong City Mall,Carrefour Cibinong,Carrefour Ciledug Tangerang,Carrefour Cipinang,Carrefour Duta Merlin,Carrefour Depok,Carrefour Supermall Karawaci,Carrefour Karawang,Carrefour Kasablanka,Carrefour Kramat Jati,Carrefour Lebak Bulus,Carrefour Mangga Dua,Carrefour MOI Kelapa Gading,Carrefour MT Haryono,Carrefour Permata Hijau,Carrefour Pluit Village,Carrefour Puri Indah,Carrefour Season City,Carrefour Taman Palem,Carrefour Taman Mini,Carrefour Transmart Tangcenter,Carrefour Tangerang City,C-4 Trans Cikokol,Carrefour Transmart X Mall Kalimalang,Carrefour Bubutan Junction Surabaya,Carrefour DP Mall Semarang,Carrefour Golden City Surabaya,Carrefour ITC Surabaya,Carrefour Kalimas Surabaya,Carrefour Paragon Solo,Carrefour Kiara Condong Bandung,Carrefour Sukajadi Bandung,Carrefour Transmart Cimahi,Carrefour Sunset Road Denpasar Bali,Centro Bintaro Exchange Mall,Centro Margo City Depok,Centro MOI Kelapa Gading,Centro Summarecon Mall Serpong,Debenham Karawaci,Depo Bangunan Bogor,Depo Bangunan Kalimalang,Depo Bangunan Alam Sutera,Depo Bangunan Denpasar Bali,Depo Bangunan Malang,Depo Bangunan Gedangan Sidoarjo,Depo Bangunan Bandung,Diamond Artha Gading,Diamond Palembang,Farmers Market Baywalk Mall,Farmers Market Bintaro Exchange Mall,Farmers Market Bogor,Farmers Market Lippo Cikarang Citywalk,Farmers Market Citra Garden,Farmers Market Epicentrum Walk,Farmers Market Summarecon Mall Serpong,Farmers Market Grand Galaxy Bekasi,Farmers Market Jababeka Cikarang,Farmers Market Kalibata City Square,Farmers Market Karawaci,Farmers Market Kelapa Gading,Farmers Market Grand Metropolitan Bekasi,Farmers Market Grand Wisata Bekasi,Foodhall Alam Sutera,Foodhall Bellezza,Foodhall Depok,Foodhall Grand Indonesia,Foodhall Kelapa Gading,Foodhall Kebon Jeruk,Foodhall Plaza Indonesia,Foodhall Plaza Senayan,Foodhall Pondok Indah,Foodhall Senayan City,Foodhall Sumarecon Mall Bekasi,Foodhall Villa Delima,Foodmart Atrium Plaza,Foodmart Gourmet Cilandak Town Square,Foodmart Gourmet Supermall Karawaci,Foodmart Gourmet Lippo Plaza Kuningan,Foodmart Basko Padang,Foodmart Gourmet Lippo Plaza Medan,Foodmart Gourmet Sun Plaza Medan,Hypermart Mall Balekota,Hypermart Bekasi Trade Center,Hypermart Sentul,Hypermart Cibubur Junction,Hypermart Lippo Cikarang,Hypermart Orange Country Cikarang,Hypermart Cimanggis Square,Hypermart Mall Ciputra Cibubur,Hypermart Daan Mogot,Hypermart Depok Town Square,Hypermart Ekalosari Bogor,Hypermart Gading Serpong,Hypermart Gajah Mada,Hypermart Grandmall Bekasi,Hypermart Thamrin City,Hypermart Supermall Karawaci,Hypermart Cyberpark Karawaci,Hypermart Techno Karawang,Hypermart Kelapa Gading,Hypermart Kemang Village,Hypermart Mega Kemayoran,Hypermart Metropolis,Hypermart Pejaten,Hypermart Pondok Gede,Hypermart Puri Indah,Hypermart St Moritz,Hypermart Urbana Cinere,Hypermart BTC Balikpapan,Hypermart Q Mall Banjarbaru,Hypermart Mega Mall Batam Centre,Hypermart Cilegon,Hypermart Ciputra Seraya Pekanbaru,Hypermart Kairagi Manado,Hypermart Mataram,Hypermart Manado Town Square,Hypermart Nagoya Hill Batam,Hypermart BTC Pangkal Pinang,Hypermart Mall Ska Pekanbaru,Hypermart BIP Bandung,Hypermart Superblok Cirebon,Hypermart Miko Bandung,Hypermart MTC Bandung,Hypermart Batu Town Square,Hypermart Ciputra World Surabaya,Hypermart City of Tomorrow Surabaya,Hypermart East Coast Center Surabaya,Hypermart Gresik,Hypermart Javamall Semarang,Hypermart Malang Town Square,Hypermart Paragon Semarang,Hypermart Pakuwon Surabaya,Hypermart Royal Plaza Surabaya,Hypermart Sidoarjo Town Square,Hypermart Solo Square,Hypermart WTC Serpong,Hypermart Binjai Supermall Medan,Hypermart Palladium Medan,Hypermart Pematang Siantar Medan,Hypermart Sun Plaza Medan,Kemchick Pasific Place,MDS Arion,MDS Cilandak Town Square,MDS Citraland,MDS Taman Aggrek Mall,Metro Gandaria City,Metro Pacific Place,Metro Plaza Senayan,Metro Pondok Indah,Metro Taman anggrek,Metro Bandung Supermall,Metro Park Solo,Mitra10 Bogor,Mitra10 Cibubur,Mitra10 Depok,Mitra10 Gading Serpong,Mitra10 Kalimalang,Mitra10 Percetakan Negara,Mitra10 Kedungdoro Surabaya,Mitra10 Wiyung Surabaya,Mu Gung Hwa Cikarang,Mu Gung Hwa Green View,Mu Gung Hwa Karawaci,Mu Gung Hwa Senayan,Ranch Market The Breeze,Ranch Market Darmawangsa,Ranch Market Grand Indonesia,Ranch Market Kemang,Ranch Market Lotte Ciputra World,Ranch Market Oakwood,Ranch Market Pesanggrahan,Ranch Market Pondok Indah,Farmers Market The Plaza Balikpapan,Ranch Market Basuki Rahmat Surabaya,Ranch Market Galaxi Surabaya,Ranch Market St. Moriz,Rezeki Harmoni,Rezeki Pluit,Brastagi Cambridge Medan,Brastagi Gatsu Subroto Medan,Mutiara Super Kitchen Soekarno Hatta,Parkson Mall Centre Point Medan,Cafe Glass Dharmahusada,Hero The Plaza Balikpapan,Hero Mataram Mall Lombok,Hero Ratu Indah Makassar,Hero Bintaro Plaza,Hero Citraland,Hero Cokroaminoto,Hero Emerald Bintaro,Hero Gondangdia,Hero Kemang,Hero Kemang Pratama Bekasi,Hero Kota Wisata Bekasi,Hero Living World,Hero Permata Hijau,Hero Pondok Indah Mall,Hero Puri Indah,Hero Sarinah,Hero Plaza Senayan,Hero Taman Anggrek,Hero Tarogong,Hero Grand City Surabaya,Hero Taman Pinang Surabaya,Hero Tunjungan Plaza Surabaya,Hero Yogya Malioboro,Hero Trans Studio Bandung,Giant Palembang,Giant Alam Sutera,Giant Bekasi,Giant Bintaro,Giant Bogor Botani,Giant Bojong Sari,Giant BSD,Giant Mitra10 Cibubur,Giant Cikupa,Giant Ciledug,Giant Cimanggis Depok,Giant Margo City Depok,Giant Graha Raya Bintaro,Giant Harapan Indah,Giant Jababeka,Giant Jati Makmur,Giant Jatiasih,Giant Jonggol Metland,Giant Kalibata,Giant Karang Tengah Lebak Bulus,Giant Point Square Lebak Bulus,Giant Menteng Huis,Giant Padjajaran Bogor,Giant Pamulang,Giant Paramount Serpong,Giant Pondok Cabe,Giant Pondok Gede,Giant Semanggi,Giant Sentul City,Giant Sunter Mall,Giant Tole Iskandar,Giant Villa Melati,Giant Wisma Asri Bekasi,Giant Yasmin Bogor,Giant Central City Semarang,Giant Maspion Plaza Surabaya,Giant MOG Gajahyana Malang,Giant Pondok Tjandra Sidoarjo,Giant Rajawali Surabaya,Giant Sun City Surabaya,Giant Waru Sidoarjo,Giant Parahiangan Bandung,Giant Pasteur Bandung,Giant Superstore Cirebon,Giant HM Joni Medan,Giant Pancing Medan,Jason Ampera,Jason Senopati,Cafe Glass Dharmahusada,Cafe Glass Ngagel,Cafe Glass Nginden,Delta Lombok,Market City Pantai Indah Kapuk,Hokky Dukuh Pakis Surabaya,Al Fresh Gatot Subroto,Al Fresh Pulomas,Al Fresh Tb.Simatupang,Total Buah Ampera,Total Buah Fatmawati,Total Buah Kelapa Gading,Foodmart Atrium Plaza,Foodmart Gourmet Cilandak Town Square,Foodmart Gourmet Supermall Karawaci,Foodmart Mega Mall Karawang,Foodmart Gourmet Lippo Plaza Kuningan,Foodmart Primo Maxx Box Karawaci,Foodmart Ambon Plaza,Foodmart Superblock Balikpapan,Foodmart Basko Padang,Foodmart Gourmet Sunset Bali,Foodmart Lembuswana Samarinda,Foodmart Palembang Icon,Foodmart Grage Mall Cirebon,Foodmart Surabaya Town Square,Foodmart Madiun,Foodmart Lippo Plaza Medan,Foodmart Gourmet Sun Plaza Medan,Hypermart Mall Balekota,Hypermart Sentul,Hypermart Bekasi Trade Center,Hypermart Ekalosari Bogor,Hypermart Cibubur Junction,Hypermart Lippo Cikarang,Hypermart Orange Country Cikarang,Hypermart Cimanggis Square,Hypermart Mall Ciputra Cibubur,Hypermart Depok Town Square,Hypermart Daan Mogot,Hypermart Gading Serpong,Hypermart Gajah Mada,Hypermart Grandmall Bekasi,Hypermart Thamrin City,Hypermart Supermall Karawaci,Hypermart Puri Indah,Hypermart Cyberpark Karawaci,Hypermart Kelapa Gading,Hypermart Kemang Village,Hypermart Mega Kemayoran,Hypermart Techno Karawang,Hypermart Metropolis,Hypermart Pejaten,Hypermart Pondok Gede,Hypermart St Moritz,Hypermart Urbana Cinere,Hypermart WTC Serpong,Hypermart Ambon City Center,Hypermart BTC Balikpapan,Hypermart Bangka Tengah,Hypermart Q Mall Banjarbaru,Hypermart Duta Mall Banjarmasin,Hypermart Mega Mall Batam Centre,Hypermart Bengkulu Indah Mal,Hypermart Bali Galeria Mall Kuta,Hypermart Big Mall Samarinda,Hypermart Cilegon,Hypermart Ciputra Seraya Pekanbaru,Hypermart Mandau City Duri,Hypermart Gorontalo,Hypermart GTC Makassar,Hypermart Kairagi Manado,Hypermart Lippo Plaza Kendari,Hypermart Kuta Icon Bali,Hypermart Eltari Kupang,Hypermart Central Plaza Lampung,Hypermart Maluku City Mall,Hypermart Mataram,Hypermart Megamall Pontianak,Hypermart Manado Town Square,Hypermart Mega Trade Center Manado,Hypermart Nagoya Hill Batam,Hypermart Plaza Samarinda,Hypermart Palembang Square Xtention,Hypermart Palu,Hypermart Panakukang Makassar,Hypermart BTC Pangkal Pinang,Hypermart Jakabaring Palembang,Hypermart Permata Bungo Plaza Jambi,Hypermart Mal Ska Pekanbaru,Hypermart Serang,Hypermart Singkawang Grand Mall,Hypermart The Central Pekanbaru,Hypermart Ternate,Hypermart Tanjung Uncang Batam,Hypermart WTC Batanghari Jambi,Hypermart BIP Bandung,Hypermart Cianjur,Hypermart Superblok Cirebon,Hypermart Miko Bandung,Hypermart MTC Bandung,Hypermart Batu Town Square,Hypermart Bangkalan Plaza Madura,Hypermart Ciputra World Surabaya,Hypermart City of Tomorrow Surabaya,Hypermart East Coast Center Surabaya,Hypermart Gresik,Hypermart Hartono Mall Solo,Hypermart Javamall Semarang,Hypermart Kudus,Hypermart Kediri Town Square,Hypermart Malang Town Square,Hypermart Madiun,Hypermart Paragon Semarang,Hypermart Pekalongan,Hypermart Ponorogo,Hypermart Pakuwon Surabaya,Hypermart Royal Plaza Surabaya,Hypermart Solo Square,Hypermart Grand Mall Solo,Hypermart Sidoarjo Town Square,Hypermart Tegal,Hypermart Yogya City Mall,Hypermart Binjai Supermall Medan,Hypermart Palladium Medan,Hypermart Pematang Siantar Medan,Hypermart Sun Plaza Medan,Suzuya Rocky Padang,Suzuya Bagan Batu Riau,Suzuya Mall Banda Aceh,Suzuya Kampung Baru Medan,Suzuya Rantau Prapat,Suzuya Tanjung Morawa,Home Smart Gatot Subroto Medan,Robinson Karawang,Ramayana Pasar Pringgan Medan,Hartono Elektronik Kerta Jaya,Hartono Elektronik S. Parman Malang,Gudang HO Serpong,Gudang Bandung,Gudang Surabaya,Gudang Medan";
		
		$sp_opt1 = explode(",", $store_name_array);
		for($o1=0; $o1<count($sp_opt1); $o1++) {
			$num = $o1 + 1;
			
			// Store Code
			if($num < 126) {
				$num_branch = "CORP_04";
			} else if($num > 125 AND $num < 328) {
				$num_branch = "CORP_05";
			} else if($num > 327 AND $num < 406) {
				$num_branch = "CORP_03";
			} else if($num > 404) {
				$num_branch = "CORP_02";
			}
			
			$query_cd = "SELECT shop_code,branch_code FROM client_shop WHERE shop_name = '$sp_opt1[$o1]' AND branch_code = '$num_branch'";
			$result_cd = mysql_query($query_cd);
				if (!$result_cd) { error("QUERY_ERROR"); exit; }
			$new_shop_code = @mysql_result($result_cd,0,0);
			$new_branch_code = @mysql_result($result_cd,0,1);
			
			if($num == 538) {
				$new_shop_code2 = "WH_02";
			} else if($num == 539) {
				$new_shop_code2 = "WH_06";
			} else if($num == 540) {
				$new_shop_code2 = "WH_07";
			} else if($num == 541) {
				$new_shop_code2 = "WH_08";
			} else {
				$new_shop_code2 = $new_shop_code;
			}
			
			$new_num5 = sprintf("%05d", $num);
			$new_store_code = "A"."$new_num5";
			
			
				/*
				$query_G = "INSERT INTO table_ini_store (num,store_name,store_code,branch_code,total_stock,new_code) 
							values ('$num','$sp_opt1[$o1]','$new_shop_code2','$num_branch','0','$new_store_code')";
				$result_G = mysql_query($query_G);
				if (!$result_G) { error("QUERY_ERROR"); exit; }
				*/
			
			if($num > 130) {
				$numA = $num - 5;
			} else {
				$numA = $num;
			}
			$new_numA5 = sprintf("%05d", $numA);
			$new_store_codeA = "A"."$new_numA5";
			
			if($num > 130) {
			
				$query_U = "UPDATE table_ini_store SET new_code = '$new_store_codeA' WHERE num = '$num'";
				$result_U = mysql_query($query_U);
				if (!$result_U) { error("QUERY_ERROR"); exit; }
				
			}
				
		
			echo ("$num ... [$num_branch] [$new_shop_code2] $sp_opt1[$o1]</br>");
		}
		
		echo("<meta http-equiv='Refresh' content='10; URL=$home/restore_item_store.php'>");
		exit;
	
	} else if($job_slct == "1") {
  
		$store_name_array = "Carrefour Ekspress Bintaro,Carrefour Ekspress Depok,Carrefour Ekspress Harapan Indah,Carrefour Ekspress Kebayoran Lama,Carrefour Ekspress Pasar Minggu,Carrefour Ekspress Sunter,Carrefour Ekspress Singaraja Bali,Carrefour Ekspress Pengayoman Makassar,Carrefour Ekspress Tamalanrea Makassar,Carrefour Ekspress Cipto Cirebon,Carrefour Ekspress Maguwo Yogyakarta,Carrefour Ekspress Solo Baru,Carrefour Ekspress Solo Pabelan,Carrefour Ekspress Ahmad Yani Surabaya,Carrefour Ekspress Blimbing Malang,Carrefour Ekspress Dukuh Kupang Surabaya,Carrefour Ambasador,Carrefour Bekasi Square,Carrefour Blue Mall Bekasi,Carrefour Blok M Square,Carrefour BSD,Carrefour Buaran,Carrefour Kasablanka,Carrefour Emporium Pluit Mall,Carrefour Cempaka Mas,Carrefour Cempaka Putih,Carrefour Central Park,Carrefour Cibinong,Carrefour Cibinong City Mall,Carrefour Cikarang,Carrefour Ciledug Tangerang,Carrefour Cipinang,Carrefour Ciputat,Carrefour Depok,Carrefour Duta Merlin,Carrefour Supermall Karawaci,Carrefour Karawang,Carrefour MOI Kelapa Gading,Carrefour Kramat jati,Carrefour Lebak Bulus,Carrefour Mangga Dua,Carrefour Pluit Village,Carrefour MT Haryono,Carrefour Permata Hijau,Carrefour Puri Indah,Carrefour Season City,Carrefour Taman Mini,Carrefour Taman Palem,Carrefour Tangerang City,Carrefour Transmart Tangcenter,Carrefour Transmart X Mall Kalimalang,Carrefour Sunset Road Denpasar Bali,Carrefour Panakkukang Makassar,Carrefour Serang,Carrefour Trans Studio Makassar,Carrefour Transmart Galara Mall Palu,Carrefour Palembang Square,Carrefour Kiara Condong Bandung,Carrefour Sukajadi Bandung,Carrefour Transmart Cimahi,Carrefour Transmart Cipadung,Carrefour Medan Citra Garden,Carrefour Medan Fair,Carrefour Plaza Ambarukmo Yogyakarta,Carrefour Banyumanik Semarang,Carrefour DP Mall Semarang,Carrefour Armada Magelang,Carrefour Paragon Solo,Carrefour Pekalongan,Carrefour Transmart Kediri,Carrefour Bubutan Junction Surabaya,Carrefour Golden City Surabaya,Carrefour ITC Surabaya,Carrefour Kalimas Surabaya,Carrefour Kalirungkut Surabaya,Carrefour Madiun,Carrefour Mojokerto,Carrefour Pasuruan,Yogya Bogor Junction,Yogya Cimanggu Bogor,Griya Arcamanik,Griya Batununggal,Yogya BTC,Griya Buah Batu,Yogya Cianjur,Yogya Plaza Cimahi,Yogya Ciwalk,Griya Dinasty,Yogya Grand Cirebon,Griya Margahayu,Yogya Tasikmalaya,Yogya Junction 8,Grand Yogya Kepatihan,Yogya Mitra Batik,Griya Pahlawan,Yogya Pajajaran,Griya Pasteur,Yogya Riau Junction,Griya Setrasari,Griya Setiabudi,Yogya Siliwangi,Yogya Grand Subang,Yogya Sukabumi,Yogya Sumber Sari,Yogya Sunda,Griya Ujung Berung,Lottemart Bekasi,Lottemart Bintaro,Lottemart Cimone,Lottemart Fatmawati,Lottemart Gandaria City,Lottemart Kelapa Gading,LOTTEMART KEMANG,Lottemart Kuningan,Lottemart Ratu Plaza,Lottemart Taman Surya,Lottemart Bandung Festival,Lottemart Bandung Electronic Center,Lottemart Medan,Mutiara Super Kitchen Caheum,Mutiara Super Kitchen Kopo,Mutiara Super Kitchen Soekarno Hatta,Mutiara Super Kitchen Ujung Berung,YENS BABY & KIDS,Yomart Grosir,FB Shop Central Park,FB Shop Emporium Pluit,FB Shop Kota Kasablanka,FB Shop Mall Artha Gading,FB Shop Paris Van Java,Carrefour Ekspress Bintaro,Carrefour Ekspress Harapan Indah,Carrefour Medan Citra Garden,Carrefour Medan Fair,Carrefour Ambasador,Carrefour Blue Mall Bekasi,Carrefour Bekasi Square,Carrefour Blok M Square,Carrefour BSD,Carrefour Buaran,Carrefour Emporium Pluit Mall,Carrefour Cempaka Mas,Carrefour Cempaka Putih,Carrefour Central Park,Carrefour Cibinong City Mall,Carrefour Cibinong,Carrefour Ciledug Tangerang,Carrefour Cipinang,Carrefour Duta Merlin,Carrefour Depok,Carrefour Supermall Karawaci,Carrefour Karawang,Carrefour Kasablanka,Carrefour Kramat Jati,Carrefour Lebak Bulus,Carrefour Mangga Dua,Carrefour MOI Kelapa Gading,Carrefour MT Haryono,Carrefour Permata Hijau,Carrefour Pluit Village,Carrefour Puri Indah,Carrefour Season City,Carrefour Taman Palem,Carrefour Taman Mini,Carrefour Transmart Tangcenter,Carrefour Tangerang City,C-4 Trans Cikokol,Carrefour Transmart X Mall Kalimalang,Carrefour Bubutan Junction Surabaya,Carrefour DP Mall Semarang,Carrefour Golden City Surabaya,Carrefour ITC Surabaya,Carrefour Kalimas Surabaya,Carrefour Paragon Solo,Carrefour Kiara Condong Bandung,Carrefour Sukajadi Bandung,Carrefour Transmart Cimahi,Carrefour Sunset Road Denpasar Bali,Centro Bintaro Exchange Mall,Centro Margo City Depok,Centro MOI Kelapa Gading,Centro Summarecon Mall Serpong,Debenham Karawaci,Depo Bangunan Bogor,Depo Bangunan Kalimalang,Depo Bangunan Alam Sutera,Depo Bangunan Denpasar Bali,Depo Bangunan Malang,Depo Bangunan Gedangan Sidoarjo,Depo Bangunan Bandung,Diamond Artha Gading,Diamond Palembang,Farmers Market Baywalk Mall,Farmers Market Bintaro Exchange Mall,Farmers Market Bogor,Farmers Market Lippo Cikarang Citywalk,Farmers Market Citra Garden,Farmers Market Epicentrum Walk,Farmers Market Summarecon Mall Serpong,Farmers Market Grand Galaxy Bekasi,Farmers Market Jababeka Cikarang,Farmers Market Kalibata City Square,Farmers Market Karawaci,Farmers Market Kelapa Gading,Farmers Market Grand Metropolitan Bekasi,Farmers Market Grand Wisata Bekasi,Foodhall Alam Sutera,Foodhall Bellezza,Foodhall Depok,Foodhall Grand Indonesia,Foodhall Kelapa Gading,Foodhall Kebon Jeruk,Foodhall Plaza Indonesia,Foodhall Plaza Senayan,Foodhall Pondok Indah,Foodhall Senayan City,Foodhall Sumarecon Mall Bekasi,Foodhall Villa Delima,Foodmart Atrium Plaza,Foodmart Gourmet Cilandak Town Square,Foodmart Gourmet Supermall Karawaci,Foodmart Gourmet Lippo Plaza Kuningan,Foodmart Basko Padang,Foodmart Gourmet Lippo Plaza Medan,Foodmart Gourmet Sun Plaza Medan,Hypermart Mall Balekota,Hypermart Bekasi Trade Center,Hypermart Sentul,Hypermart Cibubur Junction,Hypermart Lippo Cikarang,Hypermart Orange Country Cikarang,Hypermart Cimanggis Square,Hypermart Mall Ciputra Cibubur,Hypermart Daan Mogot,Hypermart Depok Town Square,Hypermart Ekalosari Bogor,Hypermart Gading Serpong,Hypermart Gajah Mada,Hypermart Grandmall Bekasi,Hypermart Thamrin City,Hypermart Supermall Karawaci,Hypermart Cyberpark Karawaci,Hypermart Techno Karawang,Hypermart Kelapa Gading,Hypermart Kemang Village,Hypermart Mega Kemayoran,Hypermart Metropolis,Hypermart Pejaten,Hypermart Pondok Gede,Hypermart Puri Indah,Hypermart St Moritz,Hypermart Urbana Cinere,Hypermart BTC Balikpapan,Hypermart Q Mall Banjarbaru,Hypermart Mega Mall Batam Centre,Hypermart Cilegon,Hypermart Ciputra Seraya Pekanbaru,Hypermart Kairagi Manado,Hypermart Mataram,Hypermart Manado Town Square,Hypermart Nagoya Hill Batam,Hypermart BTC Pangkal Pinang,Hypermart Mall Ska Pekanbaru,Hypermart BIP Bandung,Hypermart Superblok Cirebon,Hypermart Miko Bandung,Hypermart MTC Bandung,Hypermart Batu Town Square,Hypermart Ciputra World Surabaya,Hypermart City of Tomorrow Surabaya,Hypermart East Coast Center Surabaya,Hypermart Gresik,Hypermart Javamall Semarang,Hypermart Malang Town Square,Hypermart Paragon Semarang,Hypermart Pakuwon Surabaya,Hypermart Royal Plaza Surabaya,Hypermart Sidoarjo Town Square,Hypermart Solo Square,Hypermart WTC Serpong,Hypermart Binjai Supermall Medan,Hypermart Palladium Medan,Hypermart Pematang Siantar Medan,Hypermart Sun Plaza Medan,Kemchick Pasific Place,MDS Arion,MDS Cilandak Town Square,MDS Citraland,MDS Taman Aggrek Mall,Metro Gandaria City,Metro Pacific Place,Metro Plaza Senayan,Metro Pondok Indah,Metro Taman anggrek,Metro Bandung Supermall,Metro Park Solo,Mitra10 Bogor,Mitra10 Cibubur,Mitra10 Depok,Mitra10 Gading Serpong,Mitra10 Kalimalang,Mitra10 Percetakan Negara,Mitra10 Kedungdoro Surabaya,Mitra10 Wiyung Surabaya,Mu Gung Hwa Cikarang,Mu Gung Hwa Green View,Mu Gung Hwa Karawaci,Mu Gung Hwa Senayan,Ranch Market The Breeze,Ranch Market Darmawangsa,Ranch Market Grand Indonesia,Ranch Market Kemang,Ranch Market Lotte Ciputra World,Ranch Market Oakwood,Ranch Market Pesanggrahan,Ranch Market Pondok Indah,Farmers Market The Plaza Balikpapan,Ranch Market Basuki Rahmat Surabaya,Ranch Market Galaxi Surabaya,Ranch Market St. Moriz,Rezeki Harmoni,Rezeki Pluit,Brastagi Cambridge Medan,Brastagi Gatsu Subroto Medan,Mutiara Super Kitchen Soekarno Hatta,Parkson Mall Centre Point Medan,Cafe Glass Dharmahusada,Hero The Plaza Balikpapan,Hero Mataram Mall Lombok,Hero Ratu Indah Makassar,Hero Bintaro Plaza,Hero Citraland,Hero Cokroaminoto,Hero Emerald Bintaro,Hero Gondangdia,Hero Kemang,Hero Kemang Pratama Bekasi,Hero Kota Wisata Bekasi,Hero Living World,Hero Permata Hijau,Hero Pondok Indah Mall,Hero Puri Indah,Hero Sarinah,Hero Plaza Senayan,Hero Taman Anggrek,Hero Tarogong,Hero Grand City Surabaya,Hero Taman Pinang Surabaya,Hero Tunjungan Plaza Surabaya,Hero Yogya Malioboro,Hero Trans Studio Bandung,Giant Palembang,Giant Alam Sutera,Giant Bekasi,Giant Bintaro,Giant Bogor Botani,Giant Bojong Sari,Giant BSD,Giant Mitra10 Cibubur,Giant Cikupa,Giant Ciledug,Giant Cimanggis Depok,Giant Margo City Depok,Giant Graha Raya Bintaro,Giant Harapan Indah,Giant Jababeka,Giant Jati Makmur,Giant Jatiasih,Giant Jonggol Metland,Giant Kalibata,Giant Karang Tengah Lebak Bulus,Giant Point Square Lebak Bulus,Giant Menteng Huis,Giant Padjajaran Bogor,Giant Pamulang,Giant Paramount Serpong,Giant Pondok Cabe,Giant Pondok Gede,Giant Semanggi,Giant Sentul City,Giant Sunter Mall,Giant Tole Iskandar,Giant Villa Melati,Giant Wisma Asri Bekasi,Giant Yasmin Bogor,Giant Central City Semarang,Giant Maspion Plaza Surabaya,Giant MOG Gajahyana Malang,Giant Pondok Tjandra Sidoarjo,Giant Rajawali Surabaya,Giant Sun City Surabaya,Giant Waru Sidoarjo,Giant Parahiangan Bandung,Giant Pasteur Bandung,Giant Superstore Cirebon,Giant HM Joni Medan,Giant Pancing Medan,Jason Ampera,Jason Senopati,Cafe Glass Dharmahusada,Cafe Glass Ngagel,Cafe Glass Nginden,Delta Lombok,Market City Pantai Indah Kapuk,Hokky Dukuh Pakis Surabaya,Al Fresh Gatot Subroto,Al Fresh Pulomas,Al Fresh Tb.Simatupang,Total Buah Ampera,Total Buah Fatmawati,Total Buah Kelapa Gading,Foodmart Atrium Plaza,Foodmart Gourmet Cilandak Town Square,Foodmart Gourmet Supermall Karawaci,Foodmart Mega Mall Karawang,Foodmart Gourmet Lippo Plaza Kuningan,Foodmart Primo Maxx Box Karawaci,Foodmart Ambon Plaza,Foodmart Superblock Balikpapan,Foodmart Basko Padang,Foodmart Gourmet Sunset Bali,Foodmart Lembuswana Samarinda,Foodmart Palembang Icon,Foodmart Grage Mall Cirebon,Foodmart Surabaya Town Square,Foodmart Madiun,Foodmart Lippo Plaza Medan,Foodmart Gourmet Sun Plaza Medan,Hypermart Mall Balekota,Hypermart Sentul,Hypermart Bekasi Trade Center,Hypermart Ekalosari Bogor,Hypermart Cibubur Junction,Hypermart Lippo Cikarang,Hypermart Orange Country Cikarang,Hypermart Cimanggis Square,Hypermart Mall Ciputra Cibubur,Hypermart Depok Town Square,Hypermart Daan Mogot,Hypermart Gading Serpong,Hypermart Gajah Mada,Hypermart Grandmall Bekasi,Hypermart Thamrin City,Hypermart Supermall Karawaci,Hypermart Puri Indah,Hypermart Cyberpark Karawaci,Hypermart Kelapa Gading,Hypermart Kemang Village,Hypermart Mega Kemayoran,Hypermart Techno Karawang,Hypermart Metropolis,Hypermart Pejaten,Hypermart Pondok Gede,Hypermart St Moritz,Hypermart Urbana Cinere,Hypermart WTC Serpong,Hypermart Ambon City Center,Hypermart BTC Balikpapan,Hypermart Bangka Tengah,Hypermart Q Mall Banjarbaru,Hypermart Duta Mall Banjarmasin,Hypermart Mega Mall Batam Centre,Hypermart Bengkulu Indah Mal,Hypermart Bali Galeria Mall Kuta,Hypermart Big Mall Samarinda,Hypermart Cilegon,Hypermart Ciputra Seraya Pekanbaru,Hypermart Mandau City Duri,Hypermart Gorontalo,Hypermart GTC Makassar,Hypermart Kairagi Manado,Hypermart Lippo Plaza Kendari,Hypermart Kuta Icon Bali,Hypermart Eltari Kupang,Hypermart Central Plaza Lampung,Hypermart Maluku City Mall,Hypermart Mataram,Hypermart Megamall Pontianak,Hypermart Manado Town Square,Hypermart Mega Trade Center Manado,Hypermart Nagoya Hill Batam,Hypermart Plaza Samarinda,Hypermart Palembang Square Xtention,Hypermart Palu,Hypermart Panakukang Makassar,Hypermart BTC Pangkal Pinang,Hypermart Jakabaring Palembang,Hypermart Permata Bungo Plaza Jambi,Hypermart Mal Ska Pekanbaru,Hypermart Serang,Hypermart Singkawang Grand Mall,Hypermart The Central Pekanbaru,Hypermart Ternate,Hypermart Tanjung Uncang Batam,Hypermart WTC Batanghari Jambi,Hypermart BIP Bandung,Hypermart Cianjur,Hypermart Superblok Cirebon,Hypermart Miko Bandung,Hypermart MTC Bandung,Hypermart Batu Town Square,Hypermart Bangkalan Plaza Madura,Hypermart Ciputra World Surabaya,Hypermart City of Tomorrow Surabaya,Hypermart East Coast Center Surabaya,Hypermart Gresik,Hypermart Hartono Mall Solo,Hypermart Javamall Semarang,Hypermart Kudus,Hypermart Kediri Town Square,Hypermart Malang Town Square,Hypermart Madiun,Hypermart Paragon Semarang,Hypermart Pekalongan,Hypermart Ponorogo,Hypermart Pakuwon Surabaya,Hypermart Royal Plaza Surabaya,Hypermart Solo Square,Hypermart Grand Mall Solo,Hypermart Sidoarjo Town Square,Hypermart Tegal,Hypermart Yogya City Mall,Hypermart Binjai Supermall Medan,Hypermart Palladium Medan,Hypermart Pematang Siantar Medan,Hypermart Sun Plaza Medan,Suzuya Rocky Padang,Suzuya Bagan Batu Riau,Suzuya Mall Banda Aceh,Suzuya Kampung Baru Medan,Suzuya Rantau Prapat,Suzuya Tanjung Morawa,Home Smart Gatot Subroto Medan,Robinson Karawang,Ramayana Pasar Pringgan Medan,Hartono Elektronik Kerta Jaya,Hartono Elektronik S. Parman Malang,Gudang HO Serpong,Gudang Bandung,Gudang Surabaya,Gudang Medan";
		
		$sp_opt1 = explode(",", $store_name_array);
		for($o1=0; $o1<count($sp_opt1); $o1++) {
			$num = $o1 + 1;
			
			// Store Code
			if($num < 126) {
				$num_branch = "CORP_04";
			} else if($num > 125 AND $num < 328) {
				$num_branch = "CORP_05";
			} else if($num > 327 AND $num < 406) {
				$num_branch = "CORP_03";
			} else if($num > 404) {
				$num_branch = "CORP_02";
			}
			
			$query_cd = "SELECT shop_code,branch_code FROM client_shop WHERE shop_name = '$sp_opt1[$o1]' AND branch_code = '$num_branch'";
			$result_cd = mysql_query($query_cd);
				if (!$result_cd) { error("QUERY_ERROR"); exit; }
			$new_shop_code = @mysql_result($result_cd,0,0);
			$new_branch_code = @mysql_result($result_cd,0,1);
			
			if($num == 538) {
				$new_shop_code2 = "WH_02";
			} else if($num == 539) {
				$new_shop_code2 = "WH_06";
			} else if($num == 540) {
				$new_shop_code2 = "WH_07";
			} else if($num == 541) {
				$new_shop_code2 = "WH_08";
			} else {
				$new_shop_code2 = $new_shop_code;
			}
			
			echo ("$num ... [$num_branch] [$new_shop_code2] $sp_opt1[$o1]</br>");
		}
											

		echo("<meta http-equiv='Refresh' content='30; URL=$home/restore_item_store.php'>");
		exit;
		
	}

 
}

}
?>