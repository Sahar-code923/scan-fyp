<?php
// Database configuration
include("connect.php");
// Sanitize input
$cnic = $conn->real_escape_string($_POST['cnic']);

// SQL query
$sql = "SELECT * FROM students WHERE cnic = '$cnic'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Student Record</title>
    </head>
    <body>
        <h2>Student Details</h2>
        <table border="1">
            <?php foreach($row as $key => $value): ?>
            <tr>
                <th><?= ucfirst(str_replace('_', ' ', $key)) ?></th>
                <td><?= $value ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </body>
    </html>
    <?php
} else {
    echo "No student found with CNIC: $cnic";
}

$conn->close();
?>
