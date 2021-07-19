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

function tambah($data)
{
  // var_dump($data);
  $conn = koneksi();

  $nama = htmlspecialchars($data['nama']);
  // $nama = $data['nama'];
  $nrp = htmlspecialchars($data['nrp']);
  $email = htmlspecialchars($data['email']);
  $jurusan = htmlspecialchars($data['jurusan']);
  $gambar = htmlspecialchars($data['gambar']);

  $query = "INSERT INTO 
      mahasiswa
      VALUES
      (null, '$nama', '$nrp', '$email','$jurusan','$gambar')
      ";
  mysqli_query($conn, $query);
  echo mysqli_error($conn);
  return mysqli_affected_rows($conn);
}

function hapus($id)
{
  $conn = koneksi();
  mysqli_query($conn, "DELETE FROM mahasiswa where id=$id") or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}

function ubah($data)
{
  // var_dump($data);
  $conn = koneksi();
  $id = $data['id'];
  $nama = htmlspecialchars($data['nama']);
  // $nama = $data['nama'];
  $nrp = htmlspecialchars($data['nrp']);
  $email = htmlspecialchars($data['email']);
  $jurusan = htmlspecialchars($data['jurusan']);
  $gambar = htmlspecialchars($data['gambar']);

  $query = "UPDATE mahasiswa SET
      nama = '$nama',
      nrp = '$nrp',
      email = '$email',
      jurusan = '$jurusan',
      gambar = '$gambar'
      WHERE id=$id";
  mysqli_query($conn, $query);
  echo mysqli_error($conn);
  return mysqli_affected_rows($conn);
}

function cari($keyword)
{
  $conn = koneksi();
  $query = "SELECT * FROM mahasiswa
      WHERE 
      nama LIKE '%$keyword%' OR
      nrp LIKE '%$keyword%' OR
      email LIKE '%$keyword%' OR
      jurusan LIKE '%$keyword%' ";

  $result = mysqli_query($conn, $query);
  //jika hasil danya banyak jalankan ini
  $rows = []; // array kosong
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row; // row looping akan masuk ke array kosong $rows

  }
  return $rows;
}
