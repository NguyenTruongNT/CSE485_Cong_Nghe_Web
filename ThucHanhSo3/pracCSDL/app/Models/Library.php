<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    use HasFactory;

    // Khai báo các trường có thể nhập dữ liệu nhanh (Mass Assignment)
    protected $fillable = ['name', 'address', 'contact_number'];

    public function books()
    {
        return $this->hasMany(Book::class, 'library_id', 'id');
    }
}
