<!--
   this file is for goal set
   if press the modify button in first box, this page will be pop
-->
<html>
    <head>
        <title>MOMEMO-money</title>
        <style>
            body{
                padding-top: 10%;
                text-align:center;
                background-color: rgb(153,187,222);
                color: white;
            }
            label{
                display: inline;
                margin-bottom: 5px;
            }
            a{
                text-decoration: none;
                color:white;
            }
            form{
                margin-top: 3%;
            }
            form input{
                border: none;
                border-radius: 10px;
                outline:none;
                height : 30px;
                font-family: sans-serif;
            }
            .Btn{ 
                background-color: rgb(61,93,144); 
                color: white;
            }
            .Btn:hover{transform: scale( 1.2 );}

            .Logo h1{font-size:70px;font-family: fantasy;}
            .Logo h1 span{color:rgb(61,93,144);}
            a{text-decoration: none;}
            
        </style>
    </head>
    <body>
        <div class="Logo">
            <h1><a href="MainPage.php" style="color:rgb(22,42,70) "><span>M</span>o<span>M</span>e<span>M</span>o</a></h1></div>
        </div>
        <form method="post" action="goalset.php">
            <h4>My Goal is..</h4>
                <input type="number" name="inputgoal">
                <input type="submit" value='modify' class='Btn' style="width: 80px;">
            
        </body>
</html>
<script>
</script>