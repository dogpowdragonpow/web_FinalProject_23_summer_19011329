<!--
   this file is for calender.
-->
<?php
session_start();
$db = mysqli_connect('localhost', 'root', '') or die('unable to connect.');
mysqli_select_db($db, 'momemo') or die (mysqli_error($db));

//---- 오늘 날짜
$thisyear = date('Y'); // 4자리 연도
$thismonth = date('n'); // 0을 포함하지 않는 월
$today = date('j'); // 0을 포함하지 않는 일

//------ $year, $month 값이 없으면 현재 날짜
$year = isset($_GET['year']) ? $_GET['year'] : $thisyear;
$month = isset($_GET['month']) ? $_GET['month'] : $thismonth;
$day = isset($_GET['day']) ? $_GET['day'] : $today;

$prev_month = $month - 1;
$next_month = $month + 1;
$prev_year = $next_year = $year;
if ($month == 1) {
    $prev_month = 12;
    $prev_year = $year - 1;
} else if ($month == 12) {
    $next_month = 1;
    $next_year = $year + 1;
}
$preyear = $year - 1;
$nextyear = $year + 1;

$predate = date("Y-m-d", mktime(0, 0, 0, $month - 1, 1, $year));
$nextdate = date("Y-m-d", mktime(0, 0, 0, $month + 1, 1, $year));


$last_day = date('t', mktime(0, 0, 0, $month, 1, $year));
$start_week = date("w", mktime(0, 0, 0, $month, 1, $year));
$total_week = ceil(($last_day + $start_week) / 7);
$last_week = date('w', mktime(0, 0, 0, $month, $last_day, $year));


// daily total 계산
    $cnt=0;
    for($i=0;$i<$last_day;$i++){$sch[$i]=0;}

    if(isset($_SESSION['userid'])){
    $userid=$_SESSION['userid'];
    for($i=1;$i<=$last_day;$i++){
        $query = "SELECT daily_total 
                FROM daily 
                WHERE 
                    userid='$userid' 
                    AND YEAR(datei) = YEAR(CURRENT_DATE()) 
                    AND MONTH(datei) = MONTH(DATE(NOW())) 
                    AND DAY(datei) = $i";
        $result=mysqli_query($db,$query) or die(mysqli_error($db));
        $row=mysqli_fetch_array($result);
        if(!isset($row['daily_total'])) $sch[$cnt]=0;
        else $sch[$cnt]=$row['daily_total'];
        $cnt++;
    }
}
    $_SESSION['sch'] = serialize($sch);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>MOMEMO-schedule</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    table {
      table-layout: fixed;
      width: 100%;
    }
    td {
      width: 14.3%; 
      padding: 10px;
    }
    th {
      padding: 10px;
    }
    .weeks {
      color: rgb(61,93,144);
      font-weight: bolder;
      background-color: rgb(187,208,235);
      
    }
    .weeks th{ width: 15%; border-radius: 10px;}
    a{
        text-decoration: none;
        color: rgb(22,42,70);
    }
  </style>
</head>
<body>
<form>
    <table >
        <tr style='text-align: center;' >
            <td><a href=<?php echo 'schedule.php?year='.$preyear.'&month='.$month . '&day=1'; ?>><<</a></td>
            <td><a href=<?php echo 'schedule.php?year='.$prev_year.'&month='.$prev_month . '&day=1'; ?>><</a></td>
            <td colspan="3"> 
                <a href=<?php echo 'schedule.php?year=' . $thisyear . '&month=' . $thismonth . '&day=1'; ?>>
                <?php echo "&nbsp;&nbsp;" . $year . '년 ' . $month . '월 ' . "&nbsp;&nbsp;"; ?></a>  <!-- nbsp는 줄바꿈 -->
            </td>
            <td><a href=<?php echo 'schedule.php?year='.$next_year.'&month='.$next_month.'&day=1'; ?>>></a></td>
            <td><a href=<?php echo 'schedule.php?year='.$nextyear.'&month='.$month.'&day=1'; ?>>>></a></td>
        </tr>
    </table>
    <table>
    <tr class="weeks">
        <th hight="40">Sun</td>
        <th>Mon</th>
        <th>Tue</th>
        <th>Wed</th>
        <th>Thu</th>
        <th>Fri</th>
        <th>Sat</th>
    </tr>

    <?php
        $day=1;

        //총 주 수에 맞춰서 세로줄 만들기
        for($i=1; $i <= $total_week; $i++){?>
    <tr>
        <?php
        $Sch = unserialize($_SESSION['sch']);
        //총 가로칸 만들기
        for ($j = 0; $j < 7; $j++) {
            //첫번째 주이고 시작요일보다 $j가 작거나 마지막주이고 $j가 마지막 요일보다 크면 표시하지 않음
            echo '<td height="100" valign="top">';
            if (!(($i == 1 && $j < $start_week) || ($i == $total_week && $j > $last_week))) {

                if ($j == 0) {
                    //일요일이므로 빨간색
                    //오늘 날짜면 굵은 글씨
                    if($year == $thisyear && $month == $thismonth){
                        if ($day == date("j")) {
                            echo "<span style='color:red; font-weight: bolder;'>".'<span style="text-decoration: underline;">'.$day.'</span>'."<br/>".$Sch[$day-1]."</span>";
                        } else {
                            echo "<span style='color:red;'>".$day."<br/>".$Sch[$day-1]."</span>";
                        }
                    }
                    else{
                        if ($day == date("j")) {
                            echo "<span style='color:red; font-weight: bolder;'>".'<span style="text-decoration: underline;">'.$day.'</span>'."</span>";
                        } else {
                            echo "<span style='color:red;'>".$day."</span>";
                        }
                    }
                } else if ($j == 6) {
                    //토요일이므로 파란색
                    if($year == $thisyear && $month == $thismonth){
                        if ($day == date("j")) {
                            echo "<span style='color:red; font-weight: bolder;'>".'<span style="text-decoration: underline;">'.$day.'</span>'."<br/>".$Sch[$day-1]."</span>";
                        } else {
                            echo "<span style='color:red;'>".$day."<br/>".$Sch[$day-1]."</span>";
                        }
                    }
                    else{
                        if ($day == date("j")) {
                            echo "<span style='color:red; font-weight: bolder;'>".'<span style="text-decoration: underline;">'.$day.'</span>'."</span>";
                        } else {
                            echo "<span style='color:red;'>".$day."</span>";
                        }
                    }
                } else {
                    //평일 검정색
                    if($year == $thisyear && $month == $thismonth){ // if it is this month, year
                        //display date and data
                        if ($day == date("j")) {//if it is today
                            echo "<span style='color:rgb(111,135,174); font-weight: bolder;'>"
                            .'<span style="text-decoration: underline;">'.$day.'</span>'."<br/>".$Sch[$day-1]."</span>";
                        } else {//it is not today
                            echo "<span style='color:rgb(111,135,174);'>".$day."<br/>".$Sch[$day-1]."</span>";
                        }
                    }
                    else{ // is not this month, year
                        //display only date
                        if ($day == date("j")) {
                            echo "<span style='color:rgb(22,42,70); font-weight: bolder;'>"
                            .'<span style="text-decoration: underline;">'.$day.'</span>'."</span>";
                        } else {
                            echo "<span style='color:rgb(22,42,70);'>".$day."</span>";
                        }
                    }
                }

                // 14. 날짜 증가
                $day++;
            }
            echo '</td>';
        }  
    ?>
    </tr>
    <?php } ?>
    </table>

</form>
<a href="MainPage.php">go to home</a>
</body>
</html>