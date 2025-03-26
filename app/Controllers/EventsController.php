<?php

namespace App\Controllers;

use App\Services\EventService;


class EventsController
{
    protected $eventService;

    public function __construct(){
        $this->eventService = new EventService;
    }

    public function getEvents()
    {
        $this->eventService->getEvents();
    }
}