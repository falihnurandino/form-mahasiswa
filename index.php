<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'crud-mahasiswa';

$koneksi = mysqli_connect($host, $user, $pass, $db);

$nim = "";
$nama = "";
$alamat = "";
$fakultas = "";
$sukses = "";
$error = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1 = "delete from mahasiswa where id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Data berhasil dihapus";
    } else {
        $error = "Data gagal dihapus";
    }
}

if ($op == 'edit') {
    $id = $_GET['id'];
    $sql1 = "select * from mahasiswa where id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);
    $nim = $r1['nim'];
    $nama = $r1['nama'];
    $alamat = $r1['alamat'];
    $fakultas = $r1['fakultas'];

    if ($nim == '') {
        $error = "Data tidak ditemukan";
    }
}

if (isset($_POST['submit'])) { // create
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $fakultas = $_POST['fakultas'];

    if ($nim && $nama && $alamat && $fakultas) {
        if ($op == 'edit') {
            $sql1 = "update mahasiswa set nim = '$nim', nama = '$nama', alamat = '$alamat', fakultas = '$fakultas' where id = '$id' ";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error = "Data gagal diupdate";
            }
        } else { // insert
            $sql1 = "insert into mahasiswa(nim, nama, alamat, fakultas) values ('$nim', '$nama', '$alamat', '$fakultas')";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Berhasil memasukkan data baru";
            } else {
                $error = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silahkan masukkan data";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <title>Data Mahasiswa</title>
    <style>
        .mx-auto {
            width: 800px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <div class="card m-3">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $error ?>
                    </div>
                <?php
                    header("refresh:3;url=index.php");
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?= $sukses ?>
                    </div>
                <?php
                    header("refresh:3;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="nim" class="col-sm-2 col-form-label">NIM</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nim" name="nim" value="<?= $nim ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= $nama ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?= $alamat ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="fakultas" class="col-sm-2 col-form-label">Fakultas</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="fakultas" id="fakultas">
                                <option value="">-- Pilih Fakultas --</option>
                                <option value="Teknologi Informasi" <?php if ($fakultas == "Teknologi Informasi") echo "selected" ?>>Teknologi Informasi</option>
                                <option value="Hukum" <?php if ($fakultas == "Hukum") echo "selected" ?>>Hukum</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <input type="submit" name="submit" value="Simpan Data" class="btn btn-primary">
                    </div>

                </form>
            </div>
        </div>

        <div class="card m-3">
            <div class="card-header">
                Data Mahasiswa
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Fakultas</th>
                            <th>Aksi</th>
                        </tr>
                    <tbody>
                        <?php
                        $sql2 = "select * from mahasiswa order by id desc";
                        $q2 = mysqli_query($koneksi, $sql2);
                        $urut = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id = $r2['id'];
                            $nim = $r2['nim'];
                            $nama = $r2['nama'];
                            $alamat = $r2['alamat'];
                            $fakultas = $r2['fakultas'];

                        ?>
                            <tr>
                                <th><?= $urut++ ?></th>
                                <td><?= $nim ?></td>
                                <td><?= $nama ?></td>
                                <td><?= $alamat ?></td>
                                <td><?= $fakultas ?></td>
                                <td>
                                    <a href="index.php?op=edit&id=<?= $id ?>">
                                        <button type="button" class="btn btn-warning">Edit</button>
                                    </a>
                                    <a href="index.php?op=delete&id=<?= $id ?>" onclick="confirm('Yakin mau hapus data?')">
                                        <button type="button" class="btn btn-danger">Delete</button>
                                    </a>

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