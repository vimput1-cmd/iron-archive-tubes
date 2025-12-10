<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'nation_id', 'category_id', 'name', 'image', 'model_file',
        'production_year', 'quantity', 'battles', 'description'
    ];

    public function nation() { return $this->belongsTo(Nation::class); }
    public function category() { return $this->belongsTo(Category::class); }
}