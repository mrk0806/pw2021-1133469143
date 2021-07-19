<?php
function koneksi()
{
  //#koneksi db & pilih db
  return mysqli_connect('localhost', 'root', '', 'pw_043040023');
}

function query($query)
{
  $conn = koneksi(); // ambil function koneksi di atas
  $result = mysqli_query($conn, $query); // variabel $query ambil dari parimeter

  //jika hasil datanya sama dengan 1 pakai mysql num rows
  if (mysqli_num_rows($result) == 1) {
    return mysqli_fetch_assoc($result);
  }


  //jika hasil danya banyak jalankan ini
  $rows = []; // array kosong
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row; // row looping akan masuk ke array kosong $rows

  }

  return $rows;
}
