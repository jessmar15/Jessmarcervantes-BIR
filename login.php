<?php
// Start session
session_start();

include "conn.php";
    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Prepare and execute SQL statement
        $stmt = $conn->prepare("SELECT * FROM admin WHERE username = :username AND pass = SHA2(:password, 256)");
        $stmt->execute(['username' => $username, 'password' => $password]);

        // Check if user exists
        if ($stmt->rowCount() > 0) {
            // Authentication successful, redirect to dashboard
            $_SESSION['username'] = $username;
            $_SESSION['fullname'] = $fullname;
            header("Location: dashboard.php");
            exit;
        } else {
            // Authentication failed, display error message
            $error = "Wrong username or password!";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <center>
                        <h3 class="card-title">L O G I N</h3>
                        <h6>BIR RDO 057</h6>
                        </center>
                        <form method="post">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <?php if(isset($error)): ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $error; ?>
                                </div>
                            <?php endif; ?>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
