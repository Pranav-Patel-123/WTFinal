<?php
$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "wt";

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $company_name = $_POST["company_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    if ($password != $confirmPassword) {
        echo "Passwords do not match.";
    } else {
        // Insert user data into the signup_company table
        $sql1 = "INSERT INTO company_detail (company, email, password) VALUES (?, ?, ?)";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param("sss", $company_name, $email, $password);

        // Execute the prepared statement
        if($stmt1->execute())
        {
            $user_id = $stmt1->insert_id;

            // Store user ID in the session
            $_SESSION['user_id'] = $user_id;

            // Redirect to a success page
            header("Location: company_profile.html");
            exit();
        }

        // Check for successful insertion
        // if ($stmt1->affected_rows > 0) {
        //     // Redirect to the company profile page
        //     header("Location: company_profile.html");
        //     exit();
        else{
            echo "Error inserting data into the database.";
        }
    }
}

$conn->close();
?>
