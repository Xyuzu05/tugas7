<?php
include 'config.php';

$id = $_GET['id'];

$data = $conn->query("SELECT * FROM anggota WHERE id_anggota=$id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $foto = $data['foto'];

    if ($_FILES['foto']['name']) {
        $foto = time() . "_" . $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/" . $foto);
    }

    $stmt = $conn->prepare("UPDATE anggota SET
        nama=?, email=?, telepon=?, alamat=?, foto=?
        WHERE id_anggota=?");

    $stmt->bind_param("sssssi",
        $_POST['nama'],
        $_POST['email'],
        $_POST['telepon'],
        $_POST['alamat'],
        $foto,
        $id
    );

    $stmt->execute();

    header("Location: index.php?msg=update");
}
?>