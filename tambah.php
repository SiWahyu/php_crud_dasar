<?php 

session_start();

if (!isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}

require 'functions.php';
if(isset($_POST['submit']) ){
    if (tambah($_POST) > 0){
        echo "
        <script>
        alert('data berhasil disimpan!');
        document.location.href = 'index.php';
        </script>";
    }else {
        echo "
        <script>
        alert('data gagal disimpan!');
        document.location.href = 'index.php';
        </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TambahData</title>
</head>
<body>
    <h1>Tambah Data Mahasiswa</h1>

    <form action="" method="POST" enctype="multipart/form-data">
        <ul>
            <li>
                <label for='nrp'>NRP :</label>
                <input type="text" name='nrp' id='nrp' required>
            </li>
            <li>
                <label for='nama'>Nama :</label>
                <input type="text" name='nama' id='nama' required>
            </li>
            <li>
                <label for='email'>Email :</label>
                <input type="text" name='email' id='email'>
            </li>
            <li>
                <label for='jurusan'>Jurusan :</label>
                <input type="text" name='jurusan' id='jurusan'>
            </li>
            <li>
                <label for='gambar'>Gambar :</label>
                <input type="file" name='gambar' id='gambar'>
            </li>
            <button type="submit" name="submit">save</button>
        </ul>
    </form>
</body>
</html>