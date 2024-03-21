<?php

use App\Http\Controllers\LoginUserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', LoginUserController::class);
