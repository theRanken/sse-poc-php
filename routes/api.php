<?php

use Leaf\Router;


Router::group("api", function () {
    Router::get("/events", "EventsController@getEvents");
});