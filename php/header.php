<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <header id="header">
        <div class="logo">
            <img src="../images/bk_logo.png" alt="BagKat Logo" width="50">
            <div class="logo-text">
                Republic of the Philippines<br>
                <div class="logo-text-bagkat">
                    <b>BRGY. BAGONG KATIPUNAN</b>
                </div>
                1600, Pasig City, National Capital Region
            </div>
        </div>

        <nav class='nav-desk'>
            <a href="home.php"><?php echo translate('Home'); ?></a>
            <a href="about_us.php"><?php echo translate('About Us'); ?></a>
            <div class="dropdown">
                <span class="dropbtn"><?php echo translate('Services'); ?></span>
                <div class="dropdown-content">
                    <a href="certification.php"><?php echo translate('Certificates'); ?></a>
                </div>
            </div>
            <a href="contact_us.php"><?php echo translate('Contacts'); ?></a>
            <a href="login.php"><?php echo translate('Login'); ?></a>
        </nav>

        <?php
        if (isset($_SESSION['language'])) {
            echo '<form method="post">';
            echo '<div class="language-toggle">';
            echo '<button type="submit" name="toggle_language" class="language-button" style="border: none;">';
            echo ($_SESSION['language'] == 'en' ? '<i class="fas fa-globe" style="color: green; font-size: 1.9em;"></i>' : '<i class="fas fa-globe" style="color: green; font-size: 1.9em;"></i>');
            echo '</button>';
            echo '</div>';
            echo '</form>';
        }
        ?>

        <nav class='hamburger'>
            <div class='hamburger-icon'>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <path d="M0 96C0 78.3 14.3 64 32 64H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32H416c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H416c17.7 0 32 14.3 32 32z" />
                </svg>
            </div>
            <div id="nav-tab-content" class='nav-tab-content'>
                <a href="home.php"><?php echo translate('Home'); ?></a>
                <a href="about_us.php"><?php echo translate('About Us'); ?></a>
                <a href="certification.php"><?php echo translate('Certificates'); ?></a>
                <a href="contact_us.php"><?php echo translate('Contacts'); ?></a>
                <a href="login.php"><?php echo translate('Login'); ?></a>
            </div>
        </nav>
    </header>
</body>

</html>
