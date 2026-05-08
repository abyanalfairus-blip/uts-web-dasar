<?php
include 'koneksi.php';

$id = $_GET['id'];
if ($id) {
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id=$id");
}

header("location:index.php");
?>