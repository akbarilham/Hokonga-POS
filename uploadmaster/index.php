
<!--
/*
 * jQuery File Upload Plugin Demo
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */
-->
<html lang="en">
<head>
<!-- Force latest IE rendering engine or ChromeFrame if installed -->
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<![endif]-->
<meta charset="utf-8">
<title>UPLOAD MASTER</title>
<meta name="description" content="File Upload widget with multiple file selection, drag&amp;drop support, progress bars, validation and preview images, audio and video for jQuery. Supports cross-domain, chunked and resumable file uploads and client-side image resizing. Works with any server-side platform (PHP, Python, Ruby on Rails, Java, Node.js, Go etc.) that supports standard HTML form file uploads.">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap styles -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<!-- Generic page styles -->
<link rel="stylesheet" href="css/style.css">
<!-- blueimp Gallery styles -->
<link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="css/jquery.fileupload.css">
<link rel="stylesheet" href="css/jquery.fileupload-ui.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="css/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" href="css/jquery.fileupload-ui-noscript.css"></noscript>
<script language="javascript" type="text/javascript">
document.onkeydown = function(){
  switch (event.keyCode){
        case 116 : //F5 button
            event.returnValue = false;
            event.keyCode = 0;
            return false;
        case 82 : //R button
            if (event.ctrlKey){ 
                event.returnValue = false;
                event.keyCode = 0;
                return false;
            }
    }
}
</script>
</head>



<body>
<div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-fixed-top .navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="http://10.10.2.10/uploadmaster/index.php">FEELBUY</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="#"></a></li>
            </ul>
        </div>
    </div>
</div>
<div class="container">
    <h1>UPLOAD MASTER</h1>
    <h2 class="lead"></h2>
    <ul class="nav nav-tabs">
      <?php
//koneksi ke database, username,password  dan namadatabase menyesuaikan 
mysql_connect('localhost', 'root', 'cIhUy?');
mysql_select_db('masteritem');

//memanggil file excel_reader
require "excel_reader.php";

//jika tombol import ditekan
if(isset($_POST['submit'])){

    $target = basename($_FILES['filepegawaiall']['name']) ;
    move_uploaded_file($_FILES['filepegawaiall']['tmp_name'], $target);
    
    $data = new Spreadsheet_Excel_Reader($_FILES['filepegawaiall']['name'],false);
    
//    menghitung jumlah baris file xls
    $baris = $data->rowcount($sheet_index=0);
    
//    jika kosongkan data dicentang jalankan kode berikut
    $drop = isset( $_POST["drop"] ) ? $_POST["drop"] : 0 ;
    if($drop == 1){
//             kosongkan tabel pegawai
             $truncate ="TRUNCATE TABLE pegawai";
             mysql_query($truncate);
    };


	if (isset($_POST['keyes'])) {
		$keyes = $_POST['keyes'];
	}
	
	if (isset($_POST['validasi'])) {
		$validasi = $_POST['validasi'];
	}

	if (isset($_POST['tokoid'])) {
		$tokoid = $_POST['tokoid'];
	}
	
	

	if($keyes == $validasi){
	
	
//    import data excel mulai baris ke-2 (karena tabel xls ada header pada baris 1)

//       membaca data (kolom ke-1 sd terakhir)
      $toko				= $data->val(4, 2);
      $counter			= $data->val(5, 2);
      $checker			= $data->val(6, 2);
	  $tgl				= $data->val(7, 2);
	  $start			= $data->val(8, 2);
	  $end				= $data->val(9, 2);
	  $under			= $data->val(10, 2);
	  

//      setelah data dibaca, masukkan ke tabel pegawai sql
      $query = "INSERT into area (toko,counter,checker,tgl,start,end,under,keyes)values('$tokoid','$counter','$checker','$tgl','$start','$end','$under','$keyes')";
      $hasil = mysql_query($query);
	  
    for ($i=14; $i<=3200; $i++)
    {
//       membaca data (kolom ke-1 sd terakhir)
      $item_code		= $data->val($i, 1);
      $brand			= $data->val($i, 2);
      $description		= $data->val($i, 3);
	  $unit				= $data->val($i, 4);
	  $barcode			= $data->val($i, 5);
	  $qty				= $data->val($i, 6);
	  if($qty==0){
		  
	  }else{
//      setelah data dibaca, masukkan ke tabel pegawai sql
      $query = "INSERT into masteritem (item_code,brand,description,unit,barcode,qty,keyes)values('$item_code','$brand','$description','$unit','$barcode','$qty','$keyes')";
      $hasil = mysql_query($query);
	  }
   }
    
    if(!$hasil){
//          jika import gagal
          die(mysql_error());
      }else{
//          jika impor berhasil
          echo "
		 <div class='container'>
		 <div class='row fileupload-buttonbar'>
		 <div class='col-lg-7'>Upload Success</div>
		 </div>
		 </div>
		  ";
    }
    }else{
		
		echo "
			 <style rel='stylesheet'>
		#validasi {
			
			border:5px solid red;
		}
   </style>
		
		";
	}
//    hapus file xls yang udah dibaca
    unlink($_FILES['filepegawaiall']['name']);
	clearstatcache();
}

if (isset($_GET['del'])) {
		$del = $_GET['del'];
	}

if($del == true){
	var_dump ($del);
	$query_delete1 = "delete from masteritem where keyes = '$del'";
	$hasil1 = mysql_query($query_delete1);	
	var_dump($query_delete1);
	$query_delete2 = "delete from area where keyes = '$del'";
$hasil2 = mysql_query($query_delete2);		
}


$query_sum	 	= "SELECT sum(qty) FROM masteritem ";
$result_sum		= mysql_query($query_sum);
$sum		 	= @mysql_result($result_sum,0,0);


?>  
    </ul>
    <br>
    
    <br>
    <!-- The file upload form used as target for the file upload widget -->
  
<script type="text/javascript">
//    validasi form (hanya file .xls yang diijinkan)
    function validateForm()
    {
        function hasExtension(inputID, exts) {
            var fileName = document.getElementById(inputID).value;
            return (new RegExp('(' + exts.join('|').replace(/\./g, '\\.') + ')$')).test(fileName);
        }

        if(!hasExtension('filepegawaiall', ['.xls','.xlsx'])){
            alert("Hanya file XLS (Excel 2003) yang diijinkan.");
            return false;
        }
    }
</script>
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar">
            <div class="col-lg-7">
                <!-- The fileinput-button span is used to style the file input field as button -->
				<form name="myForm" id="myForm" onSubmit="return validateForm()" action="index.php" method="post" enctype="multipart/form-data">
					
					<?php
						if (isset($_GET['code'])) {
							$code = $_GET['code'];
						}
						
						
						
						
						
						if (isset($_GET['del'])) {
							$del = $_GET['del'];
						}
						
						
						
					$query = "SELECT id,name,underpt FROM toko ORDER BY NAME ASC";
					$result = mysql_query($query) or die(mysql_error()."[".$query."]");
					?>

					<select class="form-control" style="widget:300px;margin:5px" name="tokoid">
					<?php 
					while ($row = mysql_fetch_array($result))
					{
						echo "<option value='".$row['id']."'>".$row['name'].'  -  '.$row['underpt']."</option>";
					}
					?>        
					</select>
					
					
					<input class="btn btn-success fileinput-button form-control" style="widget:300px;margin:5px" type="file" id="filepegawaiall" name="filepegawaiall" />
					<?php $keyes = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', 5)), 0, 5); ?>
					<input align="center" class="form-control" style="width:100px;margin:5px" disabled type="text"  value="<?php echo $keyes ?>">
					<input  type="hidden" name="keyes" value="<?php echo $keyes ?>">
					
					<input class="form-control" style="width:100px;margin:5px" id="validasi" type="text" name="validasi" value="" placeholder="CACPCHA">
                <!--<span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Add files...</span>
                    
                </span>-->
				<br>
				<br>
                <button type="submit" class="btn btn-primary start" style="width:150px;margin:5px" name="submit">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start upload</span>
                </button>
                <!--<button type="reset" class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel upload</span>
                </button>
                <button type="button" class="btn btn-danger delete">
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" class="toggle">-->
                <!-- The global file processing state -->
                <span class="fileupload-process"></span>
				
				<!-- <label><input type="checkbox" name="drop" value="1" /> <u>Kosongkan tabel sql terlebih dahulu.</u> </label> -->
				</form>
            </div>
            <!-- The global progress state -->
            <div class="col-lg-5 fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                </div>
                <!-- The extended global progress state -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-striped"><tbody class="files">
		</tbody></table>
    </form>
	
    <div class="panel panel-default">
		
		<a  class="btn btn-primary start" href="http://10.10.2.10/uploadmaster/index.php?cat=toko">by TOKO</a>
		<a  class="btn btn-primary start" href="http://10.10.2.10/uploadmaster/index.php?cat=item">by ITEM</a>
		
		<p style='float:right; width:250px;'  >JUMLAH ITEM : <?php echo $sum;?></p>
		<?php
			if (isset($_GET['cat'])) {
				$cat = $_GET['cat'];
			}
			if($cat == 'item'){
			?>
			<table border="0" width="100%" style="margin:5px" class="table table-bordered table-striped table-condensed">
				<tr>
					<th>NO</th>
					<th>ITEM CODE</th>
					<th>DESCRIPTION</th>
					<th>QTY</th>
				</tr>
				<?php
					/* $query_countmitem	 	= "SELECT COUNT(*) FROM masteritem group by item_code having count(*) > 1";
					$result_countmitem 		= mysql_query($query_countmitem);
					$countmitem 			= @mysql_result($result_countmitem,0,0);

					for($q=0; $q<$countmitem; $q++){ 
					
					
						$itemcode 				= @mysql_result($result_countmitem2,$q,0);
						$itemdesc 				= @mysql_result($result_countmitem2,$q,1);
						$sumqty 				= @mysql_result($result_countmitem2,$q,2);*/
						
						$query_countmitem2	 	= "SELECT item_code,description,sum(qty) FROM masteritem group by item_code";
						$result = mysql_query($query_countmitem2) or die(mysql_error()."[".$query_countmitem2."]");
						$num_rows = mysql_num_rows($result);
						
						$i = 1;
						while ($row = mysql_fetch_array($result))
						{
						
						$itemcode = $row['item_code'];
						$itemdesc = $row['description'];
						$sumqty = $row['sum(qty)'];
							
							echo '
							<tr>
								<td>'.$i++.'</td>
								<td>'.$itemcode.'</td>
								<td>'.$itemdesc.'</td>
								<td>'.$sumqty.'</td>
							</tr>
						';
						
						}
						echo "
							
							<tr>
									<tr>
										<th colspan='3'> TOTAL</th>
										<th>$sum</th>
									</tr>
							";
						
						
						
						
						
					
					
					
				?>
			</table>
			<?}else{?>
		
	   <table border="0" width="100%" style="margin:5px" class="table table-bordered table-striped table-condensed">
						<tr>
							<th>NO</th>
							<th>TOKO</th>
							<th>UNDER PT</th>
							<th>JUMLAH</th>
							<th>CODE</th>
							<th>HAPUS</th>
						</tr>
	
				
					<?php
					$query_COUNT = "SELECT COUNT(toko) FROM area";
					$result_COUNT = mysql_query($query_COUNT);
					$COUNT =  @mysql_result($result_COUNT,0,0);
					
					$query_d = "SELECT toko FROM area ORDER BY toko ASC";
					$result = mysql_query($query_d) or die(mysql_error()."[".$query_d."]");
					
					FOR ($k = 0; $k < $COUNT; $k++){
					$querys = "SELECT toko,keyes FROM area ";
					$results 		= mysql_query($querys);
					$namatoko 		= @mysql_result($results,$k,0);
					$keyes			= @mysql_result($results,$k,1);
			
					
					$query_getname	= "select name,underpt from toko where id = '$namatoko'";
					$results_getname= mysql_query($query_getname);
					$name			= @mysql_result($results_getname,0,0);
					$underpt		= @mysql_result($results_getname,0,1);
					
					$query_mcount	= "select count(uid),sum(qty) from masteritem where keyes = '$keyes' order by item_code asc";
					$results_mcount	= mysql_query($query_mcount);
					$mcount			= @mysql_result($results_mcount,0,0);
					$qtysum			= @mysql_result($results_mcount,0,1);
					
					$querymaster 	= "select uid,item_code,description,keyes from masteritem where keyes = '$keyes'";
					$resultsmaster 	= mysql_query($querymaster);
					$uid			= @mysql_result($resultsmaster,0);
					
					echo 
					'
						<tr>
							<td>'.($k+1).'</td>
							<td><a href=http://10.10.2.10/uploadmaster/index.php?code='.$keyes.'>'.$name.'</a></td>
							<td>'.$underpt.'</td>
							<td>'.$qtysum.'</td>
							<td><a href=http://10.10.2.10/uploadmaster/index.php?code='.$keyes.'>'.$keyes.'</a></td>
							<td><a href=http://10.10.2.10/uploadmaster/index.php?del='.$keyes.'>HAPUS</a></td>
						
					';
					
					if(!$code OR $code == ''){
						echo "</tr>";
						
					}else{
						if ($code == $keyes){
							
							$query_getitem		= "select count(uid) from masteritem where keyes = '$code'";
							$results_getitem	= mysql_query($query_getitem);
							$itemcount			= @mysql_result($results_getitem,0,0);
							
							echo "
							</tr>
							<tr>
									<tr>
										<td></td>
										<th>ITEM CODE</th>
										<th>DESCRIPTION</th>
										<th colspan='3'>QTY</th>
										
									</tr>
							";
							
							for($p=0;$p<$itemcount;$p++){
								$query_item		= "select item_code,description,qty,keyes from masteritem where keyes = '$code'";
								$results_item	= mysql_query($query_item);
								$item			= @mysql_result($results_item,$p,0);
								$desc			= @mysql_result($results_item,$p,1);
								$qty			= @mysql_result($results_item,$p,2);
								$keyeees		= @mysql_result($results_item,$p,3);
								
								$query = "SELECT id,name,underpt FROM toko ORDER BY NAME ASC";
								$result = mysql_query($query) or die(mysql_error()."[".$query."]");
								
								
								if ($move == $item){
											echo '
											<tr>

												<td colspan="6"></td>
												
											</tr>
											<tr>
														<td></td>
														<td><b>'.$item.'</b></td>
														<td><b>'.$desc.'</b></td>
														<td colspan="3"><b>'.$qty.'</b></td>
														
															';
															
															echo '
													</tr>
											<tr>
											<td>To</td>
											<td colspan="5">
											<select class="form-control" style="widget:300px;margin:5px" name="tokoid" autofocus>
												' ;
												while ($row = mysql_fetch_array($result))
												{
													echo "<option value='".$row['id']."'>".$row['name'].'  -  '.$row['underpt']."</option>";
												}
												echo '        
												</select>
											</td>
											
											
											</tr>
											<tr>
												<td></td>
												<td colspan="5">
												'; $keyes = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', 5)), 0, 5);echo '
												<input align="center" class="form-control" style="width:100px;margin:5px" disabled type="text"  value="';echo $keyes; echo '">
												<input  type="hidden" name="keyes" value="';echo $keyes; echo '">
													
												<input class="form-control" style="width:100px;margin:5px" id="validasi" type="text" name="validasi" value="" placeholder="CACPCHA">
												<button type="submit" class="btn btn-primary start" style="width:150px;margin:5px" name="submit">
													<i class="glyphicon glyphicon-upload"></i>
													<span>Change</span>
												</button>
												</td>
												
											</tr>
											<tr>

												<td colspan="6"></td>
												
											</tr>
											';
											}else{
												
												echo '
													<tr>
														<td></td>
														<td><a href=http://10.10.2.10/uploadmaster/index.php?move='.$item.'&keyes='.$keyeees.'&code='.$keyeees.'>'.$item.'</a></td>
														<td>'.$desc.'</td>
														<td colspan="3">'.$qty.'</td>
														
															';
															
															echo '
													</tr>
												
												';
												
											}
							
							}
						echo "</tr>
						<tr>
							<td></td>
							<th colspan='2'>TOTAL</th>
							<th <td colspan='2'>$qtysum</th>
							
						</tr>
						<tr>
							<td colspan='6'></td>
						</tr>
						";
						}
						
					}
					
					
					
					
					}
					echo "
							
							<tr>
									<tr>
										<th colspan='3'> TOTAL</th>
										<th>$sum</th>
									</tr>
							";
					
					
				
					
					?>        
					
				
					

				
			
	   </table>
	   <?php } ?>
    </div>
</div>


<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <p class="name">{%=file.name%}</p>
            <strong class="error text-danger"></strong>
        </td>
        <td>
            <p class="size">Processing...</p>
            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
        </td>
        <td>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start" disabled>
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        <td>
            <span class="preview">
                {% if (file.thumbnailUrl) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
                {% } %}
            </span>
        </td>
        <td>
            <p class="name">
                {% if (file.url) { %}
                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                {% } else { %}
                    <span>{%=file.name%}</span>
                {% } %}
            </p>
            {% if (file.error) { %}
                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
            {% } %}
        </td>
        <td>
            <span class="size">{%=o.formatFileSize(file.size)%}</span>
        </td>
        <td>
            {% if (file.deleteUrl) { %}
                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" name="delete" value="1" class="toggle">
            {% } else { %}
                <button class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
{% } %}
</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="js/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<!-- blueimp Gallery script -->
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="js/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="js/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="js/main.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
<!--[if (gte IE 8)&(lt IE 10)]>
<script src="js/cors/jquery.xdr-transport.js"></script>
<![endif]-->
</body>
</html>
