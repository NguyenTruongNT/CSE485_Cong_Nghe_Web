<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory;

    protected $primaryKey = 'sale_id';
    protected $fillable = ['medicine_id', 'quantity', 'sale_date', 'customer_phone'];

    public function medicine()
    {
        // Một lượt bán chỉ thuộc về một loại thuốc
        return $this->belongsTo(Medicine::class, 'medicine_id', 'medicine_id');
    }
}
