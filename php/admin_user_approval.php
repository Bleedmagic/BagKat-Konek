<?php include 'header_admin.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Approval / BagKat</title>
    <link rel="stylesheet" href="../css/admin_user_approval.css">
</head>

<body>

    <div class="main-content">
        <div class="main">
            <h1>REPORTS: USER APPROVAL</h1>
        </div>

        <div class="dashboard">
            <div class="filter-buttons">
                <button onclick="filterAccounts('PENDING')">Pending</button>
                <button onclick="filterAccounts('APPROVED')">Approved</button>
                <button onclick="filterAccounts('DECLINED')">Declined</button>
            </div>
            <div class="table-wrapper">
                <table id="officialsTable" class="hover-table">
                    <thead>
                        <tr>
                            <th>Request No.</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            <th>Address</th>
                            <th>Valid ID</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'config.php';

                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            if (isset($_POST['approve_user'])) {
                                $user_id = $_POST['user_id'];
                                $sql_select_request = "SELECT * FROM sign_up_requests_temp WHERE request_id = ?";
                                $stmt_select_request = $conn->prepare($sql_select_request);
                                $stmt_select_request->bind_param('i', $user_id);
                                $stmt_select_request->execute();
                                $result_select_request = $stmt_select_request->get_result();

                                if ($result_select_request->num_rows > 0) {
                                    $user_info = $result_select_request->fetch_assoc();
                                    $res_username = $user_info['res_username'];
                                    $user_email = $user_info['user_email'];
                                    $user_password = $user_info['user_password'];

                                    $sql_insert_user = "INSERT INTO user_accounts (res_username, user_email, user_password)
                                                        VALUES (?, ?, MD5(?))";
                                    $stmt_insert_user = $conn->prepare($sql_insert_user);
                                    $stmt_insert_user->bind_param('sss', $res_username, $user_email, $user_password);
                                    if ($stmt_insert_user->execute()) {
                                        $sql_update_request = "UPDATE sign_up_requests_temp SET status = 'APPROVED' WHERE request_id = ?";
                                        $stmt_update_request = $conn->prepare($sql_update_request);
                                        $stmt_update_request->bind_param('i', $user_id);
                                        if ($stmt_update_request->execute()) {
                                            echo "<p>User account approved and created successfully.</p>";
                                            echo "<script>window.location.href = '?status=PENDING';</script>";
                                        } else {
                                            echo "<p>Error updating request status to APPROVED.</p>";
                                        }
                                    } else {
                                        echo "<p>Error creating user account.</p>";
                                    }
                                } else {
                                    echo "<p>Request not found.</p>";
                                }
                            } elseif (isset($_POST['decline_user'])) {
                                $user_id = $_POST['user_id'];
                                $sql_update_status = "UPDATE sign_up_requests_temp SET status = 'DECLINED' WHERE request_id = ?";
                                $stmt_update_status = $conn->prepare($sql_update_status);
                                $stmt_update_status->bind_param('i', $user_id);
                                if ($stmt_update_status->execute()) {
                                    echo "<p>User account declined successfully.</p>";
                                    echo "<script>window.location.href = '?status=PENDING';</script>";
                                } else {
                                    echo "<p>Error declining user account.</p>";
                                }
                            }
                        }

                        $status_filter = 'PENDING';
                        if (isset($_GET['status'])) {
                            $status_filter = $_GET['status'];
                        }

                        $sql = "SELECT * FROM sign_up_requests_temp WHERE status = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param('s', $status_filter);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['request_id'] . "</td>";
                                echo "<td>" . $row['res_fname'] . "</td>";
                                echo "<td>" . $row['res_mname'] . "</td>";
                                echo "<td>" . $row['res_lname'] . "</td>";
                                echo "<td>" . $row['res_street'] . ", " . $row['res_brgy'] . ", " . $row['res_city'] . "</td>";
                                echo "<td>";
                                echo "<button onclick=\"openPopup('../uploads/" . $row['id_image_path'] . "')\">View</button>";
                                echo "</td>";
                                echo "<td>";
                                if ($status_filter === 'PENDING') {
                                    echo "<form action='' method='post'>
                                            <input type='hidden' name='user_id' value='" . $row['request_id'] . "'>
                                            <button type='submit' name='approve_user'>Approve</button>
                                            <button type='submit' name='decline_user'>Decline</button>
                                        </form>";
                                } else {
                                    echo "<p>No action available</p>";
                                }
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No requests found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="myPopup" class="popup">
        <div class="popup-content">
            <span class="close" onclick="closePopup()">&times;</span>
            <img id="popupImage" src="" alt="Profile Image">
        </div>
    </div>

    <script>
        function filterAccounts(status) {
            window.location.href = '?status=' + status;
        }

        function openPopup(imageSrc) {
            document.getElementById('popupImage').src = imageSrc;
            document.getElementById('myPopup').style.display = "block";
        }

        function closePopup() {
            document.getElementById('myPopup').style.display = "none";
        }
    </script>
</body>

</html>
