<?php
// Start the session
session_start();

// Database connection parameters
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'wt';

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user ID from the session
$userID = $_SESSION['user_id'];

// Get form data
$username = $_POST['username'];
$university = $_POST['university'];
$major = $_POST['major'];
$gpa = $_POST['gpa'];
$phone = $_POST['phone'];
$graduationYear = $_POST['graduationYear'];
$languages = $_POST['languages'];
$internship = $_POST['internship'];
$linkedin = $_POST['linkedin'];
$skills = $_POST['skills'];
$resume = $_POST['resume'];

// Update student details in the database
$sql = "UPDATE student_detail SET 
        username = '$username', 
        university = '$university', 
        major = '$major', 
        gpa = '$gpa', 
        phone = '$phone', 
        graduationYear = '$graduationYear', 
        languages = '$languages', 
        internship = '$internship', 
        linkedin = '$linkedin', 
        skills = '$skills', 
        resume = '$resume' 
        WHERE id = $userID";

if ($conn->query($sql) === TRUE) {
    echo "Details updated successfully.";
} else {
    echo "Error updating details: " . $conn->error;
}

// Close the connection
$conn->close();
?>
