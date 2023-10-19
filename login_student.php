<?php
// Database configuration
$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "wt";

// Create a database connection
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["student-email"];
    $password = $_POST["student-password"];

    // You should hash the password before storing it in the database.
    // For simplicity, we won't hash it here.
    $select_student = $conn->prepare("SELECT * FROM student_detail WHERE email = ? AND password = ?");
    $select_student->bind_param("ss", $email, $password); // Bind parameters
    $select_student->execute();

    $result = $select_student->get_result();

    if ($result->num_rows > 0) {
        $fetch_student_id = $result->fetch_assoc();
        $_SESSION['student_id'] = $fetch_student_id['id'];
        header('location:students/select_company.html');
    } else {
        $message[] = 'Incorrect username or password!';
    }
}

// Close the database connection
$conn->close();
?>
