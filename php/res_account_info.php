<?php
session_start();

include 'header_res.php';
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['newUsername']) && !empty($_POST['newUsername'])) {
        $newUsername = $_POST['newUsername'];

        $sql = "UPDATE user_accounts SET res_username = ? WHERE res_username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $newUsername, $_SESSION['username']);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['username'] = $newUsername;

            $_SESSION['update_success'] = true;

            header("Location: res_account_info.php");
            exit;
        } else {
            $error_message = "Failed to update username.";
        }
    } else {
        $error_message = "New username is required.";
    }
}

$update_message = '';
if (isset($_SESSION['update_success']) && $_SESSION['update_success']) {
    $update_message = "Username updated successfully.";
    unset($_SESSION['update_success']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Info / BagKat</title>
    <link rel="stylesheet" href="../css/res_account_info.css">
</head>

<body>
    <div class="main-content">
        <div class="main">
            <h1>ACCOUNT INFORMATION</h1>
            <div class="update-contact">
                <div class="contact-info">
                    <?php if (!empty($update_message)) : ?>
                        <p style="color: green;"><?php echo $update_message; ?></p>
                    <?php endif; ?>
                    <?php if (isset($error_message)) : ?>
                        <p style="color: red;"><?php echo $error_message; ?></p>
                    <?php endif; ?>
                    <form action="res_account_info.php" method="post">
                        <label for="currentUsername">
                            Username:
                            <span id="currentUsername"><?php echo isset($_SESSION['username']) ? $_SESSION['username'] : ''; ?></span>
                        </label>
                        <br><br>
                        <label for="newUsername">
                            New Username:
                            <input type="text" id="newUsername" name="newUsername" placeholder="Enter new username" required>
                        </label>
                        <br><br>
                        <button type="submit">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
