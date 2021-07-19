<?php
require 'functions.php';
$id = $_GET['id']; //ambil id dari URL

$m = query("Select * from mahasiswa where id =$id"); //query mahasiswa berdasarkan id yg diambil dari URL
// var_dump($m['nama']); //cek test munculkan data
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Mahasiswa</title>
</head>

<body>
  <h3>Detail Mahasiswa</h3>
  <ul>
    <li><img src="img/<?= $m['gambar']; ?>" width="100"></li>
    <li>NRP : <?= $m['nrp']; ?></li>
    <li>NAMA : <?= $m['nama']; ?></li>
    <li>EMAIL : <?= $m['email']; ?></li>
    <li>JURUSAN : <?= $m['jurusan']; ?></li>
    <li><a href="">Ubah</a> | <a href="">Hapus</a></li>
    <li><a href="latihan3.php">Kembali ke Daftar Mahasiswa</a> </li>
  </ul>
</body>

</html>