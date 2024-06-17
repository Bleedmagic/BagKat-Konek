<?php
include_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $address = $_POST['address'];
    $sex = $_POST['sex'];
    $dob = $_POST['dob'];
    $pob = $_POST['pob'];
    $civil_status = $_POST['civil_status'];
    $findings = $_POST['findings'];
    $purpose = $_POST['purpose'];
    $issue_date = $_POST['issue_date'];
    $status = 'Pending';

    $sql = "INSERT INTO barangay_clearance (fname, mname, lname, address, sex, dob, pob, civil_status, findings, purpose, issue_date, status) 
            VALUES ('$fname', '$mname', '$lname', '$address', '$sex', '$dob', '$pob', '$civil_status', '$findings', '$purpose', '$issue_date', '$status')";

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        echo "<script>alert('Record added successfully'); window.location.href = 'barangay_clearance.php';</script>";
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
    <title>Certificate Form / BagKat</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="../css/barangay_clearance.css">
</head>

<body>
    <main>
        <div class="container">
            <div class="form-header">
                <img src="../images/bk_logo.png" alt="Logo">
                <h1>Barangay Certification for Clearance</h1>
            </div>
            <form method="post" action="barangay_clearance.php" enctype='multipart/form-data'>
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
                        <label for="sex">Gender:</label>
                        <select id="sex" name="sex" required>
                            <option value="" disabled selected>Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dob">Date of Birth:</label>
                        <input type="date" id="dob" name="dob" required>
                    </div>
                    <div class="form-group">
                        <label for="pob">Place of Birth:</label>
                        <input type="text" id="pob" name="pob" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="civil_status">Civil Status:</label>
                        <select name="civil_status" id="civil_status" required>
                            <option value="" disabled selected>Civil Status</option>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Widowed">Widowed</option>
                            <option value="Separated">Separated</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="findings">Findings:</label>
                        <input type="text" id="findings" name="findings" required>
                    </div>
                    <div class="form-group">
                        <label for="purpose">Purpose:</label>
                        <input type="text" id="purpose" name="purpose" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="issue_date">Issue Date:</label>
                        <input type="date" id="issue_date" name="issue_date" value="<?php echo date('Y-m-d'); ?>" required>
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
