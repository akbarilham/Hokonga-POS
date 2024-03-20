<?
/*
@author : YOGI ANDITIA;
@version : 1.2 BETA_TEST;

*/

include "../config/common.inc";
include "../config/dbconn.inc";
include "../config/text_main_{$lang}.inc";
require "../config/user_functions_{$lang}.inc";

$mmenu = "main";
$smenu = "dashboard";




if(!$login_id OR $login_level < "1") {

  echo ("<meta http-equiv='Refresh' content='0; URL=../user_login.php'>");

} else {

$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$date = date('Ymd');
$query_getcl = "SELECT sales_code from pos_client where hostname = '$hostname'";
$result_getcl = mysql_query($query_getcl);
$idcode   = @mysql_result($result_getcl, 0, 0);
$update_client = "UPDATE pos_client SET sales_code = '$login_id' where hostname = '$hostname'";
$result_client = mysql_query($update_client);
 if (!$result_client) {
            error("QUERY_ERROR");
            exit;
        }



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
   $("#test").load("<?=$home?>/pos_cart.php");
   $("#diplay").load("<?=$home?>/pos_display.php");
   $('#form')[0].reset();
   $("#gambar").html('<img id="image" style="width: 100px;height: 100px;margin: auto;top: 0; bottom: 0;left: 0;right: 0;position: absolute;" src="img_pos/feelbuy.jpg"/>');
  }
}


function onEnterC(e){
  var key=e.keyCode || e.which;
  if(key==13){
    document.getElementById('qty').focus();
    showTotal();
  $("#test").load("<?=$home?>/pos_cart.php");
  $("#diplay").load("<?=$home?>/pos_display.php");
 
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
			   var transcode = '';
                var obj = $.parseJSON(data);
                $.each(obj, function() {
                    harga += this['harga'] + "<br/>";
                    ppn += this['ppn'] +"<br/>";
                    total += this['total'] + "<br/>";
                    totqty += this['totqty'] + "<br/>";
                    totdis += this['totdis'] + "<br/>";
                    gross += this['gross'] + "<br/>";
					transcode += this['transcode'];
                });
                $('#subprice').html(harga);
                $('#ppn').html(ppn);
                $('#price').html(total);
				
				var dash = parseInt((total).replace(/[^\d.]/g, ''));
				if(dash == 0 ){
					
					$("#dass").hide();
				}else{
					$("#dash").hide();
					
				}
                $('#totqty').html(totqty);
                $('#disc').html(totdis);
                $('#gross').html(gross);
				$('#transcode').val(transcode);
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

  rObj=document.getElementById("bypcode");
  valItem=rObj.value.trim();

    if(valBarcode == '+' || valQty == '+'){
      $("#submitform").submit();
    }else if(valBarcode == 'c' || valQty == 'c'){
      submitClear();
    }else if(valBarcode == 'm' || valQty == 'm'){
      window.location = "<?=$home?>/pos_master.php"
    }else if(valBarcode == 'l' || valQty == 'l'){
      listransaction();
    }else{
    rObj.value="";rObj.focus(); iObj.value=newIndex;
    doRequested('viewResult'+index,'pos_insert.php?val='+valBarcode+'&index='+newIndex+'&qtys='+valQty+'&uid='+valUid+'&item='+valItem,false);
     $("#test").load("<?=$home?>/pos_cart.php");
     $("#diplay").load("<?=$home?>/pos_display.php");

  }
}
function submitClear(){
   $("#clear").submit();
}
function listransaction(){
  window.location = "<?=$home?>/pos_master.php?trans=list"
}
function getClear(){
   $('#readBarcode').focus();
    $('#readBarcode').val('');
    $('#bypcode').val('');
    $('#bypname').val('');
    $('#qty').val('');
    $('#temptotal').val('0');
    $('#itempricedis').val('0');
    $('#discdis').val('0');

}

var height = 0;
$('.table2 tr').each(function(i, value){
    height += parseInt($(this).height());
});

height += '';

$('.table2').animate({scrollTop: height});

$( "#main" ).mouseover(function() {
  location.reload();
});

</script>
<link rel="stylesheet" href="css/jquery-ui-pos.css">
  <script src="js/jquery-1.10.2-pos.js"></script>
  <script src="js/jquery-ui-pos.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
            $('.submit_on_enter_edit').keydown(function(event) {
                if (event.keyCode == 13) {
                  var id = $(this).parent().parent().attr('id');
                  value = $('#'+id+'i').val();
            var data = '?id=' + id +'&val='+value ;
            $.ajax(
            {
                 type: "GET",
                 url: "pos_edit_row.php"+data,
                 data: {qty:'qty',gross:'gross'},
                 cache: false,
                
                 success: function(data)

                 {
                  var qty = '';
                        var gross = '';
                        var nett = '';
                    
                  var obj = $.parseJSON(data);
                          $.each(obj, function() {
                              qty += this['qty'];
                              gross += this['gross'];
                            nett += this['nett'];
                          });
               
                          $('#'+id+'i').val(qty);
                          $('#'+id+'j').text(gross);
                          $('#'+id+'k').text(nett);
                          
                 }
             });
            
                  
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
            minLength: 3,
            source: function( request, response ) {
                // delegate back to autocomplete, but extract the last term
                $.getJSON("getbybarcode.php", { term : extractLast( request.term )},response);
            },
            focus: function( event, ui ) {
              $( "#readBarcode" ).val( ui.item.lbl1 );
              $( "#bypname" ).val( ui.item.desc );
              $( "#bypcode" ).val( ui.item.lbl1 );
              $( "#uid" ).val( ui.item.uid );
              $( "#itemprice" ).val( ui.item.price ).toLocaleString('en');
              $( "#itemdisc").val(ui.item.disc);

              var url= 'img_pos/'+ui.item.lbl1+'.jpg';

              var url= 'img_pos/'+ui.item.lbl1+'.jpg';
            $("#gambar").html('<img id="image" style="width: 100px;height: 100px;margin: auto;top: 0; bottom: 0;left: 0;right: 0;position: absolute;" src="'+url+'"/>');
            $('#image').error(function() {
            $("#gambar").html('<img id="image" style="width: 100px;height: 100px;margin: auto;top: 0; bottom: 0;left: 0;right: 0;position: absolute;" src="img_pos/feelbuy.jpg"/>');
      });

            

              return false;
            },
            select: function( event, ui ) {
              $( "#readBarcode" ).val( ui.item.lbl1 );
              $( "#bypcode" ).val( ui.item.lbl1 );
              $( "#itemprice" ).val( ui.item.price ).toLocaleString('en');
              $( "#itemdisc").val(ui.item.disc);
              return false;
            }
        });
    });

    function calculateItem(){
      var itemprice1 = document.form.itemprice.value;
      if (!itemprice1)
            itemprice1 = '0';
      var itemqty = document.form.qty.value;
      if (!itemqty)
      itemqty = '1';
      var itemdisc1 = document.form.itemdisc.value;
      if (!itemdisc1)
      itemdisc1 = '0';
      var read = document.form.readBarcode.value;
      if (!read){
        document.form.temptotal.value= 0;
        document.form.discdis.value=0;
        document.form.itempricedis.value=0;
        document.form.subpricedis.value=0;
        document.form.ppndis.value=0;
        document.form.qtys.value='';


      }else{
         var price = parseFloat(itemprice1);
        var qty = parseFloat(itemqty);
        var disc = parseFloat(itemdisc1);
        var a= disc/100;
        var b=a*price;
        var c=price-b;
        var d=price/11;
        var e = d*10;
        document.form.temptotal.value= (c * qty).toLocaleString('en');
        document.form.discdis.value=b.toLocaleString('en');
        document.form.itempricedis.value=price.toLocaleString('en');
        document.form.subpricedis.value=e.toLocaleString('en');
        document.form.ppndis.value=d.toLocaleString('en');
      }


       
    }

    function calculateCASH() {
        var totqty = $("#totqty").val();
		var paging = $("#paging").val();
		var too = $("#total").val();
		var grossid = $("#grossid").val();
		var card_cre = $("#cardcre").val();
		var card_deb = $("#carddeb").val();
		var transcode = $("#transcode").val();
		if(!$("#cashpay1").val() || $("#cashpay1").val() == ''){
			var c = 0;
		}else{
			var c = $("#cashpay1").val().replace(/[^\d.]/g, '');
			//var cashpay = parseInt(c);
		}
		
		if(!$("#debamo").val() || $("#debamo").val() == ''){
			var d = 0;
		}else{
			var d = $("#debamo").val().replace(/[^\d.]/g, '');
		}
		
		if(!$("#creamo").val() || $("#creamo").val() == ''){
			var e = 0;
		}else{
			var e = $("#creamo").val().replace(/[^\d.]/g, '');
		}
		
		if(!$("#total").val() || $("#total").val() == ''){
			var f = 0;
		}else{
			var f = $("#total").val().replace(/[^\d.]/g, '');
		}
		
		var totStr =document.form.total.value;
        if (!totStr)
            totStr = '0';
        var cpStr = document.form.cashpay1.value;
        if (!cpStr)
            cpStr = '0';
        var debamoStr = document.form.debamo1.value;
        if (!debamoStr)
            debamoStr = '0';
        var creamoStr = document.form.creamo1.value;
        if (!creamoStr)
            creamoStr = '0';
       var creStr = document.form.cardcre.value;
        if (!creStr)
            creStr = '0';
        var debStr = document.form.carddeb.value;
        if (!debStr)
            debStr = '0';
        var cheStr = document.form.change.value;
        if (!cheStr)
            cheStr = '0';


        var total = parseFloat(totStr);
        var change = parseFloat(cheStr);
        var cashpay = parseInt(cpStr.replace(/[^\d.]/g, ''));
        var debamo = parseInt(debamoStr.replace(/[^\d.]/g, ''));
        var creamo = parseInt(creamoStr.replace(/[^\d.]/g, ''));
        document.form.cashpay.value = cashpay;
        document.form.debamo.value = debamo;
        document.form.creamo.value = creamo;


        if (change<=0){
            $('.submit_on_enter').keydown(function(event) {
            if (event.keyCode == 13) {
             document.getElementById('carddeb').focus();
             }
          });
        }


        if (!$("#carddeb").val()){
          $('.submit_on_enter_carddeb').keydown(function(event) {
            if (event.keyCode == 13) {
             document.getElementById('cardcre').focus();
             }
          });
        }else{
          $('.submit_on_enter_carddeb').keydown(function(event) {
            if (event.keyCode == 13) {
             document.getElementById('debamo1').focus();
             }
          });
        }




        if (!$("#cardcre").val()){
          $('.submit_on_enter_cardcre').keydown(function(event) {
            if (event.keyCode == 13) {
             document.getElementById('cashpay1').focus();
             }
          });

        }else{
          $('.submit_on_enter_cardcre').keydown(function(event) {
            if (event.keyCode == 13) {
             document.getElementById('creamo1').focus();
             }
          });
        }
        
		$('.bayar').keydown(function(event) {
            if (event.keyCode == 40) {
             document.getElementById('back').focus();
             }
          });
		  
		$('.back').keydown(function(event) {
            if (event.keyCode == 38) {
             document.getElementById('bayar').focus();
             }
          });

        if(creamo == '0' && debamo == '0' && cashpay !='0' ){
        //CASH
            document.form.change.value = cashpay - total;
            document.form.changedis.value = (cashpay - total).toLocaleString('en');
			var re = (cashpay - total).toLocaleString('en');
			
            if((cashpay-total) >= 0 ){
              document.form.creamo.value = 0;
              document.form.debamo.value = 0;
              document.form.creamo1.value = 0;
              document.form.debamo1.value = 0;
              $("#debamo1").prop('disabled',true);
              $("#carddeb").prop('disabled',true);
              $("#creamo1").prop('disabled',true);
              $("#cardcre").prop('disabled',true);
			  $('.submit_on_enter').keydown(function(event) {
				if (!$("#cashpay1").val() || $("#cashpay1").val() == '' || $("#cashpay1").val().replace(/[^\d.]/g, '') < total){
					   document.getElementById('carddeb').focus();
					}else{
						
					  if (event.keyCode == 13) {
						  document.getElementById('bayar').focus();
						  $("#bayar").css({"background-color": "#FFEA00", "color": "black"});
						  var a = document.getElementById('bayar');
						  a.setAttribute('href','<?=$home?>/pos_pay.php?cashpay='+cashpay+'&change='+(cashpay-total)+'&login=<?=$login_id?>'+'&totqty='+totqty+'&'+paging+'&total='+too+'&gross='+grossid+'&transcode='+transcode);
						  /*if (answer=confirm("Bayar?\n\nUang Kembalian = Rp. "+re+",-\n\n\n\n\n"))
							{
								if (answer==true) {
								   this.form.submit();
									return false;
								}
							}else{
								location.reload();
							}
							*/
						 }
						 
					}
			  });
            }
        }else if(creamo != '0' && debamo == '0' && cashpay =='0'){
          //CREDIT CARD
            document.form.change.value = creamo - total;
            document.form.changedis.value = (creamo - total).toLocaleString('en');
            if((creamo-total) == 0){
              document.form.cashpay.value = 0;
              document.form.debamo.value = 0;
              document.form.cashpay1.value = 0;
              document.form.debamo1.value = 0;
              $("#cashpay1").prop('disabled',true);
              $("#debamo1").prop('disabled',true);
              $("#carddeb").prop('disabled',true);
              $('.submit_on_enter_crecardamo').keydown(function(event) {
                if (!$("#cardcre").val() || $('#cardcre').val().length != 19){
					   document.getElementById('cardcre').focus();
					}else if($('#creamo').val() != total){
						document.getElementById('creamo1').focus();
					}else{
					  if (event.keyCode == 13) {
						   document.getElementById('bayar').focus();
						    $("#bayar").css({"background-color": "#FFEA00", "color": "black"});
						   var a = document.getElementById('bayar');
						  a.setAttribute('href','<?=$home?>/pos_pay.php?creamo='+creamo+'&cardcre='+card_cre+'&login=<?=$login_id?>'+'&totqty='+totqty+'&'+paging+'&total='+too+'&gross='+grossid+'&transcode='+transcode);
						  /*  if (answer=confirm("Bayar?"))
							{
								if (answer==true) {
								   this.form.submit();
									return false;
								}
							}else{
								location.reload();
							} */
							
						 }
					}
              });
            }else{
              $('.submit_on_enter_crecardamo').keydown(function(event) {
                if (event.keyCode == 13) {
                    document.getElementById('cashpay1').focus();
                 }
              });
            }
        }else if(creamo == '0' && debamo != '0' && cashpay =='0'){
          //DEBIT CARD
            document.form.change.value = debamo - total;
            document.form.changedis.value = (debamo - total).toLocaleString('en');
            if((debamo-total) == 0){
              document.form.cashpay.value = 0;
              document.form.creamo.value = 0;
              document.form.cashpay1.value = 0;
              document.form.creamo1.value = 0;
              $("#cashpay1").prop('disabled',true);
              $("#creamo1").prop('disabled',true);
              $("#cardcre").prop('disabled',true);
             $('.submit_on_enter_debcardamo').keydown(function(event) {
                  if (!$("#carddeb").val() || $('#carddeb').val().length != 19 ){
					   document.getElementById('carddeb').focus();
					}else if($('#debamo').val() != total){
						 document.getElementById('debamo1').focus();
					}else{
					  if (event.keyCode == 13) {
						    document.getElementById('bayar').focus();
							 $("#bayar").css({"background-color": "#FFEA00", "color": "black"});
						   var a = document.getElementById('bayar');
						  a.setAttribute('href','<?=$home?>/pos_pay.php?debamo='+debamo+'&carddeb='+card_deb+'&login=<?=$login_id?>'+'&totqty='+totqty+'&'+paging+'&total='+too+'&gross='+grossid+'&transcode='+transcode);
						  /*  if (answer=confirm("Bayar?"))
							{
								if (answer==true) {
								   this.form.submit();
									return false;
								}
							}else{
								location.reload();
							} */
						 }
					}
                });
             }else{
              $('.submit_on_enter_debcardamo').keydown(function(event) {
                if (event.keyCode == 13) {
                 document.getElementById('cardcre').focus();
                 }
              });
             }
        }else if(creamo == '0' && debamo != '0' && cashpay !='0'){
          //DEBIT CARD AND CASH
            document.form.change.value = (debamo+cashpay) - total;
            //document.form.changedis.value = ((debamo+cashpay) - total).toLocaleString('en');
			var re = ((debamo+cashpay) - total).toLocaleString('en');
            if(((debamo+cashpay)-total) >= 0){
              document.form.creamo.value = 0;
              document.form.creamo1.value = 0;
			  var x = parseInt(c)+parseInt(d) - total;
              $("#creamo1").prop('disabled',true);
              $("#cardcre").prop('disabled',true);
			  document.form.changedis.value = ((debamo+cashpay) - total).toLocaleString('en');
              $('.submit_on_enter_debcardamo,.submit_on_enter').keydown(function(event) {
					
					if (!$("#carddeb").val() || $('#carddeb').val().length != 19){
						document.getElementById('carddeb').focus();
					}else if(!$("#cashpay1").val()){
						document.getElementById('debamo1').focus();
					}else if((parseInt(c)+parseInt(d)) < total){
						document.getElementById('debamo1').focus();
					}else if(x >= parseInt(c)){
						document.getElementById('debamo1').focus();
					}else{
					  if (event.keyCode == 13) {
						  
						  document.getElementById('bayar').focus();
						   $("#bayar").css({"background-color": "#FFEA00", "color": "black"});
						   var a = document.getElementById('bayar');
						  a.setAttribute('href','<?=$home?>/pos_pay.php?debamo='+debamo+'&carddeb='+card_deb+'&cashpay='+cashpay+'&change='+((debamo+cashpay)-total)+'&login=<?=$login_id?>'+'&totqty='+totqty+'&'+paging+'&total='+too+'&gross='+grossid+'&transcode='+transcode);
						  
						    /* if (answer=confirm("Bayar?\n\nUang Kembalian = Rp. "+re+",-\n\n\n\n\n"))
							{
								if (answer==true) {
								   this.form.submit();
									return false;
								}
							}else{
								location.reload();
							} */
						 }
					}
                });
             }else{
              $('.submit_on_enter_debcardamo').keydown(function(event) {
                if (event.keyCode == 13) {
                 document.getElementById('cardcre').focus();
                 }
              });
             }
        }else if(creamo != '0' && debamo == '0' && cashpay !='0'){
          //CREDIT CARD AND CASH
            document.form.change.value = (creamo+cashpay) - total;
            //document.form.changedis.value = ((creamo+cashpay) - total).toLocaleString('en');
			var re = ((creamo+cashpay) - total).toLocaleString('en');
            if(((creamo+cashpay)-total) >= 0){
              document.form.debamo.value = 0;
              document.form.debamo1.value = 0;
			  document.form.changedis.value = ((creamo+cashpay) - total).toLocaleString('en');
			   var x = parseInt(c)+parseInt(e) - total;
              $("#debamo1").prop('disabled',true);
              $("#carddeb").prop('disabled',true);
              $('.submit_on_enter_crecardamo,.submit_on_enter').keydown(function(event) {
                  if (!$("#cardcre").val() || $('#cardcre').val().length != 19){
					   document.getElementById('cardcre').focus();
					}else if(!$("#cashpay1").val()){
						document.getElementById('creamo1').focus();
					}else if((parseInt(c)+parseInt(e)) < total){
						document.getElementById('creamo1').focus();
					}else if(x >= parseInt(c)){
						document.getElementById('creamo1').focus();
					}else{
					  if (event.keyCode == 13) {
							
							 document.getElementById('bayar').focus();
							  $("#bayar").css({"background-color": "#FFEA00", "color": "black"});
						   var a = document.getElementById('bayar');
						  a.setAttribute('href','<?=$home?>/pos_pay.php?creamo='+creamo+'&cardcre='+card_cre+'&cashpay='+cashpay+'&change='+((creamo+cashpay)-total)+'&login=<?=$login_id?>'+'&totqty='+totqty+'&'+paging+'&total='+too+'&gross='+grossid+'&transcode='+transcode);
						  
						   /* if (answer=confirm("Bayar?\n\nUang Kembalian = Rp. "+re+",-\n\n\n\n\n"))
							{
								if (answer==true) {
								   this.form.submit();
									return false;
								}
							}else{
								location.reload();
							} */
							
						 }
					}
                });
             }else{
              $('.submit_on_enter_crecardamo').keydown(function(event) {
                if (event.keyCode == 13) {
                 document.getElementById('cashpay').focus();
                 }
              });
             }
            
        }else if(creamo != '0' && debamo != '0' && cashpay =='0'){
          //DEBIT CARD AND CREDIT CARD
            document.form.change.value = (creamo+debamo) - total;
            //document.form.changedis.value = ((creamo+debamo) - total).toLocaleString('en');
            if(((creamo+debamo)-total) == 0){
              document.form.cashpay.value = 0;
              document.form.cashpay1.value = 0;
              $("#cashpay1").prop('disabled',true);
			  document.form.changedis.value = ((creamo+debamo) - total).toLocaleString('en');
			$('.submit_on_enter_crecardamo,.submit_on_enter_debcardamo').keydown(function(event) {
                   if (!$("#cardcre").val() || $('#cardcre').val().length != 19){
					   document.getElementById('cardcre').focus();
					}else if(!$("#carddeb").val() || $('#carddeb').val().length != 19){
						document.getElementById('carddeb').focus();
					}else if((parseInt(d)+parseInt(e)) != total){
						document.getElementById('creamo1').focus();
					}else{
					  if (event.keyCode == 13) {
						  
						  document.getElementById('bayar').focus();
						   $("#bayar").css({"background-color": "#FFEA00", "color": "black"});
						   var a = document.getElementById('bayar');
						  a.setAttribute('href','<?=$home?>/pos_pay.php?creamo='+creamo+'&cardcre='+card_cre+'&debamo='+debamo+'&carddeb='+card_deb+'&login=<?=$login_id?>'+'&totqty='+totqty+'&'+paging+'&total='+too+'&gross='+grossid+'&transcode='+transcode);
						  
						  
						  /* if (answer=confirm("Bayar?"))
							{
								if (answer==true) {
								   this.form.submit();
									return false;
								}
							}else{
								location.reload();
							} */
						 }
					}
                });
             }else{
              $('.submit_on_enter_crecardamo').keydown(function(event) {
                if (event.keyCode == 13) {
				document.form.changedis.value = ((creamo+debamo) - total).toLocaleString('en');
                 document.getElementById('cashpay1').focus();
                 }
              });
             }
        }else if(creamo != '0' && debamo != '0' && cashpay !='0'){
          //TRIPLE PAY
            document.form.change.value = (creamo+debamo+cashpay) - total;
            document.form.changedis.value = ((creamo+debamo+cashpay) - total).toLocaleString('en');
			var re = ((debamo+creamo+cashpay) - total).toLocaleString('en');
			var x = (parseInt(c)+parseInt(e)+parseInt(d)) - total;
            $('.submit_on_enter_crecardamo,.submit_on_enter_debcardamo,.submit_on_enter').keydown(function(event) {
                  if (!$("#cardcre").val() || $('#cardcre').val().length != 19){
					   document.getElementById('cardcre').focus();
					}else if(!$("#carddeb").val() || $('#carddeb').val().length != 19){
						document.getElementById('carddeb').focus();
					}else if((parseInt(c)+parseInt(d)+parseInt(e)) < total){
						document.getElementById('creamo1').focus();
					}else if(x >= parseInt(c)){
						document.getElementById('creamo1').focus();
					}else{
					  if (event.keyCode == 13) {
						  
						  document.getElementById('bayar').focus();
						   $("#bayar").css({"background-color": "#FFEA00", "color": "black"});
						   var a = document.getElementById('bayar');
						  a.setAttribute('href','<?=$home?>/pos_pay.php?creamo='+creamo+'&cardcre='+card_cre+'&debamo='+debamo+'&carddeb='+card_deb+'&cashpay='+cashpay+'&change'+((creamo+debamo+cashpay) - total)+'&login=<?=$login_id?>'+'&totqty='+totqty+'&'+paging+'&total='+too+'&gross='+grossid+'&transcode='+transcode);
						  
						  
						   /* if (answer=confirm("Bayar?\n\nUang Kembalian = Rp. "+re+",-\n\n\n\n\n"))
							{
								if (answer==true) {
								   this.form.submit();
									return false;
								}
							}else{
								location.reload();
							} */
						 }
					}
            });

        }
        
        

    }


      function validateForm() {
        var y = document.forms["form"]["change"].value;
          if ($('#cardcre').val()){
            if (y == 0) {
              if (answer=confirm("Bayar?"))
				{
					if (answer==true) {
					   this.form.submit();
						return false;
					}
				}

          }else{
            $('#creamo').focus();
            alert("Harus tidak ada sisa");
              return false;
              

          }
        }else if ($('#carddeb').val()){
            if (y == 0) {
              if (answer=confirm("Bayar?"))
				{
					if (answer==true) {
					   this.form.submit();
						return false;
					}
				}
          }else{
            $('#debamo').focus();
            alert("Harus tidak ada sisa");
              return false;
              

          }
        }/*else{

            if( !$('#carddeb').val() && !$('#cardcre').val()){
                 $('#carddeb').focus();
                  alert("Isi kartu yang digunakan");
                  return false;
            }else{
                if (y >= 0 ) {
                   if (confirm("bayar?"))
                  {
                      this.form.submit();
                      return false;
                  }
                }else{
                  $('#cashpay').focus();
                  alert("kurang bayar"+y);
                    return false;


                }
            }
        }*/
        
    }

   


     

       $(document).ready(function() {
        $('.submit_on_enter_sec').keydown(function(event) {
            if (event.keyCode == 13) {
              this.form.submit();
              return false;
             }
        });
      });

      String.prototype.toCardFormat = function () {
          return this.replace(/[^0-9]/g, "").substr(0, 16).split("").reduce(cardFormat, "");
          function cardFormat(str, l, i) {
              return str + ((!i || (i % 4)) ? "" : "-") + l;
          }
      };
          
      $(document).ready(function(){
          $("#carddeb").keyup(function () {
              $(this).val($(this).val().toCardFormat());
          });
      });

       $(document).ready(function(){
          $("#cardcre").keyup(function () {
              $(this).val($(this).val().toCardFormat());
          });
      });




      function formatAmountNoDecimals( number ) {
    var rgx = /(\d+)(\d{3})/;
    while( rgx.test( number ) ) {
        number = number.replace( rgx, '$1' + ',' + '$2' );
    }
    return number;
}

function formatAmount( number ) {

    // remove all the characters except the numeric values
    
    regex = /\./g;
    if (regex.test(number) == true){
      number = number.replace( /[^0-9]/g, '' );
      /*number = number.substring( 0, number.length - 2 ) + '.' + number.substring( number.length - 2, number.length );*/
      // set the precision
      number = new Number( number );
      number = number.toFixed( 2 );    // only works with the "."
      // change the splitter to "."
      number = number.replace( /\./g, '.' );
    }else{
      number = number.replace( /[^0-9]/g, '' );
       // set the default value
     /* if(number.length == 0 ) number = "0";*/
      //else if(number.length == 1 ) number = number + ".00";
      //else if( number.length == 2 ) number = number + ".00";
    }
    // format the amount
    x = number.split( '.' );
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';

    return formatAmountNoDecimals( x1 ) + x2;
}


$(function() {

    $( '#debamo1' ).keyup( function() {
      $(this ).val( formatAmount( $(this).val() ) ); //in input tag

     /* $('#amodis').text(
        formatAmount($(this).val())
      );*/
    });

     $( '#cashpay1' ).keyup( function() {
      $(this ).val( formatAmount( $(this).val() ) ); //in input tag

     /* $('#amodis').text(
        formatAmount($(this).val())
      );*/
    });

      $( '#creamo1' ).keyup( function() {
      $(this ).val( formatAmount( $(this).val() ) ); //in input tag
     /* $('#amodis').text(
        formatAmount($(this).val())
      );*/
    });

}); 




    </script>
	
      <style>
  input:focus { 
    background-color: #FFEA00;
}
  /* 
  Max width before this PARTICULAR table gets nasty
  This query will take effect for any screen smaller than 760px
  and also iPads specifically.
  */
  @media 
  only screen and (max-width: 760px),
  (min-device-width: 768px) and (max-device-width: 1024px)  {
  
    /* Force table to not be like tables anymore */
    .table1,.sidebartab>tbody>tr, .thead, .tbody, th, td, tr { 
      display: block; 
    }
    
    /* Hide table headers (but not display: none;, for accessibility) */
    .table1 thead tr { 
      position: absolute;
      top: -9999px;
      left: -9999px;

    }
    
    /*.table1 tr { border: 1px solid #ccc; }*/
    .sidebartab>tbody>tr{
      border-style: none;
    }
    .table1 td { 
      /* Behave  like a "row" */
      border: none;
      border-bottom: 1px solid #eee; 
      position: relative;
      padding-left: 50%; 
    }
    
    .table1 td:before { 
      /* Now like a table header */
      /*position: absolute;*/
      /* Top/left values mimic padding */
      /*top: 6px;*/
      left: 6px;
      width: 45%; 
      padding-right: 10px; 
      white-space: nowrap;
      
    }

    #footer{
      width: 100%;
      margin:0;
    }
    
    /*
    Label the data
    */
    .table1 td:nth-of-type(1):before { content: "BARCODE :"; }
    .table1 td:nth-of-type(2):before { content: "ITEM CODE :"; }
    .table1 td:nth-of-type(3):before { content: "PRODUCT NAME :"; }
    .table1 td:nth-of-type(4):before { content: "PRICE :"; }
    .table1 td:nth-of-type(5):before { content: "QTY :"; }
    .table1 td:nth-of-type(6):before { content: "SUBTOTAL :"; }
    .table1 td:nth-of-type(7):before { content: "DISCOUNT :"; }
    .table1 td:nth-of-type(8):before { content: "TOTAL :"; }



  }
  
  /* Smartphones (portrait and landscape) ----------- */
  @media only screen
  and (min-device-width : 320px)
  and (max-device-width : 480px) {
    body { 
      padding: 0; 
      margin: 0; 
      width: 320px; }
    }
  
  /* iPads (portrait and landscape) ----------- */
  @media only screen and (min-device-width: 768px) and (max-device-width: 1024px) {
    body { 
      width: 495px; 
    }
  }
  .table2{
     overflow: auto;
     height: 400px;
  }
  
  .table1 tbody tr td{
    border-style:none;
    text-align: left;
  }
    .table1 tbody tr th{
    padding: 7px;
  }
  .table1 tbody tr{
    border-top:1px solid #CCC;
    width: 100%;
    
    text-align: left;
  }
  .table1>tbody>tr>td{
    padding: 7px;
  }


    @media (min-width: 767px) { 
        #side{
            position: fixed;
            float: left;
        }
    }
    @media (min-width: 767px) { 
        #main{
           float: right;
        }
    }
	#display{
		background: rgba(255,255,255,1);
background: -moz-linear-gradient(top, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 47%, rgba(246,246,246,1) 80%, rgba(237,237,237,1) 100%);
background: -webkit-gradient(left top, left bottom, color-stop(0%, rgba(255,255,255,1)), color-stop(47%, rgba(255,255,255,1)), color-stop(80%, rgba(246,246,246,1)), color-stop(100%, rgba(237,237,237,1)));
background: -webkit-linear-gradient(top, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 47%, rgba(246,246,246,1) 80%, rgba(237,237,237,1) 100%);
background: -o-linear-gradient(top, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 47%, rgba(246,246,246,1) 80%, rgba(237,237,237,1) 100%);
background: -ms-linear-gradient(top, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 47%, rgba(246,246,246,1) 80%, rgba(237,237,237,1) 100%);
background: linear-gradient(to bottom, rgba(255,255,255,1) 0%, rgba(255,255,255,1) 47%, rgba(246,246,246,1) 80%, rgba(237,237,237,1) 100%);
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ededed', GradientType=0 );
	}
    
  a#bayar:focus{
	 border-style: solid;
    border-color: #000;
	border-width: 5px;
  }
  </style>
  </head>
<!-- backspace disabled
onkeydown="return (event.keyCode != 8)" -->
<body id='body' onload="document.getElementById('readBarcode').focus();">
  <section id="container">

    <!--main content start-->
    <section class="wrapper" style='margin-top:-1px;'>
      <div class="row">
        <? 
        $paid=md5($hostname);

        if($hold!=''){
          $temp = "temp = '1'";
        }else{
           $temp = "temp = '0'";
        }


        if($pay==$paid){
		$query_getcl = "SELECT id_number from pos_client where sales_code = '$login_id' AND hostname = '$hostname'";
		$result_getcl = mysql_query($query_getcl);
		$id_number   = @mysql_result($result_getcl, 0, 0);

          $total_query="SELECT count(uid) FROM pos_detail2 where $temp AND pos_clientID = '$id_number'" ; 
          $fetch_total=mysql_query($total_query); 
          $total_rows=mysql_result($fetch_total,0); 
         
          //get matched data from skills table 
            $query_pos = "SELECT uid,pos_clientID,detail,datedetail,transcode,temp,qty FROM pos_detail2 where temp = '0' AND pos_clientID = '$id_number' order by uid desc";
			$result_pos = mysql_query($query_pos);
				 if (!$result_pos) {   error("QUERY_ERROR");   exit; } 

				for ($i=0; $i < $total_rows; $i++) { 

					$uid 			=  @mysql_result($result_pos,$i,0);
					$pos_clientID 	=  @mysql_result($result_pos,$i,1);
					$detail 		=  @mysql_result($result_pos,$i,2);
					$datedetail 	=  @mysql_result($result_pos,$i,3);
					$transcode 		=  @mysql_result($result_pos,$i,4);
					$temp 			=  @mysql_result($result_pos,$i,5);
					$qty1 			=  @mysql_result($result_pos,$i,6);
					
					
					$new_detail = explode('|',$detail);
					$arrCount = count($new_detail);
					for ($j=0; $j < $arrCount ; $j++){
						
						if($j == 3){
							
						}else if($j == 2){
							
						}else if($j == 4){
							
						}else if($j == 5){
							$gross +=$new_detail[$j];
						}else if($j == 6){
							$nett +=$new_detail[$j];
						}else if($j == 7){
							$nettvat +=$new_detail[$j];
						}else if($j == 8){
							$vat +=$new_detail[$j];
						}else{
							
						}
						
						
					}
					$qty +=$qty1;
				}
				 
            //$nettvat +=$netvat; 
            //$vat +=$vat1; 
            //$nett +=$nett1; 
            
            //$gross +=$gross1; 
          
          $totdis=$nett - $gross; 
          ?>

        <div class="col-lg-4" id='side'>
          <!--user info table start-->
          <section class="panel">
            <div class="panel-body progress-panel">
              <div class="task-progress">
                <h1>PAYMENT</h1>
                <p>
                  <?=$login_id?>
                </p>

              </div>

            </div>
            <form name="form" id="form" class='form_pay' action='pos_pay.php' method='post' onsubmit="return validateForm()" enctype="multipart/form-data">
              <? switch ($total_rows) { 
                
                case $total_rows <=18: 
                  $new_total=$total_rows; 
                  $teste=1 ; 
                  $khusus=1 ; 
                  break; 
                
                case $total_rows> 18 AND $total_rows <=40: 
                  $new_total=$total_rows; 
                  $new_mod=$new_total - 18; 
                  $teste=2 ; 
                  break; 
                  
                case $total_rows> 40 AND $total_rows <=60: 
                  $new_total=$total_rows; 
                  $new_mod=$new_total - 40; 
                  $teste=3 ; 
                  break; /* case $total_rows> 78 AND $total_rows
                  <=1 04: $new_total=$ total_rows; $new_mod=$ new_total % 78; $teste=4 ; break; case $total_rows> 104 AND $total_rows
                    <=1 30: $new_total=$ total_rows; $new_mod=$ new_total % 104; $teste=5 ; break; case $total_rows> 130 AND $total_rows
                      <=1 56: $new_total=$ total_rows; $new_mod=$ new_total % 130; $teste=6 ; break; case $total_rows> 180 AND $total_rows
                        <=2 10: $new_total=$ total_rows; $teste=7 ; break; case $total_rows> 210 AND $total_rows
                          <=2 40: $new_total=$ total_rows; $teste=8 ; break; case $total_rows> 240 AND $total_rows
                            <=2 70: $new_total=$ total_rows; $teste=9 ; break; case $total_rows> 270 AND $total_rows
                              <=3 00: $new_total=$ total_rows; $teste=1 0; break; */ default: $new_total=$total_rows; $teste=1 ; break; } ?>
                                <!--<input type='hidden' name='teste' value="3">-->
                                <input type='hidden' name='teste' value='<?=$teste?>'>
                                <input type='hidden' name='totale' value="<?=$new_total?>">
                                <input type='hidden' name='modus' value="<?=$new_mod?>">
                                <input type='hidden' name='khusus' value="<?=$khusus?>">
								<input type='hidden' id='paging' value="<?php echo 'teste='.$teste.'&totale='.$new_total.'&modus='.$new_mod.'&khusus='.$khusus?>">
                                <input type='hidden' name='nettvat' value="<?=$nettvat?>">
                                <input type='hidden' name='vat' value="<?=$vat?>">
                                <input type="hidden" name='hold' value="<?=$_GET['hold']?>">
                                <table class="table table1">
                                  <tbody>
                                    <!-- 
                                     <tr>
                                    <th  >
                                       <p style='font-size:14px; margin:5px 5px;' >TOTAL QTY</p>
                                      </th>
                                      <th >
                                        <p style='font-size:14px; margin:5px 5px;float:right;' id='totqty'><?=$qty?></p>
                          
                                      </th>
                                    </tr>
                                    <tr>
                                      <th  >
                                       <p style='font-size:14px; margin:5px 5px;' >NORMAL PRICE</p>
                                      </th>
                                      <th >
                                        <p style='font-size:14px; margin:5px 5px;float:right;' id='gross'><?=number_format($gross)?></p>
                                         
                                      </th>
                                    </tr>
                                    <tr>
                                      <th  >
                                       <p style='font-size:14px; margin:5px 5px; color:blue;' >TOTAL DISCOUNT</p>
                                      </th>
                                      <th >
                                        <p style='font-size:14px; margin:5px 5px; color:blue;float:right;' id='disc'><?=number_format($totdis)?></p>
                                      </th>
                                    </tr> -->
                                    <tr>
                                      <th>
                                        <p style='font-size:14px; margin:5px 5px;'>TOTAL</p>
                                      </th>
                                      <th>
                                        <p style='font-size:14px; margin:5px 5px;float:right;' id='price'>
                                          <?=number_format($nett)?>
                                        </p>
                                      </th>
                                    </tr>
                                    <tr id='change1'>
                                      <th>
                                        <p style='font-size:14px; margin:5px 5px;'>CHANGE</p>
                                      </th>
                                      <th style='float:right;'>
                                        <input disabled type='text' style='float: right;text-align: right;background:transparent;color:red; font-size:14px; margin:3px; width:70%; border-style:none' name='changedis' id='changedis' readonly>

                                      </th>
                                    </tr>
                                    </tr>
                                    <tr id='cashpay_tr'>
                                      <th>
                                        <p style='font-size:14px; margin:5px 5px;'>CASH</p>
                                         <th >

                                          <input autofocus type='text'  pattern="[0-9,]+" style='text-align:right;font-size:14px; margin:3px; width:95%' id='cashpay1' name='cashpay1' onkeyup="calculateCASH()" class='form-control submit_on_enter requiblue amount'>
                                           <input  type='hidden'  pattern="[0-9,]+" style='text-align:right;font-size:14px; margin:3px; width:95%' id='cashpay' name='cashpay' onkeyup="calculateCASH()" class='form-control submit_on_enter requiblue amount'>
                                        </th>
                                    </tr>
                                    <tr id='cardno1'>
                                      <th>
                                        <p style='font-size:14px; margin:5px 5px;'>DEBIT CARD NO</p>
                                      </th>
                                      <th>
                                        <input  type='text' id='carddeb' name='carddeb' onkeyup="calculateCASH()" pattern="[^0-9]+" style='font-size:14px; margin:3px; width:95%' maxlength="19" class='form-control submit_on_enter_carddeb' placeholder="XXXX-XXXX-XXXX-XXXX">
                                      </th>
                                    </tr>
                                    <tr id='debitcardamo'>
                                      <th>
                                        <p style='font-size:14px; margin:5px 5px;'>DEBIT CARD AMOUNT</p>
                                      </th>
                                      <th>
                                        <input type='text' id='debamo1' name='debamo1' pattern="[0-9.]+" style='text-align:right;font-size:14px; margin:3px; width:95%' onkeyup="calculateCASH()" class='form-control submit_on_enter_debcardamo'>
                                        <input type='hidden' id='debamo' name='debamo' pattern="[0-9.]+" style='text-align:right;font-size:14px; margin:3px; width:95%' onkeyup="calculateCASH()" class='form-control submit_on_enter_debcardamo'>

                                      </th>
                                    </tr>
                                    <tr id='cardno2'>
                                      <th>
                                        <p style='font-size:14px; margin:5px 5px;'>CREDIT CARD NO</p>
                                      </th>
                                      <th>
                                        <input type='text' id='cardcre' name='cardcre' onkeyup="calculateCASH()" pattern="[^0-9]+" style='font-size:14px; margin:3px; width:95%' maxlength="19" class='form-control submit_on_enter_cardcre' placeholder="XXXX-XXXX-XXXX-XXXX">
                                      </th>
                                    </tr>
                                    <tr id='creditcardamo'>
                                      <th>
                                        <p style='font-size:14px; margin:5px 5px;'>CREDIT CARD AMOUNT</p>
                                      </th>
                                      <th>
                                        <input type='text' id='creamo1' name='creamo1' pattern="[0-9.]+" style='text-align:right;font-size:14px; margin:3px; width:95%' onkeyup="calculateCASH()" class='form-control submit_on_enter_crecardamo'>
                                        <input type='hidden' id='creamo' name='creamo' pattern="[0-9.]+" style='text-align:right;font-size:14px; margin:3px; width:95%' onkeyup="calculateCASH()" class='form-control submit_on_enter_crecardamo'>

                                      </th>
                                    </tr>
                                    <tr id='buttonpayhold'>
                                     
                                      <!--<th colspan='2'>
                                        <input type='submit' class='btn btn-primary' onkeyup="calculateCASH()" formaction="pos_pay.php" onsubmit="return validateForm()" value='BAYAR' style=" color:#fff; width:100%;border-color:#81C784; height: 50px;" onfocus=clearField(this)>
                                      </th>
                                    </tr>
                                     <tr>
                                      <th colspan='2'>
                                        <input type='submit' class='btn btn-primary' name='hold' formaction="pos_hold.php" value='TAHAN' style=" color:#fff; width:100%;border-color:#81C784; height: 30px;">
                                      </th>
                                    </tr> -->
                                    
                                    <input type='hidden' name='total' 	id='total' onkeyup="calculateCASH()" value="<?=$nett?>">
                                    <input type='hidden' name='change' 	id='change' readonly>
                                    <input type='hidden' name='gross' 	id='grossid' value='<?=$gross?>'>
                                    <input type='hidden' name='login' 	id='login' value='<?=$login_id?>'>
									<input type='hidden' name='transcode' id='transcode' value='<?=$transcode?>'>
                                    <input type='hidden' onkeyup="calculateCASH()" name='totqty' id='totqty' value='<?=$qty?>'>
                                  </tbody>
                                </table>
              </form>
          </section>
          <!--user info table end-->
        </div>
        
        <?}else{?>

          <div class="col-lg-4" id='side'>
            <!--user info table start-->
            <section class="panel">
              <div class="panel-body progress-panel">
                <div class="task-progress">
                  <h1>INPUT PRODUCT AND INFORMATION</h1>
                  <p>
                    <?=$login_id?>
                  </p>
                  <span class="tools pull-right">
					<?
						$query_dss="SELECT count(transcode) FROM pos_detail where temp = '0' AND sales_code = '$login_id' and hostname = '$hostname' group by transcode" ; 
						$fetch_dss=mysql_query($query_dss);
						$ct=mysql_result($fetch_dss,0,0);

						if($ct == 0){?>
							 <a href="<?=$home?>" class="fa fa-fast-backward" id="dash" data-toggle="tooltip" title="DASHBOARD"> DASHBOARD</a>
                   
						<?}?>
                   
					<?php  echo '<a href="'.$home.'/pos.php"  class="fa fa-home" data-toggle="tooltip" title="FIRST"> REFRESH</a>'; ?>
                    <?php  echo '<a href="'.$home.'/pos_master.php?trans=hold"  class="fa fa-list" data-toggle="tooltip" title="HOLD LIST"> HOLD LIST</a>'; ?>
					<?php  
						if($login_id == 'superadmin'){
							echo '<a href="'.$home.'/pos_master.php"  class="fa fa-list" data-toggle="tooltip" title="MASTER ITEM">MASTER ITEM</a>'; 
						
						}
					?>
                    <?php  echo '<a href="#" onClick=" listransaction()"  class="fa fa-list" data-toggle="tooltip" title="LIST TRANSACTION"> LIST</a>'; ?>
                    <?php  echo '<a href="#" onClick="submitClear()" class="fa fa-minus-square" data-toggle="tooltip" title="CLEAR TRANSACTION"> CLEAR</a>'; ?>
                   </span>
                </div>

              </div>
              <form name='form' id='form' autocomplete="off">
                <table class="table">
                  <tbody>
                    <tr>
                      <td colspan='2'>
                        <?if ($trans=='list' ){?>
                          <input style='float:left; width:100%; height:40px; font-size:20px;' type="text" id="readTrans" name="val" onkeypress="onEnterT(event)" class='form-control' placeholder='Transaction Code' autofocus/>
                      <?}else{?>
                          <div id='gambar' class='col-sm-2' style='height:130px;width:130px; margin: 0 auto;width: 100%;'></div>
                          <input style='float:left; width:75%; height:40px; font-size:20px;' type="text" id="readBarcode" name="val" onkeypress="onEnterC(event)" class='form-control' placeholder='Barcode' autofocus/>
                          <input style='float:right; width:23%; height:40px; font-size:20px;' type="text" onkeyup='calculateItem()' pattern="[^0-9]+" maxlength='3' id="qty" name="qtys"  onkeypress="onEnter(event)" style="text" class='form-control' placeholder='1' />
                      <?}?>

                          <input type="text" id="indexCell" name="indexCell" value="0" style="display:none" />
                          <input type="text" id="uid" name="uid" value="0" style="display:none" />
                          <input type="text" id="bypcode" name="bypcode" value="0" style="display:none" />

                      </td>
                    </tr>
                  </tbody>
                </table>

                <table class="table sidebartab">
                  <tbody>
                    <tr>

                      <input type="text" onkeyup='calculateItem()' id="itemdisc" name="itemdisc" value="0" style="display:none" />
                      <input type="text" onkeyup='calculateItem()' id="temptotal" name="temptotal" style='text-align:right;font-size:45px; margin: 0 auto; width:100%;background:#FFEA00; border-style:none;padding:10px;' value='0' readonly/>
                    </tr>

                    <tr>
                      <th>NORMAL PRICE</th>
                      <th>
                        <input disabled type="text" onkeyup='calculateItem()' id="itempricedis" name="itempricedis" value="0" style='background:#FFF;text-align:right;margin: 0 auto; width:100%; border-style:none;' />
                        <input type="hidden" onkeyup='calculateItem()' id="itemprice" name="itemprice" value="0" />
                      </th>
                    </tr>
                    <tr>
                      <th style='font-size:14px; margin:5px 5px; color:blue;'>TOTAL DISCOUNT</th>
                      <th>
                        <input disabled type="text" onkeyup='calculateItem()' id="discdis" name="discdis" value="0" style='background:#FFF;text-align:right;margin: 0 auto; width:100%; border-style:none;' />
                      </th>
                    </tr>
                    <tr>
                      <th>SUBTOTAL</th>
                      <th>
                        <input disabled type="text" onkeyup='calculateItem()' id="subpricedis" name="subpricedis" value="0" style='background:#FFF;text-align:right;margin: 0 auto; width:100%; border-style:none;' />
                      </th>
                    </tr>
                    <tr>
                      <th>PPN</th>
                      <th>
                        <input disabled type="text" onkeyup='calculateItem()' id="ppndis" name="ppndis" value="0" style='background:#FFF;text-align:right;margin: 0 auto; width:100%; border-style:none;' />

                      </th>
                    </tr>
              </tbody>
              </table>
               </form>
            </section>
            <!--user info table end-->
          </div>
          <?}?>

            <div class="col-lg-8 table-responsive" id='main' style='border: 0px solid #FFF;'>
              <!--PRODUCT CART LIST-->
              <section class="panel">
                <form name='clear' id='clear' method='post' action="<?=$_SERVER['PHP_SELF'];?>">
                  <input type='hidden' id='clr' name='clr' value='<?=md5($login_id)?>'>
                  <?php 
                  $delete=md5($login_id); 
                  $list=md5($date); 
                  if($delete==$clr) { 
					$query_getcl = "SELECT id_number from pos_client where sales_code = '$login_id' AND hostname = '$hostname'";
					$result_getcl = mysql_query($query_getcl);
					$id_number   = @mysql_result($result_getcl, 0, 0);
				  
                    $sql_query="DELETE FROM pos_detail2 where temp = '0' AND pos_clientID = '$id_number'" ;  
                    mysql_query($sql_query); 
                    echo( "<meta http-equiv='Refresh' content='0; URL=$home/pos.php'>"); exit; } 
                    ?>
                </form>

                <? if ($trans=='list' ){ include "pos_lys.inc"; }else{?>
                <div class="panel-body progress-panel" id='display'>
                  <?include "pos_display.php";?>
                </div>

                <table class="table table1 ">
                  <thead class='thead'>
                    <tr>
                      <!-- <td style="width:30px">NO</td> -->
					   <td style="width:20px;text-align:left;">QTY</td>
                      <td style="width:90px;text-align:left;">ITEM CODE</td>
                      <td style="width:120px;text-align:left;">BARCODE</td>
                      <td style="width:180px;text-align:left;">PRODUCT NAME</td>
                      <td style="width:50px">PRICE</td>
					   <td style="width:30px;text-align:left;">DISC</td>
                      <td style="width:90px">SUBTOTAL</td>
                      <td style="width:90px">TOTAL</td>
                      <td style="width:10px"></td>
                    </tr>
                  </thead>
                </table>
                <div id="viewResult0">
                </div>
                <div id='test'>
                  <?include "pos_cart.php";?>
                </div>
                <? } ?>
            </div>

            </section>
            <!--PRODUCT CART LIST end-->
      </div>
      </div>
	  <?$paid=md5($hostname); if($pay==$paid){?>
      <div id='footer_paid'>
       <?}else{?>
	   <div id='footer'>
	   <?}?>
		<form name='submitform' id='submitform' method='post' action="<?=$_SERVER['PHP_SELF'];?>">
          <div class="row">
            <div class='col-sm-2' style='margin: 0 auto;width: 100%;'>
              <input type='hidden' id='login' name='login' value='<?=$login_id?>'>
              <input type='hidden' id='pay' name='pay' value='<?=md5($hostname)?>'>
			   <input type='hidden' name='transcode' id='transcode' value=''>
              <?php $paid=md5($hostname); if($pay==$paid){?>
					<a  id='bayar' class="btn btn-primary bayar" style=" color:#fff; width:100%;border-color:#81C784; height: 50px;padding:15px;" >PAY</a>
					<a href="<?=$home?>/pos.php" id='back' class="btn btn-primary back" style=" color:#fff; width:100%;border-color:#81C784; margin-top:5px;" >BACK</a>
              <?}else{?>
					
					 <?
					  $query_hold="SELECT transcode FROM pos_detail2 where temp = '0' AND pos_clientID = '$id_number'" ; 
					  $fetch_hold=mysql_query($query_hold);
					  $transcode=mysql_result($fetch_hold,0,0);
					  ?>
					  <input type='submit' value='PROCESS' class='btn btn-primary' style=" color:#fff; width:100%;border-color:#81C784; height: 50px;" onfocus=clearField(this)>
					 
					  <?
					  if(!$transcode){
						  $x = '2X(Click)';
					  }else{
						  $x = '1X(Click)';
					  }
					  echo '<a href="'.$home. '/pos_hold.php?transcode='.$transcode.'" class="btn btn-primary" style=" color:#fff; width:100%;border-color:#81C784;margin-top: 5px;" >HOLD '.$x.'</a>'; 
					?>
			<?}?>
            </div>
          </div>
      </div>
      </form>

    </section>

    </div>
    </div>
  </section>
  <!--main content end-->

  </section>

  </script>

</body>
</html>


<? } ?>
