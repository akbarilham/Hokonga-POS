<?php

require "func/mysqli_result.php";

$login_id = $_GET['login_id'] ?? null;

$query_0509 = "SELECT uid,gate,module_05 FROM admin_user WHERE user_id = 'akbar10'";

$fetch_0509 = mysqli_query($dbconn, $query_0509);
$smode_0509_K3 = @mysqli_result($fetch_0509,0,2);
$module_0509 = substr($smode_0509_K3,8,1);
// mysqli_close($dbconn);
?>
