<?php include 'session_language.php'; ?>
<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificates / BagKat</title>
    <link rel="stylesheet" href="../css/certification.css">
</head>

<body>

    <div class="au">
        <div class="text">
            <h2><b><?php echo translate('Certificates'); ?></b></h2>
        </div>
    </div>

    <div class="main-container">
        <div class="container 1">
            <div class="picture">
                <div class="flip-container">
                    <div class="flipper">
                        <div class="front">
                            <img src="../images/indigency.png" alt="Front Image" style="width: 100%; height: 100%;">
                        </div>
                        <div class="back">
                            <img src="../images/indiflips.png" alt="Back Image" style="width: 100%; height: 100%;">
                            <button onclick="redirectToLogin()" class="flip-button">Request Now!</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container 2">
            <div class="picture">
                <div class="flip-container">
                    <div class="flipper">
                        <div class="front">
                            <img src="../images/certificate.png" alt="Front Image" style="width: 100%; height: 100%;">
                        </div>
                        <div class="back">
                            <img src="../images/certflips.png" alt="Back Image" style="width: 100%; height: 100%;">
                            <button onclick="redirectToLogin()" class="flip-button">Request Now!</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container 3">
            <div class="picture">
                <div class="flip-container">
                    <div class="flipper">
                        <div class="front">
                            <img src="../images/clearance.png" alt="Front Image" style="width: 100%; height: 100%;">
                        </div>
                        <div class="back">
                            <img src="../images/clearflips.png" alt="Back Image" style="width: 100%; height: 100%;">
                            <button onclick="redirectToLogin()" class="flip-button">Request Now!</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/dropdowntoggle.js"></script>
    <script src="../js/headerscroll.js"></script>

    <script>
        function redirectToLogin() {
            window.location.href = 'login.php';
        }

        function displayHoverImage(initialId, hoverId) {
            document.getElementById(initialId).style.display = 'none';
            document.getElementById(hoverId).style.display = 'block';
        }

        function displayInitialImage(initialId, hoverId) {
            document.getElementById(initialId).style.display = 'block';
            document.getElementById(hoverId).style.display = 'none';
        }

        function showPopup() {
            document.getElementById('popup').style.display = 'flex';
        }

        function hidePopup() {
            document.getElementById('popup').style.display = 'none';
        }
    </script>

    <?php include 'footer.php'; ?>
</body>

</html>
