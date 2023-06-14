<!--
   this file is for database
-->
<?php
session_start();
    $db = mysqli_connect('localhost', 'root', '') or die('unable to connect.');
    $query = 'CREATE DATABASE IF NOT EXISTS momemo';
    mysqli_query($db,$query) or die(mysqli_error($db));
    mysqli_select_db($db,'momemo') or die(mysqli_error($db));

    /*
    //member
    $query='CREATE TABLE member(
        idx       INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
        id        VARCHAR(255)     NOT NULL,
        pw        VARCHAR(255)     NOT NULL,
        username  VARCHAR(255)     NOT NULL,

        PRIMARY KEY (idx)
    )
    ENGINE=MyISAM';
    mysqli_query($db, $query) or die(mysqli_error($db));
    */
    
    /*
    //today
    $query="CREATE TABLE today(
        datei DATE NOT NULL,
        today INTEGER UNSIGNED NOT NULL,
        typei ENUM('Food', 'Edu', 'Tra', 'Liv', 'Oth') NOT NULL,
        userid VARCHAR(100) NOT NULL,
    )
    ENGINE=MyISAM";
    mysqli_query($db, $query) or die(mysqli_error($db));
    */

    /*
    //daliy_total
    $query='CREATE TABLE daily(
        datei DATE NOT NULL,
        daily_total INTEGER UNSIGNED NOT NULL,
        userid VARCHAR(255) NOT NULL,
    )
    ENGINE=MyISAM';
    mysqli_query($db, $query) or die(mysqli_error($db));
    */

    /*
    //monthly_total
    $query='CREATE TABLE monthly(
        datei DATE NOT NULL,
        monthly_total INTEGER UNSIGNED NOT NULL,
        goal INTEGER UNSIGNED NOT NULL,
        userid VARCHAR(100) NOT NULL,
    )
    ENGINE=MyISAM';
    mysqli_query($db, $query) or die(mysqli_error($db));
    */

    /*
    //type
    $query='CREATE TABLE typei(
        datei DATE NOT NULL,
        food INTEGER UNSIGNED NOT NULL,
        edu INTEGER UNSIGNED NOT NULL,
        tra INTEGER UNSIGNED NOT NULL,
        liv INTEGER UNSIGNED NOT NULL,
        oth INTEGER UNSIGNED NOT NULL,
        userid VARCHAR(100) NOT NULL,
    )
    ENGINE=MyISAM';
    mysqli_query($db, $query) or die(mysqli_error($db));

    */
    /*
    $query = "DELETE FROM monthly WHERE datei = '2023-05-05' OR datei = '2023-06-09'";
    mysqli_query($db, $query) or die(mysqli_error($db)); */
    /*$query = "ALTER TABLE today ADD memo VARCHAR(255)";
mysqli_query($db, $query) or die(mysqli_error($db));*/



    echo 'database successfully created!';
?>