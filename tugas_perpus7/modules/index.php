<?php
include 'config.php';

$search = $_GET['search'] ?? '';

$stmt = $conn->prepare("SELECT * FROM anggota 
    WHERE nama LIKE ? OR email LIKE ? OR telepon LIKE ?");

$searchTerm = "%$search%";
$stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Anggota</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-primary">
  <div class="container">
    <span class="navbar-brand">
      <i class="bi bi-book"></i> Sistem Perpustakaan
    </span>
  </div>
</nav>

<div class="container mt-4">

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <h3><i class="bi bi-people"></i> Data Anggota</h3>

    <div>
        <a href="create.php" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah
        </a>
    </div>
</div>

<!-- SEARCH -->
<form method="GET" class="mb-3">
    <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Cari..." value="<?= $search ?>">
        <button class="btn btn-primary">
            <i class="bi bi-search"></i>
        </button>
    </div>
</form>

<!-- CARD -->
<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <i class="bi bi-list"></i> Daftar Anggota
    </div>

    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
            <?php $no=1; while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $no++ ?></td>

                    <td>
                        <span class="badge bg-info text-dark">
                            <?= $row['kode_anggota'] ?>
                        </span>
                    </td>

                    <td><?= $row['nama'] ?></td>

                    <td>
                        <i class="bi bi-envelope"></i>
                        <?= $row['email'] ?>
                    </td>

                    <td>
                        <i class="bi bi-telephone"></i>
                        <?= $row['telepon'] ?>
                    </td>

                    <td>
                        <span class="badge bg-<?= $row['status']=='Aktif' ? 'success' : 'danger' ?>">
                            <?= $row['status'] ?>
                        </span>
                    </td>

                    <td>
                        <a href="edit.php?id=<?= $row['id_anggota'] ?>" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <a href="delete.php?id=<?= $row['id_anggota'] ?>" 
                           onclick="return confirm('Yakin hapus?')" 
                           class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>

        </table>
    </div>

    <div class="card-footer">
        Total: <?= $result->num_rows ?> anggota
    </div>
</div>

</div>

</body>
</html>