<?
$query_copy = "SELECT subject,comment FROM wpage_stuff WHERE room = 'copy' AND lang = '$lang' AND gate = '$gate' ORDER BY uid DESC";
$result_copy = mysql_query($query_copy,$dbconn);
if(!$result_copy) { error("QUERY_ERROR"); exit;}
$copy_subject = @mysql_result($result_copy,0,0);
$copy_subjects = stripslashes($copy_subject);
$copy_comment = @mysql_result($result_copy,0,1);
$copy_comments = stripslashes($copy_comment);
$copy_comments = nl2br($copy_comments);

// Foot Box
$query_fgd1 = "SELECT subject,comment FROM wpage_stuff WHERE room = 'footbox' AND lang = '$lang' AND gate = '$gate' ORDER BY uid DESC";
$result_fgd1 = mysql_query($query_fgd1,$dbconn);
  if(!$result_fgd1) {      
    error("QUERY_ERROR");
    exit;
  }
$fgd1_subject = @mysql_result($result_fgd1,0,0);
  $fgd1_subjects = stripslashes($fgd1_subject);
  $fgd1_subjects = htmlspecialchars($fgd1_subjects);
$fgd1_comment = @mysql_result($result_fgd1,0,1);
  $fgd1_comments = stripslashes($fgd1_comment);
  $fgd1_comments2 = nl2br($fgd1_comments);

$query_fgd5 = "SELECT subject,comment FROM wpage_stuff WHERE room = 'footbox2' AND lang = '$lang' AND gate = '$gate' ORDER BY uid DESC";
$result_fgd5 = mysql_query($query_fgd5,$dbconn);
  if(!$result_fgd5) {      
    error("QUERY_ERROR");
    exit;
  }
$fgd5_subject = @mysql_result($result_fgd5,0,0);
  $fgd5_subjects = stripslashes($fgd5_subject);
  $fgd5_subjects = htmlspecialchars($fgd5_subjects);
$fgd5_comment = @mysql_result($result_fgd5,0,1);
  $fgd5_comments = stripslashes($fgd5_comment);
  $fgd5_comments2 = nl2br($fgd5_comments);

  


// Address
$query_fgd2 = "SELECT subject,comment FROM wpage_stuff WHERE room = 'xmail_footer' AND lang = '$lang' AND gate = '$gate'";
$result_fgd2 = mysql_query($query_fgd2,$dbconn);
  if(!$result_fgd2) {      
    error("QUERY_ERROR");
    exit;
  }
$fgd2_subject = @mysql_result($result_fgd2,0,0);
  $fgd2_subjects = stripslashes($fgd2_subject);
  $fgd2_subjects = htmlspecialchars($fgd2_subjects);
$fgd2_comment = @mysql_result($result_fgd2,0,1);
  $fgd2_comments = stripslashes($fgd2_comment);
  $fgd2_comments2 = nl2br($fgd2_comments);
?>


<!-- footer-wrapper -->
<footer class="footer-wrapper">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- col-md-8 -->
            <div class="col-md-8 col-sm-12">
                <!-- footer-contact -->
                <div class="footer-contact">
                    <span><?=$fgd2_subjects?></span>

                    <span><?=$fgd2_comments?></span>

                    

                </div>
                <!-- /footer-contact -->
            </div>
            <!-- /col-md-8 -->

            <!-- col-md-4 -->
            <div class="col-md-4 col-sm-12">
                <!-- social-icon -->
                <div class="social-icon less-margin-top">
                    <ul>
                        <li><a href="#" title="Facebook" target="_blank"><i class="fa fa-facebook"> </i></a></li>

                        <li><a href="#" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>

                        <li><a href="#" title="Google plus" target="_blank"><i class="fa fa-google-plus"></i></a></li>

                        <li><a href="#" title="YouTube" target="_blank"><i class="fa fa-youtube"></i></a></li>

                        <li><a href="#" title="Linkedin" target="_blank"><i class="fa fa-linkedin"></i></a></li>

                        <li><a href="#" title="Flickr" target="_blank"><i class="fa fa-flickr"></i></a></li>
                    </ul>
                </div>
                <!-- /social-icon -->
            </div>
            <!-- /col-md-4 -->
        </div>
        <!-- /row -->


        <!-- row -->
        <div class="row">
            <!-- col-md-12 -->
            <div class="col-md-12">
                <!-- footer-bottom -->
                <div class="footer-bottom">
                    <!-- copyright-text -->
                    <div class="copyright-text">
                        <p>
						<?
						if($copy_subject != "") {
							echo ("$copy_subjects<br>");
						}
						
						if($copy_comment AND $copy_comment != "") {
							echo ("$copy_comments");
						} else {
							echo ("$copyright_name");
						}
						?>
						</p>
                        <a href="#" class="back-to-top"><i class="fa fa-angle-up backtop pull-right"></i></a>
                    </div>
                    <!-- /copyright-text -->
                </div>
                <!-- /footer bottom -->
            </div>
            <!-- /col-md-12 -->
        </div>
        <!-- /row -->

    </div>
    <!-- /container -->
</footer>
<!-- /footer-wrapper -->