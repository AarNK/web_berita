<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>footer</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<style>
.footer {
    background-color: rgba(30, 144, 255, 0.9);
}

.card {
    background-color: rgba(255, 255, 255, 0.9);
    border: none;
    margin-bottom: 20px;
    margin-right: 8rem; /* Add margin right to each card */
}

.card:last-child {
    margin-right: 0; /* Remove margin right from the last card to avoid unnecessary spacing */
}

.card h3 {
    margin-top: 20px;
}

.col-md-3 img {
    width: 30px;
    height: auto;
    margin-right: 10px;
}

.social-media-icons {
    display: flex;
    justify-content: center;
}

.footer-links {
    margin-top: 10px;
}

.copy-right {
    text-align: center;
}
</style>
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="nav-left">
    <img src="assets/dj corp.png" alt="">
  </div>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav mx-auto">
      <li class="nav-item"><a class="nav-link " href="#"><img src="assets/.png" alt="">Beranda</a></li>
      <li class="nav-item"><a class="nav-link " href="#"><img src="assets/.png" alt="">Barang</a></li>
      <li class="nav-item"><a class="nav-link " href="#"><img src="assets/.png" alt="">Pembuatan Nota</a></li>
      <li class="nav-item"><a class="nav-link " href="#"><img src="assets/.png" alt="">Daftar Nota</a></li>
    </ul>
  </div>
  <div class="nav-right">
    <img src="assets/fb.png" alt="Profile Icon">
  </div>
</nav>



<footer class="footer text-dark mt-4 py-3">
    <div class="container">
      <div class="row">
        <div class="card col-md-3">
          <h3>Website Resmi</h3>
          <p>https://djcorp.co.id/</p>
        </div>
        <div class="card col-md-3">
          <h3>Kontak</h3>
          <h5>+123 4567890</h5>
          <div class="social-media-icons">
            <img src="assets/fb.png" alt="">
            <img src="assets/ig.png" alt="">
            <img src="assets/yt.png" alt="">
          </div>
        </div>
        <div class="card col-md-3">
          <h3>Alamat</h3>
          <h5>PT. Darmajaya Digital Solusi<br>
              2 Floor, DSC Building<br>
              Jl. ZA. Pagar Alam No. 93<br>
              Bandar Lampung</h5>
        </div>
      </div>
      <div class="d-flex justify-content-between footer-links" style="margin-bottom: 0;">
        <div>
            <p>Dokumentasi | Tentang | Kontak | Privasi</p>
        </div>
        <div class="copy-right">
            <p>Copyright© 2023.</p>
        </div>
      </div>
    </div>
</footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
