<?php 
// Versi 2.0: Update Tampilan Teknik Informatika 
include 'koneksi.php'; 
?>git add .
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Data Mahasiswa Teknik Informatika</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Special+Elite&family=Inter:wght@400;600&display=swap');

        body { 
            background: #cbd5e0; /* Abu-abu latar belakang */
            color: #1a1a1a;
            font-family: 'Inter', sans-serif;
            margin: 0; padding: 40px;
        }

        .container { 
            max-width: 1100px; margin: auto; 
            background: #edf2f7; /* Abu-abu terang untuk area tulisan */
            padding: 30px; 
            border-top: 5px solid #bc0000;
            border-left: 1px solid #a0aec0;
            border-right: 1px solid #a0aec0;
            border-bottom: 1px solid #a0aec0;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }

        .header { 
            display: flex; justify-content: space-between; align-items: center;
            border-bottom: 2px solid #1a1a1a; padding-bottom: 15px; margin-bottom: 30px; 
        }

        h2 { 
            font-family: 'Special Elite', cursive; 
            font-size: 28px;
            color: #000; text-transform: uppercase; margin: 0; 
        }

        .btn-tambah { 
            background: #000; color: white; padding: 10px 20px; 
            text-decoration: none; border: none; font-weight: bold;
            font-size: 13px; transition: 0.3s;
        }
        .btn-tambah:hover { background: #bc0000; }

        table { width: 100%; border-collapse: collapse; }
        th { 
            background: #1a202c; color: #fff; text-align: left; 
            padding: 15px; font-size: 12px; text-transform: uppercase;
        }
        td { padding: 15px; border-bottom: 1px solid #cbd5e0; font-size: 14px; }
        tr:nth-child(even) { background: #e2e8f0; } /* Warna baris selang-seling */

        .img-table { width: 50px; height: 50px; object-fit: cover; border: 1px solid #000; }

        .badge { border: 1px solid #bc0000; color: #bc0000; padding: 3px 8px; font-size: 11px; font-weight: bold; }

        .btn-edit { color: #2b6cb0; text-decoration: none; font-weight: 600; margin-right: 15px; }
        .btn-hapus { color: #bc0000; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h2>DATA MAHASISWA TEKNIK INFORMATIKA</h2>
            </div>
            <a href="form.php" class="btn-tambah">+ TAMBAH DATA</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>NIM</th>
                    <th>Nama Lengkap</th>
                    <th>Jurusan</th>
                    <th>Kelas</th>
                    <th>Semester</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $q = mysqli_query($conn, "SELECT * FROM mahasiswa");
                $no = 1;
                while($r = mysqli_fetch_assoc($q)): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><img src="uploads/<?= $r['foto']; ?>" class="img-table"></td>
                    <td style="font-weight: bold;"><?= $r['nim']; ?></td>
                    <td><?= strtoupper($r['nama_lengkap']); ?></td>
                    <td><span class="badge"><?= $r['jurusan']; ?></span></td>
                    <td><?= $r['kelas']; ?></td>
                    <td>Semester <?= $r['semester']; ?></td>
                    <td>
                        <a href="form.php?id=<?= $r['id']; ?>" class="btn-edit">Edit</a>
                        <a href="hapus.php?id=<?= $r['id']; ?>" class="btn-hapus" onclick="return confirm('Hapus data ini?')">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>