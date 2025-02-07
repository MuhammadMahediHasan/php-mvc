<?php

use App\Controllers\BuyerController;
use App\Controllers\HomeController;

const ROUTES = [
    '/' => [
        'GET' => [HomeController::class, 'index'],
    ],
    '/home' => [
        'GET' => [HomeController::class, 'index'],
    ],
    '/buyer-transactions' => [
        'GET' => [BuyerController::class, 'index'],
    ],
    '/buyer-transactions/create' => [
        'GET' => [BuyerController::class, 'create'],
    ],
    '/buyer-transactions/store' => [
        'POST' => [BuyerController::class, 'store'],
    ],
    '/buyer-transactions/report' => [
        'GET' => [BuyerController::class, 'report'],
    ],
    '/buyer-transactions/load' => [
        'GET' => [BuyerController::class, 'load'],
    ],
];
