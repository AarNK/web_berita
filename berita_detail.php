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

// Get the article ID from the URL parameter
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $article_id = $_GET['id'];

    // Retrieve data for the specific article
    $query = "SELECT judul, tanggal, konten, gambar FROM berita WHERE id = $article_id";
    $result = $connection->query($query);

    // Fetch data and store it in $article
    if ($result->num_rows > 0) {
        $article = $result->fetch_assoc();
    } else {
        // If no article found with the given ID, redirect to the homepage or show an error message.
        // For simplicity, let's redirect to the homepage.
        header("Location: /");
        exit();
    }
} else {
    // If no valid article ID provided, redirect to the homepage or show an error message.
    // For simplicity, let's redirect to the homepage.
    header("Location: /");
    exit();
}

// Close the database connection
$connection->close();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Detail Berita - <?php echo $article['judul']; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">

<style>
</style>
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
            </ul>
        </div>

        <!-- Search bar -->
        <form class="search-bar-container d-md-flex d-none">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn" type="submit">Search</button>
        </form>
    </div>
  </nav>

  <div class="col-md-8 offset-md-2">
    <div class="card">
        <?php if ($article['gambar']): ?>
          <div class="container">
            <img src="<?php echo $article['gambar']; ?>" class="card-img-top" alt="Gambar Berita">
          </div>
        <?php endif; ?>
        <div class="container">
        <div class="card-body">
            <h2 class="card-title"><?php echo $article['judul']; ?></h2>
            <p class="card-text"><small class="text-muted">Tanggal: <?php echo $article['tanggal']; ?></small></p>
            <p class="card-text"><?php echo $article['konten']; ?></p>
        </div>
        </div>
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