<?php

use App\Controllers\BuyerController;
use App\Controllers\HomeController;

const ROUTES = [
    '/' => [HomeController::class, 'index'],
    '/home' => [HomeController::class, 'index'],
    '/buyer-transactions' => [BuyerController::class, 'index'],
    '/buyer-transactions/create' => [BuyerController::class, 'create'],
    '/buyer-transactions/load' => [BuyerController::class, 'load'],
    '/buyer-transactions/store' => [BuyerController::class, 'store'],
];
