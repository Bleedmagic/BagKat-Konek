<?php
include 'session_language.php';
include 'header.php';
include 'config.php';

$stmt = $conn->prepare("SELECT * FROM contact_info WHERE id = 1");
$stmt->execute();
$result = $stmt->get_result();
$contact = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us / BagKat</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="../css/contact_us.css">
    <style>
        .language-button {
            display: none;
        }
    </style>
</head>

<body>

    <div class="au">
        <div class="text">
            <h2><b>CONTACT US</b></h2>
        </div>
    </div>

    <main>
        <div class="contact-info">
            <h2>Contact Information</h2>
            <?php if ($contact) : ?>
                <?php echo htmlspecialchars($contact['phone']); ?><br>
                <?php echo htmlspecialchars($contact['facebook']); ?><br>
                <?php echo htmlspecialchars($contact['email']); ?><br>
                <?php echo htmlspecialchars($contact['address']); ?><br><br>
            <?php else : ?>
                <p>No contact information available.</p>
            <?php endif; ?>

            <div class="container">

                <iframe class="responsive-iframe" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1930.8523780430264!2d121.07336988881615!3d14.558868842565332!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c87e92045213%3A0x32cd2c0a722d4ec9!2sBagong%20Katipunan%2C%20Pasig%2C%20Kalakhang%20Maynila!5e0!3m2!1sfil!2sph!4v1716425103076!5m2!1sfil!2sph" width="500" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>

        <div class="contact-bg">
            <div class="contact-section">
                <h1>CONTACT US</h1>
                <form id="contact-form" method="POST">
                    Reach out to us with any questions, concerns, or inquiries - we're here to assist you! <br><br>
                    <div class="contact-labels">
                        <label for="name">Name:</label><br>
                        <input type="text" id="name" name="name" placeholder="Enter your name" required><br>
                        <label for="email">Email Address:</label><br>
                        <input type="email" id="email" name="email" placeholder="Enter your email address" required><br>
                        <label for="phone">Phone:</label><br>
                        <input type="text" id="phone" name="phone" placeholder="Enter your phone number" required><br>
                        <label for="subject">Subject:</label><br>
                        <input type="text" id="subject" name="subject" placeholder="Enter the subject" required><br>
                        <label for="message">Message/Concern:</label><br>
                        <input type="text" id="message" name="message" placeholder="Type your message" required><br>
                    </div>
                    <input type="submit" value="Send">
                </form>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>

    <script src="../js/dropdowntoggle.js"></script>
    <script src="../js/headerscroll.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#contact-form').submit(function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: 'admin_contact_us.php',
                    data: formData,
                    success: function(response) {
                        alert('Message sent successfully!');
                        $('#contact-form')[0].reset();
                    },
                    error: function(xhr, status, error) {
                        alert('Error: ' + error);
                    }
                });
            });
        });
    </script>
</body>

</html>
