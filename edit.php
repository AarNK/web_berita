<?php
// (Include the database connection code here)
$host = 'localhost'; // Sesuaikan dengan host database Anda
$username = 'root'; // Sesuaikan dengan username database Anda
$password = ''; // Sesuaikan dengan password database Anda
$dbname = 'berita_db'; // Sesuaikan dengan nama database Anda

$koneksi = mysqli_connect($host, $username, $password, $dbname);

// Periksa koneksi database
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// (Check if the user is logged in and has permission to edit berita here)

// Periksa apakah ada parameter ID pada URL
if (isset($_GET['id'])) {
    $id_berita = $_GET['id'];

    // Query untuk mengambil berita dengan ID yang sesuai
    $query = "SELECT * FROM berita WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "i", $id_berita);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    // Jika berita dengan ID yang sesuai ditemukan, tampilkan form edit berita
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

// Jika ada data yang di-submit melalui form, proses pembaruan berita
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST["judul"];
    $konten = $_POST["konten"];
    $kategori = $_POST["kategori"];
    $gambar = $_POST["gambar"];

    // Query untuk melakukan pembaruan data berita
    $query = "UPDATE berita SET judul=?, konten=?, gambar=?, kategori=? WHERE id=?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "ssssi", $judul, $konten, $gambar, $kategori, $id_berita);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        // Redirect to detail.php after the update is successful
        header("Location: detail.php?id=$id_berita");
        exit();
    } else {
        $error_message = "Gagal memperbarui berita: " . mysqli_error($koneksi);
    }
}

// Tutup koneksi database
mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Berita</title>
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
    </style>
</head>
<body>
    <h1>Edit Berita</h1>
    <?php if (isset($error_message)) : ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php else : ?>
        <form method="post">
            <label>Judul:</label>
            <input type="text" name="judul" value="<?php echo $berita['judul']; ?>"><br>

            <label>Konten:</label><br>
            <textarea name="konten" rows="4" cols="50"><?php echo $berita['konten']; ?></textarea><br>

            <label>Kategori:</label>
            <input type="text" name="kategori" value="<?php echo $berita['kategori']; ?>"><br>

            <label>Link url gambar:</label>
            <input type="text" name="gambar" value="<?php echo $berita['gambar']; ?>"><br>

            <input type="submit" value="Update Berita">
        </form>
    <?php endif; ?>
    <a href="detail.php?id=<?php echo $id_berita; ?>">Batal</a>
</body>
</html>
