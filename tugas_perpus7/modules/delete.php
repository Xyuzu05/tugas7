<?php
include 'config.php';

if (!isset($_GET['id'])) {
    die("ID tidak ditemukan");
}

$id = $_GET['id'];

// Ambil data dulu
$stmt = $conn->prepare("SELECT foto FROM anggota WHERE id_anggota=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Data tidak ada");
}

// Hapus foto
if ($data['foto'] && file_exists("uploads/" . $data['foto'])) {
    unlink("uploads/" . $data['foto']);
}

// Hapus data
$stmt = $conn->prepare("DELETE FROM anggota WHERE id_anggota=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: index.php?msg=hapus");
?>