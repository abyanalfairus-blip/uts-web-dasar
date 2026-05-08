<?php
include 'koneksi.php';
if (isset($_POST['simpan'])) {
    $id = $_POST['id']; $nim = $_POST['nim']; $nama = $_POST['nama_lengkap'];
    $jurusan = $_POST['jurusan']; $kelas = $_POST['kelas']; $semester = $_POST['semester'];
    $foto_name = $_FILES['foto']['name'];

    if ($foto_name != "") {
        $ext = pathinfo($foto_name, PATHINFO_EXTENSION);
        $foto_db = time() . '_' . uniqid() . '.' . $ext;
        move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads/' . $foto_db);
    }

    if ($id == "") {
        $sql = "INSERT INTO mahasiswa (nim, nama_lengkap, jurusan, kelas, semester, foto) VALUES ('$nim', '$nama', '$jurusan', '$kelas', '$semester', '$foto_db')";
    } else {
        if ($foto_name != "") {
            $sql = "UPDATE mahasiswa SET nim='$nim', nama_lengkap='$nama', jurusan='$jurusan', kelas='$kelas', semester='$semester', foto='$foto_db' WHERE id=$id";
        } else {
            $sql = "UPDATE mahasiswa SET nim='$nim', nama_lengkap='$nama', jurusan='$jurusan', kelas='$kelas', semester='$semester' WHERE id=$id";
        }
    }
    if (mysqli_query($conn, $sql)) { echo "<script>alert('DATA UPLOADED'); window.location='index.php';</script>"; }
}
?>