<?
include "config/common.inc";

if(!$login_id OR $login_id == "" OR $login_level < "1") {
	echo ("<meta http-equiv='Refresh' content='0; URL=$home'>");
} else {

include "config/dbconn.inc";
include "config/text_main_{$lang}.inc";
include "config/user_functions_{$lang}.inc";

$mmenu = "chat";
$smenu = "chat_lobby";
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
  </head>

  <body>

  <section id="container" class="">
      
	  <? include "header.inc"; ?>
	  
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
              <!-- page start-->
              <div class="chat-room">
                  <aside class="left-side">
                      <div class="user-head">
                          <i class="fa fa-comments-o"></i>
                          <h3>FeelBuy Chat</h3>
                      </div>
                      <ul class="chat-list">
                          <li class="active">
                              <a class="lobby" href="chat_lobby.php">
                                  <h4>
                                      <i class="fa fa-list"></i>
                                      Lobby
                                  </h4>
                              </a>
                          </li>
                          <li>
                              <a href="chat_room.php">
                                <i class="fa fa-rocket"></i>
                                <span>Marketing</span>
                                <i class="fa fa-times pull-right"></i>
                              </a>
                          </li>
                          <li>
                              <a href="chat_room.php">
                                  <i class="fa fa-rocket"></i>
                                  <span>Water Cooler</span>
                                  <i class="fa fa-times pull-right"></i>
                              </a>
                          </li>
                          <li>
                              <a href="chat_room.php">
                                  <i class="fa fa-rocket"></i>
                                  <span>Design Lounge</span>
                                  <i class="fa fa-times pull-right"></i>
                              </a>
                          </li>
                          <li>
                              <a href="chat_room.php">
                                  <i class="fa fa-rocket"></i>
                                  <span>Development</span>
                                  <i class="fa fa-times pull-right"></i>
                              </a>
                          </li>

                      </ul>
                      <ul class="chat-list chat-user">

                          <li>
                              <a href="#">
                                  <i class="fa fa-circle text-success"></i>
                                  <span>Jonathan Smith</span>
                                  <i class="fa fa-times pull-right"></i>
                              </a>
                          </li>
                          <li>
                              <a href="#">
                                  <i class="fa fa-circle text-success"></i>
                                  <span>Jhon Doe</span>
                                  <i class="fa fa-times pull-right"></i>
                              </a>
                          </li>
                          <li>
                              <a href="#">
                                  <i class="fa fa-circle text-muted"></i>
                                  <span>Franklin kally</span>
                                  <i class="fa fa-times pull-right"></i>
                              </a>
                          </li>
                          <li>
                              <a href="#">
                                  <i class="fa fa-circle text-danger"></i>
                                  <span>Anjelina Joe</span>
                                  <i class="fa fa-times pull-right"></i>
                              </a>
                          </li>

                      </ul>
                      <footer>
                              <a class="chat-avatar" href="javascript:;">
                                  <img alt="" src="img/mail-avatar.jpg">
                              </a>
                              <div class="user-status">
                                  <i class="fa fa-circle text-success"></i>
                                  Available
                              </div>
                              <a class="chat-dropdown pull-right" href="javascript:;">
                                  <i class="fa fa-chevron-down"></i>
                              </a>
                      </footer>
                  </aside>
                  <aside class="mid-side">
                      <div class="chat-room-head">
                          <h3>Lobby</h3>
                          <form action="#" class="pull-right position">
                              <input type="text" placeholder="Search" class="form-control search-btn ">
                          </form>
                      </div>
                      <div class="room-desk">
                          <h4 class="pull-left">open room</h4>
                          <a href="#" class="pull-right btn btn-default">+ Create Room</a>
                          <div class="room-box">
                              <h5 class="text-primary"><a href="chat_room.php">Marketing</a></h5>
                              <p>Welcome to our world of marketing. Lorem ipsum dolor sit amet</p>
                              <p><span class="text-muted">Admin :</span> Kally Brash | <span class="text-muted">Member :</span> 13 | <span class="text-muted">Last Activity :</span> 15 min ago</p>
                          </div>
                          <div class="room-box">
                              <h5 class="text-primary"><a href="chat_room.php">Water Cooler</a></h5>
                              <p>Welcome to our world of marketing. Lorem ipsum dolor sit amet</p>
                              <p><span class="text-muted">Admin :</span> Kally Brash | <span class="text-muted">Member :</span> 13 | <span class="text-muted">Last Activity :</span> 15 min ago</p>
                          </div>
                          <div class="room-box">
                              <h5 class="text-primary"><a href="chat_room.php">FlatLab</a></h5>
                              <p>Welcome to our world of marketing. Lorem ipsum dolor sit amet</p>
                              <p><span class="text-muted">Admin :</span> Kally Brash | <span class="text-muted">Member :</span> 13 | <span class="text-muted">Last Activity :</span> 15 min ago</p>
                          </div>
                      </div>
                      <div class="room-desk">
                          <h4 class="pull-left">private room</h4>
                          <div class="room-box">
                              <h5 class="text-primary"><a href="chat_room.php">Marketing</a></h5>
                              <p>Welcome to our world of marketing. Lorem ipsum dolor sit amet</p>
                              <p><span class="text-muted">Admin :</span> Kally Brash | <span class="text-muted">Member :</span> 13 | <span class="text-muted">Last Activity :</span> 15 min ago</p>
                          </div>
                          <div class="room-box">
                              <h5 class="text-primary"><a href="chat_room.php">Water Cooler</a></h5>
                              <p>Welcome to our world of marketing. Lorem ipsum dolor sit amet</p>
                              <p><span class="text-muted">Admin :</span> Kally Brash | <span class="text-muted">Member :</span> 13 | <span class="text-muted">Last Activity :</span> 15 min ago</p>
                          </div>
                      </div>
                  </aside>
                  <aside class="right-side">
                      <div class="user-head">
                          <a href="#" class="chat-tools btn-success"><i class="fa fa-cog"></i> </a>
                          <a href="#" class="chat-tools btn-key"><i class="fa fa-key"></i> </a>
                      </div>
                      <div class="invite-row">
                          <h4 class="pull-left">Coworker</h4>
                          <a href="#" class="btn btn-danger pull-right">+ Invite</a>
                      </div>
                      <ul class="chat-available-user">
                          <li>
                              <a href="chat_room.php">
                                  <i class="fa fa-circle text-success"></i>
                                  Jonathan Smith
                                  <span class="text-muted">3h:22m</span>
                              </a>
                          </li>
                          <li>
                              <a href="chat_room.php">
                                  <i class="fa fa-circle text-success"></i>
                                  Jhone Due
                                  <span class="text-muted">1h:2m</span>
                              </a>
                          </li>
                          <li>
                              <a href="chat_room.php">
                                  <i class="fa fa-circle text-success"></i>
                                  Franklyn Kalley
                                  <span class="text-muted">2h:32m</span>
                              </a>
                          </li>
                          <li>
                              <a href="chat_room.php">
                                  <i class="fa fa-circle text-danger"></i>
                                  Anjelina joe
                                  <span class="text-muted">3h:22m</span>
                              </a>
                          </li>
                          <li>
                              <a href="chat_room.php">
                                  <i class="fa fa-circle text-warning"></i>
                                  Aliace Stalvien
                                  <span class="text-muted">1h:12m</span>
                              </a>
                          </li>
                          <li>
                              <a href="chat_room.php">
                                  <i class="fa fa-circle text-muted"></i>
                                  Stive jones
                                  <!--<span class="text-muted">3h:22m</span>-->
                              </a>
                          </li>
                          <li>
                              <a href="chat_room.php">
                                  <i class="fa fa-circle text-muted"></i>
                                  Jonathan Smith
                                  <!--<span class="text-muted">3h:22m</span>-->
                              </a>
                          </li>
                      </ul>
                  </aside>
              </div>
              <!-- page end-->
          </section>
      </section>
      <!--main content end-->
	  
      <? include "right_slidebar.inc"; ?>
	  
	  <? include "footer.inc"; ?>
	  
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="js/respond.min.js" ></script>

  <!--right slidebar-->
  <script src="js/slidebars.min.js"></script>

    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>


  </body>
</html>


<? } ?>