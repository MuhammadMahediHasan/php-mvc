<?php

use App\Controllers\HomeController;

const ROUTES = [
    '/'             => array(HomeController::class, 'index'),
    '/home'         => array(HomeController::class, 'index'),
];
