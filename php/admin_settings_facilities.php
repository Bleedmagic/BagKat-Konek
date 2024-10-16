<?php

include 'header_admin.php';
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image']) && !isset($_POST['update_id'])) {
    $title = $_POST['title'];
    $image = $_FILES['image']['name'];
    $target = "../uploads/" . basename($image);

    $sql = "INSERT INTO facilities (title, image_path) VALUES ('$title', '$target')";

    if ($conn->query($sql) === TRUE && move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        echo "<script>alert('New facility added successfully');</script>";
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
    }

    $conn->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_id'])) {
    $id = $_POST['update_id'];
    $title = $_POST['title'];
    $sql = "UPDATE facilities SET title='$title' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Facility updated successfully');</script>";
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
    }

    $conn->close();
}

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM facilities WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Facility deleted successfully');</script>";
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
    }

    $conn->close();
}

$sql = "SELECT * FROM facilities";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Facilities Settings / BagKat</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap">
    <link rel="stylesheet" type="text/css" href="../css/admin_settings_facilities.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="container">
        <h1>Admin Panel</h1>
        <h2>Add New Facility</h2>
        <form id="addFacilityForm" method="POST" enctype="multipart/form-data">
            <label>Title:</label>
            <input type="text" name="title" required><br>
            <label>Image:</label>
            <input type="file" name="image" id="image" accept="image/*" required><br>
            <div id="image-preview"></div>
            <input type="submit" value="Upload">
        </form>

        <h2>Existing Facilities</h2>
        <div id="facilities-list">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='facility'>";
                    echo "<img src='" . $row["image_path"] . "' alt='" . $row["title"] . "'>";
                    echo "<h2>" . $row["title"] . "</h2>";
                    echo "<form method='POST' style='display:inline;'>";
                    echo "<input type='hidden' name='update_id' value='" . $row["id"] . "'>";
                    echo "<div class='editable-label'>";
                    echo "<div class='input-with-icon'>";
                    echo "<input type='text' name='title' value='" . $row["title"] . "' required>";
                    echo "<i class='fas fa-edit edit-icon'></i>";
                    echo "</div>";
                    echo "</div>";
                    echo "<input type='submit' value='Update'>";
                    echo "</form>";
                    echo "<a href='admin_settings_facilities.php?delete_id=" . $row["id"] . "' onclick='return confirm(\"Are you sure?\")'>Delete</a>";
                    echo "</div>";
                }
            } else {
                echo "No facilities found";
            }
            $conn->close();
            ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        document.getElementById('image').addEventListener('change', function(event) {
            var imagePreview = document.getElementById('image-preview');
            imagePreview.innerHTML = '';
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxWidth = '200px';
                    img.style.maxHeight = '200px';
                    imagePreview.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });

        $(document).ready(function() {
            $('#search').on('input', function() {
                var query = $(this).val();
                if (query.length > 0) {
                    $.ajax({
                        url: 'admin_settings_facilities.php',
                        method: 'GET',
                        data: {
                            query: query,
                        },
                        success: function(data) {
                            $('#search-results').html($(data).find('#search-results').html());
                        },
                    });
                } else {
                    $('#search-results').html('');
                }
            });

            $('#addFacilityForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: 'admin_settings_facilities.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        alert('New facility added successfully');
                        location.reload();
                    },
                    error: function(response) {
                        alert('Error adding facility');
                    },
                });
            });
        });
    </script>
</body>

</html>
