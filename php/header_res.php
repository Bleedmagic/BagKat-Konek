<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/header_res.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap">
</head>

<body>
    <header>
        <div class="header-left">
            <img src="../images/bk_logo.png" alt="Logo">
            <div>
                <strong>Bagong Katipunan</strong><br>
                Pasig City
            </div>
        </div>
        <div class="header-right">
            <div class="logout">
                <img src="../images/logout.png" alt="Profile Image">
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </header>

    <aside>
        <div class="sidebar">
            <?php
            if (isset($_SESSION['username'])) {
                echo '<a href="residents.php" class="resident-name-button"><b>Welcome, ' . htmlspecialchars($_SESSION['username']) . '!</b></a>';
            } else {
                // header("Location: login.php");
                // exit();
                echo '<a href="residents.php" class="resident-name-button"><b>Welcome, Resident!</b></a>';
            }
            ?>

            <hr class="sidebar-separator">
            <h3> GENERAL </h3>
            <button class="sidebar-button dropdown-btn" onclick="toggleDropdown('general-dropdown')">My Requests <span class="arrow">&#9660;</span></button>
            <div id="general-dropdown" class="dropdown-container">
                <a href="res_clearance_req.php" class="dropdown-button">Barangay Clearance</a>
                <a href="res_indigency_req.php" class="dropdown-button">Barangay Indigency</a>
                <a href="res_certificate_req.php" class="dropdown-button">Barangay Certificate</a>
            </div>
            <h3> SETTINGS </h3>
            <button class="sidebar-button dropdown-btn" onclick="toggleDropdown('account-settings-dropdown')">Account Settings<span class="arrow">&#9660;</span></button>
            <div id="account-settings-dropdown" class="dropdown-container">
                <a href="res_account_info.php" class="dropdown-button">Account Information</a>
                <a href="res_changepass.php" class="dropdown-button">Change Password</a>
            </div>
        </div>
    </aside>

    <script>
        function toggleDropdown(dropdownId) {
            var dropdown = document.getElementById(dropdownId);
            var arrow = dropdown.previousElementSibling.querySelector('.arrow');
            if (dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
                arrow.innerHTML = '&#9660;';
            } else {
                dropdown.style.display = 'block';
                arrow.innerHTML = '&#9650;';
            }
        }
    </script>
</body>

</html>
