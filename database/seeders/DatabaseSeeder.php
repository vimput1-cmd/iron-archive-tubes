<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Nation;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Nation::create(['name' => 'Nazi Germany']);
        Nation::create(['name' => 'Soviet Union (USSR)']);
        Nation::create(['name' => 'United States (USA)']);
        Nation::create(['name' => 'Empire of Japan']);
        
        Category::create(['name' => 'Heavy Tank']);
        Category::create(['name' => 'Medium Tank']);
        Category::create(['name' => 'Fighter Aircraft']);
        Category::create(['name' => 'Bomber']);
    }
}