<?php 
session_start();

if (!isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}
require 'functions.php';
$mahasiswa= query("SELECT * FROM mahasiswa");

//jka tombol ditekan
if (isset($_POST['cari'])) {
    $mahasiswa = cari($_POST["keyword"]);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
</head>
<body>
    <a href="logout.php">Logout</a>
    <h1>Daftar Mahasiswa</h1>
    <a href="tambah.php">Tambah Data Mahasiswa</a>
    <br><br>
    <form action="" method="post">
        <input type="text" name="keyword" size="35" autofocus placeholder="masukkan keyword yang dicari...." autocomplete="off">
        <button type="submit" name="cari">Cari</button>
    </form>
    <br>
    <table border="1" cellpadding="10" cellspasing="10">
        <tr>
            <th>No.</th>
            <th>Action</th>
            <th>Gambar</th>
            <th>NRP</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Jurusan</th>
        </tr>
        <?php $i = 1; ?>
        <?php foreach($mahasiswa as $row) : ?>
        <tr>
            <td><?= $i;?></td>
            <td>
                <a href="ubah.php?id=<?= $row['id']; ?>">ubah</a> |
                <a href="hapus.php?id=<?= $row['id']; ?>" onclick="return confirm('yakin mau dihapus?')">hapus</a>
            </td>
            <td><img src="img/<?= $row['gambar']; ?>" alt=""  width="100"></td>
            <td><?= $row['nrp'];?></td>
            <td><?= $row['nama'];?></td>
            <td><?= $row['email'];?></td>
            <td><?= $row['jurusan'];?></td>
        </tr>
        <?php $i++; ?>
        <?php endforeach; ?>
    </table>
</body>
</html>