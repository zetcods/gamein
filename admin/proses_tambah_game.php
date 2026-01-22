<?php
session_start();
include '../config/koneksi.php';

if (isset($_POST['judul'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $url = mysqli_real_escape_string($conn, $_POST['download_url']);
    $desk = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $req = mysqli_real_escape_string($conn, $_POST['requirements']);
    
    $foto = time() . "_" . $_FILES['gambar']['name'];
    if (move_uploaded_file($_FILES['gambar']['tmp_name'], "../assets/images/" . $foto)) {
        mysqli_query($conn, "INSERT INTO games (judul, genre, gambar, download_url, deskripsi, requirements) 
                    VALUES ('$judul', '$genre', '$foto', '$url', '$desk', '$req')");
        header("Location: games_manage.php");
    }
}