<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;
    // Chỉ định tên bảng nếu tên file không khớp hoàn toàn (ClassModel -> classes)
    protected $table = 'classes';
    // Các trường cho phép nhập liệu
    protected $fillable = [
        'class_code',
        'class_name',
        'semester',
        'academic_year',
        'advisor'
    ];

    /**
     * Một lớp học có nhiều sinh viên
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'class_id', 'id');
    }
}
