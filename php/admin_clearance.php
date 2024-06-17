<?php include 'header_admin.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clearance Requests / BagKat</title>
    <link rel="stylesheet" href="../css/admin_clearance.css">
</head>

<body>

    <div class="main-content">
        <div class="main">
            <h1>CERTIFICATION APPROVAL: BARANGAY CLEARANCE</h1>
        </div>

        <div class="dashboard">
            <div class="filter-buttons">
                <button onclick="filterRequests('All')">All</button>
                <button onclick="filterRequests('Pending')">Pending</button>
                <button onclick="filterRequests('Approved')">Approved</button>
                <button onclick="filterRequests('Declined')">Declined</button>
                <button onclick="filterRequests('Cancelled')">Cancelled</button>
            </div>
            <div class="table-wrapper">
                <table id="requestsTable" class="hover-table">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            <th>Complete Address</th>
                            <th>Gender</th>
                            <th>Date of Birth</th>
                            <th>Civil Status</th>
                            <th>Findings</th>
                            <th>Purpose</th>
                            <th>Issue Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include_once 'config.php';

                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            if (isset($_POST['approve_request'])) {
                                $id = $_POST['approve_request'];
                                $sql = "UPDATE barangay_clearance SET status = 'Approved' WHERE id = $id";
                                if ($conn->query($sql) === TRUE) {
                                    echo "<script>alert('Request with ID $id has been approved!'); window.location = 'admin_clearance.php';</script>";
                                } else {
                                    echo "Error updating record: " . $conn->error;
                                }
                            } elseif (isset($_POST['decline_request'])) {
                                $id = $_POST['decline_request'];
                                $sql = "UPDATE barangay_clearance SET status = 'Declined' WHERE id = $id";
                                if ($conn->query($sql) === TRUE) {
                                    echo "<script>alert('Request with ID $id has been declined!'); window.location = 'admin_clearance.php';</script>";
                                } else {
                                    echo "Error updating record: " . $conn->error;
                                }
                            }
                        }

                        $sql = "SELECT * FROM barangay_clearance";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr data-status='" . $row['status'] . "'>";
                                echo "<td>" . $row['fname'] . "</td>";
                                echo "<td>" . $row['mname'] . "</td>";
                                echo "<td>" . $row['lname'] . "</td>";
                                echo "<td>" . $row['address'] . "</td>";
                                echo "<td>" . $row['sex'] . "</td>";
                                echo "<td>" . $row['dob'] . "</td>";
                                echo "<td>" . $row['civil_status'] . "</td>";
                                echo "<td>" . $row['findings'] . "</td>";
                                echo "<td>" . $row['purpose'] . "</td>";
                                echo "<td>" . $row['issue_date'] . "</td>";
                                echo "<td>";

                                if ($row['status'] == 'Cancelled') {
                                    echo "Cancelled";
                                } elseif ($row['status'] == 'Approved') {
                                    echo "<button type='button' onclick='viewPDF(" . $row['id'] . ", \"" . str_replace('+', ' ', urlencode($row['fname'])) . "\", \"" . str_replace('+', ' ', urlencode($row['mname'])) . "\", \"" . str_replace('+', ' ', urlencode($row['lname'])) . "\", \"" . str_replace('+', ' ', urlencode($row['address'])) . "\", \"" . str_replace('+', ' ', urlencode($row['sex'])) . "\", \"" . str_replace('+', ' ', urlencode($row['dob'])) . "\", \"" . str_replace('+', ' ', urlencode($row['pob'])) . "\", \"" . str_replace('+', ' ', urlencode($row['civil_status'])) . "\", \"" . str_replace('+', ' ', urlencode($row['findings'])) . "\", \"" . str_replace('+', ' ', urlencode($row['purpose'])) . "\", \"" . str_replace('+', ' ', urlencode($row['issue_date'])) . "\")'>View PDF</button>";
                                } elseif ($row['status'] == 'Declined') {
                                    echo "No action";
                                } else {
                        ?>
                                    <form id="approve_request_<?php echo $row['id']; ?>" method="post">
                                        <input type="hidden" name="approve_request" value="<?php echo $row['id']; ?>">
                                        <button type="button" onclick="approveRequest(<?php echo $row['id']; ?>)">Approve</button>
                                    </form>
                                    <form id="decline_request_<?php echo $row['id']; ?>" method="post">
                                        <input type="hidden" name="decline_request" value="<?php echo $row['id']; ?>">
                                        <button type="button" onclick="declineRequest(<?php echo $row['id']; ?>)">Decline</button>
                                    </form>
                        <?php }

                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='11'>No requests found</td></tr>";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function filterRequests(status) {
            const rows = document.querySelectorAll('#requestsTable tbody tr');
            rows.forEach(row => {
                if (status === 'All' || row.getAttribute('data-status') === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function approveRequest(requestId) {
            var confirmation = confirm("Are you sure you want to approve this request?");
            if (confirmation) {
                document.getElementById('approve_request_' + requestId).submit();
            }
        }

        function declineRequest(requestId) {
            document.getElementById('decline_request_' + requestId).submit();
        }

        function viewPDF(id, fname, mname, lname, address, sex, dob, pob, civil_status, findings, purpose, issue_date) {
            const form = document.createElement('form');
            form.method = 'post';
            form.action = '../pdf/clearance.php';
            form.target = '_blank';

            const params = {
                id: id,
                fname: fname,
                mname: mname,
                lname: lname,
                address: address,
                sex: sex,
                dob: dob,
                pob: pob,
                civil_status: civil_status,
                findings: findings,
                purpose: purpose,
                issue_date: issue_date
            };

            for (const key in params) {
                if (params.hasOwnProperty(key)) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = params[key];
                    form.appendChild(input);
                }
            }

            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>

</html>
