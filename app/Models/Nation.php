<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nation extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi
    protected $fillable = ['name', 'flag'];

    // Relasi: Satu Negara punya BANYAK Kendaraan
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}