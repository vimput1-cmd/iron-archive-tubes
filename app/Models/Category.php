<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    // Relasi: Satu Kategori punya BANYAK Kendaraan
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}