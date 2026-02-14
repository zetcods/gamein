<?php
$host = getenv('MYSQL_HOST') ?: 'localhost';
$user = getenv('MYSQL_USER') ?: 'root';
$pass = getenv('MYSQL_PASSWORD') ?: '';
$db   = getenv('MYSQL_DATABASE') ?: 'db_gamein';
$port = getenv('MYSQL_PORT') ?: '3306';

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("Waduh, koneksi database gagal bro: " . mysqli_connect_error());
}
?>