<?php

$host = "localhost";
$dbname = "webdev_act";
$username = "root";
$password = "";

$mysqli = new mysqli($host,$username,$password,$dbname);
                     
if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

$mysqli->query("ALTER TABLE users ADD COLUMN IF NOT EXISTS role ENUM('admin', 'client') DEFAULT 'client'");

return $mysqli;
?>