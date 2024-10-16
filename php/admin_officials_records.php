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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {
    $action = $_POST["action"];
    if ($action == "add") {
        $off_fname = $_POST['off_fname'];
        $off_mname = $_POST['off_mname'];
        $off_lname = $_POST['off_lname'];
        $off_position = $_POST['off_position'];
        $off_term_start = $_POST['off_term_start'];
        $off_term_end = $_POST['off_term_end'];

        $sql = "INSERT INTO officials (off_fname, off_mname, off_lname, off_position, off_term_start, off_term_end, status) 
                VALUES ('$off_fname', '$off_mname', '$off_lname', '$off_position', '$off_term_start', '$off_term_end', 'ACTIVE')";

        if (mysqli_query($conn, $sql)) {
            $fetch_id_sql = "SELECT off_id FROM officials WHERE off_fname='$off_fname' AND off_mname='$off_mname' AND off_lname='$off_lname' AND off_position='$off_position' AND off_term_start='$off_term_start' AND off_term_end='$off_term_end' ORDER BY off_id DESC LIMIT 1";
            $result = mysqli_query($conn, $fetch_id_sql);
            if ($result) {
                $row = mysqli_fetch_assoc($result);
                $record_id = $row['off_id'];
                logAction($conn, $username, 'add', 'officials', $record_id);
                $message = "New official added successfully";
            } else {
                $message = "Error fetching record ID: " . mysqli_error($conn);
            }
        } else {
            $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } elseif ($action == "edit") {
        $off_id = $_POST['off_id'];
        $off_fname = $_POST['off_fname'];
        $off_mname = $_POST['off_mname'];
        $off_lname = $_POST['off_lname'];
        $off_position = $_POST['off_position'];
        $off_term_start = $_POST['off_term_start'];
        $off_term_end = $_POST['off_term_end'];

        $sql = "UPDATE officials SET off_fname='$off_fname', off_mname='$off_mname', off_lname='$off_lname', off_position='$off_position', off_term_start='$off_term_start', off_term_end='$off_term_end', status='ACTIVE' WHERE off_id='$off_id'";

        if (mysqli_query($conn, $sql)) {
            logAction($conn, $username, 'edit', 'officials', $off_id);
            $message = "Official updated successfully";
        } else {
            $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } elseif ($action == "archive") {
        $off_id = $_POST['off_id'];

        $sql = "UPDATE officials SET status='INACTIVE' WHERE off_id='$off_id'";

        if (mysqli_query($conn, $sql)) {
            logAction($conn, $username, 'archive', 'officials', $off_id);
            $message = "Official archived successfully";
        } else {
            $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } elseif ($action == "delete") {
        $off_id = $_POST['off_id'];

        $sql = "DELETE FROM officials WHERE off_id='$off_id'";

        if (mysqli_query($conn, $sql)) {
            logAction($conn, $username, 'delete', 'officials', $off_id);
            $message = "Official deleted successfully";
            echo "<script>alert('$message');</script>";
        } else {
            $message = "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}

$sql = "SELECT * FROM officials WHERE status='ACTIVE'";
$result = mysqli_query($conn, $sql);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Officials Records / BagKat</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="../css/admin_officials_records.css">
</head>

<body>
    <div class="main-content">
        <div class="main">
            <h1>BARANGAY OFFICIALS</h1>
        </div>

        <div class="dashboard">
            <div class="search-bar">
                <div class="input-container">
                    <span class="search-icon">&#x1F50D;</span>
                    <input type="text" id="search-official" onkeyup="searchTable()" placeholder="Search Official">
                </div>
                <div class="input-container-year">
                    <input type="text" id="search-year" onkeyup="searchTable()" placeholder="Year">
                </div>
                <div class="button-up">
                    <button class="button" onclick="openPrintPage()">Print</button>
                    <!-- <button class="button" onclick="showArchivesPopup()">Archives</button> -->
                    <button class="button" onclick="showPopup('add')">Add Barangay Officials</button>
                </div>
            </div>
            <div class="table-wrapper">
                <table id="officialsTable" class="hover-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Position</th>
                            <th>Term Start</th>
                            <th>Term End</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                            <tr>
                                <td><?php echo $row['off_id']; ?></td>
                                <td><?php echo $row['off_fname'] . ' ' . $row['off_mname'] . ' ' . $row['off_lname']; ?></td>
                                <td><?php echo $row['off_position']; ?></td>
                                <td><?php echo $row['off_term_start']; ?></td>
                                <td><?php echo $row['off_term_end']; ?></td>
                                <td>
                                    <button class="edit-button" onclick='showPopup("edit", <?php echo json_encode($row); ?>)'>Edit</button>
                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" style="display:inline;">
                                        <input type="hidden" name="off_id" value="<?php echo $row['off_id']; ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <button class="delete-button" type="submit" onclick="return confirmDelete()">Delete</button>
                                    </form>
                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" style="display:inline;">
                                        <input type="hidden" name="off_id" value="<?php echo $row['off_id']; ?>">
                                        <input type="hidden" name="action" value="archive">
                                        <!-- <button class="archive-button" type="submit" onclick="return confirmArchive()">Archive</button> -->
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="popup" id="popup">
        <div class="popup-content">
            <img src="../images/bk_logo.png" alt="Logo">
            <h2 id="popup-title">Add Barangay Official</h2>
            <?php if (isset($message)) echo "<p style='color:green;'>$message</p>"; ?>
            <form id="popup-form" method="POST">
                <input type="hidden" name="action" id="form-action">
                <input type="hidden" name="off_id" id="off_id">
                First Name:
                <input type="text" name="off_fname" id="off_fname" required><br><br>
                Middle Name:
                <input type="text" name="off_mname" id="off_mname"><br><br>
                Last Name:
                <input type="text" name="off_lname" id="off_lname" required><br><br>
                Position:
                <select name="off_position" id="off_position" required>
                    <option value="PUNONG BARANGAY">Punong Barangay</option>
                    <option value="BARANGAY SECRETARY">Barangay Secretary</option>
                    <option value="BARANGAY KAGAWAD">Barangay Kagawad</option>
                    <option value="BARANGAY TREASURER">Barangay Treasurer</option>
                </select><br><br>
                Term Start:
                <input type="date" name="off_term_start" id="off_term_start" required><br><br>
                Term End:
                <input type="date" name="off_term_end" id="off_term_end"><br><br>
                <input type="submit" value="Submit">
                <button type="button" onclick="hidePopup()">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        function openPrintPage() {
            window.open('../pdf/officials_reports.php', '_blank');
        }

        function showPopup(action, data = null) {
            document.getElementById('popup').style.display = 'flex';
            document.getElementById('popup-title').innerText =
                action === 'add' ? 'Add Official' : 'Edit Official';
            document.getElementById('form-action').value = action;

            if (action === 'add') {
                document.getElementById('popup-form').reset();
                document.getElementById('off_id').readOnly = false;
            } else if (action === 'edit' && data) {
                document.getElementById('off_id').value = data.off_id;
                document.getElementById('off_id').readOnly = true;
                document.getElementById('off_fname').value = data.off_fname;
                document.getElementById('off_mname').value = data.off_mname;
                document.getElementById('off_lname').value = data.off_lname;
                document.getElementById('off_position').value = data.off_position;
                document.getElementById('off_term_start').value = data.off_term_start;
                document.getElementById('off_term_end').value = data.off_term_end;
            }
        }

        function hidePopup() {
            document.getElementById('popup').style.display = 'none';
        }

        function confirmDelete() {
            return confirm('Are you sure you want to delete this official?');
        }

        function confirmArchive() {
            return confirm('Are you sure you want to archive this official?');
        }

        function searchTable() {
            let input = document.getElementById('search-official').value.toUpperCase();
            let inputYear = document.getElementById('search-year').value.toUpperCase();
            let table = document.getElementById('officialsTable');
            let tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                let tdName = tr[i].getElementsByTagName('td')[1];
                let tdStart = tr[i].getElementsByTagName('td')[3];
                if (tdName && tdStart) {
                    let txtValue = tdName.textContent || tdName.innerText;
                    let yearValue = tdStart.textContent || tdStart.innerText;
                    if (
                        txtValue.toUpperCase().indexOf(input) > -1 &&
                        yearValue.toUpperCase().indexOf(inputYear) > -1
                    ) {
                        tr[i].style.display = '';
                    } else {
                        tr[i].style.display = 'none';
                    }
                }
            }
        }
    </script>
</body>

</html>
