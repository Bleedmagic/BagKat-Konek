<?php

include 'header_admin.php';
include 'config.php';

session_start();
$username = $_SESSION['username'];

function logAction($conn, $username, $action, $table_name, $record_id)
{
    $sql = "INSERT INTO audit_trail (admin_name, action, table_name, record_id) 
            VALUES ('$username', '$action', '$table_name', '$record_id')";
    if (!mysqli_query($conn, $sql)) {
        echo "Error logging action: " . mysqli_error($conn);
    }
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
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
    $res_date_registered = $_POST['res_date_registered'];
    $res_registered_by = $_POST['res_registered_by'];
    $action = $_POST['action'];

    if ($action == 'add') {
        $sql = "INSERT INTO residents (res_fname, res_mname, res_lname, res_type, res_house_num, res_street, res_brgy, res_city, res_zip, res_dob, res_pob, res_gender, res_civil_status, res_education_level, res_date_registered, res_registered_by) 
                VALUES ('$res_fname', '$res_mname', '$res_lname', '$res_type', '$res_house_num', '$res_street', '$res_brgy', '$res_city', '$res_zip', '$res_dob', '$res_pob', '$res_gender', '$res_civil_status', '$res_education_level', '$res_date_registered', '$res_registered_by')";

        if (mysqli_query($conn, $sql)) {
            $fetch_id_sql = "SELECT res_id FROM residents WHERE res_fname='$res_fname' AND res_mname='$res_mname' AND res_lname='$res_lname' AND res_type='$res_type' AND res_house_num='$res_house_num' AND res_street='$res_street' AND res_brgy='$res_brgy' AND res_city='$res_city' AND res_zip='$res_zip' AND res_dob='$res_dob' AND res_pob='$res_pob' AND res_gender='$res_gender' AND res_civil_status='$res_civil_status' AND res_education_level='$res_education_level' AND res_date_registered='$res_date_registered' AND res_registered_by='$res_registered_by' ORDER BY res_id DESC LIMIT 1";
            $result = mysqli_query($conn, $fetch_id_sql);
            if ($result) {
                $row = mysqli_fetch_assoc($result);
                $record_id = $row['res_id'];
                logAction($conn, $username, 'add', 'residents', $record_id);
                $message = "New resident added successfully";
            } else {
                $message = "Error fetching record ID: " . mysqli_error($conn);
            }
        } else {
            $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } elseif ($action == 'edit') {
        $res_id = $_POST['res_id'];
        $sql = "UPDATE residents SET res_fname='$res_fname', res_mname='$res_mname', res_lname='$res_lname', res_type='$res_type', res_house_num='$res_house_num', res_street='$res_street', res_brgy='$res_brgy', res_city='$res_city', res_zip='$res_zip', res_dob='$res_dob', res_pob='$res_pob', res_gender='$res_gender', res_civil_status='$res_civil_status', res_education_level='$res_education_level', res_date_registered='$res_date_registered', res_registered_by='$res_registered_by' WHERE res_id='$res_id'";

        if (mysqli_query($conn, $sql)) {
            logAction($conn, $username, 'edit', 'residents', $res_id);
            $message = "Resident updated successfully";
        } else {
            $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
    $res_id = $_POST['res_id'];

    $sql = "DELETE FROM residents WHERE res_id='$res_id'";

    if (mysqli_query($conn, $sql)) {
        logAction($conn, $username, 'delete', 'residents', $res_id);
        $message = "Resident deleted successfully";
    } else {
        $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

$sql = "SELECT * FROM residents";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Residents Records / BagKat</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="../css/admin_residents_records.css">
</head>

<body>

    <div class="main-content">
        <div class="main">
            <h1>BARANGAY RESIDENTS</h1>
        </div>

        <div class="dashboard">
            <div class="search-bar">
                <div class="input-container">
                    <span class="search-icon">&#x1F50D;</span>
                    <input type="text" id="search-official" onkeyup="searchTable()" placeholder="Search Resident Name">
                </div>
                <div class="button-up">
                    <button class="button" onclick="openPrintPage()">Print</button>
                    <!-- <button class="button" onclick="showPopup()">Archives</button> -->
                    <button class="button" onclick="showPopup('add')">Add Barangay Residents</button>
                </div>
            </div>
            <div class="table-wrapper">
                <table id="officialsTable" class="hover-table">
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Resident Type</th>
                        <th>Address</th>
                        <th>Date of Birth</th>
                        <th>Gender</th>
                        <th>Civil Status</th>
                        <th>Education Level</th>
                        <th>Date Registered</th>
                        <th>Actions</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?php echo $row['res_id']; ?></td>
                            <td><?php echo $row['res_fname'] . ' ' . $row['res_mname'] . ' ' . $row['res_lname']; ?></td>
                            <td><?php echo $row['res_type']; ?></td>
                            <td><?php echo $row['res_house_num'] . ' ' . $row['res_street'] . ', ' . $row['res_brgy'] . ', ' . $row['res_city'] . ', ' . $row['res_zip']; ?></td>
                            <td><?php echo $row['res_dob']; ?></td>
                            <td><?php echo $row['res_gender']; ?></td>
                            <td><?php echo $row['res_civil_status']; ?></td>
                            <td><?php echo $row['res_education_level']; ?></td>
                            <td><?php echo $row['res_date_registered']; ?></td>
                            <td>
                                <button class="edit-button" onclick='showPopup("edit", <?php echo json_encode($row); ?>)'>Edit</button>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" style="display:inline;">
                                    <input type="hidden" name="res_id" value="<?php echo $row['res_id']; ?>">
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

    <div class="popup" id="popup" style="display: none;">
        <div class="popup-content">
            <img src="../images/bk_logo.png" alt="Logo">
            <h2 id="popup-title">Add Barangay Resident</h2>
            <?php if (isset($message)) echo "<p style='color:green;'>$message</p>"; ?>
            <form id="popup-form" method="POST">
                <input type="hidden" name="action" id="form-action">
                <input type="hidden" name="res_id" id="res_id">

                <div class="form-group">
                    <label for="res_fname">First Name:</label>
                    <input type="text" name="res_fname" id="res_fname" required>
                </div>

                <div class="form-group">
                    <label for="res_mname">Middle Name:</label>
                    <input type="text" name="res_mname" id="res_mname">
                </div>

                <div class="form-group">
                    <label for="res_lname">Last Name:</label>
                    <input type="text" name="res_lname" id="res_lname" required>
                </div>

                <div class="form-group">
                    <label for="res_type">Resident Type:</label>
                    <select name="res_type" id="res_type" required>
                        <option value="SANGGUNIANG BARANGAY">Sangguniang Barangay</option>
                        <option value="SENIOR CITIZEN">Senior Citizen</option>
                        <option value="KABATAAN">Kabataan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="res_house_num">House Number:</label>
                    <input type="text" name="res_house_num" id="res_house_num" required>
                </div>

                <div class="form-group">
                    <label for="res_street">Street:</label>
                    <input type="text" name="res_street" id="res_street" required>
                </div>

                <div class="form-group">
                    <label for="res_brgy">Barangay:</label>
                    <input type="text" name="res_brgy" id="res_brgy" required>
                </div>

                <div class="form-group">
                    <label for="res_city">City:</label>
                    <input type="text" name="res_city" id="res_city" required>
                </div>

                <div class="form-group">
                    <label for="res_zip">Zip Code:</label>
                    <input type="text" name="res_zip" id="res_zip" required>
                </div>
                <div class="form-group">
                    <label for="res_dob">Date of Birth:</label>
                    <input type="date" name="res_dob" id="res_dob" required>
                </div>

                <div class="form-group">
                    <label for="res_pob">Place of Birth:</label>
                    <input type="text" name="res_pob" id="res_pob" required>
                </div>

                <div class="form-group">
                    <label for="res_gender">Gender:</label>
                    <select name="res_gender" id="res_gender" required>
                        <option value="MALE">Male</option>
                        <option value="FEMALE">Female</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="res_civil_status">Civil Status:</label>
                    <select name="res_civil_status" id="res_civil_status" required>
                        <option value="SINGLE">Single</option>
                        <option value="MARRIED">Married</option>
                        <option value="WIDOWED">Widowed</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="res_education_level">Education Level:</label>
                    <select name="res_education_level" id="res_education_level" required>
                        <option value="NONE">None</option>
                        <option value="ELEMENTARY">Elementary</option>
                        <option value="HIGH SCHOOL">High School</option>
                        <option value="COLLEGE">College</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="res_date_registered">Date Registered:</label>
                    <input type="date" name="res_date_registered" id="res_date_registered" required>
                </div>

                <div class="form-group">
                    <label for="res_registered_by">Registered By:</label>
                    <input type="text" name="res_registered_by" id="res_registered_by" required>
                </div>

                <div class="form-actions">
                    <input type="submit" value="Add">
                    <button type="button" onclick="hidePopup()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openPrintPage() {
            window.open('../pdf/residents_reports.php', '_blank');
        }

        function searchTable() {
            const input = document.getElementById("search-official");
            const filter = input.value.toLowerCase();
            const table = document.getElementById("officialsTable");
            const tr = table.getElementsByTagName("tr");

            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName("td")[1];
                if (td) {
                    const textValue = td.textContent || td.innerText;
                    tr[i].style.display = textValue.toLowerCase().indexOf(filter) > -1 ? "" : "none";
                }
            }
        }

        function showPopup(action, resident = null) {
            const popup = document.getElementById('popup');
            const formAction = document.getElementById('form-action');
            const formTitle = document.getElementById('popup-title');
            const submitButton = document.querySelector('#popup-form input[type="submit"]');

            formAction.value = action;
            formTitle.innerText = action === 'add' ? 'Add Barangay Resident' : 'Edit Barangay Resident';
            submitButton.value = action === 'add' ? 'Add' : 'Update';

            if (action === 'edit' && resident) {
                document.getElementById('res_id').value = resident.res_id;
                document.getElementById('res_fname').value = resident.res_fname;
                document.getElementById('res_mname').value = resident.res_mname;
                document.getElementById('res_lname').value = resident.res_lname;
                document.getElementById('res_type').value = resident.res_type;
                document.getElementById('res_house_num').value = resident.res_house_num;
                document.getElementById('res_street').value = resident.res_street;
                document.getElementById('res_brgy').value = resident.res_brgy;
                document.getElementById('res_city').value = resident.res_city;
                document.getElementById('res_zip').value = resident.res_zip;
                document.getElementById('res_dob').value = resident.res_dob;
                document.getElementById('res_pob').value = resident.res_pob;
                document.getElementById('res_gender').value = resident.res_gender;
                document.getElementById('res_civil_status').value = resident.res_civil_status;
                document.getElementById('res_education_level').value = resident.res_education_level;
                document.getElementById('res_date_registered').value = resident.res_date_registered;
                document.getElementById('res_registered_by').value = resident.res_registered_by;
            } else {
                document.getElementById('popup-form').reset();
            }

            popup.style.display = 'flex';
        }

        function hidePopup() {
            const popup = document.getElementById('popup');
            popup.style.display = 'none';
        }

        function confirmDelete() {
            return confirm('Are you sure you want to delete this resident?');
        }
    </script>
</body>

</html>
