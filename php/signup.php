<?php
session_start();

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $res_fname = $_POST['res_fname'];
    $res_mname = $_POST['res_mname'];
    $res_lname = $_POST['res_lname'];
    $res_type = $_POST['res_type'];
    $res_house_num = $_POST['res_house_num'];
    $res_street = $_POST['res_street'];
    $res_brgy = $_POST['res_brgy'];
    $res_city = $_POST['res_city'];
    $res_zip = $_POST['res_zip'];
    $res_dob = $_POST['res_dob'];
    $res_pob = $_POST['res_pob'];
    $res_gender = $_POST['res_gender'];
    $res_civil_status = $_POST['res_civil_status'];
    $res_education_level = $_POST['res_education_level'];
    $user_email = $_POST['user_email'];
    $res_username = $_POST['res_username'];
    $user_password = $_POST['user_password'];

    $image = $_FILES['brgyId'];

    $fullname = "$res_fname-$res_mname-$res_lname";

    $filename       = $image['name'];
    $tempname       = $image['tmp_name'];
    $filetype       = $image['type'];
    $filename       = $fullname . '.' . pathinfo($filename, PATHINFO_EXTENSION);
    $folder         = '../uploads/' . $filename;

    move_uploaded_file($tempname, $folder);

    $stmt = $conn->prepare("SELECT COUNT(*) FROM user_accounts WHERE res_username = ?");
    $stmt->bind_param("s", $res_username);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    $count = $count ?? 0;

    if ($count > 0) {
        echo "<script>alert('Username already exists. Please choose a different username.');</script>";
    } else {
        $password_valid = true;
        if (strlen($user_password) < 8 || strlen($user_password) > 20) {
            $password_valid = false;
        }
        if (!preg_match("/[A-Z]/", $user_password)) {
            $password_valid = false;
        }
        if (!preg_match("/[a-z]/", $user_password)) {
            $password_valid = false;
        }
        if (!preg_match("/[0-9]/", $user_password)) {
            $password_valid = false;
        }
        if (!preg_match("/[^A-Za-z0-9]/", $user_password)) {
            $password_valid = false;
        }

        if (!$password_valid) {
            echo "<script>alert('Password must be 8-20 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one symbol.');</script>";
        } else {
            $stmt = $conn->prepare("INSERT INTO sign_up_requests_temp (res_fname, res_mname, res_lname, res_type, res_house_num, res_street, res_brgy, res_city, res_zip, res_dob, res_pob, res_gender, res_civil_status, res_education_level, user_email, res_username, user_password, id_image_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssssssssssssss", $res_fname, $res_mname, $res_lname, $res_type, $res_house_num, $res_street, $res_brgy, $res_city, $res_zip, $res_dob, $res_pob, $res_gender, $res_civil_status, $res_education_level, $user_email, $res_username, $user_password, $filename);

            if ($stmt->execute()) {
                $_SESSION['message'] = 'Your account is pending approval. Please wait for admin confirmation.';
                header("Location: signup.php");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up / BagKat</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="../css/signup.css">
</head>

<body>
    <div class="login-container">
        <div class="logo">
            <img src="../images/bk_logo.png" alt="BagKat Logo">
        </div>
        <h2>Registration</h2>

        <form id="signupForm" action="signup.php" method="POST" enctype="multipart/form-data" class="signup-form">
            <div class="input-group">
                <label for="res_fname">First Name:</label>
                <div class="input-wrapper">
                    <input type="text" id="res_fname" name="res_fname" placeholder="First Name" required>
                </div>
            </div>

            <div class="input-group">
                <label for="res_mname">Middle Name:</label>
                <div class="input-wrapper">
                    <input type="text" id="res_mname" name="res_mname" placeholder="Middle Name">
                </div>
            </div>

            <div class="input-group">
                <label for="res_lname">Last Name:</label>
                <div class="input-wrapper">
                    <input type="text" id="res_lname" name="res_lname" placeholder="Last Name" required>
                </div>
            </div>

            <div class="input-group">
                <label for="res_type">Resident Type:</label>
                <div class="input-wrapper">
                    <select id="res_type" name="res_type" required>
                        <option value="" disabled selected>Select Resident Type</option>
                        <option value="SANGGUNIANG BARANGAY">Sangguniang Barangay</option>
                        <option value="SENIOR CITIZEN">Senior Citizen</option>
                        <option value="KABATAAN">Kabataan</option>
                    </select>
                </div>
            </div>

            <div class="input-group">
                <label for="res_house_num">House Number:</label>
                <div class="input-wrapper">
                    <input type="text" id="res_house_num" name="res_house_num" placeholder="House Number">
                </div>
            </div>

            <div class="input-group">
                <label for="res_street">Street:</label>
                <div class="input-wrapper">
                    <input type="text" id="res_street" name="res_street" placeholder="Street">
                </div>
            </div>

            <div class="input-group">
                <label for="res_brgy">Barangay:</label>
                <div class="input-wrapper">
                    <select id="res_brgy" name="res_brgy" required>
                        <option value="Bagong Katipunan" selected>Bagong Katipunan</option>
                    </select>
                </div>
            </div>

            <div class="input-group">
                <label for="res_city">City:</label>
                <div class="input-wrapper">
                    <select id="res_city" name="res_city" required>
                        <option value="Pasig City" selected>Pasig City</option>
                    </select>
                </div>
            </div>

            <div class="input-group">
                <label for="res_zip">Zip Number:</label>
                <div class="input-wrapper">
                    <input type="text" id="res_zip" name="res_zip" placeholder="Zip Number">
                </div>
            </div>

            <div class="input-group">
                <label for="res_dob">Date of Birth:</label>
                <div class="input-wrapper">
                    <input type="date" id="res_dob" name="res_dob" placeholder="YYYY-MM-DD" pattern="\d{4}-\d{2}-\d{2}" title="Please enter a valid date in the format YYYY-MM-DD" required>
                </div>
            </div>

            <div class="input-group">
                <label for="res_pob">Place of Birth:</label>
                <div class="input-wrapper">
                    <input type="text" id="res_pob" name="res_pob" placeholder="Place of Birth" required>
                </div>
            </div>

            <div class="input-group">
                <label for="res_gender">Gender:</label>
                <div class="input-wrapper">
                    <select id="res_gender" name="res_gender" required>
                        <option value="" disabled selected>Select Gender</option>
                        <option value="MALE">Male</option>
                        <option value="FEMALE">Female</option>
                    </select>
                </div>
            </div>

            <div class="input-group">
                <label for="res_civil_status">Civil Status:</label>
                <div class="input-wrapper">
                    <select id="res_civil_status" name="res_civil_status" required>
                        <option value="" disabled selected>Civil Status</option>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Widowed">Widowed</option>
                    </select>
                </div>
            </div>

            <div class="input-group">
                <label for="res_education_level">Education Level:</label>
                <div class="input-wrapper">
                    <select id="res_education_level" name="res_education_level" required>
                        <option value="" disabled selected>Education Attainment</option>
                        <option value="Elementary">Elementary</option>
                        <option value="High School">High School</option>
                        <option value="College">College</option>
                    </select>
                </div>
            </div>

            <div class="input-group">
                <label for="user_email">Email:</label>
                <div class="input-wrapper">
                    <input type="email" id="user_email" name="user_email" placeholder="Email" required>
                </div>
            </div>

            <div class="input-group">
                <label for="res_username">Username:</label>
                <div class="input-wrapper">
                    <input type="text" id="res_username" name="res_username" placeholder="Username" required>
                </div>
            </div>

            <div class="input-group">
                <label for="user_password">Password:</label>
                <div class="input-wrapper">
                    <input type="password" id="user_password" name="user_password" placeholder="Password" required>
                    <span class="password-toggle" onclick="togglePassword()">
                        <span id="showIcon">👁️</span>
                        <span id="hideIcon" style="display: none;">🙈</span>
                    </span>
                </div>
            </div>

            <ul id="passwordRequirements" class="password-requirements">
                <li id="length" class="invalid">Use 8-20 characters</li>
                <li id="uppercase" class="invalid">One uppercase letter</li>
                <li id="lowercase" class="invalid">One lowercase letter</li>
                <li id="number" class="invalid">One number</li>
                <li id="symbol" class="invalid">One symbol</li>
            </ul>

            <div class="input-group">
                <label for="brgyId">Upload Barangay ID / Valid ID:</label>
                <div class="input-wrapper">
                    <input type="file" id="brgyId" name="brgyId">
                </div>
            </div>


            <div class="button-group">
                <button type="button" onclick="window.location.href='home.php'">Back</button>
                <button type="submit">Submit</button>
            </div>
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </form>
    </div>

    <script>
        function togglePassword() {
            var passwordInput = document.getElementById('user_password');
            var showIcon = document.getElementById('showIcon');
            var hideIcon = document.getElementById('hideIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                showIcon.style.display = 'none';
                hideIcon.style.display = 'inline';
            } else {
                passwordInput.type = 'password';
                showIcon.style.display = 'inline';
                hideIcon.style.display = 'none';
            }
        }

        const passwordInput = document.getElementById('user_password');
        const requirementsList = document.getElementById('passwordRequirements');
        const lengthReq = document.getElementById('length');
        const uppercaseReq = document.getElementById('uppercase');
        const lowercaseReq = document.getElementById('lowercase');
        const numberReq = document.getElementById('number');
        const symbolReq = document.getElementById('symbol');

        const showRequirements = () => (requirementsList.style.display = 'block');
        const hideRequirements = () => (requirementsList.style.display = 'none');

        const validatePassword = () => {
            const password = passwordInput.value;
            const lengthValid = password.length >= 8 && password.length <= 20;
            const uppercaseValid = /[A-Z]/.test(password);
            const lowercaseValid = /[a-z]/.test(password);
            const numberValid = /[0-9]/.test(password);
            const symbolValid = /[^A-Za-z0-9]/.test(password);

            lengthReq.classList.toggle('valid', lengthValid);
            lengthReq.classList.toggle('invalid', !lengthValid);

            uppercaseReq.classList.toggle('valid', uppercaseValid);
            uppercaseReq.classList.toggle('invalid', !uppercaseValid);

            lowercaseReq.classList.toggle('valid', lowercaseValid);
            lowercaseReq.classList.toggle('invalid', !lowercaseValid);

            numberReq.classList.toggle('valid', numberValid);
            numberReq.classList.toggle('invalid', !numberValid);

            symbolReq.classList.toggle('valid', symbolValid);
            symbolReq.classList.toggle('invalid', !symbolValid);
        };

        passwordInput.addEventListener('focus', showRequirements);
        passwordInput.addEventListener('blur', hideRequirements);
        passwordInput.addEventListener('input', validatePassword);

        document.addEventListener('DOMContentLoaded', function() {
            <?php if (isset($_SESSION['message'])) : ?>
                alert('<?php echo $_SESSION['message']; ?>');
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>
        });
    </script>
</body>

</html>
