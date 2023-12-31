<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>
</head>
<body>
    <h2>Add Event</h2>

    <form action="add_event_process.php" method="post">
        <label for="event_name">Event Name:</label>
        <input type="text" id="event_name" name="event_name" required>

        <br>

        <label for="event_description">Event Description:</label>
        <textarea id="event_description" name="event_description" rows="4" required></textarea>

        <br>

        <label for="event_date">Event Date:</label>
        <input type="date" id="event_date" name="event_date" required>

        <br>

        <label for="voting_deadline">Voting Deadline:</label>
        <input type="datetime-local" id="voting_deadline" name="voting_deadline" required>

        <br>

        <button type="submit">Add Event</button>
    </form>
</body>
</html>
