<?php
require_once 'db.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $id = $_POST['id'];
    $full_name = $_POST['full_name'];
    $job_title = $_POST['job_title'];
    $phone = $_POST['phone'];
    $bio = $_POST['bio'];
    $skills = $_POST['skills'];
    $location = $_POST['location'];
    $job_type_preference = $_POST['job_type_preference'];
    $salary_range = $_POST['salary_range'];
    $remote_preference = $_POST['remote_preference'];
    $level = $_POST['level'];
    $bio_photo = $_POST['bio_photo'];
    $work_history = $_POST['work_history'];
    $education = $_POST['education'];

    // Prepare and bind
    $stmt = $conn->prepare("UPDATE employees SET full_name=?, job_title=?, phone=?, bio=?, skills=?, location=?, job_type_preference=?, salary_range=?, remote_preference=?, level=?, bio_photo=?, work_history=?, education=? WHERE id=?");
    $stmt->bind_param("sssssssssssssi", $full_name, $job_title, $phone, $bio, $skills, $location, $job_type_preference, $salary_range, $remote_preference, $level, $bio_photo, $work_history, $education, $id);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Employee updated successfully";
    } else {
        echo "Error updating employee: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>