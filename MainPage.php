<?php
session_start();
$db = mysqli_connect('localhost', 'root', '') or die('unable to connect.');
mysqli_select_db($db, 'momemo') or die (mysqli_error($db));
error_reporting(E_ALL^ E_WARNING); //warning 제거

?>

<html>
    <head>
        <title>MOMEMO - MOney,MEMOry,MEMO</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/schedule.css">
        <link rel="stylesheet" href="css/main.css">
        <style>
            
            
        </style>

        <!-- javascript -->
        <script>
            //팝업창 함수
            function win_open(page, name) {
            window.open(page,name,"width=500, height=400, left=0, top=0, status=no,");
            };
        </script>

    </head>
    <body>
        <div>
            <header>
                <div class="Logo">
                    <h1><a href="MainPage.php" style="color:rgb(22,42,70) "><span>M</span>o<span>M</span>e<span>M</span>o</a></h1></div>
                    <div class='leftnav'>
                        <a href="expense-detail.php">Expense Detail</a></li>
                    </div>
                    <div class='rightnav'>
                        <?php
                            if(!isset($_SESSION['username'])){
                                echo '<a href="login.php">login</a>';
                            }
                            else{
                                $username=$_SESSION['username'];
                                echo "<span style='margin-right: 10px; color:blue;'>hi, $username!</span>";
                                echo '<a href="logout.php">logout</a>';
                            }
                        ?>
                    </div>
                </div>
            </header>
            <div class="main">
                <div>
                    <div class="box-container">
                        <!-- first box -->
                        <div class="box">
                            <div class="inner"> <!--id='goalbox'-->
                                <h3>Goal </h3><br/>
                                <div class='boxvalue'>
                                    <?php
                                        $db = mysqli_connect('localhost', 'root', '') or die('unable to connect.');
                                        mysqli_select_db($db, 'momemo') or die (mysqli_error($db));
                                        $userid=$_SESSION['userid'];
                                        $query1 = "SELECT goal FROM monthly WHERE userid='$userid' AND YEAR(datei) = YEAR(DATE(NOW())) AND MONTH(datei) = MONTH(DATE(NOW()))";
                                        $result1=mysqli_query($db,$query1) or die(mysqli_error($db));
                                        while($row=mysqli_fetch_array($result1)){ extract($row);}
                                        if (!isset($goal)) { $goal=0;}
                                        $_SESSION['goal']=$goal;

                                        echo '<h4>'.$goal.'</h4>';
                                    ?>
                                </div>
                                <!-- goal modify button -->       
                                <div class='goal-button'>
                                    <button class="modify-btn" type="button" 
                                    onclick="win_open('goalmodify.php','popup')">modify</button>
                                </div>
                            </div>
                        </div>
                        <!-- second box -->
                        <div class="box">
                            <div class="inner">
                                <h3  style="margin-bottom: 25%;">Daily </h3>
                                <div class='boxvalue'>
                                    <?php
                                        $db = mysqli_connect('localhost', 'root', '') or die('unable to connect.');
                                        mysqli_select_db($db, 'momemo') or die (mysqli_error($db));
                                        $userid=$_SESSION['userid'];
                                        $query2 = "SELECT daily_total FROM daily WHERE userid='$userid' AND datei=DATE(NOW())";
                                        $result2=mysqli_query($db,$query2) or die(mysqli_error($db));
                                        while($row=mysqli_fetch_array($result2)){ extract($row);}
                                        if (!isset($daily_total)) { $daily_total=0;}
                                        $_SESSION['d_total']=$daily_total;

                                        echo '<h4>'.$daily_total.'</h4>';
                                    ?>
                                </div>
                            </div>
                        </div>
                        <!-- third box -->
                        <div class="box">
                            <div class="inner">
                                <h3 style="margin-bottom: 25%;">Monthly</h3>
                                <div class='boxvalue'>
                                    <?php
                                        $db = mysqli_connect('localhost', 'root', '') or die('unable to connect.');
                                        mysqli_select_db($db, 'momemo') or die (mysqli_error($db));
                                        $userid=$_SESSION['userid'];
                                        $query3 = "SELECT monthly_total FROM monthly WHERE userid='$userid' AND YEAR(datei) = YEAR(DATE(NOW())) AND MONTH(datei) = MONTH(DATE(NOW()))";
                                        $result3=mysqli_query($db,$query3) or die(mysqli_error($db));
                                        while($row=mysqli_fetch_array($result3)){ extract($row);}
                                        if (!isset($monthly_total)) { $monthly_total=0;}
                                        $_SESSION['mt']=$monthly_total;

                                        echo '<h4>'.$monthly_total.'</h4>';
                                    ?>
                                </div>
                            </div>
                        </div>
                        <!-- last box -->
                        <div class="box">
                            <div>
                                <form method='post' action="dailyset.php" >
                                    <h4> Expense </h4>
                                    <input class="Input1" type="number" name='expense'>
                                    <div class='ctg'>
                                        <h4>Category </h4>
                                        <select name="select_type">
                                            <option value="food">food</option>
                                            <option value="liv">living</option>
                                            <option value="tra">transportation</option>
                                            <option value="edu">education</option>
                                            <option value="oth">other</option>
                                        </select>
                                    </div>
                                    <div>
                                        <h4> Memo </h4>
                                        <input class="Input1" type="text" name='memo'>
                                    </div>
                                    <input type='submit' class='add-btn' value='add'/>
                                </form>
                            </div>
                        </div>
                    </div>
                <div id="d"><span id="diff"></span><span id="diff1"></span><span id="diff2"></span><div>
                <div id='img'></div>
                <div class='chart' style="margin-top: 100px; margin-bottom: 100px;">
                    <div class='barchart'><?php include 'month-chart.php' ?></div>
                    <div class='piechart'><?php include 'type-chart.php' ?></div>
                </div>
                <div>
                    <?php include 'schedule.php' ?>
                    
                </div>
            </div>
        </div>
        <script>
            var goal = <?php echo $_SESSION['goal']?>;
            var mt = <?php echo $_SESSION['mt']?>;
            var diff=goal-mt;

            var img= new Image();
            img.src="image/rich.png";
            img.style.width="300px";

            var img2= new Image();
            img2.src="image/sad.png";
            img2.style.width="300px";

            document.getElementById('d').style.textAlign="center";
            document.getElementById('d').style.fontWeight="bolder";
            document.getElementById('d').style.marginTop="50px";

            document.getElementById('diff').style.color="rgb(22,42,70)";
            document.getElementById('diff1').style.color="rgb(111,135,174)";
            document.getElementById('diff2').style.color="rgb(22,42,70)";

            document.getElementById('diff1').style.fontSize="larger";

            document.getElementById('img').style.marginTop="50px";

            if(diff>0){
                document.getElementById('diff').innerHTML = 'You\'ve spent ';
                document.getElementById('diff1').innerHTML = diff+'won'; 
                document.getElementById('diff2').innerHTML=' less than your goal!! you\'re doing great!!';
                
                document.getElementById('diff1').addEventListener('mouseover',function(event){
                    document.getElementById('img').appendChild(img);
                },false)
                document.getElementById('diff1').addEventListener('mouseout',function(event){
                    document.getElementById('img').innerHTML="";
                },false)
                
            }
            else{
                document.getElementById('diff').innerHTML = 'You\'ve spent ';
                document.getElementById('diff1').innerHTML = diff+'won'; 
                document.getElementById('diff2').innerHTML = ' more than your goal amount so far..you\'ll have to save money!';

                document.getElementById('diff1').addEventListener('mouseover',function(event){
                    document.getElementById('img').appendChild(img2);
                },false)
                document.getElementById('diff1').addEventListener('mouseout',function(event){
                    document.getElementById('img').innerHTML="";
                },false)
            }
            
        </script>
    </body>
    
</html>




<!--
goal 값바꾸기 할 때. 지금 코드의 전의 코드
/*
$query = "SELECT * FROM monthly WHERE userid='$userid' AND YEAR(datei) = YEAR(DATE(NOW())) AND MONTH(datei) = MONTH(DATE(NOW()))";
$result = mysqli_query($db, $query) or die(mysqli_error($db));
$set=mysqli_fetch_array($result);
$_SESSION['goal']=$set['goal'];
*/


// You spent n won more than the goal amount.. Save! 
//글자 클릭하면 이미지 팝업 띄우기- 만수르, 손현주 거지짤, 정교빈 거지짤 //웹페이지 이미지 팝업 띄우기 검색

<div style="margin-top:20px;">
                                        <h4 style="display: inline; margin-right:10px;">Date :</h4>
                                        <input class='Input1' name="dateset" style="width: 50%;" type="text" id="datepicker">
                                    </div>

-->