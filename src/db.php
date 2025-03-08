<?php

$servername = "MySQL-8.2";
$username = "root";
$password = "";
$dbname = "loginUser";

$conn = mysqli_connect($servername,$username, $password, $dbname);

if(!$conn){
    die("Connection Filed". mysqli_connect_error());
} else{
    "Успех";
} ?>