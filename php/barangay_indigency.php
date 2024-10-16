<?php
include_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $address = $_POST['address'];
    $issue_date = $_POST['issue_date'];
    $purpose = $_POST['purpose'];

    $sql = "INSERT INTO barangay_indigency (fname, mname, lname, address, issue_date, purpose, status) 
            VALUES ('$fname', '$mname', '$lname', '$address', '$issue_date', '$purpose', 'Pending')";

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        echo "<script>alert('Record added successfully'); window.location.href = 'barangay_indigency.php';</script>";
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indigency Form / BagKat</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="../css/barangay_indigency.css">
</head>

<body>
    <main>
        <div class="container">
            <div class="form-header">
                <img src="../images/bk_logo.png" alt="Logo">
                <h1>Barangay Certification for Indigency</h1>
            </div>
            <form method="post" action="barangay_indigency.php" enctype='multipart/form-data'>
                <div class="form-row">
                    <div class="form-group">
                        <label for="fname">First Name:</label>
                        <input type="text" id="fname" name="fname" required>
                    </div>
                    <div class="form-group">
                        <label for="mname">Middle Name:</label>
                        <input type="text" id="mname" name="mname">
                    </div>
                    <div class="form-group">
                        <label for="lname">Last Name:</label>
                        <input type="text" id="lname" name="lname" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group full-width">
                        <label for="address">Complete Address:</label>
                        <input type="text" id="address" name="address" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="issue_date">Issue Date:</label>
                        <input type="date" id="issue_date" name="issue_date" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="purpose">Purpose:</label>
                        <input type="text" id="purpose" name="purpose" required>
                    </div>
                </div>
                <div class="button-container">
                    <button type="button" onclick="window.location.href='residents.php'" class="back">Back</button>
                    <button type="submit">Submit</button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>
