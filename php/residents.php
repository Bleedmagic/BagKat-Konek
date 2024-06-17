<?php include 'header_res.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard / BagKat</title>
    <link rel="stylesheet" href="../css/residents.css">
</head>

<body>

    <div class="main-content">
        <h1> CERTIFICATION REQUEST </h1>
        <div class="container">
            <a href="barangay_clearance.php" class="option">
                <img src="../images/brgyClearance.png" alt="Barangay Clearance">
                <div class="description">
                    <h2>Barangay Clearance</h2>
                    <p>Barangay Clearance is a document issued by your local barangay (community) that certifies your residency and good moral character.</p>
                </div>
            </a>
            <a href="barangay_indigency.php" class="option">
                <img src="../images/brgyIndigency.png" alt="Barangay Indigency">
                <div class="description">
                    <h2>Barangay Indigency</h2>
                    <p>Barangay Indigency is a document issued by the local government unit (LGU) or the Department of Social Welfare and Development (DSWD) that officially recognizes you as belonging to a low-income family.</p>
                </div>
            </a>
            <a href="barangay_certificate.php" class="option">
                <img src="../images/brgyCert.png" alt="Barangay Certificate">
                <div class="description">
                    <h2>Barangay Certificate</h2>
                    <p>Barangay Certificate is an official document issued by your barangay captain that verifies your residency and good moral character.</p>
                </div>
            </a>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var dropdown = document.querySelector('.dropdown');
            var dropdownContent = dropdown.querySelector('.dropdown-content');
            var dropbtn = dropdown.querySelector('.dropbtn');

            dropdownContent.style.display = 'none';

            dropbtn.addEventListener('click', function(event) {
                dropdownContent.style.display =
                    dropdownContent.style.display === 'block' ? 'none' : 'block';
                event.stopPropagation();
            });

            document.addEventListener('click', function(event) {
                if (!dropdown.contains(event.target)) {
                    dropdownContent.style.display = 'none';
                }
            });
        });

        let lastScrollY = window.scrollY;

        window.addEventListener('scroll', function() {
            const header = document.querySelector('header');
            if (window.scrollY > lastScrollY) {
                header.style.transform = 'translateY(-100%)';
            } else {
                header.style.transform = 'translateY(0)';
            }
            lastScrollY = window.scrollY;
        });

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

</body>

</html>
