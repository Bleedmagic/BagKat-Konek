<?php include 'header_admin.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Pass / BagKat</title>
    <link rel="stylesheet" href="../css/admin_account_info.css">

</head>

<body>
    <?php
    session_start();
    include 'config.php';

    $error_message = '';
    $success_message = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $currentPass = $_POST['CurrentPass'];
        $newPass = $_POST['NewPass'];
        $confirmPass = $_POST['ConfirmPass'];

        if ($newPass !== $confirmPass) {
            $error_message = 'New password and confirm password do not match.';
        } else {
            $username = $_SESSION['username'];
            $sql = "SELECT * FROM admin WHERE username = ? AND password = MD5(?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $username, $currentPass);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $update_sql = "UPDATE admin SET password = MD5(?) WHERE username = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param('ss', $newPass, $username);

                if ($update_stmt->execute()) {
                    $success_message = 'Password updated successfully.';
                } else {
                    $error_message = 'Failed to update password. Please try again.';
                }
            } else {
                $error_message = 'Current password is incorrect.';
            }
        }
    }
    ?>

    <div class="main-content">
        <div class="main">
            <h1>Change Password</h1>
            <div class="update-contact">
                <div class="contact-info">
                    <?php if ($error_message) : ?>
                        <p class="error-message"><?php echo $error_message; ?></p>
                    <?php endif; ?>
                    <?php if ($success_message) : ?>
                        <p class="success-message"><?php echo $success_message; ?></p>
                    <?php endif; ?>
                    <form action="admin_changepass.php" method="post">
                        <label for="CurrentPass">
                            Current Password:
                            <input type="password" id="CurrentPass" name="CurrentPass" placeholder="Enter your current password" required>
                        </label><br>
                        <label for="NewPass">
                            New Password:
                            <input type="password" id="NewPass" name="NewPass" placeholder="Enter your new password" required>
                        </label><br>
                        <label for="ConfirmPass">
                            Confirm Password:
                            <input type="password" id="ConfirmPass" name="ConfirmPass" placeholder="Confirm your new password" required>
                        </label>
                        <button type="submit">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
