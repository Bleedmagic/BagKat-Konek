<?php
include 'header_admin.php';
include 'config.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST["delete"])) {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $subject = isset($_POST['subject']) ? $_POST['subject'] : '';
    $message_content = isset($_POST['message']) ? $_POST['message'] : '';

    if ($name && $email && $phone && $subject && $message_content) {
        $sql = "INSERT INTO contact_us (name, email, phone, subject, message)
                VALUES ('$name', '$email', '$phone', '$subject', '$message_content')";

        if (mysqli_query($conn, $sql)) {
            $message = "Message sent successfully";
        } else {
            $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        $message = "All fields are required.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
    $id = isset($_POST['id']) ? $_POST['id'] : '';

    if ($id) {
        $sql = "DELETE FROM contact_us WHERE id='$id'";

        if (mysqli_query($conn, $sql)) {
            $message = "Message deleted successfully";
        } else {
            $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        $message = "Invalid ID.";
    }
}

$sql = "SELECT * FROM contact_us";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact List / BagKat</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="../css/admin_contact_us.css">
</head>

<body>

    <div class="main-content">
        <div class="main">
            <h1>CONTACT MESSAGES</h1>
        </div>

        <div class="dashboard">
            <div class="table-wrapper">
                <table id="messagesTable" class="hover-table">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Submission Date</th>
                        <th>Actions</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['subject']; ?></td>
                            <td><?php echo $row['message']; ?></td>
                            <td><?php echo $row['submission_date']; ?></td>
                            <td>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="delete" value="true">
                                    <button class="delete-button" type="submit" onclick="return confirmDelete()">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this message?');
        }
    </script>
</body>

</html>
