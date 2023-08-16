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

// Retrieve data from the "berita" table
$query = "SELECT id, judul, tanggal, konten FROM berita";
$result = $connection->query($query);

$berita = array();

// Fetch data and store it in the $berita array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $berita[] = $row;
    }
}

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
                <a class="nav-link" href="/">Beranda <span class="sr-only"></span></a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="index.php?kategori=politik">Politik</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="index.php?kategori=olahraga">Olahraga</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="kategori.php?kategori=teknologi">Teknologi</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/tentangkami">Tentang Kami</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/kontak">Kontak</a>
              </li>
            </ul>
        </div>

        <!-- Search bar -->
        <form class="search-bar-container d-md-flex d-none">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn" type="submit">Search</button>
        </form>
    </div>
  </nav>


  <div class="container mt-4">
        <div class="row">

            <!-- Loop to display news from the database -->
<?php
foreach ($berita as $item) {
    echo '<div class="col-md-4 mt-3">';
    echo '<div class="card mb-3">';
    echo '<div class="card-body">';
    echo '<h2 class="card-title">' . $item['judul'] . '</h2>';
    echo '<p class="card-text"><small class="text-muted">Tanggal: ' . $item['tanggal'] . '</small></p>';
    echo '<p class="card-text">' . $item['konten'] . '</p>';
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
            <li><a href="/">Beranda</a></li>
            <li><a href="/kategori">Kategori</a></li>
            <li><a href="/tentangkami">Tentang Kami</a></li>
            <li><a href="/kontak">Kontak</a></li>
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
