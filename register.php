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

// Handle user registration
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username already exists
    $check_query = "SELECT * FROM users WHERE username = ?";
    $check_stmt = mysqli_prepare($conn, $check_query);
    mysqli_stmt_bind_param($check_stmt, "s", $username);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);

    if (mysqli_num_rows($check_result) > 0) {
        // Username already exists, display an error message or perform any other action you desire
        echo "Username already exists. Please choose a different username.";
    } else {
        // Username is available, insert the new user into the database
        $insert_query = "INSERT INTO users (username, password) VALUES (?, ?)";
        $insert_stmt = mysqli_prepare($conn, $insert_query);
        
        // Hash the password before storing it in the database (you can use password_hash() function)
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        mysqli_stmt_bind_param($insert_stmt, "ss", $username, $hashed_password);
        mysqli_stmt_execute($insert_stmt);
        
        // Registration successful, set a session variable to indicate the user is logged in
        $_SESSION['logged_in'] = true;
        header("Location: user_dashboard.php"); // Redirect to the user dashboard
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body style="background-color: #000; /* Background hitam */">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card text-white bg-dark">
          <div class="card-body">
            <h5 class="card-title">Register</h5>
            <form method="post">
              <div class="form-group">
                <label for="username" style="color: #fff;">Username:</label>
                <input type="text" id="username" name="username" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="password" style="color: #fff;">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
              </div>
              <button type="submit" name="register" class="btn btn-primary">Register</button>
            </form>
            <p class="mt-3 mb-0">Sudah punya akun? <a href="admin_login.php" style="color: #007bff;">Login di sini</a>.</p>
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
