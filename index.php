
<?php
// Start the session
session_start();

// Set background color based on the submitted color
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['color'])) {
    $_SESSION['background_color'] = $_POST['color'];
}

// Get the current background color (default to white if not set)
$backgroundColor = isset($_SESSION['background_color']) ? $_SESSION['background_color'] : 'white';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            background-color: <?php echo htmlspecialchars($backgroundColor); ?>;
        }
        .diff {
            display: flex;
            gap: 10px;
            
        }
        .diff button {
            background-color: #4CAF50;
            color: black;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
            
        }
        .diff button:hover {
            opacity: 0.8;
        }
        .diff {
            background-color: #4CAF50;
            color: black;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }
        .diff:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <h1>Project Registration</h1>
        <form class="diff" method="POST" style="display: inline;">
        <input type="hidden" name="color" value="lightblue">
        <button type="submit">
        <span style="font-size:16px; font-weight:400;">Change color to Aquamarine</span></button>
    </form>
    <form class="diff"  method="POST" style="display: inline;">
        <input type="hidden" name="color" value="aquamarine">
        <button type="submit"><span style="font-size:16px; font-weight:400;">Change color to Aquamarine</span></button>
    </form>
        <a href="students.php" class="nav-button">View Registered Students</a>
      
    </nav>

    <h1>Project Demo Registration</h1>
    <form id="registrationForm" action="register.php" method="POST">
        <label for="id">Student ID (8 digits):</label>
        <input type="text" id="id" name="id" maxlength="8" required pattern="\d{8}" title="8-digit ID only">
        
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required pattern="[A-Za-z]+" title="Alphabetic characters only">
        
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required pattern="[A-Za-z]+" title="Alphabetic characters only">
        
        <label for="project_title">Project Title:</label>
        <input type="text" id="project_title" name="project_title" required>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="phone">Phone (999-999-9999):</label>
        <input type="text" id="phone" name="phone" required pattern="\d{3}-\d{3}-\d{4}" title="Phone format: 999-999-9999">
        
    <label for="timeslot">Time Slot:</label>
<select id="timeslot" name="timeslot" required>
    <?php
    // Include database connection
    include 'db.php';

    // Fetch available time slots
    $query = "SELECT * FROM timeslots WHERE seats_remaining > 0";
    $result = $conn->query($query);

    // Populate dropdown with available time slots
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
             $start_time = date("m-d-Y h:i A", strtotime($row['start_time'])); // Format as MM-DD-YYYY h:i AM/PM
                    $end_time = date("m-d-Y h:i A", strtotime($row['end_time'])); // Format as MM-DD-YYYY h:i AM/PM
            echo "<option value='{$row['id']}'>
                    {$start_time} - {$end_time} ({$row['seats_remaining']} seats remaining)
                  </option>";
        }
    } else {
        echo "<option disabled>No slots available</option>";
    }
    ?>
</select>

        
        <button type="submit">Register</button>
    </form>
</body>
</html>
