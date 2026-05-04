<?php
$conn = new mysqli("localhost", "root", "", "perpus_tugas7");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>