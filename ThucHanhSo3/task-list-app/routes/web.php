<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// Khi vào http://localhost → tự động vào trang index của tasks
Route::get('/', function () {
    return redirect()->route('tasks.index');
});

Route::resource('tasks', TaskController::class);
