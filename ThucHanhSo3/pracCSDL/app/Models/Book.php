<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author', 'publication_year', 'genre', 'library_id'];

    // Mỗi cuốn sách thuộc về một thư viện cụ thể
    public function library()
    {
        return $this->belongsTo(Library::class, 'library_id', 'id');
    }
}
