<?php

include 'koneksi.php';

$success = "";
$error = "";

if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = '';
}

if ($action == 'delete') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql_delete = "DELETE FROM mahasiswa WHERE id = '$id'";
        $query_delete = mysqli_query($koneksi, $sql_delete);
        if ($query_delete) {
            $success = "Berhasil menghapus data";
        } else {
            $error = "Gagal menghapus data";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latihan Pemrograman Web</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px;
        }
        .card {
            margin-top:10px;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary mb-4">
        <div class="container-fluid">
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php">Data Mahasiswa</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="nilai.php">Data Nilai</a>
                </li>
            </ul>
            </div>
        </div>
    </nav>
    
    <div class="mx-auto">
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Mahasiswa
            </div>
            <div class="card-body">
                
                <a href="form.php"><button type="button" class="btn btn-primary">Tambah Data</button></a>

                <?php
                if ($error) {
                    ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error ?>
                        </div>
                    <?php
                    header("refresh:3;url=index.php");        
                }
                ?>

                <?php
                if ($success) {
                    ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $success ?>
                        </div>
                    <?php
                    header("refresh:3;url=index.php");         
                }
                ?>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NIM</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Fakultas</th>
                            <th scope="col">Jurusan</th>
                            <th scope="col">Aksi</th>
                        </tr>
                        <tbody>
                            <?php 
                            $sql_read = "SELECT * FROM mahasiswa ORDER BY id desc";
                            $query_read = mysqli_query($koneksi, $sql_read);

                            $number = 1;

                            while ($r2 = mysqli_fetch_array($query_read)) {
                                $id = $r2["id"];
                                $nim = $r2["nim"];
                                $nama = $r2["nama"];
                                $fakultas = $r2["fakultas"];
                                $jurusan = $r2["jurusan"];

                                ?>
                                <tr>
                                    <th scope="row"><?php echo $number++ ?></th>
                                    <td scope="row"><?php echo $nim ?></td>
                                    <td scope="row"><?php echo $nama ?></td>
                                    <td scope="row"><?php echo $fakultas ?></td>
                                    <td scope="row"><?php echo $jurusan ?></td>
                                    <td scope="row">
                                        <a href="form.php?action=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                        <a href="index.php?action=delete&id=<?php echo $id ?>" onclick="return confirm('Yakin ingin menghapus data?')"><button type="button" class="btn btn-danger">Delete</button></a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>

</body>
</html>