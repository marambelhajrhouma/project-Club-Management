<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include_once('../controller/EventController.php');

// Check if the user is logged in
if (!isset($_SESSION['member_id'])) {
    // Redirect to the login page
    header('Location: login.php');
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate form data
    $eventName = $_POST['event_name'] ?? '';
    $eventDescription = $_POST['event_description'] ?? '';
    $eventDate = $_POST['event_date'] ?? '';
    $organizerId = $_SESSION['member_id']; // Use the logged-in user's ID as the organizer
    $votingDeadline = $_POST['voting_deadline'] ?? '';

    // Debug
    echo "Event Name: $eventName<br>";
    echo "Event Description: $eventDescription<br>";
    echo "Event Date: $eventDate<br>";
    echo "Organizer ID: $organizerId<br>";
    echo "Voting Deadline: $votingDeadline<br>";

    // Create an instance of the EventController class
    $eventController = new EventController();

    // Create an instance of the Event class
    $event = new Event($eventName, $eventDescription, $eventDate, $organizerId, $votingDeadline);

    // Add the event to the database
    $result = $eventController->addEvent($event);

    if ($result) {
        // Event added successfully

        // Fetch events for the current month after adding the new event
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

        // Update the calendar events array with the new data
        echo "<script>
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: " . json_encode($formattedEvents) . ",
                eventClick: function(info) {
                    // ... (your existing code)
                }
            });
            calendar.render();
        </script>";
    } else {
        // Event addition failed
        $_SESSION['message'] = 'Error adding event. Please try again.';
    }

    // Redirect to calendar.php
    header('Location: calendar.php');
    exit();
} else {
    // Redirect to the home page or handle the case where the form is not submitted
    header('Location: index.php');
    exit();
}
?>
