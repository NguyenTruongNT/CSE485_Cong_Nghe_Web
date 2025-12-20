<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;

    protected $fillable = ['computer_id', 'reported_by', 'reported_date', 'description', 'urgency', 'status'];

    // Định nghĩa mối quan hệ với bảng computers
    public function computer()
    {
        // Issue thuộc về Computer thông qua khóa ngoại computer_id 
        return $this->belongsTo(Computer::class, 'computer_id', 'id');
    }
}
