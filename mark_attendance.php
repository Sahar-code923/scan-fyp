<?php
// Database config
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database_name"; // CHANGE THIS

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$cnic = $conn->real_escape_string(trim($_POST['cnic']));
$date = $conn->real_escape_string($_POST['date']));

// Find student by CNIC
$sql = "SELECT roll_no FROM students_record WHERE cnic = '$cnic'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $roll_no = $row['roll_no'];
    
    // Insert attendance record
    $insert_sql = "INSERT INTO attendance (roll_no, date)
                   VALUES ('$roll_no', '$date')
                   ON DUPLICATE KEY UPDATE roll_no=roll_no";
    
    if ($conn->query($insert_sql) {
        echo "<div style='max-width:800px;margin:50px auto;padding:20px;background:#e8f5e9;border:2px solid #4CAF50;border-radius:5px;'>
              ✅ Attendance marked for CNIC: $cnic
              <a href='index.html' style='display:block;margin-top:15px;'>Back to Portal</a>
              </div>";
    } else {
        echo "<div style='max-width:800px;margin:50px auto;padding:20px;background:#ffebee;border:2px solid #f44336;border-radius:5px;'>
              ❌ Already marked for $date
              <a href='index.html' style='display:block;margin-top:15px;'>Back to Portal</a>
              </div>";
    }
} else {
    echo "<div style='max-width:800px;margin:50px auto;padding:20px;background:#fff3e0;border:2px solid #FF9800;border-radius:5px;'>
          ⚠ Student not found!
          <a href='index.html' style='display:block;margin-top:15px;'>Back to Portal</a>
          </div>";
}

$conn->close();
?>
