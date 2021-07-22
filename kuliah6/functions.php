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

function upload()
{
  // var_dump($_FILES);
  // die;

  $nama_file = $_FILES['gambar']['name'];
  $type_file = $_FILES['gambar']['type'];
  $ukuran_file = $_FILES['gambar']['size'];
  $error = $_FILES['gambar']['error'];
  $tmp_file = $_FILES['gambar']['tmp_name'];

  //ketika tidak ada gambar yg di pilih
  if ($error == 4) {
    // echo "
    //   <script>
    //     alert('pilih gambar terlebih dahulu!');
    //   </script>
    // ";
    return "no_photo.jpg";
  }
  //cek extensi file
  $daftar_gambar = ['jpg', 'jpeg', 'png'];
  $ekstensi_file = explode('.', $nama_file);
  $ekstensi_file = strtolower(end($ekstensi_file));
  // var_dump($ekstensi_file);
  // die;

  if (!in_array($ekstensi_file, $daftar_gambar)) {
    echo "
      <script>
        alert('yang anda pilih bukan gambar!');
      </script>
    ";
    return false;
  }

  //cek tipe file
  //untuk menghindari script jahat
  // var_dump($type_file);
  // die;
  if ($type_file != 'image/jpeg' && $type_file != 'image/png') {
    echo "
    <script>
      alert('yang anda pilih bukan type gambar!');
    </script>
  ";
    return false;
  }


  //cek ukuran file
  //maksimal 5 mb = 5000000
  if ($ukuran_file > 5000000) {
    echo "
    <script>
      alert('ukuran file terlalu besar!');
    </script>
  ";
    return false;
  }

  //lolos pengecekan siap upload file
  //generate nama file gambar baru
  $nama_file_baru = uniqid();
  // var_dump($nama_file_baru);
  // die;

  $nama_file_baru .= '.';
  $nama_file_baru .= $ekstensi_file;
  // var_dump($nama_file_baru);
  // die;

  move_uploaded_file($tmp_file, 'img/' . $nama_file_baru);
  return $nama_file_baru;
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
  // $gambar = htmlspecialchars($data['gambar']);


  // upload gambar
  $gambar = upload();

  if (!$gambar) {
    return false;
  }

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
  //menghapus gambar di folder img
  $mhs = query("select * from mahasiswa where id = $id");
  if ($mhs['gambar'] != 'no_photo.jpg') {

    unlink('img/' . $mhs['gambar']);
  }
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
  $gambar_lama = htmlspecialchars($data['gambar_lama']);

  $gambar = upload();
  if (!$gambar) {
    return false;
  }

  if ($gambar == 'no_photo.jpg') {
    $gambar = $gambar_lama;
  }

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

function login($data)
{
  $conn = koneksi();
  $username = htmlspecialchars($data['username']);
  $password = htmlspecialchars($data['password']);

  //cek dulu usernamenya
  if ($user = query("Select * from user where username ='$username'")) {
    //cek password
    if (password_verify($password, $user['password'])) {

      $_SESSION['login'] = true;
      header("location: index.php");
      exit;
    }
  }
  return [
    'error' => true,
    'pesan' => 'Username / Password salah!'
  ];
}

function registrasi($data)
{
  $conn = koneksi();

  $username = htmlspecialchars(strtolower($data['username']));
  $password1 = mysqli_real_escape_string($conn, $data['password1']);
  $password2 = mysqli_real_escape_string($conn, $data['password2']);

  // var_dump($username);
  if (empty($username) || empty($password1) || empty($password2)) {
    echo "
    <script>
    alert('username / password tidak boleh kosong!');
    document.location.href='registrasi.php';
    </script>
    ";
    return false;
  }

  //jika username sudah ada
  if (query("SELECT * FROM user WHERE username ='$username'")) {
    echo "
    <script>
    alert('username sudah terdaftar');
    document.location.href='registrasi.php';
    </script>
    ";
    return false;
  }

  //jika konfirmasi password tidak sesuai
  if ($password1 !== $password2) {
    echo "
    <script>
    alert('konfirmasi password tidak sesuai');
    document.location.href='registrasi.php';
    </script>
    ";
    return false;
  }

  //jika password < 5 digit
  if (strlen($password1) < 5) {
    echo "
    <script>
    alert('Password terlalu pendek!');
    document.location.href='registrasi.php';
    </script>
    ";
    return false;
  }

  // jika username dan passwordnya sudah seesuai
  //enskripsi password 
  $password_baru = password_hash($password1, PASSWORD_DEFAULT);
  //insert ke table user

  $query = "INSERT INTO user
    VALUES
    (null, '$username', '$password_baru')
  ";
  mysqli_query($conn, $query) or die(mysqli_error($conn));
  return mysqli_affected_rows($conn);
}
