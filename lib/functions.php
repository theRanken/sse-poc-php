<?php

require_once __DIR__ . '/dummy-data.php';

// Function to send an SSE message
function sendMessage($message, $event = null) {
    if ($event !== null) {
        echo "event: $event\n";
    }
    echo "data: " . json_encode($message) . "\n\n";
    ob_flush();
    flush();
}

// Simulate a data stream with configurable parameters
function generateData($numEvents = 100, $timeout = null, $interval = 2) {
    global $dadJokes, $events;
    $counter = 0;
    $startTime = time();

    while ($counter < $numEvents) {
        // Check timeout if set
        if ($timeout !== null && (time() - $startTime) >= $timeout) {
            break;
        }

        // Get random joke and event
        $randomJoke = $dadJokes[array_rand($dadJokes)];
        $eventTypes = array_keys($events);
        $randomEventType = $eventTypes[array_rand($eventTypes)];
        
        // Prepare data payload
        $data = [
            'joke' => $randomJoke,
            'event' => $events[$randomEventType]
        ];
        
        // Send event
        sendMessage($data, $events[$randomEventType]);

        // Sleep for specified interval
        sleep($interval);
        
        $counter++;
    }
}
