<?php
session_start();

// Get the selected college from the query parameter
$selectedCollege = isset($_GET['selected_college']) ? $_GET['selected_college'] : '';

// Store the selected college in the session
$_SESSION['selectedCollege'] = $selectedCollege;
?>
