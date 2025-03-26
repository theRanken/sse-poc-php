<?php

use Ranken\Streamer\ServerSentEvents;

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/lib/functions.php';

$app = new Leaf\App();

$app->template()->config('path', './views');

/**
 * 
 * Load Api Routes
 */
require __DIR__ . '/routes/api.php';

/**
 * 
 * Load Web Routes
 */
require __DIR__ . '/routes/web.php';


// Start App Instance
$app->run();
