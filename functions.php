<?php 
$conn = mysqli_connect('localhost', 'root', '', 'crud_php');

function query ($query) {
    
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result) ) {
        $rows[] = $row;
    }
    return $rows; 
}


function tambah($post) {
    global $conn;
    $nrp = htmlspecialchars($post['nrp']);
    $nama = htmlspecialchars($post['nama']);
    $email = htmlspecialchars($post['email']);
    $jurusan = htmlspecialchars($post['jurusan']);
    // $gambar = htmlspecialchars($post['gambar']);

    $gambar = upload ();
    if (!$gambar) {
        return false;
    }

    $query = "INSERT INTO mahasiswa VALUES ('', '$nama', '$nrp', '$email', '$jurusan', '$gambar')";
    mysqli_query($conn,$query);

    return mysqli_affected_rows($conn);
}

function upload () {
    $namaFile = $_FILES["gambar"]["name"];
    $ukuranFile = $_FILES["gambar"]["size"];
    $error = $_FILES["gambar"]["error"];
    $tmpName = $_FILES["gambar"]["tmp_name"];

    if ($error === 4) {
        echo "
        <script>
            alert ('Pilih Gambar Dahulu');
        </script>";
    }
    $ekstensiValid = ['jpg', 'jpeg', 'png'];
    $ekstensigambar = explode ('.', $namaFile);
    $ekstensigambar = strtolower (end($ekstensigambar));

    if (!in_array($ekstensigambar, $ekstensiValid)) {
        echo "
        <script>
        alert ('file yang diupload bukan gambar');
        </script>";
        return false;
    }
    if ($ukuranFile > 2000000) {
        echo "
        <script>
        alert ('maaf ukuran gambar terlalu besar');
        </script>";
        return false;
    }
    $namafileBaru = uniqid();
    $namafileBaru .= '.';
    $namafileBaru .= $ekstensigambar;

    move_uploaded_file ($tmpName, 'img/' .  $namafileBaru);
    return $namafileBaru;
}

function hapus($id) {
    global $conn;
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");

    return mysqli_affected_rows($conn);
}

function ubah($post){
    global $conn;

    $id = $post['id'];
    $nrp = htmlspecialchars($post['nrp']);
    $nama = htmlspecialchars($post['nama']);
    $email = htmlspecialchars($post['email']);
    $jurusan = htmlspecialchars($post['jurusan']);
    $gambarLama = htmlspecialchars($post['gambarLama']);
    
    // cek upload gambar baru tidak
    if ($_FILES["gambar"]["error"] === 4 ) {
        $gambar = $gambarLama;
    } else {
        $gambar = upload();
    }

    $query = "UPDATE mahasiswa SET 
                nrp = '$nrp', 
                nama = '$nama', 
                email = '$email',
                jurusan = '$jurusan',
                gambar = '$gambar'
            WHERE id = $id
                ";
    mysqli_query($conn,$query);

    return mysqli_affected_rows($conn);
}

function cari($keyword) {
    $query = "SELECT * FROM mahasiswa
                WHERE 
                nama LIKE '%$keyword%' OR
                nrp LIKE '%$keyword%' OR
                email LIKE '%$keyword%' OR 
                jurusan LIKE '%$keyword%'
                ";
    return query($query);
}

function register($post){
    global $conn;

    $username = strtolower(stripslashes($post["username"]));
    $password = mysqli_real_escape_string($conn, $post["password"]);
    $password2 = mysqli_real_escape_string($conn, $post["password2"]);

    //cek username sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if(mysqli_fetch_assoc($result) ){
        echo "<script>
                alert('username sudah terdaftar');
            </script>";
    }

    //cek konfirmasi password 
    if ($password !== $password2) {
        echo "<script>
                alert('konfirmasi password tidak sesuai');
            </script>";
        return false;
    }

    //enkripsi password 
    $password = password_hash($password, PASSWORD_DEFAULT);

    //tambahkan user baru ke database
    mysqli_query($conn, "INSERT INTO user VALUES ('', '$username', '$password')");

    return mysqli_affected_rows($conn);
}
?>