<?php

require __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/lib/functions.php';
require_once __DIR__ . '/lib/dummy-data.php';

app()->template()->config('path', './views');


app()->get('/', function () {
    response()->render('index');
});

app()->get('/events', function () {
    Leaf\Http\Headers::set([
        'Content-Type' => 'text/event-stream',
        'Cache-Control' => 'no-cache',
        'Connection' => 'keep-alive'
    ]);

    $numEvents = $_GET['numEvents'] ?? 10;
    $interval = $_GET['interval'] ?? 1;
    $timeout = $_GET['timeout'] ?? 10;

    if (!is_numeric($numEvents) || !is_numeric($interval) || !is_numeric($timeout)) {
        response()->json(['error' => 'Invalid parameters']);
        return;
    }

    $numEvents = (int) $numEvents;
    $interval = (int) $interval;
    $timeout = (int) $timeout;

    generateData($numEvents, $interval, $timeout);


});

app()->run();
