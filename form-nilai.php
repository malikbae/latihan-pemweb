<?php

include 'koneksi.php';

$nim = "";
$nama = "";
$mata_kuliah = "";
$nilai = "";

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
        $sql_read = "SELECT * FROM nilai WHERE id = '$id'";
        $query_read = mysqli_query($koneksi, $sql_read);
        $read = mysqli_fetch_array($query_read);

        if ($read) {
            $id_mahasiswa = $read['id_mahasiswa'];
            $mata_kuliah = $read['mata_kuliah'];
            $nilai = $read['nilai'];

            $sql_mahasiswa = "SELECT nim FROM mahasiswa WHERE id = '$id_mahasiswa'";
            $query_mahasiswa = mysqli_query($koneksi, $sql_mahasiswa);
            $data_mahasiswa = mysqli_fetch_assoc($query_mahasiswa);
            
            if ($data_mahasiswa) {
                $nim = $data_mahasiswa['nim'];
            } else {
                $error = "Data mahasiswa tidak ditemukan";
            }
        } else {
            $error = "Data tidak ditemukan";
        }
    }
}

if (isset($_POST['save'])) { // Create Data
    $nim = $_POST['nim'];
    $mata_kuliah = $_POST['mata_kuliah'];
    $nilai = $_POST['nilai'];

    if ($nim && $mata_kuliah && $nilai) {

        if ($action == 'edit') {
            $sql_update = "UPDATE nilai SET id_mahasiswa = (SELECT id FROM mahasiswa WHERE nim = '$nim'), mata_kuliah = '$mata_kuliah', nilai = '$nilai' WHERE id = '$id'";
            $query_update = mysqli_query($koneksi, $sql_update);

            if ($query_update) {
                $success = "Data berhasil diupdate";
            } else {
                $error = "Data gagal diupdate";
            }
        } else {
            $sql = "INSERT INTO nilai (id_mahasiswa, mata_kuliah, nilai) values ((SELECT id FROM mahasiswa WHERE nim = '$nim'), '$mata_kuliah', '$nilai')";
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
                    header("refresh:3;url=nilai.php");        
                }
                ?>

                <?php
                if ($success) {
                    ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $success ?>
                        </div>
                    <?php
                    header("refresh:3;url=nilai.php");         
                }
                ?>
                
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM</label>
                        <select class="form-control" name="nim" id="nim">
                            <?php
                            $query = "SELECT nim FROM mahasiswa";
                            $result = mysqli_query($koneksi, $query);
                            
                            while ($row = mysqli_fetch_assoc($result)) {
                                $selected = ($nim == $row['nim']) ? "selected" : "";
                                echo '<option value="' . $row['nim'] . '" ' . $selected . '>' . $row['nim'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="mata_kuliah" class="form-label">Mata Kuliah</label>
                        <input type="text" class="form-control" id="mata_kuliah" name="mata_kuliah" value="<?php echo $mata_kuliah ?>">
                    </div>
                    <div class="mb-3">
                        <label for="nilai" class="form-label">Nilai</label>
                        <select class="form-control" name="nilai" id="nilai">
                            <option value="">Pilih Nilai</option>
                            <option value="A" <?php if ($nilai == "A") echo "selected" ?>>A</option>
                            <option value="B" <?php if ($nilai == "B") echo "selected" ?>>B</option>
                            <option value="C" <?php if ($nilai == "C") echo "selected" ?>>C</option>
                            <option value="D" <?php if ($nilai == "D") echo "selected" ?>>D</option>
                            <option value="E" <?php if ($nilai == "E") echo "selected" ?>>E</option>
                        </select>
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