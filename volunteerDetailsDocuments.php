<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #007BFF;
            font-size: 24px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 15px;
            text-align: center;
        }

        table th {
            background-color: #007BFF;
            color: #fff;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #e9e9e9;
        }

        .document-link {
            color: #007BFF;
            text-decoration: none;
            font-weight: bold;
        }

        .document-link:hover {
            text-decoration: underline;
        }

        .delete-button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }

        .delete-button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

<?php
// $servername = "localhost";
// $username = "root";  // Adjust based on your database credentials
// $password = "";
// $dbname = "shikshashastra1";  // Your database name

// $conn = new mysqli($servername, $username, $password, $dbname);
include("connect.php");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Handle delete request
if (isset($_POST['delete_id'])) {
    $deleteId = $_POST['delete_id'];

    // Prepare and execute delete statement
    $stmt = $conn->prepare("DELETE FROM volunteer_documents WHERE id = ?");
    $stmt->bind_param("i", $deleteId);
    if ($stmt->execute()) {
        echo "<p style='text-align:center; color: #28a745;'>Record deleted successfully.</p>";
    } else {
        echo "<p style='text-align:center; color: #FF0000;'>Error deleting record: " . $stmt->error . "</p>";
    }
    $stmt->close();
}

// Fetch volunteer documents from the database
$sql = "SELECT id, name, gmail, file1_path, file2_path, file3_path FROM volunteer_documents";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Volunteer Documents</h2>";
    echo "<table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Gmail</th>
                <th>Aadhar Card</th>
                <th>12th Mark Sheet</th>
                <th>Graduation Certificate</th>
                <th>Action</th>
            </tr>";

    // Output data for each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>" . htmlspecialchars($row['gmail']) . "</td>
                <td><a href='" . htmlspecialchars($row['file1_path']) . "' class='document-link' target='_blank'>View Aadhar Card</a></td>
                <td><a href='" . htmlspecialchars($row['file2_path']) . "' class='document-link' target='_blank'>View 12th Mark Sheet</a></td>
                <td><a href='" . htmlspecialchars($row['file3_path']) . "' class='document-link' target='_blank'>View Graduation Certificate</a></td>
                <td>
                    <form method='POST' action='' onsubmit='return confirm(\"Are you sure you want to delete this record?\");'>
                        <input type='hidden' name='delete_id' value='" . $row['id'] . "'>
                        <button type='submit' class='delete-button'>Delete</button>
                    </form>
                </td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "<p style='text-align:center; color: #FF0000;'>No volunteer documents found.</p>";
}

$con->close();
?>

</body>
</html>
