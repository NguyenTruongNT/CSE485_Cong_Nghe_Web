<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Computer extends Model
{
    use HasFactory;

    protected $fillable = ['computer_name', 'model', 'operating_system', 'processor', 'memory', 'available'];

    // Một máy tính có thể có nhiều vấn đề báo cáo 
    public function issues()
    {
        return $this->hasMany(Issue::class, 'computer_id', 'id');
    }
}
