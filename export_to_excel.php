<?php
// Database config
$conn = new mysqli("localhost", "root", "", "your_database_name"); // CHANGE THIS

// Get date filter
$date_filter = isset($_GET['date']) ? "WHERE a.date = '" . $conn->real_escape_string($_GET['date']) . "'" : "";

// Get attendance data
$sql = "SELECT s.roll_no, s.student_name, s.cnic, a.date, a.status 
        FROM students_record s
        LEFT JOIN attendance a ON s.roll_no = a.roll_no
        $date_filter
        ORDER BY a.date DESC";

$result = $conn->query($sql);

// CSV headers
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="attendance_export.csv"');

// CSV output
$output = fopen('php://output', 'w');
fputcsv($output, ['Roll No', 'Name', 'CNIC', 'Date', 'Status']);

while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
$conn->close();
exit;
?>
