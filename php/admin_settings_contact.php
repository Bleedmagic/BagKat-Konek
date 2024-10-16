<?php

include 'header_admin.php';
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phone = $_POST['phone'];
    $facebook = $_POST['facebook'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $stmt = $conn->prepare("REPLACE INTO contact_info (id, phone, facebook, email, address) VALUES (1, ?, ?, ?, ?)");
    $stmt->bind_param("ssss", $phone, $facebook, $email, $address);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Contact information updated successfully!');</script>";
    } else {
        echo "<script>alert('Failed to update contact information.');</script>";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Settings / BagKat</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="../css/admin_settings_contact.css">
</head>

<body>
    <div class="main-content">
        <div class="main">
            <h1>UPDATE CONTACT INFORMATION</h1>
            <div class="update-contact">
                <h1>Contact Information</h1>
                <div class="contact-info">
                    <form action="" method="post">
                        <label for="phone">
                            <i class="fa fa-phone"></i>
                            <input type="text" id="phone" name="phone" placeholder="Phone">
                        </label>
                        <label for="facebook">
                            <i class="fa fa-facebook"></i>
                            <input type="text" id="facebook" name="facebook" placeholder="Facebook">
                        </label>
                        <label for="email">
                            <i class="fa fa-envelope"></i>
                            <input type="email" id="email" name="email" placeholder="Email">
                        </label>
                        <label for="address">
                            <i class="fa fa-address-card"></i>
                            <input type="text" id="address" name="address" placeholder="Address">
                        </label>

                        <button type="submit">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
