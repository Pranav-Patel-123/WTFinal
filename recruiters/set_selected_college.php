<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedCollege = $_POST["selected_college"];

    // Do something with $selectedCollege
    // For example, store it in a session variable or database
    $_SESSION["selected_college"] = $selectedCollege;

    // You can also echo the value back for testing purposes
    // echo "Selected College: " . $selectedCollege;
}
// Redirect or do other things after setting the selected college
header('location:student_list.php');
?>
