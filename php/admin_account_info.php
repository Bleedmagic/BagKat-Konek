<?php
include 'header_admin.php';
include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['newUsername'])) {
    $currentUsername = $_SESSION['username'];
    $newUsername = $_POST['newUsername'];

    $sql = "UPDATE admin SET username = ? WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $newUsername, $currentUsername);
    if ($stmt->execute()) {
        $_SESSION['username'] = $newUsername;
        echo "<script>alert('Username updated successfully.');</script>";
    } else {
        echo "<script>alert('Failed to update username.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Info / BagKat</title>
    <link rel="stylesheet" href="../css/admin_account_info.css">
</head>

<body>

    <div class="main-content">
        <div class="main">
            <h1>ACCOUNT INFORMATION</h1>
            <div class="update-contact">
                <div class="contact-info">
                    <form action="admin_account_info.php" method="post">
                        <label for="currentUsername">
                            Username:
                            <span id="currentUsername"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
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
