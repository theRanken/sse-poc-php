<?php

namespace App\Services;

use Ranken\Streamer\ServerSentEvents;

class EventService
{
    public function getEvents()
    {

        $numEvents = $_GET['numEvents'] ?? null;
        $interval = $_GET['interval'] ?? null;
        $timeout = $_GET['timeout'] ?? null;

        $numEvents = is_numeric($numEvents) ? (int) $numEvents : null;
        $interval = is_numeric($numEvents) ? (int) $interval : 1;
        $timeout = is_numeric($numEvents) ? (int) ($timeout / 1000) : 60;

        $dadJokes = require_once __DIR__ . '/../../lib/jokes.php';
        $events = require_once __DIR__ . '/../../lib/events.php';
        $counter = 0;
        $startTime = time();


        // Get random joke and event
        $randomJoke = $dadJokes[array_rand($dadJokes)];
        $eventTypes = array_keys($events);
        $randomEventType = $eventTypes[array_rand($eventTypes)];


        // Prepare data payload
        $data = [
            'joke' => $randomJoke,
            'event' => $events[$randomEventType],
        ];

        while ((time() - $startTime < $timeout / 1000) && 
        ($numEvents <= 0 || $counter < $numEvents)) {

            if ($numEvents && $counter >= $numEvents) {
                break;
            }

            if ($timeout && time() - $startTime >= $timeout) {
                break;
            }

            ServerSentEvents::send($data, 'message', uniqid());
            $counter++;

            sleep($interval);
        }
    }
}

