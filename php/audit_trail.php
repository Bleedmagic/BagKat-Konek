<?php
include 'header_admin.php';
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap">
    <link rel="stylesheet" href="../css/audit_trail.css">
    <title>Audit Trail / BagKat</title>

</head>

<body>
    <div class="main-content">
        <div class="main">
            <h1>REPORTS: AUDIT TRAIL</h1>
        </div>
        <div class="table-wrapper">
            <table id="officialsTable" class="hover-table">
                <thead>
                    <tr>
                        <th>Admin Name</th>
                        <th>Actions</th>
                        <th>Table Name</th>
                        <th>Record ID</th>
                        <th>Date & Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM audit_trail ORDER BY timestamp DESC";
                    $result = $conn->query($sql);

                    if ($result) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['admin_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['action']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['table_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['record_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['timestamp']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No audit trail records found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
