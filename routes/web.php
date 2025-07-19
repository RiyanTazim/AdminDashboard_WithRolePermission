<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Load tazim routes
require __DIR__ . '/tazim.php';

// Load auth routes (from Laravel Breeze or Jetstream)
require __DIR__ . '/auth.php';
