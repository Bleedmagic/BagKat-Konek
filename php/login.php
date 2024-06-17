<?php

session_start();

include 'config.php';

$error_message = '';

if (isset($_GET['pending']) && $_GET['pending'] == 'true') {
    $error_message = 'Your account is pending approval. Please wait for admin confirmation.';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql_admin = "SELECT * FROM admin WHERE username = ? AND password = MD5(?)";
    $stmt_admin = $conn->prepare($sql_admin);
    $stmt_admin->bind_param('ss', $username, $password);
    $stmt_admin->execute();
    $result_admin = $stmt_admin->get_result();

    if ($result_admin->num_rows > 0) {
        $admin = $result_admin->fetch_assoc();
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $admin['email'];
        $_SESSION['is_admin'] = true;
        header("Location: ../mail/send_otp.php");
        exit;
    } else {
        $sql_user = "SELECT * FROM user_accounts WHERE res_username = ? AND user_password = MD5(?)";
        $stmt_user = $conn->prepare($sql_user);
        $stmt_user->bind_param('ss', $username, $password);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();

        if ($result_user->num_rows > 0) {
            $user = $result_user->fetch_assoc();
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $user['user_email'];
            $_SESSION['is_admin'] = false;
            header("Location: ../mail/send_otp.php");
            exit;
        } else {
            $sql_pending = "SELECT * FROM sign_up_requests_temp WHERE res_username = ?";
            $stmt_pending = $conn->prepare($sql_pending);
            $stmt_pending->bind_param('s', $username);
            $stmt_pending->execute();
            $result_pending = $stmt_pending->get_result();

            if ($result_pending->num_rows > 0) {
                $_SESSION['error_message'] = 'Your account is pending approval. Please wait for admin confirmation.';
                $_SESSION['pending_redirect'] = true;
            } else {
                $_SESSION['error_message'] = 'Invalid username or password.';
                $_SESSION['pending_redirect'] = false;
            }
            header("Location: login.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / BagKat</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <div class="login-container">
        <div class="logo">
            <img src="../images/bk_logo.png" alt="BagKat Logo">
        </div>
        <h2>LOGIN</h2>

        <?php if (isset($_SESSION['error_message'])) : ?>
            <script>
                alert("<?php echo $_SESSION['error_message']; ?>");
                <?php if ($_SESSION['pending_redirect']) : ?>
                    window.location.href = "index.php";
                <?php unset($_SESSION['pending_redirect']);
                endif; ?>
                <?php unset($_SESSION['error_message']); ?>
            </script>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="input-group">
                <label for="username">
                    <span class="icon">&#128100;</span>
                    <input type="text" id="username" name="username" placeholder="Username" required>
                </label>
            </div>

            <div class="input-group">
                <label for="password" style="position: relative;">
                    <span class="icon">&#128274;</span>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <span class="password-toggle" onclick="togglePassword()">
                        <span id="showIcon">👁️</span>
                        <span id="hideIcon" style="display: none;">🙈</span>
                    </span>
                </label>
            </div>

            <button type="submit">Log In</button>
        </form>
        <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
    </div>

    <script>
        function togglePassword() {
            var passwordInput = document.getElementById('password');
            var showIcon = document.getElementById('showIcon');
            var hideIcon = document.getElementById('hideIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                showIcon.style.display = 'none';
                hideIcon.style.display = 'inline';
            } else {
                passwordInput.type = 'password';
                showIcon.style.display = 'inline';
                hideIcon.style.display = 'none';
            }
        }
    </script>
</body>

</html>
