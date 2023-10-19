<?php
session_start();

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

// Retrieve id from the session
$id = $_SESSION['user_id'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $department = $_POST["department"];
    $college = $_POST["college"];
    $cgpa = $_POST["cgpa"];
    $phone_no = $_POST["phone_no"];
    $graduation_year = $_POST["graduation_year"];
    $languages = $_POST["languages"];
    $internship = $_POST["internship"];
    $linkedin = $_POST["linkedin"];
    $skills = $_POST["skills"];
    
    // File upload handling
    $targetDirectory = dirname(__FILE__) . '/uploads/';
    $targetFile = $targetDirectory . basename($_FILES["resume"]["name"]);
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
    if (move_uploaded_file($_FILES["resume"]["tmp_name"], $targetFile)) {
        // Read the resume file content into a variable
        $resumeData = file_get_contents($targetFile);

        // Update data in the database with resume binary data
        $sql = "UPDATE student_detail SET department=?, college=?, cgpa=?, phone_no=?, graduation_year=?, languages=?, internship=?, linkedin=?, skills=?, resume_data=?, resume_filename=? WHERE id=?";
        
        // Prepare the SQL statement
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bind_param("ssssssssssss", $department, $college, $cgpa, $phone_no, $graduation_year, $languages, $internship, $linkedin, $skills, $resumeData, $_FILES["resume"]["name"], $id);

        // Execute the statement
        if ($stmt->execute()) {
            // Data update successful, redirect to a success page
            header("Location: select_company.html");
            exit();
        } else {
            // Data update failed, display an error message
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Error uploading file.";
    }
}

// Close the database connection
$conn->close();
?>
