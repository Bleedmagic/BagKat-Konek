<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="../css/header_admin.css">
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
                echo '<h3>Welcome, ' . htmlspecialchars($_SESSION['username']) . '!</h3>';
            } else {
                // header("Location: login.php");
                // exit();
                echo '<h3>Welcome, Admin!</h3>';
            }
            ?>

            <h4>GENERAL </h4>
            <a href="admin_dashboard.php" class="sidebar-button">Dashboard</a>
            <a href="admin_officials_records.php" class="sidebar-button">Barangay Officials</a>
            <a href="admin_residents_records.php" class="sidebar-button">Residents List</a>
            <a href="admin_contact_us.php" class="sidebar-button">Contact Us</a>

            <h4>REPORTS</h4>
            <a href="admin_user_approval.php" class="sidebar-button">User Approval</a>
            <a href="audit_trail.php" class="sidebar-button">Audit Trail</a>
            <button class="sidebar-button dropdown-btn" onclick="toggleCertificationDropdown()">Certification Requests <span class="arrow">&#9660;</span></button>
            <div class="certification-dropdown">
                <a href="admin_clearance.php" class="certification-button">Barangay Clearance</a>
                <a href="admin_indigency.php" class="certification-button">Barangay Indigency</a>
                <a href="admin_certificate.php" class="certification-button">Barangay Certificate</a>
            </div>

            <h4>SETTINGS</h4>
            <a href="admin_settings_contact.php" class="sidebar-button">Contact Information</a>
            <a href="admin_settings_facilities.php" class="sidebar-button">Add Facilities</a>
            <button class="sidebar-button" onclick="backupAndDownload()">Backup </button>
            <button class="sidebar-button dropdown-btn" onclick="toggleDropdown()">Admin Account <span class="arrow">&#9660;</span></button>
            <div class="dropdown-container">
                <a href="admin_account_info.php" class="dropdown-button">Account Information</a>
                <a href="admin_changepass.php" class="dropdown-button">Change Password</a>
            </div>
        </div>
    </aside>

    <script>
        function toggleDropdown() {
            var dropdown = document.querySelector('.dropdown-container');
            var arrow = document.querySelector('.dropdown-btn .arrow');
            if (dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
                arrow.innerHTML = '&#9660;';
            } else {
                dropdown.style.display = 'block';
                arrow.innerHTML = '&#9650;';
            }
        }

        function toggleCertificationDropdown() {
            var dropdown = document.querySelector('.certification-dropdown');
            var arrow = document.querySelector('.certification-btn .arrow');
            if (dropdown.style.display === 'block') {
                dropdown.style.display = 'none';
                arrow.innerHTML = '&#9660;';
            } else {
                dropdown.style.display = 'block';
                arrow.innerHTML = '&#9650;';
            }
        }

        function backupAndDownload() {
            if (confirm('Do you want to keep a backup of the database?')) {
                window.location.href = 'backup_download.php';
            }
        }
    </script>
</body>

</html>
