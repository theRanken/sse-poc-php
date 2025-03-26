<?php

namespace App\Controllers;

class HomepageController
{
    public function __invoke()
    {
        return response()->render('index');
    }
}