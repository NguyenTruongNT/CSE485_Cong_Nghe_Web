<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Models\Student;

// Thay đổi route mặc định '/' để chuyển hướng hoặc gọi thẳng hàm index của EmployeeController
Route::get('/', [StudentController::class, 'index']);

// Giữ nguyên resource route cho các chức năng CRUD khác
Route::resource('students', StudentController::class);
