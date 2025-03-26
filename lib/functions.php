<?php

// Simulate a data stream with configurable parameters
function generateData($numEvents = 10, $timeout = 120, $interval = 3) {
    $dadJokes = require_once __DIR__ . '/jokes.php';
    $events = require_once __DIR__ . '/events.php';
    $counter = 0;
    $startTime = time();

    while (true) {
        // Check for timeout
        if ($timeout && (time() - $startTime) >= $timeout) {
            break;
        }

        // Check for max events
        if ($numEvents !== null && $counter >= $numEvents) {
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
        
       
        // Wait between events
        sleep($interval);

        // Check if connection is still open
        if (connection_aborted()) {
            break;
        }
    }
}
