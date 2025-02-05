<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../db.php';

// Verify connection
if (!$conn) {
    die(json_encode([
        'success' => false,
        'error' => 'Database connection failed: ' . mysqli_connect_error()
    ]));
}

$response = [];

try {
    // Get parameters
    $date = $_GET['date'] ?? null;
    $month = $_GET['month'] ?? null;
    $year = $_GET['year'] ?? null;

    if ($date) {
        // Get jobs for specific date with full details
        $stmt = $conn->prepare("
            SELECT 
                j.id,
                j.title AS job_title,
                j.start_date,
                j.start_time,
                j.end_time,
                j.location,
                j.description,
                e.name AS employer_name
            FROM jobs j
            JOIN employers e ON j.employer_id = e.id
            WHERE j.start_date = ?
        ");
        $stmt->bind_param("s", $date);
    } else if ($month && $year) {
        // Get jobs for entire month (basic details for calendar view)
        $startDate = "$year-$month-01";
        $endDate = date("Y-m-t", strtotime($startDate));
        $stmt = $conn->prepare("
            SELECT 
                j.id,
                j.title AS job_title,
                j.start_date
            FROM jobs j
            WHERE j.start_date BETWEEN ? AND ?
        ");
        $stmt->bind_param("ss", $startDate, $endDate);
    } else {
        throw new Exception("Invalid parameters");
    }

    $stmt->execute();
    $result = $stmt->get_result();
    
    $jobs = [];
    while ($row = $result->fetch_assoc()) {
        $jobs[] = $row;
    }

    $response['success'] = true;
    $response['data'] = $jobs;
} catch (Exception $e) {
    $response['success'] = false;
    $response['error'] = $e->getMessage();
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    $conn->close();
}

echo json_encode($response);
?>
