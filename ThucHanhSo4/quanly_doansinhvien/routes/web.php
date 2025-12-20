<?php

use App\Http\Controllers\IssueController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IssueController::class, 'index']);
// Đăng ký toàn bộ các đường dẫn CRUD cho Issues
Route::resource('issues', IssueController::class);
