<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
    echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "user";
$smenu = "user_login";
$step_next = false;
//======== get step next value if php 5.3 > ============
if(isset($_POST['step_next'])){
 $step_next = $_POST['step_next'];
 //echo $step_next;
} // new code for step_next post
//=========================================

if(!$page) { $page = 1; }
$num_per_page = 8; // number of article lines per page
$page_per_block = 10; // number of pages displayed in the bottom
if(!$step_next) {?>

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


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">

    </style>
    <link rel="stylesheet" href="css/jquery-ui-pos.css">
    <script src="js/jquery-1.10.2-pos.js"></script>
    <script src="js/jquery-ui-pos.js"></script>
    <script language="javascript" src="utilities.js"></script> 

    <script type="text/javascript">
        function onEnter(e){
          var key=e.keyCode || e.which;
          if(key==13){
            submit_item();
          }
        }

        function submit_item(){
            rObj=document.getElementById("read");
            valItem=rObj.value.trim();

            rObj=document.getElementById("barcode");
            valBarcode=rObj.value.trim();

            rObj=document.getElementById("uid");
            valUid=rObj.value.trim();

            var values = 'item='+valItem+'&code='+valBarcode+'&id='+valUid;
            var ajaxRequest= $.post( "whm_insert.php",values, function(data) {
               
              })
                .fail(function() {
                  alert( values );

                })
                .always(function() {
                  location.reload();
              });
        


        }

        $(document).ready(function(){
            $('#floor').on('change',function(){
                var floorID = $(this).val();
                if(floorID){
                    $.ajax({
                        type:'POST',
                        url:'floorData.php',
                        data:'floor='+floorID,
                        success:function(html){
                            $('#rack').html(html);
                        }
                    }); 
                }else{
                    $('#rack').html('<option value="">Select floor first</option>');
                }
            });

             $('#rack').on('change',function(){
                    var rackID = $(this).val();
                    if(rackID){
                        $.ajax({
                            type:'POST',
                            url:'floorData.php',
                            data:'rack='+rackID,
                            success:function(html){
                                $('#position').html(html);
                            }
                        }); 
                    }else{
                        $('#position').html('<option value="">Select Rack first</option>'); 
                    }
                });
            
        });
        </script>
        <script type="text/javascript">
                $(function() {
                    function split( val ) {
                        return val.split( /,\s*/ );
                    }
                    function extractLast( term ) {
                        return split( term ).pop();
                    }

                $( "#read" ).bind( "keydown", function( event ) {
                        if ( event.keyCode === $.ui.keyCode.TAB && $( this ).autocomplete( "instance" ).menu.active ) 
                        {
                            event.preventDefault();
                        }else if (event.keyCode == 8) {
                            $( "#barcode" ).val('');
                            $( "#uid" ).val('');
                           
                            // Call event.preventDefault() to stop the character before the cursor
                            // from being deleted. Remove this line if you don't want to do that.
                           
                        }
                    })
                    .autocomplete({
                        minLength: 1,
                        source: function( request, response ) {
                            // delegate back to autocomplete, but extract the last term
                            $.getJSON("whm_getitem.php", { term : extractLast( request.term )},response);
                        },
                        focus: function( event, ui ) {
                              $( "#read" ).val( ui.item.lbl1 );
                              $( "#barcode" ).val( ui.item.value );
                              $( "#uid" ).val( ui.item.uid );
                                return false;
                        },
                        select: function( event, ui ) {
                          $( "#read" ).val( ui.item.lbl1 );
                          return false;
                        }
                    });
                });

               
        </script>
        <script type="text/javascript">

        </script>
  </head>

    <body>

        <section id="container" >
        <!--main content start
                
            <section id="main-content">-->
                <section class="wrapper"style="margin-top:1px;">
                    <div class="col-lg-12">
                      <!--work progress start-->
                      <section class="panel">
                          <div class="panel-body progress-panel">
                              <div class="task-progress">
                                  <h1>Barcode Input</h1>
                                  <p><?=$login_id?></p>
                              </div>
                              <div class="task-option">
                                  <select class="styled">
                                      <option>Anjelina Joli</option>
                                      <option>Tom Crouse</option>
                                      <option>Jhon Due</option>
                                  </select>
                              </div>
                          </div>
                          <table class="table table-hover personal-task">
                            <thead>
                            </thead>
                              <tbody>
                                  <tr>
                                  
                                    <td>
                                        <input type='text' id='read' name='read' class='form-control' placeholder='BARCODE/ITEMCODE' style='float:left; width:100%; height:40px; font-size:20px;' onkeypress="onEnter(event)" autofocus/>
                                        <input type='hidden' id='uid' name='uid' value=''>
                                        <input type='hidden' id='barcode' name='barcode' value=''>
                                    </td>
                                   
                                    <!-- <td>
                                        <input type='submit' class='btn btn-primary' value='SUBMIT'style='float:left; width:100%; height:40px; font-size:20px;'/>
                                    </td> -->
                                </tr>
                              </tbody>
                          </table>
                      </section>
                  </div>
                </section>


                <section class="wrapper"style="margin-top:-40px;">
                  <?
                    $query_stockcount = "SELECT count(uid) FROM wms_stock";
                    $fetch_stockcount=mysql_query($query_stockcount);
                    if (!$fetch_stockcount) { error("QUERY_ERROR"); exit; }
                    $stockcount=mysql_result($fetch_stockcount,0,0);

                    // Display Range of records ------------------------------- //
                  if(!$stockcount) {
                     $first = 1;
                     $last = 0;   
                  } else {
                     $first = $num_per_page*($page-1);
                     $last = $num_per_page*$page;

                     $IsNext = $stockcount - $last;
                     if($IsNext > 0) {
                      $last -= 1;
                     } else {
                      $last = $stockcount - 1;
                     }      
                  }

                  $total_page = ceil($stockcount/$num_per_page);

                    $query_stock = "SELECT uid,gudang_code,loc_code,prev_qty,stock_in,stock_out,balance,type_id,total_type,bulk,pack,CBM,other,code_pic,post_date,upd_date FROM wms_stock order by uid desc";
                    $fetch_stock =mysql_query($query_stock);
                    if (!$fetch_stock) { error("QUERY_ERROR"); exit; }
                  ?>
                    <div class="col-lg-12">
                      <!--work progress start-->
                      <section class="panel">
                          <div class="panel-body progress-panel">
                              <div class="task-progress">
                                  <h1>Stock List</h1>
                                  <p><?=$login_id?></p>
                              </div>
                              <div class="task-option">
                                  <select class="styled">
                                      <option>Anjelina Joli</option>
                                      <option>Tom Crouse</option>
                                      <option>Jhon Due</option>
                                  </select>
                              </div>
                          </div>
                          <table class="table table-hover personal-task">
                            <thead>
                              <tr>
                                  <th>No</th>
                                  <th>Warehouse</th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th>Post Date</th>
                              </tr>
                            </thead>
                              <tbody>
                                <?
                                  for($k = $first; $k <= $last; $k++) {
                                    $uid        = mysql_result($fetch_stock,$k,0);
                                    $gcode      = mysql_result($fetch_stock,$k,1);
                                    $loc_code   = mysql_result($fetch_stock,$k,2);
                                    $prev       = mysql_result($fetch_stock,$k,3);
                                    $in         = mysql_result($fetch_stock,$k,4);
                                    $out        = mysql_result($fetch_stock,$k,5);
                                    $bal        = mysql_result($fetch_stock,$k,6);
                                    $typeId     = mysql_result($fetch_stock,$k,7);
                                    $totype     = mysql_result($fetch_stock,$k,8);
                                    $bulk       = mysql_result($fetch_stock,$k,9);
                                    $pack       = mysql_result($fetch_stock,$k,10);
                                    $CBM        = mysql_result($fetch_stock,$k,11);
                                    $other      = mysql_result($fetch_stock,$k,12);
                                    $PIC        = mysql_result($fetch_stock,$k,13);
                                    $postdate   = mysql_result($fetch_stock,$k,14);
                                    $updatedate = mysql_result($fetch_stock,$k,15);

                                    $query_getloc = "SELECT catg_code FROM  wms_location_list WHERE loc_code = '$loc_code' ";
                                    $fetch_getloc = mysql_query($query_getloc);
                                    if (!$fetch_getloc) { error("QUERY_ERROR"); exit; }
                                    $getloc     = mysql_result($fetch_getloc,0,0);

                                    $query_getgname = "SELECT gudang_name FROM  code_gudang WHERE gudang_code = '$gcode' ";
                                    $fetch_getgname = mysql_query($query_getgname);
                                    if (!$fetch_getgname) { error("QUERY_ERROR"); exit; }
                                    $getgname     = mysql_result($fetch_getgname,0,0);
                                    

                                    echo ("
                                        <tr>
                                            <td>$uid</td>
                                            <td>$getgname</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>$postdate</td>
                                        </tr> 

                                    ");

                                  } 
                                ?>

                                  

                              </tbody>
                          </table>
                              <ul class="pagination pagination-sm pull-right">
                                <?
                                $total_block = ceil($total_page/$page_per_block);
                                $block = ceil($page/$page_per_block);

                                $first_page = ($block-1)*$page_per_block;
                                $last_page = $block*$page_per_block;
                                
                                if(!$page || $page == 1){
                                  
                                }else{
                                  echo("<li><a href=".$home."/wait_whm.php?page=1&search=$search&end=1>First</a>");
                                }
                                
                                if($total_block <= $block) {
                                  $last_page = $total_page;
                                }

                                if($block > 1) {
                                  $my_page = $first_page;
                                  echo("<li><a href=".$home."/wait_whm.php?page=$my_page&search=$search&end=$total_page>Prev $page_per_block</a></li>");
                                }


                                if ($page > 1) {
                                  $page_num = $page - 1;
                                  echo("<li><a href=".$home."/wait_whm.php?page=$page_num&search=$search&end=$total_page>&laquo;</a></li>");
                                } else {
                                  echo("<li><a href='#'>&laquo;</a></li>");
                                }

                                for($direct_page = $first_page+1; $direct_page <= $last_page; $direct_page++) {
                                if($page == $direct_page) {
                                  echo("<li class='active'><a href='#'>$direct_page</a></li>");
                                } else {
                                  echo("<li><a href=".$home."/wait_whm.php?page=$direct_page&search=$search&end=$total_page>$direct_page</a></li>");
                                }
                                }

                                if ($IsNext > 0) {
                                $page_num = $page + 1;   
                                  echo("<li><a href=".$home."/wait_whm.php?page=$page_num&search=$search&end=$total_page>&raquo;</a></li>");
                                } else { 
                                  echo("<li><a href='#'>&raquo;</a></li>");
                                }

                                if($block < $total_block) {
                                  $my_page = $last_page+1;
                                  echo("<li><a href=".$home."/wait_whm.php?page=$my_page&search=$search&end=$total_page>Next $page_per_block</a>");
                                }
                                
                                if($total_page == $page ){
                                 
                                }else{
                                  echo("<li><a href=".$home."/wait_whm.php?page=$total_page&search=$search&end=$total_page>Last</a>");
                                }
                                ?>
                                </ul>
                      </section>

                      <!--work progress end-->
                  </div>

                </section>


           
                <section class="wrapper" style="margin-top:-20px;">
                    <div class="col-lg-12">
                      <!--work progress start-->
                      <section class="panel">
                          <div class="panel-body progress-panel">
                              <div class="task-progress">
                                  <h1>Update</h1>
                                  <p><?=$login_id?></p>
                              </div>
                              <div class="task-option">
                                  <select class="styled">
                                      <option>Anjelina Joli</option>
                                      <option>Tom Crouse</option>
                                      <option>Jhon Due</option>
                                  </select>
                              </div>
                          </div>
                          <table class="table table-hover personal-task">
                            <thead>
                                <tr>
                                    
                                </tr>
                            </thead>
                              <tbody>
                                
                                <tr>
                                   
                                    <td>Item Code</td>
                                    <td><input type='text' class='form-control'></td>
                                    <td>Floor</td>
                                    <td>
                                        <select name='floor' id='floor' class='form-control'>
                                        <option selected>:: <?=$txt_comm_frm19?> ::</option>
                                        <?
                                            $query_floorcount = "SELECT count(uid) from wms_catgbig ";
                                            $fetch_floorcount=mysql_query($query_floorcount);
                                            if (!$fetch_floorcount) { error("QUERY_ERROR"); exit; }
                                            $floorcount=mysql_result($fetch_floorcount,0,0);

                                            $query_floor = "SELECT uid,lcode,lname from wms_catgbig ";
                                            $fetch_floor=mysql_query($query_floor);
                                            if (!$fetch_floor) { error("QUERY_ERROR"); exit; }

                                            for ($k=0;$k<$floorcount;$k++) { 
                                            $fuid   =mysql_result($fetch_floor,$k,0);
                                            $fcode  =mysql_result($fetch_floor,$k,1);
                                            $fname  =mysql_result($fetch_floor,$k,2);
                                        
                                                echo ("
                                                    <option value='$fcode'>$fname</option>   
                                                ");
                                            }
                                        ?>

                                        </select>
                                    </td>
                                    <td>Qty Item</td>
                                    <td><input type='text' class='form-control'></td>
                                </tr>
                                 <tr>
                                    <td>Item Name</td>
                                    <td><input type='text' class='form-control'></td>
                                    <td>Rack</td>
                                    <td>

                                        <select name='rack' id='rack' class='form-control'>
                                             <option selected>:: <?=$txt_comm_frm19?> ::</option>
                                        </select>

                                    </td>
                                    <td>Qty Box</td>
                                    <td><input type='text' class='form-control'></td>
                                </tr>
                                 <tr>
                                    <td>Barcode</td>
                                    <td><input type='text' class='form-control'></td>
                                    <td>Position</td>
                                    <td>

                                        <select name='position' id='position' class='form-control'>
                                             <option selected>:: <?=$txt_comm_frm19?> ::</option>
                                        </select>

                                    </td>
                                    <td>CBM</td>
                                    <td><input type='text' class='form-control'></td>
                                </tr>
                                <tr>
                                  <td>Description</td>
                                  <td colspan='5'>
                                      <textarea class='form-control' id='description' name='description' style='height:80px; weight:100%;max-weight:400px;'></textarea>
                                  </td>
                                </tr>
                              </tbody>
                          </table>
                      </section>
                      <!--work progress end-->
                  </div>
                </section>

            <!--</section>-->
        </section>
    </body>
</html>

<?}

}?>