<?
/*
@author : YOGI ANDITIA;
@version : 1.2 BETA_TEST;

*/

include "config/common.inc";
include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
require "config/user_functions_{$lang}.inc";

$mmenu = "main";
$smenu = "dashboard";

if(!$login_id OR $login_level < "1") {

  echo ("<meta http-equiv='Refresh' content='0; URL=user_login.php'>");

} else {
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$date = date('Ymd');


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



function onEnterC(e){
  var key=e.keyCode || e.which;
  if(key==13){
    document.getElementById('qty').focus();
    showCell();
    showTotal();
    getClear();
  $("#test").load("<?=$home?>/price_preview.php");
   $('#form')[0].reset();
   $("#gambar").html('<img id="image" style="width: 100px;height: 100px;margin: auto;top: 0; bottom: 0;left: 0;right: 0;position: absolute;" src="img_pos/feelbuy.jpg"/>');
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
                    ppn += this['ppn'] +"<br/>";
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

  rObj=document.getElementById("bypcode");
  valItem=rObj.value.trim();

    if(valBarcode == '+' || valQty == '+'){
      $("#submitform").submit();
    }else if(valBarcode == 'c' || valQty == 'c'){
      submitClear();
    }else if(valBarcode == 'm' || valQty == 'm'){
      window.location = "../pos_master.php"
    }else if(valBarcode == 'l' || valQty == 'l'){
      listransaction();
    }else{
    rObj.value="";rObj.focus(); iObj.value=newIndex;
    doRequested('viewResult'+index,'price_insert.php?val='+valBarcode+'&index='+newIndex+'&qtys='+valQty+'&uid='+valUid+'&item='+valItem,false);
  }
}
function submitClear(){
   $("#clear").submit();
}
function listransaction(){
  window.location = "../pos_master.php?trans=list"
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
                 url: "pos_security_row.php"+data,
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

    function calculateCASH() {
        var totStr =document.form.total.value;
        if (!totStr)
            totStr = '0';
        var cpStr = document.form.cashpay.value;
        if (!cpStr)
            cpStr = '0';
        var debamoStr = document.form.debamo.value;
        if (!debamoStr)
            debamoStr = '0';
        var creamoStr = document.form.creamo.value;
        if (!creamoStr)
            creamoStr = '0';
       var creStr = document.form.cardcre.value;
        if (!creStr)
            creStr = '0';
        var debStr = document.form.carddeb.value;
        if (!debStr)
            debStr = '0';


        var total = parseFloat(totStr);
        var cashpay = parseInt(cpStr.replace(/[^\d.]/g, ''));
        var debamo = parseInt(debamoStr.replace(/[^\d.]/g, ''));
        var creamo = parseInt(creamoStr.replace(/[^\d.]/g, ''));

          if($("#cashpay").val()){
              $(document).ready(function() {
                        document.form.change.value = cashpay - total;
                        document.form.changedis.value = (cashpay - total).toLocaleString('en');
                        if((cashpay-total) >= 0 ){
                          document.form.creamo.value = 0;
                          document.form.debamo.value = 0;
                          $("#debamo").prop('disabled',true);
                          $("#carddeb").prop('disabled',true);
                          $("#creamo").prop('disabled',true);
                          $("#cardcre").prop('disabled',true);
                          $('.submit_on_enter').keydown(function(event) {
                              if (event.keyCode == 13) {
                                validateForm();
                               }
                          });
                          }else{
                              $('.submit_on_enter').keydown(function(event) {
                                if (event.keyCode == 13) {
                                  document.getElementById('carddeb').focus();
                                }
                              });
                          }
              });
          }else{
            $('.submit_on_enter').keydown(function(event) {
              if (event.keyCode == 13) {
                document.getElementById('carddeb').focus();
              }
            });
          }
            

          if($("#carddeb").val()){
              $(document).ready(function() {
                      $('.submit_on_enter_carddeb').keydown(function(event) {
                          if (event.keyCode == 13) {
                            document.getElementById('debamo').focus();
                           }
                      });
              });
          }else{
            $(document).ready(function() {
                      $('.submit_on_enter_carddeb').keydown(function(event) {
                          if (event.keyCode == 13) {
                            document.getElementById('cardcre').focus();
                           }
                      });
              });
          }

          if($("#debamo").val()){
              document.form.change.value = debamo - total;
              document.form.changedis.value = (debamo - total).toLocaleString('en');
              if((debamo-total) == 0){
                document.form.cashpay.value = 0;
                document.form.creamo.value = 0;
                $("#cashpay").prop('disabled',true);
                $("#creamo").prop('disabled',true);
                $("#cardcre").prop('disabled',true);
                $('.submit_on_enter_debcardamo').keydown(function(event) {
                      if (event.keyCode == 13) {
                         $("#debitcardamo").css("background-color", "#FFF") ;
                        validateForm();

                       }
                  });
                }else{
                  $('.submit_on_enter_debcardamo').keydown(function(event) {
                    if (event.keyCode == 13) {
                      document.getElementById('cardcre').focus();
                    }
                  });
                }
          }else{
            $(document).ready(function() {
                      $('.submit_on_enter_debcardamo').keydown(function(event) {
                          if (event.keyCode == 13) {
                            document.getElementById('cardcre').focus();
                           }
                      });
              });
          }



              $(document).ready(function() {
                $('.submit_on_enter_cardcre').keydown(function(event) {
                    if (event.keyCode == 13) {
                      document.getElementById('creamo').focus();
                     }
                });
              });

              $(document).ready(function() {
                $('.submit_on_enter_crecardamo').keydown(function(event) {
                    if (event.keyCode == 13) {
                      document.getElementById('cashpay').focus();
                     }
                });
              });



        
    

        /*if(creamo == '0' && debamo == '0' && cashpay !='0' ){
        //CASH
            document.form.change.value = cashpay - total;
            document.form.changedis.value = (cashpay - total).toLocaleString('en');
            if((cashpay-total) >= 0 ){
              document.form.creamo.value = 0;
              document.form.debamo.value = 0;
              $("#debamo").prop('disabled',true);
              $("#carddeb").prop('disabled',true);
              $("#creamo").prop('disabled',true);
              $("#cardcre").prop('disabled',true);
              $('.submit_on_enter').keydown(function(event) {
                  if (event.keyCode == 13) {
                    validateForm();
                   }
              });
            }else{
              $('.submit_on_enter').keydown(function(event) {
                  if (event.keyCode == 13) {
                      document.getElementById('carddeb').focus();
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
              $("#cashpay").prop('disabled',true);
              $("#debamo").prop('disabled',true);
              $("#carddeb").prop('disabled',true);
              $('.submit_on_enter_crecardamo').keydown(function(event) {
                  if (event.keyCode == 13) {
                     $("#creditcardamo").css("background-color", "#FFF") ;
                    validateForm();

                   }
              });
            }else{
              $('.submit_on_enter_crecardamo').keydown(function(event) {
                  if (event.keyCode == 13) {
                      $('#creamo').focus();
                      $("#creditcardamo").css("background-color", "red").delay(2000).queue(function(next){ 
                      $("#creditcardamo").css("background-color", "#FFF") 
                          next()
                      });
                      
                      
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
              $("#cashpay").prop('disabled',true);
              $("#creamo").prop('disabled',true);
              $("#cardcre").prop('disabled',true);
              $('.submit_on_enter_debcardamo').keydown(function(event) {
                    if (event.keyCode == 13) {
                       $("#debitcardamo").css("background-color", "#FFF") ;
                      validateForm();

                     }
                });
              }else{
                
                $('.submit_on_enter_debcardamo').keydown(function(event) {
                    if (event.keyCode == 13) {
                                $('#debamo').focus();
                                $("#debitcardamo").css("background-color", "red").delay(2000).queue(function(next){ 
                                $("#debitcardamo").css("background-color", "#FFF") 
                                    next()
                                });
                     }
                });
              }
        }else if(creamo == '0' && debamo != '0' && cashpay !='0'){
          //DEBIT CARD AND CASH
            document.form.change.value = (debamo+cashpay) - total;
            document.form.changedis.value = ((debamo+cashpay) - total).toLocaleString('en');
            if(((debamo+cashpay)-total) >= 0){
              document.form.creamo.value = 0;
              $("#creamo").prop('disabled',true);
              $("#cardcre").prop('disabled',true);
              $('.submit_on_enter_debcardamo').keydown(function(event) {
                    if (event.keyCode == 13) {
                       $("#debitcardamo").css("background-color", "#FFF") ;
                      validateForm();

                     }
                });
              }else{
                $('.submit_on_enter_debcardamo').keydown(function(event) {
                    if (event.keyCode == 13) {
                        $('#debamo').focus();
                        $("#debitcardamo").css("background-color", "red").delay(2000).queue(function(next){ 
                        $("#debitcardamo").css("background-color", "#FFF") 
                            next()
                        });
                        
                        
                     }
                });
              }
        }else if(creamo != '0' && debamo == '0' && cashpay !='0'){
          //CREDIT CARD AND CASH
            document.form.change.value = (creamo+cashpay) - total;
            document.form.changedis.value = ((creamo+cashpay) - total).toLocaleString('en');
            if(((creamo+cashpay)-total) >= 0){
              document.form.debamo.value = 0;
              $("#debamo").prop('disabled',true);
              $("#carddeb").prop('disabled',true);
              $('.submit_on_enter_crecardamo').keydown(function(event) {
                  if (event.keyCode == 13) {
                     $("#creditcardamo").css("background-color", "#FFF") ;
                    validateForm();

                   }
              });
            }else{
              $('.submit_on_enter_crecardamo').keydown(function(event) {
                  if (event.keyCode == 13) {
                      $('#creamo').focus();
                      $("#creditcardamo").css("background-color", "red").delay(2000).queue(function(next){ 
                      $("#creditcardamo").css("background-color", "#FFF") 
                          next()
                      });
                      
                      
                   }
              });
            }
        }else if(creamo != '0' && debamo != '0' && cashpay =='0'){
          //DEBIT CARD AND CREDIT CARD
            document.form.change.value = (creamo+debamo) - total;
            document.form.changedis.value = ((creamo+debamo) - total).toLocaleString('en');
            if(((creamo+debamo)-total) == 0){
              document.form.cashpay.value = 0;
              $("#cashpay").prop('disabled',true);
            }
        }else{
          //TRIPLE PAY
            document.form.change.value = (creamo+debamo+cashpay) - total;
            document.form.changedis.value = ((creamo+debamo+cashpay) - total).toLocaleString('en');
        }
        */
        

    }


      function validateForm() {
        var y = document.forms["form"]["change"].value;
          if ($('#cardcre').val()){
            if (y == 0) {
              if (confirm("bayar?"))
              {
                  this.form.submit();
                  return false;
              }

          }else{
            $('#amo').focus();
            alert("Harus tidak ada sisa");
              return false;
              

          }
        }else if ($('#carddeb').val()){
            if (y == 0) {
              if (confirm("bayar?"))
              {
                  this.form.submit();
                  return false;
              }
          }/*else{
            $('#amo').focus();
            alert("Harus tidak ada sisa");
              return false;
              

          }*/
        }else{

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
        }
        
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

    $( '#debamo' ).keyup( function() {
      $(this ).val( formatAmount( $(this).val() ) ); //in input tag

     /* $('#amodis').text(
        formatAmount($(this).val())
      );*/
    });

     $( '#cashpay' ).keyup( function() {
      $(this ).val( formatAmount( $(this).val() ) ); //in input tag

     /* $('#amodis').text(
        formatAmount($(this).val())
      );*/
    });

      $( '#creamo' ).keyup( function() {
      $(this ).val( formatAmount( $(this).val() ) ); //in input tag
     /* $('#amodis').text(
        formatAmount($(this).val())
      );*/
    });

}); 




    </script>

      <style>
  
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

    
  
  </style>
  </head>
<!-- backspace disabled
onkeydown="return (event.keyCode != 8)" -->
<body id='body' onload="document.getElementById('readBarcode').focus();">
  <section id="container">

    <!--main content start-->
    <section class="wrapper" style='margin-top:-1px;'>
      <div class="row">


          <div class="col-lg-4" id='side'>
            <!--user info table start-->
            <section class="panel">
              <div class="panel-body progress-panel">
                <div class="task-progress">
                  <h1>INPUT PRODUCT</h1>
                  <p>
                    <?=$login_id?>
                  </p>
                 
                </div>

              </div>
              <form name='form' id='form' autocomplete="off">
                <table class="table">
                  <tbody>
                    <tr>
                      <td colspan='2'>
                      
                          <div id='gambar' class='col-sm-2' style='height:250px;width:250px; margin: 0 auto;width: 100%;'></div>
                          <input style='float:left; width:100%; height:40px; font-size:20px;' type="text" id="readBarcode" name="val" onkeypress="onEnterC(event)" class='form-control' placeholder='Barcode' autofocus/>
                          <input style='float:right; width:23%; height:40px; font-size:20px;' type="hidden" onkeyup='calculateItem()' id="qty" name="qtys" onkeypress="onEnter(event)" style="text" class='form-control' placeholder='1' />
                     
                          <input type="text" id="indexCell" name="indexCell" value="0" style="display:none" />
                          <input type="text" id="uid" name="uid" value="0" style="display:none" />
                          <input type="text" id="bypcode" name="bypcode" value="0" style="display:none" />

                      </td>
					  <tr>
					  </tr>
					  <td colspan='2'>
						  <input type="text" id='va' placeholder="Type here" style='float:left; width:100%; height:40px; font-size:20px;' class="form-control" />
					  </td>
                    </tr>
                  </tbody>
                </table>

               </form>
			   
			<div class="row">
            <div class="col-lg-8 table-responsive" style='margin: 0 auto;width: 100%;'>
          

			<script>
					
					$(document).ready(function(){
						$("a#link").click(function(){

							var va = document.getElementById('va').value;						
							var ext = "<? echo $home; ?>";
							var ext2 = "<? echo $login_id; ?>";
							var new_url = ext+'/price_print.php?user='+ext2+'&va='+va;
							$('#link').attr('href',new_url);//changed this line
					
					
						});
					});
			

			</script>
				
				<a id='link'  href="<?=$link?>" class='btn btn-primary' style=" color:#fff; width:100%;border-color:#81C784; height: 55px; font-size:30px;">PRINT</a>
               
            </div>
          </div>
            </section>
            <!--user info table end-->
			
          </div>
 
            <div class="col-lg-8 table-responsive" id='main' style='border: 0px solid #FFF;'>
              <!--PRODUCT CART LIST-->
              <section class="panel">
                <form name='clear' id='clear' method='post' action="<?=$_SERVER['PHP_SELF'];?>">
                  <input type='hidden' id='clr' name='clr' value='<?=md5($login_id)?>'>
                  <?php 
                  $delete=md5($login_id); 
                  $list=md5($date); 
                  if($delete==$clr) { 
                    $sql_query="DELETE FROM boomsale WHERE temp = '0' AND hostname='$hostname' AND sales_code='$login_id'" ; 
                    mysql_query($sql_query); 
                    echo( "<meta http-equiv='Refresh' content='0; URL=$home/price.php'>"); exit; } 
                    ?>
                </form>

              
                <div class="panel-body progress-panel">
                
                  <div class="task-progress">
                    <h1>PRINT LIST</h1>
                    <p>
                      <?=$login_id?>
                    </p>
                  </div>

                </div>
					 
                <table class="table table1 ">
                  <thead class='thead'>
                    <tr>
                    
                      <td style="width:90px">FOTO</td>
					 
                      <td style="width:120px">HARGA NORMAL</td>
					   <td style="width:120px">DISCOUNT</td>
                      <td style="width:290px">HARGA DISKON</td>
                      
                    </tr>
                  </thead>
                </table>
                <div id="viewResult0">
                </div>
                <div id='test'>
                  <?include "price_preview.php";?>
                </div>
               
            </div>

            </section>
            
      </div>
      </div>
      <div id='footer'>
       
          
      </div>
    
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
