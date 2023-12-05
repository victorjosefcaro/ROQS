<?php

$server = "localhost";
$user = "root";
$password = "";
$db = "roqsmain";

//  from swiss_collection to new database roqsmain 
$conn = mysqli_connect($server,$user,$password,$db);

if(!$conn) {
    die("Connection Failed:".mysqli_connect_error());
}

?>