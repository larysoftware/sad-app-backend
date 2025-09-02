<?php

use Illuminate\Support\Facades\Route;
use App\HomePage\View\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);
