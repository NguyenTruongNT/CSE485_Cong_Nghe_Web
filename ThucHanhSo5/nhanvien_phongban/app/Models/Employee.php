<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    // Các trường có thể nhập dữ liệu vào [cite: 11]
    protected $fillable = [
        'department_id',
        'name',
        'email',
        'phone',
        'position',
        'salary'
    ];

    /**
     * Thiết lập quan hệ N:1 với bảng Departments [cite: 14]
     * Mỗi nhân viên thuộc về một phòng ban cụ thể.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
