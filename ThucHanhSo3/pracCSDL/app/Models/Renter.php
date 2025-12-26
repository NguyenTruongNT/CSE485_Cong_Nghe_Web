<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renter extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'phone_number', 'email'];

    // Một người thuê có nhiều laptop
    public function laptops()
    {
        return $this->hasMany(Laptop::class, 'renter_id', 'id');
    }
}
