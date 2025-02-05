<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employer_id = $_POST['id'];
    $company_name = $_POST['company_name'];
    $website = $_POST['website'];
    $phone = $_POST['phone'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $map = $_POST['map'];
    $address = $_POST['address'];

    $query = "UPDATE employers SET company_name = ?, website = ?, phone = ?, location = ?, description = ?, map = ?, address = ? WHERE user_id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die("Error preparing the SQL statement: " . $conn->error);
    }

    $stmt->bind_param("sssssssi", $company_name, $website, $phone, $location, $description, $map, $address, $employer_id);

    if ($stmt->execute() === false) {
        die("Error executing the SQL statement: " . $stmt->error);
    }

    echo "Employer updated successfully";
} else {
    echo "Invalid request method";
}
?>