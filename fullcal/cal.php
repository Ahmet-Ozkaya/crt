<?php
//include '../includes/template/header.php';
//include '../includes/template/navbar.php';

// Include the database connection file
require '../db.php';
// Get employee ID from query string
$employee_id = $_GET['id'] ?? 0;

// Fetch data from the database
$stmt = $conn->prepare("SELECT `bookings`.`start`, `employees`.*, `employers`.`company_name`, `bookings`.`end`, `bookings`.`status`, `employees`.`full_name` as title, `jobs`.`location`, `bookings`.*
FROM `bookings` 
    LEFT JOIN `employees` ON `bookings`.`employee_id` = `employees`.`user_id` 
    LEFT JOIN `employers` ON `bookings`.`employer_id` = `employers`.`user_id` 
    LEFT JOIN `jobs` ON `jobs`.`employer_id` = `employers`.`id` 
WHERE `bookings`.`employee_id` = ?;");

$stmt->bind_param("i", $employee_id);
$stmt->execute();
$result = $stmt->get_result();
if (!$result) {
    error_log("Query failed: " . mysqli_error($conn));
    $bookings = [];
} else {
    $bookings = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
$stmt->close();

// Debugging: Log fetched data to console
echo "<script>console.log(" . json_encode($bookings) . ");</script>";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8' />
    <script src='index.global.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prevYear,prev,next,nextYear today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,dayGridDay'
                },
                initialDate: new Date().toISOString().slice(0, 10),
                navLinks: true, // can click day/week names to navigate views
                editable: true,
                dayMaxEvents: true, // allow "more" link when too many events
                events: function(fetchInfo, successCallback, failureCallback) {
                    console.log("Fetching events...");
                    var events = <?php echo json_encode($bookings); ?>;
                    var formattedEvents = events.map(function(event) {
                        return {
                            title: event.title,
                            start: new Date(event.start),
                            end: new Date(event.end)
                        };
                    });
                    console.log("Formatted Events:", formattedEvents);
                    successCallback(formattedEvents);
                }
            });

            calendar.render();
        });
    </script>
    <style>
        body {
            margin: 40px 10px;
            padding: 0;
            font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
            font-size: 14px;
        }

        #calendar {
            max-width: 1100px;
            margin: 0 auto;
        }
    </style>
</head>

<body>

    <div id='calendar'></div>

</body>