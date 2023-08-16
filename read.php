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

// Query untuk mengambil daftar berita dari database
$query = "SELECT * FROM berita ORDER BY tanggal DESC";
$result = mysqli_query($koneksi, $query);

// Array untuk menyimpan hasil query
$berita = array();

// Jika ada hasil query, simpan data berita dalam array
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $berita[] = $row;
    }
}

// Tutup koneksi database
mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Berita</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            margin: 0;
            padding: 0;
            color: #fff; /* Warna teks */
        }

        h1 {
            text-align: center;
        }

        /* Gaya untuk card berita */
        .cards-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .card {
            background-color: #f1f1f1;
            color: #000; /* Warna teks */
            padding: 15px;
            margin: 10px;
            border-radius: 5px;
            width: 300px;
        }

        /* Gaya untuk judul berita dalam card */
        .card h3 {
            margin-top: 0;
            font-size: 20px;
        }

        /* Gaya untuk tanggal berita dalam card */
        .card p.date {
            margin-bottom: 10px;
        }

        /* Gaya untuk link selengkapnya, edit, dan hapus dalam card */
        .card a {
            color: #000; /* Warna teks */
            text-decoration: none;
            margin-right: 10px;
        }

        /* Gaya untuk link selengkapnya saat dihover */
        .card a:hover {
            text-decoration: underline;
        }

        /* Gaya untuk link hapus saat dihover */
        .card a.delete:hover {
            color: #ff0000;
        }

        /* Gaya untuk link edit saat dihover */
        .card a.edit:hover {
            color: #00ff00;
        }

        .back {
            color: #fff;
            text-decoration: none;
            margin-top: 10px;
            display: inline-block;
            background-color: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .back:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Daftar Berita</h1>
    <!-- Tampilkan daftar berita -->
    <?php
    // Tempatkan kode PHP Anda di sini (sama seperti yang telah Anda berikan sebelumnya)
    ?>
    <?php if (!empty($berita)) : ?>
        <div class="cards-container">
            <?php foreach ($berita as $item) : ?>
                <div class="card">
                    <h3><?php echo $item['judul']; ?></h3>
                    <p class="date"><?php echo $item['tanggal']; ?></p>
                    <p><?php echo substr($item['konten'], 0, 100); ?></p>
                    <a href="detail.php?id=<?php echo $item['id']; ?>">Baca Selengkapnya</a>
                    <a href="edit.php?id=<?php echo $item['id']; ?>" class="edit">(Edit)</a>
                    <a href="delete.php?id=<?php echo $item['id']; ?>" class="delete" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">Hapus</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <p>Tidak ada berita yang tersedia.</p>
    <?php endif; ?>

    <a class="back" href="admin_dashboard.php">Kembali</a>
</body>
</html>

