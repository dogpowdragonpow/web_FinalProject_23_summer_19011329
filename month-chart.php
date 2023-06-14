<!--
   this file is for chart.
-->
<?php
             error_reporting(E_ALL^ E_WARNING); //warning 제거
             error_reporting(E_ALL &~E_NOTICE);//notice제거
             session_start();
             $db = mysqli_connect('localhost', 'root', '') or die('unable to connect.');
             mysqli_select_db($db, 'momemo') or die (mysqli_error($db));
             
             
         
             $fstmonth=(date('n')-5);
             $midmonth1=$fstmonth+5;
             $midmonth2=$fstmonth+5;
             $lstmonth=$fstmonth+5;
             if($fstmonth<=0){
                 $fstmonth+=12;
                 $midmonth1=12;
                 $midmonth2=1;
             }
             //echo $fstmonth.' '.$midmonth1.' '.$midmonth2.' '.$lstmonth.'<br/>';
             
             $data=[];
             $cnt=0;
             if(!isset($_SESSION['userid'])){
                for($i=0;$i<6;$i++){$data[$i]=0;}
             }
             else{
                $userid=$_SESSION['userid'];
             if($midmonth1==12){
                 for($i=$fstmonth;$i<=$midmonth1;$i++){
                     $query = "SELECT monthly_total 
                     FROM monthly 
                     WHERE 
                         userid='$userid' 
                         AND YEAR(datei) = (YEAR(CURRENT_DATE())-1) AND MONTH(datei) = $i";
                     $result=mysqli_query($db,$query) or die(mysqli_error($db));
                     $row=mysqli_fetch_array($result);
                     if(!isset($row['monthly_total'])) $data[$cnt]=0;
                     else $data[$cnt]=$row['monthly_total'];
                     $cnt++;
                 }
                 for($i=$midmonth2;$i<=$lstmonth;$i++){
                     $query = "SELECT monthly_total 
                     FROM monthly 
                     WHERE 
                         userid='$userid' 
                         AND YEAR(datei) = YEAR(CURRENT_DATE()) AND MONTH(datei) = $i";
                     $result=mysqli_query($db,$query) or die(mysqli_error($db));
                     $row=mysqli_fetch_array($result);
                     if(!isset($row['monthly_total'])) $data[$cnt]=0;
                     else $data[$cnt]=$row['monthly_total'];
                     $cnt++;
                 }
             }
             else{
                 //echo 'f is<br/>';
                 for($i=$fstmonth;$i<=$lstmonth;$i++){
                     $query = "SELECT monthly_total 
                     FROM monthly 
                     WHERE 
                         userid='$userid' 
                         AND YEAR(datei) = YEAR(CURRENT_DATE()) AND MONTH(datei) = $i";
                     $result=mysqli_query($db,$query) or die(mysqli_error($db));
                     $row=mysqli_fetch_array($result);
                     if(!isset($row['monthly_total'])) $data[$cnt]=0;
                     else $data[$cnt]=$row['monthly_total'];
                     $cnt++;
                 }
             }
             //for($i=0;$i<=5;$i++){
             //    echo $data[$i].'<br/>';
             //}
             }
             $_SESSION['data'] = serialize($data);
             

?>
<html>
    <head>
        <title>MOMEMO-chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
    <style>
        #dayChart{ margin-right: 100px; margin-left: 70px;}
    </style>
    </head>
    <body>
        <canvas id="dayChart" width="600vw" height="400vw"></canvas>
        <script>
        var now = new Date();	//now
        var month = now.getMonth();	//month-1
        const months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nove","Dec"];
        var labels=[];
        var m=month;
        for(i=5;i>=0;i--){
            labels[i]=m;
            m=m-1;
            if(m==-1) m=11;
        }
        var chartArea = document.getElementById('dayChart').getContext('2d');
        var dayChart = new Chart(chartArea, {
            type: 'bar',
            data: {
                labels: [months[labels[0]],months[labels[1]],months[labels[2]],months[labels[3]],months[labels[4]],months[labels[5]]],
                datasets: [{
                    label: 'Recent 6-Month Expense Status',
                    data: [<?php $Data = unserialize($_SESSION['data']); echo $Data[0];?>,
                            <?php $Data = unserialize($_SESSION['data']); echo $Data[1];?>,
                            <?php $Data = unserialize($_SESSION['data']); echo $Data[2];?>,
                            <?php $Data = unserialize($_SESSION['data']); echo $Data[3];?>,
                            <?php $Data = unserialize($_SESSION['data']); echo $Data[4];?>,
                            <?php $Data = unserialize($_SESSION['data']); echo $Data[5];?>],
                    backgroundColor: 'rgb(61,93,144)', //rgba(255, 99, 132, 0.6)
                    borderColor: 'rgb(61,93,144)',
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        </script>
    </body>
    
</html>