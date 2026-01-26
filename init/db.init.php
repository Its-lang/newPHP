<?php

$host = '127.0.0.1';
$db = 'php-lesson-private-db';
$username = 'root';
$password = '';
$port = 3306;

$conn = new mysqli($host, $username, $password, $db, $port);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
