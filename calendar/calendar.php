<?php
require '../db.php'; // Include the database connection file
// Get employee ID from query string
$employee_id = $_GET['id'] ?? 0;
//$employee_id = 12;
// Fetch data from the database
/*
$query = "SELECT e.company_name AS employer_name, em.full_name AS employee_name, b.status, b.booking_date
                      FROM bookings b
                      JOIN employers e ON b.employer_id = e.id
                      JOIN employees em ON b.employee_id = em.id";
*/
/*
$stmt = $conn->prepare("SELECT `bookings`.*, `employees`.*
FROM `bookings`
LEFT JOIN `employees` ON `bookings`.`employee_id` = `employees`.`user_id`
WHERE `employee_id` = ?");
*/
$stmt = $conn->prepare("SELECT `bookings`.*, `employees`.*, `employers`.*
FROM `bookings` 
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
    <title>FullCalendar by Creative Tim</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link href="assets/css/fullcalendar.css" rel="stylesheet" />
    <link href="assets/css/fullcalendar.print.css" rel="stylesheet" media="print" />
    <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
    <script src="assets/js/jquery-ui.custom.min.js" type="text/javascript"></script>
    <script src="assets/js/fullcalendar.js" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();

            /*  className colors
                className: default(transparent), important(red), chill(pink), success(green), info(blue)
            */

            /* initialize the external events
            -----------------------------------------------------------------*/
            $("#external-events div.external-event").each(function() {
                // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                // it doesn't need to have a start or end
                var eventObject = {
                    title: $.trim($(this).text()), // use the element's text as the event title
                };

                // store the Event Object in the DOM element so we can get to it later
                $(this).data("eventObject", eventObject);

                // make the event draggable using jQuery UI
                $(this).draggable({
                    zIndex: 999,
                    revert: true, // will cause the event to go back to its
                    revertDuration: 0, //  original position after the drag
                });
            });

            /* initialize the calendar
            -----------------------------------------------------------------*/
            var calendar = $("#calendar").fullCalendar({
                header: {
                    left: "title",
                    center: "agendaDay,agendaWeek,month",
                    right: "prev,next today",
                },
                editable: true,
                firstDay: 1, //  1(Monday) this can be changed to 0(Sunday) for the USA system
                selectable: true,
                defaultView: "month",

                axisFormat: "h:mm",
                columnFormat: {
                    month: "ddd", // Mon
                    week: "ddd d", // Mon 7
                    day: "dddd M/d", // Monday 9/7
                    agendaDay: "dddd d",
                },
                titleFormat: {
                    month: "MMMM yyyy", // September 2009
                    week: "MMMM yyyy", // September 2009
                    day: "MMMM yyyy", // Tuesday, Sep 8, 2009
                },
                allDaySlot: false,
                selectHelper: true,
                select: function(start, end, allDay) {
                    var title = prompt("Event Title:");
                    if (title) {
                        calendar.fullCalendar(
                            "renderEvent", {
                                title: title,
                                start: start,
                                end: end,
                                allDay: allDay,
                            },
                            true // make the event "stick"
                        );
                    }
                    calendar.fullCalendar("unselect");
                },
                droppable: true, // this allows things to be dropped onto the calendar !!!
                drop: function(date, allDay) {
                    // this function is called when something is dropped

                    // retrieve the dropped element's stored Event Object
                    var originalEventObject = $(this).data("eventObject");

                    // we need to copy it, so that multiple events don't have a reference to the same object
                    var copiedEventObject = $.extend({}, originalEventObject);

                    // assign it the date that was reported
                    copiedEventObject.start = date;
                    copiedEventObject.allDay = allDay;

                    $("#calendar").fullCalendar("renderEvent", copiedEventObject, true);

                    // is the "remove after drop" checkbox checked?
                    if ($("#drop-remove").is(":checked")) {
                        // if so, remove the element from the "Draggable Events" list
                        $(this).remove();
                    }
                },

                events: [
                    <?php if (is_array($bookings) && count($bookings) > 0): ?>
                        <?php foreach ($bookings as $booking): ?> {
                                title: "<?php echo addslashes($booking['full_name']) . ' @ ' . addslashes($booking['company_name']) . ' - [' . addslashes($booking['status']); ?>]",
                                start: "<?php echo $booking['booking_date']; ?>",
                                allDay: false,
                                className: "<?php echo $booking['status']; ?>",
                                end: "<?php echo date('Y-m-d H:i:s', strtotime($booking['booking_date'] . ' +1 hour')); ?>",
                            },
                        <?php endforeach; ?>
                    <?php endif; ?>
                ],
            });
        });
    </script>
    <style>
        body {
            margin-top: 40px;
            text-align: center;
            font-size: 14px;
            font-family: "Helvetica Nueue", Arial, Verdana, sans-serif;
            background-color: #dddddd;
        }

        #wrap {
            width: 1100px;
            margin: 0 auto;
        }

        #external-events {
            float: left;
            width: 150px;
            padding: 0 10px;
            text-align: left;
        }

        #external-events h4 {
            font-size: 16px;
            margin-top: 0;
            padding-top: 1em;
        }

        .external-event {
            /* try to mimick the look of a real event */
            margin: 10px 0;
            padding: 2px 4px;
            background: #3366cc;
            color: #fff;
            font-size: 0.85em;
            cursor: pointer;
        }

        #external-events p {
            margin: 1.5em 0;
            font-size: 11px;
            color: #666;
        }

        #external-events p input {
            margin: 0;
            vertical-align: middle;
        }

        #calendar {
            /* 		float: right; */
            margin: 0 auto;
            width: 900px;
            background-color: #ffffff;
            border-radius: 6px;
            box-shadow: 0 1px 2px #c3c3c3;
        }
    </style>
</head>

<body>
    <div id="wrap">
        <div id="calendar"></div>
        <div style="clear: both"></div>
    </div>
</body>

</html>