<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $project_title = $_POST['project_title'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $timeslot = $_POST['timeslot'];

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Check if the user is already registered
        $checkQuery = "SELECT * FROM students WHERE email = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User already registered
            echo "You are already registered for a time slot.";
        } else {
            // Check seat availability for the selected timeslot
            $seatQuery = "SELECT seats_remaining FROM timeslots WHERE id = ?";
            $stmt = $conn->prepare($seatQuery);
            $stmt->bind_param("i", $timeslot);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $seats_remaining = $row['seats_remaining'];

                if ($seats_remaining > 0) {
                    // Register the user
                    $insertQuery = "INSERT INTO students (id, first_name, last_name, project_title, email, phone, timeslot) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($insertQuery);
                    $stmt->bind_param("isssssi", $id, $first_name, $last_name, $project_title, $email, $phone, $timeslot);

                    if ($stmt->execute()) {
                        // Decrease the seat count
                        $updateQuery = "UPDATE timeslots SET seats_remaining = seats_remaining - 1 WHERE id = ?";
                        $stmt = $conn->prepare($updateQuery);
                        $stmt->bind_param("i", $timeslot);
                        $stmt->execute();

                        echo "<p>Registration successful!</p>";
                        echo "<a href='students.php' class='button'>View Registered Students</a>";
                        // Optional: Auto-redirect after a few seconds
                        echo "<script>
                                setTimeout(function() {
                                    window.location.href = 'students.php';
                                }, 3000);
                              </script>";
                    } else {
                        echo "Error registering user: " . $stmt->error;
                    }
                } else {
                    echo "Sorry, no seats are available for this time slot.";
                }
            } else {
                echo "Invalid time slot selected.";
            }
        }

        // Commit the transaction
        $conn->commit();
    } catch (Exception $e) {
        // Rollback the transaction in case of an error
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }

    $stmt->close();
    $conn->close();
}
?>
