<?php
session_start();
include '../config/koneksi.php';

// Proteksi: Pastikan yang akses beneran Admin yang udah login
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

if (isset($_POST['judul'])) {
    // Ambil ID admin dari session (ini kunci biar nama lo muncul di detail)
    $id_admin = $_SESSION['id_user']; 
    
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $url   = mysqli_real_escape_string($conn, $_POST['download_url']);
    $desk  = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $req   = mysqli_real_escape_string($conn, $_POST['requirements']);
    
    // Penamaan file gambar biar unik
    $foto = time() . "_" . str_replace(' ', '_', $_FILES['gambar']['name']);
    
    if (move_uploaded_file($_FILES['gambar']['tmp_name'], "../assets/images/" . $foto)) {
        // Masukin id_admin ke kolom id_admin di database
        $query = "INSERT INTO games (judul, genre, gambar, download_url, deskripsi, requirements, id_admin) 
                  VALUES ('$judul', '$genre', '$foto', '$url', '$desk', '$req', '$id_admin')";
        
        if (mysqli_query($conn, $query)) {
            header("Location: games_manage.php?status=success");
        } else {
            echo "Error Database: " . mysqli_error($conn);
        }
    } else {
        echo "Gagal upload gambar!";
    }
} else {
    header("Location: games_manage.php");
}