<?php

use Leaf\Router;


Router::group("api", function () {
    Router::get("/events", "App\Controllers\EventsController@getEvents");
});