<!DOCTYPE html>
<html>
    <head>
        <title>MOMEMO-settlement</title>
        <style>
            
            body{
                padding: 10%;
                text-align:center;
                color: rgb(22,42,70);
            }
            table{
                background-color: rgb(187,208,235);
                border-radius: 20px;
                padding: 5%;
            }
            tr, td, th, table{
                border: none;
            }
            th{font-size: 17px;}
            td{
                font-size: 15px;
                font-weight: lighter;
            }
            .detail{margin-bottom: 20px;}
            .Logo h1{font-size:70px;font-family: fantasy;}
            .Logo h1 span{color:rgb(61,93,144);}
            a{text-decoration: none;}
        </style>
    </head>
    <body>
    <div class="Logo">
            <h1><a href="MainPage.php" style="color:rgb(22,42,70) "><span>M</span>o<span>M</span>e<span>M</span>o</a></h1></div>
        </div>
    <form action="expense-detail.php" method="post">
    <select name="chmonth" id="chmonth">
        <option value="1">Jan</option>
        <option value="2">Feb</option>
        <option value="3">Mar</option>
        <option value="4">Apr</option>
        <option value="5">May</option>
        <option value="6" selected>Jun</option>
        <option value="7">Jul</option>
        <option value="8">Aug</option>
        <option value="9">Sep</option>
        <option value="10">Oct</option>
        <option value="11">Nov</option>
        <option value="12">Dec</option>
    </select>
    <select name="chyear" id="chyear">
        <option value="2023">2023</option>
        <option value="2022">2022</option>
        <option value="2021">2021</option>
        <option value="2020">2020</option>
        <option value="2019">2019</option>
        <option value="2018">2018</option>
    </select>
    <input type="submit" value="look">
    </form>
    <?php
        $month=date('n');
        $year=date('Y');
        if(isset($_POST['chmonth'])){
            $month=$_POST['chmonth'];
            $year=$_POST['chyear'];
        }
        echo '<h2>'.$month.'/'.$year.' Expenditure Details';

        session_start();
        $db = mysqli_connect('localhost', 'root', '') or die('unable to connect.');
        mysqli_select_db($db, 'momemo') or die (mysqli_error($db));
        $userid=$_SESSION['userid'];
        $query="SELECT * FROM today WHERE userid='$userid' AND YEAR(datei) = $year AND MONTH(datei) = $month";
        $result=mysqli_query($db,$query) or die(mysqli_error($db));
        $num_row=mysqli_num_rows($result);

        $query1="SELECT monthly_total FROM monthly WHERE userid='$userid' AND YEAR(datei) = $year AND MONTH(datei) = $month";
        $result1=mysqli_query($db,$query1) or die(mysqli_error($db));
        $row1=mysqli_fetch_array($result1)


    ?>
    <table border="1" cellpadding="3" cellspacing="0" style="width : 80%; margin-left: 10%; margin-top: 50px;">
        <tr>
            <th>Date</th>
            <th>Expense</th>
            <th>Category</th>
            <th>Memo</th>
        </tr>
        
        <tr>
            <td></td><td></td><td></td><td></td>
        </tr>
        <tr>
            <td></td><td></td><td></td><td></td>
        </tr>
        <?php
            while ($row=mysqli_fetch_array($result)){
                extract($row);
                echo '<tr>';
                echo '<td>'.$datei.'</td>';
                echo '<td>'.$today.'</td>';
                echo '<td>'.$typei.'</td>';
                echo '<td>'.$memo.'</td>';
                echo '</tr>';
            }
        ?>
        <tr>
            <td></td><td></td><td></td><td></td>
        </tr>
        <?php
            echo '<tr>';
            echo '<td colspan="2" style="font-weight: bolder;font-size: 17px;">total Expenditure</td>';
            echo '<td style="font-weight: bolder;font-size: 17px;">'.$row1['monthly_total'].'</td>';
            echo '</tr>';
        ?>
        
        
    </table>
    </body>
</html>