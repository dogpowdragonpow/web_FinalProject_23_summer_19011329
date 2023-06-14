<!--
   this file is for chart.
-->
<?php 

    error_reporting(E_ALL^ E_WARNING); //warning 제거
    error_reporting(E_ALL &~E_NOTICE);//notice제거
    session_start();
    $db = mysqli_connect('localhost', 'root', '') or die('unable to connect.');
    mysqli_select_db($db, 'momemo') or die (mysqli_error($db));
    
    $type=[0,0,0,0,0]; //food, living, education, trasp, other

    if(isset($_SESSION['userid'])){
    $userid=$_SESSION['userid'];
    
    $query = "SELECT * 
            FROM typei 
            WHERE userid='$userid' AND YEAR(datei) = YEAR(DATE(NOW())) AND MONTH(datei) = MONTH(DATE(NOW()))";
    $result=mysqli_query($db,$query) or die(mysqli_error($db));
    while($row=mysqli_fetch_array($result)){ 
        extract($row);
        $type[0]+=$row['food'];
        $type[1]+=$row['liv'];
        $type[2]+=$row['edu'];
        $type[3]+=$row['tra'];
        $type[4]+=$row['oth'];
    }
    }
    $_SESSION['type'] = serialize($type);

?>
<html>
    <head>
        <title>MOMEMO-chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
    <style>
    </style>
    </head>
    <body>
        <canvas id="typeChart" width='400vw'></canvas>
        <script>
              var ctx = document.getElementById('typeChart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'pie', 
                    data: {
                        labels: ['Food','Living','Education','Transportation','Others'],
                        datasets: [{
                            label: "Expenses by Category This Month",
                            backgroundColor: [
                                'rgb(61,93,144)',
                                'rgb(111,135,174)',
                                'rgb(153,187,222)',
                                'rgb(187,208,235)',
                                'rgb(215,220,224)'
                            ],
                            borderColor: 'rgb(255, 99, 132)',
                            borderWidth: 0,
                            data: [<?php $Type = unserialize($_SESSION['type']); echo $Type[0];?>,
                                    <?php $Type = unserialize($_SESSION['type']); echo $Type[1];?>,
                                    <?php $Type = unserialize($_SESSION['type']); echo $Type[2];?>,
                                    <?php $Type = unserialize($_SESSION['type']); echo $Type[3];?>,
                                    <?php $Type = unserialize($_SESSION['type']); echo $Type[4];?>,
                                ]
                        }]
                    },
                    options: {
                        responsive: false,
                    }
                });
        </script>
    </body>
    
</html>