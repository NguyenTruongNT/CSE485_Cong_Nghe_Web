<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    /** @use HasFactory<\Database\Factories\MedicineFactory> */
    use HasFactory;

    protected $primaryKey = 'medicine_id'; // Khai báo khóa chính là medicine_id
    public $incrementing = true;           // Xác nhận nó tự tăng
    protected $fillable = ['name', 'brand', 'dosage', 'form', 'price', 'stock'];

    public function sales()
    {
        // Một thuốc có nhiều lượt bán
        return $this->hasMany(Sale::class, 'medicine_id', 'medicine_id');
    }
}
