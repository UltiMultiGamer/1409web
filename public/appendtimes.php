<?php
// Get the JSON data sent from JavaScript
$data = json_decode(file_get_contents('php://input'), true);
$eventNames = $data['eventNames'];
$startTimes = $data['startTimes'];
$endTimes = $data['endTimes'];
$eventTypes = $data['eventTypes'];
$eventLinks = $data['eventLinks'];

// Open a connection to the SQLite database
$db = new PDO('sqlite:time.db');

// Delete the table "time" if it exists
$db->exec('DROP TABLE IF EXISTS time');

// Create a new table "time"
$db->exec('CREATE TABLE time (eventname TEXT, starttime TEXT, endtime TEXT, eventtype TEXT, eventlink TEXT)');

$insertStmt = $db->prepare('INSERT INTO time (eventname, starttime, endtime, eventtype, eventlink) VALUES (:eventname, :starttime, :endtime, :eventtype, :eventlink)');

// loop through the arrays and insert the data into the database
for ($i = 0; $i < count($eventNames); $i++) {
    $insertStmt->execute(array(
        ':eventname' => $eventNames[$i],
        ':starttime' => $startTimes[$i],
        ':endtime' => $endTimes[$i],
        ':eventtype' => $eventTypes[$i],
        ':eventlink' => $eventLinks[$i]
    ));
}

// Close the database connection
$db = null;

echo "Data inserted into the database.";
header("location: index.php");
?>
