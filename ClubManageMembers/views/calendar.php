<?php
include_once('../controller/EventController.php');

// Create an instance of the EventController class
$eventController = new EventController();

// Fetch events for the current month
$currentMonth = date('m');
$currentYear = date('Y');
$events = $eventController->getEventsForMonth($currentMonth, $currentYear);

// Format events for FullCalendar
$formattedEvents = [];
foreach ($events as $day => $dailyEvents) {
    foreach ($dailyEvents as $event) {
        $formattedEvents[] = [
            'title' => $event['event_name'],
            'start' => "$currentYear-$currentMonth-$day",
            'color' => $event['color'],
            'ended' => $event['ended'],
            'event_id' => $event['event_id'],
            
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Event Calendar</title>
    <link rel="stylesheet" href="fullcalendar/core/main.css">
    <link rel="stylesheet" href="fullcalendar/daygrid/main.css">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script src="fullcalendar/core/main.js"></script>
    <script src="fullcalendar/daygrid/main.js"></script>
    <script>

document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    events: <?php echo json_encode($formattedEvents); ?>,
    eventClick: function(info) {
        var eventEnded = info.event.extendedProps.ended;
        var eventId = info.event.extendedProps.event_id;
        var eventName = info.event.title;
        
        // Display event details
        alert('Event Name: ' + eventName + '\nEvent Ended: ' + eventEnded);

        // If the event has not ended, provide the option to vote
        if (!eventEnded) {
            // Redirect or open a modal for voting
            window.location.href = 'event_details.php?event_id=' + eventId;
        }
        else{
            if(eventEnded){
                window.location.href = 'feedback_details.php?event_id=' + eventId;
            }
        }
    }
  });
  calendar.render();
});

</script>
</head>
<body>

    <div id="calendar"></div>
</body>
</html>
