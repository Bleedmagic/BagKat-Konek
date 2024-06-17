<?php
include 'header_res.php';
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel_request'])) {
    $request_id = $_POST['request_id'];
    $cancel_sql = "UPDATE barangay_clearance SET status = 'Cancelled' WHERE id = $request_id";

    if ($conn->query($cancel_sql) === TRUE) {
        echo "<script>alert('Request cancelled successfully'); window.location.href = 'res_clearance_req.php';</script>";
        exit();
    } else {
        echo "Error: " . $cancel_sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clearance Request / BagKat</title>
    <link rel="stylesheet" href="../css/res_clearance_req.css">
</head>

<body>

    <main class="container">
        <div class="request-list">
            <h2>REQUEST STATUS: BARANGAY CLEARANCE</h2>
            <button class="status-button all" onclick="filterRequests('All')">All</button>
            <button class="status-button pending" onclick="filterRequests('Pending')">Pending</button>
            <button class="status-button approved" onclick="filterRequests('Approved')">Approved</button>
            <button class="status-button disapproved" onclick="filterRequests('Declined')">Declined</button>
            <button class="status-button cancelled" onclick="filterRequests('Cancelled')">Cancelled</button>

            <table>
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                        <th>Complete Address</th>
                        <th>Issue Date</th>
                        <th>Purpose</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM barangay_clearance";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr data-status='" . $row['status'] . "'>";
                            echo "<td>" . $row['fname'] . "</td>";
                            echo "<td>" . $row['mname'] . "</td>";
                            echo "<td>" . $row['lname'] . "</td>";
                            echo "<td>" . $row['address'] . "</td>";
                            echo "<td>" . $row['issue_date'] . "</td>";
                            echo "<td>" . $row['purpose'] . "</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            echo "<td>";
                            if ($row['status'] === 'Pending') {
                                echo "<form method='post'>";
                                echo "<input type='hidden' name='request_id' value='" . $row['id'] . "'>";
                                echo "<button type='submit' name='cancel_request' class='cancel-button'>Cancel</button>";
                                echo "</form>";
                            }
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No requests found</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <script>
        function filterRequests(status) {
            var rows = document.querySelectorAll('tbody tr');

            rows.forEach(function(row) {
                if (status === 'All') {
                    row.style.display = '';
                } else if (row.getAttribute('data-status') === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
</body>

</html>
