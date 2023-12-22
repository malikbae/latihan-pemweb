<?php

include 'koneksi.php';

$nim = "";
$nama = "";
$fakultas = "";
$jurusan = "";

$success = "";
$error = "";

if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = '';
}

if ($action == 'edit') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql_read = "SELECT * FROM mahasiswa WHERE id = '$id'";
        $query_read = mysqli_query($koneksi, $sql_read);
        $read = mysqli_fetch_array($query_read);

        if ($read) {
            $nim = $read['nim'];
            $nama = $read['nama'];
            $fakultas = $read['fakultas'];
            $jurusan = $read['jurusan'];
        } else {
            $error = "Data tidak ditemukan";
        }
    }
}

if (isset($_POST['save'])) { // Create Data
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $fakultas = $_POST['fakultas'];
    $jurusan = $_POST['jurusan'];

    if ($nim && $nama && $fakultas && $jurusan) {

        if ($action == 'edit') {
            $sql_update = "UPDATE mahasiswa SET nim = '$nim', nama = '$nama', fakultas = '$fakultas', jurusan = '$jurusan' WHERE id = '$id'";
            $query_update = mysqli_query($koneksi, $sql_update);

            if ($query_update) {
                $success = "Data berhasil diupdate";
            } else {
                $error = "Data gagal diupdate";
            }
        } else {
            $sql = "INSERT INTO mahasiswa (nim, nama, fakultas, jurusan) values ('$nim', '$nama', '$fakultas', '$jurusan')";
            $query = mysqli_query($koneksi, $sql);

            if ($query) {
                $success = "Berhasil memasukkan data baru";
            } else {
                $error = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silahkan masukkan semua data";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Data Mahasiswa</title>
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

    <div class="mx-auto">
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">

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
                
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $nim ?>">
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                    </div>
                    <div class="mb-3">
                        <label for="fakultas" class="form-label">Fakultas</label>
                        <select class="form-control" name="fakultas" id="fakultas">
                            <option value="">Pilih Fakultas</option>
                            <option value="teknik" <?php if ($fakultas == "teknik") echo "selected" ?>>Teknik</option>
                            <option value="soshum" <?php if ($fakultas == "soshum") echo "selected" ?>>Soshum</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jurusan" class="form-label">Jurusan</label>
                        <input type="text" class="form-control" id="jurusan" name="jurusan" value="<?php echo $jurusan ?>">
                    </div>
                    <div class="col-12">
                        <input type="submit" name="save" value="Simpan Data" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>