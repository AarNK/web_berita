<?php
// Pastikan admin sudah login sebelum mengakses halaman ini
// (Implementasikan fitur keamanan sesuai dengan kebutuhan Anda)

// Proses form jika ada data yang dikirimkan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lakukan sanitasi dan validasi data yang diterima dari form
    $judul = $_POST['judul'];
    $konten = $_POST['konten'];
    $kategori = $_POST['kategori'];
    $gambar = $_POST['gambar'];

    // Lakukan validasi data sesuai dengan kebutuhan Anda
    // Contoh: Cek apakah data yang diterima tidak kosong
    if (empty($judul) || empty($konten)) {
        $error_message = "Judul dan konten berita harus diisi.";
    } else {
        // Jika data valid, lakukan penyimpanan data ke database
        // (Pastikan Anda sudah memiliki koneksi ke database)
        $host = 'localhost'; // Sesuaikan dengan host database Anda
        $username = 'root'; // Sesuaikan dengan username database Anda
        $password = ''; // Sesuaikan dengan password database Anda
        $dbname = 'berita_db'; // Sesuaikan dengan nama database Anda

        $koneksi = mysqli_connect($host, $username, $password, $dbname);

        // Periksa koneksi database
        if (!$koneksi) {
            die("Koneksi database gagal: " . mysqli_connect_error());
        }

        // Gunakan prepared statement untuk melakukan query dengan parameter
        $query = "INSERT INTO berita (judul, konten, tanggal, gambar, kategori) VALUES (?, ?, NOW(), ?, ?)";
        $stmt = mysqli_prepare($koneksi, $query);

        // Bind parameter ke statement
        mysqli_stmt_bind_param($stmt, 'ssss', $judul, $konten, $gambar, $kategori);

        // Eksekusi statement
        if (mysqli_stmt_execute($stmt)) {
            // Berita berhasil ditambahkan
            header("Location: read.php"); // Redirect ke halaman daftar berita
            exit();
        } else {
            // Gagal menyimpan berita
            $error_message = "Terjadi kesalahan saat menyimpan berita: " . mysqli_error($koneksi);
        }

        mysqli_stmt_close($stmt);
        mysqli_close($koneksi);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Berita Baru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            margin: 0;
            padding: 0;
            color: #fff;
        }

        h1 {
            text-align: center;
            padding-top: 20px;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            background-color: #f1f1f1;
            padding: 20px;
            border-radius: 5px;
            color: #000; /* Warna teks */
        }

        form label {
            display: block;
            margin-bottom: 5px;
        }

        form input[type="text"],
        form textarea {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: none;
            margin-bottom: 10px;
        }

        form textarea {
            resize: vertical;
            height: 150px;
        }

        form input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #0056b3;
        }

        a {
            color: #fff;
            text-decoration: none;
            display: inline-block;
            background-color: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 10px;
        }

        a:hover {
            background-color: #0056b3;
        }

        p.error-message {
            color: red;
        }
    </style>
</head>
<body>
    <h1>Tambah Berita Baru</h1>
    <!-- Form untuk menambah berita baru -->
    <form method="POST" action="">
        <label for="judul">Judul:</label>
        <input type="text" name="judul" required>
        <br>

        <label for="konten">Konten:</label>
        <textarea name="konten" required></textarea>
        <br>

        <label for="kategori">Kategori:</label>
        <input type="text" name="kategori" required>
        <br>

        <label for="gambar">Link url gambar:</label>
        <input type="text" name="gambar" required>
        <br>

        <input type="submit" value="Simpan">
    </form>
    <?php
    // Menampilkan pesan kesalahan jika ada
    if (isset($error_message)) {
        echo '<p class="error-message">' . $error_message . '</p>';
    }
    ?>

    <a href="admin_dashboard.php">Kembali</a>
</body>
</html>

