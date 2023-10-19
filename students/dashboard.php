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

// Fetch student details from the database
$sql = "SELECT * FROM student_detail WHERE id = $userID";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Initialize $details with the fetched data
    $details = json_encode($row);
} else {
    $details = "No student details found.";
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Details</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 60%;
            max-width: 600px;
            margin-top: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #007BFF;
            color: #fff;
            cursor: pointer;
            padding: 10px;
            border: none;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Edit Student Details</h2>
        <form id="studentForm">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" >

            <label for="university">University:</label>
            <input type="text" id="university" name="university" >

            <label for="department">Department:</label>
            <input type="text" id="department" name="department" >

            <label for="gpa">GPA:</label>
            <input type="text" id="gpa" name="gpa" >

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" >

            <label for="graduationYear">Graduation Year:</label>
            <input type="text" id="graduationYear" name="graduationYear" >

            <label for="languages">Languages:</label>
            <input type="text" id="languages" name="languages" >

            <label for="internship">Internship:</label>
            <input type="text" id="internship" name="internship" >

            <label for="linkedin">LinkedIn:</label>
            <input type="text" id="linkedin" name="linkedin" >

            <label for="skills">Skills:</label>
            <input type="text" id="skills" name="skills" >

            <label for="resume">Resume:</label>
            <input type="text" id="resume" name="resume" >

            <button type="button" onclick="updateStudentDetails()">Update Details</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var details = <?php echo $details; ?>;
            fillForm(details);
        });

        function fillForm(details) {
            document.getElementById('username').value = details.username;
            document.getElementById('university').value = details.college;
            document.getElementById('department').value = details.department;
            document.getElementById('gpa').value = details.cgpa;
            document.getElementById('phone').value = details.phone_no;
            document.getElementById('graduationYear').value = details.graduation_year;
            document.getElementById('languages').value = details.languages;
            document.getElementById('internship').value = details.internship;
            document.getElementById('linkedin').value = details.linkedin;
            document.getElementById('skills').value = details.skills;
            document.getElementById('resume').value = details.resume_data;
        }

        function updateStudentDetails() {
            var form = document.getElementById('studentForm');
            var formData = new FormData(form);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'updateStudentDetails.php', true);
            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 400) {
                    console.log('Details updated successfully.');
                } else {
                    console.error('Error updating student details:', xhr.statusText);
                }
            };
            xhr.onerror = function () {
                console.error('Network error while updating student details.');
            };
            xhr.send(formData);
        }
    </script>
</body>

</html>
