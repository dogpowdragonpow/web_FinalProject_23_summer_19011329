<?php
    $db = mysqli_connect('localhost', 'root', '') or die('unable to connect.');
    mysqli_select_db($db, 'momemo') or die (mysqli_error($db));

    $userid = $_POST['userid'];
    $userpw=$_POST['userpw'];
    $username=$_POST['username'];
    
    $query="INSERT INTO member (id, pw, username) 
        VALUES ('$userid','$userpw','$username')";
    mysqli_query($db,$query) or die(mysqli_error($db));

?>
<script type="text/javascript">alert('success!!');</script>
<html>
    <head>
        <title>MOMEMO-signup-ok</title>
        <meta http-equiv="refresh" content="0;url=MainPage.php">
    </head>
</html>