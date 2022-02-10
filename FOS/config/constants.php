<?php

    // Start Session
    session_start();

    // Creating home url variable
    $siteURL = "http://localhost/FOS/";


    // Create Constants to store no Repeating values
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbName = 'fos';


    // Database Connection
    $conn = mysqli_connect($servername, $username, $password, $dbName) or die();

?>