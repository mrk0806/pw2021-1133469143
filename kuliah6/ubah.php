<?php

session_start();
if (!isset($_SESSION['login'])) {
  header("location: login.php");
  exit;
}

require 'functions.php';

//jika tidak ada id di url
if (!isset($_GET['id'])) {
  header("location: index.php");
  exit;
}

//ambil id dari url
$id = $_GET['id'];

// query mahasiswa berdasarkan id
$m = query("Select * from mahasiswa where id=$id");
// var_dump($m);

//cek apakah tombol ubah di tekan blm
if (isset($_POST['ubah'])) {
  if (ubah($_POST) > 0) {
    echo "<script>
      alert('data berhasil diubah');
      document.location.href='index.php';
    </script>";
  } else {
    echo " data gagal diubah";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ubah Data Mahasiswa</title>
</head>

<body>
  <h3>Form Ubah Data Mahasiswa</h3>
  <form action="" method="POST">
    <input type="hidden" name="id" value="<?= $m['id']; ?>">
    <ul>
      <li>
        <label>
          NAMA :
          <input type="text" name="nama" value="<?= $m['nama']; ?>" autofocus required>
        </label>
      </li>
      <li>
        <label>
          NRP :
          <input type="text" name="nrp" value="<?= $m['nrp']; ?>" required>
        </label>
      </li>
      <li>
        <label>
          EMAIL :
          <input type="text" name="email" value="<?= $m['email']; ?>" required>
        </label>
      </li>
      <li>
        <label>
          JURUSAN :
          <input type="text" name="jurusan" value="<?= $m['jurusan']; ?>" required>
        </label>
      </li>
      <li>
        <label>
          GAMBAR :
          <input type="text" name="gambar" value="<?= $m['gambar']; ?>" required>
        </label>
      </li>
      <li>
        <button type="submit" name="ubah">Ubah Data!</button>
      </li>
    </ul>
  </form>
</body>

</html>