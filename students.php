<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Students</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <h1>Registered Students</h1>
        <a href="index.php" class="nav-button">Go Back to Registration</a>
    </nav>

    <h1>List of Registered Students</h1>
    <table>
        <thead>
            <tr>
                <th>Student ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Project Title</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Time Slot</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Query to get student and timeslot information
            $query = "SELECT s.id, s.first_name, s.last_name, s.project_title, s.email, s.phone, t.start_time, t.end_time 
                      FROM students s
                      JOIN timeslots t ON s.timeslot = t.id";

            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Format dates and times
                    $start_time = date("m-d-Y h:i A", strtotime($row['start_time'])); // Format as MM-DD-YYYY h:i AM/PM
                    $end_time = date("m-d-Y h:i A", strtotime($row['end_time'])); // Format as MM-DD-YYYY h:i AM/PM

                    // Display table rows
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['first_name']}</td>
                            <td>{$row['last_name']}</td>
                            <td>{$row['project_title']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['phone']}</td>
                            <td>{$start_time} - {$end_time}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No students registered yet.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
