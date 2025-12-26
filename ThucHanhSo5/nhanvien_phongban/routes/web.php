<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

// Thay đổi route mặc định '/' để chuyển hướng hoặc gọi thẳng hàm index của EmployeeController
Route::get('/', [EmployeeController::class, 'index']);

// Giữ nguyên resource route cho các chức năng CRUD khác
Route::resource('employees', EmployeeController::class);
