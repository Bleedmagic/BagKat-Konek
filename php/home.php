<?php include 'session_language.php'; ?>
<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Barangay Information System">
    <meta name="keywords" content="Barangay, Bagong Katipunan">
    <title>Home / BagKat</title>
    <link rel="stylesheet" href="../css/home.css">
    <style>
        .popup {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            padding: 10px 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            opacity: 1;
            transition: opacity 1s ease-out;
        }

        .popup-close {
            position: absolute;
            top: 5px;
            right: 5px;
            color: white;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div id="popup" class="popup">
        <span id="popup-text">We suggest using 80% zoom and a desktop for better experience.</span>
        <span id="popup-close" class="popup-close">&times;</span>
    </div>

    <div class="au">
        <div class="text">
            <h2><b><?php echo translate('WELCOME'); ?></b></h2>
        </div>
    </div>

    <main>
        <div class="main-content">
            <div class="img-bk-welcome">
                <img src="../images/BKWelcome.png" alt="Barangay Katipunan Welcome" width="100%" height="auto">
            </div>
        </div>

        <section class="container">
            <div class="img-bk-logo">
                <img src="../images/bk_logo.png" alt="Barangay Bagong Katipunan Logo" width="400px" height="400px">
            </div>
            <div class="content">
                <p>
                    <?php echo translate('Welcome to Barangay Bagong Katipunan, a vibrant community in the heart of Pasig City, Metro Manila. Led by our esteemed Barangay Captain, Jeronimo Alba, and a dedicated team of barangay officials, we are committed to upholding the values of unity, inclusivity, and progress.'); ?>
                </p>
                <p>
                    <?php echo translate('Through collaborative efforts and community-driven initiatives, we strive to create an environment where every resident feels valued, heard, and empowered. From neighborhood clean-up drives to cultural festivities, our residents actively contribute to the well-being and vibrancy of our barangay.'); ?>
                </p>
                <p>
                    <?php echo translate('Explore our website to stay updated on barangay projects, access essential services, or connect with fellow residents. Whether you\'re a longtime resident or a newcomer, we extend a warm welcome and invite you to be part of our journey as we continue to grow and thrive together.'); ?>
                </p>
                <p>
                    <?php echo translate('Thank you for visiting Barangay Bagong Katipunan online, and we look forward to welcoming you to our barangay in person!'); ?>
                </p>
            </div>
        </section>

        <section class="final">
            <div class="contactInfo">
                <h2><?php echo translate('CONTACT INFORMATION'); ?></h2>
                <a href="tel:+6384774262" target="_blank" class="contact-link">
                    <i class="fa fa-phone" aria-hidden="true"></i>
                    8477-42-62
                </a>

                <a href="https://www.facebook.com/bagkat2010" target="_blank" class="facebook-link">
                    <i class="fab fa-facebook-f" aria-hidden="true"></i>
                    Barangay Bagong Katipunan
                </a>

                <a href="mailto:bagongkatipunan.pasig@gmail.com" class="email-link">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                    bagongkatipunan.pasig@gmail.com
                </a>
            </div>
            <div class="get-in-touch">
                <h2><?php echo translate('GET IN TOUCH'); ?></h2>
                <p>
                    <?php echo translate('At Barangay Bagong Katipunan, we are dedicated to surpassing your expectations. Have any inquiries, feedback, or specific requests? We are here to listen and assist, so feel free to get in touch with us today!'); ?>
                </p>
            </div>
            <div class="rateUs">
                <h3>
                    <?php echo translate('RATE US!'); ?><i class="fa fa-star-o" aria-hidden="true"></i>
                </h3>
                <a href="https://forms.gle/TqTxSD2VU7nZzsD68" target="_blank">
                    <img src="../images/qr_code.png" alt="<?php echo translate('QR Code to Google Form'); ?>" width="200px" class="qr-code">
                </a>
            </div>
        </section>
    </main>

    <script src="../js/dropdowntoggle.js"></script>
    <script src="../js/headerscroll.js"></script>
    <?php include 'footer.php'; ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var popup = document.getElementById('popup');
            var popupClose = document.getElementById('popup-close');

            popupClose.addEventListener('click', function() {
                popup.style.display = 'none';
            });

            setTimeout(function() {
                popup.style.opacity = '0';
            }, 5000);
        });
    </script>


</body>

</html>
