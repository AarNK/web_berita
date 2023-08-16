<?php
// Pastikan admin sudah login sebelum mengakses halaman ini
// (Implementasikan fitur keamanan sesuai dengan kebutuhan Anda)

// Fungsi untuk menghindari serangan SQL injection
function escape_input($data) {
    global $koneksi;
    return mysqli_real_escape_string($koneksi, $data);
}

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

// Periksa apakah ada parameter ID pada URL
if (isset($_GET['id'])) {
    $id_berita = escape_input($_GET['id']);

    // Query untuk mengambil berita dengan ID yang sesuai
    $query = "SELECT * FROM berita WHERE id = '$id_berita'";
    $result = mysqli_query($koneksi, $query);

    // Jika berita dengan ID yang sesuai ditemukan, tampilkan detail berita
    if (mysqli_num_rows($result) > 0) {
        $berita = mysqli_fetch_assoc($result);
    } else {
        // Jika berita tidak ditemukan, tampilkan pesan error
        $error_message = "Berita tidak ditemukan.";
    }
} else {
    // Jika tidak ada parameter ID pada URL, tampilkan pesan error
    $error_message = "ID berita tidak valid.";
}

// Tutup koneksi database
mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Berita</title>
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

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .card {
            background-color: #f1f1f1;
            color: #000;
            border-radius: 5px;
            max-width: 600px;
            margin-top: 20px;
        }

        .card img {
            width: 100%;
            border-radius: 5px 5px 0 0;
        }

        .card-body {
            padding: 20px;
        }

        .card h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 16px;
        }

        a {
            color: #fff;
            text-decoration: none;
            margin-top: 10px;
            display: inline-block;
            background-color: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
        }

        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Detail Berita</h1>
    <?php if (isset($error_message)) : ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php else : ?>
        <div class="container">
            <div class="card">
                <?php if ($berita['gambar']) : ?>
                    <img src="<?php echo $berita['gambar']; ?>" alt="Gambar Berita">
                <?php endif; ?>
                <div class="card-body">
                    <h2><?php echo $berita['judul']; ?></h2>
                    <p><?php echo $berita['tanggal']; ?></p>
                    <p><?php echo $berita['konten']; ?></p>
                    <p><?php echo $berita['kategori']; ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <a href="read.php">Kembali</a>
</body>
</html>

