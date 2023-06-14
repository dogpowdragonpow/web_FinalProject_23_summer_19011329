<!--
   this file is for goal data setting
   if press modify button in money.php page, this file will be connected.
-->
<?php
session_start();
$db = mysqli_connect('localhost', 'root', '') or die('unable to connect.');
mysqli_select_db($db, 'momemo') or die (mysqli_error($db));
error_reporting(E_ALL^ E_WARNING); //warning 제거

$goalset=$_POST['inputgoal'];
$userid=$_SESSION['userid'];


$query3 = "SELECT goal FROM monthly WHERE userid='$userid' AND YEAR(datei) = YEAR(DATE(NOW())) AND MONTH(datei) = MONTH(DATE(NOW()))";
$result3=mysqli_query($db,$query3) or die(mysqli_error($db));
while($row=mysqli_fetch_array($result3)){
   extract($row);
}

if (isset($goal)) {
    $query2 = "UPDATE monthly SET goal = $goalset 
                WHERE userid='$userid' AND YEAR(datei) = YEAR(CURRENT_DATE()) AND MONTH(datei) = MONTH(CURRENT_DATE())";
    mysqli_query($db, $query2) or die(mysqli_error($db));
}
else{
    $query2="INSERT INTO monthly (datei, monthly_total, goal, userid) VALUES (CURRENT_DATE(), 0, '$goalset', '$userid')";
    mysqli_query($db,$query2) or die(mysqli_error($db));
}


?>
<html>
    <head><title>MOMEMO-goalset</title></head>
</html>
<script type="text/javascript">alert('success!!');
window.close();

</script>
 
