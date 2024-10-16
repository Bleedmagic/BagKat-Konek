<?php
session_start();

include 'header_res.php';
include_once 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $currentPass = $_POST['CurrentPass'];
    $newPass = $_POST['NewPass'];
    $confirmPass = $_POST['ConfirmPass'];
    $username = $_SESSION['username'];

    if ($newPass != $confirmPass) {
        $error_message = "New password and confirm password do not match.";
    } else {
        $sql_check_pass = "SELECT user_password FROM user_accounts WHERE res_username = ? AND user_password = MD5(?)";
        $stmt_check_pass = $conn->prepare($sql_check_pass);
        $stmt_check_pass->bind_param('ss', $username, $currentPass);
        $stmt_check_pass->execute();
        $result_check_pass = $stmt_check_pass->get_result();

        if ($result_check_pass->num_rows > 0) {
            $sql_update_pass = "UPDATE user_accounts SET user_password = MD5(?) WHERE res_username = ?";
            $stmt_update_pass = $conn->prepare($sql_update_pass);
            $stmt_update_pass->bind_param('ss', $newPass, $username);
            $stmt_update_pass->execute();

            $success_message = "Password updated successfully.";
        } else {
            $error_message = "Current password is incorrect.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Pass / BagKat</title>
    <link rel="stylesheet" href="../css/res_changepass.css">
</head>

<body>

    <div class="main-content">
        <div class="main">
            <h1>Change Password</h1>
            <div class="update-contact">
                <div class="contact-info">
                    <?php if (isset($error_message)) : ?>
                        <div class="error"><?php echo $error_message; ?></div>
                    <?php endif; ?>
                    <?php if (isset($success_message)) : ?>
                        <div class="success"><?php echo $success_message; ?></div>
                    <?php endif; ?>
                    <form action="res_changepass.php" method="post">
                        <label class="password-toggle" for="CurrentPass">
                            Current Password:
                            <input type="password" id="CurrentPass" name="CurrentPass" placeholder="Enter your current password" required>
                            <span class="toggle-icon" id="currentPassIcon" onclick="togglePassword('CurrentPass', 'currentPassIcon')">👁️</span>
                        </label><br>
                        <label class="password-toggle" for="NewPass">
                            New Password:
                            <input type="password" id="NewPass" name="NewPass" placeholder="Enter your new password" required>
                            <span class="toggle-icon" id="newPassIcon" onclick="togglePassword('NewPass', 'newPassIcon')">👁️</span>
                        </label><br>
                        <label class="password-toggle" for="ConfirmPass">
                            Confirm Password:
                            <input type="password" id="ConfirmPass" name="ConfirmPass" placeholder="Confirm your new password" required>
                            <span class="toggle-icon" id="confirmPassIcon" onclick="togglePassword('ConfirmPass', 'confirmPassIcon')">👁️</span>
                        </label>
                        <button type="submit">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            var input = document.getElementById(inputId);
            var icon = document.getElementById(iconId);
            if (input.type === "password") {
                input.type = "text";
                icon.innerHTML = "🙈";
            } else {
                input.type = "password";
                icon.innerHTML = "👁️";
            }
        }
    </script>
</body>

</html>
