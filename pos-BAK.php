
<?
/*
    author   = YOGI ANDITIA
    Version  = BETA 1
*/

include "config/common.inc";
if(!$login_id OR $login_id == "" OR $login_level < "1") {
  echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$date = date('Ymd');
include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="<?=$lang?>">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <link rel="shortcut icon" href="img/favicon.ico">

    <title><?=$web_erp_name?></title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />

    <!--dynamic table-->
    <link href="assets/advanced-datatable/media/css/demo_page.css" rel="stylesheet" />
    <link href="assets/advanced-datatable/media/css/demo_table.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" />
      <!--right slidebar-->
      <link href="css/slidebars.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
    <!-- CSS POS -->
    <link rel="stylesheet" href="css/pos.css">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:: POS ::</title>

<script language="javascript" src="utilities.js"></script> 

<script language="javascript">
function onEnter(e){
	var key=e.keyCode || e.which;
	if(key==13){
		showCell();
    showTotal();
    getClear();
	}
}


 function showTotal(){
        $.ajax({
            type:"POST",
            url:"getbytotal.php",
            data:{harga:'hargatotal',ppn:'ppn'},
            success:function(data){
               var harga = '';
               var ppn = '';
               var total = '';
               var totqty = '';
               var totdis = '';
               var gross = '';
                var obj = $.parseJSON(data);
                $.each(obj, function() {
                    harga += this['harga'] + "<br/>";
                    ppn += this['ppn'] + "<br/>";
                    total += this['total'] + "<br/>";
                    totqty += this['totqty'] + "<br/>";
                    totdis += this['totdis'] + "<br/>";
                    gross += this['gross'] + "<br/>";
                });
                $('#subprice').html(harga);
                $('#ppn').html(ppn);
                $('#price').html(total);
                $('#totqty').html(totqty);
                $('#disc').html(totdis);
                $('#gross').html(gross);
            }
        });
    }

function showCell(){
	iObj=document.getElementById("indexCell");
	index=iObj.value.trim();
	newIndex=eval(index)+1;
	
	rObj=document.getElementById("readBarcode");
	valBarcode=rObj.value.trim();

  rObj=document.getElementById("qty");
  valQty=rObj.value.trim();

  rObj=document.getElementById("uid");
  valUid=rObj.value.trim();

	rObj.value="";rObj.focus(); iObj.value=newIndex;
	doRequested('viewResult'+index,'pos_insert.php?val='+valBarcode+'&index='+newIndex+'&qtys='+valQty+'&uid='+valUid,false);

}

function getClear(){
   $('#readBarcode').focus();
    $('#readBarcode').val('');
    $('#bypcode').val('');
    $('#bypname').val('');
    $('#qty').val('');
}



</script>
<link rel="stylesheet" href="css/jquery-ui-pos.css">

  <script src="js/jquery-1.10.2-pos.js"></script>
  <script src="js/jquery-ui-pos.js"></script>
  <style>
  #bypname-label {
    display: block;
    font-weight: bold;
    margin-bottom: 1em;
  }
  #bypname-icon {
    float: left;
    height: 32px;
    width: 32px;
  }
  #bypname-description {
    margin: 0;
    padding: 0;
  }
  </style>
    <script>
    $(function() {
        function split( val ) {
            return val.split( /,\s*/ );
        }
        function extractLast( term ) {
            return split( term ).pop();
        }
        
        $( "#bypname" ).bind( "keydown", function( event ) {
            if ( event.keyCode === $.ui.keyCode.TAB &&
                $( this ).autocomplete( "instance" ).menu.active ) {
                event.preventDefault();
            }
        })
        .autocomplete({
            minLength: 1,
            source: function( request, response ) {
                // delegate back to autocomplete, but extract the last term
                $.getJSON("getbypname.php", { term : extractLast( request.term )},response);
            },
            focus: function( event, ui ) {
              $( "#bypname" ).val( ui.item.label );
              $( "#readBarcode" ).val( ui.item.value );
              $( "#bypcode" ).val( ui.item.desc );
              return false;
            },
            select: function( event, ui ) {
              $( "#bypname" ).val( ui.item.label );
              $( "#readBarcode" ).val( ui.item.value );
              return false;
            }
        });
    });
    </script>
        <script>
    $(function() {
        function split( val ) {
            return val.split( /,\s*/ );
        }
        function extractLast( term ) {
            return split( term ).pop();
        }
        
        $( "#bypcode" ).bind( "keydown", function( event ) {
            if ( event.keyCode === $.ui.keyCode.TAB &&
                $( this ).autocomplete( "instance" ).menu.active ) {
                event.preventDefault();
            }
        })
        .autocomplete({
            minLength: 1,
            source: function( request, response ) {
                // delegate back to autocomplete, but extract the last term
                $.getJSON("getbypcode.php", { term : extractLast( request.term )},response);
            },
            focus: function( event, ui ) {
              $( "#bypcode" ).val( ui.item.label );
              $( "#readBarcode" ).val( ui.item.value );
              $( "#bypname" ).val( ui.item.desc );
              return false;
            },
            select: function( event, ui ) {
              $( "#bypcode" ).val( ui.item.label );
              $( "#readBarcode" ).val( ui.item.label );
              $( "#readBarcode" ).val( ui.item.value );
              $( "#bypname" ).val( ui.item.desc );
              return false;
            }
        });
    });
    </script>
    <script>
    $(function() {
        function split( val ) {
            return val.split( /,\s*/ );
        }
        function extractLast( term ) {
            return split( term ).pop();
        }
        
        $( "#readBarcode" ).bind( "keydown", function( event ) {
            if ( event.keyCode === $.ui.keyCode.TAB &&
                $( this ).autocomplete( "instance" ).menu.active ) {
                event.preventDefault();
            }
        })
        .autocomplete({
            minLength: 1,
            source: function( request, response ) {
                // delegate back to autocomplete, but extract the last term
                $.getJSON("getbybarcode.php", { term : extractLast( request.term )},response);
            },
            focus: function( event, ui ) {
              $( "#readBarcode" ).val( ui.item.value );
              $( "#bypname" ).val( ui.item.desc );
              $( "#bypcode" ).val( ui.item.lbl1 );
              $( "#uid" ).val( ui.item.uid );
              return false;
            },
            select: function( event, ui ) {
              $( "#readBarcode" ).val( ui.item.label );
              $( "#readBarcode" ).val( ui.item.value );
              return false;
            }
        });
    });
    </script>
    <script>
    function calculateCASH() {
        var totStr =document.form.total.value;
        if (!totStr)
            totStr = '0';
        var cpStr = document.form.cashpay.value;
        if (!cpStr)
            cpStr = '0';
        var total = parseFloat(totStr);
        var cashpay = parseFloat(cpStr);
        document.form.change.value = cashpay - total;
    }
    </script>
    <script type="text/javascript">
      $(document).ready(function() {
        $('.submit_on_enter').keydown(function(event) {
            if (event.keyCode == 13) {
                this.form.submit();
                return false;
             }
        });
      });
    </script>


</head>
<!-- <body onload="document.getElementById('readBarcode').focus();" onkeydown="return (event.keyCode != 116)"> -->
<body onload="document.getElementById('readBarcode').focus();">
    <section id="container" class="">
     
        <section class="wrapper" style='margin: 0 auto;width: 100%;max-width: 1500px; '>
           
           <?php
            $paid = md5($hostname);
            if($pay == $paid){

            $total_query = "SELECT count(org_pcode) FROM pos_detail where temp = 0 AND sales_code = '$login_id' AND hostname = '$hostname'";
            $fetch_total = mysql_query($total_query);
            $total_rows = mysql_result($fetch_total,0);

            for ($k=0;$k<$total_rows;$k++) {
            
            //get matched data from skills table
            $query = "SELECT org_pcode,price,qty,nett,netvat,vat,gross FROM pos_detail where temp = 0 AND sales_code = '$login_id' and hostname = '$hostname'";
            $fetch = mysql_query($query);

            $price = mysql_result($fetch,$k,1);
            $qty1 = mysql_result($fetch,$k,2);
            $nett1 = mysql_result($fetch,$k,3);
            $netvat = mysql_result($fetch,$k,4);
            $vat1 = mysql_result($fetch,$k,5);
            $gross1 = mysql_result($fetch,$k,6);
        /*    while ($row = $query->fetch_assoc()) {
                $data[] = array( 
                 'pcode' => $row['org_pcode']
                , 'price' => $row['price']
                , 'qty' => $row['qty']
                , 'transcode' => $row['transcode']
                );
            }*/

            $nettvat += $netvat;
            $vat += $vat1;
            $nett += $nett1;
            $qty += $qty1;
            $gross += $gross1;

            }
             $totdis = $nett - $gross;
            ?>
             <section class="panel" style='float: left;width: 29%; position: fixed;'>
            <header class="panel-heading">
              PAYMENT
              <span class="tools pull-right">
                <?php  echo '<a href="'.$home.'" class="fa fa-home" data-toggle="tooltip" title="DASHBOARD"></a>'; ?>
                <?php  echo '<a href="'.$home.'/pos.php" class="fa fa-fast-backward" data-toggle="tooltip" title="FIRST"></a>'; ?>
                <?php  echo '<a href="'.$link_post.'?list='.md5($date).'"   class="fa fa-list" data-toggle="tooltip" title="LIST TRANSACTION"></a>'; ?>
                <?php  echo '<a href="'.$link_post.'?row='.md5($hostname).'" class="fa fa-pencil" data-toggle="tooltip" title="EDIT TRANSACTION"></a>'; ?>
                <?php  echo '<a href="'.$link_post.'?delete='.md5($hostname).'" class="fa fa-minus-square" data-toggle="tooltip" title="CLEAR TRANSACTION"></a>'; ?>
             </span>
            </header>
            <div class="panel-body">
              <div class="row">
                 <div class='col-sm-2' style='width: 100%;'>
                  <script src="//ajax.aspnetcdn.com/ajax/jquery.validate/1.8.1/jquery.validate.min.js"></script>
                  <script type="text/javascript">
                    $(document).ready(function(){
                        $("#form").validate();
                      });
                  </script>
                  <style type="text/css">
                  .error {
                      font: normal 10px arial;
                      padding: 3px;
                      margin: 3px;
                      background-color: #ffc;
                      border: 1px solid #c00;
                  }
                 
                 

                  </style>
                  <form  name="form" id="form" action='pos_pay.php' method='post' enctype="multipart/form-data">
                  <table class='sidebar'>
                      <thead>
                           <th  colspan='2'>
                             <p style='font-size:14px; margin:5px 5px;' >TOTAL QTY</p>
                            </th>
                            <th colspan='2'>
                              <p style='font-size:14px; margin:5px 5px;' id='totqty'><?=$qty?></p>
                            </th>
                          </tr>
                          <tr>
                            <th  colspan='2'>
                             <p style='font-size:14px; margin:5px 5px;' >NORMAL PRICE</p>
                            </th>
                            <th colspan='2'>
                              <p style='font-size:14px; margin:5px 5px;' id='gross'><?=number_format($gross)?></p>
                            </th>
                          </tr>
                          <tr>
                            <th  colspan='2'>
                             <p style='font-size:14px; margin:5px 5px; color:red;' >TOTAL DISCOUNT</p>
                            </th>
                            <th colspan='2'>
                              <p style='font-size:14px; margin:5px 5px; color:red;' id='disc'><?=number_format($totdis)?></p>
                            </th>
                          </tr>
                         <tr>
                            <th  colspan='2'>
                             <p style='font-size:14px; margin:5px 5px;' >SUBTOTAL</p>
                            </th>
                            <th colspan='2'>
                              <p style='font-size:14px; margin:5px 5px;' id='subprice'><?=number_format($nettvat)?></p>
                            </th>
                          </tr>
                           <tr>
                            <th  colspan='2'>
                             <p style='font-size:14px; margin:5px 5px;' >PPN</p>
                            </th>
                            <th colspan='2'>
                              <p style='font-size:14px; margin:5px 5px;' id='ppn'><?=number_format($vat)?></p>
                            </th>
                          </tr>
                          <tr>
                            <th  colspan='2'>
                             <p style='font-size:14px; margin:5px 5px;' >TOTAL</p>
                            </th>
                            <th colspan='2'>
                              <p style='font-size:14px; margin:5px 5px;' id='price'><?=number_format($nett)?></p>
                            </th>
                          </tr>
                          <tr>
                            <th  colspan='2'>
                             <p style='font-size:14px; margin:5px 5px;' >PAYMENT TYPE</p>
                            </th>
                            <script>
                            $(document).ready(function() {
                            $('#type').on('change', function () {
                                   var optionSelected = $("option:selected", this);
                                   var valueSelected = this.value;
                                   if(valueSelected == 3){
                                      $('#cashpay1').show();
                                      $('#change1').show();
                                      $('#cardno1').hide();
                                   }
                                   else if(valueSelected == 6 || valueSelected == 9){
                                     $('#cashpay1').hide();
                                      $('#change1').hide();
                                      $('#cardno1').show();
                                   }else{
                                      $('#cashpay1').hide();
                                      $('#change1').hide();
                                      $('#cardno1').hide();
                                   }
                                });
                            });
                          </script>
                            <th colspan='2'>
                              <select name='type' id='type' autofocus  style='font-size:14px; margin:3px; width:70%' class='form-control chzn-select'>
                                  <option>-SELECT-</option>
                                  <option value='3'>CASH</option>
                                  <option value='6'>DEBIT CARD</option>
                                  <option value='9'>CREDIT CARD</option>
                              </select> 
                            </th>
                          </tr>
                          <tr id='cashpay1' style="display:none">
                            <th  colspan='2'>
                             <p style='font-size:14px; margin:5px 5px;' >CASH</p>
                            </th>
                            
                            <th colspan='2'>
                              <input type='hidden' style='font-size:14px; margin:3px; width:70%' name='total' onkeyup="calculateCASH()" value="<?=$nett?>" class='form-control' autofocus>
                              <input type='text' pattern="[0-9.]+" style='font-size:14px; margin:3px; width:70%' id='cashpay' name='cashpay' onkeyup="calculateCASH()"  class='form-control submit_on_enter required amount'>
                            </th>
                          </tr>
                           <tr  id='cardno1' style="display:none">
                            <th  colspan='2'>
                             <p style='font-size:14px; margin:5px 5px;' >CARD NO</p>
                            </th>
                            <th colspan='2'>
                              <input type='text' id='cardno' name='cardno' pattern="[0-9.]+" style='font-size:14px; margin:3px; width:70%' class='form-control submit_on_enter' >
                            </th>
                          </tr>
                          <tr id='change1' style="display:none">
                            <th  colspan='2'>
                             <p style='font-size:14px; margin:5px 5px;' >CHANGE</p>
                            </th>
                            <th colspan='2'>
                              <input type='text' style='font-size:14px; margin:3px; width:70%; border-style:none' name='change' id='change' readonly>
                              <span class='displayamount'></span>
                            </th>
                          </tr>
                         
                      </thead>
                    
                    </table>
                  </form>
                 </div>
              </div>
            </div>
            </section>
            <?}else{?>
            <section class="panel" style='float: left;width: 29%; position: fixed;'>
            <header class="panel-heading">
              INPUT PRODUCT AND TOTAL
              <span class="tools pull-right">
                <?php  echo '<a href="'.$home.'" class="fa fa-home" data-toggle="tooltip" title="DASHBOARD"></a>'; ?>
                <?php  echo '<a href="'.$home.'/pos.php" class="fa fa-fast-backward" data-toggle="tooltip" title="FIRST"></a>'; ?>
                <?php  echo '<a href="'.$link_post.'?list='.md5($date).'"   class="fa fa-list" data-toggle="tooltip" title="LIST TRANSACTION"></a>'; ?>
                <?php  echo '<a href="'.$link_post.'?row='.md5($hostname).'" class="fa fa-pencil" data-toggle="tooltip" title="EDIT TRANSACTION"></a>'; ?>
                <?php  echo '<a href="'.$link_post.'?delete='.md5($hostname).'" class="fa fa-minus-square" data-toggle="tooltip" title="CLEAR TRANSACTION"></a>'; ?>
             </span>
            </header>
           
            <div class="panel-body">
            <div class="row">
                 <div class='col-sm-2' style='width: 100%;'>
                   
                    <table class='sidebar'>
                      <thead>
                          <tr >
                            <th colspan='4' style="background:#FFEA00"><p id="price" style='font-size:45px; margin: 0 auto; width:200px;'></p></th>
                          </tr>
                          <tr>
                            <th  colspan='2'>
                             <p style='font-size:14px; margin:5px 5px;' >NORMAL PRICE</p>
                            </th>
                            <th colspan='2'>
                              <p style='font-size:14px; margin:5px 5px;' id='gross'></p>
                            </th>
                          </tr>
                          <tr>
                            <th  colspan='2'>
                             <p style='font-size:14px; margin:5px 5px; color:red;' >TOTAL DISCOUNT</p>
                            </th>
                            <th colspan='2'>
                              <p style='font-size:14px; margin:5px 5px; color:red;' id='disc'></p>
                            </th>
                          </tr>
                         <tr>
                            <th  colspan='2'>
                             <p style='font-size:14px; margin:5px 5px;' >SUBTOTAL</p>
                            </th>
                            <th colspan='2'>
                              <p style='font-size:14px; margin:5px 5px;' id='subprice'></p>
                            </th>
                          </tr>
                           <tr>
                            <th  colspan='2'>
                             <p style='font-size:14px; margin:5px 5px;' >PPN</p>
                            </th>
                            <th colspan='2'>
                              <p style='font-size:14px; margin:5px 5px;' id='ppn'></p>
                            </th>
                          </tr>
                           <th  colspan='2'>
                             <p style='font-size:14px; margin:5px 5px;' >TOTAL QTY</p>
                            </th>
                            <th colspan='2'>
                              <p style='font-size:14px; margin:5px 5px;' id='totqty'></p>
                            </th>
                          </tr>

                         
                      </thead>
                    
                    </table>
                  </div>
           </div>
            <!-- <div class="row" style='margin-top:2px'>
                  <div class='col-sm-2' style='margin: 0 auto;width: 100%;'>
                      <input disabled type='text' id="bypcode" class='form-control' placeholder='Product Code'>
                  </div>
                  
            </div>
            <div class="row" style='margin-top:2px'>
                <div class='col-sm-2' style='margin: 0 auto;width: 100%;'>
                     <input disabled type='text' id="bypname" class='form-control' placeholder='Product Name'>
                  </div>
            </div> -->  
             <div class="row" style='margin-top:4px'>
             <div class='col-sm-2' style='margin: 0 auto;width: 100%;'>
            <input style='float:left; width:75%; height:40px; font-size:20px;' type="text" id="readBarcode" name="val" onkeypress="onEnter(event)"  class='form-control' placeholder='Barcode' autofocus/>
            <input style='float:right; width:23%; height:40px; font-size:20px;'type="text" id="qty" name="qtys" onkeypress="onEnter(event)" style="text" class='form-control'  placeholder='Qty'/>
            <input type="text" id="indexCell" name="indexCell" value="0" style="display:none" />
            <input type="text" id="uid" name="uid" value="0" style="display:none" />
            </div>
            </div>
            <div>&nbsp;</div>
              

            </div>
            </section >
            
            <?}?>
           



            <section class="panel" style='float: right; width: 70%;  '>
            <header class="panel-heading">
             PRODUCT CART LIST
              
            </header>
             <div class="panel-body">

            
             
              <table class='tab'>
              <thead >
            	<tr>
            		  <!-- <td style="width:30px">NO</td> -->
                  <td style="width:120px">BARCODE</td>
                  <td style="width:90px">ITEM CODE</td>
                	<td style="width:290px">PRODUCT NAME</td>
                  <td style="width:80px">PRICE</td>
                  <td style="width:40px">QTY</td>
                  <td style="width:90px">SUBTOTAL</td>
                  <td style="width:40px">DISC</td>
                  <td style="width:90px">TOTAL</td>
                </tr>
              </thead>
            </table>
            <form name='submitform' method='post' action="<?=$_SERVER['PHP_SELF'];?>" >
           
            <div>
            


            </div>
           
            <div>
            <?php
            
            $bind = md5($hostname);
            if($delete==$bind)
              {
                  $sql_query="DELETE FROM pos_detail WHERE temp = 0 AND hostname='$hostname' AND sales_code='$login_id'";
                  mysql_query($sql_query);
                  echo("<meta http-equiv='Refresh' content='0; URL=$home/pos.php'>");
                  exit;
              }


            $query_ps = "SELECT count(uid) FROM pos_detail where temp = 0 AND sales_code = '$login_id' AND hostname = '$hostname'";
            $result_ps = mysql_query($query_ps);
            $total =  @mysql_result($result_ps,0,0);

            $query_pos = "SELECT org_pcode,transcode,price,qty,nett,gross,vat,disc_rate,barcode FROM pos_detail where sales_code = '$login_id' AND temp = 0 AND hostname = '$hostname' order by date asc";
              $result_pos = mysql_query($query_pos);
              if (!$result_pos) {   error("QUERY_ERROR");   exit; }

            for ($i=0; $i < $total; $i++) { 
            $pcode =  @mysql_result($result_pos,$i,0);
            $transcode1 =  @mysql_result($result_pos,$i,1);
            $price =  @mysql_result($result_pos,$i,2);
            $qty =  @mysql_result($result_pos,$i,3);
            $nett =  @mysql_result($result_pos,$i,4);
            $gross =  @mysql_result($result_pos,$i,5);
            $vat =  @mysql_result($result_pos,$i,6);
            $disc =  @mysql_result($result_pos,$i,7);
            $barcode =  @mysql_result($result_pos,$i,8);

            $query = "SELECT pname FROM shop_product_list WHERE org_pcode = '$pcode'";
            $result = mysql_query($query);
            if (!$result) {   error("QUERY_ERROR");   exit; }
            $pname =  @mysql_result($result,0,0);

             
            ?>

              <table class='tab'>
              <tbody>
            	<tr>
                  <!-- <td style="width:30px"><?//=$i+1?>#</td> -->
                  <td style="width:120px"><?=$barcode?></td>
                  <td style="width:90px"><?=$pcode?></td>
            		  <td style="width:290px"><?php
                    if(strlen($pname) > 35){
                      echo substr($pname,0,35).'...';  
                    }else{
                      echo $pname;
                    }
                    ?>
                  </td>
                  <td style="width:80px"><?=number_format($price);?></td>
                	<td style="width:40px"><?=$qty?></td>
                  <td style="width:90px"><?=number_format($gross);?></td>
                  <td style="width:40px"><?=$disc?>%</td>
                  <td style="width:90px"><?=number_format($nett);?></td>
                  
                </tr>
                </tbody>
            </table>
            <?}
            ?>
            </div>
             <div id="viewResult0">
            </div>
          </div>
          <div id='footer'>
              <div class="row">
                <div class='col-sm-2' style='margin: 0 auto;width: 100%;'>
                  <input type='hidden' id='login' name='login' value='<?=$login_id?>'>
                  <input type='hidden' id='pay' name='pay' value='<?=md5($hostname)?>'>
                  <?php
                    $paid = md5($hostname);
                    if($pay == $paid){?>
                      <?php  echo '<a href="'.$home.'/pos.php" class="btn btn-primary" style=" color:#fff; width:100%;border-color:#81C784;" >BACK</a>'; ?>
                    <?}else{?>
                    <input type='submit' value='PAY' class='btn btn-primary' style=" color:#fff; width:100%;border-color:#81C784;" onfocus=clearField(this)>
                    <?}?>
                  </div>
            </div>
          </div>
          </form>

        </section>

        </section>
        <?php
        $dates = md5($date);
        if($list == $dates){
        ?>
         <div class="panel-body">
        <section class="panel" style='float: right; width: 70%;  '>
           <header class="panel-heading">
             TRANSACTION LIST
           </header>
        </section>
      </div>
        <?}?>
    </section>
</body>
</html>

<?}?>