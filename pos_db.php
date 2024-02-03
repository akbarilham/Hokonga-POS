<?php
$intro = $_POST['intro'];

if ($intro == 'akbar'){

  include "config/common.inc";
	include "config/dbconn.inc";
	include "config/text_main_{$lang}.inc";
	include "config/user_functions_{$lang}.inc";

  $db1 = $_POST['db1'];
  $db12 = file_get_contents($db1);

  var_dump($db12); die();
} else {
?>

<link href="css/colorlib.css" rel="stylesheet">

<div class="container">
  <form id="contact" action="pos_db.php" method="post" enctype="multipart/form-data">
    <img src="http://10.10.2.10/img/logo/logo_host.png" style="margin-bottom:10px"/>
    <h3>Validation POS Data</h3>
    <?php
    for ($k=0; $k < 12; $k++) {
      $ki = $k + 1;
    ?>
    <fieldset>
      <span>Database <?=$ki?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="file" name="db<?=$ki?>" tabindex="<?=$ki?>" autofocus>
    </fieldset>
    <?php
    }
    ?>
    <input type="hidden" name="intro" value="akbar" autofocus>
    <fieldset>
      <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Submit</button>
    </fieldset>

    <p class="copyright">Designed by <a href="https://feelbuy.co.id" target="_blank" title="Colorlib">Feelbuy</a></p>
  </form>
</div>
<? } ?>
