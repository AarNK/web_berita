<?php
// Connect to the database (adjust the credentials as needed)
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'berita_db';

$connection = new mysqli($host, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Mengambil berita pertama dari database
$query_first_news = "SELECT id, judul, tanggal, konten, gambar FROM berita LIMIT 1";
$result_first_news = $connection->query($query_first_news);

$first_news = null;
if ($result_first_news->num_rows > 0) {
    $first_news = $result_first_news->fetch_assoc();
}

// Mengambil parameter "kategori" dari URL jika tersedia
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : null;

// Mengambil parameter "search" dari URL jika tersedia
$searchQuery = isset($_GET['search']) ? $_GET['search'] : null;

// Buat query untuk mengambil berita sesuai kategori atau search query jika diberikan
$query = "SELECT id, judul, tanggal, konten, gambar FROM berita";
$conditions = array();

// Add search condition if the search query is provided
if ($searchQuery !== null) {
    // Avoid SQL injection with prepared statement
    $query .= " WHERE judul LIKE ?";
    $searchParam = '%' . $searchQuery . '%';
    $conditions[] = $searchParam;
}

// Add category condition if the category is provided
if ($kategori !== null) {
    $query .= (count($conditions) > 0) ? " AND kategori = ?" : " WHERE kategori = ?";
    $conditions[] = $kategori;
}

// Combine the conditions for prepared statement
if (count($conditions) > 0) {
    $conditionTypes = str_repeat('s', count($conditions)); // Assuming all conditions are strings
    $stmt = $connection->prepare($query);
    $stmt->bind_param($conditionTypes, ...$conditions);
} else {
    // No conditions, execute the query without prepared statement
    $stmt = $connection->prepare($query);
}

// Eksekusi query
$stmt->execute();

// Dapatkan hasil query
$result = $stmt->get_result();

$berita = array();

// Fetch data and store it in the $berita array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $berita[] = $row;
    }
}

// Tutup prepared statement
$stmt->close();

// Close the database connection
$connection->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Website Berita</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">

</head>
<body>
        <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
            aria-controls="offcanvasExample">
            <img src="./assets/dj corp.png" alt="" style="margin-right: 2rem;">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item active">
                <a class="nav-link" href="index.php">Beranda <span class="sr-only"></span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="tentangkami.php">Tentang Kami</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="kontak.php">Kontak</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="admin_login.php">Login</a>
              </li>
            </ul>
        </div>

        <!-- Search bar -->
        <form class="search-bar-container d-md-flex d-none" method="GET" action="index.php">
          <input class="form-control me-2 text-dark" type="search" placeholder="Search" aria-label="Search" name="search">
          <button class="btn" type="submit">Search</button>
        </form>
    </div>
  </nav>


  <div class="container mt-4">
        <div class="row">

<!--berita utama-->
<div class="col-md-8">
    <div class="card mb-3">
          <div class="card-body">
          <?php
            if ($first_news) {
              echo '<img src="' . $first_news['gambar'] . '" class="card-img-top" alt="Gambar Berita">';
              echo '<h3 class="card-title">' . $first_news['judul'] . '</h3>';
              echo '<p class="card-text"><small class="text-muted">Tanggal: ' . $first_news['tanggal'] . '</small></p>';
              // Tampilkan konten berita pertama secara singkat (misalnya hanya 100 karakter)
              echo '<p class="card-text">' . substr($first_news['konten'], 0, 100) . '...</p>';
              echo '<a href="berita_detail.php?id=' . $first_news['id'] . '" class="btn btn-primary">Selengkapnya</a>';
          } else {
              echo '<h5 class="card-title">Tidak ada berita.</h5>';
          }
          ?>
          </div>
    </div>
</div>

<!--kategori berita-->
<div class="col-md-4">
    <div class="card mb-3">
          <div class="card-body">
            <h5 class="card-title">Kategori Berita</h5>
            <ul class="list-group">
              <li class="list-group-item"><a href="index.php?kategori=politik">#Politik</a></li>
              <li class="list-group-item"><a href="index.php?kategori=olahraga">#Olahraga</a></li>
              <li class="list-group-item"><a href="index.php?kategori=teknologi">#Teknologi</a></li>
              <li class="list-group-item"><a href="index.php?kategori=agama">#Agama</a></li>
              <li class="list-group-item"><a href="index.php?kategori=movie">#Movie</a></li>
              <li class="list-group-item"><a href="index.php?kategori=otomotif">#Otomotif</a></li>
              <li class="list-group-item"><a href="index.php?kategori=akademik">#Akademik</a></li>
              <!-- Add more categories here -->
            </ul>
          </div>
    </div>
</div>

<!-- Loop untuk menampilkan berita dari database -->
<?php
foreach ($berita as $item) {
    echo '<div class="col-md-4 mt-3">';
    echo '<div class="card mb-3">';
    echo '<div class="card-body">';
    echo '<img src="' . $item['gambar'] . '" class="card-img-top" alt="Gambar Berita">';
    echo '<h4 class="card-title">' . $item['judul'] . '</h4>';
    echo '<p class="card-text"><small class="text-muted">Tanggal: ' . $item['tanggal'] . '</small></p>';
    echo '<p class="card-text">' . substr($item['konten'], 0, 100) . '...</p>';
    echo '<a href="berita_detail.php?id=' . $item['id'] . '" class="btn btn-primary">Baca Selengkapnya</a>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
}
?>

        </div>
    </div>
    
    <!-- Footer -->
<footer class="footer text-light mt-4 py-3">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
            <img src="assets/dj corp.png" alt="">
          <p>Jl. ZA. Pagar Alam No.93, Gedong Meneng, Kec. Rajabasa, Kota Bandar Lampung, Lampung 35141</p>
          <p>Email: info@websiteberita.com</p>
          <p>Telepon: 0813-7700-1008</p>
        </div>
        <div class="col-md-3">
          <h5>Halaman</h5>
          <ul class="list-unstyled">
            <li><a href="index.php">Beranda</a></li>
            <li><a href="tentangkami.php">Tentang Kami</a></li>
            <li><a href="kontak.php">Kontak</a></li>
          </ul>
        </div>
        <div class="col-md-3">
          <h5>Ikuti Kami</h5>
          <img src="assets/fb.png" alt="">
          <img src="assets/ig.png" alt="">
          <img src="assets/yt.png" alt="">
        </div>
      </div>
    </div>
  </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
