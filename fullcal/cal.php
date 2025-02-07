<?php
// Include the database connection file
require '../db.php';
// Get employee ID from query string
$employee_id = $_GET['id'] ?? 0;
//$employee_id = 12;
// Fetch data from the database
$stmt = $conn->prepare("SELECT `bookings`.*, `employees`.*, `employers`.*, `bookings`.`status` as `title` FROM `bookings` 
LEFT JOIN `employees` ON `bookings`.`employee_id` = `employees`.`user_id` 
LEFT JOIN `employers` ON `bookings`.`employer_id` = `employers`.`user_id` 
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

echo "<script> console . log($employee_id);</script>";


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
                events: [{
                        title: 'All Day Event',
                        start: '2025-02-01'
                    },
                    {
                        title: 'Long Event',
                        start: '2025-02-07',
                        end: '2025-02-10'
                    },
                    {
                        groupId: 999,
                        title: 'Repeating Event',
                        start: '2025-02-09T16:00:00'
                    },
                    {
                        groupId: 999,
                        title: 'Repeating Event',
                        start: '2025-02-16T16:00:00'
                    },
                    {
                        title: 'Conference',
                        start: '2025-02-11',
                        end: '2025-02-13'
                    },
                    {
                        title: 'Meeting',
                        start: '2025-02-12T10:30:00',
                        end: '2025-02-12T12:30:00'
                    },
                    {
                        title: 'Lunch',
                        start: '2025-02-12T12:00:00'
                    },
                    {
                        title: 'Meeting',
                        start: '2025-02-12T14:30:00'
                    },
                    {
                        title: 'Happy Hour',
                        start: '2025-02-12T17:30:00'
                    },
                    {
                        title: 'Dinner',
                        start: '2025-02-12T20:00:00'
                    },
                    {
                        title: 'Birthday Party',
                        start: '2025-02-13T07:00:00'
                    },
                    /*Future Feature
                    {
                        title: 'Click for Google',
                        url: 'http://google.com/',
                        start: '2025-02-28'
                    }
                    */
                ]
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

</html>