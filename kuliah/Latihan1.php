<?php
//#koneksi db & pilih db
$conn = mysqli_connect('localhost', 'root', '', 'pw_043040023');

//#query isi table mahasiswa
$result = mysqli_query($conn, "Select * from mahasiswa");

//var_dump($result);  //untuk melihat data objectnya

//#ubah data ke dalam array

//$row = mysqli_fetch_row($result); //array numeric
//$row = mysqli_fetch_assoc($result); //array assoc
//$row = mysqli_fetch_array($result); //array assoc & array numeric

//kita biasanya pakai yang assoc
//$row = mysqli_fetch_assoc($result);
//var_dump($row); //untuk melihat data objectnya
//kalau pakai cara yg di atas hanya ada 1. supaya terlihat supaya semuanya kita harus looping
$rows = []; // array kosong
while ($row = mysqli_fetch_assoc($result)) {
  $rows[] = $row; // row looping akan masuk ke array kosong $rows
}
//var_dump($row); //untuk melihat data objectnya

// #tampung ke variable
$mahasiswa = $rows;

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Mahasiswa</title>
</head>

<body>
  <h3>Daftar Mahasiswa</h3>
  <table border="1px" cellpadding="10" cellspasing="0">
    <tr>
      <th>#</th>
      <th>Gambar</th>
      <th>NRP</th>
      <th>Nama</th>
      <th>Email</th>
      <th>Jurusan</th>
      <th>Aksi</th>
    </tr>
    <?php $i = 1;
    foreach ($mahasiswa as $m) : ?>
      <tr>
        <td><?= $i++; ?></td>
        <td><img src="img/<?= $m['gambar']; ?>" width="70px"></td>
        <td><?= $m['nrp']; ?></td>
        <td><?= $m['nama']; ?></td>
        <td><?= $m['email']; ?></td>
        <td><?= $m['jurusan']; ?></td>
        <td>
          <a href="">Ubah</a> |
          <a href="">Hapus</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>

</html>