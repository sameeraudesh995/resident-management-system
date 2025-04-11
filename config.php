<?php
$host = 'localhost';
$user = 'root';
$password = '12345';
$database = 'resident_database';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>