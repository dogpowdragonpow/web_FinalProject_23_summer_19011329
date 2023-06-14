<?php
$db = mysqli_connect('localhost', 'root', '') or die('unable to connect.');
?>
<html>
    <head>
        <title>MOMEMO-login</title>
        <link rel="stylesheet" href="css/login.css">
        <style>
            .pw{
            position: relative;
            left: -35px;
            }
        </style>
    </head>
    <body>
        <div class="Logo">
            <h1><a href="MainPage.php" style="color:rgb(22,42,70) "><span>M</span>o<span>M</span>e<span>M</span>o</a></h1></div>
        </div>
        <div class='box'>
        <h3>Login</h3>
        <form method="post" action="login_ok.php">
            <label for="">ID : <input type="text" name="userid"></label>
            <label class='pw' for="">PASSWORD : <input type="password" name='userpw'></label>
            <input class='login' type="submit" value="Login">
            <a class='gotosignup' href="signup.php">Signup</a>
        </form>
        </div>
    </body>
</html>