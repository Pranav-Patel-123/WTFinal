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

// Start the session
session_start();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    // Validate inputs (you can add more validation)
    if ($password != $confirmPassword) {
        echo "Passwords do not match.";
    } else {
        // Insert user data into the database
        $sql = "INSERT INTO student_detail (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            // Registration successful

            // Fetch the user ID after registration
            $user_id = $stmt->insert_id;

            // Store user ID in the session
            $_SESSION['user_id'] = $user_id;

            // Redirect to a success page
            header("Location: fill-profile-page.html");
            exit();
        } else {
            // Registration failed, display an error message
            echo "Error: " . $stmt->error;
        }
    }
}

// Close the database connection
$conn->close();
?>
