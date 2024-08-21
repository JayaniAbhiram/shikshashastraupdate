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

        img {
            width: 100px;
            height: auto;
            border-radius: 5px;
            transition: transform 0.3s ease;
        }

        img:hover {
            transform: scale(1.2);
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
$servername = "localhost";
$username = "root";  // Adjust based on your database credentials
$password = "";
$dbname = "checkss";  // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h2>Volunteer Documents</h2>";
    echo "<table border='1' cellpadding='10'>
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
                <td>" . $row['name'] . "</td>
                <td>" . $row['gmail'] . "</td>
                <td><img src='" . $row['file1_path'] . "' alt='Aadhar Card'></td>
                <td><img src='" . $row['file2_path'] . "' alt='12th Mark Sheet'></td>
                <td><img src='" . $row['file3_path'] . "' alt='Graduation Certificate'></td>
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

$conn->close();
?>

</body>
</html>
