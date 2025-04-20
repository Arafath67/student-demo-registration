<?php
$servername = "sql208.infinityfree.com"; // MySQL Hostname
$username = "if0_37876058";              // MySQL Username
$password = "Pmbz2k4YeBR9Zyy"; // Hosting account password
$dbname = "if0_37876058_student_registration"; // Database Name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
