<?php

// Create connection
$database = "webprog";
$user = $password = "webprog";
$host = "mysql";
$conn = mysqli_connect($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// define variables
define('BASE_URL', 'http://localhost/twitter-final-project/project/');  // the home url of the website
date_default_timezone_set("UTC");

// start session
session_start();