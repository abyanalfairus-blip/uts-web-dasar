<?php 
include 'koneksi.php';

// Inisialisasi data agar tidak error saat tambah data baru
$id = isset($_GET['id']) ? $_GET['id'] : '';
$d = ['nim'=>'','nama_lengkap'=>'','jurusan'=>'','kelas'=>'','semester'=>'','foto'=>''];

// Jika ada ID, ambil data dari database untuk proses EDIT
if ($id) {
    $res = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE id=$id");
    if (mysqli_num_rows($res) > 0) {
        $d = mysqli_fetch_assoc($res);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Data Mahasiswa Teknik Informatika</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Special+Elite&family=Inter:wght@400;600&display=swap');

        body { 
            background: #cbd5e0; /* Abu-abu latar belakang */
            font-family: 'Inter', sans-serif; 
            display: flex; 
            justify-content: center; 
            padding: 40px; 
            margin: 0;
        }
        
        .card { 
            background: #edf2f7; /* Abu-abu terang untuk area form */
            padding: 40px; 
            width: 100%;
            max-width: 500px; 
            border: 1px solid #a0aec0;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        }

        h3 { 
            font-family: 'Special Elite', cursive; 
            color: #000; 
            text-align: center; 
            margin-bottom: 30px; 
            font-size: 24px;
            border-bottom: 2px solid #bc0000; 
            padding-bottom: 10px;
        }

        label { 
            display: block; 
            margin-top: 15px; 
            color: #333; 
            font-weight: 600; 
            font-size: 13px; 
            text-transform: uppercase; 
        }

        input, select { 
            width: 100%; 
            padding: 12px; 
            background: #fff; 
            border: 1px solid #cbd5e0; 
            color: #000; 
            outline: none; 
            margin-top: 5px; 
            font-family: inherit;
            box-sizing: border-box;
        }
        
        input:focus, select:focus { 
            border-color: #bc0000; 
            box-shadow: 0 0 0 2px rgba(188, 0, 0, 0.1); 
        }

        button { 
            width: 100%; 
            padding: 15px; 
            background: #000; 
            color: white; 
            border: none; 
            cursor: pointer; 
            font-weight: bold; 
            margin-top: 30px;
            text-transform: uppercase; 
            letter-spacing: 1px; 
            transition: 0.3s;
        }
        
        button:hover { 
            background: #bc0000; 
        }

        .btn-batal { 
            display: block; 
            text-align: center; 
            margin-top: 20px; 
            color: #4a5568; 
            text-decoration: none; 
            font-size: 12px; 
        }

        .preview { 
            width: 100px; 
            height: 100px; 
            object-fit: cover; 
            border: 1px solid #bc0000; 
            margin-bottom: 10px; 
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="card">
        <h3>FORM PENDAFTARAN</h3>
        <form action="proses.php" method="POST" enctype="multipart/form-data" id="mForm">
            <input type="hidden" name="id" value="<?= $id; ?>">
            
            <label>NIM (Nomor Induk Mahasiswa)</label>
            <input type="text" name="nim" id="nim" value="<?= $d['nim']; ?>" placeholder="Masukkan NIM...">

            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" id="nama" value="<?= $d['nama_lengkap']; ?>" placeholder="Nama sesuai KTP/Ijazah">

            <label>Program Studi</label>
            <select name="jurusan" id="jurusan">
                <option value="">-- Pilih Jurusan --</option>
                <option value="Teknik Informatika" <?= $d['jurusan']=='Teknik Informatika'?'selected':''; ?>>Teknik Informatika</option>
                <option value="Sistem Informasi" <?= $d['jurusan']=='Sistem Informasi'?'selected':''; ?>>Sistem Informasi</option>
            </select>

            <label>Kelas</label>
            <select name="kelas" id="kelas">
                <option value="">-- Pilih Kelas --</option>
                <option value="Reguler" <?= $d['kelas']=='Reguler'?'selected':''; ?>>Reguler</option>
                <option value="Karyawan" <?= $d['kelas']=='Karyawan'?'selected':''; ?>>Karyawan</option>
            </select>

            <label>Semester</label>
            <select name="semester" id="semester">
                <option value="">-- Pilih Semester --</option>
                <?php for($i=1;$i<=8;$i++): ?>
                    <option value="<?= $i ?>" <?= $d['semester']==$i?'selected':''; ?>>Semester <?= $i ?></option>
                <?php endfor; ?>
            </select>

            <label>Pas Foto (Maks 2MB)</label>
            <?php if($id && $d['foto']): ?> 
                <br><img src="uploads/<?= $d['foto']; ?>" class="preview"><br> 
            <?php endif; ?>
            <input type="file" name="foto" id="foto" accept="image/*">

            <button type="submit" name="simpan">SIMPAN DATA MAHASISWA</button>
            <a href="index.php" class="btn-batal">KEMBALI KE DAFTAR</a>
        </form>
    </div>

    <script>
    document.getElementById('mForm').onsubmit = function() {
        let nim = document.getElementById('nim').value.trim();
        let nama = document.getElementById('nama').value.trim();
        let jurusan = document.getElementById('jurusan').value;
        let kelas = document.getElementById('kelas').value;
        let semester = document.getElementById('semester').value;
        let foto = document.getElementById('foto');
        let idHidden = document.getElementsByName('id')[0].value;

        // 1. Validasi Input Kosong
        if(nim === "" || nama === "" || jurusan === "" || kelas === "" || semester === "") {
            alert("PERINGATAN: Semua kolom wajib diisi!");
            return false;
        }

        // 2. Validasi Foto
        if (foto.files.length > 0) {
            let file = foto.files[0];
            let size = file.size / 1024 / 1024; // Satuan MB
            let allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];

            if (!allowedTypes.includes(file.type)) {
                alert("GAGAL: Hanya file gambar (JPG/PNG) yang diizinkan!");
                return false;
            }

            if (size > 2) {
                alert("GAGAL: Ukuran foto terlalu besar! Maksimal 2MB.");
                return false;
            }
        } else if (idHidden === "") {
            // Jika tambah data baru, foto wajib ada
            alert("PERINGATAN: Pas Foto wajib diunggah!");
            return false;
        }

        return true; // Lolos validasi
    };
    </script>
</body>
</html>