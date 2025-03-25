<?php

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/lib/functions.php';

app()->template()->config('path', './views');


app()->get('/', function () {
    response()->render('index');
});

app()->get('/events', function () {
    try{

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
        $interval = (int) $interval/1000;
        $timeout = (int) $timeout/1000;

        generateData($numEvents, $interval, $timeout);

    }catch(\Exception $e){
        response()->json([
            'message' => 'Event Stream Failure',
            'error' => $e->getMessage(),
            'code' => $e->getCode(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
            'success' => false
        ]);
    }
});

app()->run();
