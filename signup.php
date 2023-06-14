<?php 
$db = mysqli_connect('localhost', 'root', '') or die('unable to connect.');
?>
<html>
    <head>
        <title>MOMEMO-signup</title>
        <link rel="stylesheet" href="css/login.css">
        <style>
            .id{
                position: relative;
                left: 15px;
            }
            .pw{
                position: relative;
                left: -20px;
            }
        </style>
    </head>
    <body>
        <div class="Logo">
            <h1><a href="MainPage.php" style="color:rgb(22,42,70) "><span>M</span>o<span>M</span>e<span>M</span>o</a></h1></div>
        </div>
        <div class='box'>
        <h3>Signup</h3>
        <form action="signup_ok.php" method="post">
            <label class="name" for="username">NAME : <input type="text" name='username' id='username'></label>
            <label class='id' for="userid">ID : <input type="text" name='userid' id='userid'></label>
            <label class='pw' for="userpw">PASSWORD : <input type="password" name='userpw' id='userpw'></label>
            <input class="signup" type="submit" value="Signup">
            <a class="gotologin" href="login.php">Login</a>
        </form>
    </div>
    </body>
</html>