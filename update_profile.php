<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id'])) {
        die("Employee ID is missing from form submission");
    }
    
    // Get form data
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $job_title = mysqli_real_escape_string($conn, $_POST['job_title']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $salary_range = mysqli_real_escape_string($conn, $_POST['salary_range']);
    $work_history = mysqli_real_escape_string($conn, $_POST['work_history']);
    $education = mysqli_real_escape_string($conn, $_POST['education']);
    $career_goals = mysqli_real_escape_string($conn, $_POST['career_goals']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    // Update query
    $query = "UPDATE employees 
              JOIN users ON employees.user_id = users.id
              SET employees.full_name = '$full_name',
                  employees.job_title = '$job_title',
                  employees.location = '$location',
                  employees.salary_range = '$salary_range',
                  employees.work_history = '$work_history',
                  employees.education = '$education',
                  employees.career_goals = '$career_goals',
                  users.email = '$email',
                  employees.phone = '$phone'
              WHERE employees.id = '".mysqli_real_escape_string($conn, $_POST['id'])."'";

    if (mysqli_query($conn, $query)) {
        // Redirect back to profile page after successful update
        header('Location: employee.php?id='. $_POST['id']);
        exit();
    } else {
        die("Update failed: " . mysqli_error($conn));
    }
}
?>
