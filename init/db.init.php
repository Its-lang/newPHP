<?php

$host = 'localhost';
$db = 'php-lesson-private-db';
$username = 'root';
$password = '';
$port = 3306;

$conn = new mysqli($host, $username, $password, $db, $port);

if (!$conn) {
    echo 'could not connect'
        . mysqli_error();
}
?>