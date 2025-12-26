<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    // Các trường cho phép nhập liệu
    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'parent_phone',
        'class_id'
    ];

    /**
     * Mỗi sinh viên thuộc về một lớp học cụ thể
     */
    public function class()
    {
        // Sử dụng belongsTo để thiết lập quan hệ ngược lại với ClassModel
        return $this->belongsTo(ClassModel::class, 'class_id', 'id');
    }
}
