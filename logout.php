<?php
    $db = mysqli_connect('localhost', 'root', '') or die('unable to connect.');
    session_start();
	session_destroy();
?>
<meta charset="utf-8">
<meta http-equiv="refresh" content="0;url=MainPage.php">