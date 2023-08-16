<?php
session_start();

// Replace these with your actual database credentials
$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "login_db";

// Establish database connection
$conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle user login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the provided credentials match admin credentials
    if ($username === "admin" && $password === "admin123") {
        // Admin login successful, set a session variable to indicate the user is logged in as admin
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin_dashboard.php"); // Redirect to the admin dashboard
        exit();
    }

    // Use prepared statements to prevent SQL injection
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $user_data = mysqli_fetch_assoc($result);
        // Verify the password using password_verify() function
        if (password_verify($password, $user_data['password'])) {
            // User login successful, set a session variable to indicate the user is logged in
            $_SESSION['logged_in'] = true;
            header("Location: user_dashboard.php"); // Redirect to the user dashboard
            exit();
        }
    }

    // Login failed, display an error message or perform any other action you desire
    echo "Invalid credentials. Please try again.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body style="background-color: #000; /* Background hitam */">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card text-white bg-dark">
          <div class="card-body">
            <h5 class="card-title">Login</h5>
            <form method="post">
              <div class="form-group">
                <label for="username" style="color: #fff;">Username:</label>
                <input type="text" id="username" name="username" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="password" style="color: #fff;">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
              </div>
              <button type="submit" name="login" class="btn btn-primary">Login</button>
            </form>
            <p class="mt-3 mb-0">Belum punya akun? <a href="register.php" style="color: #007bff;">Daftar di sini</a>.</p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS (Popper.js and jQuery are required for Bootstrap) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
