<!--
   this file is for lastbox.
   values in lastbox will be save in today table, daily table, monthly table and typei table
-->
<?php
session_start();
$db = mysqli_connect('localhost', 'root', '') or die('unable to connect.');
mysqli_select_db($db, 'momemo') or die (mysqli_error($db));
error_reporting(E_ALL^ E_WARNING); //warning 제거

$expense=$_POST['expense'];
$select_type=$_POST['select_type'];
$memo=$_POST['memo'];
$userid=$_SESSION['userid'];


$query="INSERT INTO today 
    (datei, today, typei, userid, memo) 
    VALUES 
    (CURRENT_DATE(), '$expense', '$select_type', '$userid', '$memo')";
mysqli_query($db,$query) or die(mysqli_error($db));

//같은날 daily total 데이터 없으면 insert하고 있으면 기본 데일리토탈에 today expense 더한걸로 update , monthly_total도 똑같이.
// 같은날 같은 타입 있으면 더하는걸로 업데이트, 없으면 인서트

$query1 = "SELECT monthly_total 
            FROM monthly 
            WHERE userid='$userid' AND YEAR(datei) = YEAR(DATE(NOW())) AND MONTH(datei) = MONTH(DATE(NOW()))";
$result1=mysqli_query($db,$query1) or die(mysqli_error($db));
while($row=mysqli_fetch_array($result1)){ extract($row);}

if (!isset($monthly_total)) {
    $query2="INSERT INTO monthly 
            (datei, monthly_total, goal, userid) 
            VALUES (CURRENT_DATE(), '$expense', 0, '$userid')";
    mysqli_query($db,$query2) or die(mysqli_error($db));
}
else{
    $query2 = "UPDATE monthly 
                SET monthly_total = ($monthly_total + $expense)
                WHERE userid='$userid' AND YEAR(datei) = YEAR(CURRENT_DATE()) AND MONTH(datei) = MONTH(CURRENT_DATE())";
    mysqli_query($db, $query2) or die(mysqli_error($db));
}


//daily
$query3 = "SELECT daily_total 
            FROM daily 
            WHERE userid='$userid' AND datei=DATE(NOW())";
$result3=mysqli_query($db,$query3) or die(mysqli_error($db));
while($row=mysqli_fetch_array($result3)){ extract($row);}

if (!isset($daily_total)) {
    $query4="INSERT INTO daily 
            (datei, daily_total, userid) 
            VALUES (CURRENT_DATE(), '$expense','$userid')";
    mysqli_query($db,$query4) or die(mysqli_error($db));
}
else{
    $query4 = "UPDATE daily 
                SET daily_total = ($daily_total + $expense)
                WHERE userid='$userid' AND datei=DATE(NOW())";
    mysqli_query($db, $query4) or die(mysqli_error($db));
}

//typei
$query5 = "SELECT * 
            FROM  typei
            WHERE userid='$userid' AND datei=DATE(NOW())";
$result5=mysqli_query($db,$query5) or die(mysqli_error($db));

if($select_type=='food'){
    if(mysqli_num_rows($result5)>0){
        $row=mysqli_fetch_array($result5);
        extract($row);
        $udt=$row['food'];
        $query6 = "UPDATE typei 
            SET food = ($udt + $expense)
            WHERE userid='$userid' AND datei=DATE(NOW())";
        mysqli_query($db, $query6) or die(mysqli_error($db));
    }
    else{
        $query6="INSERT INTO typei 
            (datei, food, edu, liv, oth, tra, userid) 
            VALUES (CURRENT_DATE(), '$expense', 0,0,0,0,'$userid')";
        mysqli_query($db,$query6) or die(mysqli_error($db));
    }
}
else if($select_type=='edu'){
    if(mysqli_num_rows($result5)>0){
        $row=mysqli_fetch_array($result5);
        extract($row);
        $udt=$row['edu'];
        $query6 = "UPDATE typei 
            SET edu = ($udt + $expense)
            WHERE userid='$userid' AND datei=DATE(NOW())";
        mysqli_query($db, $query6) or die(mysqli_error($db));
    }
    else{
        $query6="INSERT INTO typei 
            (datei, food, edu, liv, oth, tra, userid) 
            VALUES (CURRENT_DATE(), 0,'$expense',0,0,0,'$userid')";
        mysqli_query($db,$query6) or die(mysqli_error($db));
    }
}
else if($select_type=='liv'){
    if(mysqli_num_rows($result5)>0){
        $row=mysqli_fetch_array($result5);
        extract($row); 
        $udt=$row['liv'];
        $query6 = "UPDATE typei 
            SET liv = ($udt + $expense)
            WHERE userid='$userid' AND datei=DATE(NOW())";
        mysqli_query($db, $query6) or die(mysqli_error($db));
    }
    else{
        $query6="INSERT INTO typei 
            (datei, food, edu, liv, oth, tra, userid) 
            VALUES (CURRENT_DATE(), 0,0,'$expense',0,0,'$userid')";
        mysqli_query($db,$query6) or die(mysqli_error($db));
    }
}
else if($select_type=='oth'){
    if(mysqli_num_rows($result5)>0){
        $row=mysqli_fetch_array($result5);
        extract($row); 
        $udt=$row['oth'];
        $query6 = "UPDATE typei 
        SET oth = ($udt + $expense)
        WHERE userid='$userid' AND datei=DATE(NOW())";
        mysqli_query($db, $query6) or die(mysqli_error($db));
    }
    else{
         $query6="INSERT INTO typei 
            (datei, food, edu, liv, oth, tra, userid) 
            VALUES (CURRENT_DATE(),0,0,0, '$expense',0,'$userid')";
        mysqli_query($db,$query6) or die(mysqli_error($db)); 
    }
}
else if($select_type=='tra'){
    if(mysqli_num_rows($result5)>0){
        $row=mysqli_fetch_array($result5);
        extract($row);
        $udt=$row['tra']; 
        $query6 = "UPDATE typei 
            SET tra = ($udt + $expense)
            WHERE userid='$userid' AND datei=DATE(NOW())";
        mysqli_query($db, $query6) or die(mysqli_error($db));
    }
    else{
         $query6="INSERT INTO typei 
            (datei, food, edu, liv, oth, tra, userid) 
            VALUES (CURRENT_DATE(), 0,0,0,0,'$expense','$userid')";
        mysqli_query($db,$query6) or die(mysqli_error($db));  
    }
}

?>


<script type="text/javascript">alert('success!!');</script>
<html>
    <head>
        <title>MOMEMO-dailyset</title>
        <meta http-equiv="refresh" content="0;url=MainPage.php">
    </head>
</html>