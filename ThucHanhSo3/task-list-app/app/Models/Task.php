<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Dòng này là quan trọng
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory; // Dòng này là quan trọng

    // Thêm $fillable hoặc $guarded nếu cần thiết để Mass Assignment
    protected $fillable = [
        'title',
        'description',
        'long_description',
        'completed',
    ];
}
