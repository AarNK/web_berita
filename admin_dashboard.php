<?php
session_start();

// Check if the user is logged in as an admin
$admin_logged_in = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'];

// If the user is not logged in as an admin, redirect to the login page
if (!$admin_logged_in) {
    header("Location: index.php");
    exit();
}

// Function to increment the website visitor count
function incrementVisitorCount() {
    if (!isset($_SESSION['visitor_count'])) {
        $_SESSION['visitor_count'] = 1;
    } else {
        $_SESSION['visitor_count']++;
    }
}

// Increment the visitor count on every page load
incrementVisitorCount();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- FullCalendar CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.7.2/main.min.css" rel="stylesheet" />

<style>
body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color: #000; /* Background hitam */
    color: #fff; /* Warna teks putih */
}

.container {
    display: flex;
}

.sidebar {
    margin-top: 20px;
    /* Tambahkan gaya lain yang diperlukan untuk sidebar */
}

.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar li {
    margin: 20px 0;
}

.sidebar li a {
    text-decoration: none;
    color: #fff; /* Warna teks putih */
    padding: 5px 10px;
    display: block;
}

.sidebar li a img {
    vertical-align: middle;
    margin-right: 5px;
}

.content {
    flex: 1;
    padding: 20px;
    margin-left: 50px;
    /* Tambahkan gaya lain yang diperlukan untuk konten */
}

</style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Tempatkan navigasi atau menu admin di sini -->
            <ul>
                <li><a href="admin_dashboard.php"><img src="assets/beranda.png" alt=""></a></li>
                <li><a href="read.php"><img src="assets/berita.png" alt=""></a></li>
                <li><a href="create.php"><img src="assets/grafik.png" alt=""></a></li>

            </ul>
        </div>

        <!-- Content -->
        
        <div class="content">
            <!-- Tempatkan konten dashboard di sini -->
            <h1>Dashboard Admin</h1>
        
            <div class="d-flex flex-wrap" style="margin-top: 10px;">
                <div class="card shadow  mb-5"
                    style="margin-top: 10px; background-color: rgba(255, 255, 255, 0.5); width: 11rem; margin-left: 20px;">
                    <div class="card-body text-center">
                        <h6 class="fw-bold"> Pengunjung</h6>
                        <h4 class="fw-bold"><?php echo isset($_SESSION['visitor_count']) ? $_SESSION['visitor_count'] : '0'; ?></h4>
                    </div>
                </div>
                <!-- Other cards -->
            </div>
            <a href="index.php">Logout</a>
        </div>

    </div>


    <!-- Bootstrap JS (Popper.js and jQuery are required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
