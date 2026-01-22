<?php
$conn = mysqli_connect("localhost", "root", "", "db_gamein");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>