<?php

ob_end_flush(); // Ensure nothing is buffered
ini_set('output_buffering', 'off');
ini_set('zlib.output_compression', 'off');
ignore_user_abort(true);


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
