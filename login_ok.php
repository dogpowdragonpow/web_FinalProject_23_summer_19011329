<?php
    session_start();
    $db = mysqli_connect('localhost', 'root', '') or die('unable to connect.');
    mysqli_select_db($db, 'momemo') or die (mysqli_error($db));
    
    if($_POST['userid']=="" || $_POST['userpw']==""){
        echo '<script>alert("Please ipnut your id and password."); history.back();</script>';
    }
    else{
        $password=$_POST['userpw'];
        $id=$_POST['userid'];
        $query="SELECT * FROM member WHERE id='$id'";
        $result=mysqli_query($db,$query) or die(mysqli_error($db));
        $member=mysqli_fetch_array($result);
        $hash_pw=$member['pw'];

        if($password==$hash_pw){
            $_SESSION['userid']=$member['id'];
            $_SESSION['userpw']=$member['pw'];
            $_SESSION['username']=$member['username'];
            $_SESSION['test']='test';
            
            //$today = date('Y-m-d');
            /*
            // 테이블1과 테이블2에 동시에 값 추가
            $query = "INSERT INTO today (datei) VALUES ('$today'); 
                    INSERT INTO daily (datei) VALUES ('$today');
                    INSERT INTO monthly (datei) VALUES ('$today');
                    INSERT INTO typei (datei) VALUES ('$today');

                    INSERT INTO today (userid) VALUES ('$userid'); 
                    INSERT INTO daily (userid) VALUES ('$userid');
                    INSERT INTO monthly (userid) VALUES ('$userid');
                    INSERT INTO typei (userid) VALUES ('$userid')
                    
                    INSERT INTO today (datei) VALUES ('$today'); 
                    INSERT INTO daily (datei) VALUES ('$today');
                    INSERT INTO monthly (datei) VALUES ('$today');
                    INSERT INTO typei (datei) VALUES ('$today')
                    
                    INSERT INTO today (datei) VALUES ('$today'); 
                    INSERT INTO daily (datei) VALUES ('$today');
                    INSERT INTO monthly (datei) VALUES ('$today');
                    INSERT INTO typei (datei) VALUES ('$today')";
            $result = mysqli_multi_query($db, $query);
            */
            echo "<script>alert('login success!!.'); location.href='MainPage.php';</script>";
        }
        else{
            echo "<script>alert('Check your ID or PASSWORD.'); history.back();</script>";
        }
    }

?>