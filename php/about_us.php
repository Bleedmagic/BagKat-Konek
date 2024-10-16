<?php
include 'session_language.php';
include 'header.php';
include 'config.php';

$sql = "SELECT * FROM facilities";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About / BagKat</title>
    <link rel="stylesheet" href="../css/about_us.css">
</head>

<body>

    <div class="au">
        <div class="text">
            <h2><b><?php echo translate('ABOUT US'); ?></b></h2>
        </div>
    </div>

    <div class="slideshow-container">
        <div class="slides">
            <img src="../images/about_slide1.png" alt="Slide 1">
        </div>
        <div class="slides">
            <img src="../images/about_slide2.png" alt="Slide 2">
        </div>
        <div class="slides">
            <img src="../images/about_slide3.png" alt="Slide 3">
        </div>
    </div>

    <div class="mission-vision-titles">
    </div>
    <div class="mission-vision-container">
        <div class="mission-vision">
            <h1><?php echo translate('MISSION'); ?></h1>
            <p><?php echo translate('To help our residents improve their quality of life through the services we provide.'); ?></p>
        </div>
        <div class="mission-vision vision">
            <h1><?php echo translate('VISION'); ?></h1>
            <p><?php echo translate('A vibrant, healthy, progressive, peaceful and compassionate community.'); ?></p>
        </div>
    </div>

    <div class="facilities-container">
        <h1><?php echo translate('BARANGAY FACILITIES'); ?></h1>
        <div class="facilities" id="facilities">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>

                    <div class='facility'>
                        <img src='<?= $row["image_path"] ?>' alt='<?= $row["title"] ?>'>
                        <h2><?= $row["title"] ?></h2>
                    </div>

            <?php
                }
            } else {
                echo "No facilities found";
            }
            $conn->close();
            ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="../js/dropdowntoggle.js"></script>
    <script src="../js/headerscroll.js"></script>

    <script>
        let slideIndex = 0;
        showSlides();

        function showSlides() {
            let slides = document.getElementsByClassName('slides');
            for (let i = 0; i < slides.length; i++) {
                slides[i].style.display = 'none';
            }
            slideIndex++;
            if (slideIndex > slides.length) {
                slideIndex = 1;
            }
            slides[slideIndex - 1].style.display = 'block';
            setTimeout(showSlides, 3000);
        }
    </script>
</body>

</html>
