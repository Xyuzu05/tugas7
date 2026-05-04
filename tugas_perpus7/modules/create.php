<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];
    $tanggal_lahir = $_POST['tanggal_lahir'];

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email tidak valid");
    }

    // Validasi telepon
    if (!preg_match("/^08[0-9]{8,11}$/", $telepon)) {
        die("Telepon tidak valid");
    }

    // Validasi umur
    $umur = date('Y') - date('Y', strtotime($tanggal_lahir));
    if ($umur < 10) {
        die("Minimal umur 10 tahun");
    }

    // Upload foto
    $foto = null;
    if ($_FILES['foto']['name']) {
        $foto = time() . "_" . $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/" . $foto);
    }

    $stmt = $conn->prepare("INSERT INTO anggota 
    (kode_anggota,nama,email,telepon,alamat,tanggal_lahir,jenis_kelamin,pekerjaan,tanggal_daftar,status,foto)
    VALUES (?,?,?,?,?,?,?,?,CURDATE(),'Aktif',?)");

    $stmt->bind_param("sssssssss",
        $_POST['kode'],
        $nama,
        $email,
        $telepon,
        $_POST['alamat'],
        $tanggal_lahir,
        $_POST['jk'],
        $_POST['pekerjaan'],
        $foto
    );

    $stmt->execute();

    header("Location: index.php?msg=berhasil");
}
?>