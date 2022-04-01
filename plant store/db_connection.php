<?php

$serverName = "localhost";
$usernameDB = "root";
$passwordDB = "root";
$dbName = "plantstoredb";

$connection = mysqli_connect($serverName, $usernameDB, $passwordDB,$dbName);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
?>