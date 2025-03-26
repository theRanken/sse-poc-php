<?php

use Leaf\Router;
use App\Controllers\HomepageController;


// Homepage Route
Router::get('/', fn() => response()->render('index'));