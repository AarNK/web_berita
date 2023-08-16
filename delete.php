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

    // Query untuk menghapus berita dengan ID yang sesuai
    $delete_query = "DELETE FROM berita WHERE id = '$id_berita'";
    if (mysqli_query($koneksi, $delete_query)) {
        // Berita berhasil dihapus
        header("Location: read.php"); // Redirect ke halaman daftar berita
        exit();
    } else {
        // Gagal menghapus berita
        $error_message = "Terjadi kesalahan saat menghapus berita: " . mysqli_error($koneksi);
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
    <title>Hapus Berita</title>
</head>
<body>
    <h1>Hapus Berita</h1>
    <?php if (isset($error_message)) : ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php else : ?>
        <p>Berita berhasil dihapus.</p>
    <?php endif; ?>
    <a href="read.php">Kembali ke Daftar Berita</a>
</body>
</html>
