<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    // Các trường có thể nhập dữ liệu vào 
    protected $fillable = [
        'name',
        'location',
        'manager'
    ];

    /**
     * Thiết lập quan hệ 1:N với bảng Employees 
     * Một phòng ban có nhiều nhân viên.
     */
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
